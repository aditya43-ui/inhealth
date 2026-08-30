<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel',array('judulLaporan'=>$judulLaporan, 'colspan'=>4)); ?>
    <div class="header">
    <?php //echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
    </div>
    <div class="content">
  <?php
$template = "{items}";
$table = 'ext.bootstrap.widgets.BootGridView';
$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint2(),
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			'header'=>'No.',
			'value' => '($this->grid->dataProvider->pagination) ? 
					($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
					: ($row+1)',
			'type'=>'raw',
			'htmlOptions'=>array('style'=>'text-align:right;'),
		),
		array(
			'header'=>'Ruangan',
			'name'=>'ruangan_id',
			'value'=>'$data->ruangan->ruangan_nama',
			'type'=>'raw',
			'filter'=>CHtml::activeTextField($model,'ruangan_nama'),
		),
		array(
			'header'=>'Shiift',
			'name'=>'shift_id',
			'value'=>'$data->shift->shift_nama',
			'type'=>'raw',
			'filter'=>CHtml::activeTextField($model,'shift_nama'),
		),
		array(
			'header'=>'Jumlah Formasi (Orang)',
			'name'=>'jmlformasi',
			'value'=>'$data->jmlformasi',
			'type'=>'raw',
		),
            array(
                                'header' => 'Status',
                                'value' => '($data->formasishift_aktif)?"Aktif":"Tidak Aktif"',
                            ),
		/*
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		'formasishift_aktif',
		*/

	),
)); 
?>
    </div>
    
<?php } 
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF' && $caraPrint != 'EXCEL'){
    
    
?>

 <table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => ''));
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
              <?php
$template = "{items}";
$table = 'ext.bootstrap.widgets.BootGridView';
$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint2(),
	'template'=>$template,
	'itemsCssClass'=>'table border',
	'columns'=>array(
		array(
			'header'=>'No.',
			'value' => '($this->grid->dataProvider->pagination) ? 
					($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
					: ($row+1)',
			'type'=>'raw',
			'htmlOptions'=>array('style'=>'text-align:right;'),
		),
		array(
			'header'=>'Ruangan',
			'name'=>'ruangan_id',
			'value'=>'$data->ruangan->ruangan_nama',
			'type'=>'raw',
			'filter'=>CHtml::activeTextField($model,'ruangan_nama'),
		),
		array(
			'header'=>'Shiift',
			'name'=>'shift_id',
			'value'=>'$data->shift->shift_nama',
			'type'=>'raw',
			'filter'=>CHtml::activeTextField($model,'shift_nama'),
		),
		array(
			'header'=>'Jumlah Formasi (Orang)',
			'name'=>'jmlformasi',
			'value'=>'$data->jmlformasi',
			'type'=>'raw',
		),
            array(
                                'header' => 'Status',
                                'value' => '($data->formasishift_aktif)?"Aktif":"Tidak Aktif"',
                            ),
		/*
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		'formasishift_aktif',
		*/

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
if ($caraPrint == 'PDF'){
?>
<div class="header">
<?php //$this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => '')); ?>
</div>
<div class="content">
 <?php
$template = "{items}";
$table = 'ext.bootstrap.widgets.BootGridView';
$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint2(),
	'template'=>$template,
	'itemsCssClass'=>'table border',
	'columns'=>array(
		array(
			'header'=>'No.',
			'value' => '($this->grid->dataProvider->pagination) ? 
					($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
					: ($row+1)',
			'type'=>'raw',
			'htmlOptions'=>array('style'=>'text-align:right;'),
		),
		array(
			'header'=>'Ruangan',
			'name'=>'ruangan_id',
			'value'=>'$data->ruangan->ruangan_nama',
			'type'=>'raw',
			'filter'=>CHtml::activeTextField($model,'ruangan_nama'),
		),
		array(
			'header'=>'Shiift',
			'name'=>'shift_id',
			'value'=>'$data->shift->shift_nama',
			'type'=>'raw',
			'filter'=>CHtml::activeTextField($model,'shift_nama'),
		),
		array(
			'header'=>'Jumlah Formasi (Orang)',
			'name'=>'jmlformasi',
			'value'=>'$data->jmlformasi',
			'type'=>'raw',
		),
            array(
                                'header' => 'Status',
                                'value' => '($data->formasishift_aktif)?"Aktif":"Tidak Aktif"',
                            ),
		/*
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		'formasishift_aktif',
		*/

	),
)); 
?>
</div>

<?php
}

 ?>