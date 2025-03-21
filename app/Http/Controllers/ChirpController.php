<?php

namespace App\Http\Controllers;

use App\Events\ChirpDeleted;
use App\Events\ChirpPosted;
use App\Events\ChirpUpdated;
use App\Models\Chirp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // Retrieve chirps
        $chirps = Chirp::with('user')->latest()->get();

        // pass chirps using compact
        return view('chirps.index', compact('chirps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $chirp = $request->user()->chirps()->create($validated);
        broadcast(new ChirpPosted($chirp))->toOthers();
        return redirect(route('chirps.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {
        // check if user can edit
        // Correct syntax for authorization
        Gate::authorize('update', $chirp);

        return view('chirps.edit', compact('chirp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp)
    {
        Gate::authorize('update', $chirp);
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $chirp->update($validated);
        // Ensure we pass the updated chirp instance
        broadcast(new ChirpUpdated($chirp->fresh()))->toOthers();
        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp): RedirectResponse
    {
        Gate::authorize('delete', $chirp);
        $chirp->delete();
        broadcast(new ChirpDeleted($chirp->id))->toOthers();
        return redirect(route('chirps.index'));
    }
}
