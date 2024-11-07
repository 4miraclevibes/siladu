<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Laboratory;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        $laboratories = Laboratory::all();
        return view('pages.backend.packages.index', compact('packages', 'laboratories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'satuan' => 'required',
            'harga' => 'required',
            'catatan' => 'nullable',
            'laboratory_id' => 'required',
        ]);
        $data = $request->all();
        Package::create($data);
        return redirect()->route('packages.index')->with('success', 'Package created successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'satuan' => 'required',
            'harga' => 'required',
            'catatan' => 'nullable',
            'laboratory_id' => 'required',
        ]);
        $data = $request->all();
        $package = Package::findOrFail($id);
        $package->update($data);
        return redirect()->route('packages.index')->with('success', 'Package updated successfully');
    }

    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        $package->delete();
        return redirect()->route('packages.index')->with('success', 'Package deleted successfully');
    }
}
