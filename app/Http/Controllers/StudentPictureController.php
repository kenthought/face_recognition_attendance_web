<?php

namespace App\Http\Controllers;

use App\Models\StudentPicture;
use Illuminate\Http\Request;

class StudentPictureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\StudentPicture  $studentPicture
     * @return \Illuminate\Http\Response
     */
    public function show(StudentPicture $studentPicture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentPicture  $studentPicture
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentPicture $studentPicture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentPicture  $studentPicture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentPicture $studentPicture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentPicture  $studentPicture
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentPicture $studentPicture)
    {
        //
    }
}
