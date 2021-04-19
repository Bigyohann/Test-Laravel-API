<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
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
    public function index(): Response
    {
        return $this->apiResponse('Data retrieved',Topic::all()->load('author'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Topic|Application|ResponseFactory|Response
     */
    public function store(Request $request) : Response
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        // Sending error if validation failed
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
    public function show($id): Response
    {
        // Try catch for catch exception if no row is found, before call the load function
        try {
            $topic = Topic::where('id', $id)->firstOrFail()->load('author');
        }
        catch (\Exception $exception) {
            return $this->errorApiReponse('No row have been found with this', 404);
        }

        return $this->apiResponse('Single topic found',$topic);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id): Response
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string',
            'body' => 'string',
        ]);


        // Sending error if validation failed
        if ($validator->fails()) {
            return $this->errorApiReponse($validator->errors()->messages(), 400);
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
    public function destroy($id) :Response
    {
        $topicToDelete = Topic::where('id', $id)->first();

        // Sending error if row don't exist
        if (!$topicToDelete) {
            return $this->errorApiReponse('No record with this ID have been found', 404);
        }
        $topicToDelete->delete();

        return $this->apiResponse('Deleted');
    }
}
