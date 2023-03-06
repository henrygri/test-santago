<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Settori;
use App\Models\Customer;
use App\Models\User;
use Spatie\SimpleExcel\SimpleExcelWriter;

use Validator;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $companies = Company::where('privato','!=', 1)->orderBy('created_at', 'desc')->get();
        $companiesPrivate = Company::where('privato','=', 1)->orderBy('created_at', 'desc')->get();
        return view('company.index',compact('companies','companiesPrivate'));
    }

    public function create()
    {
        $users = User::all();
        $settori = Settori::all();
        return view('company.create', compact('settori', 'users'));
    }

    public function store(Request $request)
    {
        $data = [
            'rag_soc' => 'required',
            'settore_id' => 'required|exists:settori,id',
            'phone' => 'required',
            'come_ci_ha_conosciuto' => 'required',
            'cod_fisc' => 'required|unique:companies,cod_fisc',
            'indirizzo_legale' => 'required',
            'comune_legale' => 'required',
            'provincia_legale' => 'required',
            'cap_legale' => 'required',
            'regione_legale' => 'required',
            'nazione_legale' => 'required',
        ];
        if(!$request->has('privato')) {
            $data['p_iva'] = 'required|unique:companies,p_iva';
            /*
            $data['indirizzo_legale'] = 'required';
            $data['comune_legale'] = 'required';
            $data['provincia_legale'] = 'required';
            $data['cap_legale'] = 'required';
            $data['regione_legale'] = 'required';
            $data['nazione_legale'] = 'required';
            */
        }
        $request->validate($data);

        $sedi = [];
        //if(is_null($request->privato)) {
            foreach($request->indirizzo_operativo as $key => $t) {
                if(strlen($t) > 0) {
                    $sedi[$key]['indirizzo_operativo'] = $t;
                    $sedi[$key]['comune_operativo'] = $request->comune_operativo[$key];
                    $sedi[$key]['provincia_operativo'] = $request->provincia_operativo[$key];
                    $sedi[$key]['cap_operativo'] = $request->cap_operativo[$key];
                    $sedi[$key]['regione_operativo'] = $request->regione_operativo[$key];
                    $sedi[$key]['nazione_operativo'] = $request->nazione_operativo[$key];
                }
            }
        //}


        $company = Company::create([
            'user_id' => strlen($request->user_id) > 0 ? $request->user_id : null,
            'rag_soc' => $request->rag_soc,
            'settore_id' => $request->settore_id,
            'cod_fisc' => $request->cod_fisc,
            'p_iva' => $request->p_iva,
            'p_iva_collegata' => $request->p_iva_collegata,
            'phone' => $request->phone,
            'tipo' => $request->tipo,
            'indirizzo_legale' => $request->indirizzo_legale,
            'comune_legale' => $request->comune_legale,
            'provincia_legale' => $request->provincia_legale,
            'cap_legale' => $request->cap_legale,
            'regione_legale' => $request->regione_legale,
            'nazione_legale' => $request->nazione_legale,
            /*
            'indirizzo_operativo' => $request->indirizzo_operativo,
            'comune_operativo' => $request->comune_operativo,
            'provincia_operativo' => $request->provincia_operativo,
            'cap_operativo' => $request->cap_operativo,
            'regione_operativo' => $request->regione_operativo,
            'nazione_operativo' => $request->nazione_operativo,
            */
            'sedi' => json_encode($sedi),
            'tipologia_organizzativa' => $request->tipologia_organizzativa,
            'fatturato_annuo' => $request->fatturato_annuo,
            'n_dipendenti' => $request->n_dipendenti,
            'data_ricontattare' => $request->data_ricontattare,
            'data_contatto' => $request->data_contatto,
            'come_ci_ha_conosciuto' => $request->come_ci_ha_conosciuto,
            'fondo_dirigenti' => $request->fondo_dirigenti,
            'fondo_non_dirigenti' => $request->fondo_non_dirigenti,
            'rsa_rsu' => !is_null($request->rsa_rsu) ? 1 : 0,
            'privato' => $request->has('privato') ? 1 : 0,
            'fornitori_attuali' => $request->fornitori_attuali,
            'potenziale_fatturato_formazione' => $request->potenziale_fatturato_formazione,
            'potenziale_fatturato_selezione' => $request->potenziale_fatturato_selezione,
            'potenziale_fatturato_pal' => $request->potenziale_fatturato_pal,
            'potenziale_fatturato_consulenza' => $request->potenziale_fatturato_consulenza,
        ]);

        return redirect('/aziende')->with('status', 'Aggiunta nuova azienda');
    }

    public function show($id)
    {
        $company = Company::findOrFail($id);
        return view('company.show',compact('company'));
    }

    public function edit($id)
    {
        $users = User::all();
        $company = Company::findOrFail($id);
        $settori = Settori::all();
        return view('company.edit',compact('company','settori', 'users'));
    }

    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        /*
        $data = [
            'rag_soc' => 'required',
            'settore_id' => 'required|exists:settori,id',
            'phone' => 'required'
        ];
        if(!is_null($request->privato)) {
            $data['cod_fisc'] = 'required';
        } else {
            $data['p_iva'] = 'required';
            $data['indirizzo_legale'] = 'required';
            $data['comune_legale'] = 'required';
            $data['provincia_legale'] = 'required';
            $data['cap_legale'] = 'required';
            $data['regione_legale'] = 'required';
            $data['nazione_legale'] = 'required';
        }
        */
        $data = [
            'rag_soc' => 'required',
            'settore_id' => 'required|exists:settori,id',
            'phone' => 'required',
            'come_ci_ha_conosciuto' => 'required',
            'cod_fisc' => 'required|unique:companies,cod_fisc,'.$id,
            'indirizzo_legale' => 'required',
            'comune_legale' => 'required',
            'provincia_legale' => 'required',
            'cap_legale' => 'required',
            'regione_legale' => 'required',
            'nazione_legale' => 'required',
        ];
        if(!$request->has('privato')) {
            $data['p_iva'] = 'required|unique:companies,p_iva,'.$id;
            /*
            $data['indirizzo_legale'] = 'required';
            $data['comune_legale'] = 'required';
            $data['provincia_legale'] = 'required';
            $data['cap_legale'] = 'required';
            $data['regione_legale'] = 'required';
            $data['nazione_legale'] = 'required';
            */
        }
        

        $request->validate($data);

        $sedi = [];
        //if(is_null($request->privato)) {
            foreach($request->indirizzo_operativo as $key => $t) {
                if(strlen($t) > 0) {
                    $sedi[$key]['indirizzo_operativo'] = $t;
                    $sedi[$key]['comune_operativo'] = $request->comune_operativo[$key];
                    $sedi[$key]['provincia_operativo'] = $request->provincia_operativo[$key];
                    $sedi[$key]['cap_operativo'] = $request->cap_operativo[$key];
                    $sedi[$key]['regione_operativo'] = $request->regione_operativo[$key];
                    $sedi[$key]['nazione_operativo'] = $request->nazione_operativo[$key];
                }
            }
        //}

        $company->user_id = strlen($request->user_id) > 0 ? $request->user_id : null;
        $company->rag_soc = $request->rag_soc;
        $company->settore_id = $request->settore_id;
        $company->cod_fisc = $request->cod_fisc;
        $company->p_iva = $request->p_iva;
        $company->p_iva_collegata = $request->p_iva_collegata;
        $company->phone = $request->phone;
        $company->tipo = $request->tipo;
        $company->indirizzo_legale = $request->indirizzo_legale;
        $company->comune_legale = $request->comune_legale;
        $company->provincia_legale = $request->provincia_legale;
        $company->cap_legale = $request->cap_legale;
        $company->regione_legale = $request->regione_legale;
        $company->nazione_legale = $request->nazione_legale;
        $company->indirizzo_legale = $request->indirizzo_legale;
        $company->comune_legale = $request->comune_legale;
        /*
        $company->indirizzo_operativo = $request->indirizzo_operativo;
        $company->comune_operativo = $request->comune_operativo;
        $company->provincia_operativo = $request->provincia_operativo;
        $company->cap_operativo = $request->cap_operativo;
        $company->regione_operativo = $request->regione_operativo;
        $company->nazione_operativo = $request->nazione_operativo;
        */
        $company->sedi = json_encode($sedi);
        $company->tipologia_organizzativa = $request->tipologia_organizzativa;
        $company->fatturato_annuo = $request->fatturato_annuo;
        $company->n_dipendenti = $request->n_dipendenti;
        $company->data_ricontattare = $request->data_ricontattare;
        $company->data_contatto = $request->data_contatto;
        $company->come_ci_ha_conosciuto = $request->come_ci_ha_conosciuto;
        $company->fondo_dirigenti = $request->fondo_dirigenti;
        $company->fondo_non_dirigenti = $request->fondo_non_dirigenti;
        $company->rsa_rsu = !is_null($request->rsa_rsu) ? 1 : 0;
        $company->privato = $request->has('privato') ? 1 : 0;
        $company->fornitori_attuali = $request->fornitori_attuali;
        $company->potenziale_fatturato_formazione = $request->potenziale_fatturato_formazione;
        $company->potenziale_fatturato_selezione = $request->potenziale_fatturato_selezione;
        $company->potenziale_fatturato_pal = $request->potenziale_fatturato_pal;
        $company->potenziale_fatturato_consulenza = $request->potenziale_fatturato_consulenza;

        $company->save();

        return redirect('/aziende')->with('status', 'I dati dell\' azienda sono stati aggiornati');
    }

    public function export()
    {
        $companies = Company::all();
        $to_export = [];
        foreach($companies as $company) {
            $item = [
                'id' => $company->id,
                'assegnato a' => $company->user ? $company->user->name : 'N/A',
                'rag_soc' => $company->rag_soc,
                'settore' => $company->settore->nome,
                'cod_fisc' => $company->cod_fisc,
                'p_iva' => $company->p_iva,
                'p_iva_collegata' => $company->p_iva_collegata,
                'telefono' => $company->phone,
                'tipo' => $company->tipo,
                'indirizzo_legale' => $company->indirizzo_legale,
                'comune_legale' => $company->comune_legale,
                'provincia_legale' => $company->provincia_legale,
                'cap_legale' => $company->cap_legale,
                'regione_legale' => $company->regione_legale,
                'nazione_legale' => $company->nazione_legale,
                'tipologia_organizzativa' => $company->tipologia_organizzativa,
                'fatturato_annuo' => number_format($company->fatturato_annuo, 2, '.', ''),
                'n_dipendenti' => $company->n_dipendenti,
                'data_contatto' => $company->data_contatto,
                'come_ci_ha_conosciuto' => $company->come_ci_ha_conosciuto,
                'fondo_dirigenti' => $company->fondo_dirigenti,
                'fondo_non_dirigenti' => $company->fondo_non_dirigenti,
                'rsa_rsu' => $company->rsa_rsu ? 'sì' : 'no',
                'privato' => $company->privato ? 'sì' : 'no',
                'fornitori_attuali' => $company->fornitori_attuali,
                'potenziale_fatturato_formazione' => number_format($company->potenziale_fatturato_formazione, 2, '.', ''),
                'potenziale_fatturato_selezione' => number_format($company->potenziale_fatturato_selezione, 2, '.', ''),
                'potenziale_fatturato_pal' => number_format($company->potenziale_fatturato_pal, 2, '.', ''),
                'potenziale_fatturato_consulenza' => number_format($company->potenziale_fatturato_consulenza, 2, '.', '')
            ];
            array_push($to_export, $item);
        }

        $stream = SimpleExcelWriter::streamDownload('lista_aziende.xlsx');
        $writer = $stream->getWriter();
        
        $scartiSheet = $writer->getCurrentSheet();
        $scartiSheet->setName('Lista');
        $stream->addRows($to_export);

        return $stream->toBrowser();
    }

    public function destroy($id)
    {
        Company::findOrFail($id)->delete();
        return redirect()->back()->with('status', 'L\'azienda è stata eliminata');   
    }

    /* fetch requests */
    public function getList()
    {
        $companies = Company::get();
        return response()->json($companies);
    }

    public function newCompany(Request $request)
    {

        $response = [
            'status' => false,
            'message' => 'Errore endpoint'
        ];


        try {

            $validation_data = [
                'rag_soc' => ['required'],
                'settore_id' => ['required'],
                // 'cod_fisc' => ['unique:companies,cod_fisc'],
                // 'p_iva' => ['unique:companies,p_iva']
            ];

            $validator = Validator::make($request->all(), $validation_data);

            if ($validator->fails()) {
                $response['message'] = 'Errore validazione endpoint';
                return response()->json($response);
            }

            $company = Company::create([
                'rag_soc' => $request->rag_soc,
                'settore_id' => $request->settore_id,
                'privato' => is_null($request->privato) ? 0 : 1,
            ]);

            if($request->privato == true && strlen($request->id_customer) > 0) {
                $customer = Customer::findOrFail($request->id_customer);
                $customer->company_id = $company->id;
                $customer->save();

                $company->come_ci_ha_conosciuto = $request->come_ci_ha_conosciuto;
                $company->cod_fisc = $request->cod_fisc;
                $company->phone = $request->phone;
                $company->user_id = $request->user_id_company;
                $company->data_contatto = $request->data_contatto;
                $company->indirizzo_legale = $request->indirizzo_legale;
                $company->comune_legale = $request->comune_legale;
                $company->provincia_legale = $request->provincia_legale;
                $company->cap_legale = $request->cap_legale;
                $company->regione_legale = $request->regione_legale;
                $company->nazione_legale = $request->nazione_legale;
                $company->save();
            }

            if(!is_object($company)) {
                $response['message'] = 'Errore creazione azienda';
                return response()->json($response);
            }

            $response['status'] = true;
            $response['company_id'] = $company->id;
            return response()->json($response);

        } catch(\Exception $e) {
            $response['message'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function getCompanyById(Request $request)
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

            $company = Company::findOrFail($request->company_id);

            if(!is_object($company)) {
                $response['message'] = 'Errore creazione azienda';
                return response()->json($response);
            }

            if((!$company->privato && (is_null($company->user_id) || is_null($company->cod_fisc) || is_null($company->p_iva) || is_null($company->come_ci_ha_conosciuto) || is_null($company->indirizzo_legale) || is_null($company->comune_legale) || is_null($company->provincia_legale) || is_null($company->cap_legale) || is_null($company->regione_legale) || is_null($company->nazione_legale)))
                || ($company->privato && (is_null($company->user_id) || is_null($company->cod_fisc) || is_null($company->come_ci_ha_conosciuto) || is_null($company->phone)))) {
                $response['status'] = true;
                $response['company'] = $company;
            }

            return response()->json($response);

        } catch(\Exception $e) {
            $response['message'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function storeCompanyData(Request $request)
    {
        //dd($request);
        $response = [
            'status' => false,
            'message' => 'Errore endpoint'
        ];

        try {
            $validation_data = [
                'privato' => ['required'],
                'company_id' => ['required', 'exists:companies,id'],
                'user_id' => ['required', 'exists:users,id'],
                'cod_fisc' => ['required','unique:companies,cod_fisc,'.$request->company_id.''],
                'phone' => ['required'],
                'come_ci_ha_conosciuto' => ['required'],
            ];
            if($request->privato == 0) {
                $validation_data['p_iva'] = ['required','unique:companies,p_iva,'.$request->company_id.''];
                $validation_data['indirizzo_legale'] = 'required';
                $validation_data['provincia_legale'] = 'required';
                $validation_data['cap_legale'] = 'required';
                $validation_data['regione_legale'] = 'required';
                $validation_data['nazione_legale'] = 'required';
                $validation_data['comune_legale'] = 'required';
            }

            $validator = Validator::make($request->all(), $validation_data);

            if ($validator->fails()) {
                $response['message'] = 'Errore validazione endpoint';
                return response()->json($response);
            }

            $company = Company::findOrFail($request->company_id);

            if(!is_object($company)) {
                $response['message'] = 'Errore creazione azienda';
                return response()->json($response);
            }

            $company->user_id = $request->user_id;
            $company->cod_fisc = $request->cod_fisc;
            $company->phone = $request->phone;
            $company->come_ci_ha_conosciuto = $request->come_ci_ha_conosciuto;
            if($request->privato == 0) {
                $company->p_iva = $request->p_iva;
                $company->indirizzo_legale = $request->indirizzo_legale;
                $company->provincia_legale = $request->provincia_legale;
                $company->cap_legale = $request->cap_legale;
                $company->regione_legale = $request->regione_legale;
                $company->nazione_legale = $request->nazione_legale;
                $company->comune_legale = $request->comune_legale;
            }
            $company->save();

            $response['status'] = true;
            return response()->json($response);

        } catch(\Exception $e) {
            $response['message'] = $e->getMessage();
            return response()->json($response);
        }
    }
    /* end fetch requests */

    public function createOfferta($id)
    {
        return redirect()->route('offerte.create')->with('company_id', $id);
    }

    public function createContatto($id)
    {
        return redirect()->to('list/contattato/create')->with('company_id', $id);
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
            Company::whereIn('id', $ids)->delete();

            $response['status'] = true;
            return response()->json($response);

        } catch(\Exception $e) {
            $response['message'] = $e->getMessage();
            return response()->json($response);
        }
    }
}
