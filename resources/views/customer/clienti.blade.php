@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1>{{ __('Clienti') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Clienti</a></li>
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
                    {{ __('Clienti') }}
                    <div class="ml-auto">
                        <a href="{{ route('customer.export_clienti') }}" class="btn btn-info btn-sm"><i class="fa fa-download"></i> {{ __('Esporta XLS') }}</a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ session('status') }}
                        </div>
                    @endif

                    <table id="datatables" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Azienda') }}</th>
                                <th>{{ __('Telefono') }}</th>
                                <th>{{ __('Provincia legale') }}</th>
                                <th>{{ __('Responsabile contatto') }}</th>
                                <th>{{ __('Privato') }}</th>
                                <th class="no-sort">{{ __('Azioni') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $clienti as $cliente )
                            <tr>
                                <td>{{ $cliente->id }}</td>
                                <td><a href="{{ route('cliente.show', ['id' => $cliente->id]) }}" class="text-capitalize">{{ $cliente->rag_soc }}</a></td>
                                <td>{{ $cliente->phone }}</td>
                                <td>{{ $cliente->provincia_legale }}</td>
                                <td class="text-capitalize">{{ $cliente->user ? $cliente->user->name : '' }}</td>
                                <td>{{ $cliente->privato != 1 ? 'No' : 'Sì' }}</td>
                                <td>
                                    <a class="btn btn-success btn-sm mr-1" href="{{ route('cliente.show', ['id' => $cliente->id]) }}">
                                        <i class="fas fa-eye"></i>
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
@endsection