<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;        
use App\Bill;
use App\Http\Resources\Bill as BillResource;
use App\Http\Resources\BillCollection;

class BillController extends Controller
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

        $this->validate($this->request, Bill::indexRules());

        return response()->json( new BillCollection( Bill::paginate( (int)($this->request->page_size ?? env('PAGE_SIZE')) ) ) );

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
        $bill = Bill::findOrFail($id);

        return response()->json($bill);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $this->validate($this->request, Bill::createRules());
                
        $bill = new Bill;

        $bill->project_id= $this->request->project_id;
        $bill->user_id = $this->request->user_id;
        $bill->weight = $this->request->weight;
        
        $bill->save();
 
        return response()->json([ 'message' =>'bill created successfully' ,'bill' => $bill],201);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $bill = Bill::findOrFail($id);

        $bill->update( $this->request->only('project_id','user_id','weight') );

        return response()->json([ 'message' =>'bill edited successfully' ,'bill' => $bill],202);
        
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

        $this->validate($this->request, Bill::updateRules());
        
        $bill= Bill::findOrFail($id);
        
        $bill->project_id = $this->request->project_id;
        $bill->user_id = $this->request->user_id;
        $bill->weight = $this->request->weight;

        $bill->save();

        return response()->json([ 'message' =>'bill updated successfully' ,'bill' => $bill],202);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
                
        $bill = Bill::findOrFail($id);
        $bill->delete();

         return response()->json([ 'message' =>'bill removed successfully'],202);

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function payment($id)
    {
        $payment = Bill::findOrFail($id)->payment();

        return response()->json($payment);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function user($id)
    {
        $user = Bill::findOrFail($id)->user();

        return response()->json($user);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function project($id)
    {
        $project = Bill::findOrFail($id)->project();

        return response()->json($project);
    }
}
