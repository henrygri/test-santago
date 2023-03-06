<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //$users = User::where('id', '!=', auth()->id())->orderBy('created_at', 'desc')->get();
        $users = UserDetail::where('user_id', '!=', auth()->id())->orderBy('created_at', 'desc')->get();
        return view('user.index',compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role_id' => 'required|exists:roles,id',
            'fiscal_code' => 'required|string|max:16|unique:users_details',
        ]);

        $role = Role::findOrFail($request->role_id);

        $user = User::create([
            'name' =>  $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $user->assignRole($role->name) && $user->givePermissionTo($role->permissions->first()->name);

        $detail = UserDetail::create([
            'user_id' => $user->id,
            'fiscal_code' => $request->input('fiscal_code'),
            'is_active' => $request->input('is_active') ? 1 : 0
        ]);

        return redirect('/collaboratori')->with('status', 'Aggiunto nuovo collaboratore');
    }

    public function edit($id)
    {
        $userData = UserDetail::where('user_id', '=', $id)->firstOrFail();
        //$detail = UserDetail::where('user_id', '=', $user->id)->first();
        $roles = Role::all();
        return view('user.edit',compact('userData', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $userDetail = UserDetail::where('user_id', '=', $id)->firstOrFail();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'fiscal_code' => 'required|unique:users_details,fiscal_code,'.$userDetail->id,
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if($request->input('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $role = Role::findOrFail($request->role_id);
        if($user->roles->first()->id != $request->role_id) {
            $user->syncRoles([$role->name]) && $user->syncPermissions([$role->permissions->first()->name]);
            //$user->assignRole($role->name) && $user->givePermissionTo($role->permissions->first()->name);
        }

        $user->save();

        $userDetail->fiscal_code = $request->input('fiscal_code');
        $userDetail->is_active = $request->input('is_active') ? 1 : 0;
        $userDetail->save();

        return redirect('/collaboratori')->with('status', 'I dati del collaboratore sono stati aggiornati');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('status', 'Il collaboratore è stato eliminato');   
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
            User::whereIn('id', $ids)->delete();

            $response['status'] = true;
            return response()->json($response);

        } catch(\Exception $e) {
            $response['message'] = $e->getMessage();
            return response()->json($response);
        }
    }
}
