<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // $data = [
        //     'level_id'=> 2,
        //     'username'=>'manager_tiga',
        //     'nama' => 'Manager 3',
        //     'password'=> Hash::make('12345')
            
        // ];
        // UserModel::create($data);

        // $user = UserModel::find(1); 
        // $user = UserModel::where('level_id',)->first(); 
        // $user = UserModel::firstWhere('level_id',1); 
        // $user = UserModel::findOr(20,['username', 'nama'], function(){
        //     abort(404);
        // }); 
        // $user = UserModel::where('username', 'manager')->firstOrfail(); 
        $user = UserModel::where('level_id', 2)->count();
        // dd($user) ;

        return view('user', ['data' => $user]);
    }
}
