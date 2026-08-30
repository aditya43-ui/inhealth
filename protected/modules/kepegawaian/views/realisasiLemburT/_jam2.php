
<?php   
if (empty($value)) $value = "";
    echo '<div class="input-append">';
    if ($jam == 'selesai'){
   
        echo CHtml::textField("RealisasilemburT[detail][".$idx."][jamSelesai]", $value, array(
            'class'=>'jam jam_selesai', 
            'style'=>'width: 100px;',
            'readonly'=>TRUE,
            'placeholder'=>'00:00:00',
            'onkeyup'=>"return $(this).focusNextInputField(event),"
        ));
        
        echo '<span id="RealisasilemburT_detail_'.$idx.'_jamMulai_date" class="add-on">';
        echo '<i class="icon-time"></i>';
        echo '</span>';
        
        /*
	$this->widget('MyDateTimePicker',array(		                                        
		'name'=>"RealisasilemburT[detail][".$idx."][jamSelesai]",		
		'mode'=>'time',
        'value'=>$value,					
		'options'=> array(
			'showOn' => false,	
			//'format' => 'H:i',			
		),
        ));
         * 
         */
    }elseif($jam == 'mulai'){
        echo CHtml::textField("RealisasilemburT[detail][".$idx."][jamMulai]", $value, array(
            'class'=>'jam jam_mulai', 
            'style'=>'width: 100px;',
            'readonly'=>TRUE,
            'placeholder'=>'00:00:00',
            'onkeyup'=>"return $(this).focusNextInputField(event),"
        ));
        
        echo '<span id="RealisasilemburT_detail_'.$idx.'_jamMulai_date" class="add-on">';
        echo '<i class="icon-time"></i>';
        echo '</span>';
        /*
        $this->widget('MyDateTimePicker',array(		                                        
		'name'=>"RealisasilemburT[detail][".$idx."][jamMulai]",		
		'mode'=>'time',	
        'value'=>$value,						
		'options'=> array(
			'showOn' => false,		
			//'format' => 'H:i',			
		),
		'htmlOptions'=>array('class'=>'jam jam_mulai', 'style'=>'width: 100px;','readonly'=>TRUE,'placeholder'=>'00:00:00','onkeyup'=>"return $(this).focusNextInputField(event),"
		),
        ));
         * 
         */
    }
    
    echo '</div>';

?>
                        