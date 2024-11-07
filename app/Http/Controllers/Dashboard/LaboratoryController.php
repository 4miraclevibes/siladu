<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laboratory;
class LaboratoryController extends Controller
{
    public function index()
    {
        $laboratories = Laboratory::orderBy('created_at', 'desc')->get();
        return view('pages.backend.laboratories.index', compact('laboratories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $data = $request->all();
        Laboratory::create($data);
        return redirect()->route('laboratories.index')->with('success', 'Laboratory created successfully');
    }

    public function update(Request $request, Laboratory $laboratory)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $data = $request->all();
        $laboratory->update($data);
        return redirect()->route('laboratories.index')->with('success', 'Laboratory updated successfully');
    }

    public function destroy(Laboratory $laboratory)
    {
        $laboratory->delete();
        return redirect()->route('laboratories.index')->with('success', 'Laboratory deleted successfully');
    }
}
