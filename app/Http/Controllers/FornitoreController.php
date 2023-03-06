<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fornitore;
use App\Models\User;
use App\Models\Discipline;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Validator;
use DB;

class FornitoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $fornitori = Fornitore::all()->sortByDesc('created_at');
        foreach($fornitori as $key => $fornitore) {
            $discipline = DB::table('fornitori_discipline')
                        ->where('fornitore_id', '=', $fornitore->id)
                        ->join('discipline', 'fornitori_discipline.disciplina_id', '=', 'discipline.id')
                        ->pluck('discipline.nome')
                        ->toArray();
            $fornitore->discipline = $discipline;
        }
        return view('fornitore.index',compact('fornitori'));
    }

    public function create()
    {
        $users = User::all();
        $_discipline = Discipline::all();
        $discipline = [];
        foreach($_discipline as $r) {
            if(is_null($r->parent_id)) {
                $discipline[$r->nome] = Discipline::where('parent_id', '=', $r->id)->get()->toArray();
            }
        }
        return view('fornitore.create', compact('users', 'discipline'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cellulare' => 'required',
            'email' => 'required|email|unique:fornitori',
            'codice_fiscale' => 'required|unique:fornitori',
            'partita_iva' => 'required|unique:fornitori',
            'disciplina_id' => 'required',
            'via' => 'required',
            'comune' => 'required',
            'provincia' => 'required',
            'cap' => 'required',
            'nazione' => 'required',
            'user_id' => 'required'
        ]);

        $fornitore = Fornitore::create([
            'rag_soc' =>  $request->input('rag_soc'),
            'telefono' => $request->input('telefono'),
            'cellulare' => $request->input('cellulare'),
            'email' => $request->input('email'),
            'codice_fiscale' => $request->input('codice_fiscale'),
            'partita_iva' => $request->input('partita_iva'),
            'via' => $request->input('via'),
            'comune' => $request->input('comune'),
            'provincia' => $request->input('provincia'),
            'cap' => $request->input('cap'),
            'nazione' => $request->input('nazione'),
            'note' => $request->input('note'),
            'user_id' => $request->input('user_id')
        ]);

        foreach($request->disciplina_id as $index => $d) {
            DB::table('fornitori_discipline')->insert([
                'fornitore_id' => $fornitore->id,
                'disciplina_id' => $d
            ]);
        }

        return redirect('/fornitori')->with('status', 'Aggiunto nuovo fornitore');
    }

    public function show($id) 
    {
        $fornitore = Fornitore::findOrFail($id);
        $discipline = DB::table('fornitori_discipline')
                        ->where('fornitore_id', '=', $fornitore->id)
                        ->join('discipline', 'fornitori_discipline.disciplina_id', '=', 'discipline.id')
                        ->pluck('discipline.nome')
                        ->toArray();
        $fornitore->discipline = $discipline;
        return view('fornitore.show',compact('fornitore'));
    }

    public function edit($id)
    {
        $_discipline = Discipline::all();
        $discipline = [];
        foreach($_discipline as $r) {
            if(is_null($r->parent_id)) {
                $discipline[$r->nome] = Discipline::where('parent_id', '=', $r->id)->get()->toArray();
            }
        }
        $fornitore = Fornitore::findOrFail($id);
        $fornitore->discipline = DB::table('fornitori_discipline')->where('fornitore_id','=',$id)->pluck('disciplina_id')->toArray();
        $users = User::all();
        return view('fornitore.edit',compact('fornitore','users', 'discipline'));
    }

    public function update(Request $request, $id)
    {
        $fornitore = Fornitore::findOrFail($id);

        $request->validate([
            'cellulare' => 'required',
            'email' => 'required|email|unique:fornitori,email,'.$fornitore->id,
            'codice_fiscale' => 'required|unique:fornitori,codice_fiscale,'.$fornitore->id,
            'partita_iva' => 'required|unique:fornitori,partita_iva,'.$fornitore->id,
            'disciplina_id' => 'required',
            'via' => 'required',
            'comune' => 'required',
            'provincia' => 'required',
            'cap' => 'required',
            'nazione' => 'required',
            'user_id' => 'required'
        ]);

        $fornitore->rag_soc = $request->input('rag_soc');
        $fornitore->telefono = $request->input('telefono');
        $fornitore->cellulare = $request->input('cellulare');
        $fornitore->email = $request->input('email');
        $fornitore->codice_fiscale = $request->input('codice_fiscale');
        $fornitore->partita_iva = $request->input('partita_iva');
        $fornitore->via = $request->input('via');
        $fornitore->comune = $request->input('comune');
        $fornitore->provincia = $request->input('provincia');
        $fornitore->cap = $request->input('cap');
        $fornitore->nazione = $request->input('nazione');
        $fornitore->note = $request->input('note');
        $fornitore->user_id = $request->input('user_id');

        $fornitore->save();

        $old_discipline = DB::table('fornitori_discipline')->where('fornitore_id', '=', $id)->pluck('disciplina_id')->toArray();
        $new_discipline = $request->disciplina_id;

        $diff = array_diff($old_discipline, $new_discipline);
        if(count($diff) > 0) {
            DB::table('fornitori_discipline')->where('fornitore_id', '=', $id)->whereIn('disciplina_id', $diff)->delete();
        }
        
        foreach($new_discipline as $index => $disciplina_id) {
            if(!in_array($disciplina_id, $old_discipline)) {
                DB::table('fornitori_discipline')->insert([
                    'fornitore_id' => $id,
                    'disciplina_id' => $disciplina_id
                ]);
            }
        }

        return redirect('/fornitori')->with('status', 'I dati del fornitore sono stati aggiornati');
    }

    public function export()
    {
        $fornitori = Fornitore::all();
        $to_export = [];
        foreach($fornitori as $fornitore) {
            $item = [
                "id" => $fornitore->id,
                "ragione sociale" => $fornitore->rag_soc,
                "telefono" => $fornitore->telefono,
                "cellulare" => $fornitore->cellulare,
                "email" => $fornitore->email,
                "codice fiscale" => $fornitore->codice_fiscale,
                "partita iva" => $fornitore->partita_iva,
                "disciplina" => $fornitore->note,
                "via" => $fornitore->via,
                "comune" => $fornitore->comune,
                "provincia" => $fornitore->provincia,
                "cap" => $fornitore->cap,
                "nazione" => $fornitore->nazione,
                "assegnato a" => $fornitore->user->name,
                'note' => $fornitore->note,
            ];
            array_push($to_export, $item);
        }

        $stream = SimpleExcelWriter::streamDownload('lista_fornitori.xlsx');
        $writer = $stream->getWriter();
        
        $scartiSheet = $writer->getCurrentSheet();
        $scartiSheet->setName('Lista');
        $stream->addRows($to_export);

        return $stream->toBrowser();
    }

    public function destroy($id)
    {
        Fornitore::findOrFail($id)->delete();
        return redirect()->back()->with('status', 'Il fornitore è stato eliminato');   
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
            Fornitore::whereIn('id', $ids)->delete();

            $response['status'] = true;
            return response()->json($response);

        } catch(\Exception $e) {
            $response['message'] = $e->getMessage();
            return response()->json($response);
        }
    }
}
