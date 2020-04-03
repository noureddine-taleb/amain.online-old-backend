<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alert;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Alert as AlertResource;
use App\Http\Resources\AlertCollection;

class AlertController extends Controller
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

        $this->validate($this->request, Alert::indexRules());

        return response()->json( new AlertCollection( Alert::paginate( (int)( $this->request->page_size ?? env('PAGE_SIZE') ) )) );

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
    public function create()
    {
        $this->validate($this->request, Alert::createRules());

        $alert = new Alert;

        $alert->project_id= $this->request->project_id;
        $alert->frequency = $this->request->frequency;
        $alert->priority = $this->request->priority;
        
        $alert->save();
 
        return response()->json([ 'message' =>'alert created successfully' ,'alert' => $alert],201);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $alert = Alert::findOrFail($id);

        $alert->update( $this->request->only('project_id','frequency','priority') );

        return response()->json([ 'message' =>'alert edited successfully' ,'alert' => $alert],202);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {

        $this->validate($this->request, Alert::updateRules());
        
        $alert= Alert::findOrFail($id);
        
        $alert->project_id = $this->request->project_id;
        $alert->priority = $this->request->priority;
        $alert->frequency = $this->request->frequency;

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
