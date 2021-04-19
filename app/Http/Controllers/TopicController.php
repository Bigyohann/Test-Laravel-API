<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TopicController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return Topic[]|Collection|Response
     */
    public function index()
    {
        return $this->apiResponse('Data retrieved',Topic::all()->load('author'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Topic|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->errorApiReponse($validator->errors()->messages(), 400);
        }

        $fields = $request->request->all();



        $topic = new Topic($fields);

        if (!in_array("author", $fields)) {
           $topic->author_id = auth()->user()->id;
        }

        $topic->save();

        return $this->apiResponse('Topic created', $topic, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return $this->apiResponse('Single topic found',Topic::where('id', $id)->first()->load('author'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string',
            'body' => 'string',
        ]);


        if ($validator->fails()) {
            return $validator->errors()->messages();
        }
        $fields = $request->request->all();

        $topic = Topic::where('id', $id)->first();

        $topic->update($fields);
        $topic->save();

        return $this->apiResponse('Topic modified', $topic);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $topicToDelete = Topic::where('id', $id)->first();
        if (!$topicToDelete) {
            return $this->errorApiReponse('No record with this ID have been found', 404);
        }
        $topicToDelete->delete();

        return $this->apiResponse('Deleted');
    }
}
