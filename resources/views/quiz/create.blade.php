@extends('layouts.app2')

@section('content')

<div class="container">
  <h2>Create New Quiz</h2>
  <form action="/create-new-quiz" method="post" >
    @csrf
    <div class="form-group">
      <label for="quiz">Quiz Name:</label>
      <input type="text" class="form-control" id="quiz" placeholder="Enter quiz name" name="quiz">
    </div>
    <div class="form-group">
      <label for="quiz">Quiz Duration(Minutes):</label>
      <input type="number" class="form-control" id="quiz" placeholder="Enter a number" name="time">
    </div>
    <div class="form-group">
      <label for="quiz">Quiz Question Amount:</label>
      <input type="number" class="form-control" id="quiz" placeholder="Enter a number" name="question">
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
</div>

@endsection