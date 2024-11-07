<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QualityStandart;

class QualityStandartController extends Controller
{
    public function index()
    {
        $qualityStandarts = QualityStandart::orderBy('created_at', 'desc')->get();
        return view('pages.backend.qualityStandarts.index', compact('qualityStandarts'));
    }

    public function store(Request $request)
    {
        QualityStandart::create($request->all());
        return redirect()->route('quality-standarts.index')->with('success', 'Standar Mutu berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $qualityStandart = QualityStandart::findOrFail($id);
        $qualityStandart->update($request->all());
        return redirect()->route('quality-standarts.index')->with('success', 'Standar Mutu berhasil diubah');
    }

    public function destroy($id)
    {
        $qualityStandart = QualityStandart::findOrFail($id);
        $qualityStandart->delete();
        return redirect()->route('quality-standarts.index')->with('success', 'Standar Mutu berhasil dihapus');
    }
}
