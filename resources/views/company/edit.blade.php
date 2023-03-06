@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1>Modifica Azienda</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('aziende.index') }}">Aziende</a></li>
                <li class="breadcrumb-item active">Modifica Azienda {{$company->rag_soc}} </li>
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
                <div class="card-header">{{ __('Modifica Azienda') }}</div>

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
                        <form action="{{ route('aziende.update', $company->id) }}" method="post">
                            @csrf
                            @method('PATCH')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input type="checkbox" name="privato" id="privato" class="form-check-input" {{$company->privato ? 'checked' : ''}}>
                                        <label class="form-check-label" for="privato">{{ __('Privato') }}</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="user_id">{{ __('Assegnato a') }}</label>
                                        <select id="user_id" name="user_id" class="form-control">
                                            <option></option>
                                            @foreach($users as $user)
                                            <option value="{{$user->id}}" {{ $user->id == $company->user_id ? 'selected' : '' }}>{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rag_soc">{{ __('Ragione Sociale') }}</label>
                                        <input type="text" class="form-control" id="rag_soc" name="rag_soc" placeholder="{{ __('Es: Azienda srl') }}" value="{{$company->rag_soc}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="settore_id">{{ __('Settore') }}</label>
                                        <select id="settore_id" name="settore_id" class="form-control">
                                            <option></option>
                                            @foreach($settori as $settore)
                                            <option value="{{$settore->id}}" {{$company->settore->id == $settore->id ? 'selected' : ''}}>{{$settore->nome}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cod_fisc">{{ __('Codice Fiscale') }} * <span class="text-danger text-sm">(se non disponibile copiare ed incollare la p.iva)</span></label>
                                        <input type="text" class="form-control" id="cod_fisc" name="cod_fisc" placeholder="{{ __('Es: YHTKIU89O08O896U') }}" value="{{$company->cod_fisc}}" maxlength="16">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group {{ $company->privato ? 'd-none' : '' }}" data-company>
                                        <label for="p_iva">{{ __('Partita IVA') }} *</label>
                                        <input type="text" class="form-control" maxlength="11" id="p_iva" name="p_iva" placeholder="{{ __('Es: 12345678901') }}" value="{{$company->p_iva}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group {{ $company->privato ? 'd-none' : '' }}" data-company>
                                        <label for="p_iva_collegata">{{ __('Partita IVA collegata') }}</label>
                                        <input type="text" maxlength="11" class="form-control" id="p_iva_collegata" name="p_iva_collegata" placeholder="{{ __('Es: 12345678901') }}" value="{{$company->p_iva_collegata}}">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">{{ __('Telefono') }} *</label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="{{ __('Es: 034123456') }}" value="{{$company->phone}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tipo">{{ __('Tipo') }}</label>
                                        <select id="tipo" name="tipo" class="form-control">
                                            <option></option>
                                            <option value="nuovo" {{$company->tipo == 'nuovo' ? 'selected' : ''}}>Nuovo</option>
                                            <option value="in lavorazione" {{$company->tipo == 'in lavorazione' ? 'selected' : ''}}>In lavorazione</option>
                                            <option value="da ricontattare" {{$company->tipo == 'da ricontattare' ? 'selected' : ''}}>Da ricontattare</option>
                                            <option value="prospect" {{$company->tipo == 'prospect' ? 'selected' : ''}}>Prospect</option>
                                            <option value="non interessato" {{$company->tipo == 'non interessato' ? 'selected' : ''}}>Non interessato</option>
                                            <option value="cliente" {{$company->tipo == 'cliente' ? 'selected' : ''}}>Cliente</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group d-none">
                                        <label for="data_ricontattare">{{ __('Data ricontattare') }}</label>
                                        <input type="date" class="form-control" id="data_ricontattare" name="data_ricontattare" value="{{$company->data_ricontattare}}">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-primary  card-show">
                                        <div class="card-header">
                                            {{ __('Sede legale') }}
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="autocomplete">{{ __('Inserisci indirizzo') }}</label>
                                                        <input type="text" id="pac-input" class="form-control autocomplete">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="indirizzo_legale">{{ __('Indirizzo legale') }} *</label>
                                                        <input type="text" class="form-control" id="indirizzo_legale" name="indirizzo_legale" placeholder="{{ __('Es: Via piave 2') }}" value="{{$company->indirizzo_legale}}" data-map="route">
                                                        <input type="hidden" id="street_number" data-map="street_number" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="comune_legale">{{ __('Comune legale') }} *</label>
                                                        <input type="text" class="form-control" id="comune_legale" name="comune_legale" placeholder="{{ __('Es: Milano') }}" value="{{$company->comune_legale}}" data-map="locality">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="provincia_legale">{{ __('Provincia legale') }} *</label>
                                                        <input type="text" class="form-control" id="provincia_legale" name="provincia_legale" placeholder="{{ __('Es: Milano') }}" value="{{$company->provincia_legale}}" data-map="administrative_area_level_2">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="cap_legale">{{ __('CAP legale') }} *</label>
                                                        <input type="text" class="form-control" id="cap_legale" name="cap_legale" placeholder="{{ __('Es: 20100') }}" value="{{$company->cap_legale}}" data-map="postal_code">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="regione_legale">{{ __('Regione legale') }} *</label>
                                                        <input type="text" class="form-control" id="regione_legale" name="regione_legale" placeholder="{{ __('Es: Lombardia') }}" value="{{$company->regione_legale}}" data-map="administrative_area_level_1">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="nazione_legale">{{ __('Nazione legale') }} *</label>
                                                        <input type="text" class="form-control" id="nazione_legale" name="nazione_legale" placeholder="{{ __('Es: Italia') }}" value="{{$company->nazione_legale}}" data-map="country">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card card-primary  card-show">
                                        <div class="card-header">
                                            {{ __('Sedi operative') }}
                                        </div>
                                        <div class="card-body">
                                            <div class="card card-primary d-none" data-sede>
                                                <div class="card-header">
                                                    <a class="btn btn-danger" role="button" onclick="removeRow(this)"><i class="fa fa-trash"></i> {{__('Elimina')}}</a>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="autocomplete">{{ __('Inserisci indirizzo') }}</label>
                                                                <input type="text" id="pac-input" class="form-control autocomplete">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group d-none" data-company>
                                                                <label for="indirizzo_operativo">{{ __('Indirizzo operativo') }}</label>
                                                                <input type="text" class="form-control" name="indirizzo_operativo[]" placeholder="{{ __('Es: Via piave 2') }}" data-map="route">
                                                                <input type="hidden" id="street_number" data-map="street_number" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group d-none" data-company>
                                                                <label for="comune_operativo">{{ __('Comune operativo') }}</label>
                                                                <input type="text" class="form-control" name="comune_operativo[]" placeholder="{{ __('Es: Milano') }}" data-map="locality">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group d-none" data-company>
                                                                <label for="provincia_operativo">{{ __('Provincia operativo') }}</label>
                                                                <input type="text" class="form-control" name="provincia_operativo[]" placeholder="{{ __('Es: Milano') }}" data-map="administrative_area_level_2">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group d-none" data-company>
                                                                <label for="cap_operativo">{{ __('CAP operativo') }}</label>
                                                                <input type="text" class="form-control" name="cap_operativo[]" placeholder="{{ __('Es: 20100') }}" data-map="postal_code">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group d-none" data-company>
                                                                <label for="regione_operativo">{{ __('Regione operativo') }}</label>
                                                                <input type="text" class="form-control" name="regione_operativo[]" placeholder="{{ __('Es: Lombardia') }}" data-map="administrative_area_level_1">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group d-none" data-company>
                                                                <label for="nazione_operativo">{{ __('Nazione operativo') }}</label>
                                                                <input type="text" class="form-control" name="nazione_operativo[]" placeholder="{{ __('Es: Italia') }}" data-map="country">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if(!is_null($company->sedi))
                                            @foreach(json_decode($company->sedi) as $sede)
                                            <div class="card card-primary" data-sede>
                                                <div class="card-header">
                                                    <a class="btn btn-danger" role="button" onclick="removeRow(this)"><i class="fa fa-trash"></i> {{__('Elimina')}}</a>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="autocomplete">{{ __('Inserisci indirizzo') }}</label>
                                                                <input type="text" id="pac-input" class="form-control autocomplete">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group {{ $company->privato ? 'd-none' : '' }}" data-company>
                                                                <label for="indirizzo_operativo">{{ __('Indirizzo operativo') }}</label>
                                                                <input type="text" class="form-control" name="indirizzo_operativo[]" placeholder="{{ __('Es: Via piave 2') }}" value="{{$sede->indirizzo_operativo}}" data-map="route">
                                                                <input type="hidden" id="street_number" data-map="street_number" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group {{ $company->privato ? 'd-none' : '' }}" data-company>
                                                                <label for="comune_operativo">{{ __('Comune operativo') }}</label>
                                                                <input type="text" class="form-control" name="comune_operativo[]" placeholder="{{ __('Es: Milano') }}" value="{{$sede->comune_operativo}}" data-map="locality">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group {{ $company->privato ? 'd-none' : '' }}" data-company>
                                                                <label for="provincia_operativo">{{ __('Provincia operativo') }}</label>
                                                                <input type="text" class="form-control" name="provincia_operativo[]" placeholder="{{ __('Es: Milano') }}" value="{{$sede->provincia_operativo}}" data-map="administrative_area_level_2">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group {{ $company->privato ? 'd-none' : '' }}" data-company>
                                                                <label for="cap_operativo">{{ __('CAP operativo') }}</label>
                                                                <input type="text" class="form-control" name="cap_operativo[]" placeholder="{{ __('Es: 20100') }}" value="{{$sede->cap_operativo}}" data-map="postal_code">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group {{ $company->privato ? 'd-none' : '' }}" data-company>
                                                                <label for="regione_operativo">{{ __('Regione operativo') }}</label>
                                                                <input type="text" class="form-control" name="regione_operativo[]" placeholder="{{ __('Es: Lombardia') }}" value="{{$sede->regione_operativo}}" data-map="administrative_area_level_1">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group {{ $company->privato ? 'd-none' : '' }}" data-company>
                                                                <label for="nazione_operativo">{{ __('Nazione operativo') }}</label>
                                                                <input type="text" class="form-control" name="nazione_operativo[]" placeholder="{{ __('Es: Italia') }}" value="{{$sede->nazione_operativo}}"  data-map="country">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                            @endif
                                        </div>
                                        <div class="card-footer">
                                            <a role="button" onclick="newSede(this);" class="btn btn-primary"><i class="fa fa-plus"></i> {{__('Sede operativa')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group {{ $company->privato ? 'd-none' : '' }}" data-company>
                                        <label for="tipologia_organizzativa">{{ __('Tipologia organizzativa') }}</label>
                                        <select id="tipologia_organizzativa" name="tipologia_organizzativa" class="form-control">
                                            <option></option>
                                            <option value="multinazionale" {{$company->tipologia_organizzativa == 'multinazionale' ? 'selected' : ''}}>Multinazionale</option>
                                            <option value="padronale manageriale" {{$company->tipologia_organizzativa == 'padronale manageriale' ? 'selected' : ''}}>Padronale manageriale</option>
                                            <option value="padronale" {{$company->tipologia_organizzativa == 'padronale' ? 'selected' : ''}}>Padronale</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group {{ $company->privato ? 'd-none' : '' }}" data-company>
                                        <label for="fatturato_annuo">{{ __('Fatturato annuo') }}</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control number_format" id="fatturato_annuo" name="fatturato_annuo" placeholder="{{ __('Es: 20.000') }}" value="{{$company->fatturato_annuo}}">
                                            <span class="input-group-text">€</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group {{ $company->privato ? 'd-none' : '' }}" data-company>
                                        <label for="n_dipendenti">{{ __('Numero dipendenti') }}</label>
                                        <input type="text" class="form-control" id="n_dipendenti" name="n_dipendenti" placeholder="{{ __('Es: 50') }}" value="{{$company->n_dipendenti}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="data_contatto">{{ __('Data di primo contatto') }}</label>
                                        <input type="date" class="form-control" id="data_contatto" name="data_contatto" value="{{$company->data_contatto}}">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="come_ci_ha_conosciuto">{{ __('Come ci ha conosciuto') }} *</label>
                                <select id="come_ci_ha_conosciuto" name="come_ci_ha_conosciuto" class="form-control" required>
                                    <option></option>
                                    <option value="social" {{$company->come_ci_ha_conosciuto == 'social' ? 'selected' : ''}}>Social</option>
                                    <option value="sito" {{$company->come_ci_ha_conosciuto == 'sito' ? 'selected' : ''}}>Sito</option>
                                    <option value="telefono" {{$company->come_ci_ha_conosciuto == 'telefono' ? 'selected' : ''}}>Telefono</option>
                                    <option value="email" {{$company->come_ci_ha_conosciuto == 'email' ? 'selected' : ''}}>Email</option>
                                    <option value="chiamata a freddo" {{$company->come_ci_ha_conosciuto == 'chiamata a freddo' ? 'selected' : ''}}>Chiamata a freddo</option>
                                    <option value="campagna web" {{$company->come_ci_ha_conosciuto == 'campagna web' ? 'selected' : ''}}>Campagna web</option>
                                    <option value="passaparola" {{$company->come_ci_ha_conosciuto == 'passaparola' ? 'selected' : ''}}>Passaparola</option>
                                    <option value="dipendente" {{$company->come_ci_ha_conosciuto == 'dipendente' ? 'selected' : ''}}>Dipendente</option>
                                    <option value="partner" {{$company->come_ci_ha_conosciuto == 'partner' ? 'selected' : ''}}>Partner</option>
                                    <option value="evento online" {{$company->come_ci_ha_conosciuto == 'evento online' ? 'selected' : ''}}>Evento online</option>
                                    <option value="convegno" {{$company->come_ci_ha_conosciuto == 'convegno' ? 'selected' : ''}}>Convegno</option>
                                </select>
                                {{--<textarea id="come_ci_ha_conosciuto" name="come_ci_ha_conosciuto" class="form-control">{!!$company->come_ci_ha_conosciuto!!}</textarea>--}}
                            </div>
                            <div class="form-group {{ $company->privato ? 'd-none' : '' }}" data-company>
                                <label for="fondo_dirigenti">{{ __('Fondo dirigenti') }}</label>
                                <select id="fondo_dirigenti" name="fondo_dirigenti" class="form-control">
                                    <option></option>
                                    <option value="FONDIR" {{$company->fondo_dirigenti == 'FONDIR' ? 'selected' : ''}}>FONDIR</option>
                                    <option value="FONDIRIGENTI" {{$company->fondo_dirigenti == 'FONDIRIGENTI' ? 'selected' : ''}}>FONDIRIGENTI</option>
                                </select>
                                {{--<input type="text" class="form-control" id="fondo_dirigenti" name="fondo_dirigenti" placeholder="{{ __('Es: Lorem ipsum') }}" value="{{$company->fondo_dirigenti}}">--}}
                            </div>
                            <div class="form-group {{ $company->privato ? 'd-none' : '' }}" data-company>
                                <label for="fondo_non_dirigenti">{{ __('Fondo non dirigenti') }}</label>
                                <select id="fondo_non_dirigenti" name="fondo_non_dirigenti" class="form-control">
                                    <option></option>
                                    <option value="FONDIMPRESA" {{$company->fondo_non_dirigenti == 'FONDIMPRESA' ? 'selected' : ''}}>FONDIMPRESA</option>
                                    <option value="FORTE" {{$company->fondo_non_dirigenti == 'FORTE' ? 'selected' : ''}}>FORTE</option>
                                    <option value="FONDOBANCHE" {{$company->fondo_non_dirigenti == 'FONDOBANCHE' ? 'selected' : ''}}>FONDOBANCHE</option>
                                    <option value="FONARCOM" {{$company->fondo_non_dirigenti == 'FONARCOM' ? 'selected' : ''}}>FONARCOM</option>
                                    <option value="FORMAZIENDA" {{$company->fondo_non_dirigenti == 'FORMAZIENDA' ? 'selected' : ''}}>FORMAZIENDA</option>
                                    <option value="FONTER" {{$company->fondo_non_dirigenti == 'FONTER' ? 'selected' : ''}}>FONTER</option>
                                    <option value="FONDARTIGIANATO" {{$company->fondo_non_dirigenti == 'FONDARTIGIANATO' ? 'selected' : ''}}>FONDARTIGIANATO</option>
                                    <option value="FONDOPMI" {{$company->fondo_non_dirigenti == 'FONDOPMI' ? 'selected' : ''}}>FONDOPMI</option>
                                    <option value="FONDITALIA" {{$company->fondo_non_dirigenti == 'FONDITALIA' ? 'selected' : ''}}>FONDITALIA</option>
                                    <option value="FONDOPROFESSIONI" {{$company->fondo_non_dirigenti == 'FONDOPROFESSIONI' ? 'selected' : ''}}>FONDOPROFESSIONI</option>
                                    <option value="FONDOLAVORO" {{$company->fondo_non_dirigenti == 'FONDOLAVORO' ? 'selected' : ''}}>FONDOLAVORO</option>
                                    <option value="FONCOOP" {{$company->fondo_non_dirigenti == 'FONCOOP' ? 'selected' : ''}}>FONCOOP</option>
                                </select>
                            </div>
                            <div class="form-check mb-5 {{ $company->privato ? 'd-none' : '' }}" data-company>
                                <input type="checkbox" name="rsa_rsu" id="rsa_rsu" class="form-check-input" {{$company->rsa_rsu ? 'checked' : ''}}>
                                <label class="form-check-label" for="rsa_rsu">{{ __('RSA/RSU') }}</label>
                            </div>
                            <div class="form-group {{ $company->privato ? 'd-none' : '' }}" data-company>
                                <label for="fornitori_attuali">{{ __('Fornitori attuali') }}</label>
                                <textarea id="fornitori_attuali" name="fornitori_attuali" class="form-control">{!!$company->fornitori_attuali!!}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group {{ $company->privato ? 'd-none' : '' }}" data-company>
                                        <label for="potenziale_fatturato_formazione">{{ __('Potenziale Fatturato formazione') }}</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control number_format" id="potenziale_fatturato_formazione" name="potenziale_fatturato_formazione" placeholder="{{ __('Es: 20.000') }}" value="{{$company->potenziale_fatturato_formazione}}">
                                            <span class="input-group-text">€</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group {{ $company->privato ? 'd-none' : '' }}" data-company>
                                        <label for="potenziale_fatturato_selezione">{{ __('Potenziale Fatturato selezione') }}</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control number_format" id="potenziale_fatturato_selezione" name="potenziale_fatturato_selezione" placeholder="{{ __('Es: 20.000') }}" value="{{$company->potenziale_fatturato_selezione}}">
                                            <span class="input-group-text">€</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group {{ $company->privato ? 'd-none' : '' }}" data-company>
                                        <label for="potenziale_fatturato_pal">{{ __('Potenziale Fatturato PAL') }}</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control number_format" id="potenziale_fatturato_pal" name="potenziale_fatturato_pal" placeholder="{{ __('Es: 20.000') }}" value="{{$company->potenziale_fatturato_pal}}">
                                            <span class="input-group-text">€</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group {{ $company->privato ? 'd-none' : '' }}" data-company>
                                        <label for="potenziale_fatturato_consulenza">{{ __('Potenziale Fatturato consulenza') }}</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control number_format" id="potenziale_fatturato_consulenza" name="potenziale_fatturato_consulenza" placeholder="{{ __('Es: 20.000') }}" value="{{$company->potenziale_fatturato_consulenza}}">
                                            <span class="input-group-text">€</span>
                                        </div>
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
            let obj = $(input).closest('.card-body');
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

    const removeRow = (el) => {
        $(el).closest('[data-sede]').remove();
    }

    const newSede = () => {
        let clone = $('[data-sede]').closest('.card-body').children().first().clone();
        $(clone).find('input').val('');
        $(clone).removeClass('d-none');
        $('[data-sede]').closest('.card-body').append($(clone));
        let input = $('.autocomplete');
        for (i = 0; i < input.length; i++) {
            createAutocomplete(input[i], i);
        }
    }

    $(document).ready(function(){

        let input = $('.autocomplete');
        for (i = 0; i < input.length; i++) {
            createAutocomplete(input[i], i);
        }
        
        if($('#tipo').val() == 'da ricontattare') {
            $('#data_ricontattare').parent('.form-group').removeClass('d-none');
        }
        if(!$('#privato').is(':checked')) {
            $('[data-company]').removeClass('d-none');
            //$('[data-company]').parents('.card-show').removeClass('d-none');
        } else {
            $('[data-company]').addClass('d-none');
            //$('[data-company]').parents('.card-show').addClass('d-none');
        }
        $('#privato').change(function() {
            if(!$(this).is(':checked')) {
                $('[data-company]').removeClass('d-none');
                //$('[data-company]').parents('.card-show').removeClass('d-none');
            } else {
                $('[data-company]').addClass('d-none');
                //$('[data-company]').parents('.card-show').addClass('d-none');
            }
        });
        $('#tipo').on('change',function(){
            if($(this).val() == 'da ricontattare') {
                $('#data_ricontattare').parent('.form-group').removeClass('d-none');
            } else {
                $('#data_ricontattare').parent('.form-group').addClass('d-none');
            }
        })
    });
</script>
@endsection