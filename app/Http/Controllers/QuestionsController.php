<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Question;
use App\Repositories\QuestionRepository;
use App\Topic;
use Illuminate\Http\Request;
use Auth;

class QuestionsController extends Controller
{
    protected $qusetionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->middleware('auth',[
            'except' => ['index','show'] //排除这两个方法
        ]);

        $this->qusetionRepository = $questionRepository;
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
        $select2s = $this->normalizeTopic($request->select2);
        $data = [
            'title' => $request->title,
            'body'  => $request->body,
            'user_id' => Auth::id(),
        ];

        $question = $this->qusetionRepository->create($data);
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
        $question = $this->qusetionRepository->byIdWithTopic($id);
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

    /**
     *  过滤包含有数字和文本的数组，全部变成数字
     * @param array $topics
     * @return array $newTopics
     */
    public function normalizeTopic(array $topics)
    {
        $newTopics = collect($topics)->map(function ($topic) {
            if (is_numeric($topic)) {
                Topic::findOrFail($topic)->increment('questions_count'); //自增
                return (int)$topic;
            }
            $newTopic =  Topic::create([
                'name' => $topic,
                'questions_count' => 1
            ]);
            return $newTopic->id;
        });
        return $newTopics->toArray();
    }
}
