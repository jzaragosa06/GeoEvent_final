<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;


//we need this import to work with db facade
use Illuminate\Support\Facades\DB;


class GooogleController extends Controller
{
    public function index()
    {
        $response = Http::get('https://eonet.gsfc.nasa.gov/api/v2.1/events?status=open');
        $events = $response->json()['events'];

        // Read the JSON file from the storage directory
        $citiesJson = Storage::get('json/cities.json');
        $cities = json_decode($citiesJson, true);

        return view('index', compact('cities', 'events'));
    }

    public function satellite()
    {
        return view('satellite');
    }

    public function demoParse()
    {
        return view('sampleparse');
    }

    public function profile()
    {
        $userid = session('userid');

        $locations = DB::table('locations')->where('userid', $userid)->get();
        return view('profile', compact('locations'));
    }



    public function add_show()
    {
        $response = Http::get('https://eonet.gsfc.nasa.gov/api/v2.1/events?status=open');
        $events = $response->json()['events'];
        return view('add', compact('events'));
    }

    public function addloc(Request $request)
    {


        //validate the form

        //i am using db facade to store data. 
        //add a user login and registration. 
        $validated = $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'description' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'range' => 'required|integer|min:0',
        ]);

        //userid of the active user
        $userid = session('userid');

        //i will be using a userid of 1 for this example
        DB::table('locations')->insert([
            'userid' => $userid,
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'address' => $validated['address'],
            'description' => $validated['description'],
            'range' => $validated['range'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('index')->with('success', 'location is added successfully');

    }


    public function monitor()
    {
        //we are going to implement a user login an duser registrtion. 
        //we need to store the userid in session variable so that we access it here. 
        //basically, we are fetching the selected locations for specific users. 

        //assume that userid is 1
        $userId = session('userid');

        $locations = DB::table('locations')->where('userid', $userId)->get();
        $response = Http::get('https://eonet.gsfc.nasa.gov/api/v2.1/events?status=open');
        $events = $response->json()['events'];



        return view('monitor', compact('locations', 'events'));
    }


    public function delete_loc($locid)
    {
        // Delete the record from the locations table
        DB::table('locations')->where('locid', $locid)->delete();

        // Redirect back with a success message
        return redirect()->route('profile')->with('success_delete', 'Location deleted successfully.');
    }
}
