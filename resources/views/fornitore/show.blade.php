@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1>Vedi Consulente/Docente</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('fornitori.index') }}">Consulenti/Docenti</a></li>
                <li class="breadcrumb-item active">{{ $fornitore->rag_soc }}</li>
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
                    <h3 class="mb-0">{{ $fornitore->rag_soc }}</h3>
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item"><a class="nav-link active" href="#dati" data-toggle="tab">Dati docente/consulente</a></li>
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
                                        <label for="company">Ragione sociale</label>
                                        <p class="text-capitalize">{{ $fornitore->rag_soc }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Telefono</label>
                                        <p>{{ $fornitore->telefono ? $fornitore->telefono : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Cellulare</label>
                                        <p>{{ $fornitore->cellulare ? $fornitore->cellulare : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Email</label>
                                        <p>{{ $fornitore->email ? $fornitore->email : '---' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Codice fiscale</label>
                                        <p class="text-uppercase">{{ $fornitore->codice_fiscale ? $fornitore->codice_fiscale : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Partita IVA</label>
                                        <p>{{ $fornitore->partita_iva ? $fornitore->partita_iva : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Assegnato a</label>
                                        <p class="text-capitalize">{{ $fornitore->user ? $fornitore->user->name : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Disciplina</label>
                                        <p>{{ implode(", ",$fornitore->discipline) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="company">Note</label>
                                        <p>{{ $fornitore->note ? $fornitore->note : '---' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Via</label>
                                        <p class="text-capitalize">{{ $fornitore->via ? $fornitore->via : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Comune</label>
                                        <p class="text-capitalize">{{ $fornitore->comune ? $fornitore->comune : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Provincia</label>
                                        <p class="text-capitalize">{{ $fornitore->provincia ? $fornitore->provincia : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">CAP</label>
                                        <p>{{ $fornitore->cap ? $fornitore->cap : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Nazione</label>
                                        <p>{{ $fornitore->nazione ? $fornitore->nazione : '---' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <a class="btn btn-primary btn-float" href="{{ route('fornitori.edit', $fornitore->id) }}">Modifica</a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="incarichi">
                            <a href="{{ route('incarichi.create') }}" class="mb-3 btn btn-success">Crea incarico</a>
                            <table id="datatables" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Codice') }}</th>
                                        <th>{{ __('Commessa') }}</th>
                                        <th>{{ __('Offerta') }}</th>
                                        <th>{{ __('Responsabile') }}</th>
                                        <th>{{ __('Assegnato') }}</th>
                                        <th class="no-sort">{{ __('Azioni') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $fornitore->incarichi as $incarico )
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td><a href="{{ route('incarichi.edit', $incarico->id) }}">{{ $incarico->codice }}</a></td>
                                        <td>{{ $incarico->commessa->codice }}</td>
                                        <td><a href="{{ route('offerte.show', $incarico->offerta->id) }}">{{ $incarico->offerta->codice }}</a></td>
                                        <td class="text-capitalize">{{ $incarico->resp->name }}</td>
                                        <td class="text-capitalize">{{ $incarico->ass->name }}</td>
                                        <td>
                                            <a class="btn btn-sm  btn-info" href="{{ route('incarichi.edit', $incarico->id) }}">
                                                <i class="fas fa-pencil-alt"></i>
                                                Vedi
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