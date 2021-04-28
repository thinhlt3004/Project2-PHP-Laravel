<?php

namespace App\Http\Controllers;

use App\Exports\CouponExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;

use Maatwebsite\Excel\Facades\Excel;
class Admin_CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::get();
        return view('admin.coupon.list',[
            'coupons' => $coupons
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupon.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $coupon = new Coupon();
        $coupon->name = $request->name;
        $coupon->code = $request->code;
        $coupon->time = $request->time;
        $coupon->cpn_condition = $request->cpn_condition;
        $coupon->number = $request->number;
        $coupon->save();
        return redirect()->action([Admin_CouponController::class,'index']);
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
       return view('admin.coupon.edit',[
            'coupon' => $coupon
       ]) ;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Coupon::find($id)->delete();
        return redirect()->action([Admin_CouponController::class,'index']);
    }

    public function export(){
        return Excel::download(new CouponExport, 'coupon.xlsx');
    }
}
