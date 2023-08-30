<?php

namespace App\Http\Controllers;

use App\Models\chirp;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
// use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index():Response
    // {
    //     return response('Hello World');
    // }
public function index():View
{
    return view('chirps.index', [
        'chirps' => Chirp::with('user')->latest()->get(),
    ]);
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
    public function store(Request $request):RedirectResponse
    {
        $valid = $request->validate([
            'message' =>'required|string|max:300'
        ]);
        $request->user()->chirps()->create($valid);
        return redirect(route('chirps.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(chirp $chirp)
    {
        $this->authorize('update', $chirp);
        return view('chirps.edit',['chirp' =>$chirp,]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, chirp $chirp)
    {        $this->authorize('update', $chirp);

       $valideted = $request->validate([
        'message' =>'required|string|max:255'
       ]);
       $chirp->update($valideted);
       return redirect(route('chirps.index'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(chirp $chirp)
    {
        $this->authorize('delete', $chirp);

        $chirp->delete();
 
        return redirect(route('chirps.index'));
    }
}
