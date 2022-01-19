<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use Response;
use Redirect;

use App\Models\TechnologyReport;
use App\Models\Company;

class TechnologyReportController extends Controller
{
    public function migrate_reports() {
        $reports = DB::table('technology_reports_bk')->get();
        foreach( $reports as $report ) {
            $report = collect($report)->toArray();
            TechnologyReport::create( $report );
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company_admin      = Auth::user()->company_admin;
        $logged_in_username = Auth::user()->username;
        $company_name       = getCurrentUserCompanyName();

        if ($company_admin === 'Y' AND $logged_in_username === \Config::get('constants.admin')) {
            $reports = TechnologyReport::all();
        } else {
            $reports = TechnologyReport::where('company_name', $company_name)->get();
        }

        $companies = getCompanies();
        
        return view('technology-reports.index', compact('reports', 'companies') );
    }

    public function ajaxGetTechnologyReport(Request $request) {

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

            $reports = TechnologyReport::select(['uuid', 'name', 'file', 'company_name']);

            $isSuperAdmin = false;
            if( getCurrentUserRole() === \Config::get('constants.admin')) {
                
                $isSuperAdmin = true;
            } else {
                $reports->where('company_name', $company_name);
            }

            if(!empty($searchchar)) {
                $reports->where(function($query) use($searchchar) {
                    return $query->orWhere('name', 'like', '%'.$searchchar.'%')->orWhere('file', 'like', '%'.$searchchar.'%')->orWhere('company_name', 'like', '%'.$searchchar.'%');
                });
            }

            switch ($ordercol) {
                case 0: $reports->orderBy('name', $orderdir); break;
                case 1: $reports->orderBy('company_name', $orderdir); break;
                case 2: $reports->orderBy('file', $orderdir); break;
                default: $reports->orderBy('name', $orderdir);
            }

            $total_reports = $reports->count();
            $reports->skip($start)->take($length);

            $data = $reports->get();
            $data = $data->map(function($report, $key) use($isSuperAdmin) {

                $report->no = intval( $key ) + 1;

                $file_extension = strtolower( pathinfo($report->file, PATHINFO_EXTENSION) );
                if( $file_extension === 'pdf' ) {
                    $report->file = '<a href="' . route('viewTechDocument', $report->uuid) . '" class="view-document" target="_blank">'. $report->file .'</a>';
                } else {
                    $report->file = '<a href="' . route('downloadTechReport', $report->uuid) . '" target="_blank">'. $report->file .'</a>';
                }

                $actions = [];

                if( $isSuperAdmin ) {
                    $actions[] = '<a href="' . route('technology-report.edit', $report->uuid) . '" class="btn btn-xs btn-custom-primary"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>';
                    $actions[] = '<a href="' . route('technology-report.destroy', $report->uuid) . '" class="btn btn-xs btn-custom-danger delete-report"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</a>';
                }

                $report->actions = '<div class="btn-toolbar">'.implode('', $actions) .'</div>';
                return $report;
            });

            // dd($data);

            return response::json([
                'data' => $data,
                'recordsTotal' => $total_reports,
                'recordsFiltered' => $total_reports
            ]);

        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while fetching the technology reports. ' . $e->getMessage()); // 
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = getCompanies();

        return view('technology-reports.create', compact('companies') );
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
                'file' => ['required']
            ];

            $data = $request->except(['_token', 'submit']);

            $validator = Validator::make($data, $rules);

            if ( $validator->fails() ) {
                return back()->withInput()->withErrors($validator);
            }

            $file = $request->file('file');

            $file_name = $file->getClientOriginalName();

            $file_path = storage_path( 'app/public/reports/' . $file_name );

            if( file_exists( $file_path ) ) {
                return back()->with('error', 'Report with the same name already found so please change the file name and reupload to save the report.');
            }

            $file->move( storage_path('app/') . 'public/reports/' , $file_name  );

            $data['file'] = $file_name;
            $data['size'] = intval( $request->file('file')->getSize() ) / 1024; // file size in KB
            $data['type'] = $request->file('file')->getClientMimeType();
            $data['firstname'] = '';
            $data['user_id'] = Auth::user()->id;

            TechnologyReport::create( $data );

            return Redirect::route('technology-report.index')->with('success', 'Report has been uploaded successfully.');

            // return Redirect::route('technology-report.index')->with('success', 'Report has been uploaded successfully.');

        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while storing the technology report. ' . $e->getMessage()); // 
        }
    }

    public function download($report_uuid) {
        try {

            $report = TechnologyReport::whereUuid($report_uuid)->firstOrfail();

            $file_path = storage_path('app/') . 'public/reports/' . $report->file;

            if ( !file_exists( $file_path ) ) {
                die('Sorry! This file is not found on the server.');
            }

            return response()->download( $file_path );
        }
        catch(\Exception $e) {
            die($e->getMessage());
            // return back()->with('error', 'Sorry! There was an error while downloading the technology report. ' . $e->getMessage()); // 
        }
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
    public function edit($uuid)
    {
        $report = TechnologyReport::whereUuid($uuid)->firstOrfail();
        $companies = getCompanies();

        return view('technology-reports.edit', compact('companies', 'report') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        try {
            $report = TechnologyReport::whereUuid($uuid)->firstOrfail();

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

                $report->file = $file_name;
                $report->size = intval( $request->file('file')->getSize() ) / 1024; // file size in KB
                $report->type = $request->file('file')->getClientMimeType();
            }

            $report->name = $request->name;
            $report->company_name = $request->company_name;
            $report->firstname = '';
            $report->user_id = Auth::user()->id;

            $report->save();

            return Redirect::route('technology-report.index')->with('success', 'Report has been updated successfully.');
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while updating the report. ' . $e->getMessage()); // $e->getMessage()
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($report_uuid)
    {
        try {
            $report = TechnologyReport::whereUuid($report_uuid)->firstOrfail();
            $report->delete();

            if( file_exists( storage_path('app/') . 'public/reports/' . $report->file ) ) {
                unlink( storage_path('app/') . 'public/reports/' . $report->file );
            }

            return back()->with('success', 'Report has been deleted successfully.');
        }
        catch(\Exception $e) {
            return back()->with('error', 'Sorry! There was an error while deleting the report. ' . $e->getMessage()); // $e->getMessage()
        }
    }

    public function getDocument($uuid) {
        try {

            $report = TechnologyReport::whereUuid($uuid)->firstOrfail();

            $file_name = $report->file;

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
