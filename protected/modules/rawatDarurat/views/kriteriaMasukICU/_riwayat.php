<?php
$modList = new KriteriamasukicuT();
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
            'header'=>'Tanggal Pemeriksaan',
            'type'=>'raw',
            'value'=>'MyFormatter::formatDateTimeForUser($data->tanggal_pemeriksaan)',
        ),
          array(
            'header'=>'Petugas Pemeriksaan',
            'type'=>'raw',
            'value'=>'$data->petugas_pemeriksa',
        ),
        array(
          'header'=>'Petugas Pemeriksaan',
          'type'=>'raw',
          'value'=>function($data) {
              $ruangan = RuanganM::model()->findByPk($data->create_ruangan);
              return (!empty($ruangan)?$ruangan->ruangan_nama:"");
            }
      ),
        array(
            'header'=>'Detail',
            'type'=>'raw',
            'value'=>function($data) {
                return CHtml::link(
                  '<icon class="icon-form-detail"></icon>', Yii::app()->controller->createUrl("detail", array("kriteriamasukicu_id"=>$data->kriteriamasukicu_id)),
                  array(
                      "target"=>"iframeDetail",
                      "onclick"=>"$('#dialogDetail').dialog('open');",
                      "rel"=>"tooltip",
                      "title"=>"Klik untuk Melihat Detail Kriteria Masuk ICU",

                  ));
            },
            'htmlOptions'=>array(
                'style'=>'text-align: center;',
            )
        ),
        array(
            'header'=>'Ubah',
            'type'=>'raw',
            'value'=>function($data) {
                return CHtml::link('<i class="entypo-pencil" style="font-size: 14pt"></i>', Yii::app()->controller->createUrl('index', array(
                  'pendaftaran_id'=>$data->pendaftaran_id,
                    'kriteriamasukicu_id'=>$data->kriteriamasukicu_id,
                    'type'=>(!empty($_GET['type'])?$_GET['type']:""),
                    'frame'=>(!empty($_GET['frame'])?$_GET['frame']:"")
                )));
            },
            'htmlOptions'=>array(
                'style'=>'text-align: center;',
            )
        ),
        array(
            'header'=>'Hapus',
            'type'=>'raw',
            'value'=>function($data) {
                return CHtml::link('<i class="entypo-trash" style="font-size: 14pt"></i>', '#', array(
                    'onclick'=>'hapusRiwayat('.$data->kriteriamasukicu_id.'); return false'
                ));
            },
            'htmlOptions'=>array(
                'style'=>'text-align: center;',
            )
        ),
        array(
            'header'=>'Cetak',
            'type'=>'raw',
            'value'=>function($data) {
                return CHtml::link('<i class="entypo-print" style="font-size: 14pt"></i>', '#', array(
                    'onclick'=>'print('.$data->kriteriamasukicu_id.'); return false'
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
            'title' => 'Detail Kriteria Masuk ICU',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 1000,
            'height' => 700,
            'resizable' => true
        ),
    ));
    ?>
    <iframe name='iframeDetail' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>
