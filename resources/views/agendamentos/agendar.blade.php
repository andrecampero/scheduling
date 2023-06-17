@extends('layout.app')
@section('content')
    <!--begin::Portlet-->
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{ $title }}
                    </h3>
                </div>
            </div>
        </div>

        <form id="createform" class="m-form m-form--fit m-form--label-align-right ajax-form" method="post" action="{{route('agendamento.ins')}}">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            
			<div class="m-portlet__body">

				<div class="row" style="padding-left:1em; padding-right:1em;">
					<div class="col-xs-12 col-md-6 col-sm-6 col-lg-6" style="margin-bottom:1em;">
						<label for="id_usuario">Cliente</label>
						<select class="form-control m-input" id="id_usuario" name="id_usuario" style="width:100%">
							<?php 
							foreach($usuarios as $usuario_val)
							{
								?>
								<option value="<?php echo $usuario_val['id']; ?>"><?php echo $usuario_val['nome']; ?></option>
								<?php
							}
							?>
                        </select>
					</div>
					<div class="col-xs-12 col-md-6 col-sm-6 col-lg-6" style="margin-bottom:1em;">
						<label for="cliente">Serviços</label>
						<select class="form-control m-input" id="servicos" name="servicos[]" style="width:100%" multiple="multiple">
							<?php 
							foreach($servicos as $servico_val)
							{
								?>
								<option value="<?php echo $servico_val['id']; ?>"><?php echo $servico_val['servico']; ?></option>
								<?php
							}
							?>
                        </select>
					</div>
					<div class="col-xs-12 col-md-6 col-sm-6 col-lg-6">
						<label for="data_agendamento">Data Agendamento</label>
						<input type="text" id="data_agendamento" name="data_agendamento" style="width:100%; padding: 0.5em;" class="form-control m-input data" autocomplete="off" required="" maxlength="10">
					</div>
					<div class="col-xs-12 col-md-6 col-sm-6 col-lg-6">
						<label for="hora_agendamento">Horário Agendamento (hs) - Entre 08 às 17hs</label>
						<input type="number" id="hora_agendamento" name="hora_agendamento" class="form-control m-input" required="" value="" min="8" max="17" aria-invalid="false">
					</div>
				</div>
			</div>

			<div class="row" style="padding-bottom: 4em;">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-right">
					<!--<div onclick="action_submit()" class="btn btn-brand">Cadastrar</div>-->
					<div style="float:right; position: relative; top: 1em; right: 1em;">
						<button type="submit" class="btn btn-primary">Agendar</button>
						<button type="reset" class="btn btn-secondary">Cancelar</button>
					</div>
				</div>
			</div>
		</form>

        <!--end::Form-->
    </div>
    <!--end::Portlet-->
@endsection
@push('scripts')
<script>
	$(document).ready(function() {
		$('#id_usuario').select2({ placeholder: "Selecione..." });
		$('#servicos').select2({ placeholder: "Selecione..." });

		var dateToday = new Date();
		$("#data_agendamento").datetimepicker({
			language: 'pt-BR',
			minView: 2,
			format: 'dd/mm/yyyy',
			pickTime: false,
			autoclose: true,
			todayBtn: true,
			startDate: dateToday,
		});
		
	});

	

	// realiza a validação do formulário
	// $(".btn-brand").prop('disabled', true);
	const form = $(".ajax-form");
	$(form).validate({
		rules: {
			track_malote: {
				required: true
			},
			remetente: {
				required: true
			},
			destinatario: {
				required: true
			},
			baia: {
				required: true
			},
			obs: {
				required: true
			},
			cod_barra: {
				required: true
			},
		},
		messages: {
			remetente: {
				required: "Este campo é obrigatório"
			},
			track_malote: {
				required: "Este campo é obrigatório"
			},
			destinatario: {
				required: "Este campo é obrigatório"
			},
			baia: {
				required: "Este campo é obrigatório"
			},
			obs: {
				required: "Este campo é obrigatório"
			},
			cod_barra: {
				required: "Este campo é obrigatório"
			}
		},
		highlight: function (element) {
			$(element).parent().addClass('error')
		},
		unhighlight: function (element) {
			$(element).parent().removeClass('error')
		}
	});
	
	// habilita ou desabilita o botão de enviar formulário conforme validação
	$('input').on('blur', function () {
		if ($(form).valid()) {
			$(".btn-brand").prop('disabled', false);
		} else {
			// $(".btn-brand").prop('disabled', true);
		}
	});
	
	$('.cod_barra').keydown(function (e) {
		if (e.key == 'Enter') {
			//key primeiro campo
			$('#add_phone').trigger('click');
		}
	});

	function checkIfArrayIsUnique(arr) {
		var map = {}, i, size;

		for (i = 0, size = arr.length; i < size; i++){
			if (map[arr[i]]){
				return false;
			}

			map[arr[i]] = true;
		}

		return true;
	}

	var validaDupCodBarras = function()
	{
		// Define cod_barras[]
		var cod_barra_all = $('input[name="cod_barra[]"]').map(function(){return $(this).val();}).get();

		// remove null ou vazio
		var cod_barra_all_filtered = cod_barra_all.filter(function(n){return n; });

		if(!this.checkIfArrayIsUnique(cod_barra_all_filtered))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	$('#add_phone').click(function () {

		// atualiza qtd cod barras - Qtd Cod Barras
		var count_cod_barras = $(".cod_barra").length;
		$("#qtd_cod_barras").text(count_cod_barras + 1);

		var wrapper = $(".input_fields_value"); //Fields wrapper
		var ref = $('#ids');
		var id = parseInt(ref.val()) + 1;
		ref.val(id);
		$(wrapper).append(
			'<div class="form-group m-form__group row remove">' +
			'<label class="col-form-label col-lg-3 col-sm-12">Código de Barras</label>' +
			'<div class="col-lg-7 col-md-7 col-sm-12">' +
			'<input type="text" class="form-control m-input cod_barra" maxlength="80" name="cod_barra[]" multiple  required id=' + id + '>' +
			'</div>' +
			'<div class="input-group-append" style="height: 3em;">' +
			'<button id="add_phone" data-toggle="tooltip" data-placement="top" title="Excluir Campo"' +
			'class="btn btn-danger remove_field"' +
			'type="button">' +
			'<i class="fa fa-times"></i>' +
			'</button>' +
			'</div>' +
			'</div>').hide().show();
		$(wrapper).on("click", ".remove_field", function (e) { //user click on remove text

			// atualiza qtd cod barras - Qtd Cod Barras
			var count_cod_barras = $(".cod_barra").length;
			$("#qtd_cod_barras").text(count_cod_barras);

			e.preventDefault();
			$(this).closest('.remove').remove();

		});
		$('#' + id + '').focus();
		$('.cod_barra').keydown(function (e) {
			if (e.key == 'Enter') {
				// key, demais campos
				var cod_barra_all = $('input[name="cod_barra[]"]').map(function(){return $(this).val();}).get();

				// remove null ou vazio
				var cod_barra_all_filtered = cod_barra_all.filter(function(n){return n; });


				var recipientsArray = cod_barra_all_filtered.sort();

				var reportRecipientsDuplicate = [];
				var is_dup = 0;
				for (var i = 0; i < recipientsArray.length - 1; i++) {
					console.log(recipientsArray[i]);
					console.log(recipientsArray[i + 1]);
					console.log('--');
					if (recipientsArray[i + 1] == recipientsArray[i]) {
						reportRecipientsDuplicate.push(recipientsArray[i]);
						this.is_dup = 1;
					}
				}

				if(this.is_dup == 1)
				{
					alert('Item em Duplicidade / Nulo');
					this.is_dup = 0;
				}
				else
				{
					$('#add_phone').trigger('click');
				}

			}
		});
	});

	function func_timeout() {
		var content_text = $('#swal2-title').text();
		if(content_text == "Sucesso!")
		{
			$('.btn-success').click(function(){
				document.location.reload(true);
			});
		}
	}

	function isValidEmailAddress(emailAddress) {
		var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
		return pattern.test(emailAddress);
	}

	var count_submit = 0;
	function action_submit()
	{
		// Def Cod Barras
		var cod_barra_primeiro_val = $('input[name="cod_barra[]"]').val();

		// Tipo Serviço
		var tipo_servico_val = $('#tipo_servico option:selected').val();
		var quantidade_cartas_simples_val = $('#quantidade_cartas_simples').val();
		if(tipo_servico_val == "Carta Simples")
		{
			if(quantidade_cartas_simples_val == "")
			{
				alert("Preencha corretamente o campo Quantidade (Para Carta Simples).");
				return;
			}
		}

		//Def Qtd
		if(cod_barra_primeiro_val != "")
		{
			// Define cod_barras[]
			var cod_barra_all = $('input[name="cod_barra[]"]').map(function(){return $(this).val();}).get();

			// remove null ou vazio
			var cod_barra_all_filtered = cod_barra_all.filter(function(n){return n; });

			// rm dup
			var cod_barra_all_filtered_wd = cod_barra_all_filtered.filter(function(elem, index, self) {
					 return index === self.indexOf(elem);
				});

			// Set cod_barra_filtered hidden input
			$('input[name="cod_barra_filtered[]"]').val(cod_barra_all_filtered_wd);

			//Qtd Cod Barras
			var count_cod_barras = cod_barra_all_filtered_wd.length;
			$('#track_cartas_qtd').val(count_cod_barras);
		}
		else
		{
			if(tipo_servico_val == "Carta Simples")
			{
				// Define cod_barras[]
				var cod_barra_all = $('input[name="cod_barra[]"]').map(function(){return $(this).val();}).get();

				// remove null ou vazio
				var cod_barra_all_filtered = cod_barra_all.filter(function(n){return n; });

				// rm dup
				var cod_barra_all_filtered_wd = cod_barra_all_filtered.filter(function(elem, index, self) {
					  return index === self.indexOf(elem);
				  });

				// Set cod_barra_filtered hidden input
				$('input[name="cod_barra_filtered[]"]').val(cod_barra_all_filtered_wd);

				// Qtd Cod Barras
				var count_cod_barras = 0;
				$('#track_cartas_qtd').val(count_cod_barras);
			}
			else
			{
				alert("Preencha corretamente o campo Código de Barras.");
				return;
			}
		}

		if(cod_barra_primeiro_val != "" || tipo_servico_val == "Carta Simples")
		{

			var cod_barra_all = $('input[name="cod_barra[]"]').map(function(){return $(this).val();}).get();

			// remove null ou vazio
			var cod_barra_all_filtered = cod_barra_all.filter(function(n){return n; });


			var recipientsArray = cod_barra_all_filtered.sort();

			var reportRecipientsDuplicate = [];
			var is_dup_inst = 0;
			for (var i = 0; i < recipientsArray.length - 1; i++) {
					console.log(recipientsArray[i]);
					console.log(recipientsArray[i + 1]);
					console.log('--');
					if (recipientsArray[i + 1] == recipientsArray[i]) {
						reportRecipientsDuplicate.push(recipientsArray[i]);
						this.is_dup_inst = 1;
					}
			}


			if(this.is_dup_inst == 1)
			{
				alert('Item em Duplicidade / Nulo');
				this.is_dup_inst = 0;
			}
			else
			{
				$("#createform").submit();
				setTimeout(func_timeout, 500);
			}


		}
		else
		{
			alert("Preencha corretamente o campo Código de Barras.");
			return;
		}

	}
</script>
@endpush
