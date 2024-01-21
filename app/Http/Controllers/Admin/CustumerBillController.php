<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerBill;
use Illuminate\Http\Request;

class CustumerBillController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    if (request()->ajax()) {
    };

    $get_menu = get_menu_id('price-settings');
    return view('admin.pages.customer-bill.index', compact('get_menu'));
    //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\CustomerBill  $customerBill
   * @return \Illuminate\Http\Response
   */
  public function show(CustomerBill $customerBill)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\CustomerBill  $customerBill
   * @return \Illuminate\Http\Response
   */
  public function edit(CustomerBill $customerBill)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\CustomerBill  $customerBill
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, CustomerBill $customerBill)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\CustomerBill  $customerBill
   * @return \Illuminate\Http\Response
   */
  public function destroy(CustomerBill $customerBill)
  {
    //
  }
}
