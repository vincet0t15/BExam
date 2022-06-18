<?php

namespace App\Http\Controllers;

use App\Models\role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class roleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return role::all();
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
            'display_name' => ['required', 'unique:roles'],
            'description' => ['required', 'unique:roles'],
        ]);

        $role = new role();
        $role->display_name = $request->display_name;
        $role->description = $request->description;
        $role->save();

        return response()->json([
            'message' => 'Role successfully added'
        ]);
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if ($id != 1) {
            $request->validate([
                'display_name' => ['required', 'unique:roles'],
                'description' => ['required', 'unique:roles'],
            ]);

            role::where('id', $id)
                ->update([
                    'display_name' => $request->display_name,
                    'description' => $request->description
                ]);

            return response()->json([
                'message' => 'Role successfully update'
            ]);
        } else {
            return response()->json([
                'message' => 'Access denied!'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        role::where('id', $id)->delete();

        return response()->json([
            'message' => 'Successfully delete!'
        ]);
    }
}
