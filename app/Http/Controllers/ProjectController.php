<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Http\Resources\Project as ProjectResource;
use App\Http\Resources\ProjectCollection;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $this->validate($request, Project::indexRules());

        return response()->json( new ProjectCollection( Project::paginate( (int)($request->page_size ?? env('PAGE_SIZE')) ) ) );

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
        $project = Project::findOrFail($id);

        return response()->json($project);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $this->validate($request, Project::createRules());
        
        $project = new Project;

        $project->name= $request->name;
        $project->desc = $request->desc;
        $project->fees = $request->fees;
        
        $project->save();
 
        return response()->json([ 'message' =>'project created successfully' ,'project' => $project],201);

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

        $project->update( $request->only('name','desc','fees') );

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
            
        $this->validate($request, Project::updateRules());
        

        $project= Project::findOrFail($id);
        
        $project->name = $request->name;
        $project->desc = $request->desc;
        $project->fees = $request->fees;

        $project->save();

        return response()->json([ 'message' =>'project updated successfully' ,'project' => $project],202);

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

         return response()->json([ 'message' =>'project removed successfully'],202);

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
        
        return response()->json($bills);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function alerts($id)
    {
        $alerts = Project::findOrFail($id)->alerts();
        
        return response()->json($alerts);
    }
}
