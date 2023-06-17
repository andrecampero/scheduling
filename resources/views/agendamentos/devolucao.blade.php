@extends('layout.app')
@section('content')
    <!--begin::Portlet-->
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        <!--{{$title or 'Lote Pré Impressão'}}-->
                        {{$title or 'Devolução'}}
                    </h3>
                </div>
            </div>
        </div>
        <!--begin::Form-->
        <form id="devolverform" class="m-form m-form--fit m-form--label-align-right ajax-form" method="post"
              action="{{route('savedevolucao.protocol')}}" onkeypress="return event.keyCode != 13;">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            {{--<input type="hidden" name="geolocation" value="1">--}}
            <div class="m-portlet__body">
                
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-3 col-sm-12">Tracking <span
                                style="color:red;">*</span></label>
                    <div class="col-lg-7 col-md-7 col-sm-12 div_track">
                        <input type="text" class="form-control m-input" id="tracking" name="tracking" required>
                    </div>
                </div>
                

                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-3 col-sm-12">Observação <span
                                style="color:red;">*</span></label>
                    <div class="col-lg-7 col-md-7 col-sm-12">
                        <input type="text" class="form-control m-input" name="obs" required>
                    </div>
                </div>

            </div>


            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions m-form__actions">
                    <div class="row">
                        <div class="col-lg-9 ml-lg-auto">
                            <button onclick="action_submit()" class="btn btn-brand">Cadastrar</button>
                            <button type="reset" class="btn btn-secondary">Cancelar</button>
                            <div class="lds-dual-ring m--margin-left-50 m--padding-top-20"
                                 style="display:none;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <input type="hidden" id="my_lat">
        <input type="hidden" id="my_long">
        <!--end::Form-->
    </div>
    <!--end::Portlet-->
@endsection
@push('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAoIuUqdY9XgBaZ_wPwqanNHor_xFHu-_4&libraries=places&callback=initMap"
            async defer></script>

    <script>
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
                local_origem: {
                    required: true
                },
                local_destino: {
                    required: true
                },
                andar: {
                    required: true
                },
                obs: {
                    required: true
                },
                cod_barra: {
                    required: true
                }

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
                local_origem: {
                    required: "Este campo é obrigatório"
                },
                local_destino: {
                    required: "Este campo é obrigatório"
                },
                baia: {
                    required: "Este campo é obrigatório"
                },
                andar: {
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
                $('#add_phone').trigger('click');
            }
        });
        $('#add_phone').click(function () {
            var wrapper = $(".input_fields_value"); //Fields wrapper
            var ref = $('#ids');
            var id = parseInt(ref.val()) + 1;
            ref.val(id);
            $(wrapper).append(
                '<div class="form-group m-form__group row remove">' +
                '<label class="col-form-label col-lg-3 col-sm-12">Código de Barras</label>' +
                '<div class="col-lg-7 col-md-7 col-sm-12">' +
                '<input type="text" class="form-control m-input cod_barra" maxlength="23" name="cod_barra[]" multiple  required id=' + id + '>' +
                '</div>' +
                '<div class="input-group-append">' +
                '<button id="add_phone" data-toggle="tooltip" data-placement="top" title="Excluir Campo"' +
                'class="btn btn-danger remove_field"' +
                'type="button">' +
                '<i class="fa fa-times"></i>' +
                '</button>' +
                '</div>' +
                '</div>').hide().show();
            $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
                e.preventDefault();
                $(this).closest('.remove').remove();
            });
            $('#' + id + '').focus();
            $('.cod_barra').keydown(function (e) {
                if (e.key == 'Enter') {
                    $('#add_phone').trigger('click');
                }
            });
        });

        function setCoors(data) {
            var keys = Object.keys(data);

            if (data.results.length > 0) {
                $("#latitude").val(data.results[0].geometry.location.lat);
                $("#longitude").val(data.results[0].geometry.location.lng);
            } else {
                alert("Invalid address");
            }
        }

        function initMap(id) {
            var my_lat = parseInt($('#my_lat').val());
            var my_long = parseInt($('#my_long').val());
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: my_lat, lng: my_long},
                zoom: 13
            });
            var input = /** @type {!HTMLInputElement} */(
                document.getElementById(id));

            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);

            var infowindow = new google.maps.InfoWindow();
            var marker = new google.maps.Marker({
                map: map,
                anchorPoint: new google.maps.Point(0, -29)
            });

            autocomplete.addListener('place_changed', function () {
                infowindow.close();
                marker.setVisible(false);

                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    // User entered the name of a Place that was not suggested and
                    // pressed the Enter key, or the Place Details request failed.
                    window.alert("No details available for input: '" + place.name + "'");
                    return;
                }
                // If the place has a geometry, then present it on a map.
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);  // Why 17? Because it looks good.
                }
                marker.setIcon(/** @type {google.maps.Icon} */({
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(35, 35)
                }));
                marker.setPosition(place.geometry.location);
                marker.setVisible(true);

                var address = '';
                if (place.address_components) {
                    address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');
                }

                infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
                infowindow.open(map, marker);
            });
        }

        function getGeolocation(val, id) {
            var address;
            initMap(id);
            address = val;
            if (address != '') {
                axios.get('https://maps.googleapis.com/maps/api/geocode/json', {
                    params: {
                        address: address,
                        key: 'AIzaSyAoIuUqdY9XgBaZ_wPwqanNHor_xFHu-_4'
                    }
                }).then(function (response) {
                    $('#lat').val(response.data.results[0].geometry.location.lat);
                    $('#long').val(response.data.results[0].geometry.location.lng);
                });
            }
        }

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                alert = "Geolocation is not supported by this browser.";
            }
        }


        function showPosition(position) {

            $("#my_lat").val(position.coords.latitude);
            $("#my_long").val(position.coords.longitude);
        }


        $(document).ready(function () {
            initMap();
            getLocation();
        });
		
		function func_timeout() {
			// your code to run after the timeout
			$(':input').not(':button, :submit, :reset, :hidden').removeAttr('checked').removeAttr('selected').not(':checkbox, select').val('').removeAttr('value');
		}

		function action_submit()
		{
			$("#devolverform").submit();
			
			// stop for sometime if needed
			setTimeout(func_timeout, 300);	
		}

    </script>
@endpush
