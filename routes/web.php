<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/', function () {
    return view('home');
});

Route::get('/home', 'HomeController@index');

//Create a new Quiz
Route::get('/create-new-quiz' , 'QuizController@create_quiz');

//save a new quiz to database
Route::post('/create-new-quiz' , 'QuizController@save_quiz');

//See all the quizzes
Route::get('/see-all-quizzes' , 'QuizController@see_all');

//Set Qustion for a quiz
Route::get('/set-question/{id}' , 'QuizController@set_question');

//Send questions and answer to the server
Route::post('/set-question/{id}' , 'QuizController@save_question');

//Take quiz 
//Route::get('/take-quiz','QuizController@take_quiz');

//Quiz Individual Link
Route::get('quiz/{name}','QuizController@take_quiz' );

//Save the answers 
Route::post('/ajax/send-answer','QuizController@save_answers');
Route::post('/ajax/send-time','QuizController@save_time');

Route::get('/showResult','QuizController@showResult');