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
                <li class="breadcrumb-item active">{{ __('Prospect') }}</li>
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
                    {{ __('Prospect') }}
                    <div class="ml-auto">
                        <a href="{{ route('customer.export_prospect') }}" class="btn btn-info btn-sm"><i class="fa fa-download"></i> {{ __('Esporta XLS') }}</a>
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
                            @foreach ( $prospects as $prospect )
                            <tr>
                                <td>{{ $prospect->id }}</td>
                                <td><a href="{{ route('prospect.show', ['id' => $prospect->id]) }}" class="text-capitalize">{{ $prospect->rag_soc }}</a></td>
                                <td>{{ $prospect->phone }}</td>
                                <td>{{ $prospect->provincia_legale }}</td>
                                <td>{{ $prospect->user ? $prospect->user->name : '' }}</td>
                                <td>{{ $prospect->privato != 1 ? 'No' : 'Sì' }}</td>
                                <td>
                                    <a class="btn btn-success btn-sm mr-1" href="{{ route('prospect.show', ['id' => $prospect->id]) }}">
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