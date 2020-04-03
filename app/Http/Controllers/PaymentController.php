<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;        
use App\Payment;
use App\Http\Resources\Payment as PaymentResource;
use App\Http\Resources\PaymentCollection;

class PaymentController extends Controller
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

        $this->validate($this->request, Payment::indexRules());

        return response()->json( new PaymentCollection( Payment::paginate( (int)($this->request->page_size ?? env('PAGE_SIZE')) ) ) );

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
    public function create()
    {

        $this->validate($this->request, Payment::createRules());

        $payment = new Payment;

        $payment->bill_id= $this->request->bill_id;
        
        $payment->save();
 
        return response()->json([ 'message' =>'payment created successfully' ,'payment' => $payment],201);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
                
        $payment = Payment::findOrFail($id);

        $payment->update( $this->request->only('bill_id') );

        return response()->json([ 'message' =>'payment edited successfully' ,'payment' => $payment],202);
       
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

        $this->validate($this->request, Payment::updateRules());

        $payment= Payment::findOrFail($id);
        
        $payment->bill_id = $this->request->bill_id;

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
