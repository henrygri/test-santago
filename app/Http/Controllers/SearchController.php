<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Fornitore;
use App\Models\Bando;
use App\Models\Incarico;
use App\Models\Offerta;
use App\Models\Commessa;
use DB;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function search(Request $request)
    {
        if(!isset($request->adminlteSearch) || strlen($request->adminlteSearch) <= 0) {
            return view('search.index')->with('error', 'Non è stato inserito alcun parametro di ricerca');
        }

        $string_to_search = $request->adminlteSearch;

        $result = [];

        // cercare $string_to_search nelle varie entità

        $result['customers'] = Customer::where('nome', 'like', '%'.$string_to_search.'%')
            ->orWhere('cognome', 'like', '%'.$string_to_search.'%')
            ->orWhere('email', 'like', '%'.$string_to_search.'%')
            ->get();
        $result['companies'] = Company::where('rag_soc', 'like', '%'.$string_to_search.'%')
            ->orWhere('p_iva', 'like', '%'.$string_to_search.'%')
            ->orWhereHas('customers', function($q) use ($string_to_search) {
                $q->where('nome', 'like', '%'.$string_to_search.'%')
                    ->orWhere('cognome', 'like', '%'.$string_to_search.'%')
                    ->orWhere('email', 'like', '%'.$string_to_search.'%');
            })
            ->get();
        $result['offerte'] = Offerta::where('codice', 'like', '%'.$string_to_search.'%')->get();
        $result['commesse'] = Commessa::where('codice', 'like', '%'.$string_to_search.'%')->get();
        $result['fornitori'] = Fornitore::where('rag_soc', 'like', '%'.$string_to_search.'%')
            ->orWhere('email', 'like', '%'.$string_to_search.'%')
            ->orWhere('codice_fiscale', 'like', '%'.$string_to_search.'%')
            ->orWhere('partita_iva', 'like', '%'.$string_to_search.'%')
            ->get();
        $result['bandi'] = Bando::where('codice', '=', $string_to_search)
            ->orWhere('nome', 'like', '%'.$string_to_search.'%')
            ->get();
        $result['incarichi'] = Incarico::where('codice', 'like', '%'.$string_to_search.'%')->get();
        // si conrolla ad es $companies e si verifica se in un ciclo l'elemento è un array in quel caso sitira fuori da lì esi accoda a $result
        //$result = array_merge($customers, $companies, $offerte, $commesse, $fornitori, $bandi, $incarichi);
        //dd($result);
        /*
            case 'Contatti/Lead': 
                $result = Customer::where('nome', 'like', '%'.$string_to_search.'%')->orWhere('cognome', 'like', '%'.$string_to_search.'%')->orWhere('email', 'like', '%'.$string_to_search.'%')->get();
                break;
            case 'Aziende': 
                $result = Company::where('rag_soc', 'like', '%'.$string_to_search.'%')->orWhere('p_iva', 'like', '%'.$string_to_search.'%')->get();
                break;
            case 'Offerte': 
                $result = DB::table('offerte')
                    ->leftJoin('companies', 'offerte.company_id', '=', 'companies.id')
                    ->where('offerte.codice', 'like', '%'.$string_to_search.'%')
                    ->orWhere('companies.rag_soc', 'like', '%'.$string_to_search.'%')
                    ->select('offerte.*', 'companies.rag_soc')
                    ->get();
                break;
            case 'Commesse': 
                $result = DB::table('commesse')
                    ->leftJoin('offerte', 'commesse.offerta_id', '=', 'offerte.id')
                    ->leftJoin('companies', 'commesse.company_id', '=', 'companies.id')
                    ->where('commesse.codice', '=', $string_to_search)
                    ->orWhere('offerte.codice', 'like', '%'.$string_to_search.'%')
                    ->select('commesse.*', 'companies.rag_soc')
                    ->get();
                break;
            case 'Incarichi': 
                $result = DB::table('incarichi')
                    ->leftJoin('fornitori', 'incarichi.fornitore_id', '=', 'incarichi.fornitore_id')
                    ->where('incarichi.codice', '=', $string_to_search)
                    ->orWhere('fornitori.rag_soc', 'like', '%'.$string_to_search.'%')
                    ->orWhere('fornitori.partita_iva', 'like', '%'.$string_to_search.'%')
                    ->orWhere('fornitori.codice_fiscale', 'like', '%'.$string_to_search.'%')
                    ->select('incarichi.*')
                    ->get();
                break;
            case 'Consulenti/Docenti': 
                $result = Fornitore::where('rag_soc', 'like', '%'.$string_to_search.'%')->orWhere('email', 'like', '%'.$string_to_search.'%')->orWhere('codice_fiscale', 'like', '%'.$string_to_search.'%')->orWhere('partita_iva', 'like', '%'.$string_to_search.'%')->get();
                break;
            case 'Piani/Bandi': 
                $result = Bando::where('codice', '=', $string_to_search)->orWhere('nome', 'like', '%'.$string_to_search.'%')->get();
                break;
            */
        
        $tot = count($result['customers']) + count($result['companies']) + count($result['bandi']) + count($result['incarichi']) + count($result['fornitori']) + count($result['commesse']) +  count($result['offerte']);
        return view('search.index', compact('result', 'string_to_search'))->with('success', 'Sono stati trovati '.($tot > 0 ? $tot : 0).' elementi');
    }

    /*

    public function search(Request $request)
    {
        if(!isset($request->adminlteSearch) || strlen($request->adminlteSearch) <= 0) {
            return view('search.index')->with('error', 'Non è stato inserito alcun parametro di ricerca');
        }

        $string_to_search = $request->adminlteSearch;

        $type = $request->search_general;

        $result = null;

        switch($type) {
            case 'Contatti/Lead': 
                $result = Customer::where('nome', 'like', '%'.$string_to_search.'%')->orWhere('cognome', 'like', '%'.$string_to_search.'%')->orWhere('email', 'like', '%'.$string_to_search.'%')->get();
                break;
            case 'Aziende': 
                $result = Company::where('rag_soc', 'like', '%'.$string_to_search.'%')->orWhere('p_iva', 'like', '%'.$string_to_search.'%')->get();
                break;
            case 'Offerte': 
                $result = DB::table('offerte')
                    ->leftJoin('companies', 'offerte.company_id', '=', 'companies.id')
                    ->where('offerte.codice', 'like', '%'.$string_to_search.'%')
                    ->orWhere('companies.rag_soc', 'like', '%'.$string_to_search.'%')
                    ->select('offerte.*', 'companies.rag_soc')
                    ->get();
                break;
            case 'Commesse': 
                $result = DB::table('commesse')
                    ->leftJoin('offerte', 'commesse.offerta_id', '=', 'offerte.id')
                    ->leftJoin('companies', 'commesse.company_id', '=', 'companies.id')
                    ->where('commesse.codice', '=', $string_to_search)
                    ->orWhere('offerte.codice', 'like', '%'.$string_to_search.'%')
                    ->select('commesse.*', 'companies.rag_soc')
                    ->get();
                break;
            case 'Incarichi': 
                $result = DB::table('incarichi')
                    ->leftJoin('fornitori', 'incarichi.fornitore_id', '=', 'incarichi.fornitore_id')
                    ->where('incarichi.codice', '=', $string_to_search)
                    ->orWhere('fornitori.rag_soc', 'like', '%'.$string_to_search.'%')
                    ->orWhere('fornitori.partita_iva', '=', $string_to_search)
                    ->select('incarichi.*', 'fornitori.rag_soc')
                    ->get();
                break;
            case 'Consulenti/Docenti': 
                $result = Fornitore::where('rag_soc', 'like', '%'.$string_to_search.'%')->orWhere('email', 'like', '%'.$string_to_search.'%')->get();
                break;
            case 'Piani/Bandi': 
                $result = Bando::where('codice', '=', $string_to_search)->orWhere('nome', 'like', '%'.$string_to_search.'%')->get();
                break;
            default: break;
        }

        return view('search.index', compact('result', 'type'))->with('success', 'Sono stati trovati '.count($result).' elementi in '.$type);
    }

    */
}
