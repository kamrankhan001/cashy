<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Work;

class AdminWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $works = Work::latest()->paginate(10);

        return view('admin.work', compact('works'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        Work::create($request->only('url'));

        return redirect()->route('admin.works')->with('success', 'Work added successfully.');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        $work = Work::findOrFail($id);
        $work->update($request->only('url'));

        return redirect()->route('admin.works')->with('success', 'Work updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $work = Work::findOrFail($id);
        $work->delete();

        return redirect()->route('admin.works')->with('success', 'Work deleted successfully.');
    }
}
