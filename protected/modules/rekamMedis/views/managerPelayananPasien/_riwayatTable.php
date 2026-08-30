<?php

$typeinstalasi = "";

if (isset($_GET['typeinstalasi'])) {
    $typeinstalasi = $_GET['typeinstalasi'];
}

$modPas = new PasienM();
$modPas->pasien_id = $modPendaftaran->pasien_id;
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id'=>'riwayataskep-grid',
	'dataProvider'=>$modPas->searchRiwayatPelayananPasien(),
                'template'=>"{summary}\n{items}\n{pager}",
                'replaceUrl'=>true,
                'itemsCssClass'=>'table table-bordered table-striped table-condensed',
	'columns'=>array(
                array(
                        'header'=>'Skrining Pasien',
                        'type'=>'raw',
                        'value'=>function($data) {
                          return CHtml::link(
                              '<icon class="icon-form-detail"></icon>', Yii::app()->createUrl("/rekamMedis/SkrinningT/Riwayat", array("pasien_id"=>$data->pasien_id,"frame"=>true)),
                              array(
                                  "target"=>"iframeDetailSkrining",
                                  "onclick"=>"$('#dialogDetailSkrining').dialog('open');",
                                  "rel"=>"tooltip",
                                  "title"=>"Klik untuk Melihat Skrining Pasien",

                              ));
                    },
                    'htmlOptions'=>array(
                        'style'=>'text-align: center;',
                    )
              ),
              array(
                      'header'=>'Evaluasi Awal',
                      'type'=>'raw',
                      'value'=>function($data) use ($typeinstalasi) {
                        return CHtml::link(
                            '<icon class="icon-form-detail"></icon>', Yii::app()->createUrl("/rekamMedis/EvaluasiAwal/Riwayat", array("pasien_id"=>$data->pasien_id,'typeinstalasi'=>$typeinstalasi, "frame"=>true)),
                            array(
                                "target"=>"iframeDetailEvaluasiAwal",
                                "onclick"=>"$('#dialogDetailEvaluasiAwal').dialog('open');",
                                "rel"=>"tooltip",
                                "title"=>"Klik untuk Melihat Evaluasi Awal",

                            ));
                  },
                  'htmlOptions'=>array(
                      'style'=>'text-align: center;',
                  )
            ),
            array(
                    'header'=>'Catatan Implementasi',
                    'type'=>'raw',
                    'value'=>function($data) use ($typeinstalasi) {
                      return CHtml::link(
                          '<icon class="icon-form-detail"></icon>', Yii::app()->createUrl("/rekamMedis/CatatanImplementasi/Riwayat", array("pasien_id"=>$data->pasien_id,'typeinstalasi'=>$typeinstalasi,"frame"=>true)),
                          array(
                              "target"=>"iframeDetailCatatan",
                              "onclick"=>"$('#dialogDetailCatatan').dialog('open');",
                              "rel"=>"tooltip",
                              "title"=>"Klik untuk Melihat Catatan Implementasi",

                          ));
                },
                'htmlOptions'=>array(
                    'style'=>'text-align: center;',
                )
          ),
            ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
?>
<?php
    // Dialog untuk tindak lanjut pasien ke RI=========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogDetailSkrining',
        'options' => array(
            'title' => 'Riwayat Skrining Pasien',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 800,
            'height' => 500,
            'resizable' => true
        ),
    ));
    ?>
    <iframe name='iframeDetailSkrining' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

<?php
    // Dialog untuk tindak lanjut pasien ke RI=========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogDetailEvaluasiAwal',
        'options' => array(
            'title' => 'Riwayat Evaluasi Awal',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 800,
            'height' => 500,
            'resizable' => true
        ),
    ));
    ?>
    <iframe name='iframeDetailEvaluasiAwal' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

<?php
    // Dialog untuk tindak lanjut pasien ke RI=========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogDetailCatatan',
        'options' => array(
            'title' => 'Riwayat Catatan Implementasi',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 800,
            'height' => 500,
            'resizable' => true
        ),
    ));
    ?>
    <iframe name='iframeDetailCatatan' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>
