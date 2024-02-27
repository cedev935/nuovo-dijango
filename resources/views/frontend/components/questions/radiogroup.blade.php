
<style>

input[type='radio']:not(:checked) {
    border-color: red !important; /* change this to the color you want */
}
</style>
<?php
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
?>
<div class="mb-2 radiogroup w-100" data-required="@if($question->required=="1") 1 @else 0 @endif">
 
  @if($content != '')
  <div 
    class="col radio_content w-100 p-0"
    style="justify-content: {{ data_get($question, 'answer_aligment', 'left') }};"
  >
    @php
      foreach($content as $key => $c){
        if(isset($c->col)) $col = $c->col;
        if(isset($c->display)) $display = $c->display;
      }
    @endphp
    @foreach($content as $key=>$c)
      @if(isset($c->label))
      <label for="radio-{{$question->id}}-{{$key+1}}" class="radio-box" style='--active-color: {{ $question->color1 }} !important; --inactive-color: {{ $question->color2 }} !important;'>
        <input 
          class="form-check-input {{' radio_'.$key}}" 
          type="radio" 
          name="radiogroup" 
          id="radio-{{$question->id}}-{{$key+1}}" 
          data-key="{{$key+1}}" 
          data-qid="{{$question->id}}" 
          value="{{$c->score}}" 
          data-score="{{$c->score}}"
        />
        <div class="form-check form-check-inline" >
          <label class="form-check-label" for="radio-{{$question->id}}-{{$key+1}}">{{$c->label}}</label>
        </div>
      </label>
      @endif
    @endforeach
  </div>
    <div class="message mt-2">
    </div>
  @endif
</div>
<script>
  $("#q_<?php echo $question->id ?> input[type='radio']").css("accent-color", `<?php echo $question->color1 == NULL ? $question->color1 : $question->color1 ?>`);
  $("body").append(`<style>#q_<?php echo $question->id ?> label{<?php echo 'font-size:'.$firstFontSize.';font-style:'.$firstStyle.';font-family:'.$firstFamily.';' ?>}</style>`);
</script>