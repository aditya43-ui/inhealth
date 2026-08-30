<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'terdugatb-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#RKAnamnesaT_keluhanutama_annoninput .maininput',
));
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="row">
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title">
                Form Pencatatan Dokter Penanggung Jawab Pelayanan (PDJP)
            </div>
        </div>
        <div class="panel-body">
            <?php $this->renderPartial('_row_1', array('form' => $form, 'modPencatatan' => $modPencatatan, 'modPencatatanDet' => $modPencatatanDet, 'jenis' => $jenis, 'new' => $new)); ?>
            <?php $this->renderPartial('_row_2', array('form' => $form, 'modDiagnosa' => $modDiagnosa, 'modPencatatan' => $modPencatatan, 'modPencatatanDet' => $modPencatatanDet, 'jenis' => $jenis, 'new' => $new)); ?>
            <?php
                if(($jenis == 'lihat')){
                    echo CHtml::link('Kembali', $this->createUrl('index', array('pendaftaran_id' => $_GET['pendaftaran_id'])), array(
                        'class'=>'btn btn-danger'
                    )); 
                } else {
            ?>
            <?php
                    echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                        array('title' => 'Simpan', 'class' => 'btn btn-success', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                    );
            ?>
            <?php
                    echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        Yii::app()->createUrl('jurnalRekPenjamin/admin'),
                        array(
                            'title' => 'Ulang',
                            'class' => 'btn btn-warning',
                            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                        )
                    );
                }
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogPegawai',
        'options' => array(
            'title' => 'Daftar Karyawan',
            'autoOpen' => false,
            'modal' => true,
            'width' => 700,
            'height' => 600,
            'resizable' => false,
        ),
    ));

    $modPeg = new PegawaiM('search');
    $modPeg->unsetAttributes();
    if (isset($_GET['PegawaiM'])) {
        $modPeg->attributes = $_GET['PegawaiM'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'pegawai-m-grid',
        'dataProvider' => $modPeg->search(),
        'filter' => $modPeg,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0)",array("class"=>"btn-small", 
                "id" => "selectPegawai",
                "onClick" => "
                    $(\'.pegawai_id\').val($data->pegawai_id);
                    $(\'.pegawai_nama\').val(\'$data->namaLengkap\');
                    $(\'#dialogPegawai\').dialog(\'close\');
                    return false;"
                    ))',
            ),
            'nomorindukpegawai',
            [
                'header'=>'Nama',
                'name'=>'nama_pegawai',
                'value'=>'$data->namaLengkap'
            ],
            
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));

    $this->endWidget();
?>