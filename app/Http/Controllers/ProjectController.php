<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Http\Resources\Project as ProjectResource;
use App\Http\Resources\ProjectCollection;

class ProjectController extends Controller
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
        $this->validate($this->request, Project::indexRules());

        $projects = Project::all();
        foreach ($projects as $project) {
            $project->bills_count = $project->bills()->count();
        }
        return $this->response(200,"Project", $projects );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::findOrFail($id);

        return $this->response(200,"Project", $project );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->validate($this->request, Project::createRules());
        
        $project = new Project;

        $project->name = $this->request->name;
        $project->desc = $this->request->desc;
        $project->fees = $this->request->fees;
        
        $project->save();
 
        return $this->response(201,"Project", $project );
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

        $project->update( $this->request->only('name','desc','fees') );

        return $this->response(202,"Project", $project );
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
        $this->validate($this->request, Project::updateRules());
        
        $project= Project::findOrFail($id);
        
        $project->name = $this->request->name;
        $project->desc = $this->request->desc;
        $project->fees = $this->request->fees;

        $project->save();

        return $this->response(202,"Project", $project );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
                
        $project = Project::findOrFail($id);
        $project->delete();

        return $this->response(207,"Project", $project );
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bills($id)
    {
        $bills = Project::findOrFail($id)->bills();
        
        return $this->response(200,"Project", $bills );
    }
}
