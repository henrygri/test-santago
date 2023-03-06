@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1>Risultati</h1>
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
                    {{ __('Risultati') }}
                </div>

                <div class="card-body">
                    @if (!empty($success))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ $success }}
                        </div>
                    @elseif(!empty($error))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ $error }}
                        </div>
                    @endif
                    @if(isset($result) && count($result) > 0)
                    <table id="datatables" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                {{--
                                @switch($type)
                                    @case('Contatti/Lead')
                                    @include('search.includes.th', ['columns' => ['Nome', 'Cognome', 'E-mail', 'Azienda']])
                                    @break
                                    @case('Aziende')
                                    @include('search.includes.th', ['columns' => ['Ragione Sociale', 'Partita IVA']])
                                    @break
                                    @case('Offerte')
                                    @include('search.includes.th', ['columns' => ['Codice', 'Azienda']])
                                    @break
                                    @case('Commesse')
                                    @include('search.includes.th', ['columns' => ['Codice', 'Azienda']])
                                    @break
                                    @case('Incarichi')
                                    @include('search.includes.th', ['columns' => ['Codice', 'Fornitore']])
                                    @break
                                    @case('Consulenti/Docenti')
                                    @include('search.includes.th', ['columns' => ['Ragione Sociale', 'E-mail']])
                                    @break
                                    @case('Piani/Bandi')
                                    @include('search.includes.th', ['columns' => ['Codice', 'Nome']])
                                    @break
                                @endswitch
                                --}}
                                <th>{{ __('Modello') }}</th>
                                <th>{{ __('Ricerca') }}</th>
                                <th class="no-sort">{{ __('Azioni') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $result as $index => $record )
                            @foreach($record as $row)
                            <tr>
                                <td>{{$index}}</td>
                                @switch($index)
                                    @case('customers')
                                    <td>{{$row->nome.' '.$row->cognome.' - '.$row->email}}</td>
                                    <td><a href="{{route('clienti.edit', ['stato' => $row->stato, 'id' => $row->id])}}">Vedi</a></td>
                                    @break
                                    @case('companies')
                                    <td>{{$row->rag_soc.' - '.$row->p_iva}}</td>
                                    <td><a href="{{route('aziende.edit', $row->id)}}">Vedi</a></td>
                                    @break
                                    @case('offerte')
                                    <td>{{$row->codice}}</td>
                                    <td><a href="{{route('offerte.edit', $row->id)}}">Vedi</a></td>
                                    @break
                                    @case('commesse')
                                    <td>{{$row->codice}}</td>
                                    <td><a href="{{route('commesse.edit', $row->id)}}">Vedi</a></td>
                                    @break
                                    @case('fornitori')
                                    <td>{{$row->rag_soc.' - '.$row->email.' '.$row->codice_fiscale.' '.$row->partita_iva}}</td>
                                    <td><a href="{{route('fornitori.edit', $row->id)}}">Vedi</a></td>
                                    @break
                                    @case('bandi')
                                    <td>{{$row->codice.' - '.$row->nome}}</td>
                                    <td><a href="{{route('bandi.edit', $row->id)}}">Vedi</a></td>
                                    @break
                                    @case('incarichi')
                                    <td>{{$row->codice}}</td>
                                    <td><a href="{{route('incarichi.edit', $row->id)}}">Vedi</a></td>
                                    @break
                                    {{--
                                    @case('Contatti/Lead')
                                    @include('search.includes.td', ['columns' => [$row->nome, $row->cognome, $row->email, $row->company_id ? $row->company->rag_soc : ''], 'url' => route('clienti.edit', ['stato' => $row->stato, 'id' => $row->id])])
                                    @break
                                    @case('Aziende')
                                    @include('search.includes.td', ['columns' => [$row->rag_soc, $row->p_iva], 'url' => route('aziende.edit', $row->id)])
                                    @break
                                    @case('Offerte')
                                    @include('search.includes.td', ['columns' => [$row->codice, $row->rag_soc], 'url' => route('offerte.edit', $row->id)])
                                    @break
                                    @case('Commesse')
                                    @include('search.includes.td', ['columns' => [$row->codice, $row->rag_soc], 'url' => route('commesse.edit', $row->id)])
                                    @break
                                    @case('Incarichi')
                                    @include('search.includes.td', ['columns' => [$row->codice, $row->rag_soc], 'url' => route('incarichi.edit', $row->id)])
                                    @break
                                    @case('Consulenti/Docenti')
                                    @include('search.includes.td', ['columns' => [$row->rag_soc, $row->email], 'url' => route('fornitori.edit', $row->id)])
                                    @break
                                    @case('Piani/Bandi')
                                    @include('search.includes.td', ['columns' => [$row->codice, $row->nome], 'url' => route('bandi.edit', $row->id)])
                                    @break
                                    --}}
                                @endswitch
                            </tr>
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection