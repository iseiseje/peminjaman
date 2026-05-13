<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\StoreCommodityRequest;
use App\Http\Requests\Administrator\UpdateCommodityRequest;
use App\Http\Requests\ImportExcelRequest;
use App\Models\Commodity;
use App\Services\ImportService;

class CommodityController extends Controller
{
    private ImportService $importService;

    public function __construct()
    {
        $this->importService = new ImportService(new Commodity());
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commodities = Commodity::with(['category', 'programStudy'])->get();
        $categories = \App\Models\Category::all();
        $program_studies = \App\Models\ProgramStudy::all();

        return view('administrator.commodity.index', compact('commodities', 'categories', 'program_studies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommodityRequest $request)
    {
        $data = $request->validated();
        
        // Auto-generate SKU (item_code)
        $latestCommodity = Commodity::withTrashed()->whereNotNull('item_code')->orderBy('id', 'desc')->first();
        if ($latestCommodity) {
            $lastCode = intval($latestCommodity->item_code);
            $data['item_code'] = str_pad($lastCode + 1, 9, '0', STR_PAD_LEFT);
        } else {
            $data['item_code'] = str_pad(1, 9, '0', STR_PAD_LEFT);
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('commodities', 'public');
        }
        Commodity::create($data);

        return redirect()->route('administrators.commodities.store')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommodityRequest $request, Commodity $commodity)
    {
        $data = $request->validated();
        
        // Prevent manual update of item_code
        unset($data['item_code']);

        if ($request->hasFile('image')) {
            if ($commodity->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($commodity->image);
            }
            $data['image'] = $request->file('image')->store('commodities', 'public');
        }
        $commodity->update($data);

        return redirect()->route('administrators.commodities.index')->with('success', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commodity $commodity)
    {
        $commodity->delete();

        return redirect()->route('administrators.commodities.index')->with('success', 'Data berhasil dihapus!');
    }

    /**
     * Import a listing of the resource.
     */
    public function import(ImportExcelRequest $request)
    {
        $counts = $this->importService->importExcel($request->validated('import'), ['name'], 'name', 0);
        $message = "Total {$counts['imported']} berhasil diimpor, {$counts['ignored']} dihiraukan!";

        return redirect()->route('administrators.commodities.index')->with('success', $message);
    }
}
