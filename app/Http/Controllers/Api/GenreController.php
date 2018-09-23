<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Genre;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Webpatser\Uuid\Uuid;
use Validator;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            Log::info('- [Genre] Listing data...');
            $genres = Genre::all();
            return response()->json(['genres' => $genres, 'code' => 200]);
        } catch (\Exception $e) {
            Log::error('[Genre] error ' . $e->getMessage());
            return response()->json(['code' => 403, 'message' => 'Something went wrong']);
        }
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
            Log::info('- [Genre] Storing data...');

            //*validate fields
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'status' => 'required|boolean',
            ]);

            if ($validator->fails()) {
                //!Validator fails
                return response()->json(['code' => 400, 'message' => $validator->errors()]);
            }

            $request_data = $request->all();
            $request_data['uuid'] = Uuid::generate(4)->string;
            Genre::create($request_data);
            return response()->json(['code' => 200, 'message' => 'Successfully saved.']);
        } catch (\Exception $e) {
            Log::error('[Genre] error ' . $e->getMessage());
            return response()->json(['code' => 403, 'message' => 'Something went wrong']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            Log::info('- [Genre] show genre...');
            $genre = Genre::where('uuid', $id)->first();
            return response()->json(['genre' => $genre]);
        } catch (\Exception $e) {
            Log::error('[Genre] error ' . $e->getMessage());
            return response()->json(['code' => 403, 'message' => 'Something went wrong']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        try {
            Log::info('- [Genre] update genre...');
             //*validate fields
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'status' => 'required|boolean',
            ]);

            if ($validator->fails()) {
                //!Validator fails
                return response()->json(['code' => 400, 'message' => $validator->errors()]);
            }
            $genre = Genre::where('uuid', $id)->first();
            $genre->update($request->all());
            return response()->json(['code' => 200, 'message' => 'successfully updated!']);
        } catch (\Exception $e) {
            Log::error('[Genre] error ' . $e->getMessage());
            return response()->json(['code' => 403, 'message' => 'Something went wrong']);
        }
    }
}
