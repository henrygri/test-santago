@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1>Commesse</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Commesse</li>
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
                <div class="card-header d-flex">
                    {{ __('Lista Commesse') }}
                    <a href="{{ route('commesse.create') }}" class="btn btn-primary btn-sm ml-3">{{ __('Aggiungi commessa') }}</a>
                    <a href="javascript:void(0)" onclick="deleteRows(this)" class="btn btn-danger btn-sm ml-3">{{ __('Elimina') }}</a>
                    <a href="{{ route('commesse.export') }}" class="btn btn-info btn-sm ml-auto"><i class="fa fa-download"></i> {{ __('Esporta XLS') }}</a>
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
                                <th class="no-sort">
                                    <input type="checkbox" name="selectAll">
                                </th>
                                <th>#</th>
                                <th>{{ __('Codice') }}</th>
                                <th>{{ __('Azienda') }}</th>
                                <th>{{ __('Tipologia') }}</th>
                                <th>{{ __('Servizi') }}</th>
                                <th>{{ __('Valore iniziale') }}</th>
                                <th>{{ __('Data apertura') }}</th>
                                <th>{{ __('Data stimata chiusura') }}</th>
                                <th>{{ __('Stato') }}</th>
                                <th>{{ __('Referente interno') }}</th>
                                <th class="no-sort">{{ __('Azioni') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $commesse as $commessa )
                            <tr data-id="{{$commessa->id}}">
                                <td><input type="checkbox" name="row[]"></td>
                                <td>{{ $commessa->id }}</td>
                                <td><a href="{{ route('commesse.show', $commessa->id) }}">{{ $commessa->codice }}</a></td>
                                <td><a href="{{ route('aziende.show', $commessa->company->id) }}" class="text-capitalize">{{ $commessa->company->rag_soc }}</a></td>
                                <td>{{ $commessa->company->privato == 1 ? 'Privato' : 'Azienda' }}</td>
                                <td>{{ implode(', ', $commessa->services) }}</td>
                                <td>{{ $commessa->val_iniziale . ' €' }}</td>
                                <td>{{ formatDate($commessa->created_at) }}</td>
                                <td>{{ formatDate($commessa->data_stim_chiusura) }}</td>
                                <td class="text-uppercase"><span style="background-color:{{getColorStatoCommessa($commessa->stato)}}">{{ $commessa->stato }}</span></td>
                                <td class="text-capitalize">{{ $commessa->user ? $commessa->user->name : '---' }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="{{ route('commesse.show', $commessa->id) }}">{{ __('Vedi') }}</a>
                                            <a class="dropdown-item" href="{{ route('commesse.edit', $commessa->id) }}">{{ __('Modifica') }}</a>
                                            <form method="post" action="{{ route('commesse.destroy', $commessa->id) }}" class="d-inline-block">
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
                common_request.post('/commesse/remove-rows', {
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