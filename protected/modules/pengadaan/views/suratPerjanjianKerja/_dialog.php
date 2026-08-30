<?php

$p_id = isset($_GET['id'])?$_GET['id']:$model->persiapanpengadaan_id;

//========= Dialog untuk ....  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPenyediaBarangJasa',
    'options' => array(
        'title' => 'Penyedia Barang/Jasa',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));


$modSupplier = new ADSupplierM('search');
$modSupplier->unsetAttributes();
if (isset($_GET['ADSupplierM'])) {
    $modSupplier->attributes = $_GET['ADSupplierM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'drafter-grid',
    'dataProvider' => $modSupplier->searchDialogPenyedia(),
    'filter' => $modSupplier,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectItem",
                "onClick" => "
                    $(\".supplier_id\").val(".$data->supplier_id.");
                    $(\".supplier_nama\").val(\"".$data->supplier_nama."\");
                    setSupplier(".CJSON::encode($data->attributes).");
                    $(\"#SuratperjanjiankerjaT_nosuratperjanjiankerja\").blur();
                    $(\"#dialogPenyediaBarangJasa\").dialog(\"close\");
                    return false;"))',
        ),
        'supplier_kode',
        'supplier_nama',
        'supplier_alamat',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>


    <?php
//========= Dialog untuk ....  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogProgram',
    'options' => array(
        'title' => 'Program',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));


$modProgram = new KegiatanprogramM('search');
$modProgram->unsetAttributes();
$modProgram->kegiatanprogram_aktif = true;

if (isset($_GET['KegiatanprogramM'])) {
    $modProgram->attributes = $_GET['KegiatanprogramM'];
}

$prov = $modProgram->search();
$prov->sort->defaultOrder = 'kegiatanprogram_nourut';
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'program-grid',
    'dataProvider' => $prov,
    'filter' => $modProgram,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectItem",
                "onClick" => "
                    $(\".kegiatanprogram_id, #dialog_kegiatanprogram_id\").val(".$data->kegiatanprogram_id.");
                    $(\".kegiatanprogram_nama\").val(\"".$data->kegiatanprogram_kode." - ".$data->kegiatanprogram_nama."\");
                    $(\".subkegiatanprogram_id\").val(\"\");
                    $(\".subkegiatanprogram_nama\").val(\"\");
                    $(\"#SuratperjanjiankerjaT_nosuratperjanjiankerja\").blur();
                    $(\"#dialogProgram\").dialog(\"close\");
                    $.fn.yiiGridView.update(\"kegiatan-grid\", {data : $(\"#dialogKegiatan :input\").serialize()});
                    return false;"))',
        ),
        'kegiatanprogram_kode',
        'kegiatanprogram_nama',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>


    <?php
//========= Dialog untuk ....  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogKegiatan',
    'options' => array(
        'title' => 'Kegiatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));


$modKegiatan = new SubkegiatanprogramM('search');
$modKegiatan->unsetAttributes();
$modKegiatan->subkegiatanprogram_aktif = true;

if (isset($_GET['SubkegiatanprogramM'])) {
    $modKegiatan->attributes = $_GET['SubkegiatanprogramM'];
}

$prov = $modKegiatan->search();
$prov->sort->defaultOrder = 'subkegiatanprogram_nourut';
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'kegiatan-grid',
    'dataProvider' => $prov,
    'filter' => $modKegiatan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectItem",
                "onClick" => "
                    $(\".subkegiatanprogram_id\").val(".$data->subkegiatanprogram_id.");
                    $(\".subkegiatanprogram_nama\").val(\"".$data->subkegiatanprogram_kode." - ".$data->subkegiatanprogram_nama."\");
                    $(\"#SuratperjanjiankerjaT_nosuratperjanjiankerja\").blur();
                    $(\"#dialogKegiatan\").dialog(\"close\");
                    return false;"))',
            'filter'=>CHtml::activeHiddenField($modKegiatan, 'kegiatanprogram_id', array('id'=>'dialog_kegiatanprogram_id')),
        ),
        'subkegiatanprogram_kode',
        'subkegiatanprogram_nama',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>



<?php 
//========= Dialog buat cari data Rek Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogRekening',
    'options'=>array(
        'title'=>'Daftar Rekening Akuntansi',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>400,
        'resizable'=>false,
    ),
));

$modRekDebit = new RekeningakuntansiV('search');
$modRekDebit->unsetAttributes();
// $modRekDebit->rekening5_nb = "D";
$modRekDebit->rekening5_aktif = true;
$account = "";
if(isset($_GET['RekeningakuntansiV'])) {
    $modRekDebit->attributes = $_GET['RekeningakuntansiV'];
}

$c2 = new CDbCriteria();
$c3 = new CDbCriteria();
$c4 = new CDbCriteria();


$c2->compare('rekening1_id', $modRekDebit->rekening1_id);
$c2->addCondition('rekening2_aktif = true');
$c2->order = 'kdrekening2';

$r2 = Rekening2M::model()->findAll($c2);

$c3->compare('rekening2_id', $modRekDebit->rekening2_id);
$c3->addCondition('rekening3_aktif = true');
$c3->order = 'kdrekening3';

$r3 = Rekening3M::model()->findAll($c3);

$c4->compare('rekening3_id', $modRekDebit->rekening3_id);
$c4->addCondition('rekening4_aktif = true');
$c4->order = 'kdrekening4';

$r4 = Rekening4M::model()->findAll($c4);

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'rekening5-m-grid',
    'dataProvider'=>$modRekDebit->searchAccounts(),
    'filter'=>$modRekDebit,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectRekDebit",
                "onClick" =>"
                    $(\".rekening5_id\").val(\"".$data->rekening5_id."\");
                    $(\".nmrekening5\").val(\"".$data->kdrekening5." - ".$data->nmrekening5."\");    
                    $(\"#SuratperjanjiankerjaT_nosuratperjanjiankerja\").blur();                                           
                    $(\"#dialogRekening\").dialog(\"close\");    
                    return false;
            "))',
        ),
        array(
            'header' => 'Kode Akun',
            'name' => 'kdrekening5',
            'value' => '$data->kdrekening5',
            'filter' => Chtml::activeTextField($modRekDebit, 'kdrekening5', array('class'=>'numbers-only','maxlength'=>12))
        ),
        array(
            'header'=>'Kelompok Akun',
            'type'=>'raw',
            'value'=>function($data) {
                $rek1 = Rekening1M::model()->findByPk($data->rekening1_id);
                $rek2 = KelrekeningM::model()->findByPk($rek1->kelrekening_id);
                return $rek2->namakelrekening;
            },
            'filter'=>CHtml::activeDropDownList($modRekDebit, 'kelrekening_id', CHtml::listData(
            KelrekeningM::model()->findAll(array(
               'condition'=>'kelrekening_aktif = true',
               'order'=>'koderekeningkel',
            )), 'kelrekening_id', 'namakelrekening'
            ), array('empty'=>'-- Pilih --')),
        ),
        array(
            'header'=>'Komponen',
            'name'=>'rekening1_id',
            'value'=>'$data->nmrekening1',
            'filter'=>  CHtml::activeDropDownList($modRekDebit, 'rekening1_id', 
            CHtml::listData(Rekening1M::model()->findAll(array(
                'condition'=>'rekening1_aktif = true',
                'order'=>'kdrekening1 asc',
            )), 'rekening1_id', 'nmrekening1'), array('empty'=>'-- Pilih --')),
        ),
        array(
            'header'=>'Unsur',
            'name'=>'rekening2_id',
            'value'=>'$data->nmrekening2',
            'filter'=>  CHtml::activeDropDownList($modRekDebit, 'rekening2_id', 
            CHtml::listData($r2, 'rekening2_id', 'nmrekening2'), array('empty'=>'-- Pilih --')),
        ),
        array(
            'header'=>'Kelompok Pos',
            'name'=>'rekening3_id',
            'value'=>'$data->nmrekening3',
            'filter'=>  CHtml::activeDropDownList($modRekDebit, 'rekening3_id', 
            CHtml::listData($r3, 'rekening3_id', 'nmrekening3'), array('empty'=>'-- Pilih --')),
        ),
        array(
            'header'=>'Pos',
            'name'=>'rekening4_id',
            'value'=>'$data->nmrekening4',
            'filter'=>  CHtml::activeDropDownList($modRekDebit, 'rekening4_id', 
            CHtml::listData($r4, 'rekening4_id', 'nmrekening4'), array('empty'=>'-- Pilih --')),
        ),
        array(
            'header' => 'Akun',
            'name' => 'nmrekening5',
            'value' => '$data->nmrekening5',
            'filter' => Chtml::activeTextField($modRekDebit, 'nmrekening5', array('class'=>'custom-only'))
        ),
        array(
            'header'=>'Saldo Normal',
            'name'=>'rekening5_nb',
            'value'=>'($data->rekening5_nb == "D") ? "Debit" : "Kredit"',
                        'filter'=>  CHtml::activeDropDownList($modRekDebit, 'rekening5_nb', array('D'=>'Debit', 'K'=>'Kredit'), array('empty'=>"-- Pilih --")),
        ),

    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});'
        . '$(".numbers-only").keyup(function() {
            setNumbersOnly(this);
            });
            $(".custom-only").keyup(function() {
            setCustomOnly(this);
            });'
                                . '}',
));


$this->endWidget();
//========= end Rek Debit dialog =============================
?>



    <?php
//========= Dialog untuk ....  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPejabatPengguna',
    'options' => array(
        'title' => 'Pejabat Pengguna',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));
    
    
$modPejabat = new PegawaiV('search');
$modPejabat->unsetAttributes();
$modPejabat->pegawai_aktif = true;
if (isset($_GET['PegawaiV'])) {
    $modPejabat->attributes = $_GET['PegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pejabat-grid',
    'dataProvider' => $modPejabat->search(),
    'filter' => $modPejabat,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectItem",
                "onClick" => "
                    $(\".pejabatpenggunaanggaran_id\").val(".$data->pegawai_id.");
                    $(\".pejabatpenggunaanggaran_nama\").val(\"".$data->namaLengkap."\");
                    $(\"#SuratperjanjiankerjaT_nosuratperjanjiankerja\").blur();
                    $(\"#dialogPejabatPengguna\").dialog(\"close\");
                    return false;"))',
        ),
        'nomorindukpegawai',
        array(
            'header'=>'Nama Pegawai',
            'name'=>'nama_pegawai',
            'value'=>'$data->namaLengkap',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
    
$this->endWidget();
?>

    <?php
//========= Dialog untuk ....  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogKuasaPengguna',
    'options' => array(
        'title' => 'Kuasa Pengguna',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));
    
    
$modKuasa = new PegawaiV('search');
$modKuasa->unsetAttributes();
if (isset($_GET['PegawaiV'])) {
    $modKuasa->attributes = $_GET['PegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'kuasa-grid',
    'dataProvider' => $modKuasa->search(),
    'filter' => $modKuasa,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectItem",
                "onClick" => "
                    $(\".kuasapenggunaanggaran_id\").val(".$data->pegawai_id.");
                    $(\".kuasapenggunaanggaran_nama\").val(\"".$data->namaLengkap."\");
                    $(\"#dialogKuasaPengguna\").dialog(\"close\");
                    return false;"))',
        ),
        'nomorindukpegawai',
        array(
            'header'=>'Nama Pegawai',
            'name'=>'nama_pegawai',
            'value'=>'$data->namaLengkap',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
    
$this->endWidget();
?>

<?php
//========= Dialog untuk Mencari Penawaran Penyedia  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPenawaranPenyedia',
    'options' => array(
        'title' => 'Penawaran Penyedia',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));


$modSupplier = new PenawaranpenyediaT('searchPenawaranPenyedia');
$modSupplier->unsetAttributes();
$modSupplier->persiapanpengadaan_id = $p_id;
if (isset($_GET['PenawaranpenyediaT'])) {
    $modSupplier->attributes = $_GET['PenawaranpenyediaT'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'penawaran-penyedia-grid',
    'dataProvider' => $modSupplier->searchPenawaranPenyedia(),
    'filter' => $modSupplier,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectItem",
                "onClick" => "
                    $(\".penawaranpenyedia_id\").val(".$data->penawaranpenyedia_id.");
                    $(\".penawaranpenyedia_nomor\").val(\"".$data->penawaranpenyedia_nomor."\");
                    $(\"#SuratperjanjiankerjaT_tglpenawaran\").val(\"".$data->penawaranpenyedia_tanggal."\");
                    $(\"#supplier_nama\").val(\"".$data->supplier->supplier_nama."\");
                    $(\"#SuratperjanjiankerjaT_supplier_id\").val(\"".$data->supplier->supplier_id."\");
                    $(\"#SuratperjanjiankerjaT_nama_supplier\").val(\"".$data->supplier->direktursupplier."\");
                    $(\"#SuratperjanjiankerjaT_alamat_supplier\").val(\"".$data->supplier->supplier_alamat."\");
                    $(\"#SuratperjanjiankerjaT_nomor_rekening\").val(\"".$data->supplier->supplier_norekening."\");
                    $(\"#dialogPenawaranPenyedia\").dialog(\"close\");
                    return false;"))',
        ),
        'penawaranpenyedia_nomor',
        'penawaranpenyedia_nomorsurat',
        array(
            'header' => 'Direktur',
            'value'  => function ($data){
                echo $data->supplier->direktursupplier;
            }
        )
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();

////========= Dialog untuk Obat  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogObat',
    'options' => array(
        'title' => 'Data Obat',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));
    
$modelObat = new ObatalkesM('search');
$modelObat->unsetAttributes();
$modelObat->obatalkes_aktif = true;
if (isset($_GET['ObatalkesM'])) {
    $modelObat->attributes = $_GET['ObatalkesM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obat-grid',
    'dataProvider' => $modelObat->search(),
    'filter' => $modelObat,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                    "id" => "selectPegawai",
                    "onClick" => "                    
                        setObatAlkes($data->obatalkes_id);
                    "))',
            ),
        'obatalkes_nama',
        array(
            'name'=>'obatalkes_kategori',
            'filter'=> CHtml::activeHiddenField($modelObat, 'generik_id', array('class' => 'obat_generik_id')) . 
                        CHtml::activeDropDownList($modelObat, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array('empty'=>'-- Pilih --'))
        ),
        array(
            'name'=>'obatalkes_golongan',
            'filter'=> CHtml::activeDropDownList($modelObat, 'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'), array('empty'=>'-- Pilih --'))
        ),
        array(
            'header'=>'Satuan Kecil',
            'name'=>'satuankecil_nama',
            'type'=>'raw',
            'value'=>'$data->satuankecil->satuankecil_nama',
            'filter'=>CHtml::activeDropDownList($modelObat, 'satuankecil_id', CHtml::listData(
           SatuankecilM::model()->findAll(array('condition'=>'satuankecil_aktif = true', 'order'=>'satuankecil_nama asc')), 'satuankecil_id', 'satuankecil_nama'
            ), array('empty'=>'-- Pilih --')),
        ),
        array(
            'header'=>'SSHBJ',
            'name'=>'sshbj',
            'value'=>'MyFormatter::formatNumberForPrint($data->sshbj)',
            'filter'=>false,
            'htmlOptions'=>array('style'=>'text-align: right'),
        ),
        
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
    
$this->endWidget();