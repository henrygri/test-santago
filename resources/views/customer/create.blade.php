@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1 class="text-capitalize">Crea {{$stato == 'contattato' ? 'Contatto' : $stato}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item text-capitalize"><a href="/list/{{$stato}}">{{$stato == 'contattato' ? 'Contatto' : $stato}}</a></li>
                <li class="breadcrumb-item active text-capitalize">Crea {{$stato == 'contattato' ? 'Contatto' : $stato}}</li>
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
                <div class="card-header text-capitalize">{{ __('Aggiungi') }} {{$stato == 'contattato' ? 'Contatto' : $stato}}</div>
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
                        <form action="{{ route('clienti.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="stato" value="{{$stato}}">
                            @if(isset($company))
                            <input type="hidden" name="company_id_passed" data-company_privato="{{$company->privato}}" data-company_rag_soc="{{$company->rag_soc}}" value="{{$company->id}}">
                            @endif
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nome">{{ __('Nome') }} *</label>
                                        <input type="text" class="form-control" id="nome" name="nome"  value="{{ old('nome') }}" placeholder="{{ __('Es: Paolo') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cognome">{{ __('Cognome') }} *</label>
                                        <input type="text" class="form-control" id="cognome" name="cognome" value="{{ old('cognome') }}" placeholder="{{ __('Es: Rossi') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">{{ __('Indirizzo email primo contatto') }} *</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="{{ __('Es: user@user.it') }}" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="privato">{{ __('Tipo di customer') }} *</label>
                                        <select id="privato" name="privato" class="form-control" required>
                                            <option></option>
                                            <option value="privato">Privato</option>
                                            <option value="azienda">Azienda</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="email_aziendale">{{ __('Indirizzo email aziendale personale') }}</label>
                                        <input type="email" class="form-control" id="email_aziendale" value="{{ old('email_aziendale') }}" name="email_aziendale" placeholder="{{ __('Es: user@user.it') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="telefono_ufficio">{{ __('Telefono ufficio') }}</label>
                                        <input type="text" class="form-control" id="telefono_ufficio" value="{{ old('telefono_ufficio') }}" name="telefono_ufficio" placeholder="{{ __('Es: +39 02484668') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="telefono_personale">{{ __('Telefono personale') }}</label>
                                        <input type="text" class="form-control" id="telefono_personale" value="{{ old('telefono_personale') }}" name="telefono_personale" placeholder="{{ __('Es: +39 02484668') }}">
                                    </div>
                                </div>
                            </div>
                           
                            <div class="row">
                                <div class="col-md-8 d-none" data-azienda>
                                    <div class="form-group">
                                        <label for="company_id">{{ __('Azienda') }} *</label>
                                        {{--
                                        @if(isset($company))
                                        <select id="company_id" name="company_id" readonly>
                                            <option value="{{$company->id}}" selected>{{ $company->rag_soc }}</option>
                                        </select>
                                        @else
                                        <div class="input-group">
                                            <select id="company_id" name="company_id" class="form-control">
                                                <option></option>
                                            </select>
                                            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#newCompany">Aggiungi</button>
                                        </div>
                                        @endif
                                        --}}
                                        <div class="input-group">
                                            <select id="company_id" name="company_id" class="form-control">
                                                <option></option>
                                            </select>
                                            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#newCompany">Aggiungi</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email_aziendale_generica">{{ __('Indirizzo email aziendale generica') }}</label>
                                        <input type="email" class="form-control" id="email_aziendale_generica" value="{{ old('email_aziendale_generica') }}" name="email_aziendale_generica" placeholder="{{ __('Es: user@user.it') }}">
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
                                                <option value="{{$role['id']}}">{{$role['nome']}}</option>
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
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="user_id">{{ __('Responsabile contatto') }} *</label>
                                        <select id="user_id" name="user_id" class="form-control" required>
                                            <option></option>
                                            @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="data_creazione_lead">{{ __('Data creazione') }}</label>
                                        <input type="date" class="form-control" id="data_creazione_lead" value="{{ old('data_creazione_lead') }}" name="data_creazione_lead">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="stato_cliente">{{ __('Stato lead') }} *</label>
                                        <select id="stato_cliente" name="stato_cliente" class="form-control" required>
                                            <option></option>
                                            <option value="da_lavorare" {{$stato != 'contattato' ? 'selected' : ''}}>{{__('Da Lavorare')}}</option>
                                            <option value="contattato" {{$stato == 'contattato' ? 'selected' : ''}}>{{__('Contattato')}}</option>
                                            <option value="da_ricontattare">{{__('Da Ricontattare')}}</option>
                                            <option value="parking">{{__('Parking')}}</option>
                                            <option value="non_qualificato">{{__('Non Qualificato')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="service_id">{{ __('Servizi') }}</label>
                                    <select id="service_id" name="service_id" class="form-control">
                                        <option></option>
                                        @foreach ( $services as $service)
                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="noe">{{ __('Note') }}</label>
                                        <textarea name="note" id="note" class="form-control" rows="5">{{ old('note') }}</textarea>
                                    </div>
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
<div class="modal fade" id="newCompany" tabindex="-1" aria-labelledby="newCompanyLabel" aria-hidden="true">
    <div class="modal-dialog">
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
            {{--<div class="form-group">
                <label for="cod_fisc">{{ __('Codice Fiscale') }} <span class="text-danger">(se non disponibile copiare ed incollare la partita IVA)</span></label>
                <input type="text" maxlength="16" class="form-control" id="cod_fisc" name="cod_fisc" placeholder="{{ __('Es: YHTKIU89O08O896U') }}">
            </div>
            <div class="form-group">
                <label for="phone">{{ __('Telefono') }}</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="{{ __('Es. +39 01232412') }}">
            </div>
            <div class="form-group">
                <label for="user_id_company">{{ __('Assegnato a') }}</label>
                <select id="user_id_company" name="user_id_company" class="form-control modalSelect2">
                    <option></option>
                    @foreach ( $users as $user )
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>--}}
            <div class="form-group">
                <label for="settore_id">{{ __('Settore') }}</label>
                <select id="settore_id" name="settore_id" class="form-control modalSelect2">
                    <option></option>
                    @foreach($settori as $settore)
                    <option value="{{$settore->id}}">{{$settore->nome}}</option>
                    @endforeach
                </select>
            </div>
            {{--<div class="form-group">
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
            <div class="form-group">
                <label for="data_contatto">{{ __('Data di primo contatto') }}</label>
                <input type="date" class="form-control" id="data_contatto" name="data_contatto">
            </div>--}}
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
<script>
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
            let company_passed = 0
            if($('input[name="company_id_passed"]').length > 0) {
                company_passed = parseInt($('input[name="company_id_passed"]').val())
            }
            $.each(data, function(index, value) {
                let opt = document.createElement('option')
                opt.value = value.id
                opt.text = value.rag_soc
                if(company_id == value.id || (company_passed > 0 && company_passed == value.id)) {
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
        common_request.post('/nuova-azienda-short', {
            rag_soc: $('#rag_soc').val(),
            settore_id: $('#settore_id').val()
        })
        .then(response => {
            console.log(response);
            let data = response.data
            if(!data.status) {
                alert(data.message)
            } else {
                resetModal()
                resetCompanies(data.company_id)
            }
        })
        .catch(error => {
            console.log(error)
        })
    }
    $(document).ready(function() {
        getCompanies();
        $('#privato').change(function() {
            $('#company_id').val('')
            if($(this).val() == 'azienda') {
                $('[data-azienda]').removeClass('d-none');
                $('#company_id').attr('required', true);
            } else {
                $('[data-azienda]').addClass('d-none');
                $('#company_id').removeAttr('required');
            }
            $('#company_id').trigger('change.select2')
        });
        if($('input[name="company_id_passed"]').length > 0) {
            let el = $('input[name="company_id_passed"]')
            let privato = parseInt(el.data('company_privato')) == 1 ? 'privato' : 'azienda'
            if(privato == 'azienda') {
                $('[data-azienda]').removeClass('d-none');
                $('#company_id').attr('required', true);
            }
            $('[data-bs-target="#newCompany"]').hide()
            $('#privato').val(privato)
            $('#privato').trigger('change.select2')
        }
    });
</script>
@endsection