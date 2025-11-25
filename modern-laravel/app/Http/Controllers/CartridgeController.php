<?php

namespace App\Http\Controllers;

use App\Models\Cartridge;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CartridgeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $cartridges = Cartridge::latest()->get();
        return view('cartridges.index', compact('cartridges'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('cartridges.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'owner' => 'required|string|max:50',
            'brand' => 'required|string|max:50',
            'marks' => 'required|string|max:50',
            'code' => 'required|string|max:30',
            'servicename' => 'nullable|string|max:30',
            'technical_life' => 'required|integer|in:0,1',
            'comments' => 'nullable|string|max:50',
            'weight_before' => 'required|integer|min:0',
            'weight_after' => 'required|integer|min:0',
            'date_outcome' => 'nullable|date',
            'date_income' => 'nullable|date',
        ]);

        // Auto-calculate service status
        $validated['inservice'] = 0;
        if (isset($validated['date_outcome']) && isset($validated['date_income'])) {
            $validated['inservice'] = $validated['date_income'] < $validated['date_outcome'] ? 1 : 0;
        }

        Cartridge::create($validated);

        return redirect()
            ->route('cartridges.index')
            ->with('success', 'Cartridge data has been added to the database');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cartridge $cartridge): View
    {
        $cartridge->load('histories');
        return view('cartridges.show', compact('cartridge'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cartridge $cartridge): View
    {
        return view('cartridges.edit', compact('cartridge'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cartridge $cartridge): RedirectResponse
    {
        $validated = $request->validate([
            'owner' => 'required|string|max:50',
            'code' => 'required|string|max:30',
            'servicename' => 'nullable|string|max:30',
            'technical_life' => 'required|integer|in:0,1',
            'comments' => 'nullable|string|max:50',
            'weight_before' => 'required|integer|min:0',
            'weight_after' => 'required|integer|min:0',
            'date_outcome' => 'nullable|date',
            'date_income' => 'nullable|date',
        ]);

        // Auto-calculate service status
        $validated['inservice'] = 0;
        if (isset($validated['date_outcome']) && isset($validated['date_income'])) {
            $validated['inservice'] = $validated['date_income'] < $validated['date_outcome'] ? 1 : 0;
        }

        $cartridge->update($validated);

        return redirect()
            ->route('cartridges.edit', $cartridge)
            ->with('success', 'Data has been updated in the database');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cartridge $cartridge): RedirectResponse
    {
        $cartridge->delete();

        return redirect()
            ->route('cartridges.index')
            ->with('success', 'Cartridge has been deleted');
    }

    /**
     * Display the history of the specified resource.
     */
    public function history(Cartridge $cartridge): View
    {
        $cartridge->load('histories');
        return view('cartridges.history', compact('cartridge'));
    }
}
