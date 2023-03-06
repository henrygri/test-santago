<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offerta;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Bando;
use App\Models\User;
use App\Models\Service;
use Spatie\SimpleExcel\SimpleExcelWriter;

use Carbon\Carbon;
use DB, Validator, Session;

class OfferteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $offerte = Offerta::all()->sortByDesc('created_at');
        foreach($offerte as $key => $offerta) {
            $services = DB::table('offerte_servizi')
                        ->where('offerta_id', '=', $offerta->id)
                        ->join('services', 'offerte_servizi.service_id', '=', 'services.id')
                        ->pluck('services.name')
                        ->toArray();

            $ids = DB::table('offerte_servizi')->where('offerta_id','=',$offerta->id)->pluck('service_id')->toArray();
            $offerta->services = $services;
        }

        return view('offerte.index',compact('offerte'));
    }

    public function create()
    {
        /*
        $bandi = Bando::all();
        $companies = Company::all();
        $services = Service::all();
        $users = User::all();
        */
        $data = [
            'bandi' => Bando::all(),
            'services' => Service::all(),
            'users' => User::all(),
        ];
        if(Session::has('company_id')) {
            $data['company'] = Company::findOrFail(Session::get('company_id'));
            //return view('offerte.create', compact('bandi', 'company', 'services', 'users'));
        } else {
            $data['companies'] = Company::all();
        }
        return view('offerte.create', $data);
    }

    public function store(Request $request)
    {
        $data = [
            'company_id' => 'required|exists:companies,id',
            'customer_id' => 'required|exists:customers,id',
            'description' => 'required',
            'stato' => 'required|string|max:255',
            'val_offerta_tot' => 'required|string|max:255',
        ];

        if($request->finanziamento) {
            $data['bando_id'] = 'required|exists:bandi,id';
            $data['val_offerta_no_finanz'] = 'required';
            $data['val_offerta_finanz'] = 'required';
        }

        $request->validate($data);

        $codice = $request->codice;
        if(is_null($codice) || strlen($request->codice) <= 0) {
            $tot_offerte = Offerta::count() + 1;
            $codice = 'PROTOFF-SNTAG/'.substr(auth()->user()->name, 0, 6).'/'.$tot_offerte.'/'.date('Y');
        }

        $offerta = Offerta::create([
            'codice' => $codice,
            'company_id' => $request->company_id,
            'customer_id' => $request->customer_id,
            'user_id' => $request->user_id ? $request->user_id : auth()->user()->id,
            'bando_id' => $request->bando_id,
            'corso_id' => $request->corso_id,
            'n_edizione' => $request->edizione_corso,
            'codice' => $codice,
            'description' => $request->description,
            'data_richiesta_preventivo' => is_null($request->data_richiesta_preventivo) ? Carbon::now()->format('Y-m-d') : Carbon::parse($request->data_richiesta_preventivo)->format('Y-m-d'),
            'data_scadenza_preventivo' => is_null($request->data_scadenza_preventivo) ? Carbon::now()->addDays(15)->format('Y-m-d') : Carbon::parse($request->data_scadenza_preventivo)->format('Y-m-d'),
            'stato' => $request->stato,
            'val_offerta_tot' => $request->val_offerta_tot,
            'finanziamento' => is_null($request->finanziamento) ? 0 : 1,
            'val_offerta_no_finanz' => $request->val_offerta_no_finanz,
            'val_offerta_finanz' => $request->val_offerta_finanz,
            'individuale_gruppo' => $request->individuale_gruppo,
            'note' => $request->note,
        ]);

        foreach($request->service_id as $index => $service) {
            DB::table('offerte_servizi')->insert([
                'offerta_id' => $offerta->id,
                'service_id' => $service
            ]);
        }

        if($request->stato == 'accettata') {
            return redirect('/commesse/create')->with('offerta', $offerta);
        }

        return redirect('/offerte')->with('status', 'Aggiunta nuova offerta');
    }

    public function show($id)
    {
        $offerta = Offerta::findOrFail($id);
        $services = DB::table('offerte_servizi')
        ->where('offerta_id', '=', $offerta->id)
        ->join('services', 'offerte_servizi.service_id', '=', 'services.id')
        ->pluck('services.name')
        ->toArray();

        $ids = DB::table('offerte_servizi')->where('offerta_id','=',$offerta->id)->pluck('service_id')->toArray();
        $offerta->services = $services;
        return view('offerte.show',compact('offerta'));
    }

    public function edit($id)
    {
        $offerta = Offerta::findOrFail($id);
        $offerta->services = DB::table('offerte_servizi')->where('offerta_id','=',$id)->pluck('service_id')->toArray();
        $bandi = Bando::all();
        $companies = Company::all();
        $services = Service::all();
        $customers = Customer::all();
        $users = User::all();
        
        return view('offerte.edit',compact('bandi','companies', 'services', 'offerta', 'customers','users'));
    }

    public function update(Request $request, $id)
    {
        $offerta = Offerta::findOrFail($id);

        $old_stato = $offerta->stato;

        $data = [
            'company_id' => 'required|exists:companies,id',
            'customer_id' => 'required|exists:customers,id',
            'user_id' => 'required|exists:users,id',
            'description' => 'required',
            'stato' => 'required|string|max:255',
            'val_offerta_tot' => 'required|string|max:255',
        ];

        if($request->finanziamento) {
            $data['bando_id'] = 'required|exists:bandi,id';
            $data['val_offerta_no_finanz'] = 'required';
            $data['val_offerta_finanz'] = 'required';
        }

        $request->validate($data);

        $offerta->company_id = $request->company_id;
        $offerta->customer_id = $request->customer_id;
        $offerta->user_id = $request->user_id;
        $offerta->bando_id = $request->bando_id;
        $offerta->corso_id = $request->corso_id;
        $offerta->n_edizione = $request->edizione_corso;
        $offerta->description = $request->description;
        $offerta->data_richiesta_preventivo = $request->data_richiesta_preventivo;
        $offerta->data_scadenza_preventivo = $request->data_scadenza_preventivo;
        $offerta->stato = $request->stato;
        $offerta->val_offerta_tot = $request->val_offerta_tot;
        $offerta->finanziamento = $request->finanziamento ? 1 : 0;
        $offerta->val_offerta_no_finanz = $request->val_offerta_no_finanz;
        $offerta->val_offerta_finanz = $request->val_offerta_finanz;
        $offerta->individuale_gruppo = $request->individuale_gruppo;
        $offerta->note = $request->note;

        $offerta->save();

        $old_services = DB::table('offerte_servizi')->where('offerta_id', '=', $id)->pluck('service_id')->toArray();
        $new_services = $request->service_id;

        $diff = array_diff($old_services, $new_services);
        if(count($diff) > 0) {
            DB::table('offerte_servizi')->where('offerta_id', '=', $id)->whereIn('service_id', $diff)->delete();
        }
        
        foreach($new_services as $index => $service_id) {
            if(!in_array($service_id, $old_services)) {
                DB::table('offerte_servizi')->insert([
                    'offerta_id' => $id,
                    'service_id' => $service_id
                ]);
            }
        }

        if($old_stato != 'accettata' && $request->stato == 'accettata') {
            return redirect('/commesse/create')->with('offerta', $offerta);
        }

        return redirect('/offerte')->with('status', 'I dati dell\'offerta sono stati aggiornati');
    }


    public function getOffertaById(Request $request)
    {
        $response = [
            'status' => false,
            'message' => 'Errore endpoint'
        ];

        try {
            $validation_data = [
                'offerta_id' => ['required'],
            ];

            $validator = Validator::make($request->all(), $validation_data);

            if ($validator->fails()) {
                $response['message'] = 'Errore validazione endpoint';
                return response()->json($response);
            }

            $offerta = Offerta::find($request->offerta_id);
            $company = $offerta->company;
            $customer = $offerta->customer;
            $services = DB::table('offerte_servizi')->where('offerta_id','=',$offerta->id)->pluck('service_id')->toArray();

            $response['status'] = true;
            $response['message'] = 'ok';
            $response['offerta'] = $offerta;
            $response['bando'] = $offerta->bando;
            $response['company'] = $company;
            $response['customer'] = $customer;
            $response['services'] = $services;
            return response()->json($response);

        } catch(\Exception $e) {
            $response['message'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function export()
    {
        $offerte = Offerta::all();
        $to_export = [];

        foreach($offerte as $offerta) {
            $servizi = DB::table('offerte_servizi')
                        ->leftJoin('services', 'offerte_servizi.service_id', '=', 'services.id')
                        ->where('offerte_servizi.offerta_id', '=', $offerta->id)
                        ->pluck('name')
                        ->toArray();
            $item = [
                'id' => $offerta->id,
                'codice' => $offerta->codice,
                'azienda' => $offerta->company->rag_soc,
                'referente' => $offerta->customer->nome .' '. $offerta->customer->cognome,
                'responsabile offerta' => $offerta->user->name,
                'bando' => $offerta->bando ? $offerta->bando->nome : '',
                'codice bando' => $offerta->bando ? $offerta->bando->codice : '',
                'descrizione offerta' => $offerta->description,
                'data richiesta preventivo' => $offerta->data_richiesta_preventivo ? Carbon::parse($offerta->data_richiesta_preventivo)->format('Y-m-d') : 'N/A',
                'data scadenza preventivo' => $offerta->data_scadenza_preventivo ? Carbon::parse($offerta->data_scadenza_preventivo)->format('Y-m-d') : 'N/A',
                'stato' => $offerta->stato,
                'valore totale' => number_format($offerta->val_offerta_tot, 2, '.', ''),
                'finanziamento' => $offerta->finanziamento ? 'sì' : 'no',
                'valore non finanziato' => number_format($offerta->val_offerta_no_finanz, 2, '.', ''),
                'valore finanziato' => number_format($offerta->val_offerta_finanz, 2, '.', ''),
                'Tipologia servizi' => $servizi ? implode(", ",$servizi) : 'N/A',
                'corso' => $offerta->corso ? $offerta->corso->titolo : 'N/A',
                'ore corso' => $offerta->corso ? $offerta->corso->ore .'h' : 'N/A',
                'edizione' => $offerta->n_edizione,
                'individuale_gruppo' => $offerta->individuale_gruppo,
                'note' => $offerta->note,
            ];
            array_push($to_export, $item);
        }

        $stream = SimpleExcelWriter::streamDownload('lista_offerte.xlsx');
        $writer = $stream->getWriter();
        
        $scartiSheet = $writer->getCurrentSheet();
        $scartiSheet->setName('Lista');
        $stream->addRows($to_export);

        return $stream->toBrowser();
    }

    public function destroy($id)
    {
        Offerta::findOrFail($id)->delete();
        return redirect()->back()->with('status', 'L\'offerta è stata eliminata');   
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
            Offerta::whereIn('id', $ids)->delete();

            $response['status'] = true;
            return response()->json($response);

        } catch(\Exception $e) {
            $response['message'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function createCommessa($id)
    {
        return redirect()->route('commesse.create')->with('offerta_id', $id);
    }

    public function accept($id)
    {
        $offerta = Offerta::findOrFail($id);
        $offerta->stato = 'accettata';
        $offerta->save();
        return redirect()->route('commesse.create')->with('offerta_id', $offerta->id);
    }
}
