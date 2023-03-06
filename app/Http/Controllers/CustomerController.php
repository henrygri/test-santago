<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Ruoli;
use App\Models\User;
use App\Models\Settori;
use App\Models\Service;
use App\Models\Company;
use App\Models\Offerta;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Spatie\SimpleExcel\SimpleExcelReader;
use Validator;
use DB;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Response;
use Storage;
use Session;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function list($stato)
    {
        if(!in_array($stato, ['lead','contattato','prospect','cliente'])) {
            abort(404);
        }

        $customers = Customer::where('stato','=',$stato)->orderBy('created_at', 'desc')->get();
        if($stato == 'prospect') {
            $data = [];
            $offerte = Offerta::all();
            foreach ($offerte as $key => $item) {
                $data[$item['company_id']][$key] = $item;
            }

            foreach($data as $index => $item) {
                foreach($item as $element) {
                    if($element->stato == 'accettata') {
                        unset($data[$index]);
                    }
                }
            }

            $prospects = [];

            foreach($data as $index => $element) {
                array_push($prospects, Company::findOrFail($index));
            }
            
            return view('customer.prospect',compact('prospects'));
        }

        if($stato == 'cliente') {
            $data = [];
            $offerte = Offerta::all();
            foreach ($offerte as $key => $item) {
                $data[$item['company_id']][$key] = $item;
            }

            foreach($data as $index => $item) {
                $stati = [];
                foreach($item as $element) {
                    array_push($stati, $element->stato);
                }
                if(!in_array('accettata', $stati)) {
                    unset($data[$index]);
                }
            }

            $clienti = [];

            foreach($data as $index => $element) {
                array_push($clienti, Company::findOrFail($index));
            }

            return view('customer.clienti',compact('clienti'));
        }
        return view('customer.index',compact('customers', 'stato'));
    }

    public function create($stato)
    {
        $_ruoli = Ruoli::all();
        $ruoli = [];
        foreach($_ruoli as $r) {
            if(is_null($r->parent_id)) {
                $ruoli[$r->nome] = Ruoli::where('parent_id', '=', $r->id)->get()->toArray();
            }
        }
        $data = [
            'users' => User::all(),
            'settori' => Settori::all(),
            'services' => Service::all(),
            'ruoli' => $ruoli,
            'stato' => $stato
        ];
        /*
        $users = User::all();
        $settori = Settori::all();
        $services = Service::all();
        */

        if(Session::has('company_id')) {
            $data['company'] = Company::findOrFail(Session::get('company_id'));
        }
        //return view('customer.create', compact('ruoli', 'users', 'stato', 'settori', 'services'));
        return view('customer.create', $data);
    }

    public function store(Request $request)
    {

        $data = [
            'nome' => 'required',
            'cognome' => 'required',
            'email' => 'required|email|unique:customers',
            'sorgente_acquisizione' => 'required',
            'ruolo_id' => 'required',
            'user_id' => 'required|exists:users,id',
            'privato' => 'required',
            'stato_cliente' => 'required'
        ];

        if($request->privato == 'azienda') {
            $data['company_id'] = 'required';
        }

        $request->validate($data);
       
        $customer = DB::table('customers')->insert([
            'nome' => $request->nome,
            'cognome' => $request->cognome,
            'email' => $request->email,
            'ruolo_id' => $request->ruolo_id,
            'company_id' => $request->company_id,
            'email_aziendale_generica' => $request->email_aziendale_generica,
            'stato' => $request->stato,
            'sorgente_acquisizione' => $request->sorgente_acquisizione,
            'privato' => strlen($request->privato) > 0 ? ($request->privato == 'privato' ? 1 : 0) : null,
            'user_id' => $request->user_id,
            'email_aziendale' => $request->email_aziendale,
            'telefono_ufficio' => $request->telefono_ufficio,
            'telefono_personale' => $request->telefono_personale,
            'service_id' => $request->service_id,
            'stato_cliente' =>  $request->stato_cliente,
            'data_creazione_lead' => strlen($request->data_creazione_lead) > 0 ? $request->data_creazione_lead : DB::raw('NOW()'),
            'note' => $request->note,
            'created_at' => DB::raw('NOW()')
        ]);

        return redirect('/list/'.$request->stato)->with('status', 'Aggiunto nuovo record');
    }

    public function show($stato, $id)
    {
        $customer = Customer::findOrFail($id);
        return view('customer.show',compact('stato', 'customer'));
    }

    public function edit($stato,$id)
    {
        $_ruoli = Ruoli::all();
        $ruoli = [];
        foreach($_ruoli as $r) {
            if(is_null($r->parent_id)) {
                $ruoli[$r->nome] = Ruoli::where('parent_id', '=', $r->id)->get()->toArray();
            }
        }
        $users = User::all();
        $settori = Settori::all();
        $services = Service::all();
        $customer = Customer::findOrFail($id);
        $require_company = false;
        if($customer->privato && $customer->stato == 'contattato' && !is_object($customer->company)) {
            $require_company = true;
        }
        return view('customer.edit',compact('customer','ruoli','users','settori','services','require_company'));
    }

    public function update(Request $request, $id)
    {
        if($request->stato == 'lead' || $request->stato == 'contattato') {
            $data = [
                'nome' => 'required',
                'cognome' => 'required',
                'email' => 'required|email|unique:customers,email,'.$id,
                'sorgente_acquisizione' => 'required',
                'ruolo_id' => 'required',
                'user_id' => 'required|exists:users,id',
                'privato' => 'required',
                'stato_cliente' => 'required'
            ];
            if($request->privato == 'azienda') {
                $data['company_id'] = 'required';
            }
            $request->validate($data);
        }
       
        $customer = DB::table('customers')->where('id', '=', $id)->update([
            'nome' => $request->nome,
            'cognome' => $request->cognome,
            'email' => $request->email,
            'ruolo_id' => $request->ruolo_id,
            'company_id' => strlen($request->privato) > 0 ? ($request->privato == 'privato' ? null : $request->company_id) : null,
            'email_aziendale_generica' => $request->email_aziendale_generica,
            'stato' => $request->stato,
            'sorgente_acquisizione' => $request->sorgente_acquisizione,
            'privato' => strlen($request->privato) > 0 ? ($request->privato == 'privato' ? 1 : 0) : null,
            'user_id' => $request->user_id,
            'email_aziendale' => $request->email_aziendale,
            'telefono_ufficio' => $request->telefono_ufficio,
            'telefono_personale' => $request->telefono_personale,
            'data_creazione_lead' => $request->data_creazione_lead,
            'service_id' => $request->service_id,
            'stato_cliente' =>  $request->stato_cliente,
            'note' => $request->note,
        ]);

        return redirect('/list/'.$request->stato)->with('status', 'I dati del record sono stati aggiornati');
    }

    public function export($stato)
    {
        $customers = Customer::where('stato', '=', $stato)->with('user', 'ruolo', 'company')->get();
        $to_export = [];
        foreach($customers as $customer) {
            $item = [
                "id" => $customer->id,
                "nome" => $customer->nome,
                "cognome" => $customer->cognome,
                "email" => $customer->email,
                "email aziendale personale" => $customer->email_aziendale,
                "email aziendale generica" => $customer->email_aziendale_generica,
                "telefono ufficio" => $customer->telefono_ufficio,
                "telefono personale" => $customer->telefono_personale,
                "note" => $customer->note,
                "assegnato a" => $customer->user->name,
                "azienda" => !is_null($customer->privato) ? ($customer->privato == 1 ? 'N/A' : $customer->company->rag_soc) : 'N/A',
                "ruolo" => $customer->ruolo->nome,
                "privato" => !is_null($customer->privato) ? ($customer->privato == 1 ? 'si' : 'no') : 'N/A',
                "fonte" => $customer->sorgente_acquisizione,
                "servizi" => $customer->service_id ? $customer->service->name : 'N/A',
                "stato" => $customer->stato_cliente,
                "data creazione lead" => $customer->data_creazione_lead,
            ];
            array_push($to_export, $item);
        }

        $stream = SimpleExcelWriter::streamDownload('lista_'.$stato.'.xlsx');
        $writer = $stream->getWriter();
        
        $scartiSheet = $writer->getCurrentSheet();
        $scartiSheet->setName('Lista');
        $stream->addRows($to_export);

        return $stream->toBrowser();
    }

    public function getListByCompanyId(Request $request)
    {
        $response = [
            'status' => false,
            'message' => 'Errore endpoint'
        ];

        try {
            $validation_data = [
                'company_id' => ['required', 'exists:companies,id'],
            ];

            $validator = Validator::make($request->all(), $validation_data);

            if ($validator->fails()) {
                $response['message'] = 'Errore validazione endpoint';
                return response()->json($response);
            }

            $customers = Customer::where('company_id', '=', $request->company_id)->get();

            $response['status'] = true;
            $response['customers'] = $customers;
            $response['message'] = 'ok';
            return response()->json($response);

        } catch(\Exception $e) {
            $response['message'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function showProspect($id)
    {
        $company = Company::findOrFail($id);
        return view('customer.show-prospect',compact('company'));
    }

    public function showClient($id)
    {
        $company = Company::findOrFail($id);
        return view('customer.show-client',compact('company'));
    }

    public function newCustomer(Request $request)
    {
        $response = [
            'status' => false,
            'message' => 'Errore endpoint'
        ];

        try {
            $validation_data = [
                'company_id' => ['required', 'exists:companies,id'],
                'nome' => ['required'],
                'cognome' => ['required'],
                'email' => ['required', 'email', 'unique:customers'],
                'sorgente_acquisizione' => ['required'],
                'ruolo_id' => ['required'],
                'user_id' => ['required', 'exists:users,id'],
                'privato' => ['required']
            ];

            $validator = Validator::make($request->all(), $validation_data);


            if ($validator->fails()) {
                $response['message'] = 'Errore validazione endpoint';
                return response()->json($response);
            }
           
            $customer_id = DB::table('customers')->insertGetId([
                'nome' => $request->nome,
                'cognome' => $request->cognome,
                'stato' => 'contattato',
                'email' => $request->email,
                'ruolo_id' => $request->ruolo_id,
                'company_id' => $request->company_id,
                'sorgente_acquisizione' => $request->sorgente_acquisizione,
                'privato' => strlen($request->privato) > 0 ? ($request->privato == 'privato' ? 1 : 0) : null,
                'user_id' => $request->user_id,
                'stato' => 'contattato',
                'stato_cliente' => 'contattato',
                'data_creazione_lead' => DB::raw('NOW()'),
                'created_at' => DB::raw('NOW()')
            ]);

            $customer = DB::table('customers')->where('id', '=', $customer_id)->first();

            $response['status'] = true;
            $response['customer'] = $customer;
            return response()->json($response);

        } catch(\Exception $e) {
            $response['message'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function clone($id)
    {
        $faker = Faker::create();
        $old_contact = Customer::findOrFail($id);
        $new_contact = $old_contact->replicate();
        $new_contact->email = $faker->unique()->email;
        $new_contact->created_at = Carbon::now();
        $new_contact->data_creazione_lead = Carbon::now();
        $new_contact->save();
        return redirect()->back()->with('status', 'Il contatto è stato duplicato');
    }

    public function convert($id)
    {
        $lead = Customer::findOrFail($id);
        $lead->stato = 'contattato';
        $lead->stato_cliente = 'contattato';
        $lead->save();
        return redirect('/list/contattato/'.$lead->id);
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
            Customer::whereIn('id', $ids)->delete();

            $response['status'] = true;
            return response()->json($response);

        } catch(\Exception $e) {
            $response['message'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function destroy($id)
    {
        Customer::findOrFail($id)->delete();
        return redirect()->back()->with('status', 'Il cliente è stato eliminato');   
    }

    public function download()
    {
        $file_path = storage_path('app/import_leads_santagostino.xlsx');
        if(file_exists($file_path)) {
            return Response::download($file_path, 'IMPORT_MODELLO_LEAD.xlsx', [
                'Content-Length: '. filesize($file_path)
            ]);
        }
    }

    public function import(Request $request)
    {
        try {
            $request->validate([
                'import_file' => 'required'
            ]);

            if($request->hasFile('import_file')) {
                $image = $request->file('import_file');
                $tmp_name = 'import_'.time().'.'.$image->getClientOriginalExtension();
                $request->import_file->move(storage_path('app'), $tmp_name);

                $pathToFile = storage_path('app/'.$tmp_name);
                $rows = SimpleExcelReader::create($pathToFile)->getRows();

                $rows->each(function(array $rowProperties) {
                    $company_id = null;
                    if($rowProperties['tipologia'] == 'AZIENDA') {
                        $company = Company::create([
                            'user_id' => auth()->user()->id,
                            'rag_soc' => $rowProperties['nome_azienda'],
                            'settore_id' => $rowProperties['id_settore'],
                        ]);
                        $company_id = $company->id;
                    }
                    $lead = DB::table('customers')->insert([
                        'nome' => $rowProperties['nome'],
                        'cognome' => $rowProperties['cognome'],
                        'email' => $rowProperties['email'],
                        'ruolo_id' => $rowProperties['id_ruolo'],
                        'company_id' => $company_id,
                        'stato' => 'lead',
                        'privato' => $rowProperties['tipologia'] == 'AZIENDA' ? 0 : 1,
                        'user_id' => auth()->user()->id,
                        'stato_cliente' =>  'non_qualificato',
                        'data_creazione_lead' => DB::raw('NOW()'),
                    ]);
                });

                unlink($pathToFile);
            }

            return redirect('/list/lead')->with('status', 'Leads importati correttamente');

        } catch(\Exception $e) {
            return redirect('/list/lead')->with('error', $e->getMessage());
        }
    }

    public function export_prospect()
    {
        $customers = Customer::where('stato','=','prospect')->orderBy('created_at', 'desc')->get();
        $data = [];
        $offerte = Offerta::all();
        foreach ($offerte as $key => $item) {
            $data[$item['company_id']][$key] = $item;
        }

        foreach($data as $index => $item) {
            foreach($item as $element) {
                if($element->stato == 'accettata') {
                    unset($data[$index]);
                }
            }
        }

        $prospects = [];

        foreach($data as $index => $element) {
            array_push($prospects, Company::findOrFail($index));
        }

        $to_export = [];
        foreach($prospects as $prospect) {
            $item = [
                "id" => $prospect->id,
                'assegnato a' => $prospect->user->name,
                "Ragione sociale" => $prospect->rag_soc,
                'settore' => $prospect->settore->nome,
                'cod_fisc' => $prospect->cod_fisc,
                'p_iva' => $prospect->p_iva,
                'p_iva_collegata' => $prospect->p_iva_collegata,
                "telefono" => $prospect->phone,
                "Privato" => $prospect->privato ? 'Sì' : 'No',
                'tipo' => $prospect->tipo,
                'indirizzo_legale' => $prospect->indirizzo_legale,
                'comune_legale' => $prospect->comune_legale,
                'provincia_legale' => $prospect->provincia_legale,
                'cap_legale' => $prospect->cap_legale,
                'regione_legale' => $prospect->regione_legale,
                'nazione_legale' => $prospect->nazione_legale,
                'tipologia_organizzativa' => $prospect->tipologia_organizzativa,
                'fatturato_annuo' => $prospect->fatturato_annuo,
                'n_dipendenti' => $prospect->n_dipendenti,
                'data_contatto' => $prospect->data_contatto,
                'come_ci_ha_conosciuto' => $prospect->come_ci_ha_conosciuto,
                'fondo_dirigenti' => $prospect->fondo_dirigenti,
                'fondo_non_dirigenti' => $prospect->fondo_non_dirigenti,
                'rsa_rsu' => $prospect->rsa_rsu ? 'sì' : 'no',
                'privato' => $prospect->privato ? 'sì' : 'no',
                'fornitori_attuali' => $prospect->fornitori_attuali,
                'potenziale_fatturato_formazione' => $prospect->potenziale_fatturato_formazione,
                'potenziale_fatturato_selezione' => $prospect->potenziale_fatturato_selezione,
                'potenziale_fatturato_pal' => $prospect->potenziale_fatturato_pal,
                'potenziale_fatturato_consulenza' => $prospect->potenziale_fatturato_consulenza,
            ];
            array_push($to_export, $item);
        }

        $stream = SimpleExcelWriter::streamDownload('lista_prospect.xlsx');
        $writer = $stream->getWriter();
    
        $scartiSheet = $writer->getCurrentSheet();
        $scartiSheet->setName('Lista');
        $stream->addRows($to_export);

        return $stream->toBrowser();
        
    }


    public function export_clienti()
    {
        $data = [];
        $offerte = Offerta::all();
        foreach ($offerte as $key => $item) {
            $data[$item['company_id']][$key] = $item;
        }

        foreach($data as $index => $item) {
            $stati = [];
            foreach($item as $element) {
                array_push($stati, $element->stato);
            }
            if(!in_array('accettata', $stati)) {
                unset($data[$index]);
            }
        }

        $clienti = [];

        foreach($data as $index => $element) {
            array_push($clienti, Company::findOrFail($index));
        }

        
        $to_export = [];

        foreach($clienti as $cliente) {

            $item = [
                "id" => $cliente->id,
                'assegnato a' => $cliente->user->name,
                "Ragione sociale" => $cliente->rag_soc,
                'settore' => $cliente->settore->nome,
                'cod_fisc' => $cliente->cod_fisc,
                'p_iva' => $cliente->p_iva,
                'p_iva_collegata' => $cliente->p_iva_collegata,
                "telefono" => $cliente->phone,
                "Privato" => $cliente->privato ? 'Sì' : 'No',
                'tipo' => $cliente->tipo,
                'indirizzo_legale' => $cliente->indirizzo_legale,
                'comune_legale' => $cliente->comune_legale,
                'provincia_legale' => $cliente->provincia_legale,
                'cap_legale' => $cliente->cap_legale,
                'regione_legale' => $cliente->regione_legale,
                'nazione_legale' => $cliente->nazione_legale,
                'tipologia_organizzativa' => $cliente->tipologia_organizzativa,
                'fatturato_annuo' => $cliente->fatturato_annuo,
                'n_dipendenti' => $cliente->n_dipendenti,
                'data_contatto' => $cliente->data_contatto,
                'come_ci_ha_conosciuto' => $cliente->come_ci_ha_conosciuto,
                'fondo_dirigenti' => $cliente->fondo_dirigenti,
                'fondo_non_dirigenti' => $cliente->fondo_non_dirigenti,
                'rsa_rsu' => $cliente->rsa_rsu ? 'sì' : 'no',
                'privato' => $cliente->privato ? 'sì' : 'no',
                'fornitori_attuali' => $cliente->fornitori_attuali,
                'potenziale_fatturato_formazione' => $cliente->potenziale_fatturato_formazione,
                'potenziale_fatturato_selezione' => $cliente->potenziale_fatturato_selezione,
                'potenziale_fatturato_pal' => $cliente->potenziale_fatturato_pal,
                'potenziale_fatturato_consulenza' => $cliente->potenziale_fatturato_consulenza,
            ];
            array_push($to_export, $item);
        }

        $stream = SimpleExcelWriter::streamDownload('lista_clienti.xlsx');
        $writer = $stream->getWriter();
    
        $scartiSheet = $writer->getCurrentSheet();
        $scartiSheet->setName('Lista');
        $stream->addRows($to_export);

        return $stream->toBrowser();
        
     }
}
