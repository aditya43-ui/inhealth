<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF'){
    
    
?>

 <table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                        <br>
			<div class="judulcontent"> <?php echo $judulLaporan   ?> <br></div>
                        <br>
                <?php  $table = 'ext.bootstrap.widgets.BootGroupGridView';
if($caraPrint=='EXCEL')
{
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
//echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>3));      

$this->widget($table,array(
	'id'=>'rjkelasruangan-m-grid',
	'dataProvider'=>$model->searchTabel(),
	'filter'=>$model,
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//                'extraRowColumns' => array('ruangan.ruangan_nama'),
                'mergeColumns' => array('ruangan.ruangan_nama'),
	'columns'=>array(
                    array(
                        'name'=>'ruangan.ruangan_nama',
                        'header'=>'Nama Ruangan',
                        'value'=>'$data->ruangan->ruangan_nama',
                    ),
                    array(
                        'header'=>'Nama Kelas',
                        'value'=>'$data->kelaspelayanan->kelaspelayanan_nama',
                        'htmlOptions'=>array(
                            'style'=>'border-left:1px solid #DDDDDD',
                        ),
                    ),
                    array(
                        'header'=>'Nama Lainnya',
                        'value'=>'$data->kelaspelayanan->kelaspelayanan_namalainnya',
                    ),
        ),
    )); ?>
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
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  }  ?>
</div>   

<?php
}
if ($caraPrint == 'PDF'){
?>
<div class="header">
<?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
</div>
<div class="content">
     <br>
    <div class="judulcontent"> <?php echo $judulLaporan   ?> <br></div>
     <br>
<?php $table = 'ext.bootstrap.widgets.BootGroupGridView';
if($caraPrint=='EXCEL')
{
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
//echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>3));      

$this->widget($table,array(
	'id'=>'rjkelasruangan-m-grid',
	'dataProvider'=>$model->searchTabel(),
	'filter'=>$model,
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//                'extraRowColumns' => array('ruangan.ruangan_nama'),
                'mergeColumns' => array('ruangan.ruangan_nama'),
	'columns'=>array(
                    array(
                        'name'=>'ruangan.ruangan_nama',
                        'header'=>'Nama Ruangan',
                        'value'=>'$data->ruangan->ruangan_nama',
                    ),
                    array(
                        'header'=>'Nama Kelas',
                        'value'=>'$data->kelaspelayanan->kelaspelayanan_nama',
                        'htmlOptions'=>array(
                            'style'=>'border-left:1px solid #DDDDDD',
                        ),
                    ),
                    array(
                        'header'=>'Nama Lainnya',
                        'value'=>'$data->kelaspelayanan->kelaspelayanan_namalainnya',
                    ),
        ),
    )); ?>
</div>

<?php
}
if ($caraPrint == 'GRAFIK'){
 ?>
<table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                        <br>
			<div class="judulcontent"> <?php echo $judulLaporan   ?> <br></div>
                        <br>
                        <?php $table = 'ext.bootstrap.widgets.BootGroupGridView';
if($caraPrint=='EXCEL')
{
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
//echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>3));      

$this->widget($table,array(
	'id'=>'rjkelasruangan-m-grid',
	'dataProvider'=>$model->searchTabel(),
	'filter'=>$model,
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//                'extraRowColumns' => array('ruangan.ruangan_nama'),
                'mergeColumns' => array('ruangan.ruangan_nama'),
	'columns'=>array(
                    array(
                        'name'=>'ruangan.ruangan_nama',
                        'header'=>'Nama Ruangan',
                        'value'=>'$data->ruangan->ruangan_nama',
                    ),
                    array(
                        'header'=>'Nama Kelas',
                        'value'=>'$data->kelaspelayanan->kelaspelayanan_nama',
                        'htmlOptions'=>array(
                            'style'=>'border-left:1px solid #DDDDDD',
                        ),
                    ),
                    array(
                        'header'=>'Nama Lainnya',
                        'value'=>'$data->kelaspelayanan->kelaspelayanan_namalainnya',
                    ),
        ),
    )); ?>
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
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  }  ?>
</div>
  
<?php
}
?>