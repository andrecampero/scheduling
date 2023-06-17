<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ScAgendamentos;
use App\Models\ScAgendamentosServicos;
use App\Models\ScServicos;
use App\Models\ScUsuarios;
use Auth;
use App\Models\ScPerfil;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;


class AgendamentosController extends Controller
{
    private $protocol;

    public function __construct(ScAgendamentos $sc_agendamentos)
    {
    	$this->sc_agendamentos = $sc_agendamentos;
    }

    public function index()
    {
        $title = "Agendamentos";

        return view('agendamentos.index', compact('title'));
    }

    public function agendar()
    {
        $title = "Agendar";

		$perfil = ScPerfil::where('id', Auth::user()->id_perfil)->first();
		if($perfil->admin == 1)
		{
			$usuarios = ScUsuarios::where('id_perfil', '<>', 1)->orderby('nome', 'ASC')->get();
		}
		else
		{
			$usuarios = ScUsuarios::where('id', Auth::user()->id)->get();
		}
		
		$servicos = ScServicos::orderby('servico', 'ASC')->get();

        return view('agendamentos.agendar', compact('title', 'perfil', 'usuarios', 'servicos'));
    }

	public function alterar($id)
    {
        $title = "Alterar Agendamento";

		$agendamento = $this->sc_agendamentos->find($id);
		
		$servicos_ag = DB::select( DB::raw("
			SELECT GROUP_CONCAT(ss.id) ids_servicos FROM sc_agendamentos_servicos sss
			LEFT JOIN sc_servicos ss
			ON ss.id = sss.id_servicos
			WHERE sss.id_agendamento = $agendamento->id
		"));

		$perfil = ScPerfil::where('id', Auth::user()->id_perfil)->first();
		if($perfil->admin == 1)
		{
			$usuarios = ScUsuarios::where('id_perfil', '<>', 1)->orderby('nome', 'ASC')->get();
		}
		else
		{
			$usuarios = ScUsuarios::where('id', Auth::user()->id)->get();
		}
		
		$servicos = ScServicos::orderby('servico', 'ASC')->get();

        return view('agendamentos.alterar', compact('title', 'agendamento', 'perfil', 'usuarios', 'servicos', 'servicos_ag'));
    }

	public function getAgendamentos()
    {
        $id_usuario = Auth::user()->id;
		$perfil = ScPerfil::where('id', Auth::user()->id_perfil)->first();
		
		$perfil_relacionado = "";
		if ($perfil->relacionado) {
			$perfil_relacionado = " and sa.id_usuario = $id_usuario ";
		}
		
		$res = DB::select( DB::raw("
			SELECT 
				sa.id,
				su.nome,
				GROUP_CONCAT(ss.servico SEPARATOR ', ') AS servicos,
				CONCAT_WS(' ', DATE_FORMAT(sa.data_agendamento, '%d/%m/%Y'), sa.hora_agendamento) AS data_agendamento,
				sa.status,
				DATE_FORMAT(sa.data_registro, '%d/%m/%Y %H:%i:%s') AS data_registro,
				IF(sa.data_agendamento >= DATE_ADD(CURDATE(), INTERVAL 2 DAY), 1, 0) AS p_alt,
				(
					IF
					((SELECT COUNT(1) FROM sc_agendamentos ssa 
						LEFT JOIN sc_usuarios ssu 
						ON ssu.id = ssa.id_usuario 
						WHERE YEARWEEK(ssa.data_agendamento, 1) = YEARWEEK(sa.data_agendamento, 1)
						AND ssa.id_usuario = su.id
						AND ssa.status IN ('Agendado')
						LIMIT 1) > 1,
						'Sugerir atendimento único na semana',
					'')
				) AS sugerir_unir_ag
			FROM sc_agendamentos sa
			
			LEFT JOIN sc_agendamentos_servicos sas
			ON sas.id_agendamento = sa.id
			
			LEFT JOIN sc_servicos ss
			ON ss.id = sas.id_servicos
			
			LEFT JOIN sc_usuarios  su
			ON su.id = sa.id_usuario
			
			WHERE 1 = 1
				$perfil_relacionado
			GROUP BY su.nome, sa.data_agendamento
			ORDER BY sa.id DESC
			limit 2500
		"));
		
        return Datatables::of($res)
            ->addColumn('action', function ($res) {

				$btn_alt = '';
				
				if ($res->status != 'Atendido' &&  $res->status != 'Cancelado')
				{
					// Valida se agendamento é maior que 2 dias do dia atual
					if($res->p_alt == 1)
					{
						$btn_alt = '<a style="margin-left: 1em;" href="' . route('agendamentos.alterar', array('id' => $res->id)) . '"  class="btn btn-xs btn-primary" id="edit-data"><i class="fa flaticon-edit"></i></a>';
						//$btn_alt = $data_agendamento_us;
					}
				}

                return $btn_alt;

            })->make(true);
    }

    public function AgendamentoIns(Request $request)
    {
        $id_usuario = Auth::user()->id;
		$perfil = ScPerfil::where('id', Auth::user()->id_perfil)->first();

		$data = $request->except(['_token']);
        $dados = $request->all();
        $fields = new Request($data);
        $this->validate($fields, $this->sc_agendamentos->rulesLot, $this->sc_agendamentos->messages);

		if($perfil->admin == 0)
		{
			$dados['id_usaurio'] = Auth::user()->id;
		}
        
		$dados['data_agendamento'] = Carbon::createFromFormat('d/m/Y', $dados['data_agendamento'])->format('Y-m-d');
		$dados['hora_agendamento'] = $dados['hora_agendamento'].":00:00";
		$c_ok = 1;
		$ins_ag = ScAgendamentos::create($dados);
		if (!$ins_ag)
		{
			$c_ok = 0;
        }
		else
		{
			// Ins Serviços
			foreach($dados['servicos'] as $servicos_val)
			{
				$servicos_agendamento = [
					'id_agendamento' => $ins_ag->id,
					'id_servicos' => $servicos_val
				];

				$ins_ag_s = ScAgendamentosServicos::create($servicos_agendamento);
				if (!$ins_ag_s) 
				{
					$c_ok = 0;
				}
			}
		}

		if($c_ok == 0)
		{
			return response()->json(["result" => false, "message" => "Algo errado aconteceu, tente novamente mais tarde "]);
		}
		else
		{
			return response()->json(["result" => true, "message" => "Agendamento cadastrado com sucesso!"]);
		}
	}

	public function AgendamentoUpd(Request $request)
    {
        $id_usuario = Auth::user()->id;
		$perfil = ScPerfil::where('id', Auth::user()->id_perfil)->first();

		$data = $request->except(['_token']);
        $dados = $request->all();
        $fields = new Request($data);
        $this->validate($fields, $this->sc_agendamentos->rulesLot, $this->sc_agendamentos->messages);

		if($perfil->admin == 0)
		{
			$dados['id_usaurio'] = Auth::user()->id;
		}
        
		$dados['data_agendamento'] = Carbon::createFromFormat('d/m/Y', $dados['data_agendamento'])->format('Y-m-d');
		$dados['hora_agendamento'] = $dados['hora_agendamento'].":00:00";
		
		
		$dados_upd_ag = $dados;
		unset($dados_upd_ag['_token']);
		unset($dados_upd_ag['id_agendamento']);
		unset($dados_upd_ag['servicos']);

		$c_ok = 1;
		$upd_ag = ScAgendamentos::where('id',$dados['id_agendamento'])->update($dados_upd_ag);
		if (!$upd_ag)
		{
			$c_ok = 0;
        }
		else
		{
			// Rm
			ScAgendamentosServicos::where('id_agendamento', $dados['id_agendamento'])->delete();

			// Ins Serviços
			foreach($dados['servicos'] as $servicos_val)
			{
				$servicos_agendamento = [
					'id_agendamento' => $dados['id_agendamento'],
					'id_servicos' => $servicos_val
				];

				$upd_ag_s = ScAgendamentosServicos::create($servicos_agendamento);
				if (!$upd_ag_s) 
				{
					$c_ok = 0;
				}
			}
		}

		if($c_ok == 0)
		{
			return response()->json(["result" => false, "message" => "Algo errado aconteceu, tente novamente mais tarde "]);
		}
		else
		{
			return response()->json(["result" => true, "message" => "Agendamento alterado com sucesso!"]);
		}
	}

    public function cancelProtocol(Request $request)
    {
        $data = $request->only(['id']);
        $registry = TbTrack::where('chave', $data['id'])->first();
        $registry->status = 'Cancelado';
        $registry->update();
        //$registry->delete();

        if (!$registry) {
            return response()->json(["result" => false]);
        }

        return response()->json(["result" => true]);
    }


}
