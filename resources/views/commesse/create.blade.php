@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1>Crea Commessa</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('commesse.index') }}">Commesse</a></li>
                <li class="breadcrumb-item active">Crea Commessa</li>
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
                <div class="card-header">{{ __('Aggiungi Commessa') }}</div>

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
                        <form action="{{ route('commesse.store') }}" method="post">
                            @csrf
                            
                            @if(!is_null($offerta) && is_object($offerta))
                            <input type="hidden" name="offerta_id_passed" value="{{$offerta->id}}">
                            <input type="hidden" name="offerta_company_id" value="{{$offerta->company_id}}">
                            <input type="hidden" name="offerta_customer_id" value="{{$offerta->customer_id}}">
                            @endif
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="offerta_id">{{ __('Responsabile Commessa') }}</label>
                                        <select id="user_id" name="user_id" class="form-control">
                                            <option></option>
                                            @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="offerta_id">{{ __('Offerta') }} *</label>
                                        <select id="offerta_id" name="offerta_id" class="form-control" required>
                                            <option></option>
                                            @foreach($offerte as $offerta)
                                            <option value="{{$offerta->id}}">{{$offerta->codice}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="company_id">{{ __('Azienda') }} *</label>
                                        <select id="company_id" name="company_id" class="form-control" required>
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="customer_id">{{ __('Contatto che segue la commessa') }} *</label>
                                        <div class="input-group">
                                            <select id="customer_id" name="customer_id" class="form-control" required>
                                                <option></option>
                                            </select>
                                            <button type="button" class="btn btn-outline-secondary d-none" id="modalNewReferente" onclick="openModalReferente()">
                                                Aggiungi
                                            </button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="bando_id">{{ __('Bando') }}</label>
                                        <select id="bando_id" name="bando_id" class="form-control" disabled>
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label for="description">{{ __('Descrizione') }} *</label>
                                    <textarea id="description" name="description" class="form-control" required>{{ old('description') }}</textarea>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <label for="description">{{ __('Servizi') }} *</label>
                                    <select id="service_id" name="service_id[]" class="form-control select2" multiple disabled>
                                        @foreach($services as $service)
                                            <option value="{{$service->id}}">{{$service->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                           
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="data_stim_chiusura">{{ __('Data stimata chiusura') }} *</label>
                                        <input type="date" min="<?php echo date('Y-m-d');?>" value="{{ old('data_stim_chiusura') }}" class="form-control" id="data_stim_chiusura" name="data_stim_chiusura" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="data_effettiva_chiusura">{{ __('Data effettiva chiusura') }}</label>
                                        <input type="date"  min="<?php echo date('Y-m-d');?>" value="{{ old('data_effettiva_chiusura') }}" class="form-control" id="data_effettiva_chiusura" name="data_effettiva_chiusura">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="val_iniziale">{{ __('Valore iniziale') }} *</label>
                                        <div class="input-group">
                                            <input type="text" value="{{ old('val_iniziale') }}" class="form-control number_format" id="val_iniziale" name="val_iniziale" required>
                                            <span class="input-group-text">€</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="val_finale">{{ __('Valore finale') }}</label>
                                        <div class="input-group">
                                            <input type="text" value="{{ old('val_finale') }}" class="form-control number_format" id="val_finale" name="val_finale">
                                            <span class="input-group-text">€</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="val_no_finanz">{{ __('Valore non finanziato') }}</label>
                                        <div class="input-group">
                                            <input type="text" value="{{ old('val_no_finanz') }}" class="form-control number_format" id="val_no_finanz" name="val_no_finanz">
                                            <span class="input-group-text">€</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="val_finanz">{{ __('Valore finanziato') }}</label>
                                        <div class="input-group">
                                            <input type="text" value="{{ old('val_finanz') }}" class="form-control number_format" id="val_finanz" name="val_finanz">
                                            <span class="input-group-text">€</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="individuale_gruppo">{{ __('Individuale/Gruppo') }}</label>
                                        <select id="individuale_gruppo" name="individuale_gruppo" class="form-control">
                                            <option></option>
                                            <option value="individuale">{{__('Individuale')}}</option>
                                            <option value="gruppo">{{__('Gruppo')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-float">{{ __('Salva') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal modal2 fade" id="newReferente" tabindex="-1" aria-labelledby="newReferenteLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newReferenteLabel">{{__('Aggiungi Referente')}}</h5>
          <button type="button" class="btn-close" aria-label="Close" onclick="closeReferente()"></button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="nome">{{ __('Nome') }} *</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="{{ __('Es: Paolo') }}" required>
            </div>
            <div class="form-group">
                <label for="cognome">{{ __('Cognome') }} *</label>
                <input type="text" class="form-control" id="cognome" name="cognome" placeholder="{{ __('Es: Rossi') }}" required>
            </div>
            <div class="form-group">
                <label for="email">{{ __('Indirizzo email') }} *</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="{{ __('Es: user@user.it') }}" required>
            </div>
            <div class="form-group">
                <label for="privato">{{ __('Tipo di customer') }} *</label>
                <select id="privato" name="privato" class="form-control modalSelect2" required>
                    <option></option>
                    <option value="privato">Privato</option>
                    <option value="azienda">Azienda</option>
                </select>
            </div>
            <div class="form-group">
                <label for="ruolo_id">{{ __('Ruolo') }} *</label>
                <select id="ruolo_id" name="ruolo_id" class="form-control modalSelect2" required>
                    <option></option>
                    @foreach($ruoli as $i => $value)
                    <optgroup label="{{$i}}">
                        @foreach($value as $role)
                        <option value="{{$role['id']}}">{{$role['nome']}}</option>
                        @endforeach
                    </optgroup>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="sorgente_acquisizione">{{ __('Fonte') }} *</label>
                <select id="sorgente_acquisizione" name="sorgente_acquisizione" class="form-control modalSelect2" required>
                    <option></option>
                    <option value="social">Social</option>
                    <option value="sito">Sito</option>
                    <option value="telefono">Telefono</option>
                    <option value="email">Email</option>
                    <option value="chiamata a freddo">Chiamata a freddo</option>
                    <option value="campagna web">Campagna web</option>
                    <option value="passaparola">Passaparola</option>
                    <option value="dipendente">Dipendente</option>
                    <option value="partner">Partner</option>
                    <option value="evento online">Evento online</option>
                    <option value="convegno">Convegno</option>
                </select>
            </div>
            <div class="form-group">
                <label for="user_id_customer">{{ __('Assegnato a') }} *</label>
                <select id="user_id_customer" name="user_id_customer" class="form-control modalSelect2" required>
                    <option></option>
                    @foreach($users as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" onclick="closeReferente()">{{__('Chiudi')}}</button>
          <button type="button" class="btn btn-primary" onclick="newReferente()">{{__('Aggiungi')}}</button>
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
    const resetDetail = () => {
        $.each($('#customer_id > option[value!=""]'), function(index, value) {
            $(value).remove()
        })
        $.each($('#company_id > option[value!=""]'), function(index, value) {
            $(value).remove()
        })
        $('#val_iniziale').val('');
        $('#val_finanz').val('');
        $('#val_no_finanz').val('');
        $('#description').html('');
        $('#service_id').val(null).trigger('change');
    }

     const getOffertaDetail = (offerta_id) => {
        common_request.post('/offerta-details', {
            offerta_id: offerta_id
        })
        .then(response => {

            let company = response.data.company;
            let customer = response.data.customer;
            let offerta = response.data.offerta;
            let services = response.data.services;
            let bando = response.data.bando;

            let opt = document.createElement('option')
            opt.value = company.id
            opt.text = company.rag_soc
            opt.setAttribute('selected','')

            let optCustomer = document.createElement('option')
            optCustomer.value = customer.id
            optCustomer.text = customer.nome + ' ' + customer.cognome;
            optCustomer.setAttribute('selected','')

            if(bando) {
                let optBando = document.createElement('option')
                optBando.value = bando.id
                optBando.text = bando.codice;
                optBando.setAttribute('selected','')
                $('#bando_id').append(optBando)
            }
            
            $('#company_id').append(opt)
            $('#customer_id').append(optCustomer)
            $('#val_iniziale').val(offerta.val_offerta_tot);
            $('#val_finanz').val(offerta.val_offerta_finanz);
            $('#val_no_finanz').val(offerta.val_offerta_no_finanz);
            $('#description').html(offerta.description);
            $('#service_id').val(services);
            $('#service_id').trigger('change');
            $('#individuale_gruppo').val(offerta.individuale_gruppo)
            $('#individuale_gruppo').trigger('change');
            $('#modalNewReferente').removeClass('d-none');
        })
        .catch(error => {
            console.log(error)
        })
    }

    const closeReferente = () => {
        $('#newReferente').modal('hide')
    }

    const openModalReferente = () => {
        $('#newReferente').modal('show')
    }

    const newReferente = () => {
        common_request.post('/customer-save-data', {
            company_id: $('#company_id').val(),
            nome: $('#nome').val(),
            cognome: $('#cognome').val(),
            email: $('#email').val(),
            privato: $('#privato').val(),
            ruolo_id: $('#ruolo_id').val(),
            sorgente_acquisizione: $('#sorgente_acquisizione').val(),
            user_id: $('#user_id_customer').val(),
        })
        .then(response => {
            if(!response.data.status) {
                alert(response.data.message)
            } else {
                $('#newReferente').modal('hide');
                let customer = response.data.customer
                let optCustomer = document.createElement('option')
                optCustomer.value = customer.id
                optCustomer.text = customer.nome + ' ' + customer.cognome;
                optCustomer.setAttribute('selected','')
                $('#customer_id').append(optCustomer)
            }
        })
        .catch(error => {
            console.log(error)
        })
    }

    $(document).ready(function(){
        

        if($('input[name="offerta_id_passed"]').length > 0) {
            $('#offerta_id').val($('input[name="offerta_id_passed"]').val())
            $('#offerta_id option[value="'+$('input[name="offerta_id_passed"]').val()+'"]').attr('selected')
            $('#offerta_id').trigger('change.select2');
            resetDetail();
            getOffertaDetail($('input[name="offerta_id_passed"]').val());
        }
        $('#offerta_id').change(function() {
            resetDetail();
            getOffertaDetail($(this).val());
        })
    });
</script>
@endsection