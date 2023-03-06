@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1>Vedi Piano/Bando</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('bandi.index') }}">Piani/Bandi</a></li>
                <li class="breadcrumb-item active">{{ $bando->codice }}</li>
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
                    <h3 class="mb-0">{{ $bando->codice }}</h3>
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item"><a class="nav-link active" href="#dati" data-toggle="tab">Dati piano/bando</a></li>
                        <li class="nav-item"><a class="nav-link" href="#corsi" data-toggle="tab">Corsi</a></li>
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
                                        <label for="company">Fondo/Ente</label>
                                        <p class="text-capitalize">{{ $bando->nome }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Codice</label>
                                        <p>{{ $bando->codice }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Data apertura</label>
                                        <p>{{ formatDate($bando->data_apertura) }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Data chiusura</label>
                                        <p class="text-capitalize">{{ formatDate($bando->data_chiusura) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Data chiusura prorogata</label>
                                        <p class="text-capitalize">{{ $bando->data_chiusura_prorogata ? formatDate($bando->data_chiusura_prorogata) : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Monte ore</label>
                                        <p class="text-capitalize">{{ $bando->monte_ore ? $bando->monte_ore . ' h' : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Valore iniziale</label>
                                        <p class="text-capitalize">{{ $bando->monte_ore ? $bando->valore_iniziale . ' €' : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="company">Valore finale</label>
                                        <p class="text-capitalize">{{ $bando->valore_finale ? $bando->valore_finale . ' €' : '---' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="noe">{{ __('Note') }}</label>
                                        <p>{{ $bando->note ? $bando->note : '---' }}</p>
                                    </div>
                                </div>
                            </div> 
                            <div class="row mt-2">
                                <div class="col-12">
                                    <a class="btn btn-primary btn-float" href="{{ route('bandi.edit', $bando->id) }}">Modifica</a>
                                </div>
                            </div>   
                        </div>
                        <div class="tab-pane" id="corsi">
                            <a href="{{ route('corsi.create') }}" class="mb-3 btn btn-success">Crea corso</a>
                            <table id="datatables" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Titolo corso') }}</th>
                                        <th>{{ __('N. Edizioni') }}</th>
                                        <th>{{ __('Ore per edizione') }}</th>
                                        <th>{{ __('Totale ore') }}</th>
                                        <th class="no-sort">{{ __('Azioni') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ( $corsi as $corso )
                                <tr data-id="{{$corso->id}}">
                                    <td>{{ $corso->id }}</td>
                                    <td class="text-capitalize"><a href="{{ route('corsi.edit', $corso->id) }}">{{ $corso->titolo }}</a></td>
                                    <td>{{ $corso->edizioni }}</td>
                                    <td>{{ $corso->ore . 'h' }}</td>
                                    <td>{{ $corso->edizioni * $corso->ore . 'h' }}</td>
                                    <td>
                                        <a class="btn btn-info btn-sm mr-1" href="{{ route('corsi.edit', $corso->id) }}">
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