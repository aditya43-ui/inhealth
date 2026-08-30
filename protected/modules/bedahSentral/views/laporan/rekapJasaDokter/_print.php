<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
      echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan'=>$judulLaporan,'periode'=>$periode,'colspan'=>3));
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF' && $caraPrint != 'PRINT'){
    
    
?>

 <table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                if($caraPrint != 'EXCEL'){
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan'=>$judulLaporan,'periode'=>$periode));
                } ?>
                <div class="judulcontent" style="text-align:center;"><?php echo $periode   ?></div>
                <br>
                </div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                       
     
  <?php 
$this->renderPartial('rekapJasaDokter/_tableRekapBaru', array('model'=>$model, 'caraPrint'=>$caraPrint,'tab' =>$tab)); 

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
    <?php   if (isset($caraPrint) && $caraPrint!="PDF"){  ?>
    <?php //echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  }  ?>
</div>   

<?php
}
if ($caraPrint == 'PDF' || $caraPrint == 'PRINT'){
?>
<div class="header">
<?php   echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan'=>$judulLaporan,'periode'=>$periode)); ?>
    <div class="judulcontent" style="text-align:center;"><?php echo $periode   ?></div>
     <br>
</div>
<div class="content">
   
 <?php 
$this->renderPartial('rekapJasaDokter/_tableRekapBaru', array('model'=>$model, 'caraPrint'=>$caraPrint,'tab' =>$tab)); 
?>
</div>

<?php
}
if ($caraPrint == 'GRAFIK'){
 ?>
<table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php   echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan'=>$judulLaporan,'periode'=>$periode)); ?>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                     
                      echo $this->renderPartial('_grafik', array('model'=>$model, 'data'=>$data, 'caraPrint'=>$caraPrint,'tab' =>$tab), true); 

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
    <?php   if (isset($caraPrint) && $caraPrint!="PDF"){  ?>
    <?php //echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  }  ?>
</div>
  
<?php
}
?>