<?php
namespace App\Repositories;

use App\Question;

class QuestionRepository
{

    public function byIdWithTopic($id){
        // 使用 with 方法指定想要预载入的关联对象 预载入可以大大提高程序的性能
        // 这里的 topics 是App\Question 中的 topics 的方法
        return  Question::where('id',$id)->with('topics')->firstOrFail();
    }

    public function create(array $data){
        return Question::create($data);
    }
}