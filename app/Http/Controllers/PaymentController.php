<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;        
use App\Payment;

class PaymentController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $payments = Payment::all();

        return response()->json($payments);

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
        $payment = Payment::findOrFail($id);

        return response()->json($payment);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $this->validate($request, Payment::createRules());

        $payment = new Payment;

        $payment->bill_id= $request->bill_id;
        
        $payment->save();
 
        return response()->json([ 'message' =>'payment created successfully' ,'payment' => $payment],201);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
                
        $payment = Payment::findOrFail($id);

        $payment->update( $request->only('bill_id') );

        return response()->json([ 'message' =>'payment edited successfully' ,'payment' => $payment],202);
       
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

        $this->validate($request, Payment::updateRules());

        $payment= Payment::findOrFail($id);
        
        $payment->bill_id = $request->bill_id;

        $payment->save();

        return response()->json([ 'message' =>'payment updated successfully' ,'payment' => $payment],202);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
                
        $payment = Payment::findOrFail($id);
        $payment->delete();

         return response()->json([ 'message' =>'payment removed successfully'],202);

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bill($id)
    {

        $bill = Payment::findOrFail($id)->bill();
        
        return response()->json($bill);

    }
}
