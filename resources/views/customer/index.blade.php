@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1>{{ $stato == 'lead' ? 'Leads' : 'Contatti' }} </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active text-capitalize">{{ $stato == 'lead' ? 'Leads' : 'Contatti' }}</li>
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
                    Lista {{ $stato == 'lead' ? 'Leads' : 'Contatti' }}
                    @if($stato == 'lead' || $stato == 'contattato')
                    <a href="{{url('list/'.$stato.'/create')}}" class="btn btn-primary btn-sm ml-3">{{ __('Aggiungi') }}</a>
                    @endif
                    <a href="javascript:void(0)" onclick="deleteRows(this)" class="btn btn-danger btn-sm ml-3">{{ __('Elimina') }}</a>
                    <div class="ml-auto">
                        @if($stato == 'lead')
                        <a href="{{url('list/'.$stato.'/download')}}" class="btn btn-info btn-sm"><i class="fa fa-download"></i> {{ __('Scarica file esempio') }}</a>
                        <a role="button" href="javascript:void(0);" onclick="importModal()" class="btn btn-info btn-sm"><i class="fa fa-upload"></i> {{ __('Importa XLS') }}</a>
                        @endif
                        <a href="{{url('list/'.$stato.'/export')}}" class="btn btn-info btn-sm"><i class="fa fa-download"></i> {{ __('Esporta XLS') }}</a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ session('error') }}
                        </div>
                    @endif

                    <table id="datatables" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th class="no-sort">
                                    <input type="checkbox" name="selectAll">
                                </th>
                                <th>#</th>
                                <th>{{ __('Nome') }}</th>
                                <th class="no-sort">{{ __('Email primo contatto') }}</th>
                                <th class="no-sort">{{ __('Telefono') }}</th>
                                <th>{{ __('Azienda') }}</th>
                                <th>{{ __('Tipologia') }}</th>
                                <th>{{ __('Responsabile contatto') }}</th>
                                <th>{{ __('Fonte') }}</th>
                                <th>{{ __('Data creazione') }}</th>
                                <th>{{ __('Stato') }}</th>
                                <th class="no-sort">{{ __('Azioni') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $customers as $customer )
                            <tr data-id="{{$customer->id}}">
                                <td><input type="checkbox" name="row[]"></td>
                                <td>{{ $customer->id }}</td>
                                <td class="text-capitalize"><a href="{{ route('clienti.show', ['stato' => $customer->stato, 'id' => $customer->id]) }}">{{ $customer->nome }} {{ $customer->cognome }}</a></td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->telefono_personale }}</td>
                                <td class="text-capitalize">
                                    @if($customer->company_id)
                                    <a href="{{ route('aziende.show', $customer->company_id) }}" class="text-capitalize">{{ $customer->company_id ? $customer->company->rag_soc : '' }}</a>
                                    @endif
                                </td>
                                <td>{{ $customer->privato == 1 ? 'Privato' : 'Azienda'}}</td>
                                <td class="text-capitalize">{{ !is_null($customer->user_id) ? $customer->user->name : 'N/A' }}</td>
                                <td class="text-capitalize">{{ $customer->sorgente_acquisizione }}</td>
                                <td>{{ formatDate($customer->data_creazione_lead) }}</td>
                                <td class="text-uppercase"><span style="background-color:{{getColorStatoCliente($customer->stato_cliente)}}">{{ formatStatoCliente($customer->stato_cliente) }}</span></td>
                                <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{ route('clienti.show', ['stato' => $customer->stato, 'id' => $customer->id]) }}">{{ __('Vedi') }}</a>
                                        <a class="dropdown-item" href="{{ route('clienti.edit', ['stato' => $customer->stato, 'id' => $customer->id]) }}">{{ __('Modifica') }}</a>
                                        @if($stato == 'contattato')
                                        <a class="dropdown-item" href="{{ route('clienti.clone', $customer->id) }}">{{ __('Duplica') }}</a>
                                        @endif
                                        <form method="post" action="{{ route('clienti.destroy', $customer->id ) }}" class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item confirm_delete" data-toggle="tooltip" title='Delete'>
                                                {{ __('Elimina') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
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
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="{{url('list/lead/import')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">{{__('Importa i tuoi Leads')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="import_file">{{ __('Seleziona il File da importare') }} <span class="text-danger">(assicurati di aver compilato corettamente il file)</span></label>
                    <input type="file" class="form-control" id="import_file" name="import_file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">{{__('Importa')}}</button>
            </div>
        </form>
      </div>
    </div>
</div>
@endsection
@section('js')
<script>
    const common_request = axios.create({
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content')
        }
    });

    const deleteRows = (el) => {
        Swal.fire({
            title: `Elimina record`,
            text: "Attenzione! questa è un’operazione irreversibile. Sei sicuro di voler eliminare il record?",
            showCancelButton: true,
            showCloseButton: true,
        })
        .then((result) => {
          if (result.isConfirmed) {
            let ids = []
            $.each($('tbody > tr'), function(index, element) {
                if($(element).find('[name="row[]"]').is(':checked')) {
                    ids.push($(element).data('id'))
                }
            })
            if(ids.length > 0) {
                common_request.post('/customer/remove-rows', {
                    data: JSON.stringify(ids)
                })
                .then(response => {
                    console.log(response);
                    window.location.reload()
                })
                .catch(error => {
                    console.log(error)
                })
            } else {
                Swal.fire({
                    title: `Elimina record`,
                    text: "Nessuna voce è selezionata",
                    showCloseButton: true,
                })
            }
          }
        });
    }

    const importModal = () => {
        $('#importModal').modal('show')
    }

    /*
    const importFile = () => {
        common_request.post('/list/lead/import', {
            data: JSON.stringify(ids)
        })
        .then(response => {
            console.log(response);
        })
        .catch(error => {
            console.log(error)
        })
    }
    */

    $(document).ready(function() {
        $('[name="selectAll"]').on('change', function() {
            if($(this).is(':checked')) {
                $('[name="row[]"]').prop('checked', true)
            } else {
                $('[name="row[]"]').prop('checked', false)
            }
        })
    })
</script>
@endsection