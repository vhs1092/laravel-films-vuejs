<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Auth;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->user =  Auth::user();
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
     * Store a newly created comment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $film_id)
    {
        try {
        
            //*validate fields
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'comment' => 'required',
            ]);

            if ($validator->fails()) {
                //!Validator fails
                return response()->json(['code' => 400, 'message' => $validator->errors()]);
            }

            Comment::create(array(
            'name' => $request->get('name'),
            'comment' => $request->get('comment'),
            'film_id' => $request->get('film_id'),
            'user_id' => $this->user->id
        ));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Comment::destroy($id);
        return Response::json(array('success' => true));
    }
}
