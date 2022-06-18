<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpensesCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ExpenseCategory::all();
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
        $validate = $request->validate([
            'category' => ['required', 'unique:expense_categories'],
            'description' => ['required', 'unique:expense_categories'],
        ]);

        ExpenseCategory::create([
            'category' => $request->category,
            'description' => $request->description
        ]);

        return response()->json([
            'message' => 'Expenses Category successfully added'
        ]);
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
    public function edit($id)
    {
        //
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
        $validate = $request->validate([
            'category' => ['required', 'unique:expense_categories'],
            'description' => ['required', 'unique:expense_categories'],
        ]);

        ExpenseCategory::where('id', $id)->update([
            'category' => $request->category,
            'description' => $request->description
        ]);

        return response()->json([
            'message' => 'Expenses Category successfully update'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ExpenseCategory::where('id', $id)->delete();

        return response()->json([
            'message' => 'Expenses Category successfully remove'
        ]);
    }
}
