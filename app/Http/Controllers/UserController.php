<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;        
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::all();

        return response()->json($users);

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
        $user = User::findOrFail($id);

        return response()->json($user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
        $this->validate($request, User::createRules());

        $user = new User;

        $user->name= $request->name;
        $user->image = $request->image;
        $user->dob = $request->dob;
        $user->phone = $request->phone;
        $request->privileges && $user->privileges = $request->privileges;
        
        $user->save();
 
        return response()->json([ 'message' =>'user created successfully' ,'user' => $user],201);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
                                
        $project = Project::findOrFail($id);

        $project->update( $request->only('name','image','dob','phone','privileges') );

        return response()->json([ 'message' =>'project edited successfully' ,'project' => $project],202);
       
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

        $this->validate($request, User::createRules());
                                        
        $user= User::findOrFail($id);
        
        $user->name= $request->name;
        $user->image = $request->image;
        $user->dob = $request->dob;
        $user->phone = $request->phone;
        $request->privileges && $user->privileges = $request->privileges;

        $user->save();

        return response()->json([ 'message' =>'user updated successfully' ,'user' => $user],202);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
                
        $user = User::findOrFail($id);
        $user->delete();

         return response()->json([ 'message' =>'user removed successfully'],202);

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bills($id)
    {
        $bills = User::findOrFail($id)->bills();

        return response()->json($bills);
    }
}
