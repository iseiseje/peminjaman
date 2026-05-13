<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\ReturnBorrowingRequest;
use App\Http\Requests\Student\StoreBorrowingRequest;
use App\Models\Borrowing;
use App\Models\Commodity;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $today = now();
        $student = auth('student')->user();

        $borrowings = Borrowing::with('student:id,identification_number,name', 'commodity:id,name', 'officer:id,name')
            ->select('id', 'commodity_id', 'student_id', 'officer_id', 'date', 'time_start', 'time_end')
            ->whereDate('date', $today)
            ->where('student_id', $student->id)
            ->orderByDesc('date')
            ->get();

        $commodities = Commodity::select('id', 'name', 'stock', 'program_study_id')
            ->where(function($query) use ($student) {
                $query->whereNull('program_study_id')
                      ->orWhere('program_study_id', $student->program_study_id);
            })
            ->get();

        $availableCommodities = $commodities->where('stock', '>', 0);
        $unavailableCommodities = $commodities->where('stock', '<=', 0);

        return view('student.borrowing.main.index', compact('borrowings', 'availableCommodities', 'unavailableCommodities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBorrowingRequest $request)
    {
        $validated = $request->safe()->merge(['student_id' => auth('student')->id(), 'date' => now()]);
        
        $commodity = Commodity::findOrFail($validated['commodity_id']);

        if ($commodity->stock <= 0) {
            return redirect()->route('students.borrowings.index')
                ->with('error', 'Stok komoditas yang dipilih habis!');
        }

        // Optional check to prevent same student borrowing same item at the same time if not returned
        $alreadyBorrowed = Borrowing::where('student_id', $validated['student_id'])
            ->where('commodity_id', $commodity->id)
            ->whereNull('time_end')
            ->exists();

        if ($alreadyBorrowed) {
            return redirect()->route('students.borrowings.index')
                ->with('error', 'Anda masih meminjam barang ini dan belum mengembalikannya!');
        }

        $commodity->decrement('stock');
        Borrowing::create($validated->toArray());

        return redirect()->route('students.borrowings.index')->with('success', 'Berhasil dipinjam!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Borrowing $borrowing)
    {
        $borrowing->update($request->all());

        return redirect()->route('students.borrowings.index')->with('success', 'Data berhasil diubah!');
    }

    /**
     * Returning borowing by changing the is_return status column.
     */
    public function returnBorrowing(ReturnBorrowingRequest $request, Borrowing $borrowing)
    {
        if (is_null($borrowing->time_end)) {
            $validated = $request->merge(['time_end' => now()])->toArray();
            $borrowing->update($validated);
            
            // Return stock
            $borrowing->commodity()->increment('stock');
        }

        return redirect()->back()->with('success', 'Status berhasil diubah, barang telah dikembalikan!');
    }
}
