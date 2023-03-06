@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1>Modifica Offerta</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('offerte.index') }}">Offerte</a></li>
                <li class="breadcrumb-item active">Modifica Offerta</li>
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
                <div class="card-header">{{ __('Modifica Offerta') }}</div>

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
                        <form action="{{ route('offerte.update', $offerta->id) }}" method="post">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="hidden_corso_id" value="{{$offerta->corso_id}}">
                            <input type="hidden" name="hidden_n_edizione" value="{{$offerta->n_edizione}}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="codice">{{ __('Codice') }} <span class="text-danger">(si genera in automatico)</span></label>
                                        <input type="text" value="{{ $offerta->codice }}" class="form-control" id="codice" name="codice" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="company_id">{{ __('Azienda') }} *</label>
                                        <select id="company_id" name="company_id" class="form-control" required>
                                            <option></option>
                                            @foreach($companies as $company)
                                            <option value="{{$company->id}}" {{$offerta->company_id == $company->id ? 'selected' : ''}}>{{$company->rag_soc}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="customer_id">{{ __('Referente azienda') }} *</label>
                                        <select id="customer_id" name="customer_id" class="form-control" required>
                                            <option></option>
                                            <option value="{{$offerta->customer_id}}" selected>{{$offerta->customer->nome}} {{$offerta->customer->cognome}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="user_id">{{ __('Responsabile offerta') }} *</label>
                                        <select id="user_id" name="user_id" class="form-control" required>
                                            <option></option>
                                            @foreach($users as $user)
                                            <option value="{{$user->id}}" {{$offerta->user_id == $user->id ? 'selected' : ''}}>{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                           

                            <div class="row">
                                <div class="col-md-12">
                                    <label for="description">{{ __('Descrizione offerta') }} *</label>
                                    <textarea id="description" name="description" class="form-control" required>{{ $offerta->description }}</textarea>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="service_id">{{ __('Tipologia servizi') }} *</label>
                                        <select id="service_id" name="service_id[]" class="form-control select2" multiple required>
                                            <option></option>
                                            @foreach($services as $service)
                                            <option value="{{$service->id}}" {{in_array($service->id, $offerta->services) ? 'selected' : ''}}>{{$service->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="stato">{{ __('Stato') }} *</label>
                                        <select id="stato" name="stato" class="form-control" required>
                                            <option value="in attesa" {{$offerta->stato == 'in attesa' ? 'selected' : ''}}>{{__('In attesa')}}</option>
                                            <option value="accettata" {{$offerta->stato == 'accettata' ? 'selected' : ''}}>{{__('Accettata')}}</option>
                                            <option value="rifiutata" {{$offerta->stato == 'rifiutata' ? 'selected' : ''}}>{{__('Rifiutata')}}</option>
                                            <option value="annullata" {{$offerta->stato == 'annullata' ? 'selected' : ''}}>{{__('Annullata')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="data_richiesta_preventivo">{{ __('Data richiesta preventivo') }} *</label>
                                        <input type="date" value="{{ $offerta->data_richiesta_preventivo }}" class="form-control" id="data_richiesta_preventivo" name="data_richiesta_preventivo" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="data_scadenza_preventivo">{{ __('Data scadenza preventivo') }} *</label>
                                        <input type="date" min="{{ $offerta->data_richiesta_preventivo }}" value="{{ $offerta->data_scadenza_preventivo }}" class="form-control" id="data_scadenza_preventivo" name="data_scadenza_preventivo" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="val_offerta_tot">{{ __('Valore offerta TOT') }} *</label>
                                        <div class="input-group mb-3">
                                            <input type="text" value="{{ $offerta->val_offerta_tot }}" class="form-control number_format" id="val_offerta_tot" name="val_offerta_tot" required>
                                            <span class="input-group-text">€</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check ml-1 mb-3">
                                        <input type="checkbox" name="finanziamento" id="finanziamento" class="form-check-input" {{$offerta->finanziamento ? 'checked' : ''}}>
                                        <label class="form-check-label" for="finanziamento">{{ __('Finanziamento') }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4 {{$offerta->finanziamento ? '' : 'd-none'}}">
                                <div class="col-md-12">
                                    <div class="card card-primary">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="val_offerta_finanz">{{ __('Valore offerta finanziato') }} *</label>
                                                        <div class="input-group mb-3">
                                                            <input type="text" value="{{ $offerta->val_offerta_finanz }}" class="form-control number_format" id="val_offerta_finanz" name="val_offerta_finanz">
                                                            <span class="input-group-text">€</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="val_offerta_no_finanz">{{ __('Valore offerta non finanziato') }} *</label>
                                                        <div class="input-group mb-3">
                                                            <input type="text" value="{{ $offerta->val_offerta_no_finanz }}" class="form-control number_format" id="val_offerta_no_finanz" name="val_offerta_no_finanz" readonly>
                                                            <span class="input-group-text">€</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="individuale_gruppo">{{ __('Individuale/Gruppo') }}</label>
                                                        <select id="individuale_gruppo" name="individuale_gruppo" class="form-control">
                                                            <option></option>
                                                            <option value="individuale" {{$offerta->individuale_gruppo == 'individuale' ? 'selected' : ''}}>{{__('Individuale')}}</option>
                                                            <option value="gruppo" {{$offerta->individuale_gruppo == 'gruppo' ? 'selected' : ''}}>{{__('Gruppo')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="bando_id">{{ __('Codice piano/bando') }} *</label>
                                                        <select id="bando_id" name="bando_id" class="form-control">
                                                            <option></option>
                                                            @foreach($bandi as $bando)
                                                            <option value="{{$bando->id}}" {{$offerta->bando_id == $bando->id ? 'selected' : ''}}>{{$bando->codice}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="corso_id">{{ __('Corso') }}</label>
                                                        <select id="corso_id" name="corso_id" class="form-control">
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="edizione_corso">{{ __('Edizione') }}</label>
                                                        <select id="edizione_corso" name="edizione_corso" class="form-control">
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                    {{--
                                                    <label class="mt-3 d-none" data-corso>{{__('Corsi')}}</label>
                                                    <div class="input-group my-3 child d-none" data-placeholder>
                                                        <div>  
                                                            <label for="titolo">Titolo</label>                                                      
                                                            <input type="text" name="titolo" class="form-control" readonly>
                                                        </div>
                                                        <div>
                                                            <label for="titolo">Ore</label> 
                                                            <input type="text" name="ore"  class="form-control" readonly>
                                                        </div>
                                                        <div>
                                                            <label for="titolo">Edizione</label> 
                                                            <select name="edizione" class="form-control"></select>
                                                        </div>
                                                    </div>
                                                    --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="note">{{ __('Note') }}</label>
                                    <textarea id="note" name="note" class="form-control">{{ $offerta->note }}</textarea>
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
    const resetCustomers = () => {
        $.each($('#customer_id > option[value!=""]'), function(index, value) {
            $(value).remove()
        })
    }
    const getCustomers = (company_id) => {
        resetCustomers()
        common_request.post('/customers-dropdown', {
            company_id: company_id
        })
        .then(response => {
            console.log(response);
            let data = response.data.customers
            $.each(data, function(index, value) {
                let opt = document.createElement('option')
                opt.value = value.id
                opt.text = value.nome + ' ' + value.cognome
                $('#customer_id').append(opt)
            })
        })
        .catch(error => {
            console.log(error)
        })
    }

    const resetCourses = () => {
        $('#corso_id').find('option:not(:first-child)').remove()
        resetEditions()
    }

    const resetEditions = () => {
        $('#edizione_corso').find('option:not(:first-child)').remove()
    }

    const getCourses = (bando_id, callback) => {
        resetCourses()
        if(bando_id > 0) {
            common_request.post('/courses-data', {
                bando_id: bando_id
            })
            .then(response => {
                let data = response.data.corsi
                $.each(data, function(index, value) {
                    let opt = document.createElement('option')
                    opt.value = value.id
                    opt.text = value.titolo + ' (ore: '+value.ore+')'
                    if(value.id == $('[name="hidden_corso_id"]').val()) {
                        opt.selected = true
                    }
                    $('#corso_id').append(opt)
                })
                if(callback) {
                    getEditions($('[name="hidden_corso_id"]').val())
                }
            })
            .catch(error => {
                console.log(error)
            })
        }
    }

    const calcNoFinanz = (finanziato, tot) => {
        let _tot = parseFloat(tot).toFixed(2)
        let finanz = parseFloat(finanziato).toFixed(2)
        let result = parseFloat(_tot - finanz).toFixed(2)
        return result
    }

    const getEditions = (corso) => {
        resetEditions()
        if(corso > 0) {
            common_request.post('/editions-data', {
                corso_id: corso
            })
            .then(response => {
                let data = response.data.corso;
                console.log(data)
                let editions = parseInt(data.edizioni)
                for(let i=0; i < editions; i++) {
                    let opt = document.createElement('option')
                    opt.value = i + 1
                    opt.text = i + 1
                    if(opt.value == $('[name="hidden_n_edizione"]').val()) {
                        opt.selected = true
                    }
                    $('#edizione_corso').append(opt)
                }
            })
            .catch(error => {
                console.log(error)
            })
        }
    }
    
    $(document).ready(function(){
        

        $('#finanziamento').change(function() {
            let row = $(this).closest('.row');

            if($(this).is(':checked')) {
                row.next().removeClass('d-none');
            } else {
                row.next().addClass('d-none');
                let content = row.next();
                $(content).find('input').val('');
                $(content).find('select').val('');
                $(content).find('#corso_id :not(:first-child)').remove();
                $(content).find('#edizione_corso :not(:first-child)').remove();
            }
        })

        $('#company_id').change(function() {
            getCustomers($(this).val())
        })

        $('#bando_id').change(function() {
            getCourses($(this).val())
        })

        $('#corso_id').change(function() {
            getEditions($(this).val())
        })
        
        if($('#finanziamento').is(':checked')) {
            getCourses($('#bando_id').val(), true);
        }

        $('#val_offerta_finanz, #val_offerta_tot').change(function() {
            if($('#val_offerta_tot').val().length > 0 && $('#val_offerta_finanz').val().length > 0) {
                $('#val_offerta_no_finanz').val(calcNoFinanz($('#val_offerta_finanz').val(), $('#val_offerta_tot').val()))
            } else {
                $('#val_offerta_no_finanz').val('')
            }
        })

        $('#val_offerta_finanz').on('keyup',function(){
            let tot = parseFloat($('#val_offerta_tot').val())
            let init = parseFloat($('#val_offerta_finanz').val())
            if(init > tot) {
                $('#val_offerta_finanz').val('')
                $('#val_offerta_no_finanz').val('')
            }
        });

        $('#data_richiesta_preventivo').on('change',function() {
            $('#data_scadenza_preventivo').attr('min', $('#data_richiesta_preventivo').val())
            $('#data_scadenza_preventivo').val($('#data_richiesta_preventivo').val())
        });

    });
</script>
@endsection