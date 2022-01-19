<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Redirect;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RoleController extends Controller

{

    function __construct(){
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $roles = Role::where('name', 'not like', 'Admin')->orderBy('role_order', 'asc')->paginate(10);

        return view('roles.index',compact('roles'))

            ->with('i', ($request->input('page', 1) - 1) * 10);
    }

    private function getPermissions() {

        return [
            'Roles' => [ 1 => 'List', 2 => 'Create', 3 => 'Edit', 4 => 'Delete'],
            'Users' => [ 5 => 'List', 6 => 'Create', 7 => 'Edit', 8 => 'Delete'],
            'HIPAA Rules and Safe Harbor' => [ 11 => 'HIPAA Safe Harbor', 12 => 'HIPAA Rules'],
            'Quiz' => [ 14 => 'List', 53 => 'Create', 54 => 'Edit', 55 => 'Delete'],
            'Questions' => [ 49 => 'List', 50 => 'Create', 51 => 'Edit', 52 => 'Delete'],
            'Training' => [ 13 => 'Overview', 15 => 'Training Video', 16 => 'Training Quiz', 17 => 'Training Acknowledgement'],
            'Annual Risk Assessment' => [ 18 => 'Risk Assessment Overview', 19 => 'Risk Assessment Quiz', 20 => 'Risk Assessment Acknowledgment'],
            'Policies and Procedures' => [ 21 => 'List', 40 => 'Create', 41 => 'Edit', 42 => 'Delete'],
            'Policy Revisions' => [ 46 => 'List', 47 => 'Create', 48 => 'Delete'],
            'Document Library' => [ 22 => 'List', 33 => 'Create', 34 => 'Edit', 35 => 'Delete'],
            'Scanned Documents' => [ 61 => 'List', 62 => 'Create', 63 => 'Edit', 64 => 'Delete'],
            'Patient Disclosure Authorization Form' => [ 23 => 'List', 43 => 'Create', 44 => 'Edit', 45 => 'Delete'],
            'Authorization to Use and/or Disclose Medical Records Form' => [ 24 => 'List'],
            'Index to Practice Forms' => [ 25 => 'List'],
            'Company' => [ 58 => 'List', 27 => 'Create', 56 => 'Edit', 57 => 'Delete'],
            'Business Associate Agreement' => [ 29 => 'List', 30 => 'Create', 31 => 'Edit', 32 => 'Delete'],
            'EMR Records' => [ 36 => 'List', 37 => 'Create', 38 => 'Edit', 39 => 'Delete'],
            'Setting' => [ 59 => 'Setting' ],
        ];
    }
    
    public function create()
    {
        $permissions = $this->getPermissions();

        return view('roles.create',compact('permissions'));
    }

    public function store(Request $request) {
        $rules = [
            'name' => 'required|unique:roles,name',
            // 'permission' => 'required',
        ];

        $data = $request->except(['_token', 'submit']);

        $validator = Validator::make($data, $rules);

        if ( $validator->fails() ) {
            return back()->withInput()->withErrors($validator);
        }

        $role = Role::create(['name' => $request->input('name')]);

        if( !empty( $request->permission ) ) {
            $role->syncPermissions($request->input('permission'));
        }

        return redirect()->route('roles.index')->with('success','Role: ' . $role->name . ' has been created successfully.');

    }

    public function show($id)
    {

        $role = Role::find($id);

        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")

            ->where("role_has_permissions.role_id",$id)

            ->get();

    

        return view('roles.show',compact('role','rolePermissions'));
    }

    public function edit($id)
    {

        $role = Role::find($id);

        // $permissions = Permission::get();
        $permissions = $this->getPermissions();

        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)

            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')

            ->all();


        return view('roles.edit',compact('role','permissions','rolePermissions'));
    }

    public function update(Request $request, $id)
    {

        $rules = [
            'name' => ['required', Rule::unique('roles')->ignore($id)] //'required|unique:roles,name',
            // 'permission' => 'required',
        ];

        $data = $request->except(['_token', 'update']);

        $validator = Validator::make($data, $rules);

        if ( $validator->fails() ) {
            return back()->withInput()->withErrors($validator);
        }

        $role = Role::find($id);

        $role->name = $request->input('name');

        $role->save();
    
        if( !empty( $request->input('permission') ) ) {
            $role->syncPermissions($request->input('permission'));
        }

        return redirect()->route('roles.index')

                        ->with('success','Role: ' . $role->name . '  has been updated successfully.');

    }

    public function destroy($id)
    {

        DB::table("roles")->where('id',$id)->delete();

        return redirect()->route('roles.index')

                        ->with('success','Role deleted successfully');

    }

    public function saveRoleOrder(Request $request) {

        $role_ids = (array) explode(',', $request->role_ids);
        try {
            if( !empty( $role_ids ) ) {

                $i = 1;

                foreach( $role_ids as $role_id ) {

                    $role = Role::find($role_id);
                    $role->role_order = $i++;
                    $role->save();

                }

            }

            return response()->json([
                'success' => true,
                'message' => 'Role order has been saved successfully.'
            ]);
        }
        catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

    }

}