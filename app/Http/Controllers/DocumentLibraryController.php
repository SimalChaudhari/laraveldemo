<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;
use Response;
use DB;
use Redirect;
use Gate;

use App\Models\DocumentLibrary;
use App\Models\Company;

/**
 * @group DocumentLibrary management
 *
 * APIs for managing DocumentLibrary
 */

class DocumentLibraryController extends Controller
{

    public function migrate_agreements() {
        $agreements = DB::table('upload_agreements_bk')->get();
        foreach( $agreements as $agreement ) {
            $agreement = collect($agreement)->toArray();
            DocumentLibrary::create( $agreement );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('Document Library'), redirect(url('/dashboard')));

        return view( 'document-library.index' );
    }

    public function ajaxGetDocumentLibraries(Request $request) {
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

            $agreements = DocumentLibrary::select(['uuid', 'name', 'file', 'company_name']);


            $isSuperAdmin = true;
            // $isSuperAdmin = false;
            // if( getCurrentUserRole() === \Config::get('constants.admin')) {
                
            //     $isSuperAdmin = true;
            // } else {
            //     $agreements->where('company_name', $company_name);
            // }

            if(!empty($searchchar)) {
                $agreements->where(function($query) use($searchchar) {
                    return $query->orWhere('name', 'like', '%'.$searchchar.'%')->orWhere('file', 'like', '%'.$searchchar.'%')->orWhere('company_name', 'like', '%'.$searchchar.'%');
                });
            }

            switch ($ordercol) {
                case 0: $agreements->orderBy('name', $orderdir); break;
                case 1: $agreements->orderBy('company_name', $orderdir); break;
                case 2: $agreements->orderBy('file', $orderdir); break;
                default: $agreements->orderBy('name', $orderdir);
            }

            $total_agreements = $agreements->count();
            $agreements->skip($start)->take($length);

            $data = $agreements->get();
            $data = $data->map(function($agreement) use($isSuperAdmin) {
                
                $file_extension = strtolower( pathinfo($agreement->file, PATHINFO_EXTENSION) );
                if( $file_extension === 'pdf' ) {
                    $agreement->file = '<a href="' . route('viewDocument', $agreement->uuid) . '" class="view-document" target="_blank">'. $agreement->file .'</a>';
                } else {
                    $agreement->file = '<a href="' . route('downloadAgreement', $agreement->uuid) . '" target="_blank">'. $agreement->file .'</a>';    
                }
                
                $can_edit = Auth::user()->can('Edit Document Library') ? true : false;
                $can_delete = Auth::user()->can('Delete Document Library') ? true : false;

                $actions = [];

                // if( $isSuperAdmin ) {
                //     $actions[] = '<a href="' . route('document-library.edit', $agreement->uuid) . '" class="btn btn-xs btn-custom-primary"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>';
                //     $actions[] = '<a href="' . route('document-library.destroy', $agreement->uuid) . '" class="btn btn-xs btn-custom-danger delete-library"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</a>';
                // }
                
                if( $can_edit ) {
                    $actions[] = '<a href="' . route('document-library.edit', $agreement->uuid) . '" class="btn btn-xs btn-custom-primary"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>';
                }

                if( $file_extension === 'pdf' ) {
                    $actions[] = '<a href="' . route('viewDocument', $agreement->uuid) . '" class="view-document btn btn-xs btn-custom-success" target="_blank"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View</a>';
                }

                $actions[] = '<a href="' . route('downloadAgreement', $agreement->uuid) . '" class="btn btn-xs btn-custom-info" target="_blank"><span class="glyphicon glyphicon-download" aria-hidden="true"></span> Download</a>';

                if( $isSuperAdmin && $can_delete ) {
                    $actions[] = '<a href="' . route('document-library.destroy', $agreement->uuid) . '" class="btn btn-xs btn-custom-danger delete-library"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</a>';
                }

                $agreement->actions = '<div class="btn-toolbar">'.implode('', $actions) .'</div>';
                return $agreement;
            });

            return response::json([
                'data' => $data,
                'recordsTotal' => $total_agreements,
                'recordsFiltered' => $total_agreements
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
        abort_if(Gate::denies('Create Document Library'), redirect(url('/dashboard')));

        $companies = getCompanies();

        return view('document-library.create', compact('companies') );
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
                'name' => ['required', 'string', 'max:255'],
                'company_name' => ['required', 'string'],
                'file' => ['required'],
            ];

            $data = $request->except(['_token', 'upload']);

            $validator = Validator::make($data, $rules);
            
            if ( $validator->fails() ) {
                return back()->withInput()->withErrors($validator);
            }

            $file = $request->file('file');

            $file_name = $file->getClientOriginalName();

            $file_path = storage_path( 'app/public/reports/' . $file_name );

            if( file_exists( $file_path ) ) {
                return back()->with('error', 'Agreement with the same name already found so please change the file name and reupload.');
            }

            $file->move( storage_path('app/') . 'public/reports/' , $file_name  );

            $data['user_id'] = Auth::user()->id;
            $data['file'] = $file_name;
            $data['type'] = $request->file('file')->getClientMimeType();
            $data['size'] = intval( $request->file('file')->getSize() ) / 1024; // file size in KB
            $data['firstname'] = Auth::user()->firstname;

            DocumentLibrary::create( $data );

            return back()->with('success', 'The document has been created successfully.');

        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while storing the agreement. ' . $e->getMessage()); // 
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
        abort_if(Gate::denies('Edit Document Library'), redirect(url('/dashboard')));

        $agreement = DocumentLibrary::whereUuid($uuid)->firstOrfail();
        $companies = getCompanies();

        return view('document-library.edit', compact('agreement', 'companies') );
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
            $agreement = DocumentLibrary::whereUuid($uuid)->firstOrfail();

            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'company_name' => ['required', 'string'],   
                'file' => ['nullable', 'mimes:pdf'] // actually doc and docx are zip files
            ];

            $data = $request->except(['_token', 'submit']);

            $validator = Validator::make($data, $rules);

            if ( $validator->fails() ) {
                return back()->withInput()->withErrors($validator);
            }

            if( $request->has('file') && !is_null( $request->file ) ) {
                $file = $request->file('file');

                $file_name = $file->getClientOriginalName();

                $file_path = storage_path( 'app/public/reports/' . $file_name );

                if( file_exists( $file_path ) ) {
                    return back()->with('error', 'Report with the same name already found so please change the file name and reupload to save the report.');
                }

                $file->move( storage_path('app/') . 'public/reports/' , $file_name  );

                $agreement->file = $file_name;
                $agreement->size = intval( $request->file('file')->getSize() ) / 1024; // file size in KB
                $agreement->type = $request->file('file')->getClientMimeType();
            }

            $agreement->name = $request->name;
            $agreement->company_name = $request->company_name;
            $agreement->firstname = '';
            $agreement->user_id = Auth::user()->id;

            $agreement->save();

            return Redirect::route('document-library.index')->with('success', 'The document has been updated successfully.');
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while updating the library. ' . $e->getMessage()); // $e->getMessage()
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
        abort_if(Gate::denies('Delete Document Library'), redirect(url('/dashboard')));

        try {
            $agreement = DocumentLibrary::whereUuid($uuid)->firstOrfail();
            $agreement->delete();

            if( file_exists( storage_path('app/') . 'public/reports/' . $agreement->file ) ) {
                unlink( storage_path('app/') . 'public/reports/' . $agreement->file );
            }

            return back()->with('success', 'The document library has been deleted successfully.');
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while deleting the library. ' . $e->getMessage()); // $e->getMessage()
        }
    }

    public function download($uuid) {
        try {

            $agreement = DocumentLibrary::whereUuid($uuid)->firstOrfail();

            $file_path = storage_path('app/') . 'public/reports/' . $agreement->file;

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

            $agreement = DocumentLibrary::whereUuid($uuid)->firstOrfail();

            $file_name = $agreement->file;

            $file_path = storage_path( 'app/public/reports/' . $file_name );

            if ( !file_exists( $file_path ) ) {
                die('Sorry! This file is not found on the server.');
            }

            $pdfContent = \Storage::disk('local')->get('public/reports/' . $file_name );
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
