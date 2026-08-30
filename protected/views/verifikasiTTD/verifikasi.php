<?php

echo $this->renderPartial('_header', array(), true);


$str = Yii::app()->user->getState('nama_rumahsakit')." Menyatakan bahwa : <br/><br/>";
$str .= "Dokumen dengan judul : ".$model->nama_file."<br/><br/>";
$str .= "No. Seri : ".$model->no_seri."<br/><br/>";
$str .= "Telah ditandatangani oleh Pihak Rumah Sakit sebagai Berikut :<br/>";

$str .= "<strong>";

foreach($details as $detail) {
    $str .= $detail->verifikasi_sebagai." - ".$detail->nama_pegawai." - ".$detail->user_agent." ";
    $str .= "pada ".MyFormatter::formatDateTimeForUser($model->create_time)." ";
    $str .= "No. SK Direktur Izin Tanda Tangan Elektronik : ".$detail->nomor_sk."<br/>";
}

$str .= "</strong><br/>";
$str .= "Benar dan tercatat dalam audit trail kami serta pihak tersebut sudah tercantum pada SK Direktur masing-masing.";

echo $str;

?>
<br/>
<br/>
<div style="text-align: center">
<?php 
echo CHtml::link('Unduh Dokumen', $this->createUrl('unduh', array('id'=>$model->tandatangandigital_id)), array(
    'class'=>"btn btn-success",
)); 
?>

</div>