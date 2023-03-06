@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1>{{ __('Prospect') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="/list/prospect">{{ __('Prospect') }}</a></li>
                <li class="breadcrumb-item active">Vedi Prospect</a></li>
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
                                        <p>{{ $company->p_iva }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Codice fiscale</label>
                                        <p>{{ $company->cod_fisc }}</p>
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
                                        <label for="company">Indirizzo legale</label>
                                        <p class="text-capitalize">{{ $company->indirizzo_legale }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Comune legale</label>
                                        <p class="text-capitalize">{{ $company->comune_legale }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Provincia legale</label>
                                        <p class="text-capitalize">{{ $company->provincia_legale }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Cap legale</label>
                                        <p>{{ $company->cap_legale }}</p>
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
                                        <p>{{ $company->fatturato_annuo ? $company->fatturato_annuo .' €' : '---' }}</p>
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
                            <div class="row mt-2">
                                <div class="col-12">
                                    <a class="btn btn-primary btn-float" href="{{ route('aziende.edit', $company->id) }}">Modifica</a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="contatti">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <a href="{{ route('contatto.create', 'contattato') }}" class="btn btn-success">Crea contatto</a>
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
                                        <td><a href="{{ route('clienti.edit', ['stato' => $customer->stato, 'id' => $customer->id]) }}">{{ $customer->nome }} {{ $customer->cognome }}</a></td>
                                        <td class="text-capitalize">{{ $customer->ruolo_id ? \Str::limit($customer->ruolo->nome, 10, '...') : '' }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td class="text-capitalize">{{ $customer->sorgente_acquisizione }}</td>
                                        <td>
                                            <a class="btn btn-info btn-sm mr-1" href="{{ route('clienti.edit', ['stato' => $customer->stato, 'id' => $customer->id]) }}">
                                                <i class="fas fa-pencil-alt"></i>
                                                {{ __('Vedi') }}
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                                        <td><a href="{{ route('offerte.edit', $offerta->id) }}">{{ $offerta->codice }}</a></td>
                                        <td><a href="{{ route('aziende.show', $offerta->company_id) }}">{{ $offerta->company->rag_soc }}</a></td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection