<?php
echo "

            <style>
                .border th, .border td{
                    border:1px solid #000;
                }
                .table thead:first-child{
                    border-top:1px solid #000;        
                }

                thead th{
                    background:none;
                    color:#333;
                }

                .border {
                    box-shadow:none;
                    border-spacing: 0;
                    padding: 0;
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>";
$itemCssClass='table border';
?>
<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'periode' => $periode, 'colspan' => 16));
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF') {
    ?>

    <table style="width: 100%; border: none;">
        <thead>
            <tr>
                <td>
                    <div class="header"><?php
                        if ($caraPrint != 'EXCEL') {
                            echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => $periode));
                        }
                        ?></div>  
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="content">
  			<?php
                 		if ($model->jenisdiklat_id == Params::JENIS_DIKLAT_EKSTERNAL){
			$this->renderPartial($this->path_view.'rencanaDiklat._tableEksternal', array('model'=>$model, 'caraPrint'=>$caraPrint)); 
		}elseif ($model->jenisdiklat_id == Params::JENIS_DIKLAT_INTERNAL){
			$this->renderPartial($this->path_view.'rencanaDiklat._tableInternal', array('model'=>$model, 'caraPrint'=>$caraPrint, 'modInternal'=>$model)); 
		}
                        ?>

                    </div>		
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td>
                    <div class="footer-space">&nbsp;</div>
                </td>
            </tr>
        </tfoot>
    </table>
    <div class="">
    </div>
    <div class="footer">
        <?php if (isset($caraPrint) && $caraPrint != "PDF") { ?>
            <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
        <?php } ?>
    </div>   

    <?php
}
if ($caraPrint == 'PDF') {
    ?>
    <div class="header">
        <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => $periode)); ?>
    </div>
    <div class="content">
  <?php
              	if ($model->jenisdiklat_id == Params::JENIS_DIKLAT_EKSTERNAL){
			$this->renderPartial($this->path_view.'rencanaDiklat._tableEksternal', array('model'=>$model, 'caraPrint'=>$caraPrint)); 
		}elseif ($model->jenisdiklat_id == Params::JENIS_DIKLAT_INTERNAL){
			$this->renderPartial($this->path_view.'rencanaDiklat._tableInternal', array('model'=>$model, 'caraPrint'=>$caraPrint, 'modInternal'=>$model)); 
		}
                        ?>
    </div>

    <?php
}
if ($caraPrint == 'GRAFIK') {
    ?>
    <table style="width: 100%; border: none;">
        <thead>
            <tr>
                <td>
                    <div class="header">  <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => $periode)); ?></div>  
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="content">

                        <?php echo $this->renderPartial($this->path_view.'_grafik', array('model'=>$model, 'data'=>$data, 'caraPrint'=>$caraPrint), true); ?>
                        
                    </div>		
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td>
                    <div class="footer-space">&nbsp;</div>
                </td>
            </tr>
        </tfoot>
    </table>
    <div class="">
    </div>
    <div class="footer">
        <?php if (isset($caraPrint) && $caraPrint != "PDF") {
           echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); 
            ?>
         
        <?php } ?>
    </div>

    <?php
}
?>