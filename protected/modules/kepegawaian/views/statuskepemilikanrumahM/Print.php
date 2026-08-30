<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel',array('judulLaporan'=>$judulLaporan, 'colspan'=>3)); ?>
    <div class="header">
    <?php //echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
    </div>
    <div class="content">
    <?php
$table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->search();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->search();
         $template = "{summary}\n{items}\n{pager}";
    }
    
$this->widget($table, array(
	'id'=>'statuskepemilikanrumah-m-grid',
	'dataProvider'=>$data,
        'enableSorting'=>$sort,
        'template'=>$template,
	'filter'=>$model,
        'itemsCssClass'=>'table table-bordered table-striped table-condensed',
	'columns'=>array(
//		'statuskepemilikanrumah_id',
//		'statuskepemilikanrumah_nama',
//		'statuskepemilikanrumah_namalain',
                                array(
                                    'header'=>'ID',
                                    'value'=>'$data->statuskepemilikanrumah_id',
                                ),
                                array(
                                    'header'=>'Status Kepemilikan Rumah',
                                    'value'=>'$data->statuskepemilikanrumah_nama',
                                ),
                                array(
                                    'header'=>'Nama lainnya',
                                    'value'=>'$data->statuskepemilikanrumah_namalain',
                                ),
                                array(
                                    'header'=>'Aktif',
                                    'value'=>'(($data->statuskepemilikanrumah_aktif==1)? "Ya" : "Tidak")',
                                ),
//                                array(
//                                    'header'=>'Aktif',
//                                    'class'=>'CCheckBoxColumn',
//                                    'checked'=>'$data->statuskepemilikanrumah_aktif',
//                                ),
//		array(
//                                                'header'=>Yii::t('zii','View'),
//			'class'=>'CButtonColumn',
//                                                'template'=>'{view}',
//		),
//		array(
//                                                'header'=>Yii::t('zii','Update'),
//			'class'=>'CButtonColumn',
//                                                'template'=>'{update}',
//		),
//		array(
//                                                'header'=>'Hapus',
//			'class'=>'CButtonColumn',
//                                                'template'=>'{delete}',
//		),
	),
)); ?>
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
$table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->search();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->search();
         $template = "{summary}\n{items}\n{pager}";
    }
    
$this->widget($table, array(
	'id'=>'statuskepemilikanrumah-m-grid',
	'dataProvider'=>$data,
        'enableSorting'=>$sort,
        'template'=>$template,
	'filter'=>$model,
        'itemsCssClass'=>'table border',
	'columns'=>array(
//		'statuskepemilikanrumah_id',
//		'statuskepemilikanrumah_nama',
//		'statuskepemilikanrumah_namalain',
                                array(
                                    'header'=>'ID',
                                    'value'=>'$data->statuskepemilikanrumah_id',
                                ),
                                array(
                                    'header'=>'Status Kepemilikan Rumah',
                                    'value'=>'$data->statuskepemilikanrumah_nama',
                                ),
                                array(
                                    'header'=>'Nama lainnya',
                                    'value'=>'$data->statuskepemilikanrumah_namalain',
                                ),
                                array(
                                    'header'=>'Aktif',
                                    'value'=>'(($data->statuskepemilikanrumah_aktif==1)? "Ya" : "Tidak")',
                                ),
//                                array(
//                                    'header'=>'Aktif',
//                                    'class'=>'CCheckBoxColumn',
//                                    'checked'=>'$data->statuskepemilikanrumah_aktif',
//                                ),
//		array(
//                                                'header'=>Yii::t('zii','View'),
//			'class'=>'CButtonColumn',
//                                                'template'=>'{view}',
//		),
//		array(
//                                                'header'=>Yii::t('zii','Update'),
//			'class'=>'CButtonColumn',
//                                                'template'=>'{update}',
//		),
//		array(
//                                                'header'=>'Hapus',
//			'class'=>'CButtonColumn',
//                                                'template'=>'{delete}',
//		),
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
<?php //$this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => '')); ?>
</div>
<div class="content">
  <?php
$table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->search();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->search();
         $template = "{summary}\n{items}\n{pager}";
    }
    
$this->widget($table, array(
	'id'=>'statuskepemilikanrumah-m-grid',
	'dataProvider'=>$data,
        'enableSorting'=>$sort,
        'template'=>$template,
	'filter'=>$model,
        'itemsCssClass'=>'table border',
	'columns'=>array(
//		'statuskepemilikanrumah_id',
//		'statuskepemilikanrumah_nama',
//		'statuskepemilikanrumah_namalain',
                                array(
                                    'header'=>'ID',
                                    'value'=>'$data->statuskepemilikanrumah_id',
                                ),
                                array(
                                    'header'=>'Status Kepemilikan Rumah',
                                    'value'=>'$data->statuskepemilikanrumah_nama',
                                ),
                                array(
                                    'header'=>'Nama lainnya',
                                    'value'=>'$data->statuskepemilikanrumah_namalain',
                                ),
                                array(
                                    'header'=>'Aktif',
                                    'value'=>'(($data->statuskepemilikanrumah_aktif==1)? "Ya" : "Tidak")',
                                ),
//                                array(
//                                    'header'=>'Aktif',
//                                    'class'=>'CCheckBoxColumn',
//                                    'checked'=>'$data->statuskepemilikanrumah_aktif',
//                                ),
//		array(
//                                                'header'=>Yii::t('zii','View'),
//			'class'=>'CButtonColumn',
//                                                'template'=>'{view}',
//		),
//		array(
//                                                'header'=>Yii::t('zii','Update'),
//			'class'=>'CButtonColumn',
//                                                'template'=>'{update}',
//		),
//		array(
//                                                'header'=>'Hapus',
//			'class'=>'CButtonColumn',
//                                                'template'=>'{delete}',
//		),
	),
)); ?>
</div>

<?php
}

 ?>