<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Answer;
use App\Vote;

class AnswerController extends Controller
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
    public function create($question)
    {
        $answer = new Answer;
        $edit = FALSE;
        return view('answerForm', ['answer' => $answer,'edit' => $edit, 'question' =>$question  ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $question)
    {
        $input = $request->validate([
            'body' => 'required|min:5',
        ], [
            'body.required' => 'Body is required',
            'body.min' => 'Body must be at least 5 characters',
        ]);
        $input = request()->all();
        $question = Question::find($question);
        $Answer = new Answer($input);
        $Answer->user()->associate(Auth::user());
        $Answer->question()->associate($question);
        $Answer->save();
        return redirect()->route('question.show',['question_id' => $question->id])->with('message', 'Saved');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($question,  $answer)
    {
        $answer = Answer::find($answer);
        return view('answer')->with(['answer' => $answer, 'question' => $question]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($question,  $answer)
    {
        $answer = Answer::find($answer);
        $edit = TRUE;
        return view('answerForm', ['answer' => $answer, 'edit' => $edit, 'question'=>$question ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $question, $answer)
    {
        $input = $request->validate([
            'body' => 'required|min:5',
        ], [
            'body.required' => 'Body is required',
            'body.min' => 'Body must be at least 5 characters',
        ]);

        $answer = Answer::find($answer);
        $answer->body = $request->body;
        $answer->save();
        return redirect()->route('answers.show',['question_id' => $question, 'answer_id' => $answer])->with('message', 'Updated');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($question, $answer)
    {
        $answer = Answer::find($answer);
        $answer->delete();
        return redirect()->route('question.show',['question_id' => $question])->with('message', 'Delete');
    }


    public function VoteAnswer(Request $request)
    {
        $answer_id = $request['answerId'];
        $is_vote = $request['isVote'] === 'true';
        $update = false;
        $answer = Answer::find($answer_id);
        if (!$answer) {
            return null;
        }
        $user = Auth::user();
        $vote = $user->votes()->where('answer_id', $answer_id)->first();
        if ($vote) {
            $vote_up = $vote->vote;
            $update = true;
            if ($vote_up == $is_vote) {
                $vote->delete();
                return null;
            }
        } else {
            $vote = new Vote();
        }
        $vote->vote = $is_vote;
        $vote->user_id = $user->id;
        $vote->answer_id = $answer->id;
        if ($update) {
            $vote->update();
        } else {
            $vote->save();
        }
        return null;
    }

}