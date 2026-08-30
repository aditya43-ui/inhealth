<?php
//========= Dialog untuk ....  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPetugasAnalisa',
    'options' => array(
        'title' => 'Petugas Analisa Darah Kembali',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'resizable' => false,
    ),
));


$model = new BDPegawairuanganV('search');
$model->unsetAttributes();
$model->ruangan_id = Yii::app()->user->getState("ruangan_id");
$model->pegawai_aktif = true;

if (isset($_GET['BDPegawairuanganV'])) {
    $model->attributes = $_GET['BDPegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'petugas-analisa-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectItem",
                "onClick" => "
                    $(\".petugas_analisa_id\").val(".$data->pegawai_id.");
                    $(\".petugas_analisa_nama\").val(\"".$data->nama_pegawai."\");
                    $(\"#dialogPetugasAnalisa\").dialog(\"close\");
                    return false;"))',
        ),
        'nomorindukpegawai',
        'nama_pegawai'
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

    <?php
//========= Dialog untuk ....  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogReturKantong',
    'options' => array(
        'title' => 'Kantong Darah',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));
    
    
$model = new BDReturdarahT('search');
$model->unsetAttributes();
if (isset($_GET['BDReturdarahT'])) {
    $model->attributes = $_GET['BDReturdarahT'];
    
    $model->no_kantongdarah = $_GET['BDReturdarahT']['no_kantongdarah'];
    $model->no_rekam_medik = $_GET['BDReturdarahT']['no_rekam_medik'];
    $model->nama_pasien = $_GET['BDReturdarahT']['nama_pasien'];
    //$model->jeniskantongdarah_id = $_GET['BDReturdarahT']['jeniskantongdarah_id'];
    $model->komponendarah_id = $_GET['BDReturdarahT']['komponendarah_id'];
    
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'drafter-grid',
    'dataProvider' => $model->searchReturKantongDarah(),
    'filter' => $model,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
    
                $json = $data->jsonReturDarah();
    
                return CHtml::Link('<i class="icon-form-check"></i>',"#",array("class"=>"btn-small", 
                    "id" => "selectItem",
                    "onClick" => "setReturDarah(".$json."); $('#dialogReturKantong').dialog('close'); return false;"
                ));
            },
        ),
        array(
            'header'=>'No. Kantong Darah',
            'value'=>'$data->no_kantongdarah',
            'name'=>'no_kantongdarah',
        ),
        array(
            'name'=>'no_rekam_medik',
            'header'=>'No. Rekam Medik',
        ),
        
        'nama_pasien',
        array(
            'header'=>'Jenis Darah',
            'name'=>'komponendarah_id',
            'type'=>'raw',
            'value'=>function($data) {
                return $data->jenis_komponen_darah;
            },
            'filter'=>CHtml::activeDropDownList($model, 'komponendarah_id', CHtml::listData(BDKomponendarahM::model()->findAll(
                'komponendarah_aktif = true order by komponendarah_id'), 'komponendarah_id', 'singkatan_komp'), array(
                    'empty'=>'-- Pilih --',
            )),
        ),
                
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
    
$this->endWidget();
?>
