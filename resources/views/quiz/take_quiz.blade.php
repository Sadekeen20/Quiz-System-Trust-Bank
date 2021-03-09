@extends('layouts.app')

@section('content')


<script>
// Set the date we're counting down to
var countDownDate = new Date().getTime() + parseInt('{{$time}}');

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  document.getElementById("demo").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "EXPIRED";
  }
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  $.ajax({
         type:'POST',
         url:'/ajax/send-time',
         data:{distance : distance},
    });
}, 1000);
</script>
  <div class="container " style="padding: 10px">
    <div class="row">
      <div class="col-sm-6">
       <div class="card" style="align-items: middle">
        
        <div class="container" style="margin-left:55px ;margin-top: 10px">
        </div>
        <form style="margin: 10px;">
              <select name="cars" class="custom-select">
                <option selected>Custom Select Menu</option>
                <?php $i = 1; ?>
                @foreach($all as $al)
                <a href="take-quiz/?page="{{$i++}}><option value="volvo">{{$i - 1}}{{". "}}{{$al->question_description}}</option></a>
                @endforeach
              </select>
            </form>
        <div class="card-body">
          <input type="hidden" id="question" value="{{$Question[0]->id}}">
          <p style="border-style: solid;border-color:  #f2f2f2;padding:5px;border-radius: 10px"><b>{{$Question[0]->question_description}}</b></p>
          <?php $val = "false"; ?>
          @foreach($Options as $answer)
          <div class="custom-control custom-radio" style="margin: 7px">
            @if(!$check->isEmpty())
              @if($check[0]->answer == $answer->id)
            <input type="radio" class="custom-control-input" id="customRadio{{$answer->id}}" name="answer" value="{{$answer->id}}" checked>
              @endif
            <?php $val = "true"; ?>
            @else
            <input type="radio" class="custom-control-input" id="customRadio{{$answer->id}}" name="answer" value="{{$answer->id}}">
            @endif
            <label class="custom-control-label" for="customRadio{{$answer->id}}" >{{$answer->possible_answer}}</label>
          </div>
          @endforeach 
          @if($val == "false")
            <button type="button" class="btn btn-success"style="width: 48.8%" id="answer">Answer</button>
            <button type="button" id="mark" class="btn btn-info"style="width: 50%; background-color: #cce6ff; color: rgb(0,0,0); border-color: #67c5ff">Mark</button>
          @endif
        </div>
      </div>
    </div>
        <div class="col-sm-6">
        <div class="card" style="text-align: center;">
          <p id="demo" style="color:  #333399"></p>
            <div id="div1" class="fa"></div>
             
            <script>
            function hourglass() {
              var a;
              a = document.getElementById("div1");
              a.innerHTML = "&#xf251;";
              setTimeout(function () {
                  a.innerHTML = "&#xf252;";
                }, 1000);
              setTimeout(function () {
                  a.innerHTML = "&#xf253;";
                }, 2000);
            }
            hourglass();
            setInterval(hourglass, 3000);
            </script>

          <div class="card-body" >
     {{$Question->links('quiz.buttons' , ["Quiz"  => $Quiz])}} 
   <!-- sadekeen // var correct;var total_question;      -->
    <div class="container" style="margin-bottom: 20px; margin-top: 10px">
      <div class="progress">
        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="{{$prog}}" aria-valuemin="0" aria-valuemax="100" style="width:{{$prog}}%">{{$prog}}%</div>
      </div>
    </div>

          <a href="/showResult"><button type="button" class="btn btn-danger" style="width: 100%">End Quiz</button></a>
          </div>
        </div>
      </div>
  </div>
</div>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#answer").click(function(e){
        e.preventDefault(); 
        var now = new Date().getTime();
        var answer = $("input[name=answer]").val();
        var question = $("#question").val();
        var current = {{$Question->currentPage()}};
        var quiz_id = {{$Quiz[0]->id}};
        var data = {answer:answer, question:question , current:current , distance:countDownDate - now , quiz_id:quiz_id};
        console.log(data);
        $.ajax({
           type:'POST',
           url:'/ajax/send-answer',
           data:data,
           success:function(data){
            if({{$Question->lastPage()}} != {{$Question->currentPage()}})
            {
              location.replace("{{$Question->url($Question->currentPage()+1)}}");
            }
           }
      });
    });

    $("#mark").click(function(e){
        e.preventDefault(); 
        var now = new Date().getTime();
        var answer = '0';
        var question = $("#question").val();
        var current = {{$Question->currentPage()}};
        var quiz_id = {{$Quiz[0]->id}};
        var data = {answer:answer, question:question , current:current , distance:countDownDate - now , quiz_id:quiz_id};
        console.log(data);
        $.ajax({
           type:'POST',
           url:'/ajax/send-answer',
           data:data,
           success:function(data){
            if({{$Question->lastPage()}} != {{$Question->currentPage()}})
            {
              location.replace("{{$Question->url($Question->currentPage()+1)}}");
            }
           }
      });
    });
</script>
@endsection