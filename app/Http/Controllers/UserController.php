<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;        
use App\User;

use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $users = User::all();

        $this->validate($this->request, User::indexRules());

        return response()->json( new UserCollection( User::paginate( (int)($this->request->page_size ?? env('PAGE_SIZE')) ) ) );

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
    public function create()
    {
        
        $this->validate($this->request, User::createRules());

        $user = new User;

        $user->name= $this->request->name;
        $user->image = $this->request->image;
        $user->dob = $this->request->dob;
        $user->phone = $this->request->phone;
        $this->request->privileges && $user->privileges = $this->request->privileges;
        
        $user->save();
 
        return response()->json([ 'message' =>'user created successfully' ,'user' => $user],201);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
                                
        $project = Project::findOrFail($id);

        $project->update( $this->request->only('name','image','dob','phone','privileges') );

        return response()->json([ 'message' =>'project edited successfully' ,'project' => $project],202);
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {

        $this->validate($this->request, User::updateRules());
                                        
        $user= User::findOrFail($id);
        
        $user->name= $this->request->name;
        $user->image = $this->request->image;
        $user->dob = $this->request->dob;
        $user->phone = $this->request->phone;
        $this->request->privileges && $user->privileges = $this->request->privileges;

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
