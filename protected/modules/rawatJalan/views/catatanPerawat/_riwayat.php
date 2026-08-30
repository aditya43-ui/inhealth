<?php
$modList = new CatatanperawatT();
$modList->unsetAttributes();
$modList->pendaftaran_id = $modPendaftaran->pendaftaran_id;
$modList->create_ruangan =  Yii::app()->user->getState("ruangan_id");
$prov = $modList->searchRiwayat();


$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'observasi-grid',
    'dataProvider' => $prov,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
      array(
          'header'=>'No',
          'type'=>'raw',
          'value'=>'$row+1',
      ),
        array(
            'header'=>'Tanggal/ Jam',
            'type'=>'raw',
            'value'=>'MyFormatter::formatDateTimeForUser($data->tglobservasi)',
        ),
          array(
            'header'=>'Petugas Pemeriksaan',
            'type'=>'raw',
            'value'=>'$data->perawatmengetahui->namaLengkap',
        ),
        array(
            'header'=>'Catatan Perawat',
            'type'=>'raw',
            'value'=>function($data) {
                return CHtml::link(
                  '<icon class="icon-form-detail"></icon>', Yii::app()->controller->createUrl("detail", array("catatanperawat_id"=>$data->catatanperawat_id)),
                  array(
                      "target"=>"iframeDetail",
                      "onclick"=>"$('#dialogDetail').dialog('open');",
                      "rel"=>"tooltip",
                      "title"=>"Klik untuk Melihat Catatan Perawat",

                  ));
            },
            'htmlOptions'=>array(
                'style'=>'text-align: center;',
            )
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
    . '$(".custom-only").keyup(function(){setCustomOnly(this);});}',
));
?>

<?php
    // Dialog untuk tindak lanjut pasien ke RI=========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogDetail',
        'options' => array(
            'title' => 'Detail Catatan Perawat',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 1000,
            'height' => 500,
            'resizable' => true
        ),
    ));
    ?>
    <iframe name='iframeDetail' width="100%" height="90%"></iframe>
<?php $this->endWidget(); ?>
