<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Corso;
use App\Models\Bando;
use App\Models\BandiCorso;

use Validator;
use DB;

class CorsiController extends Controller
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
         $corsi = Corso::all()->sortByDesc('created_at');
         return view('corsi.index',compact('corsi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bandi = Bando::all();
        return view('corsi.create',compact('bandi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'bando_id' => 'required|exists:bandi,id',
            'titolo' => 'required',
            'edizioni' => 'required',
            'ore' => 'required',
        ]);

        $corso = Corso::create([
            'titolo' =>  $request->input('titolo'),
            'edizioni' => $request->input('edizioni'),
            'ore' => $request->input('ore'),
        ]);

        $corso->relazione_bando()->create([
            'bando_id' => $request->bando_id,
            'corso_id' => $corso->id
        ]);

        return redirect('/corsi')->with('status', 'Aggiunto nuovo corso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $corso = Corso::findOrFail($id);
        $bandi = Bando::all();
        return view('corsi.edit',compact('corso', 'bandi'));
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
        $corso = Corso::findOrFail($id);

        $data = [
            'bando_id' => 'required|exists:bandi,id',
            'titolo' => 'required',
            'edizioni' => 'required',
            'ore' => 'required',
        ];

        $request->validate($data);

        $corso->titolo = $request->titolo;
        $corso->edizioni = $request->edizioni;
        $corso->ore = $request->ore;

        $corso->save();

        if($request->bando_id != $corso->relazione_bando->bando_id) {
            BandiCorso::where([
                ['corso_id' ,'=', $corso->id],
                ['bando_id' ,'=', $corso->relazione_bando->bando_id],
            ])->update([
                'bando_id' => $request->bando_id
            ]);
        }

        return redirect('/corsi')->with('status', 'I dati del corso sono stati aggiornati');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Corso::findOrFail($id)->delete();
        return redirect()->back()->with('status', 'Il corso è stato eliminato');   
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
            Corso::whereIn('id', $ids)->delete();

            $response['status'] = true;
            return response()->json($response);

        } catch(\Exception $e) {
            $response['message'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function getCoursesById(Request $request)
    {
        $response = [
            'status' => false,
            'message' => 'Errore endpoint'
        ];

        try {
            $validation_data = [
                'bando_id' => ['required', 'exists:bandi,id'],
            ];

            $validator = Validator::make($request->all(), $validation_data);

            if ($validator->fails()) {
                $response['message'] = 'Errore validazione endpoint';
                return response()->json($response);
            }

            $corsi = DB::table('corsi')
                ->leftJoin('bandi_corsi', 'corsi.id', '=', 'bandi_corsi.corso_id')
                ->where('bandi_corsi.bando_id', '=', $request->bando_id)
                ->select('corsi.*')
                ->get();
            $response['status'] = true;
            $response['corsi'] = $corsi;
            return response()->json($response);

        } catch(\Exception $e) {
            $response['message'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function newCourse(Request $request)
    {
        
        $response = [
            'status' => false,
            'message' => 'Errore endpoint'
        ];

        try {
            $validation_data = [
                'titolo' => ['required'],
                'edizioni' => ['required'],
                'ore' => ['required']
            ];

            $validator = Validator::make($request->all(), $validation_data);

            if ($validator->fails()) {
                $response['message'] = 'Errore validazione endpoint';
                return response()->json($response);
            }

            $corso = Corso::create([
                'titolo' =>  $request->input('titolo'),
                'edizioni' => $request->input('edizioni'),
                'ore' => $request->input('ore'),
            ]);

            $response['message'] = 'ok';
            $response['status'] = true;
            $response['corso'] = $corso;
            return response()->json($response);

        } catch(\Exception $e) {
            $response['message'] = $e->getMessage();
            return response()->json($response);
        }
    }


    public function getEditionsById(Request $request)
    {
        $response = [
            'status' => false,
            'message' => 'Errore endpoint'
        ];

        try {
            $validation_data = [
                'corso_id' => ['required', 'exists:corsi,id'],
            ];

            $validator = Validator::make($request->all(), $validation_data);

            if ($validator->fails()) {
                $response['message'] = 'Errore validazione endpoint';
                return response()->json($response);
            }

            $corso = Corso::findOrFail($request->corso_id);
            $response['status'] = true;
            $response['corso'] = $corso;
            return response()->json($response);

        } catch(\Exception $e) {
            $response['message'] = $e->getMessage();
            return response()->json($response);
        }
    }
}
