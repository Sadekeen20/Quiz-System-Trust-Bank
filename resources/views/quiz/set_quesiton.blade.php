@extends('layouts.app2')

@section('content')

<div class="container" >
  <h2>Create New Quiz</h2>
  <form action="/set-question/{{$id}}" method="post" id="quesitons">
    @csrf
    <div class="form-group">
      <label for="quiz0" >Quesitons:</label>
      <input type="text" class="form-control" id="ques0" placeholder="Enter question" name="ques0">
      <div class="row">
        <div class="col-sm-3">
          <input type="text" class="form-control" id="ques0" placeholder="Option 1" name="op10"></div>
        <div class="col-sm-3">
          <input type="text" class="form-control" id="ques0" placeholder="Option 2" name="op20"></div>
        <div class="col-sm-3">
          <input type="text" class="form-control" id="ques0" placeholder="Option 3" name="op30"></div>
        <div class="col-sm-3">
          <input type="text" class="form-control" id="ques0" placeholder="Option 4" name="op40"></div>
      </div>
        <input type="number" class="form-control" id="answer0" placeholder="Correct Answer" name="ans0">
        <input type="button" class="btn btn-default remove" value="Remove this field"/>
    </div>
    <input type="button" class="btn btn-default" value="Add a field" class="add" id="add" />
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
</div>

</body>
<script>
var id = 1;
$(document).ready(function() {
    if(id >= 100)
    {
      alert('Only 100 Questions allowed');
    } 
    else
    { 
      $("#add").click(function() {
        var html = '<div class="form-group">'+
          '<label for="quiz0">Quesitons</label>'+
          '<input type="text" class="form-control" id="ques'+id+'" placeholder="Enter question" name="ques'+id+'"><div class="row">'+
          '<div class="col-sm-3"><input type="text" class="form-control" id="ques'+id+'" placeholder="Option 1" name="op1'+id+'"></div>'+
          '<div class="col-sm-3"><input type="text" class="form-control" id="ques'+id+'" placeholder="Option 2" name="op2'+id+'"></div>'+
          '<div class="col-sm-3"><input type="text" class="form-control" id="ques'+id+'" placeholder="Option 3" name="op3'+id+'"></div>'+
          '<div class="col-sm-3"><input type="text" class="form-control" id="ques'+id+'" placeholder="Option 4" name="op4'+id+'"></div></div>'+
          '<input type="number" class="form-control" id="answer'+id+'" placeholder="Correct Answer" name="ans'+id+'">'+
          '<input type="button" class="remove btn btn-default" value="Remove this field"/>'+
        '</div>';
        $('#quesitons').prepend(html);
        id++;
      });
    }
});


$(document).on('click' , '.remove' , function() {
    console.log('Here');
      $(this).parent().remove();
});
</script>

@endsection