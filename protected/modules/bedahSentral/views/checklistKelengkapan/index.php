<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
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
                Check List Kelengkapan Pre Operasi
            </div>
        </div>
        <div class="panel-body">
            <?php $this->renderPartial('_row_1', array('form' => $form, 'pendaftaran' => $pendaftaran, 'modCeklist' => $modCeklist, 'jenis' => $jenis)); ?>
            <?php $this->renderPartial('_row_2', array('form' => $form, 'pendaftaran' => $pendaftaran, 'modCeklist' => $modCeklist, 'jenis' => $jenis)); ?>
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
                        array('title' => 'Simpan', 'class' => 'btn btn-success', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'onclick' => 'cekReq(event);')
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
    function cekReq(event) {
        var cek1 = $('.petugasok_id').val();
        var cek2 = $('.pertugasrawatinap_id').val();
        
        if(cek1 == '' || cek2 == '') {
            myAlert('Silakan isi yang bertanda bintang <span class="required">*</span> !');
            event.preventDefault();
        }
    }
</script>
<!-- open dialog petugas OK -->
<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogPetugasOK',
        'options' => array(
            'title' => 'Daftar Petugas Kamar Operasi',
            'autoOpen' => false,
            'modal' => true,
            'width' => 700,
            'height' => 600,
            'resizable' => false,
        ),
    ));

    $modPeg = new PegawaiM('search');
    // $modPeg->instalasi_id = Yii::app()->user->getState('instalasi_id');
    $modPeg->ruangan_id = 57;
    $modPeg->pegawai_aktif = true;
    // $modPeg->unsetAttributes();
    if (isset($_GET['PegawaiM'])) {
        $modPeg->attributes = $_GET['PegawaiM'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'petugasOK-m-grid',
        'dataProvider' => $modPeg->search(),
        'filter' => $modPeg,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0)",array("class"=>"btn-small", 
                "id" => "selectPetugasOK",
                "onClick" => "
                    $(\'.petugasok_id\').val($data->pegawai_id);
                    $(\'.petugasok_nama\').val(\'$data->namaLengkap\');
                    $(\'#dialogPetugasOK\').dialog(\'close\');
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
<!-- open dialog petugas RI -->
<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogPetugasRI',
        'options' => array(
            'title' => 'Daftar Petugas Rawat Inap',
            'autoOpen' => false,
            'modal' => true,
            'width' => 700,
            'height' => 600,
            'resizable' => false,
        ),
    ));

    $modPeg = new PegawaiM('search');
    $modPeg->cek_array_or_not = true;
    $modPeg->array_1 = 2;
    $modPeg->array_2 = 20;
    $modPeg->instalasi_id = 4;
    $modPeg->pegawai_aktif = true;
    // $modPeg->unsetAttributes();
    if (isset($_GET['PegawaiM'])) {
        $modPeg->attributes = $_GET['PegawaiM'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'petugasRI-m-grid',
        'dataProvider' => $modPeg->search(),
        'filter' => $modPeg,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0)",array("class"=>"btn-small", 
                "id" => "selectPetugasRI",
                "onClick" => "
                    $(\'.pertugasrawatinap_id\').val($data->pegawai_id);
                    $(\'.pertugasrawatinap_nama\').val(\'$data->namaLengkap\');
                    $(\'#dialogPetugasRI\').dialog(\'close\');
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