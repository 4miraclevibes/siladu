<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Method;
use App\Models\Parameter;
use Illuminate\Http\Request;

class MethodController extends Controller
{
    public function index()
    {
        $methods = Method::all();
        $parameters = Parameter::all();
        return view('pages.backend.methods.index', compact('methods', 'parameters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'parameter_id' => 'required',
        ]);
        $data = $request->all();
        Method::create($data);
        return redirect()->route('methods.index')->with('success', 'Method created successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'parameter_id' => 'required',
        ]);
        $data = $request->all();
        $method = Method::findOrFail($id);
        $method->update($data);
        return redirect()->route('methods.index')->with('success', 'Method updated successfully');
    }

    public function destroy($id)
    {
        $method = Method::findOrFail($id);
        $method->delete();
        return redirect()->route('methods.index')->with('success', 'Method deleted successfully');
    }
}
