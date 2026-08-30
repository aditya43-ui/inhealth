<?php 
//echo $this->widget('ext.colorpicker.ColorPicker', 
//    array(
//        'name'=>'Dokumen[warnadokrm_id][]',
//        //'value'=>WarnadokrmM::model()->getKodeWarnaId($warnadokrm_id),// string hexa decimal contoh 000000 atau 0000ff
//        'height'=>'20px', // tinggi
//        'width'=>'83px',        
//        //'swatch'=>true, // default false jika ingin swatch
//        'colors'=>  WarnadokrmM::model()->getKodeWarna(), //warna dalam bentuk array contoh array('0000ff','00ff00')
//        'colorOptions'=>array(
//            'transparency'=> true,
//           ),
//        ),true
//    ); 

echo "<div class='control-group'>";
echo CHtml::dropDownList('Dokumen[warnadokrm_id][]','',CHtml::listData(WarnadokrmM::model()->findAll("warnadokrm_aktif = TRUE ORDER BY warnadokrm_namawarna ASC" ),'warnadokrm_id','warnadokrm_namawarna'),array('empty'=>'-- Pilih --','class' => 'form-control'));
echo "</div>";
//echo CHtml::dropDownList("Dokumen[warnadokrm_id][]","",CHtml::listData(WarnadokrmM::model()->findAll(), "warnadokrm_id", "warnadokrm_namawarna"),array("options" => array("'.Params::INSTALASI_ID_RJ.'"=>array("selected"=>true))));
?>

