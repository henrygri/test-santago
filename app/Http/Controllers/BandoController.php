<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bando;
use App\Models\BandiCorso;
use App\Models\Corso;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Carbon\Carbon;

use Validator;
use DB;

class BandoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bandi = Bando::all()->sortByDesc('created_at');
        return view('bandi.index',compact('bandi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $corsi = Corso::all();
        return view('bandi.create',compact('corsi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'nome' => 'required',
            'codice' => 'required',
            'data_apertura' => 'required',
            'data_chiusura' => 'required',
            'valore_iniziale' => 'required'
        ];

        $request->validate($data);

        $bando = Bando::create([
            'nome' => $request->nome,
            'codice' => $request->codice,
            'data_apertura' => $request->data_apertura,
            'data_chiusura' => $request->data_chiusura,
            'data_chiusura_prorogata' => $request->data_chiusura_prorogata,
            'valore_iniziale' => $request->valore_iniziale,
            'valore_finale' => $request->valore_finale,
            'monte_ore' => $request->monte_ore,
            'note' => $request->note,
        ]);

        foreach($request->corsi as $corso) {
            BandiCorso::create([
                'corso_id' => $corso,
                'bando_id' => $bando->id
            ]);
        }

        return redirect('/bandi')->with('status', 'Aggiunto nuovo bando');
    }

    /**
     * Show the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bando = Bando::findOrFail($id);
        
        $corsi = [];
        foreach($bando->corsi as $corso) :
            $corsi[] = Corso::find($corso->corso_id);
        endforeach;
        return view('bandi.show',compact('bando', 'corsi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bando = Bando::findOrFail($id);
        $corsi = Corso::all();
        return view('bandi.edit',compact('bando', 'corsi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bando = Bando::findOrFail($id);

        $data = [
            'nome' => 'required',
            'codice' => 'required',
            'data_apertura' => 'required',
            'data_chiusura' => 'required',
            'valore_iniziale' => 'required'
        ];

        $request->validate($data);

        $bando->nome = $request->nome;
        $bando->codice = $request->codice;
        $bando->data_apertura = $request->data_apertura;
        $bando->data_chiusura = $request->data_chiusura;
        $bando->data_chiusura_prorogata = $request->data_chiusura_prorogata;
        $bando->valore_iniziale = $request->valore_iniziale;
        $bando->valore_finale = $request->valore_finale;
        $bando->monte_ore = $request->monte_ore;
        $bando->note = $request->note;

        $bando->save();

        $old_corsi = DB::table('bandi_corsi')->where('bando_id', '=', $id)->pluck('corso_id')->toArray();
        $new_corsi = $request->corsi;

        $diff = array_diff($old_corsi, $new_corsi);
        if(count($diff) > 0) {
            DB::table('bandi_corsi')->where('bando_id', '=', $id)->whereIn('corso_id', $diff)->delete();
        }
        
        foreach($new_corsi as $index => $corso_id) {
            if(!in_array($corso_id, $old_corsi)) {
                DB::table('bandi_corsi')->insert([
                    'bando_id' => $id,
                    'corso_id' => $corso_id
                ]);
            }
        }

        return redirect('/bandi')->with('status', 'I dati del bando sono stati aggiornati');
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
            Bando::whereIn('id', $ids)->delete();

            $response['status'] = true;
            return response()->json($response);

        } catch(\Exception $e) {
            $response['message'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function export()
    {
        $bandi = Bando::all();
        $to_export = [];
   

        foreach($bandi as $bando) {
            
            $corsi = DB::table('bandi_corsi')
                        ->leftJoin('corsi', 'bandi_corsi.corso_id', '=', 'corsi.id')
                        ->where('bandi_corsi.bando_id', '=', $bando->id)
                        ->pluck('titolo')
                        ->toArray();
            $item = [
                'id' => $bando->id,
                'fondo ente' => $bando->nome,
                'codice' => $bando->codice,
                'data_apertura' => Carbon::parse($bando->data_apertura)->format('d-m-y'),
                'data_chiusura' => Carbon::parse($bando->data_chiusura)->format('d-m-y'),
                'data_chiusura_prorogata' => Carbon::parse($bando->data_chiusura_prorogata)->format('d-m-yd'),
                'valore_iniziale' => number_format($bando->valore_iniziale, 2, '.', ''),
                'valore_finale' => number_format($bando->valore_finale, 2, '.', ''),
                'corsi' => $corsi ? implode(', ', $corsi) : '',
                'monte_ore' => $bando->monte_ore,
                'note' => $bando->note,
            ];

            array_push($to_export, $item);

        }

        $stream = SimpleExcelWriter::streamDownload('lista_bandi.xlsx');
        $writer = $stream->getWriter();
        
        $scartiSheet = $writer->getCurrentSheet();
        $scartiSheet->setName('Lista');
        $stream->addRows($to_export);

        return $stream->toBrowser();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Bando::findOrFail($id)->delete();
        return redirect()->back()->with('status', 'Il bando è stato eliminato');
    }
}
