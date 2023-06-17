@extends('layout.app')
@section('content')
    <!--begin::Portlet-->
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{$title or 'Protocolo Pré Impressão'}}
                    </h3>
                </div>
            </div>
        </div>
        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right ajax-form" method="post"
              action="{{route('save.unitary.protocol')}}">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            {{--<input type="hidden" name="geolocation" value="1">--}}
            <div class="m-portlet__body">
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-3 col-sm-12" for="track_malote">Código da Etiqueta <span
                                style="color:red;">*</span></label>
                    <div class="col-lg-7 col-md-7 col-sm-12 div_track">
                        <input type="text" class="form-control m-input" name="track_malote" id="track_malote" required>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-3 col-sm-12">Tipo de Documento </label>
                    <div class="col-lg-7 col-md-7 col-sm-12">
                        <select name="transporte" class="form-control m-input">
                            <optgroup label="Correios">
                                <option value="mercedes">Carta Registrada</option>
                                <option value="audi">Carta Simples</option>
                                <option value="audi">Mala Direta Postal</option>
                                <option value="audi">PAC</option>
                                <option value="audi">Revistas</option>
                                <option value="audi">Sedex Convencional</option>
                                <option value="audi">Sedex 10</option>
                                <option value="audi">Telegrama</option>
                            </optgroup>
                            <optgroup label="Jurídico">
                                <option value="audi">Carta Registrada</option>
                                <option value="audi">Envelope</option>
                                <option value="audi">Sedex</option>
                                <option value="audi">Telegrama</option>
                                <option value="audi">Protesto</option>
                            </optgroup>
                            <optgroup label="Malote">
                                <option value="audi">Malote Lacre</option>
                                <option value="audi">Vai e Vem</option>
                                <option value="audi">Envelope</option>
                                <option value="audi">Caixa</option>
                                <option value="audi">Andar para Andar</option>
                                <option value="audi">Saca Vermelha - CSC</option>
                                <option value="audi">Saca Verde - Ambulatório</option>
                                <option value="audi">Saca Azul - Braskem</option>
                            </optgroup>
                            <optgroup label="Mensageiro Externo">
                                <option value="audi">Caixas</option>
                                <option value="audi">DHL</option>
                                <option value="audi">EnvelopeS</option>
                                <option value="audi">FEDEX</option>
                                <option value="audi">Pacotes</option>
                                <option value="audi">Sacolas</option>
                                <option value="audi">TNT</option>
                                <option value="audi">UPS</option>
                            </optgroup>
                        </select>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-3 col-sm-12" for="chegada">Data de chegada <span
                                style="color:red;">*</span></label>
                    <div class="col-lg-7 col-md-7 col-sm-12">
                        <input type="text" id="chegada" class="form-control m-input" name="data_chegada" required>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-3 col-sm-12" for="remetente">De <span
                                style="color:red;">*</span></label>
                    <div class="col-lg-7 col-md-7 col-sm-12">
                        <input type="text" id="remetente" class="form-control m-input" name="remetente" required>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-3 col-sm-12">Local Origem <span
                                style="color:red;">*</span></label>
                    <div class="col-lg-7 col-md-7 col-sm-12">
                        <input type="text" class="form-control m-input" id="address" name="local_origem" required
                               onkeydown="getGeolocation(this.value, 'address')">
                    </div>
                    <div id="map"></div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-3 col-sm-12" for="destinatario">Para <span
                                style="color:red;">*</span></label>
                    <div class="col-lg-7 col-md-7 col-sm-12">
                        <input type="text" class="form-control m-input" id="destinatario" name="destinatario" required>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-3 col-sm-12">Local Destino <span
                                style="color:red;">*</span></label>
                    <div class="col-lg-7 col-md-7 col-sm-12">
                        <input type="text" class="form-control m-input"
                               onkeydown="getGeolocation(this.value, 'dest')" id="dest"
                               name="local_destino" required>
                    </div>
                    <div id="map"></div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-3 col-sm-12" for="andar">Andar <span
                                style="color:red;">*</span></label>
                    <div class="col-lg-7 col-md-7 col-sm-12">
                        <input type="text" class="form-control m-input" id="andar" name="andar" required>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-3 col-sm-12" for="baia">Baia/Complemento <span
                                style="color:red;">*</span></label>
                    <div class="col-lg-7 col-md-7 col-sm-12">
                        <input type="text" class="form-control m-input" id="baia" name="baia" required>
                    </div>
                </div>

            </div>
            <div class="form-group m-form__group row">
                <label class="col-form-label col-lg-3 col-sm-12">Código dos correios</label>
                <div class="col-lg-7 col-md-7 col-sm-12">
                    <input type="text" class="form-control m-input" name="correio">
                </div>
            </div>
            <div class="form-group m-form__group row">
                <label class="col-form-label col-lg-3 col-sm-12">Observações <span style="color:red;">*</span></label>
                <div class="col-lg-7 col-md-7 col-sm-12">
                    <input type="text" class="form-control m-input" name="obs" required/>
                </div>
            </div>
            <!-- FIM DESTINO -->

            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions m-form__actions">
                    <div class="row">
                        <div class="col-lg-9 ml-lg-auto">
                            <button type="submit" class="btn btn-brand">Cadastrar</button>
                            <button type="reset" class="btn btn-secondary">Cancelar</button>
                            <div class="lds-dual-ring m--margin-left-50 m--padding-top-20" style="display:none;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!--end::Form-->
    </div>
    <input type="hidden" id="my_lat">
    <input type="hidden" id="my_long">
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
                chegada: {
                    required: true
                },
                andar: {
                    required: true
                },
                baia: {
                    required: true
                },
                obs: {
                    required: true
                },
                local_destino: {
                    required: true
                },
                local_origem: {
                    required: true
                }

            },
            messages: {
                track_malote: {
                    required: "Este campo é obrigatório"
                },
                remetente: {
                    required: "Este campo é obrigatório"
                },
                destinatario: {
                    required: "Este campo é obrigatório"
                },
                chegada: {
                    required: "Este campo é obrigatório"
                },
                andar: {
                    required: "Este campo é obrigatório"
                },
                baia: {
                    required: "Este campo é obrigatório"
                },
                obs: {
                    required: "Este campo é obrigatório"
                },
                local_destino: {
                    required: "Este campo é obrigatório"
                },
                local_origem: {
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

        function dateToday() {
            var date = new Date();
            var month = date.getMonth();
            month = month.toString();
            if (month.length == 1) {
                month = parseInt(month);
                month = 1 + month;
                month = "0" + month;
            }
            today = date.getDate() + "-" + month + "-" + date.getFullYear() + " " + date.getHours() + ":" + date.getMinutes() + "0";
            return today
        }

        $("#chegada").datepicker({
            language: 'pt-BR',
            format: 'dd-mm-yyyy',
            autoclose: true,
            // startDate: dateToday()
        });
        $("#chegada").mask('00-00-0000');

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

    </script>
@endpush
