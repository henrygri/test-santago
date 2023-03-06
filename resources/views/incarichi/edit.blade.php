@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1>Modifica Incarico</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('incarichi.index') }}">Incarichi</a></li>
                <li class="breadcrumb-item active">Modifica Incarico</li>
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
                <div class="card-header">{{ __('Modifica Incarico') }}</div>

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
                        <form action="{{ route('incarichi.update', $incarico->id) }}" method="post">
                            @csrf
                            @method('PATCH')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="codice">{{ __('Codice') }} <span class="text-danger">(si genera in automatico)</span></label>
                                        <input type="text" value="{{ $incarico->codice }}" class="form-control" id="codice" name="codice">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fornitore_id">{{ __('Docente/Consulente') }} *</label>
                                        <select id="fornitore_id" name="fornitore_id" class="form-control" required>
                                            <option></option>
                                            @foreach($fornitori as $fornitore)
                                            <option value="{{$fornitore->id}}" {{ $incarico->fornitore_id == $fornitore->id ? 'selected' : '' }}>{{$fornitore->rag_soc}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="commessa_id">{{ __('Commessa') }} *</label>
                                        <select id="commessa_id" name="commessa_id" class="form-control" required>
                                            <option></option>
                                            @foreach($commesse as $commessa)
                                            <option value="{{$commessa->id}}" {{ $incarico->commessa_id == $commessa->id ? 'selected' : '' }}>{{$commessa->codice}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="company_id">{{ __('Azienda') }}</label>
                                        <select id="company_id" name="company_id" class="form-control">
                                            <option></option>
                                            @if($incarico->company_id)
                                            <option value="{{$incarico->company_id}}" selected>{{ $incarico->company->rag_soc }}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="offerta_id">{{ __('Offerta') }} *</label>
                                        <select id="offerta_id" name="offerta_id" class="form-control">
                                            <option></option>
                                            @if($incarico->offerta_id)
                                            <option value="{{$incarico->offerta_id}}" selected>{{ $incarico->offerta->codice }}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="bando_id">{{ __('Bando') }}</label>
                                        <select id="bando_id" name="bando_id" class="form-control">
                                            <option></option>
                                            @foreach($bandi as $bando)
                                            <option value="{{$bando->id}}" {{ $incarico->bando_id == $bando->id ? 'selected' : '' }}>{{$bando->codice}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="corso_id">{{ __('Corso') }}</label>
                                        <input type="text" name="corso" id="corso" class="form-control" value="{{ is_object($incarico->offerta->corso) ? $incarico->offerta->corso->titolo : ''}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="corso_id">{{ __('Edizione') }}</label>
                                        <input type="text" name="edizione" id="edizione" class="form-control" value="{{ is_object($incarico->offerta->corso) ? $incarico->offerta->n_edizione : '' }}" readonly>
                                    </div>
                                </div>
                            </div>

                           
                            <div class="row">
                                <!-- <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="responsabile">{{ __('Responsabile progetto') }} *</label>
                                        <select id="responsabile" name="responsabile" class="form-control">
                                            <option></option>
                                            @foreach($users as $user)
                                            <option value="{{$user->id}}" {{ $incarico->responsabile == $user->id ? 'selected' : '' }}>{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="attivita">{{ __('Attività') }} *</label>
                                        <select id="attivita" name="attivita[]" class="form-control select2" multiple>
                                            <option value="docenza" {{in_array('docenza', $attivita) ? 'selected' : ''}}>Docenza</option>
                                            <option value="tutoraggio" {{in_array('tutoraggio', $attivita) ? 'selected' : ''}}>Tutoraggio</option>
                                            <option value="coordinamento didattico" {{in_array( 'coordinamento didattico', $attivita) ? 'selected' : ''}}>Coordinamento didattico</option>
                                            <option value="coordinamento generale" {{in_array('coordinamento generale', $attivita) ? 'selected' : ''}}>Coordinamento generale</option>
                                            <option value="amministrazione" {{in_array('amministrazione', $attivita) ? 'selected' : ''}}>Amministrazione</option>
                                            <option value="segreteria" {{in_array('segreteria', $attivita) ? 'selected' : ''}}>Segreteria</option>
                                            <option value="analisi della domanda" {{in_array('analisi della domanda', $attivita) ? 'selected' : ''}}>Analisi della domanda</option>
                                            <option value="diagnosi e rilevazione bisogni formativi" {{in_array('diagnosi e rilevazione bisogni formativi', $attivita) ? 'selected' : ''}}>Diagnosi e rilevazione bisogni formativi</option>
                                            <option value="progettazione attività" {{in_array('progettazione attività', $attivita) ? 'selected' : ''}}>Progettazione attività</option>
                                            <option value="diffusione risultati o attestati" {{in_array('diffusione risultati o attestati', $attivita) ? 'selected' : ''}}>Diffusione risultati o attestati</option>
                                            <option value="monitoraggio e valutazione" {{in_array('monitoraggio e valutazione', $attivita) ? 'selected' : ''}}>Monitoraggio e valutazione</option>
                                            <option value="promozione delle attività del piano" {{in_array('promozione delle attività del piano', $attivita) ? 'selected' : ''}}>Promozione delle attività del piano</option>
                                            <option value="segreteria didattica" {{in_array('segreteria didattica', $attivita) ? 'selected' : ''}}>Segreteria didattica</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="service_id">{{ __('Servizi') }} *</label>
                                        <select id="service_id" name="service_id[]" class="form-control select2" multiple>
                                            @foreach($services as $service)
                                            <option value="{{$service->id}}" {{in_array($service->id, $incarico->services) ? 'selected' : ''}}>{{$service->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="data_inizio">{{ __('Data inizio') }} *</label>
                                        <input type="date" value="{{ $incarico->data_inizio }}" class="form-control" id="data_inizio" name="data_inizio">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="data_fine">{{ __('Data fine') }}</label>
                                        <input type="date" min="{{ $incarico->data_inizio }}" value="{{ $incarico->data_fine }}" class="form-control" id="data_fine" name="data_fine">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="numero_edizione">{{ __('Numero edizione') }}</label>
                                        <input type="text" id="numero_edizione" name="numero_edizione" value="{{ $incarico->numero_edizione }}" class="form-control">
                                    </div>
                                </div> -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ore">{{ __('Impegno Ore') }} *</label>
                                        <input type="number" id="ore" step="0.5" name="ore" value="{{ $incarico->ore }}" class="form-control" placeholder="Es: 7,5" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="costo_orario">{{ __('Costo orario') }} *</label>
                                        <div class="input-group mb-3">
                                            <input type="number" id="costo_orario" name="costo_orario" value="{{ $incarico->costo_orario }}" class="form-control" placeholder="In €/h" required>
                                            <span class="input-group-text">€/h</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ore">{{ __('Totale') }}</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="tot" name="tot" class="form-control" readonly>
                                            <span class="input-group-text">€</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tempi_pagamento">{{ __('Tempi pagamento') }} *</label>
                                        <select id="tempi_pagamento" name="tempi_pagamento" class="form-control" required>
                                            <option></option>
                                            <option value="Ricevimento in fattura" {{ $incarico->tempi_pagamento == 'Ricevimento in fattura' ? 'selected' : '' }}>Ricevimento in fattura</option>
                                            <option value="30" {{ $incarico->tempi_pagamento == '30' ? 'selected' : '' }}>30</option>
                                            <option value="60" {{ $incarico->tempi_pagamento == '60' ? 'selected' : '' }}>60</option>
                                            <option value="90" {{ $incarico->tempi_pagamento == '90' ? 'selected' : '' }}>90</option>
                                            <option value="30 dffm" {{ $incarico->tempi_pagamento == '30 dffm' ? 'selected' : '' }}>30 dffm</option>
                                            <option value="60 dffm" {{ $incarico->tempi_pagamento == '60 dffm' ? 'selected' : '' }}>60 dffm</option>
                                            <option value="90 dffm" {{ $incarico->tempi_pagamento == '90 dffm' ? 'selected' : '' }}>90 dffm</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="spese">{{ __('Spese') }} *</label>
                                        <select id="spese" name="spese" class="form-control" required>
                                            <option></option>
                                            <option value="previste" {{ $incarico->spese == 'previste' ? 'selected' : '' }}>previste</option>
                                            <option value="non previste" {{ $incarico->spese == 'non previste' ? 'selected' : '' }}>non previste</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="note">{{ __('Note') }}</label>
                                    <textarea id="note" name="note" class="form-control">{{ $incarico->note }}</textarea>
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

    const resetDetail = () => {
        $.each($('#company_id > option[value!=""]'), function(index, value) {
            $(value).remove()
        })
        $.each($('#offerta_id > option[value!=""]'), function(index, value) {
            $(value).remove()
        })
        $('#data_fine').val('');
    }

    const getCommessaDetail = (commessa_id) => {
        common_request.post('/commessa-details', {
            commessa_id: commessa_id
        })
        .then(response => {
            let company = response.data.company;
            let offerta = response.data.offerta;
            let commessa = response.data.commessa;
            let bando = response.data.bando;
            let corso = response.data.corso;
            let services = response.data.services;
            
            let opt = document.createElement('option')
            opt.value = company.id
            opt.text = company.rag_soc
            opt.selected = 'selected'

            let optOfferta = document.createElement('option')
            optOfferta.value = offerta.id
            optOfferta.text = offerta.codice;
            optOfferta.selected = 'selected';

            if(offerta.bando_id != null) {
                let optBando = document.createElement('option')
                optBando.value = bando.id
                optBando.text = bando.codice;
                optBando.selected = 'selected';
                $('#bando_id').append(optBando)

                $('#corso').val(corso.titolo)
                $('#edizione').val(offerta.n_edizione)
            } else {
                $('#bando_id option').remove()
                $('#corso').val('')
                $('#edizione').val('')
            }

            $('#company_id').append(opt)
            $('#offerta_id').append(optOfferta)
            $('#data_inizio').val(new Date(commessa.created_at).toISOString().split('T')[0]);
            $('#data_fine').val(commessa.data_stim_chiusura);
            $('#service_id').val(services);
            $('#service_id').trigger('change');
        })
        .catch(error => {
            console.log(error)
        })
    }

    const initTot = () => {
        let ore = $('#ore').val()
        let costo_orario = $('#costo_orario').val()
        let result = ore * costo_orario
        $('#tot').val(result)
    }
    
    $(document).ready(function(){
        

        $('#commessa_id').change(function() {
            resetDetail();
            getCommessaDetail($(this).val());
        })

        initTot()
        $('#ore, #costo_orario').change(function() {
            initTot()
        })

        $('#data_inizio').on('change',function() {
            $('#data_fine').attr('min', $('#data_inizio').val())
            $('#data_fine').val($('#data_inizio').val())
        });
    });
</script>
@endsection