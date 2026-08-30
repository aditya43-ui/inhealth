
<?php   
if (empty($value)) $value = "";

    if ($jam == 'selesai'){
	$this->widget('MyDateTimePicker',array(		                                        
		'name'=>"RealisasilemburdetT[detail][".$idx."][jamSelesai]",		
		'mode'=>'time',
        'value'=>$value,					
		'options'=> array(
			'showOn' => false,	
			//'format' => 'H:i',			
		),
		'htmlOptions'=>array(
            'class'=>'jam jam_selesai', 
            'style'=>'width: 100px;',
            'readonly'=>TRUE,
            'placeholder'=>'00:00:00',
            'onkeyup'=>"return $(this).focusNextInputField(event),",
            'onchange'=>'hitungJam(this);'
		),
        ));
    }elseif($jam == 'mulai'){
        $this->widget('MyDateTimePicker',array(		                                        
		'name'=>"RealisasilemburdetT[detail][".$idx."][jamMulai]",		
		'mode'=>'time',	
        'value'=>$value,						
		'options'=> array(
			'showOn' => false,		
			//'format' => 'H:i',			
		),
		'htmlOptions'=>array(
            'class'=>'jam jam_mulai', 
            'style'=>'width: 100px;',
            'readonly'=>TRUE,
            'placeholder'=>'00:00:00',
            'onkeyup'=>"return $(this).focusNextInputField(event),",
            'onchange'=>'hitungJam(this);'
		),
        ));
    }

?>
                        