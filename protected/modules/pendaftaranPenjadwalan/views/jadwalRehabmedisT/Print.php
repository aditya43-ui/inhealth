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
                <?php  $this->widget('ext.bootstrap.widgets.BootGroupGridView',array(
	'id'=>'sajenis-kelas-m-grid',
    'enableSorting'=>false,
	'dataProvider'=>$model->searchPrintjadwalRH($totalData),
    'template'=>"{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'mergeColumns'=>array('jadwalrehabmedis_hari', 'jadwalrehabmedis_tgl_ke', 'shift_id'),
	'columns'=>array(
				array(
                       'header'=>'Hari',
						'name'=>'jadwalrehabmedis_hari',
                       'type'=>'raw',
                       'value'=>'$data->jadwalrehabmedis_hari',
                    ),    
				array(
                       'header'=>'Tanggal',
						'name'=>'jadwalrehabmedis_tgl_ke',
                       'type'=>'raw',
                       'value'=>'MyFormatter::formatDateTimeForUser($data->jadwalrehabmedis_tgl_ke)',
                    ),
				array(
                       'header'=>'Shift',
						'name'=>'shift_id',
                       'type'=>'raw',
                       'value'=>'$data->shift->shift_nama',
                    ),
                 array(
                       'header'=>'Ruangan',
						'name'=>'ruangan_id',
                       'type'=>'raw',
                       'value'=>'$data->getNamaRuangan()',
                    ),
				 array(
                       'header'=>'No R.M',
                       'type'=>'raw',
                       'value'=>'$data->pasienrl->no_rekam_medik',
                    ),
				array(
                       'header'=>'Nama Pasien',
                       'type'=>'raw',
                       'value'=>'$data->pasienrl->nama_pasien',
                    ),
				array(
                       'header'=>'Jenis Kelamin',
                       'type'=>'raw',
                       'value'=>'$data->pasienrl->jeniskelamin',
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
<?php $this->widget('ext.bootstrap.widgets.BootGroupGridView',array(
	'id'=>'sajenis-kelas-m-grid',
    'enableSorting'=>false,
	'dataProvider'=>$model->searchPrintjadwalRH($totalData),
    'template'=>"{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'mergeColumns'=>array('jadwalrehabmedis_hari', 'jadwalrehabmedis_tgl_ke', 'shift_id'),
	'columns'=>array(
				array(
                       'header'=>'Hari',
						'name'=>'jadwalrehabmedis_hari',
                       'type'=>'raw',
                       'value'=>'$data->jadwalrehabmedis_hari',
                    ),    
				array(
                       'header'=>'Tanggal',
						'name'=>'jadwalrehabmedis_tgl_ke',
                       'type'=>'raw',
                       'value'=>'MyFormatter::formatDateTimeForUser($data->jadwalrehabmedis_tgl_ke)',
                    ),
				array(
                       'header'=>'Shift',
						'name'=>'shift_id',
                       'type'=>'raw',
                       'value'=>'$data->shift->shift_nama',
                    ),
                 array(
                       'header'=>'Ruangan',
						'name'=>'ruangan_id',
                       'type'=>'raw',
                       'value'=>'$data->getNamaRuangan()',
                    ),
				 array(
                       'header'=>'No R.M',
                       'type'=>'raw',
                       'value'=>'$data->pasienrl->no_rekam_medik',
                    ),
				array(
                       'header'=>'Nama Pasien',
                       'type'=>'raw',
                       'value'=>'$data->pasienrl->nama_pasien',
                    ),
				array(
                       'header'=>'Jenis Kelamin',
                       'type'=>'raw',
                       'value'=>'$data->pasienrl->jeniskelamin',
                    ),

        ),
    ));?>
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
                        <?php  $this->widget('ext.bootstrap.widgets.BootGroupGridView',array(
	'id'=>'sajenis-kelas-m-grid',
    'enableSorting'=>false,
	'dataProvider'=>$model->searchPrintjadwalRH($totalData),
    'template'=>"{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'mergeColumns'=>array('jadwalrehabmedis_hari', 'jadwalrehabmedis_tgl_ke', 'shift_id'),
	'columns'=>array(
				array(
                       'header'=>'Hari',
						'name'=>'jadwalrehabmedis_hari',
                       'type'=>'raw',
                       'value'=>'$data->jadwalrehabmedis_hari',
                    ),    
				array(
                       'header'=>'Tanggal',
						'name'=>'jadwalrehabmedis_tgl_ke',
                       'type'=>'raw',
                       'value'=>'MyFormatter::formatDateTimeForUser($data->jadwalrehabmedis_tgl_ke)',
                    ),
				array(
                       'header'=>'Shift',
						'name'=>'shift_id',
                       'type'=>'raw',
                       'value'=>'$data->shift->shift_nama',
                    ),
                 array(
                       'header'=>'Ruangan',
						'name'=>'ruangan_id',
                       'type'=>'raw',
                       'value'=>'$data->getNamaRuangan()',
                    ),
				 array(
                       'header'=>'No R.M',
                       'type'=>'raw',
                       'value'=>'$data->pasienrl->no_rekam_medik',
                    ),
				array(
                       'header'=>'Nama Pasien',
                       'type'=>'raw',
                       'value'=>'$data->pasienrl->nama_pasien',
                    ),
				array(
                       'header'=>'Jenis Kelamin',
                       'type'=>'raw',
                       'value'=>'$data->pasienrl->jeniskelamin',
                    ),

        ),
    ));
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
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  }  ?>
</div>
  
<?php
}
?>