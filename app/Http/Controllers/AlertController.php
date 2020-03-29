<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alert;
use Illuminate\Support\Facades\Validator;

class AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $alerts = Alert::all();

        return response()->json($alerts);

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
        $alert = Alert::findOrFail($id);

        return response()->json($alert);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request, Alert::createRules());

        $alert = new Alert;

        $alert->project_id= $request->project_id;
        $alert->frequency = $request->frequency;
        $alert->priority = $request->priority;
        
        $alert->save();
 
        return response()->json([ 'message' =>'alert created successfully' ,'alert' => $alert],201);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

        $alert = Alert::findOrFail($id);

        $alert->update( $request->only('project_id','frequency','priority') );

        return response()->json([ 'message' =>'alert edited successfully' ,'alert' => $alert],202);
        
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

        $this->validate($request, Alert::updateRules());
        
        $alert= Alert::findOrFail($id);
        
        $alert->project_id = $request->project_id;
        $alert->priority = $request->priority;
        $alert->frequency = $request->frequency;

        $alert->save();

        return response()->json([ 'message' =>'alert updated successfully' ,'alert' => $alert],202);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $alert = Alert::findOrFail($id);
        $alert->delete();

         return response()->json([ 'message' =>'alert removed successfully'],202);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function project($id)
    {

        $project = Alert::findOrFail($id)->project();

        return response()->json($project);
        
    }
}
