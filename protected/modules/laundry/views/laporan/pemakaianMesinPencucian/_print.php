<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan'=>$judulLaporan,'periode'=>$periode,'colspan'=>6));

echo $this->renderPartial($this->path_view.'_tabel',['model'=>$model,'caraPrint'=>$caraPrint]);
?>