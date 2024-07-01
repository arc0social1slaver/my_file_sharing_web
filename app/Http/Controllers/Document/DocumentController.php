<?php

namespace App\Http\Controllers\Document;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $docs = Document::allDocs(auth('my_sys')->user()->type)->get();
        return view('pages/documents/index', compact('docs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = 'Add new Document';
        return view('pages/documents/form', compact('title'));
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
        $request->validate([
            'title' => 'required',
            'myfile' => 'required'
        ], [
            'title.required' => 'Tieu de khong duoc bo trong',
            'myfile.required' => 'File khong duoc bo trong'
        ]);
        $data = $request->only('title', 'description');
        $arr = array();
        foreach ($request->myfile as $key => $file) {
            $file_name = $file->hashName();
            $arr[$key]['size'] = filesize($file);
            $file->move(public_path('assets/uploads/files'), $file_name);
            $arr[$key]['name'] = $file->getClientOriginalName();
            $arr[$key]['hashName'] = $file_name;
        }
        $arr = json_encode($arr);
        $data['file_json'] = $arr;
        $data['user_id'] = auth('my_sys')->id();
        $check = Document::create($data);
        if ($check) {
            return redirect()->route('documents.index');
        }
        return redirect()->back();
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
        $types = array();
        foreach($document->list_file as $file) {
            array_push($types, mime_content_type(public_path('assets/uploads/files').'/'.$file->hashName));    
        }
        return view('pages/documents/view', compact('document', 'types'));
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
        $title = 'Edit Document ' . $document->id;
        $types = array();
        foreach($document->list_file as $file) {
            array_push($types, mime_content_type(public_path('assets/uploads/files').'/'.$file->hashName));    
        }
        return view('pages/documents/form', compact('title', 'document', 'types'));
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
        $request->validate([
            'title' => 'required',
        ], [
            'title.required' => 'Tieu de khong duoc bo trong',
        ]);
        $data = $request->only('title', 'description');
        if ($request->has('myfile')) {
            $files = $document->list_file;
            foreach ($files as $file) {
                $file_name = public_path('assets/uploads/files') . '/' . ($file->hashName);
                if (file_exists($file_name)) {
                    unlink($file_name);
                }
            }
            $arr = array();
            foreach ($request->myfile as $key => $file) {
                $file_name = $file->hashName();
                $arr[$key]['size'] = filesize($file);
                $file->move(public_path('assets/uploads/files'), $file_name);
                $arr[$key]['name'] = $file->getClientOriginalName();
                $arr[$key]['hashName'] = $file_name;
            }
            $arr = json_encode($arr);
            $data['file_json'] = $arr;
        }
        $check = $document->update($data);
        if($check) {
            return redirect()->route('documents.index');
        }
        return redirect()->back();
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
        $files = $document->list_file;
        if ($document->delete()) {
            foreach ($files as $file) {
                $file_name = public_path('assets/uploads/files') . '/' . ($file->hashName);
                if (file_exists($file_name)) {
                    unlink($file_name);
                }
            }
        }
        return redirect()->route('documents.index');
    }
}
