<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;
use Response;
use DB;
use Redirect;
use Gate;

use App\Models\ScannedDocument;
use App\Models\Company;

class ScannedDocumentController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('Scanned Documents - List'), redirect(url('/dashboard')));

        return view( 'scanned-documents.index' );
    }

    public function ajaxGetScannedDocuments(Request $request) {
        try {

            $postData = $request->all();
            $start      = isset($postData['start'])             ? $postData['start']                : 0;
            $length     = isset($postData['length'])            ? $postData['length']               : 10;
            $orderdir   = isset($postData['order'][0]['dir'])   ? $postData['order'][0]['dir']      : 0;
            $ordercol   = isset($postData['order'][0]['dir'])   ? $postData['order'][0]['column']   : 0;
            $searchchar = isset($postData['search']['value'])   ? $postData['search']['value']      : '';

            $company_admin      = Auth::user()->company_admin;
            $logged_in_username = Auth::user()->username;
            $company_name       = getCurrentUserCompanyName();

            $scanned_documents = ScannedDocument::select(['uuid', 'title', 'file_display_name AS file', DB::raw('(SELECT company_name FROM companies WHERE companies.id = scanned_documents.company_id) AS company_name')]);


            $isSuperAdmin = false;
            if( getCurrentUserRole() === \Config::get('constants.admin')) {
                
                $isSuperAdmin = true;
            } else {
                $scanned_documents->where('company_id', Auth::user()->company_id);
            }

            if(!empty($searchchar)) {
                $scanned_documents->where(function($query) use($searchchar) {
                    return $query->orWhere('title', 'like', '%'.$searchchar.'%')->orWhere('file_display_name', 'like', '%'.$searchchar.'%');
                });
            }

            switch ($ordercol) {
                case 0: $scanned_documents->orderBy('title', $orderdir); break;
                // case 1: $scanned_documents->orderBy('company_name', $orderdir); break;
                case 2: $scanned_documents->orderBy('file', $orderdir); break;
                default: $scanned_documents->orderBy('title', $orderdir);
            }

            $total_scanned_documents = $scanned_documents->count();
            $scanned_documents->skip($start)->take($length);

            $data = $scanned_documents->get();
            $data = $data->map(function($document) use($isSuperAdmin) {

                $file_extension = strtolower( pathinfo($document->file, PATHINFO_EXTENSION) );
                if( $file_extension === 'pdf' ) {
                    $document->file = '<a href="' . route('viewScannedDocument', $document->uuid) . '" class="view-document" target="_blank">'. $document->file .'</a>';
                } else {
                    $document->file = '<a href="' . route('downloadScannedDocument', $document->uuid) . '" target="_blank">'. $document->file .'</a>';    
                }

                $actions = [];

                if( $isSuperAdmin ) {
                    $actions[] = '<a href="' . route('scanned-documents.edit', $document->uuid) . '" class="btn btn-xs btn-custom-primary"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>';
                }

                if( $file_extension === 'pdf' ) {
                    $actions[] = '<a href="' . route('viewScannedDocument', $document->uuid) . '" class="view-document btn btn-xs btn-custom-success" target="_blank"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View</a>';
                }

                $actions[] = '<a href="' . route('downloadScannedDocument', $document->uuid) . '" class="btn btn-xs btn-custom-info" target="_blank"><span class="glyphicon glyphicon-download" aria-hidden="true"></span> Download</a>';

                if( $isSuperAdmin ) {
                    $actions[] = '<a href="' . route('scanned-documents.destroy', $document->uuid) . '" class="btn btn-xs btn-custom-danger delete-scanned-document"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</a>';
                }

                $document->actions = '<div class="btn-toolbar">'.implode('', $actions) .'</div>';
                return $document;
            });

            return response::json([
                'data' => $data,
                'recordsTotal' => $total_scanned_documents,
                'recordsFiltered' => $total_scanned_documents
            ]);

        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while fetching the agreements. ' . $e->getMessage()); // 
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('Scanned Documents - Create'), redirect(url('/dashboard')));

        $companies = getCompanies();

        return view('scanned-documents.create', compact('companies') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                'title' => ['required', 'string', 'max:255'],
                'company_id' => ['required'],
                'file' => ['required'],
            ];

            $data = $request->except(['_token', 'upload']);

            $validator = Validator::make($data, $rules);
            
            if ( $validator->fails() ) {
                return back()->withInput()->withErrors($validator);
            }

            $file = $request->file('file');

            $file_display_name = $file->getClientOriginalName();
            $file_new_name = strtotime('now') . '.' . $file->extension();

            $file->move( storage_path('app/') . 'public/scanned-documents/' , $file_new_name  );

            $data['user_id'] = Auth::user()->id;
            $data['file_display_name'] = $file_display_name;
            $data['file_path'] = $file_new_name;

            ScannedDocument::create( $data );

            return back()->with('success', 'The document has been created successfully.');

        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while uploading the document. ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DocumentLibrary  $DocumentLibrary
     * @return \Illuminate\Http\Response
     */
    public function show(DocumentLibrary $DocumentLibrary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DocumentLibrary  $DocumentLibrary
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        abort_if(Gate::denies('Scanned Documents - Edit'), redirect(url('/dashboard')));

        $document = ScannedDocument::whereUuid($uuid)->firstOrfail();
        $companies = getCompanies();

        return view('scanned-documents.edit', compact('document', 'companies') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DocumentLibrary  $DocumentLibrary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        try {
            $document = ScannedDocument::whereUuid($uuid)->firstOrfail();

            $rules = [
                'title' => ['required', 'string', 'max:255'],
                'company_id' => ['required'],   
                'file' => ['nullable']
            ];

            $data = $request->except(['_token', 'upload']);

            $validator = Validator::make($data, $rules);

            if ( $validator->fails() ) {
                return back()->withInput()->withErrors($validator);
            }

            if( $request->has('file') && !is_null( $request->file ) ) {
                $file = $request->file('file');

                $file_display_name = $file->getClientOriginalName();
	            $file_new_name = strtotime('now') . '.' . $file->extension();

	            $file->move( storage_path('app/') . 'public/scanned-documents/', $file_new_name );

	            // delete the old file if it exist
	            if( file_exists( storage_path('app/') . 'public/scanned-documents/' . $document->file_path ) ) {
	            	unlink( storage_path('app/') . 'public/scanned-documents/' . $document->file_path );
	            }

	            $document->file_display_name = $file_display_name;
	            $document->file_path = $file_new_name;
            }

            $document->user_id = Auth::user()->id;
            $document->title = $request->title;
            $document->company_id = $request->company_id;

            $document->save();

            return Redirect::route('scanned-documents.index')->with('success', 'The document has been updated successfully.');
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while updating the document. ' . $e->getMessage()); // $e->getMessage()
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DocumentLibrary  $DocumentLibrary
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        abort_if(Gate::denies('Scanned Documents - Delete'), redirect(url('/dashboard')));

        try {
            $document = ScannedDocument::whereUuid($uuid)->firstOrfail();
            $document->delete();

            if( file_exists( storage_path('app/') . 'public/scanned-documents/' . $document->file_path ) ) {
                unlink( storage_path('app/') . 'public/scanned-documents/' . $document->file_path );
            }

            return back()->with('success', 'The document has been deleted successfully.');
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while deleting the document. ' . $e->getMessage()); // $e->getMessage()
        }
    }

    public function download($uuid) {
        try {

            $document = ScannedDocument::whereUuid($uuid)->firstOrfail();

            $file_path = storage_path('app/') . 'public/scanned-documents/' . $document->file_path;

            if ( !file_exists( $file_path ) ) {
                die('Sorry! This file is not found on the server.');
            }

            return response()->download( $file_path );
        }
        catch(\Exception $e) {
            die( $e->getMessage() );
        }
    }

    public function getDocument($uuid) {
        try {

            $document = ScannedDocument::whereUuid($uuid)->firstOrfail();

            $file_name = $document->file_path;

            $file_path = storage_path( 'app/public/scanned-documents/' . $file_name );

            if ( !file_exists( $file_path ) ) {
                die('Sorry! This file is not found on the server.');
            }

            $pdfContent = \Storage::disk('local')->get('public/scanned-documents/' . $file_name );
            $type       = mime_content_type( $file_path );

            return Response::make($pdfContent, 200, [
                'Content-Type'        => $type,
                'Content-Disposition' => 'inline; filename="'.$file_name.'"'
            ]);
        }
        catch(\Exception $e) {
            die( $e->getMessage() );
        }
    }
}