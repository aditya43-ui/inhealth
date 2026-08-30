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
                Ringkasan Transfer Pasien Intra Rumah Sakit
            </div>
        </div>
        <div class="panel-body">
            <?php $this->renderPartial('_row_1', array('form' => $form, 'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modelTransfer' => $modelTransfer, 'jenis' => $jenis)); ?>
            <?php $this->renderPartial('_row_2', array('form' => $form, 'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modelTransfer' => $modelTransfer, 'jenis' => $jenis)); ?>
            <?php $this->renderPartial('_row_3', array('form' => $form, 'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modelTransfer' => $modelTransfer, 'jenis' => $jenis)); ?>
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
<script>
    function cekOksigen() {
        if ($('#is_alatbantuoksigen').is(":checked")) {
            $('.alatbantuoksigen_ket').attr('disabled', false);
        } else {
            $('.alatbantuoksigen_ket').attr('disabled', true);
            $('.alatbantuoksigen_ket').val('');
        }
    }
    function cekLain() {
        if ($('#is_lain').is(":checked")) {
            $('.berkaslainlain').attr('disabled', false);
        } else {
            $('.berkaslainlain').attr('disabled', true);
            $('.berkaslainlain').val('');
        }
    }
    function cekLain2() {
        if ($('#is_lain2').is(":checked")) {
            $('.alabantulainlain').attr('disabled', false);
        } else {
            $('.alabantulainlain').attr('disabled', true);
            $('.alabantulainlain').val('');
        }
    }
    $(document).ready(function(){
        cekOksigen();          
        cekLain();          
        cekLain2();          
	});
</script>
<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogDokter',
        'options' => array(
            'title' => 'Daftar Dokter',
            'autoOpen' => false,
            'modal' => true,
            'width' => 700,
            'height' => 600,
            'resizable' => false,
        ),
    ));

    $modPeg = new PegawaiM('search');
    $modPeg->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modPeg->pegawai_aktif = true;
    $modPeg->kelompokpegawai_id = 1;
    // $modPeg->unsetAttributes();
    if (isset($_GET['PegawaiM'])) {
        $modPeg->attributes = $_GET['PegawaiM'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'dokter-m-grid',
        'dataProvider' => $modPeg->search(),
        'filter' => $modPeg,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0)",array("class"=>"btn-small", 
                "id" => "selectDokter",
                "onClick" => "
                    $(\'.dokter_id\').val($data->pegawai_id);
                    $(\'.dokter_nama\').val(\'$data->namaLengkap\');
                    $(\'#dialogDokter\').dialog(\'close\');
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
<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogPendamping1',
        'options' => array(
            'title' => 'Daftar Pegawai',
            'autoOpen' => false,
            'modal' => true,
            'width' => 700,
            'height' => 600,
            'resizable' => false,
        ),
    ));

    $modPeg = new PegawaiM('search');
    $modPeg->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modPeg->pegawai_aktif = true;
    // $modPeg->unsetAttributes();
    if (isset($_GET['PegawaiM'])) {
        $modPeg->attributes = $_GET['PegawaiM'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'pegawai1-m-grid',
        'dataProvider' => $modPeg->search(),
        'filter' => $modPeg,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0)",array("class"=>"btn-small", 
                "id" => "selectPegawai1",
                "onClick" => "
                    $(\'.pendamping1_id\').val($data->pegawai_id);
                    $(\'.pendamping1_nama\').val(\'$data->namaLengkap\');
                    $(\'#dialogPendamping1\').dialog(\'close\');
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
<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogPendamping2',
        'options' => array(
            'title' => 'Daftar Pegawai',
            'autoOpen' => false,
            'modal' => true,
            'width' => 700,
            'height' => 600,
            'resizable' => false,
        ),
    ));

    $modPeg = new PegawaiM('search');
    $modPeg->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modPeg->pegawai_aktif = true;
    // $modPeg->unsetAttributes();
    if (isset($_GET['PegawaiM'])) {
        $modPeg->attributes = $_GET['PegawaiM'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'pegawai2-m-grid',
        'dataProvider' => $modPeg->search(),
        'filter' => $modPeg,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0)",array("class"=>"btn-small", 
                "id" => "selectPegawai2",
                "onClick" => "
                    $(\'.pendamping2_id\').val($data->pegawai_id);
                    $(\'.pendamping2_nama\').val(\'$data->namaLengkap\');
                    $(\'#dialogPendamping2\').dialog(\'close\');
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