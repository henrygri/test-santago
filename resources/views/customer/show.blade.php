@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1 class="text-capitalize">{{ $customer->nome }} {{ $customer->cognome }} - ({{$stato == 'contattato' ? 'Contatto' : $stato}})</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item text-capitalize"><a href="/list/{{$stato}}">{{$customer->stato == 'contattato' ? 'Contatto' : $customer->stato}}</a></li>
                <li class="breadcrumb-item active text-capitalize">{{ $customer->nome }} {{ $customer->cognome }}</li>
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
                    <h3 class="mb-0 text-capitalize">{{ $customer->nome }} {{ $customer->cognome }}</h3>
                    @if($stato === 'lead')
                        <a href="{{ route('clienti.convert', $customer->id) }}" class="btn btn-success ml-4">Converti in contatto</a>
                    @endif
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item"><a class="nav-link active" href="#dati" data-toggle="tab">Dati {{$stato == 'contattato' ? 'Contatto' : $stato}}</a></li>
                        <li class="nav-item"><a class="nav-link" href="#azienda" data-toggle="tab">Azienda</a></li>
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
                                        <label for="customer">Nome e cognome</label>
                                        <p class="text-capitalize">{{ $customer->nome }} {{ $customer->cognome }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="customer">Indirizzo Email</label>
                                        <p>{{ $customer->email }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="customer">Privato</label>
                                        <p>{{ $customer->privato ? 'Sì' : 'No' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="customer">Indirizzo email aziendale personale</label>
                                        <p>{{ $customer->email_aziendale ? $customer->email_aziendale : '---'}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="telefono_ufficio">Telefono ufficio</label>
                                        <p>{{ $customer->telefono_ufficio ? $customer->telefono_ufficio : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="telefono_personale">Telefono personale</label>
                                        <p>{{ $customer->telefono_personale ? $customer->telefono_personale : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="email_aziendale_generica">Indrizzo Email aziendale generica</label>
                                        <p>{{ $customer->email_aziendale_generica ? $customer->email_aziendale_generica : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="ruolo_id">Ruolo</label>
                                        <p class="text-capitalize">{{ $customer->ruolo ? $customer->ruolo->nome : '---'}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="sorgente_acquisizione">Fonte</label>
                                        <p class="text-capitalize">{{ $customer->sorgente_acquisizione ? $customer->sorgente_acquisizione : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="user_id">Responsabile contatto</label>
                                        <p class="text-capitalize">{{ $customer->user ? $customer->user->name : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="data_creazione_lead">Data creazione lead</label>
                                        <p>{{ $customer->data_creazione_lead ? formatDate($customer->data_creazione_lead) : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="stato_cliente">Stato lead</label>
                                        <p class="text-uppercase"><span style="background-color:{{getColorStatoCliente($customer->stato_cliente)}}">{{ $customer->stato_cliente ? formatStatoCliente($customer->stato_cliente) : '---'}}</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="servizi">Servizi</label>
                                        <p>{{ $customer->service_id ? $customer->service->name : '---' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="note">Note</label>
                                        <p>{{ $customer->note ? $customer->note : '---' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-3">
                                    <a class="btn btn-primary btn-float" href="{{ route('clienti.edit', ['stato' => $customer->stato, 'id' => $customer->id]) }}">Modifica</a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="azienda">
                            @if($customer->company)
                            <table id="datatables" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Ragione Sociale') }}</th>
                                        <th class="no-sort">{{ __('Telefono') }}</th>
                                        <th>{{ __('Provincia legale') }}</th>
                                        <th>{{ __('Responsabile contatto') }}</th>
                                        <th>{{ __('Privato') }}</th>
                                        <th class="no-sort">{{ __('Azioni') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $customer->company_id }}</td>
                                        <td><a href="{{ route('aziende.show', $customer->company->id) }}" class="text-capitalize">{{ $customer->company->rag_soc }}</a></td>
                                        <td>{{ $customer->company->phone }}</td>
                                        <td>{{ $customer->company->provincia_legale }}</td>
                                        <td class="text-capitalize">{{ $customer->company->user ? $customer->company->user->name : '---' }}</td>
                                        <td>{{ $customer->company->privato != 1 ? 'No' : 'Sì' }}</td>
                                        <td>
                                            <a class="btn btn-success btn-sm mr-1" href="{{ route('aziende.show', $customer->company->id) }}">
                                                <i class="fas fa-pencil-alt"></i>
                                                {{ __('Vedi') }}
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection