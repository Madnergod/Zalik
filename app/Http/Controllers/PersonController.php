<?php

namespace App\Http\Controllers;

use App\Http\Resources\PersonResource;
use App\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Person::all();
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $person = Person::find($id);
        if(is_null($person)){
            return response()->json(['message' => 'Not found'], 404);
        }
        return new PersonResource($person);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $person = Person::find($id);
        if(count($request->all())==0){
            return response()->json(['message'=> '1', 'errors'=> $person], 422);
        }

        $person->update($request->all());
        $person->save();
        return response()->json(['data'=>$person], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $person = Person::find($id);
        if(is_null($person)){
            return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json([
            'data'=>[
                'first_name'=>1, 'middle_name'=>1, 'last_name'=>1
            ]
        ], 200);

    }
}
