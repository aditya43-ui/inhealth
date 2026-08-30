<div style="overflow-x: auto;">
    <?php
    $modList = new FormtransferpasienT();
    $modList->unsetAttributes();
    $modList->pendaftaran_id = $model->pendaftaran_id;
    $modList->create_ruangan_id = Yii::app()->user->getState("ruangan_id");
    $prov = $modList->search();
    $prov->sort->defaultOrder = "tanggal_transfer ASC";

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
                'header'=>'Tanggal Transfer',
                'type'=>'raw',
                'value'=>'MyFormatter::formatDateTimeForUser($data->tanggal_transfer)',
            ),
              array(
                'header'=>'Waktu Transfer',
                'type'=>'raw',
                'value'=>'$data->waktu_transfer',
            ),
             array(
                'header'=>'Dokter Pengirim',
                'type'=>'raw',
                'value'=>'$data->dokterpengirim->namaLengkap',
            ),
             array(
                'header'=>'Detail',
                'type'=>'raw',
                'value'=>function($data) {
                    return CHtml::link(
                        '<icon class="fa fa-file" style="font-size:14pt"></icon>', Yii::app()->createUrl("/rawatDarurat/LembarTransfer/detail", array("pendaftaran_id"=>$data->pendaftaran_id,"formtransferpasien_id"=>$data->formtransferpasien_id,"frame"=>true)), 
                        array(
                            "target"=>"iframeDetailRiwayatLembar",
                            "onclick"=>"$('#dialogDetailRiwayatLembar').dialog('open');",
                            "rel"=>"tooltip",
                            "title"=>"Klik untuk Melihat Detail Lembar Transfer 1",

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
                    return CHtml::link('<i  class="entypo-pencil" style="font-size:14pt"></i>', Yii::app()->controller->createUrl('index', array(
                        'pendaftaran_id'=>$data->pendaftaran_id,
                        'formtransferpasien_id'=>$data->formtransferpasien_id,
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
//                        return CHtml::link('<i class="entypo-trash"></i>', '#', array(
//                            'onclick'=>'hapusObservasi('.$data->observasipasienigd_id.','.$data->pendaftaran_id.'); return false'
//                        ));
                    return CHtml::link('<i class="entypo-trash" style="font-size:14pt"></i>', 'javascript:void(0)',array('onclick'=>'myAlert("Tidak Berfungsi")'));
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
</div>

<?php
    // Dialog untuk tindak lanjut pasien ke RI=========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogDetailRiwayatLembar',
        'options' => array(
            'title' => 'Detail Lembar Transfer 1',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 1000,
            'height' => 700,
            'resizable' => true
        ),
    ));
    ?>
    <iframe name='iframeDetailRiwayatLembar' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>
