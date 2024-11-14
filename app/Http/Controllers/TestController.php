<?php

namespace App\Http\Controllers;

use App\Jobs\MyJob;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::all();
        $models = Role::orderBy('id', 'ASC')->take(10)->get();
        return view('spatie-permission', ['models'=> $models,'permissions' => $permissions]);
    }


    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'permissions' => 'required|array',
        ]);
        MyJob::dispatch($data);
    
        return redirect()->route('spatie-permission')->with('success', 'Roles created successfully!');
    }
    

    public function update(Request $request , Role $role)
    {
        $data = $request->validate([
            'name' => 'required',
            'permissions' => 'required|array',
        ]);
        $ids = $data['permissions'];
        unset($data['permissions']);

        $role->update($data);
        $role->permissions()->sync($ids);
        return redirect()->route('spatie-permission');

    }

    public function delete(Role $role)
    {
        $role->delete();
        return redirect()->route('spatie-permission');
    }
    
}