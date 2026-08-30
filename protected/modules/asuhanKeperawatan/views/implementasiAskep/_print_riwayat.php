<link rel="stylesheet" href="css/printoutrsiaks-normal.css">

<?php
echo $this->renderPartial('application.views.headerReport._kopHeader',['judulLaporan'=>$judulLaporan]);

echo "<div class='judul-rincian'>".$judulLaporan."</div>";

echo $this->renderPartial($this->path_view.'_identitas',['rencana'=>$rencana,'model'=>$model, 'pasien'=>$pasien], true);

echo "<div class='judul-rincian bordertop borderbot'>Implementasi</div>";

echo $this->renderPartial($this->path_view.'_riwayatImplementasi',['model'=>$model, 'caraPrint'=>$caraPrint], true);

?>