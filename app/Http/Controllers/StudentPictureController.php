<?php

namespace App\Http\Controllers;

use App\Models\StudentPicture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class StudentPictureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $query = StudentPicture::all();
        return response()->json($query);
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
        try {
            StudentPicture::create($request->all());

            //dili ga gana :(
            $path = public_path() . "/attachments/" + $request->first_name + "_" + $request->last_name;
            File::makeDirectory($path, 0777, true, true, true);
            Storage::makeDirectory($path);

            return $this->index();
        } catch (\Exception $e) {
            return response()->json(["error" => $e]);
        }
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

    public function getImage(Request $request)
    {
    }
}
