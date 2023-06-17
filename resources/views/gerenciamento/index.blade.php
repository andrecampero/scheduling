@extends('layout.app')

@section('content')
	<style>
	
	tfoot {
		 display: table-header-group;
	}

	.table-responsive
	{
		overflow: hidden !important;
	}

	.dataTables_filter {
		display: none;
	}
	</style>

	<div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">{{ $title }}</h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{route('home')}}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>

	<div class="row">
		<div class="col-xs-12 col-md-3 col-sm-3 col-lg-3">
			<div class="m-portlet">
        		<div class="m-portlet__body" style="color:green; font-weight:600;">
					<p style="text-align:center; font-size: 1.2em;">Atendidos</p>
					<p style="text-align:center; font-size: 1.2em;">{{ $qtd_atendido[0]->qtd }}</p>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-md-3 col-sm-3 col-lg-3">
			<div class="m-portlet">
        		<div class="m-portlet__body" style="color:#dda258; font-weight:600;">
					<p style="text-align:center; font-size: 1.2em;">Agendados</p>
					<p style="text-align:center; font-size: 1.2em;">{{ $qtd_agendado[0]->qtd }}</p>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-md-3 col-sm-3 col-lg-3">
			<div class="m-portlet">
        		<div class="m-portlet__body" style="color:#5867dd; font-weight:600;">
					<p style="text-align:center; font-size: 1.2em;">Confirmados</p>
					<p style="text-align:center; font-size: 1.2em;">{{ $qtd_confirmado[0]->qtd }}</p>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-md-3 col-sm-3 col-lg-3">
			<div class="m-portlet">
        		<div class="m-portlet__body" style="color:#f01539; font-weight:600;">
					<p style="text-align:center; font-size: 1.2em;">Cancelados</p>
					<p style="text-align:center; font-size: 1.2em;">{{ $qtd_cancelado[0]->qtd }}</p>
				</div>
			</div>
		</div>
	</div>

    <div class="m-portlet">
        <div class="m-portlet__body">
            <table id="datatable" class="table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
					<tr>
						<th>Id</th>
						<th>Nome</th>
						<th>Serviços</th>
						<th>Agendamento</th>
						<th>Status</th>
						<th>Data Registro</th>
					</tr>
                </thead>
				<tfoot>
					<tr>
						<th>Id</th>
						<th>Nome</th>
						<th>Serviços</th>
						<th>Agendamento</th>
						<th>Status</th>
						<th>Data Registro</th>
					</tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
@push('scripts')
<script type="text/javascript" src="{{ URL::to('js/jquery-ui.min.js') }}"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script type="text/javascript" src="{{ URL::to('js/jquery.doubleScroll.js') }}"></script>
<script>

	//Datatable
	$('#datatable').DataTable({
		"autoWidth": false,
		"bLengthChange": false,
		pageLength: 10,
		dom: 'Bfrtip',
		buttons: [{
			extend: 'excelHtml5',
		}],
		"search": {
		"regex": true
		},
		destroy: true,
		"processing" : false,
		"paging": true,
		"searching": true,
		"ServerSide": true,
		"columnDefs":[
		   {"visible": false, "targets":0}
		],
		aaSorting: [[0, "desc"]],
		ajax: '{{route("get.gerenciamento")}}',
		columns: [
			{
				data: 'id',
				render: function (data) {
					if (data === undefined) {
						data = 'Indisponível';
					}
					return data;
				}
			},
			
			{
				data: 'nome',
				render: function ( data, type, row )
				{
					return '<p>'+ row.nome +'</p>';
				}
			},

			{
				data: 'servicos',
				render: function ( data, type, row )
				{
					return '<p>'+ row.servicos +'</p>';
				}
			},

			{
				data: 'data_agendamento',
				render: function ( data, type, row )
				{
					return '<p>'+ row.data_agendamento +'</p>';
				}
			},

			{
				data: 'status',
				render: function ( data, type, row )
				{
					let s_cor = "";
					switch(row.status)
					{
						case "Atendido":
							s_cor = "style='color:green; font-weight:600;'";
						break;							
						case "Confirmado":
							s_cor = "style='color:#5867dd; font-weight:600;'";
						break;							
						case "Agendado":
							s_cor = "style='color:#dda258; font-weight:600;'";
						break;							
						case "Cancelado":
							s_cor = "style='color:#f01539; font-weight:600;'";
						break;							
					}

					return '<p '+ s_cor +'>'+ row.status +'</p>';
				}
			},

			{
				data: 'data_registro',
				render: function ( data, type, row )
				{
					return '<p>'+ row.data_registro +'</p>';
				}
			}			
		],
		language: {
			"lengthMenu": "Mostrar _MENU_ registros por página",
			"zeroRecords": "...",
			"info": "Exibindo a página _PAGE_ de _PAGES_",
			"infoEmpty": "Sem registros disponíveis",
			"search": "Buscar",
			"processing": "Carregando..."
		},
		initComplete: function() {
		  var api = this.api();

		  // Apply the search
		  api.columns().every(function() {
			var that = this;

			$('input', this.footer()).on('keyup change', function() {
			  if (that.search() !== this.value) {
				that
				  .search(this.value)
				  .draw();
			  }
			});
		  });
		
		
			<!-- Div Scroll -->
			$('#datatable').wrap("<div id='scrooll_div' style='width: 100%;'></div>");
			$('#scrooll_div').doubleScroll();
		}

	});
		
		
	$('#datatable tfoot th').each(function() {
		var title = $(this).text();
		$(this).html('<input type="text" placeholder="Pesquisar ' + title + '" style="width:100%;"/>');
	});

		

$("#de").datetimepicker({
	language: 'pt-BR',
	minView: 2,
	format: 'dd/mm/yyyy',
	pickTime: false,
	autoclose: true,
	todayBtn: true,
	endDate: $('#date_today').val()
});

$("#ate").datetimepicker({
	language: 'pt-BR',
	minView: 2,
	format: 'dd/mm/yyyy',
	pickTime: false,
	autoclose: true,
	todayBtn: true,
	endDate: $('#date_today').val()
});


var submit_pdf = function(row_chave)
{
	console.log("in function: " + row_chave);
	$('form[name="form_submit_'+row_chave+'"]').submit();
}
</script>
@endpush
