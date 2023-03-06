@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1>Vedi Commessa</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('offerte.index') }}">Commesse</a></li>
                <li class="breadcrumb-item active">{{ $commessa->codice }}</li>
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
                    <h3 class="mb-0">{{ $commessa->codice }}</h3>
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item"><a class="nav-link active" href="#dati" data-toggle="tab">Dati commessa</a></li>
                        <li class="nav-item"><a class="nav-link" href="#azienda" data-toggle="tab">Azienda</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contatti" data-toggle="tab">Contatti</a></li>
                        <li class="nav-item"><a class="nav-link" href="#offerte" data-toggle="tab">Offerte</a></li>
                        <li class="nav-item"><a class="nav-link" href="#incarichi" data-toggle="tab">Incarichi</a></li>
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
                        <div class="tab-pane active" id="dati">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Codice</label>
                                        <p>{{ $commessa->codice }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Stato</label>
                                        <p class="text-uppercase"><span style="background-color:{{getColorStatoCommessa($commessa->stato)}}">{{ $commessa->stato }}</span></p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Offerta</label>
                                        <p><a href="{{ route('offerte.show', $commessa->offerta_id) }}">{{ $commessa->offerta ? $commessa->offerta->codice : '---' }}</a></p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Azienda</label>
                                        <p class="text-capitalize"><a href="{{ route('aziende.show', $commessa->company_id) }}">{{ $commessa->company ? $commessa->company->rag_soc : '---' }}</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="company">Responsabile commessa</label>
                                        <p class="text-capitalize">{{ $commessa->user ? $commessa->user->name : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="company">Servizi</label>
                                        <p class="text-capitalize">{{ implode(', ',$commessa->services) }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="company">Contatto che segue la commessa</label>
                                        <p class="text-capitalize">
                                            @if($commessa->customer )
                                            <a href="{{ route('clienti.show', ['stato' => $commessa->customer->stato, 'id' => $commessa->customer->id]) }}">{{$commessa->customer->nome . ' '. $commessa->customer->cognome}}</a>
                                            @else
                                            ----
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="company">Data apertura</label>
                                        <p>{{ $commessa->data_apertura ? formatDate($commessa->data_apertura) : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="company">Data stimata chiusura</label>
                                        <p>{{ $commessa->data_stim_chiusura ? formatDate($commessa->data_stim_chiusura) : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="company">Data effettiva chiusura</label>
                                        <p>{{ $commessa->data_effettiva_chiusura ? formatDate($commessa->data_effettiva_chiusura) : '---' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Valore inziale</label>
                                        <p>{{ $commessa->val_iniziale ? $commessa->val_iniziale .' €' : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Valore finale</label>
                                        <p>{{ $commessa->val_finale ? $commessa->val_finale .' €' : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Valore finanziato</label>
                                        <p>{{ $commessa->val_no_finanz ? $commessa->val_finanz .' €' : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Valore non finanziato</label>
                                        <p>{{ $commessa->val_no_finanz ? $commessa->val_no_finanz .' €' : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="company">Individuale/Gruppo</label>
                                        <p class="text-capitalize">{{ $commessa->offerta->individuale_gruppo ? $commessa->offerta->individuale_gruppo : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="company">Codice piano/bando</label>
                                        <p>
                                            @if($commessa->offerta->bando_id)
                                            <a href="{{ route('bandi.edit', $commessa->offerta->bando_id) }}">{{ $commessa->offerta->bando_id ? $commessa->offerta->bando->codice : '---' }}</a>
                                            @else
                                            ---
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="company">Corso</label>
                                        <p>
                                            @if($commessa->offerta->corso_id)
                                            <a href="{{ route('corsi.edit', $commessa->offerta->corso_id) }}">{{ $commessa->offerta->corso_id ? $commessa->offerta->corso->titolo : '---' }} ({{ $commessa->offerta->corso->ore }} ore)</a>
                                            @else
                                            ---
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="company">Edizione</label>
                                        <p>
                                            @if($commessa->offerta->n_edizione)
                                            {{ $commessa->offerta->n_edizione ? $commessa->offerta->n_edizione : '---' }}
                                            @else
                                            ---
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="company">Descrizione</label>
                                        <p>{{ $commessa->description ? $commessa->description : '---' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <a class="btn btn-primary btn-float" href="{{ route('commesse.edit', $commessa->id) }}">Modifica</a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="azienda">
                            <table id="datatables" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Ragione Sociale') }}</th>
                                        <th>{{ __('Responsabile contatto') }}</th>
                                        <th class="no-sort">{{ __('Azioni') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $commessa->company_id }}</td>
                                        <td class="text-capitalize"><a href="{{ route('aziende.show', $commessa->company->id) }}">{{ $commessa->company ? $commessa->company->rag_soc : '---' }}</a></td>
                                        <td class="text-capitalize">{{ $commessa->company->user ? $commessa->company->user->name : '---' }}</td>
                                        <td>
                                            <a class="btn btn-info btn-sm mr-1" href="{{ route('aziende.show', $commessa->company->id) }}">
                                                <i class="fas fa-pencil-alt"></i>
                                                {{ __('Vedi') }}
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="contatti">
                            <table id="datatables2" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Nome') }}</th>
                                        <th>{{ __('Email Privata') }}</th>
                                        <th>{{ __('Telefono') }}</th>
                                        <th>{{ __('Azienda') }}</th>
                                        <th>{{ __('Responsabile contatto') }}</th>
                                        <th>{{ __('Fonte') }}</th>
                                        <th>{{ __('Data creazione') }}</th>
                                        <th>{{ __('Stato') }}</th>
                                        <th class="no-sort">{{ __('Azioni') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $commessa->customer_id }}</td>
                                        <td class="text-capitalize"><a href="{{ route('clienti.show', [ 'contattato', $commessa->customer->id ] ) }}">{{ $commessa->customer ? $commessa->customer->nome .' '.$commessa->customer->cognome : '---' }}</a></td>
                                        <td>{{ $commessa->customer ? $commessa->customer->email : '---' }}</td>
                                        <td>{{ $commessa->customer ? $commessa->customer->telefono_personale : '---' }}</td>
                                        <td class="text-capitalize"><a href="{{ route('aziende.show', $commessa->customer->company_id) }}">{{ $commessa->customer->company ? $commessa->customer->company->rag_soc : '---' }}</a></td>
                                        <td class="text-capitalize">{{ $commessa->customer->user ? $commessa->customer->user->name : '---' }}</td>
                                        <td class="text-capitalize">{{ $commessa->customer ? $commessa->customer->sorgente_acquisizione : '---' }}</td>
                                        <td>{{ $commessa->customer ? formatDate($commessa->customer->data_creazione_lead) : '---' }}</td>
                                        {{--<td>{{ $commessa->customer ? $commessa->customer->stato_cliente : '---' }}</td>--}}
                                        <td class="text-uppercase">
                                            @if($commessa->customer)
                                            <span style="background-color:{{getColorStatoCliente($commessa->customer->stato_cliente)}}">{{ formatStatoCliente($commessa->customer->stato_cliente) }}</span>
                                            @else
                                            ---
                                            @endif
                                        </td>
                                        <td></td>
                                        <td>
                                            <a class="btn btn-info btn-sm mr-1" href="{{ route('clienti.show', [ 'contattato', $commessa->customer->id ] ) }}">
                                                <i class="fas fa-pencil-alt"></i>
                                                {{ __('Vedi') }}
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="incarichi">
                            <a href="{{ url('commessa/'.$commessa->id.'/incarico') }}" class="mb-3 btn btn-success">Crea Incarico</a>
                            <table id="datatables3" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Codice') }}</th>
                                        <th>{{ __('Fornitore') }}</th>
                                        <th>{{ __('Valore totale') }}</th>
                                        <th>{{ __('Responsabile') }}</th>
                                        <th>{{ __('Assegnato') }}</th>
                                        <th class="no-sort">{{ __('Azioni') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $commessa->incarichi as $incarico)
                                    <tr>
                                        <td>{{ $incarico->id }}</td>
                                        <td><a href="{{ route('incarichi.edit', $incarico->id) }}">{{ $incarico->codice }}</a></td>
                                        <td class="text-capitalize"><a href="{{ route('fornitori.show', $incarico->fornitore->id) }}">{{ $incarico->fornitore->rag_soc }}</a></td>
                                        <td>{{ $incarico->costo_orario * $incarico->ore }} €</td>
                                        <td class="text-capitalize">{{ $incarico->resp->name }}</td>
                                        <td class="text-capitalize">{{ $incarico->ass->name }}</td>
                                        <td>
                                            <a class="btn btn-info btn-sm mr-1" href="{{ route('incarichi.edit', $incarico->id) }}">
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
                            <table id="datatables3" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Codice</th>
                                        <th>{{ __('Azienda') }}</th>
                                        <th>{{ __('Servizio') }}</th>
                                        <th class="no-sort">{{ __('Descrizione') }}</th>
                                        <th>{{ __('Valore totale') }}</th>
                                        <th>{{ __('Resp. offerta') }}</th>
                                        <th>{{ __('Data emissione') }}</th>
                                        <th>{{ __('Stato') }}</th>
                                        <th class="no-sort">{{ __('Azioni') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $commessa->offerta_id }}</td>
                                        <td><a href="{{ route('offerte.show', $commessa->offerta->id) }}">{{ $commessa->offerta->codice }}</a></td>
                                        <td class="text-capitalize"><a href="{{ route('aziende.show', $commessa->offerta->company_id) }}">{{ $commessa->offerta->company->rag_soc }}</a></td>
                                        <td class="text-capitalize">{{ implode(", ", $commessa->services) }}</td>
                                        <td>{{ $commessa->offerta->description }}</td>
                                        <td>{{ $commessa->offerta->val_offerta_tot }} €</td>
                                        <td class="text-capitalize">{{ $commessa->offerta->user->name }}</td>
                                        <td>{{ formatDate($commessa->offerta->data_richiesta_preventivo) }}</td>
                                        <td class="text-uppercase"><span style="background-color:{{getColorStatoOfferta($commessa->offerta->stato)}}">{{ $commessa->offerta->stato }}</span></td>
                                        <td>
                                            <a class="btn btn-info btn-sm mr-1" href="{{ route('offerte.show', $commessa->offerta->id) }}">
                                                <i class="fas fa-pencil-alt"></i>
                                                {{ __('Vedi') }}
                                            </a>
                                        </td>
                                    </tr>
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