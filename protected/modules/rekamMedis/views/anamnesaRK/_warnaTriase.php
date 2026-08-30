<?php echo $this->widget('ext.colorpicker.ColorPicker', 
    array(
        'name'=>'Dokumen[warna_triase][]',
        'value'=>RKTriase::model()->getKodeWarnaId($triase_id),// string hexa decimal contoh 000000 atau 0000ff
        'height'=>'30px', // tinggi
        'width'=>'83px',        
        'disable'=>true,
        //'swatch'=>true, // default false jika ingin swatch
        'colors'=>  RKTriase::model()->getKodeWarna(), //warna dalam bentuk array contoh array('0000ff','00ff00')
        'colorOptions'=>array(
            'transparency'=> true,
           ),
        ),true
    ); 
?>

