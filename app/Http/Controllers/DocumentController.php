<?php

namespace App\Http\Controllers;

use App\Http\Resources\DocumentResource;
use App\Http\Resources\UserResource;
use App\Models\attachment;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::with('document')->get();

        return UserResource::collection($user);
        // return DocumentResource::collection(Document::all());
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

        // return Document::join('attachments', 'attachments.document_id', '=', 'documents.id')
        //     ->get();

        $document = new Document();
        $document->fk_owner = Auth()->user()->id;
        $document->fk_office_owner = 1;
        $document->fk_document_type = $request->documentType;
        $document->subject = $request->subject;
        $document->description = $request->description;
        $document->save();

        if ($request->has('image')) {
            foreach ($request->file('image') as $file) {
                $filename =  $file->getClientOriginalName();

                $path =  $file->move(public_path('files/attachments/'), $filename);

                $document->attachment()->create([
                    'name' => $filename,
                    'path' =>  $path,
                ]);
            }
        }



        return  response()->json(['message' => 'Document Successfully Sent']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        //
    }
}
