@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1>{{ __('Collaboratori') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Collaboratori</a></li>
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
                <div class="card-header">
                    {{ __('Lista Collaboratori') }}
                    <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm ml-3">{{ __('Aggiungi collaboratore') }}</a>
                    <a href="javascript:void(0)" onclick="deleteRows(this)" class="btn btn-danger btn-sm ml-3">{{ __('Elimina') }}</a>
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
                                <th>{{ __('Nome') }}</th>
                                <th>{{ __('Ruolo') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Attivo') }}</th>
                                <th>{{ __('Data') }}</th>
                                <th class="no-sort">{{ __('Azioni') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $users as $user )
                            <tr data-id="{{$user->user_id}}">
                                <td><input type="checkbox" name="row[]"></td>
                                <td>{{ $user->user_id }}</td>
                                <td class="text-capitalize"><a href="{{ route('user.edit', $user->user_id) }}">{{ $user->user->name }}</a></td>
                                <td class="text-capitalize">{{ $user->user->roles->first()->name }}</td>
                                <td>{{ $user->user->email }}</td>
                                <td>{{ $user->is_active ? 'Sì' : 'No' }}</td>
                                <td>{{ formatDate($user->user->created_at) }}</td>
                                <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{ route('user.edit', $user->user_id) }}">{{ __('Modifica') }}</a>
                                        <form method="post" action="{{ route('user.delete', $user->user_id) }}" class="d-inline-block">
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
                common_request.post('/collaboratori/remove-rows', {
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