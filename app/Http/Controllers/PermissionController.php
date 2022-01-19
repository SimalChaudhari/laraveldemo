<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

// use App\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::get();

        return view('permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permission.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:permissions,name',
        ];

        $data = $request->except(['_token', 'submit']);

        $validator = Validator::make($data, $rules);

        if ( $validator->fails() ) {
            return back()->withInput()->withErrors($validator);
        }

        $permission = Permission::create([
            'name' => $request->input('name'),
            'guard_name' => 'web'
        ]);

        return redirect()->route('permission.index')->with('success','Permission has been created successfully.');
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
        $permission = Permission::find($id);

        return view('permission.edit', compact('permission'));
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
        $rules = [
            'name' => ['required', Rule::unique('permissions')->ignore($id)]
        ];

        $data = $request->except(['_token', 'update']);

        $validator = Validator::make($data, $rules);

        if ( $validator->fails() ) {
            return back()->withInput()->withErrors($validator);
        }

        $permission = Permission::find($id);

        $permission->name = $request->input('name');

        $permission->save();

        return redirect()->route('permission.index')

                        ->with('success','Permission has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail( $id );
        $permission->delete();

        return Redirect::route('permission.index')->with('success', 'Permission has been deleted successfully.');
    }
}
