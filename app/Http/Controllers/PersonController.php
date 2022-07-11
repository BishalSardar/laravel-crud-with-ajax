<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use DataTables;
use Exception;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    function getItem(Request $request)
    {
        try {
            $person = Person::all();
            return response([
                'person' => $person,

            ]);
        } catch (Exception $exception) {
            return response([
                'message' => 'error' . $exception,
            ]);
        }
    }

    function form_submit(Request $request)
    {
        try {
            $person = new Person();
            $person->name = $request->name;
            $person->details = $request->details;
            $person->save();
        } catch (Exception $exception) {
            dd($exception);
            return redirect()->back()->with('error', 'This is the error' . $exception);
        }
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function show(Person $person)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function edit(Person $person, $id)
    {
        $person = Person::find($id);
        return response([
            'person' => $person,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Person $person, $id)
    {
        try {
            $person = Person::find($id);
            $person->name = $request->name;
            $person->details = $request->details;
            $person->update();
        } catch (Exception $exception) {
            dd($exception);
            return redirect()->back()->with('error', 'This is the error' . $exception);
        }
        return redirect()->back();
    }

    public function delete(Request $request, Person $person, $id)
    {
        $person = Person::find($id);
        $person->delete();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person)
    {
        //
    }
}
