<?php

echo $this->renderPartial('_header', array(), true);

$str = Yii::app()->user->getState('nama_rumahsakit')." Menyatakan bahwa : <br/><br/>";
$str .= "Dokumen dengan judul : ".$model->nama_file."<br/><br/>";
$str .= "No. Seri : ".$model->no_seri."<br/><br/>";
$str .= "Telah ditandatangani oleh Pihak Rumah Sakit sebagai Berikut :<br/>";
$str .= "<strong>";
$str .= $detail->verifikasi_sebagai." - ".$detail->nama_pegawai." - ".$detail->user_agent." ";
$str .= "pada ".MyFormatter::formatDateTimeForUser($model->create_time)." ";
$str .= "No. SK Direktur Izin Tanda Tangan Elektronik : ".$detail->nomor_sk."<br/><br/>";
$str .= "</strong>";
$str .= "Benar dan tercatat dalam audit trail kami.";

echo $str;


?>