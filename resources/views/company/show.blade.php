@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1>Vedi Azienda</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('aziende.index') }}">Aziende</a></li>
                <li class="breadcrumb-item active text-capitalize">{{$company->rag_soc}} </li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid pt-3">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h3 class="mb-0 text-capitalize">{{ $company->rag_soc }}</h3>
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item"><a class="nav-link active" href="#azienda" data-toggle="tab">Azienda</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contatti" data-toggle="tab">Contatti</a></li>
                        <li class="nav-item"><a class="nav-link" href="#offerte" data-toggle="tab">Offerte</a></li>
                        <li class="nav-item"><a class="nav-link" href="#commesse" data-toggle="tab">Commesse</a></li>
                    </ul>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="tab-content">
                        <div class="tab-pane active" id="azienda">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Ragione sociale</label>
                                        <p class="text-capitalize">{{ $company->rag_soc }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Partita IVA</label>
                                        <p>{{ $company->p_iva ? $company->p_iva : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Codice fiscale</label>
                                        <p>{{ $company->cod_fisc ? $company->cod_fisc : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Assegnato a</label>
                                        <p class="text-capitalize">{{ $company->user ? $company->user->name : '---' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Settore</label>
                                        <p class="text-capitalize">{{ $company->settore ? $company->settore->nome : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Tipo</label>
                                        <p class="text-capitalize">{{ $company->tipo ? $company->tipo : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Telefono</label>
                                        <p>{{ $company->phone ? $company->phone : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Come ci hai consociuto</label>
                                        <p class="text-capitalize">{{ $company->come_ci_ha_conosciuto ? $company->come_ci_ha_conosciuto : '---' }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            @if($company->privato != 1)
                           
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Fondo dirigenti</label>
                                        <p>{{ $company->fondo_dirigenti ? $company->fondo_dirigenti : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Fondo non dirigenti</label>
                                        <p>{{ $company->fondo_non_dirigenti ? $company->fondo_non_dirigenti : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">RSA/RSU</label>
                                        <p>{{ $company->rsa_rsu ? 'Sì' : 'No' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Fornitori attuali</label>
                                        <p>{{ $company->fornitori_attuali ? $company->fornitori_attuali : '---' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">{{ __('Tipologia organizzativa') }}</label>
                                        <p class="text-capitalize">{{ $company->tipologia_organizzativa ? $company->tipologia_organizzativa : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">{{ __('Fatturato annuo') }}</label>
                                        <p>{{ $company->fatturato_annuo ? $company->fatturato_annuo . ' €' : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">{{ __('Numero dipendenti') }}</label>
                                        <p>{{ $company->n_dipendenti ? $company->n_dipendenti : '---'}}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">{{ __('Data contattato') }}</label>
                                        <p>{{ $company->data_contatto ? formatDate($company->data_contatto) : '---' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">{{ __('Potenziale Fatturato formazione') }}</label>
                                        <p>{{ $company->potenziale_fatturato_formazione ? $company->potenziale_fatturato_formazione . ' €' : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">{{ __('Potenziale Fatturato selezione') }}</label>
                                        <p>{{ $company->potenziale_fatturato_selezione ? $company->potenziale_fatturato_selezione . ' €' : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">{{ __('Potenziale Fatturato PAL') }}</label>
                                        <p>{{ $company->potenziale_fatturato_pal ? $company->potenziale_fatturato_pal . ' €' : '---'}}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">{{ __('Potenziale Fatturato consulenza') }}</label>
                                        <p>{{ $company->potenziale_fatturato_consulenza ? $company->potenziale_fatturato_consulenza . ' €' : '---' }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="card card-primary mt-3">
                                <div class="card-header">Sede legale</div>
                                <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="company">Indirizzo legale</label>
                                            <p class="text-capitalize">{{ $company->indirizzo_legale ? $company->indirizzo_legale : '---' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="company">Comune legale</label>
                                            <p class="text-capitalize">{{ $company->comune_legale ? $company->comune_legale : '---' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="company">Provincia legale</label>
                                            <p class="text-capitalize">{{ $company->provincia_legale ? $company->provincia_legale : '---'}}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="company">Cap legale</label>
                                            <p>{{ $company->cap_legale ? $company->cap_legale : '---' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="company">Regione legale</label>
                                            <p class="text-capitalize">{{ $company->regione_legale ? $company->regione_legale : '---' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="company">Nazione legale</label>
                                            <p class="text-capitalize">{{ $company->nazione_legale ? $company->nazione_legale : '---' }}</p>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            @if($company->privato != 1)
                            @if(!is_null($company->sedi))
                            <div class="card card-primary mt-3">
                                <div class="card-header">Sedi operative</div>
                                <div class="card-body">
                                    @foreach(json_decode($company->sedi) as $sede)
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="company">{{ __('Indirizzo operativo') }}</label>
                                                <p class="text-capitalize">{{ $sede->indirizzo_operativo ? $sede->indirizzo_operativo : '---' }}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="company">{{ __('Comune operativo') }}</label>
                                                <p class="text-capitalize">{{ $sede->comune_operativo ? $sede->comune_operativo : '---' }}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="company">{{ __('Provincia operativo') }}</label>
                                                <p class="text-capitalize">{{ $sede->provincia_operativo ? $sede->provincia_operativo : '---' }}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="company">{{ __('CAP operativo') }}</label>
                                                <p>{{ $sede->cap_operativo ? $sede->cap_operativo : '---' }}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="company">{{ __('Regione operativo') }}</label>
                                                <p class="text-capitalize">{{ $sede->regione_operativo ? $sede->regione_operativo : '---' }}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="company">{{ __('Nazione operativo') }}</label>
                                                <p class="text-capitalize">{{ $sede->nazione_operativo ? $sede->nazione_operativo : '---' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            @endif
                            <div class="row mt-2">
                                <div class="col-12">
                                    <a class="btn btn-primary btn-float" href="{{ route('aziende.edit', $company->id) }}">Modifica</a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="offerte">
                            <div class="row mb-3">
                                <div class="col-12">
                                    {{--<a href="{{ route('offerte.create') }}" class="btn btn-success">Crea offerta</a>--}}
                                    <a href="{{ url('azienda/'.$company->id.'/offerta') }}" class="btn btn-success">Crea offerta</a>
                                </div>
                            </div>
                            <table id="datatables" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Codice protocollo') }}</th>
                                        <th>{{ __('Azienda') }}</th>
                                        <th class="no-sort">{{ __('Descrizione') }}</th>
                                        <th>{{ __('Valore totale') }}</th>
                                        <th>{{ __('Resp. offerta') }}</th>
                                        <th>{{ __('Data emissione') }}</th>
                                        <th>{{ __('Stato') }}</th>
                                        <th>{{ __('Azioni') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $company->offerte as $offerta )
                                    <tr>
                                        <td>{{ $offerta->id }}</td>
                                        <td><a href="{{ route('offerte.show', $offerta->id) }}">{{ $offerta->codice }}</a></td>
                                        <td>{{ $offerta->company->rag_soc }}</td>
                                        <td>{{ $offerta->description }}</td>
                                        <td>{{ $offerta->val_offerta_tot }} €</td>
                                        <td class="text-capitalize">{{ $offerta->user->name }}</td>
                                        <td>{{ formatDate($offerta->data_richiesta_preventivo) }}</td>
                                        <td class="text-uppercase"><span style="background-color:{{getColorStatoOfferta($offerta->stato)}}">{{ $offerta->stato }}</span></td>
                                        <td>
                                            <a class="btn btn-info btn-sm mr-1" href="{{ route('offerte.edit', $offerta->id) }}">
                                                <i class="fas fa-pencil-alt"></i>
                                                {{ __('Vedi') }}
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="contatti">
                            <div class="row mb-3">
                                <div class="col-12">
                                    {{--<a href="{{ route('contatto.create', 'contattato') }}" class="btn btn-success">Crea contatto</a>--}}
                                    <a href="{{ url('azienda/'.$company->id.'/contatto') }}" class="btn btn-success">Crea contatto</a>
                                </div>
                            </div>
                            <table id="datatables2" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Nome') }}</th>
                                        <th>{{ __('Ruolo') }}</th>
                                        <th>{{ __('Email Privata') }}</th>
                                        <th>{{ __('Fonte') }}</th>
                                        <th class="no-sort">{{ __('Azioni') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $company->customers as $customer )
                                    <tr>
                                        <td>{{ $customer->id }}</td>
                                        <td class="text-capitalize"><a href="{{ route('clienti.show', ['stato' => $customer->stato, 'id' => $customer->id]) }}">{{ $customer->nome }} {{ $customer->cognome }}</a></td>
                                        <td class="text-capitalize">{{ $customer->ruolo_id ? $customer->ruolo->nome : '' }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td class="text-capitalize">{{ $customer->sorgente_acquisizione }}</td>
                                        <td>
                                            <a class="btn btn-info btn-sm mr-1" href="{{ route('clienti.show', ['stato' => $customer->stato, 'id' => $customer->id]) }}">
                                                <i class="fas fa-pencil-alt"></i>
                                                {{ __('Vedi') }}
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="commesse">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <a href="{{ route('commesse.create') }}" class="btn btn-success">Crea commessa</a>
                                </div>
                            </div>
                            <table id="datatables3" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Cod. Commessa') }}</th>
                                        <th>{{ __('Azienda') }}</th>
                                        <th>{{ __('Valore iniziale') }}</th>
                                        <th>{{ __('Data apertura') }}</th>
                                        <th>{{ __('Stato') }}</th>
                                        <th>{{ __('Referente interno') }}</th>
                                        <th class="no-sort">{{ __('Azioni') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $company->commesse as $commessa )
                                    <tr>
                                    <td>{{ $commessa->id }}</td>
                                    <td><a href="{{ route('commesse.show', $commessa->id) }}">{{ $commessa->codice }}</a></td>
                                    <td><a href="{{ route('aziende.show', $commessa->company->id) }}">{{ $commessa->company->rag_soc }}</a></td>
                                    <td>{{ $commessa->val_iniziale.' €' }}</td>
                                    <td>{{ formatDate($commessa->created_at) }}</td>
                                    <td class="text-uppercase"><span style="background-color:{{getColorStatoCommessa($commessa->stato)}}">{{ $commessa->stato == 0 ? 'aperta' : 'chiusa' }}</span></td>
                                    <td>{{ $commessa->user ? $commessa->user->name : '---' }}</td>
                                        <td>
                                            <a class="btn btn-info btn-sm mr-1" href="{{ route('commesse.edit', $commessa->id) }}">
                                                <i class="fas fa-pencil-alt"></i>
                                                {{ __('Vedi') }}
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection