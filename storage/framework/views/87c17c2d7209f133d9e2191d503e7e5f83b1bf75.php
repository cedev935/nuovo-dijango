
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
<div class="mb-2 radiogroup w-100" data-required="<?php if($question->required=="1"): ?> 1 <?php else: ?> 0 <?php endif; ?>">
 
  <?php if($content != ''): ?>
  <div 
    class="col radio_content w-100 p-0"
    style="justify-content: <?php echo e(data_get($question, 'answer_aligment', 'left')); ?>;"
  >
    <?php
      foreach($content as $key => $c){
        if(isset($c->col)) $col = $c->col;
        if(isset($c->display)) $display = $c->display;
      }
    ?>
    <?php $__currentLoopData = $content; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php if(isset($c->label)): ?>
      <label for="radio-<?php echo e($question->id); ?>-<?php echo e($key+1); ?>" class="radio-box" style='--active-color: <?php echo e($question->color1); ?> !important; --inactive-color: <?php echo e($question->color2); ?> !important;'>
        <input 
          class="form-check-input <?php echo e(' radio_'.$key); ?>" 
          type="radio" 
          name="radiogroup" 
          id="radio-<?php echo e($question->id); ?>-<?php echo e($key+1); ?>" 
          data-key="<?php echo e($key+1); ?>" 
          data-qid="<?php echo e($question->id); ?>" 
          value="<?php echo e($c->score); ?>" 
          data-score="<?php echo e($c->score); ?>"
        />
        <div class="form-check form-check-inline" >
          <label class="form-check-label" for="radio-<?php echo e($question->id); ?>-<?php echo e($key+1); ?>"><?php echo e($c->label); ?></label>
        </div>
      </label>
      <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>
    <div class="message mt-2">
    </div>
  <?php endif; ?>
</div>
<script>
  $("#q_<?php echo $question->id ?> input[type='radio']").css("accent-color", `<?php echo $question->color1 == NULL ? $question->color1 : $question->color1 ?>`);
  $("body").append(`<style>#q_<?php echo $question->id ?> label{<?php echo 'font-size:'.$firstFontSize.';font-style:'.$firstStyle.';font-family:'.$firstFamily.';' ?>}</style>`);
</script><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/frontend/components/questions/radiogroup.blade.php ENDPATH**/ ?>