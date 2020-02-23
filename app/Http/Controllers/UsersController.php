<?php

namespace App\Http\Controllers;
use App\User;
use App\Http\Requests\Users\UpdateProfileRequest;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    //
    public function index(){

        return view('users.index')->with('users',User::all());
    }

    public function makeAdmin(User $user){

        $user->role='admin';
        
        $user->save();

        session()->flash('success', 'This User has been successfully made Admin' );

        return redirect(route('users.index'));

    }

    public function edit(){

        return view('users.edit')->with('user', auth()->user());//only authenticated user can edit their profile
    }

    public function update(UpdateProfileRequest $request){

        $user = auth()->user();

        $user->update([
            'name'=>$request->name,
            'about'=>$request->about
        ]);

        session()->flash('success', 'This User Info has been successfully Updated' );

        return redirect()->back();


    }
}
