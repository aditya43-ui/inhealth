<?php $this->widget('ext.colorpicker.ColorPicker', 
    array(
        'name'=>'Dokumen[warnadokrm_id][]',
        'value'=>WarnadokrmM::model()->getKodeWarnaId($warnadokrm_id),// string hexa decimal contoh 000000 atau 0000ff
        'height'=>'30px', // tinggi
        'width'=>'83px',    
        'htmlOptions'=>array(
            'onchange'=>'ubahWarna('.$dokrekammedis_id.', $(this).val())',
        ),
        // 'OnColorChange'=>'ubahWarna()',
        //'swatch'=>true, // default false jika ingin swatch
        'colors'=>  WarnadokrmM::model()->getKodeWarna(), //warna dalam bentuk array contoh array('0000ff','00ff00')
        'colorOptions'=>array(
            'transparency'=> true,
           ),
        )
    ); ?>

