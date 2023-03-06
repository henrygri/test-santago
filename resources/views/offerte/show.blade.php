@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1>Vedi Offerta</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('offerte.index') }}">Offerte</a></li>
                <li class="breadcrumb-item active">{{ $offerta->codice }}</li>
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
                    <h3 class="mb-0">{{ $offerta->codice }}</h3>
                    <a href="{{ route('offerte.accept', $offerta->id) }}" class="btn btn-success ml-4">Accetta offerta</a>
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item"><a class="nav-link active" href="#dati" data-toggle="tab">Dati offerta</a></li>
                        <li class="nav-item"><a class="nav-link" href="#azienda" data-toggle="tab">Azienda</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contatti" data-toggle="tab">Contatti</a></li>
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
                        <div class="tab-pane active" id="dati">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Codice</label>
                                        <p>{{ $offerta->codice }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Azienda</label>
                                        <p class="text-capitalize"><a href="{{ route('aziende.show', $offerta->company->id) }}">{{ $offerta->company ? $offerta->company->rag_soc : '---' }}</a></p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Referente azienda</label>
                                        <p class="text-capitalize">
                                            @if($offerta->customer )
                                            <a href="{{ route('clienti.show', ['stato' => $offerta->customer->stato, 'id' => $offerta->customer->id]) }}">{{$offerta->customer->nome . ' '. $offerta->customer->cognome}}</a>
                                            @else
                                            ----
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Responsabile offerta</label>
                                        <p class="text-capitalize">{{ $offerta->user ? $offerta->user->name : '---' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label for="company">Descrizione offerta</label>
                                    <p>{{ $offerta->description ? $offerta->description : '---' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Tipologia servizi</label>
                                        <p class="text-capitalize">{{ $offerta->services ? implode(", ",$offerta->services) : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Stato</label>
                                        <p class="text-uppercase"><span style="background-color:{{getColorStatoOfferta($offerta->stato)}}">{{ $offerta->stato ? $offerta->stato : '---' }}</span></p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Data richiesta preventivo</label>
                                        <p>{{ $offerta->data_richiesta_preventivo ? formatDate($offerta->data_richiesta_preventivo) : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Data scadenza preventivo</label>
                                        <p>{{ $offerta->data_scadenza_preventivo ? formatDate($offerta->data_scadenza_preventivo) : '---' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Valore totale</label>
                                        <p>{{ $offerta->val_offerta_tot ? $offerta->val_offerta_tot .' €' : '---' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @if($offerta->finanziamento)
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="company">Valore offerta non finanziato</label>
                                        <p>{{ $offerta->val_offerta_no_finanz ? $offerta->val_offerta_no_finanz .' €' : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="company">Valore offerta finanziato</label>
                                        <p>{{ $offerta->val_offerta_finanz ? $offerta->val_offerta_finanz .' €' : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="company">Individuale/Gruppo</label>
                                        <p class="text-capitalize">{{ $offerta->individuale_gruppo ? $offerta->individuale_gruppo : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="company">Codice piano/bando</label>
                                        <p><a href="{{ route('bandi.edit', $offerta->bando_id) }}">{{ $offerta->bando ? $offerta->bando->codice : '---' }}</a></p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="company">Corso</label>
                                        <p>
                                            @if($offerta->corso_id)
                                            <a href="{{ route('corsi.edit', $offerta->corso_id) }}">{{ $offerta->corso ? $offerta->corso->titolo : '---' }} ({{$offerta->corso->ore}} ore) </a>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="company">Edizione</label>
                                        <p>{{ $offerta->n_edizione ? $offerta->n_edizione : '---' }}</a></p>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="company">Note</label>
                                        <p>{{ $offerta->note ? $offerta->note : '---' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <a class="btn btn-primary btn-float" href="{{ route('offerte.edit', $offerta->id) }}">Modifica</a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="azienda">
                            <table id="datatables" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Ragione sociale</th>
                                        <th>Responsabile contatto</th>
                                        <th class="no-sort">{{ __('Azioni') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td class="text-capitalize"><a href="{{ route('aziende.show', $offerta->company->id) }}">{{ $offerta->company->rag_soc }}</a></td>
                                        <td class="text-capitalize">{{ $offerta->company->user ? $offerta->company->user->name : '---' }}</td>
                                        <td>
                                            <a class="btn btn-info btn-sm mr-1" href="{{ route('aziende.show', $offerta->company->id) }}">
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
                                        <td>1</td>
                                        <td class="text-capitalize"><a href="{{ route('clienti.show', [ 'contattato', $offerta->customer->id]) }}">{{ $offerta->customer ? $offerta->customer->nome . ' ' . $offerta->customer->cognome : '---' }}</a></td>
                                        <td>{{ $offerta->customer ? $offerta->customer->email : '---' }}</td>
                                        <td>{{ $offerta->customer ? $offerta->customer->telefono_personale : '---' }}</td>
                                        <td class="text-capitalize"><a href="{{ route('aziende.show', $offerta->customer->company_id) }}">{{ $offerta->customer->company ? $offerta->customer->company->rag_soc : '---' }}</a></td>
                                        <td class="text-capitalize">{{ $offerta->customer->user ? $offerta->customer->user->name : '---' }}</td>
                                        <td class="text-capitalize">{{ $offerta->customer ? $offerta->customer->sorgente_acquisizione : '---' }}</td>
                                        <td>{{ $offerta->customer ? formatDate($offerta->customer->data_creazione_lead) : '---' }}</td>
                                        {{--<td>{{ $offerta->customer ? $offerta->customer->stato_cliente : '---' }}</td>--}}
                                        <td class="text-uppercase">
                                            @if($offerta->customer)
                                            <span style="background-color:{{getColorStatoCliente($offerta->customer->stato_cliente)}}">{{ formatStatoCliente($offerta->customer->stato_cliente) }}</span>
                                            @else
                                            ---
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-info btn-sm mr-1" href="{{ route('clienti.show', [ 'contattato', $offerta->customer->id]) }}">
                                                <i class="fas fa-pencil-alt"></i>
                                                {{ __('Vedi') }}
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="commesse">
                            <a href="{{ url('offerta/'.$offerta->id.'/commessa') }}" class="mb-3 btn btn-success">Crea commessa</a>
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
                                    @foreach ($offerta->commesse as $commessa )             
                                    <tr>
                                        <td>1</td>
                                        <td><a href="{{ route('commesse.show', $commessa->id) }}">{{ $commessa->codice }}</a></td>
                                        <td><a href="{{ route('aziende.show', $commessa->company->id) }}">{{ $commessa->company->rag_soc }}</a></td>
                                        <td>{{ $commessa->val_iniziale }}</td>
                                        <td>{{ formatDate($commessa->created_at) }}</td>
                                        <td class="text-uppercase"><span style="background-color:{{getColorStatoCommessa($commessa->stato)}}">{{ $commessa->stato == 0 ? 'aperta' : 'chiusa' }}</span></td>
                                        <td class="text-capitalize">{{ $commessa->user ? $commessa->user->name : '---' }}</td>
                                        <td>
                                            <a class="btn btn-info btn-sm mr-1" href="{{ route('commesse.show', $commessa->id) }}">
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