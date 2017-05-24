<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Question;
use App\Topic;
use Illuminate\Http\Request;
use Auth;

class QuestionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',[
            'except' => ['index','show'] //排除这两个方法
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request)
    {
        $select2s = $request->select2;
        foreach ($select2s as $key => $item){
            if(!is_numeric($item)){
                $topic = Topic::create(['name' => $item]);
                $select2s[$key] = $topic->id;
            }
        }
        $data = [
            'title' => $request->title,
            'body'  => $request->body,
            'user_id' => Auth::id(),
        ];

        $question = Question::create($data);
        $question->topics()->sync($select2s,false); //向中间表添加关联
        return redirect()->route('questions.show',[$question]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::findOrFail($id);
        return view('questions.show',compact('question'));
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
        //
    }
}
