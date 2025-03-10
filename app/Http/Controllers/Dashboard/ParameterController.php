<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Parameter;
use App\Models\Package;
use Illuminate\Http\Request;

class ParameterController extends Controller
{
    public function index()
    {
        $parameters = Parameter::orderBy('created_at', 'desc')->get();
        $packages = Package::orderBy('created_at', 'desc')->get();
        return view('pages.backend.parameters.index', compact('parameters', 'packages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'package_id' => 'required',
            'code' => 'nullable'
        ]);
        $data = $request->all();
        Parameter::create($data);
        return redirect()->route('parameters.index')->with('success', 'Parameter created successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'package_id' => 'required',
            'code' => 'nullable'
        ]);
        $data = $request->all();
        $parameter = Parameter::findOrFail($id);
        $parameter->update($data);
        return redirect()->route('parameters.index')->with('success', 'Parameter updated successfully');
    }

    public function destroy($id)
    {
        $parameter = Parameter::findOrFail($id);
        $parameter->delete();
        return redirect()->route('parameters.index')->with('success', 'Parameter deleted successfully');
    }
}
