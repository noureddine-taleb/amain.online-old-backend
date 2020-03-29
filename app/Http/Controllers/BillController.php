<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;        
use App\Bill;

class BillController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $bills = Bill::all();

        return response()->json($bills);

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
    public function create(Request $request)
    {
        
        $this->validate($request, Bill::createRules());
                
        $bill = new Bill;

        $bill->project_id= $request->project_id;
        $bill->user_id = $request->user_id;
        $bill->weight = $request->weight;
        
        $bill->save();
 
        return response()->json([ 'message' =>'bill created successfully' ,'bill' => $bill],201);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        
        $bill = Bill::findOrFail($id);

        $bill->update( $request->only('project_id','user_id','weight') );

        return response()->json([ 'message' =>'bill edited successfully' ,'bill' => $bill],202);
        
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

        $this->validate($request, Bill::updateRules());
        
        $bill= Bill::findOrFail($id);
        
        $bill->project_id = $request->project_id;
        $bill->user_id = $request->user_id;
        $bill->weight = $request->weight;

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
