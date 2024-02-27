<?php echo html_entity_decode($question->content);?> 
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
<script>
	
	var sval=""
	if(<?php echo strpos($question->content, '<thead id="symbol_matrix_value') == true ? 1:0; ?>)
	{
		sval=$("#symbol_matrix_value").text();
		$("table[data-id='<?php echo $question->id ?>'] #symbol_matrix_value").remove();
		$("table[data-id=<?php echo $question->id ?>]").before(`<p id='symbol_matrix_value'>${sval}</p>`);
	}

	$("table[data-id=<?php echo $question->id ?>] thead tr").css({"background":`<?php echo $question->color2 == NULL ? $question->color2 : $question->color2 ?>`})
	// $("table[data-id=<?php echo $question->id ?>] tbody tr").css({"background":`<?php echo $question->color2 == NULL ? $question->color2 == NULL ? $question->color2 : $question->color2 : $question->color2 ?>`})
	$("table[data-id=<?php echo $question->id ?>] tbody tr").eq(0).css({"background":`<?php echo $question->color2 == NULL ? $question->color2 : $question->color2 ?>`})

	$("table[data-id=<?php echo $question->id ?>] tr th label").css({"text-align":"center"});
	$("table[data-id=<?php echo $question->id ?>] tr th label").css({"font-weight":"bold"});
	$("table[data-id=<?php echo $question->id ?>] tr th label").css({"color": "<?php echo e($question->color1); ?>"});
	$("table[data-id=<?php echo $question->id ?>] tr td label").css({"text-align":"center"});
	$("table[data-id=<?php echo $question->id ?>] tr td label").css({"font-weight":"bold"});
	$("table[data-id=<?php echo $question->id ?>] tr td label").css({"color": "<?php echo e($question->color2); ?>"});
	$("#q_<?php echo $question->id ?> table tr td:nth-child(2)").css("text-align", "left");
	
	$("#q_<?php echo $question->id ?> table input[type='radio']").css("accent-color", `<?php echo $question->color2 == NULL ? $question->color2 : $question->color2 ?>`);
	$("head").append(`<style>#q_<?php echo $question->id ?> table label font-size:<?php echo e($firstFontSize); ?> !important;font-style:<?php echo e($firstStyle); ?>;font-family:<?php echo e($firstFamily); ?>;
	 		#q_<?php echo $question->id ?> table{<?php echo $firstStyle ?>}
	 		#q_<?php echo $question->id ?> table tbody tr:first-child label font-size:<?php echo e($firstFontSize); ?> !important;
	 		#symbol_matrix_value{<?php echo $firstStyle ?> color: <?php echo e($question->color1); ?>}
	 		#q_<?php echo $question->id ?> table input[type='text']{<?php echo $firstStyle ?>}
	 		#q_<?php echo $question->id ?> table input[type='text']{text-align:center;}
	 		#q_<?php echo $question->id ?> table input[type='text']{border-color:<?php echo $question->color2 ?>;}
	 		
	 		#q_<?php echo $question->id ?> table tr:nth-child(even){background:white;}
	 		#q_<?php echo $question->id ?> table tr:nth-child(odd){background:<?php echo e($question->color2); ?>;}

	 		#q_<?php echo $question->id ?> table tr th label{border:1px solid <?php echo $question->color2 == NULL ? $question->color2 : $question->color2 ?>;}
	 		#q_<?php echo $question->id ?> table tr th label{font-size: <?php echo $firstFontSize  ?>!important;}
	 		#q_<?php echo $question->id ?> table tr td label{font-size: <?php echo $firstFontSize  ?>!important;}
	 		#q_<?php echo $question->id ?> table tr th{border:1px solid <?php echo $question->color2 == NULL ? $question->color2 : $question->color2 ?> !important;}
	 		#q_<?php echo $question->id ?> table tr td{border:1px solid <?php echo $question->color2 == NULL ? $question->color2 : $question->color2 ?> !important;}
	 	</style>`)
	//$("table[data-id=<?php echo $question->id ?>] input[type='text']").css({"background":`<?php echo $question->color2 == NULL ? $question->color2 == NULL ? $question->color2 : $question->color2 : $question->color2 ?>`})
	
</script><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/frontend/components/questions/matrix.blade.php ENDPATH**/ ?>