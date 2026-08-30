
<?php   	
    if ($jam == 'selesai'){
	$this->widget('MyDateTimePicker',array(		                                        
		'name'=>"KPRencanaLemburT[detail][".$no."][jamSelesai]",		
		'mode'=>'time',							
		'options'=> array(
                        'showAnim' => '',
			'showOn' => false,			
			//'format' => 'H:i',			
		),
		'htmlOptions'=>array('class'=>'jam', 'style'=>'width: 100px;','readonly'=>TRUE,'placeholder'=>'00:00:00','onkeyup'=>"return $(this).focusNextInputField(event),"
		),
        ));
    }elseif($jam == 'mulai'){
        $this->widget('MyDateTimePicker',array(		                                        
		'name'=>"KPRencanaLemburT[detail][".$no."][jamMulai]",		
		'mode'=>'time',							
		'options'=> array(
                        'showAnim' => '',
			'showOn' => false,			
			//'format' => 'H:i',			
		),
		'htmlOptions'=>array('class'=>'jam', 'style'=>'width: 100px;','readonly'=>TRUE,'placeholder'=>'00:00:00','onkeyup'=>"return $(this).focusNextInputField(event),"
		),
        ));
    }

?>
                        