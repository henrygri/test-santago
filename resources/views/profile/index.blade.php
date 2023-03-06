@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1>{{ __('Profilo') }}</h1>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <ul class="mb-0 pl-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    @if (Session::has('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{ Session::get('success') }}
    </div>
    @endif
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-warning">{{__('Cambia Password')}}</div>

                <div class="card-body">
                    <form action="{{route('change-password')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>{{__('Password Corrente')}}</strong>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password Corrente" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>{{__('Nuova Password')}}</strong>
                                    <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" placeholder="Nuova Password" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>{{__('Conferma Nuova Password')}}</strong>
                                    <input type="password" name="new_password_confirmation" class="form-control @error('new_password_confirmation') is-invalid @enderror" placeholder="Conferma Nuova Password" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-warning"><i class="fas fa-edit"></i> {{__('Salva')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection