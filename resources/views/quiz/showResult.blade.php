@extends('layouts.app')

@section('content')

<div class="container" style="margin-top: 20px;">
<div class="dotted" align="center">
  <div class="jumbotron">

  <h3 style="margin-top: 10px;margin-bottom: 15px;">Well Done .
    Here is your result .</h3>

    <button type="button" class="btn btn-primary">
    Total Performed Question <span class="badge badge-light">{{$wrong+$mark+$correct_answer}}</span>
  </button>
    <button type="button" class="btn btn-secondary">
    Unmarked <span class="badge badge-light">{{$mark}}</span>
  </button>
    <button type="button" class="btn btn-success">
    Correct Answer <span class="badge badge-light">{{$correct_answer}}</span>
  </button>
  <button type="button" class="btn btn-danger">
     Percentage <span class="badge badge-light">{{($correct_answer*100)/($wrong+$mark+$correct_answer)}}%</span>
  </button>

</div>

<div id="piechart"></div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['Questions', 'Number'],
  ['Correct',{{$correct_answer}}],
  ['Wrong',{{$wrong}}],
  ['Unmarked',{{$mark}}]
]);

  // Optional; add a title and set the width and height of the chart
  var options = {'width':550, 'height':400};

  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
}
</script>

</div></div>
@endsection