<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incarico;
use App\Models\Bando;
use App\Models\Company;
use App\Models\Service;
use App\Models\Fornitore;
use App\Models\Offerta;
use App\Models\User;
use App\Models\Commessa;
use Spatie\SimpleExcel\SimpleExcelWriter;

use Carbon\Carbon;
use DB;
use Session;
use Validator;

class IncaricoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $incarichi = Incarico::all()->sortByDesc('created_at');
        foreach($incarichi as $incarico) {
            $services = DB::table('incarichi_servizi')
            ->where('incarico_id', '=', $incarico->id)
            ->join('services', 'incarichi_servizi.service_id', '=', 'services.id')
            ->pluck('services.name')
            ->toArray();
            $incarico->services = $services;
        }
        return view('incarichi.index',compact('incarichi'));
    }

    public function create()
    {
        if(Session::has('fornitore')) {
            Session::forget('fornitore');
        }

        $data = [
            'fornitori' => Fornitore::all(),
            'bandi' => Bando::all(),
            'services' => Service::all(),
            'users' => User::all(),
        ];

        if(Session::has('commessa_id')) {
            $data['commessa'] = Commessa::findOrFail(Session::get('commessa_id'));
        } else {
            $data['commesse'] = Commessa::all();
        }

        if(Session::has('commessa_id')) {
            Session::forget('commessa_id');
        }

        //$fornitore = Fornitore::findOrFail($request->fornitore_id);

        //$fornitori = Fornitore::all();
        //$bandi = Bando::all();
        //$services = Service::all();
        //$users = User::all();
        $commesse = Commessa::all();
        return view('incarichi.create', $data);
    }

    public function store(Request $request)
    {
        $data = [
            'codice' => 'unique:incarichi,codice',
            'fornitore_id' => 'required|exists:fornitori,id',
            'offerta_id' => 'required|exists:offerte,id',
            //'responsabile' => 'required|exists:users,id',
            'attivita' => 'required',
            'service_id' => 'required|exists:services,id',
            'data_inizio' => 'required',
            'data_fine' => 'required',
            'ore' => 'required',
            'costo_orario' => 'required',
            'spese' => 'required'
        ];

        $request->validate($data);

        $codice = $request->codice;
        if(is_null($codice) || strlen($request->codice) <= 0) {
            $tot_offerte = Incarico::count() + 1;
            $codice = 'PROTINC-SNTAG/'.substr(auth()->user()->name, 0, 6).'/'.$tot_offerte.'/'.date('Y');
        }

        $incarico = Incarico::create([
            'codice' => $codice,
            'fornitore_id' => $request->fornitore_id,
            'commessa_id' => $request->commessa_id,
            'offerta_id' => $request->offerta_id,
            'company_id' => $request->company_id,
            'bando_id' => $request->bando_id,
            //'responsabile' => $request->responsabile,
            'assegnato' => auth()->user()->id,
            'attivita' => json_encode($request->attivita),
            'data_inizio' => Carbon::parse($request->data_inizio)->format('Y-m-d'),
            'data_fine' => Carbon::parse($request->data_fine)->format('Y-m-d'),
            'ore' => $request->ore,
            'costo_orario' => $request->costo_orario,
            'spese' => $request->spese,
            'numero_edizione' => $request->numero_edizione,
            'tempi_pagamento' => $request->tempi_pagamento,
            'note' => $request->note
        ]);

        foreach($request->service_id as $index => $service) {
            DB::table('incarichi_servizi')->insert([
                'incarico_id' => $incarico->id,
                'service_id' => $service
            ]);
        }

        if(Session::has('commessa_id')) {
            Session::forget('commessa_id');
        }

        return redirect('/incarichi')->with('status', 'Aggiunto nuovo incarico');
    }

    public function edit($id)
    {
        $commesse = Commessa::all();
        $fornitori = Fornitore::all();
        $bandi = Bando::all();
        $services = Service::all();
        $users = User::all();
        $incarico = Incarico::findOrFail($id);
        $attivita = json_decode($incarico->attivita);
        $incarico->services = DB::table('incarichi_servizi')->where('incarico_id','=',$id)->pluck('service_id')->toArray();
        return view('incarichi.edit', compact('incarico','attivita','commesse', 'users', 'fornitori', 'bandi', 'services'));
    }

    public function update($id, Request $request)
    {
        $incarico = Incarico::findOrFail($id);

        $data = [
            'codice' => 'required|unique:incarichi,codice,'.$id,
            'fornitore_id' => 'required|exists:fornitori,id',
            'offerta_id' => 'required|exists:offerte,id',
            //'responsabile' => 'required|exists:users,id',
            'attivita' => 'required',
            'service_id' => 'required|exists:services,id',
            'data_inizio' => 'required',
            'data_fine' => 'required',
            'ore' => 'required',
            'costo_orario' => 'required',
            'spese' => 'required'
        ];

        $request->validate($data);

        $incarico->codice = $request->codice;
        $incarico->fornitore_id = $request->fornitore_id;
        $incarico->commessa_id = $request->commessa_id;
        $incarico->offerta_id = $request->offerta_id;
        $incarico->company_id = $request->company_id;
        $incarico->bando_id = $request->bando_id;
        //$incarico->responsabile = $request->responsabile;
        $incarico->attivita = json_encode($request->attivita);
        $incarico->data_inizio = Carbon::parse($request->data_inizio)->format('Y-m-d');
        $incarico->data_fine = Carbon::parse($request->data_fine)->format('Y-m-d');
        $incarico->ore = $request->ore;
        $incarico->costo_orario = $request->costo_orario;
        $incarico->spese = $request->spese;
        $incarico->numero_edizione = $request->numero_edizione;
        $incarico->tempi_pagamento = $request->tempi_pagamento;
        $incarico->note = $request->note;

        $incarico->save();

        $old_services = DB::table('incarichi_servizi')->where('incarico_id', '=', $id)->pluck('service_id')->toArray();
        $new_services = $request->service_id;

        $diff = array_diff($old_services, $new_services);
        if(count($diff) > 0) {
            DB::table('incarichi_servizi')->where('incarico_id', '=', $id)->whereIn('service_id', $diff)->delete();
        }
        
        foreach($new_services as $index => $service_id) {
            if(!in_array($service_id, $old_services)) {
                DB::table('incarichi_servizi')->insert([
                    'incarico_id' => $id,
                    'service_id' => $service_id
                ]);
            }
        }

        return redirect('/incarichi')->with('status', 'I dati dell\'incarico sono stati aggiornati');
    }

    public function export()
    {
        $incarichi = Incarico::all();
        $to_export = [];
        foreach($incarichi as $incarico) {
            $item = [
                'id' => $incarico->id,
                'codice' => $incarico->codice,
                'fornitore' => $incarico->fornitore ? $incarico->rag_soc : 'N/A',
                'commessa_id' => $incarico->commessa ? $incarico->commessa->codice : 'N/A',
                'offerta' => $incarico->offerta ? $incarico->offerta->codice : 'N/A',
                'azienda' => $incarico->company_id ? $incarico->company->rag_soc : 'N/A',
                'bando' => $incarico->bando ? $incarico->bando->codice : 'N/A',
                'corso' => is_object($incarico->offerta->corso) ? $incarico->offerta->corso->titolo : 'N/A',
                'edizione' => is_object($incarico->offerta->corso) ? $incarico->offerta->n_edizione : 'N/A',
                //'responsabile' => $incarico->resp ? $incarico->resp->name : 'N/A',
                'assegnato' => $incarico->ass ? $incarico->ass->name : 'N/A',
                'attivita' => $incarico->attivita ? implode(', ',  json_decode($incarico->attivita)) : 'N/A',
                'servizi' => $incarico->services ? implode(', ',$incarico->services) : 'N/A',
                'data_inizio' => Carbon::parse($incarico->data_inizio)->format('Y-m-d'),
                'data_fine' => Carbon::parse($incarico->data_fine)->format('Y-m-d'),
                'ore' => $incarico->ore,
                'costo_orario' => number_format($incarico->costo_orario, 2, '.', ''),
                'totale' => number_format($incarico->ore * $incarico->costo_orario, 2, '.', ''),
                'spese' => $incarico->spese,
                //'numero_edizione' => $incarico->numero_edizione,
                'tempi_pagamento' => $incarico->tempi_pagamento,
                'note' => $incarico->note
            ];
            array_push($to_export, $item);
        }

        $stream = SimpleExcelWriter::streamDownload('lista_incarichi.xlsx');
        $writer = $stream->getWriter();
        
        $scartiSheet = $writer->getCurrentSheet();
        $scartiSheet->setName('Lista');
        $stream->addRows($to_export);

        return $stream->toBrowser();
    }


    public function destroy($id)
    {
        Incarico::findOrFail($id)->delete();
        return redirect()->back()->with('status', 'L\' incarico è stato eliminato');   
    }

    public function removeRows(Request $request)
    {
        $response = [
            'status' => false,
            'message' => 'Errore endpoint'
        ];

        try {
            $validation_data = [
                'data' => ['required'],
            ];

            $validator = Validator::make($request->all(), $validation_data);

            if ($validator->fails()) {
                $response['message'] = 'Errore validazione endpoint';
                return response()->json($response);
            }

            $ids = json_decode($request->data);
            Incarico::whereIn('id', $ids)->delete();

            $response['status'] = true;
            return response()->json($response);

        } catch(\Exception $e) {
            $response['message'] = $e->getMessage();
            return response()->json($response);
        }
    }
}
