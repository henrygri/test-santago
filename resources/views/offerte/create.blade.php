@extends('adminlte::page')

@section('css')
<style>
    .pac-container {
        z-index: 10000 !important;
    }
</style>
@endsection

@section('content_header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1>Crea Offerta</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('offerte.index') }}">Offerte</a></li>
                <li class="breadcrumb-item active">Crea Offerta</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid pt-3">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">{{ __('Aggiungi Offerta') }}</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <ul class="mb-0 pl-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="col-md-12">
                        <form action="{{ route('offerte.store') }}" method="post">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="codice">{{ __('Codice protocollo') }} <span class="text-danger">(si genera in automatico)</span></label>
                                        <input type="text" value="{{ old('codice') }}" class="form-control" id="codice" name="codice">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @if(isset($companies))
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="company_id">{{ __('Azienda') }} *</label>
                                        <select id="company_id" name="company_id" class="form-control" required>
                                            <option></option>
                                            @foreach($companies as $company)
                                            <option value="{{$company->id}}">{{$company->rag_soc}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @else
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="company_id_select">{{ __('Azienda') }} *</label>
                                        <input type="hidden" value="{{$company->id}}" id="company_id" name="company_id" required>
                                        <select id="company_id_select" name="company_id_select" class="form-control" disabled>
                                            <option value="{{$company->id}}" selected>{{$company->rag_soc}}</option>
                                        </select>
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="customer_id">{{ __('Referente azienda') }} *</label>
                                        <select id="customer_id" name="customer_id" class="form-control" required>
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="user_id">{{ __('Responsabile offerta') }}</label>
                                        <select id="user_id" name="user_id" class="form-control">
                                            <option></option>
                                            @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                           

                            <div class="row">
                                <div class="col-md-12">
                                    <label for="description">{{ __('Descrizione offerta') }} *</label>
                                    <textarea id="description" name="description" class="form-control" required>{{ old('description') }}</textarea>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="service_id">{{ __('Tipologia servizi') }} *</label>
                                        <select id="service_id" name="service_id[]" class="form-control select2" multiple required>
                                            <option></option>
                                            @foreach($services as $service)
                                            <option value="{{$service->id}}">{{$service->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="stato">{{ __('Stato') }} *</label>
                                        <select id="stato" name="stato" class="form-control" required>
                                            <option value="in attesa" selected>{{__('In attesa')}}</option>
                                            <option value="accettata">{{__('Accettata')}}</option>
                                            <option value="rifiutata">{{__('Rifiutata')}}</option>
                                            <option value="annullata">{{__('Annullata')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="data_richiesta_preventivo">{{ __('Data richiesta preventivo') }}</label>
                                        <input type="date" value="{{ old('data_richiesta_preventivo') }}" class="form-control" id="data_richiesta_preventivo" name="data_richiesta_preventivo">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="data_scadenza_preventivo">{{ __('Data scadenza preventivo') }}</label>
                                        <input type="date" value="{{ old('data_scadenza_preventivo') }}" class="form-control" id="data_scadenza_preventivo" name="data_scadenza_preventivo">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="val_offerta_tot">{{ __('Valore offerta TOT') }} *</label>
                                        <div class="input-group mb-3">
                                            <input type="text" value="{{ old('val_offerta_tot') }}" class="form-control number_format" id="val_offerta_tot" name="val_offerta_tot" required>
                                            <span class="input-group-text">€</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check ml-1 mb-3">
                                        <input type="checkbox" name="finanziamento" id="finanziamento" class="form-check-input">
                                        <label class="form-check-label" for="finanziamento">{{ __('Finanziamento') }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4 d-none">
                                <div class="col-md-12">
                                    <div class="card card-primary">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="val_offerta_finanz">{{ __('Valore offerta finanziato') }} *</label>
                                                        <div class="input-group mb-3">
                                                            <input type="text" class="form-control number_format" id="val_offerta_finanz" name="val_offerta_finanz">
                                                            <span class="input-group-text">€</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="val_offerta_no_finanz">{{ __('Valore offerta non finanziato') }} *</label>
                                                        <div class="input-group mb-3">
                                                            <input type="text" class="form-control number_format" id="val_offerta_no_finanz" name="val_offerta_no_finanz" readonly>
                                                            <span class="input-group-text">€</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="individuale_gruppo">{{ __('Individuale/Gruppo') }}</label>
                                                        <select id="individuale_gruppo" name="individuale_gruppo" class="form-control">
                                                            <option></option>
                                                            <option value="individuale">{{__('Individuale')}}</option>
                                                            <option value="gruppo">{{__('Gruppo')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="bando_id">{{ __('Codice piano/bando') }} *</label>
                                                        <select id="bando_id" name="bando_id" class="form-control">
                                                            <option></option>
                                                            @foreach($bandi as $bando)
                                                            <option value="{{$bando->id}}">{{$bando->codice}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="corso_id">{{ __('Corso') }}</label>
                                                        <select id="corso_id" name="corso_id" class="form-control">
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="edizione_corso">{{ __('Edizione') }}</label>
                                                        <select id="edizione_corso" name="edizione_corso" class="form-control">
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                {{--
                                                    <label class="mt-3 d-none" data-corso>{{__('Corsi')}}</label>
                                                    <div class="input-group my-3 child d-none" data-placeholder>
                                                        <div>  
                                                            <label for="titolo">Titolo</label>                                                      
                                                            <input type="text" name="titolo" class="form-control" readonly>
                                                        </div>
                                                        <div>
                                                            <label for="titolo">Ore</label> 
                                                            <input type="text" name="ore"  class="form-control" readonly>
                                                        </div>
                                                        <div>
                                                            <label for="titolo">Edizione</label> 
                                                            <select name="edizione" class="form-control"></select>
                                                        </div>
                                                    </div>
                                                </div>
                                                --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="note">{{ __('Note') }}</label>
                                    <textarea id="note" name="note" class="form-control">{{ old('note') }}</textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('Salva') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="companyData" tabindex="-1" aria-labelledby="companyDataLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="companyDataLabel">{{__('Aggiungi Dati Azienda')}}</h5>
          <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
        </div>
        <div class="modal-body">
            <input type="hidden" id="privato" name="privato">
            <div class="form-group">
                <label for="cod_fisc">{{ __('Codice Fiscale') }} * <span class="text-danger">(se non disponibile copiare ed incollare la partita IVA)</span></label>
                <input type="text" maxlength="16" class="form-control" id="cod_fisc" name="cod_fisc" placeholder="{{ __('Es: YHTKIU89O08O896U') }}" required>
            </div>
            <div class="form-group">
                <label for="phone">{{ __('Telefono') }} *</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="{{ __('Es. +39 01232412') }}" required>
            </div>
            <div class="form-group">
                <label for="user_id_company">{{ __('Assegnato a') }} *</label>
                <select id="user_id_company" name="user_id_company" class="form-control modalSelect2" required>
                    <option></option>
                    @foreach ( $users as $user )
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="come_ci_ha_conosciuto">{{ __('Come ci ha conosciuto') }} *</label>
                <select id="come_ci_ha_conosciuto" name="come_ci_ha_conosciuto" class="form-control modalSelect2" required>
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
            <div class="form-group" data-company-real>
                <label for="p_iva">{{ __('Partita IVA') }} *</label>
                <input type="text" maxlength="11" class="form-control" id="p_iva" name="p_iva" placeholder="{{ __('Es: 12345678901') }}" required>
            </div>
            <div class="form-group" data-company-real>
                <label for="autocomplete">{{ __('Inserisci sede legale') }}</label>
                <input type="text" id="pac-input" class="form-control autocomplete">
            </div>
            <div class="form-group" data-company-real>
                <label for="indirizzo_legale">{{ __('Indirizzo legale') }} *</label>
                <input type="text" class="form-control" id="indirizzo_legale" name="indirizzo_legale" placeholder="{{ __('Es: Via piave 2') }}" required data-map="route">
            </div>
            <div class="form-group" data-company-real>
                <label for="comune_legale">{{ __('Comune legale') }} *</label>
                <input type="text" class="form-control" id="comune_legale" name="comune_legale" placeholder="{{ __('Es: Milano') }}" required data-map="locality">
            </div>
            <div class="form-group" data-company-real>
                <label for="provincia_legale">{{ __('Provincia legale') }} *</label>
                <input type="text" class="form-control" id="provincia_legale" name="provincia_legale" placeholder="{{ __('Es: Milano') }}" required data-map="administrative_area_level_2">
            </div>
            <div class="form-group" data-company-real>
                <label for="cap_legale">{{ __('CAP legale') }} *</label>
                <input type="text" class="form-control" id="cap_legale" name="cap_legale" placeholder="{{ __('Es: 20100') }}" required data-map="postal_code">
            </div>
            <div class="form-group" data-company-real>
                <label for="regione_legale">{{ __('Regione legale') }} *</label>
                <input type="text" class="form-control" id="regione_legale" name="regione_legale" placeholder="{{ __('Es: Lombardia') }}" required data-map="administrative_area_level_1">
            </div>
            <div class="form-group" data-company-real>
                <label for="nazione_legale">{{ __('Nazione legale') }} *</label>
                <input type="text" class="form-control" id="nazione_legale" name="nazione_legale" placeholder="{{ __('Es: Italia') }}" required data-map="country">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="saveData()">{{__('Salva')}}</button>
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
    const resetCustomers = () => {
        $.each($('#customer_id > option[value!=""]'), function(index, value) {
            $(value).remove()
        })
    }
    const getCustomers = (company_id) => {
        resetCustomers()
        common_request.post('/customers-dropdown', {
            company_id: company_id
        })
        .then(response => {
            let data = response.data.customers
            $.each(data, function(index, value) {
                let opt = document.createElement('option')
                opt.value = value.id
                opt.text = value.nome + ' ' + value.cognome
                $('#customer_id').append(opt)
            })
        })
        .catch(error => {
            console.log(error)
        })
    }

    const resetCourses = () => {
        $('#corso_id').find('option:not(:first-child)').remove()
        resetEditions()
    }

    const resetEditions = () => {
        $('#edizione_corso').find('option:not(:first-child)').remove()
    }

    const getCourses = (bando_id) => {
        resetCourses()
        if(bando_id > 0) {
            common_request.post('/courses-data', {
                bando_id: bando_id
            })
            .then(response => {
                let data = response.data.corsi
                $.each(data, function(index, value) {
                    let opt = document.createElement('option')
                    opt.value = value.id
                    opt.text = value.titolo + ' (ore: '+value.ore+')'
                    $('#corso_id').append(opt)
                })
            })
            .catch(error => {
                console.log(error)
            })
        }
    }

    const checkData = (company_id) => {
        common_request.post('/azienda-details', {
            company_id: company_id
        })
        .then(response => {
            if(response.data.status) {
                let company = response.data.company;
                console.log(company);
                let privato = parseInt(company.privato)
                if(privato) {
                    $('[data-company-real]').addClass('d-none');
                } else {
                    $('[data-company-real]').removeClass('d-none');
                }
                $('#privato').val(company.privato)
                $('#cod_fisc').val(company.cod_fisc);
                $('#phone').val(company.phone);
                $('#p_iva').val(company.p_iva);
                $('#come_ci_ha_conosciuto').val(company.come_ci_ha_conosciuto);
                $('#indirizzo_legale').val(company.indirizzo_legale);
                $('#comune_legale').val(company.comune_legale);
                $('#provincia_legale').val(company.provincia_legale);
                $('#cap_legale').val(company.cap_legale);
                $('#regione_legale').val(company.regione_legale);
                $('#nazione_legale').val(company.nazione_legale);
                $('#comune_legale').val(company.comune_legale);
                $('#user_id_company').val(company.user_id)
                $('#come_ci_ha_conosciuto, #user_id_company').trigger('change.select2');
                $('#companyData').modal('show');
            }  
        })
        .catch(error => {
            console.log(error)
        })
    }

    const saveData = () => {
        common_request.post('/azienda-save-data', {
            privato: $('#privato').val(),
            company_id: $('#company_id').val(),
            user_id: $('#user_id_company').val(),
            cod_fisc: $('#cod_fisc').val(),
            phone: $('#phone').val(),
            p_iva: $('#p_iva').val(),
            come_ci_ha_conosciuto: $('#come_ci_ha_conosciuto').val(),
            indirizzo_legale: $('#indirizzo_legale').val(),
            provincia_legale: $('#provincia_legale').val(),
            cap_legale: $('#cap_legale').val(),
            regione_legale: $('#regione_legale').val(),
            nazione_legale: $('#nazione_legale').val(),
            comune_legale: $('#comune_legale').val(),
        })
        .then(response => {
            if(!response.data.status) {
                alert(response.data.message)
            } else {
                $('#companyData').modal('hide');
            }
        })
        .catch(error => {
            console.log(error)
        })
    }

    const calcNoFinanz = (finanziato, tot) => {
        let _tot = parseFloat(tot).toFixed(2)
        let finanz = parseFloat(finanziato).toFixed(2)
        let result = parseFloat(_tot - finanz).toFixed(2)
        return result
    }

    const getEditions = (corso) => {
        resetEditions()
        if(corso > 0) {
            common_request.post('/editions-data', {
                corso_id: corso
            })
            .then(response => {
                let data = response.data.corso;
                console.log(data)
                let editions = parseInt(data.edizioni)
                for(let i=0; i < editions; i++) {
                    let opt = document.createElement('option')
                    opt.value = i + 1
                    opt.text = i + 1
                    $('#edizione_corso').append(opt)
                }
            })
            .catch(error => {
                console.log(error)
            })
        }
    }
    
    $(document).ready(function(){
        

        $('#finanziamento').change(function() {
            let row = $(this).closest('.row');

            if($(this).is(':checked')) {
                row.next().removeClass('d-none');
            } else {
                row.next().addClass('d-none');
                let content = row.next();
                $(content).find('input').val('');
                $(content).find('select').val('');
                $(content).find('#corso_id :not(:first-child)').remove();
                $(content).find('#edizione_corso :not(:first-child)').remove();
            }
        })

        if($('#company_id_select').prop('disabled')) {
            checkData($('#company_id').val());
            getCustomers($('#company_id_select').val())
        }

        $('#company_id').change(function() {
            checkData($(this).val())
            getCustomers($(this).val())
        })

        $('#bando_id').change(function() {
            getCourses($(this).val())
        });

        $('#corso_id').change(function() {
            getEditions($(this).val())
        })

        $('#companyData').modal({
            backdrop: 'static',
            keyboard: false
        });


        $('#val_offerta_finanz, #val_offerta_tot').change(function() {
            if($('#val_offerta_tot').val().length > 0 && $('#val_offerta_finanz').val().length > 0) {
                $('#val_offerta_no_finanz').val(calcNoFinanz($('#val_offerta_finanz').val(), $('#val_offerta_tot').val()))
            } else {
                $('#val_offerta_no_finanz').val('')
            }
        })

        $('#val_offerta_finanz').on('keyup',function(){
            let tot = parseFloat($('#val_offerta_tot').val())
            let init = parseFloat($('#val_offerta_finanz').val())
            if(init > tot) {
                $('#val_offerta_finanz').val('')
                $('#val_offerta_no_finanz').val('')
            }
        });

        let input = $('.autocomplete');
        for (i = 0; i < input.length; i++) {
            createAutocomplete(input[i], i);
        }

        $('#data_richiesta_preventivo').on('change',function() {
            $('#data_scadenza_preventivo').attr('min', $('#data_richiesta_preventivo').val())
            $('#data_scadenza_preventivo').val($('#data_richiesta_preventivo').val())
        });
 
    });
</script>
@endsection