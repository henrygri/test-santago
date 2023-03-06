@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1>Aziende</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Aziende</li>
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
                    <div>
                        {{ __('Lista Aziende') }}
                        <a href="{{ route('aziende.create') }}" class="btn btn-primary btn-sm ml-3">{{ __('Aggiungi azienda') }}</a>
                        <a href="javascript:void(0)" onclick="deleteRows(this)" class="btn btn-danger btn-sm ml-3">{{ __('Elimina') }}</a>
                        <a href="{{ route('aziende.export') }}" class="btn btn-info btn-sm ml-3"><i class="fa fa-download"></i> {{ __('Esporta XLS') }}</a>
                    </div>
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item"><a class="nav-link active" href="#aziende" data-toggle="tab">Aziende</a></li>
                        <li class="nav-item"><a class="nav-link" href="#privati" data-toggle="tab">Privati</a></li>
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
                        <div class="tab-pane active" id="aziende">
                            <table id="datatables2" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="no-sort">
                                            <input type="checkbox" name="selectAll">
                                        </th>
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
                                    @foreach ( $companies as $company )
                                    <tr data-id="{{$company->id}}">
                                        <td><input type="checkbox" name="row[]"></td>
                                        <td>{{ $company->id }}</td>
                                        <td><a href="{{ route('aziende.show', $company->id) }}" class="text-capitalize">{{ $company->rag_soc }}</a></td>
                                        <td>{{ $company->phone }}</td>
                                        <td>{{ $company->provincia_legale }}</td>
                                        <td>{{ $company->user ? $company->user->name : '---' }}</td>
                                        <td>{{ $company->privato != 1 ? 'No' : 'Sì' }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="{{ route('aziende.show', $company->id) }}">{{ __('Vedi') }}</a>
                                                    <a class="dropdown-item" href="{{ route('aziende.edit', $company->id) }}">{{ __('Modifica') }}</a>
                                                    <form method="post" action="{{ route('aziende.destroy', $company->id) }}" class="d-inline-block">
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
                        <div class="tab-pane" id="privati">
                            <table id="datatables2" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="no-sort">
                                            <input type="checkbox" name="selectAll">
                                        </th>
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
                                    @foreach ( $companiesPrivate as $company )
                                    <tr data-id="{{$company->id}}">
                                        <td><input type="checkbox" name="row[]"></td>
                                        <td>{{ $company->id }}</td>
                                        <td><a href="{{ route('aziende.show', $company->id) }}" class="text-capitalize">{{ $company->rag_soc }}</a></td>
                                        <td>{{ $company->phone }}</td>
                                        <td>{{ $company->provincia_legale }}</td>
                                        <td>{{ $company->user ? $company->user->name : '---' }}</td>
                                        <td>{{ $company->privato != 1 ? 'No' : 'Sì' }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="{{ route('aziende.show', $company->id) }}">{{ __('Vedi') }}</a>
                                                    <a class="dropdown-item" href="{{ route('aziende.edit', $company->id) }}">{{ __('Modifica') }}</a>
                                                    <form method="post" action="{{ route('aziende.destroy', $company->id) }}" class="d-inline-block">
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
                common_request.post('/aziende/remove-rows', {
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