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

        $bills = Bill::all();
        foreach ($bills as $bill) {
            $bill->user_id = $bill->user();
            $bill->project_id = $bill->project();
            $bill->payment_id = $bill->payment();
        }

        return $this->response(200,"Bill", $bills );


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

        return $this->response(200,"Bill", $bill );

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
 
        return $this->response(201,"Bill", $bill );


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

        return $this->response(202,"Bill", $bill );

        
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

        return $this->response(202, "Bill", $bill);


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
        
        return $this->response(207, "Bill");
        //  return response()->json([ 'message' =>'bill removed successfully'],202);

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

        return $this->response(200,"Bill", $payment );

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

        return $this->response(200,"Bill", $user );
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

        return $this->response(200,"Bill", $project );

    }
}
