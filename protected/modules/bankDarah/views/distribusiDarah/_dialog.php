<?php
//========= Dialog untuk ....  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogKantongDarah',
    'options' => array(
        'title' => 'Kantong Darah',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'resizable' => false,
    ),
));
    
    
$modKantong = new BDKantongdarahT('search');
$modKantong->unsetAttributes();
if (isset($_GET['BDKantongdarahT'])) {
    $modKantong->attributes = $_GET['BDKantongdarahT'];
    $modKantong->gol_darah = $_GET['BDKantongdarahT']['gol_darah'];
    $modKantong->rhesus = $_GET['BDKantongdarahT']['rhesus'];
    $modKantong->singkatan_komp = $_GET['BDKantongdarahT']['singkatan_komp'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'kantong-darah-grid',
    'dataProvider' => $modKantong->searchKantongUntukDistribusi(),
    'filter' => $modKantong,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::checkBox('cek', false, array(
                    'data-id'=>$data->kantongdarah_id,
                    'class'=>'cek_kantong',
                    'onclick'=>'ceklisKantongDarah(this);'
                ));
            }
        ),
        'no_kantongdarah',
        array(
            'header'=>'Jenis Komponen Darah',
            'name'=>'komponendarah_id',
            'type'=>'raw',
            'value'=>function($data) {
                if (empty($data->komponendarah_id)) {
                    return "-";
                }
                $jenis = KomponendarahM::model()->findByPk($data->komponendarah_id);
                
                if (empty($jenis)) {
                    return "-";
                }
                
                return $jenis->singkatan_komp;
            },
            'filter'=>CHtml::activeDropDownList($modKantong, 'singkatan_komp',
                CHtml::listData(KomponendarahM::model()->findAll('komponendarah_aktif = true order by komponendarah_id'),
                    'singkatan_komp', 'singkatan_komp'),
                array('empty'=>'-- Pilih --')
            ),
        ),
        array(
            'name'=>'jeniskantongdarah_id',
            'type'=>'raw',
            'value'=>function($data) {
                if (empty($data->jeniskantongdarah_id)) {
                    return "-";
                }
                $jenis = JeniskantongdarahM::model()->findByPk($data->jeniskantongdarah_id);
                
                if (empty($jenis)) {
                    return "-";
                }
                
                return $jenis->nama_jenis;
            },
            'filter'=>CHtml::activeDropDownList($modKantong, 'jeniskantongdarah_id',
                CHtml::listData(JeniskantongdarahM::model()->findAll('jeniskantongdarah_aktif = true order by jeniskantongdarah_id'),
                    'jeniskantongdarah_id', 'nama_jenis'),
                array('empty'=>'-- Pilih --')
            ),
        ),
        array(
            'name'=>'gol_darah',
            'header'=>'Golongan Darah',
            'filter'=>CHtml::activeDropDownList($modKantong, 'gol_darah', LookupM::getItems('golongandarah'), array(
                'empty'=>'-- Pilih --',
            )),
        ),
        array(
            'name'=>'rhesus',
            'header'=>'Rhesus',
            'filter'=>CHtml::activeDropDownList($modKantong, 'rhesus', array('Positif'=>'Positif', 'Negatif'=>'Negatif'), array(
                'empty'=>'-- Pilih --',
            )),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); loadCeklisKantongDarah();}',
));
    echo CHtml::htmlButton('<i class="entypo-plus"></i> Tambah', array(
        'class'=>'btn btn-green',
        'onclick'=>'tambahKantongDarah(); $("#dialogKantongDarah").dialog("close");',
    ));
$this->endWidget();
?>



    <?php
//========= Dialog untuk memilih petugas distribusi  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDistribusi',
    'options' => array(
        'title' => 'Petugas Distribusi Pelayanan Donor',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));
    
    
$distribusi = new PegawairuanganV('search');
$distribusi->unsetAttributes();
$distribusi->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['PegawairuanganV'])) {
    $distribusi->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'petugas-distribusi-grid',
    'dataProvider' => $distribusi->search(),
    'filter' => $distribusi,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectItem",
                "onClick" => "
                    $(\".petugasdistribusi_id\").val(".$data->pegawai_id.");
                    $(\".petugasdistribusi_nama\").val(\"".$data->nama_pegawai."\");                    
                    $(\"#dialogDistribusi\").dialog(\"close\");
                    $(\".keterangan\").blur();
                    return false;"))',
        ),
        'nama_pegawai',
        'nomorindukpegawai',
        //'alamat_pegawai',
        //'agama',
        array(
            'name' => 'jeniskelamin',
            'filter' => LookupM::getItems('jeniskelamin'),
            'value' => '$data->jeniskelamin',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
    
$this->endWidget();
?>


    <?php
//========= Dialog untuk ....  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogKoordinator',
    'options' => array(
        'title' => 'Koordinator Pelayanan Donor',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));
    
$koordinator = new PegawairuanganV('search');
$koordinator->unsetAttributes();
$koordinator->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['PegawairuanganV'])) {
    $koordinator->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'petugas-koordinator-grid',
    'dataProvider' => $koordinator->search(),
    'filter' => $koordinator,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectItem",
                "onClick" => "
                    $(\".petugaskoordinator_id\").val(".$data->pegawai_id.");
                    $(\".petugaskoordinator_nama\").val(\"".$data->nama_pegawai."\");
                    $(\"#dialogKoordinator\").dialog(\"close\");
                    $(\".keterangan\").blur();
                    return false;"))',
        ),
        'nama_pegawai',
        'nomorindukpegawai',
        //'alamat_pegawai',
        //'agama',
        array(
            'name' => 'jeniskelamin',
            'filter' => LookupM::getItems('jeniskelamin'),
            'value' => '$data->jeniskelamin',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
    
$this->endWidget();
?>

