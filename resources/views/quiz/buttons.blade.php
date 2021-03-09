@if ($paginator->lastPage() > 1)
 <div class="row pagination" >
    @for ($i = 1; $i <= $Quiz[0]->question; $i++)
    <div class="col-lg-2">
        @if(session()->get("Answered".$i) == "yes")
        <a href="{{ $paginator->url($i) }}"><button type="button" class="btn2" style="width :100%;margin-bottom: 10px;"><b>{{$i}}</b></button></a>
        @elseif(session()->get("Marked".$i) == "yes")
        <a href="{{ $paginator->url($i) }}"><button type="button" class="btn1" style="width :100%;margin-bottom: 10px;"><b>{{$i}}</b></button></a>
        @else
        <a href="{{ $paginator->url($i) }}"><button type="button" class="btnX" style="width :100%;margin-bottom: 10px;"><b>{{$i}}</b></button></a>
        @endif
     </div>
    @endfor
</div>
@endif


