@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1>Crea Consulenti/Docenti</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('fornitori.index') }}">Consulenti/Docenti</a></li>
                <li class="breadcrumb-item active">Consulenti/Docenti</li>
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
                <div class="card-header">{{ __('Aggiungi Fornitore') }}</div>

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
                        <form action="{{ route('fornitori.store') }}" method="post">
                            @csrf

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="rag_soc">{{ __('Ragione Sociale / Nominativo') }}</label>
                                        <input type="text" class="form-control" id="rag_soc" name="rag_soc" placeholder="{{ __('Es: Azienda srl') }}" value="{{ old('rag_soc') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="telefono">{{ __('Telefono') }}</label>
                                        <input type="text" class="form-control" id="telefono" name="telefono" placeholder="{{ __('Es: +39 02484668') }}" value="{{ old('telefono') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cellulare">{{ __('Cellulare') }} *</label>
                                        <input type="text" class="form-control" id="cellulare" name="cellulare" placeholder="{{ __('Es: +39 02484668') }}" value="{{ old('cellulare') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">{{ __('Email') }} *</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="{{ __('Es: user@user.it') }}" value="{{ old('email') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="codice_fiscale">{{ __('Codice fiscale') }} *</label>
                                        <input type="text" maxlength="16" class="form-control" id="codice_fiscale" name="codice_fiscale" placeholder="{{ __('Es: YHTKIU89O08O896U') }}" value="{{ old('codice_fiscale') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="partita_iva">{{ __('Partita IVA') }} *</label>
                                        <input type="text" class="form-control" id="partita_iva" maxlength="11" name="partita_iva" placeholder="{{ __('Es: 12345678901') }}" value="{{ old('partita_iva') }}" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="user_id">{{ __('Assegnato a') }} *</label>
                                        <select id="user_id" name="user_id" class="form-control" required>
                                            <option></option>
                                            @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="disciplina_id">{{ __('Disciplina') }} *</label>
                                        <select id="disciplina_id" name="disciplina_id[]" class="form-control" multiple required>
                                            <option></option>
                                            @foreach($discipline as $i => $value)
                                            <optgroup label="{{$i}}">
                                                @foreach($value as $d)
                                                <option value="{{$d['id']}}">{{$d['nome']}}</option>
                                                @endforeach
                                            </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="note">{{ __('Note') }}</label>
                                        <textarea id="note" name="note" class="form-control" rows="5">{{ old('note') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="autocomplete">{{ __('Inserisci indirizzo') }}</label>
                                        <input type="text" id="pac-input" class="form-control autocomplete">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="via">{{ __('Via') }} *</label>
                                        <input type="text" class="form-control" id="via" name="via" placeholder="{{ __('Es: Via piave 2') }}" value="{{ old('via') }}" required data-map="route">
                                        <input type="hidden" id="street_number" data-map="street_number" value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="comune">{{ __('Comune') }} *</label>
                                        <input type="text" class="form-control" id="comune" name="comune" placeholder="{{ __('Es: Milano') }}" value="{{ old('comune') }}" required data-map="locality">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="provincia">{{ __('Provincia') }} *</label>
                                        <input type="text" class="form-control" id="provincia" name="provincia" placeholder="{{ __('Es: Milano') }}" value="{{ old('provincia') }}" required data-map="administrative_area_level_2">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cap">{{ __('CAP') }} *</label>
                                        <input type="text" class="form-control" id="cap" name="cap" placeholder="{{ __('Es: 20100') }}" value="{{ old('cap') }}" required data-map="postal_code">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nazione">{{ __('Nazione') }} *</label>
                                        <input type="text" class="form-control" id="nazione" name="nazione" placeholder="{{ __('Es: Italia') }}" value="{{ old('nazione') }}" required data-map="country">
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

@section('js')
<script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDfWrArMEXdPV92u9j6U8ohnZSp9aKJPeM&libraries=places&v=weekly"
      defer
    ></script>
<script>

    let componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'long_name',
        administrative_area_level_2: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };


    const createAutocomplete = (input, index) => {
        let autocomplete = new google.maps.places.Autocomplete(input, {
            types: ['address'],
            componentRestrictions: {
                'country': ["it"]
            }
        });

        let input_to_change = input;

        autocomplete.addListener('place_changed', function() {
            let obj = $(input).closest('.card-body');
            fillInAddress(autocomplete,obj);
        });
    }

  
    const fillInAddress = (ac,content) => {
        let place = ac.getPlace();
        for (let i = 0; i < place.address_components.length; i++) {
            let addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                let val = place.address_components[i][componentForm[addressType]];
                let elem_id = $(content).find('input[data-map="'+addressType+'"]');
                $(elem_id).val(val);
                let street = $(content).find('input[data-map="street_number"]').val();
                if($(elem_id).attr('data-map') == 'route') {
                    $(elem_id).val($(elem_id).val() + ' ' + street)
                }
            }
        }
    }

    $(document).ready(function(){

        let input = $('.autocomplete');
        for (i = 0; i < input.length; i++) {
            createAutocomplete(input[i], i);
        }
    });

</script>
@endsection