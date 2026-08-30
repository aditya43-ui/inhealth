<link rel="stylesheet" href="css/printoutrsiaks-normal.css">



<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
if ($caraPrint != 'EXCEL') {
    if ($caraPrint == 'PRINT') {
        ?>
        <style>
            
              @page {
                padding:0;
                margin: 0cm 1cm 0cm 2cm;
                
            }
        </style>
        <?php

        echo $this->renderPartial('application.views.headerReport._kopHeader');
        ?>
        
        <?php $this->renderPartial($this->path_view.'_tableEvaluasi', array('model' => $model, 'modPasien' => $modPasien, 'modDetail' => $modDetail, 'caraPrint' => $caraPrint)); ?></div>
                 
           

        <?php
        
    } else {
       echo $this->renderPartial('application.views.headerReport._kopHeader');
    }
} else {
   echo $this->renderPartial('application.views.headerReport._kopHeader');
}
?>

<?php
if ($caraPrint == 'PDF') {
    $this->renderPartial($this->path_view.'_tableEvaluasi', array('model' => $model, 'modPasien' => $modPasien, 'modDetail' => $modDetail, 'caraPrint' => $caraPrint));
}
if ($caraPrint == 'EXCEL') {
    $this->renderPartial($this->path_view.'_tableEvaluasi', array('model' => $model, 'modPasien' => $modPasien, 'modDetail' => $modDetail, 'caraPrint' => $caraPrint));
    ?>
    
    <?php
}

