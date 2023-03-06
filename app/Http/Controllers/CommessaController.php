<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commessa;
use App\Models\Company;
use App\Models\Offerta;
use App\Models\Service;
use App\Models\User;
use App\Models\Ruoli;
use App\Models\Corso;
use Spatie\SimpleExcel\SimpleExcelWriter;

use Carbon\Carbon;
use Validator;
use Session;
use DB;

class CommessaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $commesse = Commessa::all()->sortByDesc('created_at');
        foreach($commesse as $commessa) {
            $services = DB::table('offerte_servizi')
                        ->where('offerta_id', '=', $commessa->offerta_id)
                        ->join('services', 'offerte_servizi.service_id', '=', 'services.id')
                        ->pluck('services.name')
                        ->toArray();
            $commessa->services = $services;
        }
        return view('commesse.index',compact('commesse'));
    }

    public function create()
    {
        $_ruoli = Ruoli::all();
        $ruoli = [];
        foreach($_ruoli as $r) {
            if(is_null($r->parent_id)) {
                $ruoli[$r->nome] = Ruoli::where('parent_id', '=', $r->id)->get()->toArray();
            }
        }

        $offerta = null;
        if(Session::has('offerta_id')) {
            $offerta = Offerta::findOrFail(Session::get('offerta_id'));
        }

        $offerte = Offerta::all()->sortByDesc('created_at');
        $services = Service::all();
        $_ruoli = Ruoli::all();
        $ruoli = [];
        foreach($_ruoli as $r) {
            if(is_null($r->parent_id)) {
                $ruoli[$r->nome] = Ruoli::where('parent_id', '=', $r->id)->get()->toArray();
            }
        }
        $users = User::all();

        return view('commesse.create', compact('offerte','services', 'users', 'ruoli','offerta'));
    }

    public function store(Request $request)
    {
        
        $data = [
            'offerta_id' => 'required|exists:offerte,id',
            'company_id' => 'required|exists:companies,id',
            'customer_id' => 'required|exists:customers,id',
            'description' => 'required',
            'data_stim_chiusura' => 'required',
            'val_iniziale' => 'required',
        ];

        $request->validate($data);

        $num = Commessa::count();

        $commessa = Commessa::create([
            'codice' => Carbon::now()->format('Y') . '0' . $num + 1,
            'offerta_id' => $request->offerta_id,
            'user_id' => $request->user_id ? $request->user_id : auth()->user()->id,
            'company_id' => $request->company_id,
            'customer_id' => $request->customer_id,
            'description' => $request->description,
            'data_apertura' => Carbon::now()->format('Y-m-d'),
            'data_stim_chiusura' => Carbon::parse($request->data_stim_chiusura)->format('Y-m-d'),
            'data_effettiva_chiusura' => is_null($request->data_effettiva_chiusura) ? Carbon::parse($request->data_stim_chiusura)->format('Y-m-d') : Carbon::parse($request->data_effettiva_chiusura)->format('Y-m-d'),
            'stato' => 'Aperta',
            'val_iniziale' => $request->val_iniziale,
            'val_finale' => $request->val_finale,
            'val_no_finanz' => $request->val_no_finanz,
            'val_finanz' => $request->val_finanz,
            'note' => $request->note,
        ]);

        $offerta = Offerta::findOrFail($request->offerta_id);
        $offerta->stato = 'accettata';
        $offerta->save();

        if(Session::has('offerta_id')) {
            Session::forget('offerta_id');
        }

        return redirect('/commesse')->with('status', 'Aggiunta nuova commessa');
    }

    public function show($id)
    {
        $commessa = Commessa::findOrFail($id);
        $services = DB::table('offerte_servizi')
        ->where('offerta_id', '=', $commessa->offerta_id)
        ->join('services', 'offerte_servizi.service_id', '=', 'services.id')
        ->pluck('services.name')
        ->toArray();

        $commessa->services = $services;
        return view('commesse.show', compact('commessa'));
    }

    public function edit($id)
    {
        $offerte = Offerta::all()->sortByDesc('created_at');
        $commessa = Commessa::findOrFail($id);
        $services = Service::all();
        $commessa->services = DB::table('offerte_servizi')->where('offerta_id','=',$commessa->offerta_id)->pluck('service_id')->toArray();

        
        $_ruoli = Ruoli::all();
        $ruoli = [];
        foreach($_ruoli as $r) {
            if(is_null($r->parent_id)) {
                $ruoli[$r->nome] = Ruoli::where('parent_id', '=', $r->id)->get()->toArray();
            }
        }
        $users = User::all();
        return view('commesse.edit', compact('commessa','offerte', 'services', 'ruoli', 'users'));
    }

    public function update($id, Request $request)
    {
        $commessa = Commessa::findOrFail($id);

        $data = [
            'offerta_id' => 'required|exists:offerte,id',
            'codice' => 'required',
            'company_id' => 'required|exists:companies,id',
            'customer_id' => 'required|exists:customers,id',
            'description' => 'required',
            'data_stim_chiusura' => 'required',
            'val_iniziale' => 'required',
            'stato' => 'required'
        ];

        $request->validate($data);

        $commessa->user_id = $request->user_id;
        $commessa->codice = $request->codice;
        $commessa->offerta_id = $request->offerta_id;
        $commessa->company_id = $request->company_id;
        $commessa->customer_id = $request->customer_id;
        $commessa->description = $request->description  ;
        $commessa->data_apertura = $request->data_apertura;
        $commessa->data_stim_chiusura = $request->data_stim_chiusura;
        $commessa->data_effettiva_chiusura = $request->data_effettiva_chiusura;
        $commessa->stato = $request->stato;
        $commessa->val_iniziale = $request->val_iniziale;
        $commessa->val_finale = $request->val_finale;
        $commessa->val_no_finanz = $request->val_no_finanz;
        $commessa->val_finanz = $request->val_finanz;

        $commessa->save();

        return redirect('/commesse')->with('status', 'I dati della commessa sono stati aggiornati');
    }

    public function getCommessaById(Request $request)
    {
        $response = [
            'status' => false,
            'message' => 'Errore endpoint'
        ];

        try {
            $validation_data = [
                'commessa_id' => ['required'],
            ];

            $validator = Validator::make($request->all(), $validation_data);

            if ($validator->fails()) {
                $response['message'] = 'Errore validazione endpoint';
                return response()->json($response);
            }

            $commessa = Commessa::find($request->commessa_id);
            $company = $commessa->company;
            $offerta = $commessa->offerta;
            $corso = Corso::find($offerta->corso_id);

            $response['status'] = true;
            $response['message'] = 'ok';
            $response['commessa'] = $commessa;
            $services = DB::table('offerte_servizi')->where('offerta_id','=',$offerta->id)->pluck('service_id')->toArray();
            $response['services'] = $services;
            $response['offerta'] = $offerta;
            $response['bando'] = $offerta->bando;
            $response['corso'] = $corso;
            $response['company'] = $company;
            return response()->json($response);

        } catch(\Exception $e) {
            $response['message'] = $e->getMessage();
            return response()->json($response);
        }
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
            Commessa::whereIn('id', $ids)->delete();

            $response['status'] = true;
            return response()->json($response);

        } catch(\Exception $e) {
            $response['message'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function createIncarico($id)
    {
        return redirect()->route('incarichi.create')->with('commessa_id', $id);
    }

    public function export()
    {
        $commesse = Commessa::all();
        $to_export = [];
        foreach($commesse as $commessa) {
            $servizi = DB::table('offerte_servizi')
                        ->leftJoin('services', 'offerte_servizi.service_id', '=', 'services.id')
                        ->where('offerte_servizi.offerta_id', '=', $commessa->offerta_id)
                        ->pluck('name')
                        ->toArray();
            $item = [
                'id' => $commessa->id,
                'codice' => $commessa->codice,
                'offerta' => $commessa->offerta->codice,
                'responsabile commessa' => $commessa->user ? $commessa->user->name : 'N/A',
                'azienda' => $commessa->company->rag_soc,
                'contatto' => $commessa->customer ? $commessa->customer->nome . ' ' . $commessa->customer->cognome : 'N/A',
                'description' => $commessa->description,
                'data_apertura' => Carbon::parse($commessa->data_apertura)->format('Y-m-d'),
                'data_stim_chiusura' => Carbon::parse($commessa->data_stim_chiusura)->format('Y-m-d'),
                'data_effettiva_chiusura' => Carbon::parse($commessa->data_stim_chiusura)->format('Y-m-d'),
                'stato' => $commessa->stato,
                'val_iniziale' => number_format($commessa->val_iniziale, 2, '.', ''),
                'val_finale' => number_format($commessa->val_finale, 2, '.', ''),
                'individuale/gruppo' => $commessa->offerta->individuale_gruppo ? $commessa->offerta->individuale_gruppo : 'N/A',
                'val_no_finanz' => number_format($commessa->val_no_finanz, 2, '.', ''),
                'val_finanz' => number_format($commessa->val_finanz, 2, '.', ''),
                'Tipologia servizi' => $servizi ? implode(', ',$servizi) : 'N/A',
                'codice bando' => $commessa->offerta->bando_id ? $commessa->offerta->bando->codice : 'N/A',
                'corso' => $commessa->offerta->corso_id ? $commessa->offerta->corso->titolo : 'N/A',
                'ore corso' => $commessa->offerta->corso_id ? $commessa->offerta->corso->ore .'h' : 'N/A',
                'edizione' => $commessa->offerta->n_edizione ? $commessa->offerta->n_edizione : 'N/A',
                //'note' => $commessa->note,
            ];
            array_push($to_export, $item);
        }

        $stream = SimpleExcelWriter::streamDownload('lista_commesse.xlsx');
        $writer = $stream->getWriter();
        
        $scartiSheet = $writer->getCurrentSheet();
        $scartiSheet->setName('Lista');
        $stream->addRows($to_export);

        return $stream->toBrowser();
    }

    public function destroy($id)
    {
        Commessa::findOrFail($id)->delete();
        return redirect()->back()->with('status', 'La commessa è stata eliminata');   
    }
}
