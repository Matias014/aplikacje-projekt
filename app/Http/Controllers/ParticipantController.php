<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index()
    {
        $participants = Participant::all();
        // dla admina dodam możliwość zobaczenia wszystkich turniejów i użytkowników, którzy są przypisani do nich w formie tabelki
        // będzie ich mógł usuwać

        // return view('trips.index', [
        //     'trips' => $trips,
        //     'randomTrips' => $trips->random(4),
        // ]);
    }

    public function show($id)
    {
        return view('trips.show', [
            'trip' => Trip::findOrFail($id)
        ]);
    }

    public function edit($id)
    {
        $trip = Trip::findOrFail($id);
        return view('trips.edit', [
            'trip' => $trip,
            'countries' => Country::all()
        ]);
    }

    public function update(Request $request, $id)
    {
        if (!Gate::allows('is-admin')) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|unique:trips,name,'.$id,
            'continent' => 'required|string',
            'period' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'img' => 'required|string',
            'country_id' => 'required|integer|exists:countries,id',
        ]);

        $trip = Trip::findOrFail($id);
        $input = $request->all();
        $trip->update($input);
        return redirect()->route('trips.index');
    }
}
