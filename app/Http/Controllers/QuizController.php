<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuizController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth');
    }

    public function all_links(Request $request)
    {
        return view('quiz.all_links');
    }

    public function create_quiz()
    {
    	return view('quiz.create');
    }

    public function save_quiz(Request $request)
    {
    	$slug = strtolower($request->quiz);
    	$slug = str_replace(" ", "-", $slug);
        $slug = $slug.rand(1000,9999);
    	$insert = new \App\Quiz;
    	$insert->name = $request->quiz;
    	$insert->slug = $slug;
        $insert->time = $request->time;
        $insert->question = $request->question;
    	$insert->save();
    	return redirect('/set-question/'.$insert->id);
    }

    public function see_all()
    {
    	$fetch = \App\Quiz::all();
    	return view('quiz.list' , ["quizzes" => $fetch]);
    }

    public function set_question($id)
    {
    	return view('quiz.set_quesiton' , ["id" => $id]);
    }

    public function save_question(Request $request , $id)
    {
    	for($i = 0 ; $i < 100 ; $i++)
    	{
    		if(empty(request("ques".$i)))
    			continue;
    		
    		$insertq = new \App\Question;
    		$insertq->quiz_id = $id;
    		$insertq->question_description = request("ques".$i);
    		$insertq->correct_answer = request("ans".$i);
    		$insertq->save();

    		$insert2 = new \App\AllAnswer;
    		$insert2->question_id = $insertq->id;
    		$insert2->possible_answer = request("op1".$i);
    		$insert2->save();

    		$insert2 = new \App\AllAnswer;
    		$insert2->question_id = $insertq->id;
    		$insert2->possible_answer = request("op2".$i);
    		$insert2->save();

    		$insert2 = new \App\AllAnswer;
    		$insert2->question_id = $insertq->id;
    		$insert2->possible_answer = request("op3".$i);
    		$insert2->save();

    		$insert2 = new \App\AllAnswer;
    		$insert2->question_id = $insertq->id;
    		$insert2->possible_answer = request("op4".$i);
    		$insert2->save();
    	}
    	return redirect('/set-question/'.$id);
    }

    public function take_quiz(Request $request , $name)
    {
        $Quiz = \App\Quiz::where('slug' , $name)->get();
    	$question = \App\Question::where('quiz_id' , $Quiz[0]->id)->inRandomOrder(auth()->user()->id)->paginate(1);
        if(session()->has('time'))
        {
            $time_left = session()->get('time');    
        }
        else
        {
            $check = \App\QuizAnswerProfile::where('quiz_id' , $Quiz[0]->id)->latest()->first();
            if(empty($check))
                $time_left = $Quiz[0]->time * 1000 * 60;
            else
            {
                $time_left = $check->time_left;
                $check = \App\QuizAnswerProfile::where('quiz_id' , $Quiz[0]->id)->get();
                foreach ($check as $c) {
                    if($c->answer != 0)
                        session()->put('Answered'.$c->question_number , 'yes');
                    else
                        session()->put('Marked'.$c->question_number , 'yes');
                }
            }
        }
        $question_all = \App\Question::where('quiz_id' , $Quiz[0]->id)->inRandomOrder(auth()->user()->id)->limit($Quiz[0]->question)->get();
    	$answers = \App\Question::find($question[0]->id)->options;
    	$check = \App\QuizAnswerProfile::where('question_id' , $question[0]->id)->get();
        $answerCount = \App\QuizAnswerProfile::where('quiz_id' , $Quiz[0]->id)->count();
        $prog = intval(($answerCount / $Quiz[0]->question ) * 100);
    	return view('quiz.take_quiz' , ["Quiz" => $Quiz , "Question" => $question , "Options" => $answers , 'time' => $time_left , "check" => $check , "all" => $question_all , "prog" => $prog]);
    }

    public function save_answers(Request $request)
    {	
    	$user = auth()->user();
    	$newAns = new \App\QuizAnswerProfile;
    	$newAns->user_id = $user->id;
    	$newAns->question_id = $request->question;
    	$newAns->answer = $request->answer;
    	$newAns->time_left = $request->distance;
        $newAns->quiz_id = $request->quiz_id;
        $newAns->question_number = $request->current;
    	$newAns->save();
    	session()->put('time' , $request->distance);
    	if($request->answer != 0)
    		session()->put('Answered'.$request->current , 'yes');
    	else
    		session()->put('Marked'.$request->current , 'yes');
    	return response()->json(["status" => "Success"]); 	
    }

    public function save_time(Request $request)
    {	
    	session()->put('time' , $request->distance);
    	return response()->json(["status" => "Success"]); 	
    }

    public function showResult(Request $request)
    {
    	session()->flush();
    	$allAnswer = \App\QuizAnswerProfile::where('user_id',auth()->user()->id)->get();
    	$correct_answer = 0;
    	$wrong = 0;
    	$mark = 0;
    	foreach($allAnswer as $answer)
    	{
    		if($answer->answer == 0)
    		{
    			$mark++;
    			continue;
    		}
    		$question_op = \App\Question::find($answer->question_id)->options;
    		$question = \App\Question::find($answer->question_id);
    		if($question->correct_answer == 1 && $question_op[0]->id == $answer->answer)
    			$correct_answer++;
    		else if($question->correct_answer == 2 && $question_op[1]->id == $answer->answer)
    			$correct_answer++;
    		else if($question->correct_answer == 3 && $question_op[2]->id == $answer->answer)
    			$correct_answer++;
    		else if($question->correct_answer == 4 && $question_op[3]->id == $answer->answer)
    			$correct_answer++;
    	}
        $total = \App\Quiz::find($allAnswer[0]->quiz_id)->get();
        $wrong = $total[0]->question - $correct_answer;
    	$allAnswer = \App\QuizAnswerProfile::where('user_id',auth()->user()->id)->delete();
    	return view('quiz.showResult' , ["mark" => $mark , "correct_answer" => $correct_answer , "wrong" => $wrong]);
    }
}
