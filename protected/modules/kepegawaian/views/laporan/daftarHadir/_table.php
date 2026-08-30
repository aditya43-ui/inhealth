<?php
  $table = 'ext.bootstrap.widgets.BootGridView';
if (isset($caraPrint)){
  $data = $model->searchPrint();
  $template = '{items}';
  if ($caraPrint=='EXCEL') {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
} else{
  $data = $model->searchTableLaporan();
  $template = "{summary}{pager}\n{items}";
}
?>
<?php if(isset($caraPrint)){ ?>

<?php }else{ ?>
<div style='max-width:1000px;overflow-y: scroll;'>
<?php } ?>

<?php $this->widget($table,array(
	'id'=>'PPInfoKunjungan-v',
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
             array(
              'header'=>'Waktu Kehadiran',
              'type'=>'raw',
              'value'=>'MyFormatter::formatDateTimeForUser($data->tglkehadiran)',
            ),
            array(
              'header'=>'Nama Peserta',
              'type'=>'raw',
              'value'=>'$data->namapeserta',
            ),
            array(
              'header'=>'Jenis Kelamin',
              'type'=>'raw',
              'value'=>'$data->jeniskelamin',
            ),
            array(
              'header'=>'Keterlambatan',
              'type'=>'raw',
              'value'=>'$data->terlambat_menit',
            ),   
            array(
              'header'=>'Nama Pelatihan',
              'type'=>'raw',
              'value'=>'$data->namapelatihan',
            ),
            array(
              'header'=>'Jenis Pelatihan',
              'type'=>'raw',
              'value'=>'$data->jenispelatihan',
            ),
            array(
              'header'=>'Ruangan',
              'type'=>'raw',
              'value'=>'$data->ruangan_nama',
            ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
<?php if(isset($caraPrint)){ ?>

<?php }else{ ?>
</div>
<?php } ?>