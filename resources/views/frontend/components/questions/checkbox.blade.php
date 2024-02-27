<div class="mb-2">
    <div class="checkbox-input" data-required="@if($question->required=="1") 1 @else 0 @endif">
        @php
            $temp_val =1;
            $content = json_decode($question->content);

if ($content !== null) {
    foreach ($content as $key => $c) {
        if (isset($c->col)) {
            $col = $c->col;
        }
    }
}
if(isset($firstFontSize)){
    $firstFontSize = $firstFontSize;
}else{
    $firstFontSize = '';
}

if(isset($firstStyle)){
    $firstStyle = $firstStyle;
}else{
    $firstStyle = '';
}

if(isset($firstFamily)){
    $firstFamily = $firstFamily;
}else{
    $firstFamily = '';
}
            
        @endphp
        <div class="row p-0 check_content">
        @if ($content !== null)
            @foreach($content as $key => $c)
                @if(isset($c->label))
                <div class="p-0">
                    <div class="form-check p-0">
                        <div class="square-check checkbox gradient-bg" style='--active-color: {{ $question->color1 }} !important; --inactive-color: {{ $question->color2 }} !important;' >
                            <input class="form-check-input {{' checkbox_'.$key}}" name="checkbox-radio" type="checkbox" data-qid="{{$question->id}}" data-key="{{$key+1}}" value="{{$c->score}}" {{(isset($identy[$question->id]))?($identy[$question->id]==$c->score)?'data-opendiv='.$ids[$question->id]:'':''}} name="flexRadioDefault"  id="{{$question->id}}">
                            {{$c->label}}
                            <div class="square-check--content"></div>
                        </div>
                    </div>
                </div>
                @endif
                @php
                    $temp_val++;
                @endphp
            @endforeach
            @endif
        </div>
    </div>
    <span class="message mt-2"></span>
</div>