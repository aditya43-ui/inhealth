<?php 
if($_GET['filter_tab'] == 'pemeriksaan'){
    $this->renderPartial('laboratorium.views.laporan.pemeriksaanCaraBayar/_tablePemeriksaanCaraBayar', array('model'=>$model,'modelPerusahaan'=>$modelPerusahaan, 'caraPrint'=>$caraPrint));
}else if ($_GET['filter_tab'] == 'rincian'){
    $this->renderPartial('laboratorium.views.laporan.pemeriksaanCaraBayar/_tableRincianCaraBayar', array('model'=>$model,'modelPerusahaan'=>$modelPerusahaan, 'caraPrint'=>$caraPrint)); 
}
?>