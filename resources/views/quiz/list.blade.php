@extends('layouts.app2')

@section('content')

<div class="container">
  <h2>Quizzes List</h2>
  <p></p>            
  <table class="table">
    <thead>
      <tr>
        <th>Quiz Name</th>
        <th>Quiz Link</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach($quizzes as $quiz)
      <tr>
        <td>{{$quiz->name}}</td>
        <td><a href="/quiz/{{$quiz->slug}}">Click</a></td>
        <td><a href="/set-question/{{$quiz->id}}" > Set Qustions </a></td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection