@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1>Modifica Piani/Bandi</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('bandi.index') }}">Piani/Bandi</a></li>
                <li class="breadcrumb-item active">Modifica Piani/Bandi</li>
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
                <div class="card-header">{{ __('Aggiungi piano/bando') }}</div>
                <div class="card-body">
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
                    <div class="col-md-12">
                        <form action="{{ route('bandi.update', $bando->id) }}" method="post">
                            @csrf
                            @method('PATCH')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nome">{{ __('Fondo/Ente') }}</label>
                                        <select name="nome" id="nome" class="form-control" required>
                                            <option></option>
                                            <option value="FONARCOM" {{ $bando->nome == 'FONARCOM' ? 'selected' : '' }}>FONARCOM</option>
                                            <option value="Regione Lombardia" {{ $bando->nome == 'Regione Lombardia' ? 'selected' : '' }}>Regione Lombardia</option>
                                            <option value="UILM" {{ $bando->nome == 'UILM' ? 'selected' : '' }}>UILM</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="codice">{{ __('Codice') }} *</label>
                                        <input type="text" class="form-control" id="codice" value="{{ $bando->codice }}" name="codice" placeholder="{{ __('Es: XC678') }}">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="data_apertura">{{ __('Data apertura') }} *</label>
                                        <input type="date" class="form-control" id="data_apertura" value="{{ $bando->data_apertura }}" name="data_apertura" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="data_chiusura">{{ __('Data chiusura') }} *</label>
                                        <input type="date" min="{{ $bando->data_apertura }}" class="form-control" id="data_chiusura" value="{{ $bando->data_chiusura }}" name="data_chiusura" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="data_chiusura_prorogata">{{ __('Data chiusura prorogata') }}</label>
                                        <input type="date" min="{{ $bando->data_chiusura }}" class="form-control" id="data_chiusura_prorogata" value="{{ $bando->data_chiusura_prorogata }}" name="data_chiusura_prorogata">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="corsi">{{ __('Corsi') }} *</label>
                                            <select name="corsi[]" id="corsi" class="form-control select2" multiple required>
                                                <option></option>
                                                @foreach ($corsi as $corso )
                                                    <option value="{{$corso->id}}" {{ in_array($corso->id, $bando->corsi->pluck('corso_id')->toArray()) ? 'selected' : '' }}>{{$corso->titolo}}</option>
                                                @endforeach
                                            </select>
                                            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#newCourse">Aggiungi</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="monte_ore">{{ __('Monte ore') }}</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="monte_ore" value="{{ $bando->monte_ore }}" name="monte_ore">
                                            <span class="input-group-text">h</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="valore_iniziale">{{ __('Valore iniziale') }} *</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control number_format" id="valore_iniziale" value="{{ $bando->valore_iniziale }}" name="valore_iniziale" required>
                                            <span class="input-group-text">€</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="valore_finale">{{ __('Valore finale') }}</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control number_format" id="valore_finale" value="{{ $bando->valore_finale }}" name="valore_finale">
                                            <span class="input-group-text">€</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="note">{{ __('Note') }}</label>
                                        <textarea name="note" id="note" class="form-control" rows="5">{{ $bando->note }}</textarea>
                                    </div>
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

<div class="modal fade" id="newCourse" tabindex="-1" aria-labelledby="newCourseLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newCourseLabel">{{__('Aggiungi corso')}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="titolo">{{ __('Titolo') }} *</label>
                <input type="text" id="titolo" name="titolo" value="{{old('titolo')}}" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="ore">{{ __('N. edizione') }} *</label>
                <input type="number" id="edizioni" name="edizioni" step="1" value="{{old('edizioni')}}" class="form-control" placeholder="7" required>
            </div>
            <div class="form-group">
                <label for="costo_orario">{{ __('Ore edizione') }} *</label>
                <div class="input-group mb-3">
                    <input type="number" id="ore" name="ore" value="{{old('ore')}}" placeholder="5" class="form-control" required>
                    <span class="input-group-text">h</span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Chiudi')}}</button>
          <button type="button" class="btn btn-primary" onclick="newCourse()">{{__('Aggiungi')}}</button>
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

const resetModal = () => {
    $('#newCourse').modal('hide')
    $('#newCourse').on('hidden.bs.modal', function(e) {
        $('#titolo').val(''),
        $('#edizioni').val(''),
        $('#ore').val('')
    })
}

const newCourse = () => {
    common_request.post('/new-course', {
        titolo: $('#titolo').val(),
        edizioni: $('#edizioni').val(),
        ore: $('#ore').val()
    })
    .then(response => {
        let data = response.data
        if(!data.status) {
            alert(data.message)
        } else {
            resetModal();
            let opt = document.createElement('option')
            opt.value = data.corso.id
            opt.text = data.corso.titolo
            opt.selected = true
            $('#corsi').append(opt)
            Swal.fire({
                title: `Corso creato`,
                text: "Il corso è stato creato con successo",
                showCloseButton: true,
            })
        }
    })
    .catch(error => {
        console.log(error)
    })
}

$(document).ready(function(){

    

    $('#data_apertura').on('change',function() {
        $('#data_chiusura').attr('min', $('#data_apertura').val())
        $('#data_chiusura').val($('#data_apertura').val())
        $('#data_chiusura_prorogata').attr('min', $('#data_apertura').val())
        //$('#data_chiusura_prorogata').val($('#data_apertura').val())
    });

    $('#data_chiusura').on('change',function() {
        $('#data_chiusura_prorogata').attr('min', $('#data_chiusura').val())
        //$('#data_chiusura_prorogata').val($('#data_chiusura').val())
    });


});
</script>
@endsection