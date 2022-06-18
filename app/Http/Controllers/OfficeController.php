<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Office;

class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  Office::when(request('search'), function ($query) {
            $query->where('office_name', 'like', '%' . request('search') . '%');
        })->orderBy('office_name', 'asc')->paginate(10);
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
        $request->validate([
            'office_name' => ['required', 'unique:offices'],
            'office_code' => ['required', 'unique:offices'],
        ]);

        $office = new Office();
        $office->office_name = $request->office_name;
        $office->office_code = $request->office_code;
        $office->save();

        return response()->json([
            'message' => 'Office successfully added'
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
        $request->validate([
            'office_name' => ['required', 'unique:offices'],
            'office_code' => ['required', 'unique:offices'],
        ]);

        Office::where('id', $id)
            ->update([
                'office_name' => $request->office_name,
                'office_code' => $request->office_code
            ]);

        return response()->json([
            'message' => $request->office_name . " Successfully update"
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
        //
    }

    public function getOffice()
    {
        return Office::all();
    }
}
