@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1 class="text-capitalize">Modifica {{$customer->stato == 'contattato' ? 'Contatto' : $customer->stato}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item text-capitalize"><a href="/list/{{ $customer->stato }}">{{$customer->stato == 'contattato' ? 'Contatto' : $customer->stato}}</a></li>
                <li class="breadcrumb-item active text-capitalize">Modifica {{$customer->stato == 'contattato' ? 'Contatto' : $customer->stato}}</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<style>
    .pac-container {
        z-index: 9999;
    }
</style>
<div class="container-fluid pt-3">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header text-capitalize">{{ __('Modifica') }} {{$customer->stato == 'contattato' ? 'Contatto' : $customer->stato}}</div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <ul class="mb-0 pl-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="col-md-12">
                        <form action="{{ route('clienti.update', $customer->id) }}" method="post">
                            @csrf
                            <!-- <input type="hidden" name="stato" value="{{$customer->stato}}"> -->
                            <input type="hidden" name="id_customer" id="id_customer" value="{{$customer->id}}">
                            <input type="hidden" name="require_company" value="{{$require_company}}">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="stato">{{ __('Stato') }}</label>
                                        <select id="stato" name="stato" class="form-control">
                                            <option></option>
                                            <option value="lead" {{ $customer->stato == 'lead' ? 'selected' : '' }}>lead</option>
                                            <option value="contattato" {{ $customer->stato == 'contattato' ? 'selected' : '' }}>contattato</option>
                                            {{--<option value="prospect" {{ $customer->stato == 'prospect' ? 'selected' : '' }}>prospect</option>
                                            <option value="cliente" {{ $customer->stato == 'cliente' ? 'selected' : '' }}>cliente</option>--}}
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nome">{{ __('Nome') }} *</label>
                                        <input type="text" class="form-control" id="nome" name="nome" value="{{ $customer->nome }}" placeholder="{{ __('Es: Paolo') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cognome">{{ __('Cognome') }} *</label>
                                        <input type="text" class="form-control" id="cognome" name="cognome" value="{{ $customer->cognome }}" placeholder="{{ __('Es: Rossi') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">{{ __('Indirizzo email primo contatto') }} *</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ $customer->email }}" placeholder="{{ __('Es: user@user.it') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="privato">{{ __('Tipo di customer') }} *</label>
                                        <select id="privato" name="privato" class="form-control" required>
                                            <option></option>
                                            <option value="privato" {{ $customer->privato == 1 ? 'selected' : '' }}>Privato</option>
                                            <option value="azienda" {{ !is_null($customer->privato) && $customer->privato == 0 ? 'selected' : '' }}>Azienda</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="email_aziendale">{{ __('Indirizzo email aziendale personale') }}</label>
                                        <input type="email" class="form-control" id="email_aziendale" name="email_aziendale" value="{{ $customer->email_aziendale }}" placeholder="{{ __('Es: user@user.it') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="telefono_ufficio">{{ __('Telefono ufficio') }}</label>
                                        <input type="text" class="form-control" id="telefono_ufficio" name="telefono_ufficio"value="{{ $customer->telefono_ufficio }}"  placeholder="{{ __('Es: +39 02484668') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="telefono_personale">{{ __('Telefono personale') }}</label>
                                        <input type="text" class="form-control" id="telefono_personale" name="telefono_personale" value="{{ $customer->telefono_personale }}" placeholder="{{ __('Es: +39 02484668') }}">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-8 {{ $customer->privato == 1 || is_null($customer->privato) ? 'd-none' : '' }}" data-azienda>
                                    <div class="form-group">
                                        <label for="company_id">{{ __('Azienda') }} *</label>
                                        <div class="input-group">
                                            <select id="company_id" name="company_id" class="form-control" {{ $customer->privato == 0 ? 'required' : '' }}>
                                                <option></option>
                                            </select>
                                            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#newCompany">Aggiungi</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email_aziendale_generica">{{ __('Indirizzo email aziendale generica') }}</label>
                                        <input type="email" class="form-control" id="email_aziendale_generica" name="email_aziendale_generica" value="{{ $customer->email_aziendale_generica }}" placeholder="{{ __('Es: user@user.it') }}">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ruolo_id">{{ __('Ruolo') }} *</label>
                                        <select id="ruolo_id" name="ruolo_id" class="form-control" required>
                                            <option></option>
                                            @foreach($ruoli as $i => $value)
                                            <optgroup label="{{$i}}">
                                                @foreach($value as $role)
                                                <option value="{{$role['id']}}" {{ $role['id'] == $customer->ruolo_id ? 'selected' : '' }}>{{$role['nome']}}</option>
                                                @endforeach
                                            </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sorgente_acquisizione">{{ __('Fonte') }} *</label>
                                        <select id="sorgente_acquisizione" name="sorgente_acquisizione" class="form-control" required>
                                            <option></option>
                                            <option value="social" {{ $customer->sorgente_acquisizione == 'social' ? 'selected' : '' }}>Social</option>
                                            <option value="sito" {{ $customer->sorgente_acquisizione == 'sito' ? 'selected' : '' }}>Sito</option>
                                            <option value="telefono" {{ $customer->sorgente_acquisizione == 'telefono' ? 'selected' : '' }}>Telefono</option>
                                            <option value="email" {{ $customer->sorgente_acquisizione == 'email' ? 'selected' : '' }}>Email</option>
                                            <option value="chiamata a freddo" {{ $customer->sorgente_acquisizione == 'chiamata a freddo' ? 'selected' : '' }}>Chiamata a freddo</option>
                                            <option value="campagna web" {{ $customer->sorgente_acquisizione == 'campagna web' ? 'selected' : '' }}>Campagna web</option>
                                            <option value="passaparola" {{ $customer->sorgente_acquisizione == 'passaparola' ? 'selected' : '' }}>Passaparola</option>
                                            <option value="dipendente" {{ $customer->sorgente_acquisizione == 'dipendente' ? 'selected' : '' }}>Dipendente</option>
                                            <option value="partner" {{ $customer->sorgente_acquisizione == 'partner' ? 'selected' : '' }}>Partner</option>
                                            <option value="evento online" {{ $customer->sorgente_acquisizione == 'evento online' ? 'selected' : '' }}>Evento online</option>
                                            <option value="convegno" {{ $customer->sorgente_acquisizione == 'convegno' ? 'selected' : '' }}>Convegno</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="user_id">{{ __('Responsabile contatto') }} *</label>
                                        <select id="user_id" name="user_id" class="form-control" required>
                                            <option></option>
                                            @foreach($users as $user)
                                            <option value="{{$user->id}}" {{ $user->id == $customer->user_id ? 'selected' : '' }}>{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="data_creazione_lead">{{ __('Data creazione') }}</label>
                                        <input type="date" class="form-control" id="data_creazione_lead" name="data_creazione_lead" value="{{ $customer->data_creazione_lead }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="stato_cliente">{{ __('Stato lead') }} *</label>
                                        <select id="stato_cliente" name="stato_cliente" class="form-control" required>
                                            <option></option>
                                            <option value="da_lavorare" {{ $customer->stato_cliente == 'da_lavorare' ? 'selected' : '' }}>{{__('Da Lavorare')}}</option>
                                            <option value="contattato" {{ $customer->stato_cliente == 'contattato' ? 'selected' : '' }}>{{__('Contattato')}}</option>
                                            <option value="da_ricontattare" {{ $customer->stato_cliente == 'da_ricontattare' ? 'selected' : '' }}>{{__('Da Ricontattare')}}</option>
                                            <option value="parking" {{ $customer->stato_cliente == 'parking' ? 'selected' : '' }}>{{__('Parking')}}</option>
                                            <option value="non_qualificato" {{ $customer->stato_cliente == 'non_qualificato' ? 'selected' : '' }}>{{__('Non Qualificato')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="service_id">{{ __('Servizi') }}</label>
                                    <select id="service_id" name="service_id" class="form-control">
                                        <option></option>
                                        @foreach ( $services as $service)
                                        <option value="{{ $service->id }}" {{ $customer->service_id ==  $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="noe">{{ __('Note') }}</label>
                                        <textarea name="note" id="note" class="form-control" rows="5">{{ $customer->note }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-float">{{ __('Aggiorna') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="newCompany" tabindex="-1" aria-labelledby="newCompanyLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newCompanyLabel">{{__('Aggiungi Azienda')}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="rag_soc">{{ __('Ragione Sociale') }}</label>
                <input type="text" class="form-control" id="rag_soc" name="rag_soc" placeholder="{{ __('Es: BigVision') }}">
            </div>
            <div class="form-group d-none" data-require-company>
                <label for="cod_fisc">{{ __('Codice Fiscale') }} <span class="text-danger">(se non disponibile copiare ed incollare la partita IVA)</span></label>
                <input type="text" maxlength="16" class="form-control" id="cod_fisc" name="cod_fisc" placeholder="{{ __('Es: YHTKIU89O08O896U') }}">
            </div>
            <div class="form-group d-none" data-require-company>
                <label for="phone">{{ __('Telefono') }}</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="{{ __('Es. +39 01232412') }}">
            </div>
            <div class="form-group d-none" data-require-company>
                <label for="user_id_company">{{ __('Assegnato a') }}</label>
                <select id="user_id_company" name="user_id_company" class="form-control modalSelect2">
                    <option></option>
                    @foreach ( $users as $user )
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="settore_id">{{ __('Settore') }}</label>
                <select id="settore_id" name="settore_id" class="form-control modalSelect2">
                    <option></option>
                    @foreach($settori as $settore)
                    <option value="{{$settore->id}}">{{$settore->nome}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group d-none" data-require-company>
                <label for="come_ci_ha_conosciuto">{{ __('Come ci ha conosciuto') }}</label>
                <select id="come_ci_ha_conosciuto" name="come_ci_ha_conosciuto" class="form-control modalSelect2">
                    <option></option>
                    <option value="social">Social</option>
                    <option value="sito">Sito</option>
                    <option value="telefono">Telefono</option>
                    <option value="email">Email</option>
                    <option value="chiamata a freddo">Chiamata a freddo</option>
                    <option value="campagna web">Campagna web</option>
                    <option value="passaparola">Passaparola</option>
                    <option value="dipendente">Dipendente</option>
                    <option value="partner">Partner</option>
                    <option value="evento online">Evento online</option>
                    <option value="convegno">Convegno</option>
                </select>
            </div>
            <div class="form-group d-none" data-require-company>
                <label for="data_contatto">{{ __('Data di primo contatto') }}</label>
                <input type="date" class="form-control" id="data_contatto" name="data_contatto">
            </div>
            <div class="form-group d-none" data-require-company style="z-index:99999999">
                <label for="autocomplete">{{ __('Inserisci indirizzo') }}</label>
                <input type="text" id="pac-input" class="form-control autocomplete">
            </div>
            <div class="form-group d-none" data-require-company>
                <label for="indirizzo_legale">{{ __('Indirizzo legale') }} *</label>
                <input type="text" value="{{ old('indirizzo_legale') }}" class="form-control" id="indirizzo_legale" name="indirizzo_legale" placeholder="{{ __('Es: Via piave 2') }}" data-map="route">
                <input type="hidden" id="street_number" data-map="street_number" value="">
            </div>
            <div class="form-group d-none" data-require-company>
                <label for="comune_legale">{{ __('Comune legale') }} *</label>
                <input type="text" value="{{ old('comune_legale') }}" class="form-control" id="comune_legale" name="comune_legale" placeholder="{{ __('Es: Milano') }}" data-map="locality">
            </div>
            <div class="form-group d-none" data-require-company>
                <label for="provincia_legale">{{ __('Provincia legale') }} *</label>
                <input type="text" value="{{ old('provincia_legale') }}" class="form-control" id="provincia_legale" name="provincia_legale" placeholder="{{ __('Es: Milano') }}" data-map="administrative_area_level_2">
            </div>
            <div class="form-group d-none" data-require-company>
                <label for="cap_legale">{{ __('CAP legale') }} *</label>
                <input type="text" value="{{ old('cap_legale') }}" class="form-control" id="cap_legale" name="cap_legale" placeholder="{{ __('Es: 20100') }}" data-map="postal_code">
            </div>
            <div class="form-group d-none" data-require-company>
                <label for="regione_legale">{{ __('Regione legale') }} *</label>
                <input type="text" value="{{ old('regione_legale') }}" class="form-control" id="regione_legale" name="regione_legale" placeholder="{{ __('Es: Lombardia') }}" data-map="administrative_area_level_1">
            </div>
            <div class="form-group d-none" data-require-company>
                <label for="nazione_legale">{{ __('Nazione legale') }} *</label>
                <input type="text" value="{{ old('nazione_legale') }}" class="form-control" id="nazione_legale" name="nazione_legale" placeholder="{{ __('Es: Italia') }}" data-map="country">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Chiudi')}}</button>
          <button type="button" class="btn btn-primary" onclick="newCompany()">{{__('Aggiungi')}}</button>
        </div>
      </div>
    </div>
</div>
@endsection

@section('js')
<script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDfWrArMEXdPV92u9j6U8ohnZSp9aKJPeM&libraries=places&v=weekly"
      defer
    ></script>
<script>
    let componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'long_name',
        administrative_area_level_2: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };

    const createAutocomplete = (input, index) => {
        let autocomplete = new google.maps.places.Autocomplete(input, {
            types: ['address'],
            componentRestrictions: {
                'country': ["it"]
            }
        });

        let input_to_change = input;

        autocomplete.addListener('place_changed', function() {
            let obj = $(input).closest('.modal-body');
            fillInAddress(autocomplete,obj);
        });
    }

    const fillInAddress = (ac,content) => {
        let place = ac.getPlace();
        for (let i = 0; i < place.address_components.length; i++) {
            let addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                let val = place.address_components[i][componentForm[addressType]];
                let elem_id = $(content).find('input[data-map="'+addressType+'"]');
                $(elem_id).val(val);
                let street = $(content).find('input[data-map="street_number"]').val();
                if($(elem_id).attr('data-map') == 'route') {
                    $(elem_id).val($(elem_id).val() + ' ' + street)
                }
            }
        }
    }

    const common_request = axios.create({
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content')
        }
    });
    const resetModal = () => {
        $('#newCompany').modal('hide')
        $('#newCompany').on('hidden.bs.modal', function(e) {
            $('#rag_soc').val('')
            $('#settore_id').val('')
        })
    }
    const resetCompanies = (company_id) => {
        $.each($('#company_id > option'), function(index, value) {
            if($(value).val().length > 0) {
                $(value).remove()
            }
        })
        getCompanies(company_id)
    }
    const getCompanies = (company_id) => {
        common_request.get('/aziende-dropdown')
        .then(response => {
            let data = response.data
            $.each(data, function(index, value) {
                let opt = document.createElement('option')
                opt.value = value.id
                opt.text = value.rag_soc
                if(company_id == value.id) {
                    opt.selected = true
                }
                $('#company_id').append(opt)
            })
        })
        .catch(error => {
            console.log(error)
        })
    }
    const newCompany = () => {
        let privato = false
        let id_customer = null
        if($('[name="require_company"]').val() == true) {
            privato = true
            id_customer = $('#id_customer').val()
        }
        common_request.post('/nuova-azienda-short', {
            rag_soc: $('#rag_soc').val(),
            settore_id: $('#settore_id').val(),
            privato: privato,
            id_customer: id_customer,
            come_ci_ha_conosciuto: $('#come_ci_ha_conosciuto').val(),
            cod_fisc: $('#cod_fisc').val(),
            data_contattato: $('#data_contatto').val(),
            phone: $('#phone').val(),
            indirizzo_legale: $('#indirizzo_legale').val(),
            user_id_company: $('#user_id_company').val(),
            comune_legale: $('#comune_legale').val(),
            regione_legale: $('#regione_legale').val(),
            provincia_legale: $('#provincia_legale').val(),
            nazione_legale: $('#nazione_legale').val(),
            cap_legale: $('#cap_legale').val(),
        })
        .then(response => {
            let data = response.data
            if(!data.status) {
                alert(data.message)
            } else {
                resetModal()
                resetCompanies(data.company_id)
                Swal.fire({
                    title: `Azienda creata`,
                    text: "L'azienda è stata creata con successo!",
                    showCancelButton: true,
                    showCloseButton: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        if(privato) {
                            window.location.href = "/aziende/"+data.company_id
                        }
                    }
                })
            }
        })
        .catch(error => {
            console.log(error)
        })
    }

    $(document).ready(function() {
        let input = $('.autocomplete');
        for (i = 0; i < input.length; i++) {
            createAutocomplete(input[i], i);
        }

        $('#newCompany').on('hidden.bs.modal', function (e) {
            $('[data-require-company]').addClass('d-none')
        })
        getCompanies({{ $customer->company_id }});

        $('#privato').change(function() {
            if($(this).val() == 'azienda') {
                $('[data-azienda]').removeClass('d-none');
                $('#company_id').attr('required', true);
            } else {
                $('[data-azienda]').addClass('d-none');
                $('#company_id').removeAttr('required');
            }
        });

        if($('[name="require_company"]').val() == true) {
            Swal.fire({
                title: `Crea Azienda`,
                text: "Questo Contatto Privato non ha ancora una Azienda associata, vuoi crearla?",
                showCancelButton: true,
                showCloseButton: true,
            })
            .then((result) => {
                if (result.isConfirmed) {
                    
                    $('[data-require-company]').removeClass('d-none')
                    $('#come_ci_ha_conosciuto').val($('#sorgente_acquisizione').val())
                    $('#newCompany').modal('show')
                }
            });
        }
    });
</script>
@endsection