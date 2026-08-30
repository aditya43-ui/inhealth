<?php
    $this->breadcrumbs=array(
        'Informasi Rekonsiliasi Obat',
    );

    Yii::app()->clientScript->registerScript('search', "
    $('#rekonsiliasiobat-info-search').submit(function(){
            $('#rekonsiliasiobat-info-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('rekonsiliasiobat-info-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Informasi <b>Rekonsiliasi Obat</b></div>
    </div>
    <div class="panel-body">
      <div class="panel panel-success">
          <div class="panel-heading">
              <div class="panel-title">Tabel <b>Riwayat Rekonsiliasi Obat</b></div>
          </div>
          <div class="panel-body table-responsive">
            <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                'id'=>'rekonsiliasiobat-info-grid',
                'dataProvider'=>$model->searchInformasi(),
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-bordered table-striped table-condensed',
                'columns'=>array(
                    array(
                        'header'=>'No.',
                        'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
                    ),
                    array(
                        'header'=>'Tanggal Pendaftaran /<br/>No. Pendaftaran',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/ <br/>".$data->no_pendaftaran',
                    ),
                    array(
                        'header'=>'No Rekam Medik',
                        'type'=>'raw',
                        'value'=>'$data->no_rekam_medik',
                    ),

                    array(
                        'header'=>'Nama Pasien',
                        'type'=>'raw',
                        'value'=>'$data->nama_pasien',
                    ),
                    array(
                        'header'=>'Status Periksa',
                        'type'=>'raw',
                        'value'=>'Params::getWrStatusPeriksa($data->statusperiksa)',
                        'htmlOptions'=>array('style'=>'text-align: center;'),
                    ),
                    array(
                        'header'=>'Obat Alergi',
                        'type'=>'raw',
                        'value'=>function($data){

                          return CHtml::Link("<i class='icon-form-detail'></i>",Yii::app()->controller->createUrl("riwayatRekonsiliasi",array("pendaftaran_id"=>$data->pendaftaran_id,"typetransaksi"=>'obatalergi')),
                                       array("class"=>"",
                                             "target"=>"iframeObatAlergi",
                                             "onclick"=>"$('#dialogObatAlergi').dialog('open');",
                                             "rel"=>"tooltip",
                                             "title"=>"Klik untuk Melihat Riwayat Obat Alergi",
                                       ));
                        },
                        'htmlOptions'=>array('style'=>'text-align: center;'),
                    ),
                    array(
                        'header'=>'Obat Sebelum Admisi',
                        'type'=>'raw',
                        'value'=>function($data){
                          return CHtml::Link("<i class='icon-form-detail'></i>",Yii::app()->controller->createUrl("riwayatRekonsiliasi",array("pendaftaran_id"=>$data->pendaftaran_id,"typetransaksi"=>'obatsebelumadmisi')),
                                       array("class"=>"",
                                             "target"=>"iframeObatSebelumAdmisi",
                                             "onclick"=>"$('#dialogObatSebelumAdmisi').dialog('open');",
                                             "rel"=>"tooltip",
                                             "title"=>"Klik untuk Melihat Riwayat Obat Sebulum Admisi",
                                       ));
                        },
                        'htmlOptions'=>array('style'=>'text-align: center;'),
                    ),
                    array(
                        'header'=>'Obat Saat Transfer',
                        'type'=>'raw',
                        'value'=>function($data){
                          return CHtml::Link("<i class='icon-form-detail'></i>",Yii::app()->controller->createUrl("riwayatRekonsiliasi",array("pendaftaran_id"=>$data->pendaftaran_id,"typetransaksi"=>'obatsaattransfer')),
                                       array("class"=>"",
                                             "target"=>"iframeObatSaatTransfer",
                                             "onclick"=>"$('#dialogObatSaatTransfer').dialog('open');",
                                             "rel"=>"tooltip",
                                             "title"=>"Klik untuk Melihat Riwayat Obat Saat Transfer",
                                       ));
                        },
                        'htmlOptions'=>array('style'=>'text-align: center;'),
                    ),
                    array(
                        'header'=>'Obat saat Discharge',
                        'type'=>'raw',
                        'value'=>function($data){
                          return CHtml::Link("<i class='icon-form-detail'></i>",Yii::app()->controller->createUrl("riwayatRekonsiliasi",array("pendaftaran_id"=>$data->pendaftaran_id,"typetransaksi"=>'obatsaatdischarge')),
                                       array("class"=>"",
                                             "target"=>"iframeObatSaatDischarge",
                                             "onclick"=>"$('#dialogObatSaatDischarge').dialog('open');",
                                             "rel"=>"tooltip",
                                             "title"=>"Klik untuk Melihat Riwayat Obat Saat Discharge",
                                       ));
                        },
                        'htmlOptions'=>array('style'=>'text-align: center;'),
                    ),
                    array(
                        'header'=>'Kelola',
                        'type'=>'raw',
                        'value'=>function($data){
                          return CHtml::Link("<i class='entypo-pencil' style='font-size: 14pt'></i>",Yii::app()->controller->createUrl("RekonsiliasiObatFA/indexTabulasi",array("pendaftaran_id"=>$data->pendaftaran_id)),
                               array("class"=>"",
                                     "rel"=>"tooltip",
                                     "title"=>"Klik untuk Transaksi Kelola",
                               ));
                        },
                        'htmlOptions'=>array('style'=>'text-align: center;'),
                    ),
                    array(
                        'header'=>'Cetak',
                        'type'=>'raw',
                        'value'=>function($data){
                          $this->widget('bootstrap.widgets.BootButtonGroup', array(
                              'type'=>'primary',
                              'buttons'=>array(
                                  array('label'=>'Print', 'icon'=>'entypo-print', 'url'=>'javascript:void(0)', 'htmlOptions'=>array('onclick'=>'print(\'PRINT\','.$data->pendaftaran_id.')')),
                                  array('label'=>'', 'items'=>array(
                                      array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>'javascript:void(0)', 'itemOptions'=>array('onclick'=>'print(\'PDF\','.$data->pendaftaran_id.')')),
                                      array('label'=>'Excel','icon'=>'icon-pdf', 'url'=>'javascript:void(0)', 'itemOptions'=>array('onclick'=>'print(\'EXCEL\','.$data->pendaftaran_id.')')),

                                  )),
                              ),
                              // 'htmlOptions'=>array('style'=>'float:right')
                          ));
                        },
                        'htmlOptions'=>array('style'=>'text-align: center; width: 150px !important'),
                    ),
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            )); ?>
          </div>
      </div>
      <?php echo $this->renderPartial($this->path_view.'_search',array('model'=>$model)); ?>
    </div>
</div>
<?php
// Dialog untuk rencana kontrol =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'dialogObatAlergi',
	'options'=>array(
		'title'=>'Riwayat Obat Alergi',
		'autoOpen'=>false,
		'modal'=>true,
		'minWidth'=>900,
		'minHeight'=>100,
		'resizable'=>true,
	),
));
?>
<iframe src="" name="iframeObatAlergi" width="100%" height="500" style="border: none;"></iframe>
<?php
$this->endWidget();
?>

<?php
// Dialog untuk rencana kontrol =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'dialogObatSebelumAdmisi',
	'options'=>array(
		'title'=>'Riwayat Obat Sebelum Admisi',
		'autoOpen'=>false,
		'modal'=>true,
		'minWidth'=>1000,
		'minHeight'=>100,
		'resizable'=>true,
	),
));
?>
<iframe src="" name="iframeObatSebelumAdmisi" width="100%" height="500" style="border: none;"></iframe>
<?php $this->endWidget(); ?>

<?php
// Dialog untuk rencana kontrol =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'dialogObatSaatTransfer',
	'options'=>array(
		'title'=>'Riwayat Obat Saat Transfer',
		'autoOpen'=>false,
		'modal'=>true,
		'minWidth'=>1000,
		'minHeight'=>100,
		'resizable'=>true,
	),
));
?>
<iframe src="" name="iframeObatSaatTransfer" width="100%" height="500" style="border: none;"></iframe>
<?php $this->endWidget(); ?>

<?php
// Dialog untuk rencana kontrol =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'dialogObatSaatDischarge',
	'options'=>array(
		'title'=>'Riwayat Obat Saat Discharger',
		'autoOpen'=>false,
		'modal'=>true,
		'minWidth'=>1000,
		'minHeight'=>100,
		'resizable'=>true,
	),
));
?>
<iframe src="" name="iframeObatSaatDischarge" width="100%" height="500" style="border: none;"></iframe>
<?php $this->endWidget(); ?>

<script type="text/javascript">
  function print(caraPrint, pendaftaran_id)
  {
      window.open('<?php echo $this->createUrl('print'); ?>&pendaftaran_id='+pendaftaran_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=793,height=1122,scrollbars=yes');
  }
</script>
