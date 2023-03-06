@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1>{{ __('Modifica Collaboratore') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Collaboratori</a></li>
                <li class="breadcrumb-item active">Modifica Collaboratore</a></li>
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
                <div class="card-header">{{ __('Modifica Collaboratore') }}</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <ul class="mb-0 pl-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="col-md-6">
                        <form action="{{ route('user.update', $userData->user_id) }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="name">{{ __('Ruolo') }} *</label>
                                <select name="role_id" id="role_id" class="form-control" required>
                                    <option></option>
                                    @foreach($roles as $role)
                                    <option value="{{$role->id}}" {{ $userData->user->roles->first()->id == $role->id ? 'selected' : '' }}>{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">{{ __('Nome e cognome') }} *</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('Es: Paolo Rossi') }}" value="{{ $userData->user->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('Indirizzo email') }} *</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="{{ __('Es: user@user.it') }}" value="{{ $userData->user->email }}" required>
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('Cambia Password') }} ({{__('lasciare vuoto per non modificare la password')}})</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label for="fiscal_code">{{ __('Codice Fiscale') }} *</label>
                                <input type="text" maxlength="16" class="form-control text-uppercase" id="fiscal_code" name="fiscal_code" placeholder="{{ __('Es: ABCDEF89G04H123I') }}" value="{{ $userData->fiscal_code }}" required>
                            </div>
                            <div class="form-group">
                                <div class="form-check ml-1 mb-3">
                                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" {{$userData->is_active ? 'checked' : ''}}>
                                    <label class="form-check-label" for="is_active">{{ __('Attivo') }}</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-float">{{ __('Aggiorna') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection