<div style="overflow-x: auto;">
    <?php
    $modList = new ProsestransferpasienT();
    $modList->unsetAttributes();
    $modList->formtransferpasien_id = $model->formtransferpasien_id;
    $modList->create_ruangan_id = Yii::app()->user->getState("ruangan_id");
    $prov = $modList->search();
    $prov->sort->defaultOrder = "sebelumtransfer_tanggal ASC";

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'riwayatprosestransfer-grid',
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
                'header'=>'Tanggal & Jam',
                'type'=>'raw',
                'value'=>'MyFormatter::formatDateTimeForUser($data->sebelumtransfer_tanggal)',
            ),
              array(
                'header'=>'Derajat Pasien',
                'type'=>'raw',
                'value'=>'$data->derajatpasien',
            ),
             array(
                'header'=>'Petugas yang mengirimkan pasien',
                'type'=>'raw',
                'value'=>'(isset($data->sebelumtransferpegawaiygmenyerahkan)? $data->sebelumtransferpegawaiygmenyerahkan->namaLengkap : "")',
            ),
             array(
                'header'=>'Detail',
                'type'=>'raw',
                'value'=>function($data) {
                    return CHtml::link(
                        '<icon  class="fa fa-file" style="font-size:14pt"></icon>', Yii::app()->createUrl("/rawatDarurat/TransferKondisiPasien/detail", array("prosestransferpasien_id"=>$data->prosestransferpasien_id,"iframe"=>true)), 
                        array(
                            "target"=>"iframeDetailKategori", 
                            "onclick"=>"$('#dialogDetailKategori').dialog('open');",
                            "rel"=>"tooltip", 
                            "title"=>"Klik untuk Melihat Detail Kategori & Kondisi Pasien",

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
                        return CHtml::link('<i class="entypo-pencil" style="font-size:14pt"></i>', Yii::app()->controller->createUrl('index', array(
                            'pendaftaran_id'=>$_GET['pendaftaran_id'],
                            'prosestransferpasien_id'=>$data->prosestransferpasien_id,
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
        'id' => 'dialogDetailKategori',
        'options' => array(
            'title' => 'Detail Kategori & Kondisi Pasien',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 1000,
            'height' => 600,
            'resizable' => true
        ),
    ));
    ?>
    <iframe name='iframeDetailKategori' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>