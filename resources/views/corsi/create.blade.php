@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1>Crea corso</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('corsi.index') }}">Corsi</a></li>
                <li class="breadcrumb-item active">Crea corso</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid pt-3">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">{{ __('Aggiungi corso') }}</div>

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
                    <div class="col-md-12">
                        <form action="{{ route('corsi.store') }}" method="post">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="titolo">{{ __('Bando') }} *</label>
                                        <select name="bando_id" id="bando_id" class="form-control" required>
                                            <option></option>
                                            @foreach ($bandi as $bando )
                                                <option value="{{ $bando->id }}">{{ $bando->codice }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="titolo">{{ __('Titolo') }} *</label>
                                        <input type="text" id="titolo" name="titolo" value="{{old('titolo')}}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ore">{{ __('Edizioni') }} *</label>
                                        <input type="number" id="edizioni" name="edizioni" min="1" step="1" value="{{old('edizioni')}}" class="form-control" placeholder="Es: 7" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="costo_orario">{{ __('Ore') }} *</label>
                                        <div class="input-group mb-3">
                                            <input type="number" id="ore" name="ore" min="1" value="{{old('ore')}}" placeholder="Es: 5" class="form-control" required>
                                            <span class="input-group-text">h</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">{{ __('Salva') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection