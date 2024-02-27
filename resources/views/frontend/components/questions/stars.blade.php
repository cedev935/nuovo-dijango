<div class='rating-stars stars_content' data-required="@if($question->required=="1") 1 @else 0 @endif">
    @php
        $len = 0;
        // $content = json_decode($question->content, true);
        
        if(filled($content)){
            foreach($content as $c){
                if(isset($c->label))
                $len++;
            }
        }
    @endphp

    <ul id='stars{{ $question->id }}'>
        @for($i = 0; $i < $len; $i++)
            <li class='{{'star star-'.($i+1)}}' name="star" data-value='{{$i+1}}' style="color: {{ $question->color2 }};">
                <i class='fas fa-star fa-fw' style="font-size: 30px;"></i>
            </li>
        @endfor
    </ul>
    @php
        $i=1;
        $color = "#fff";
    @endphp
    @if(isset($content) && (is_array($content) || $content instanceof Countable))
    @foreach($content as $c)
        @if(isset($c->color))
            @php
                $color = $c->color;
            @endphp
        @endif
    @endforeach
    @endif
    <input type="hidden" name="star_color" class="star_color" value="{{$color}}">
    <input type="hidden" class="starinput" id="{{ $question->id }}" data-qid="{{ $question->id }}" value="0" data-selected="false">
    <span class="message mt-2"></span>
</div>