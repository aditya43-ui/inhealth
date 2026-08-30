<?php 

//========= Dialog buat cari data PPDS  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPpds',
    'options' => array(
        'title' => 'Pencarian PPDS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

$modPpds = new PpdsM();
$modPpds->unsetAttributes();
if (isset($_GET['PpdsM'])) {
    $modPpds->attributes = $_GET['PpdsM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'ppds-m-grid',
    'dataProvider' => $modPpds->searchDialogPPDS(),
    'filter' => $modPpds,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectPpds",
                "onClick" => "
                            $(\"#' . CHtml::activeId($modKirimKeUnitLain, 'ppds_id') . '\").val(\"$data->ppds_id\");
                            $(\"#' . CHtml::activeId($modKirimKeUnitLain, 'ppds_nama') . '\").val(\"$data->ppds_nama\");
                              $(\"#dialogPpds\").dialog(\"close\");    
                              return false;
                    "))',
        ),
        array(
            'header' => 'NIM',
            'name' => 'ppds_nim',
            'value' => '$data->ppds_nim',
        ),
        array(
            'header' => 'Nama PPDS',
            'name' => 'ppds_nama',
            'value' => '$data->ppds_nama',
        ),
        array(
            'header' => 'Tahap',
            'name' => 'ppds_tahap',
            'value' => '$data->ppds_tahap',
        ),
        array(
            'header' => 'Prodi',
            'filter'=>  CHtml::activeDropDownList($modPpds, 'programstudi_id', CHtml::listData(ProgramstudiM::model()->findAll("programstudi_aktif = TRUE ORDER BY programstudi_nama ASC"), 'programstudi_id', 'programstudi_nama'),array('empty'=>'-- Pilih --')),
            'value' => function($data) {
                    $programstudi_nama = "";
                    if(!empty($data->programstudi_id)){
                        $programstudi_nama = ProgramstudiM::model()->findByPk($data->programstudi_id)->programstudi_nama;
                    }
                    return $programstudi_nama;
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Search data PPDS =============================
?>
<?php
    //========= Dialog buat cari DPJP ==========
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogDokter',
        'options' => array(
            'title' => 'Daftar DPJP',
            'autoOpen' => false,
            'modal' => true,
            'width' => 750,
            'resizable' => false,
        ),
    ));

    $modPegawai = new PegawairuanganV('searchDokter');
    $modPegawai->unsetAttributes();
    if (isset($_GET['PegawairuanganV']))
        $modPegawai->attributes = $_GET['PegawairuanganV'];

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'dokter-m-grid',
        'dataProvider' => $modPegawai->searchDokter(),
        'filter' => $modPegawai,
        'template' => "{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            ////'pegawai_id',
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectBahan",
					"onClick" => "
						$(\'#' . Chtml::activeId($modKirimKeUnitLain, 'pegawai_id') . '\').val(\'$data->pegawai_id\');	
						$(\'#dpjp_nama\').val(\'$data->NamaLengkap\');
						$(\'#dialogDokter\').dialog(\'close\');
						return false;"))',
            ),
             array(
            'header' => 'NIP',
            'filter' => CHtml::activeTextField($modPegawai, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPegawai, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function($data){
                        $hasil ='';
                        $j = JabatanM::model()->findByPk($data->jabatan_id);
                                
                        if (!empty($j)){
                            $hasil = $j->jabatan_nama;
                        }
                            return $hasil;
            },
            'filter' => Chtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));

    $this->endWidget();
 //========= Dialog buat cari Petugas ==========
?>




<?php 

//========= Dialog buat cari data PPDS  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPpds2',
    'options' => array(
        'title' => 'Pencarian PPDS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

$modPpds = new PpdsM();
$modPpds->unsetAttributes();
if (isset($_GET['PpdsM'])) {
    $modPpds->attributes = $_GET['PpdsM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'ppds-m2-grid',
    'dataProvider' => $modPpds->searchDialogPPDS(),
    'filter' => $modPpds,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectPpds",
                "onClick" => "$(\".ppds_id2\").val(\"$data->ppds_id\");
                              $(\".ppds_nama2\").val(\"$data->ppds_nama\");   
                              $(\"#dialogPpds2\").dialog(\"close\");    
                              return false;
                    "))',
        ),
        array(
            'header' => 'NIM',
            'name' => 'ppds_nim',
            'value' => '$data->ppds_nim',
        ),
        array(
            'header' => 'Nama PPDS',
            'name' => 'ppds_nama',
            'value' => '$data->ppds_nama',
        ),
        array(
            'header' => 'Tahap',
            'name' => 'ppds_tahap',
            'value' => '$data->ppds_tahap',
        ),
        array(
            'header' => 'Prodi',
            'filter'=>  CHtml::activeDropDownList($modPpds, 'programstudi_id', CHtml::listData(ProgramstudiM::model()->findAll("programstudi_aktif = TRUE ORDER BY programstudi_nama ASC"), 'programstudi_id', 'programstudi_nama'),array('empty'=>'-- Pilih --')),
            'value' => function($data) {
                    $programstudi_nama = "";
                    if(!empty($data->programstudi_id)){
                        $programstudi_nama = ProgramstudiM::model()->findByPk($data->programstudi_id)->programstudi_nama;
                    }
                    return $programstudi_nama;
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Search data PPDS =============================
?>
<?php
    //========= Dialog buat cari DPJP ==========
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogDokter2',
        'options' => array(
            'title' => 'Daftar DPJP',
            'autoOpen' => false,
            'modal' => true,
            'width' => 750,
            'resizable' => false,
        ),
    ));

    $modPegawai = new PegawairuanganV('searchDokter');
    $modPegawai->unsetAttributes();
    if (isset($_GET['PegawairuanganV']))
        $modPegawai->attributes = $_GET['PegawairuanganV'];

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'dokter2-m-grid',
        'dataProvider' => $modPegawai->searchDokter(),
        'filter' => $modPegawai,
        'template' => "{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            ////'pegawai_id',
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectBahan2",
					"onClick" => "
						$(\'.dokter_id2\').val(\'$data->pegawai_id\');	
						$(\'.dokter_nama2\').val(\'$data->NamaLengkap\');
						$(\'#dialogDokter2\').dialog(\'close\');
						return false;"))',
            ),
             array(
            'header' => 'NIP',
            'filter' => CHtml::activeTextField($modPegawai, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPegawai, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function($data){
                        $hasil ='';
                        $j = JabatanM::model()->findByPk($data->jabatan_id);
                                
                        if (!empty($j)){
                            $hasil = $j->jabatan_nama;
                        }
                            return $hasil;
            },
            'filter' => Chtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));

    $this->endWidget();
 //========= Dialog buat cari Petugas ==========
?>


<?php 

//========= Dialog buat cari data PPDS  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPpds3',
    'options' => array(
        'title' => 'Pencarian PPDS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

$modPpds = new PpdsM();
$modPpds->unsetAttributes();
if (isset($_GET['PpdsM'])) {
    $modPpds->attributes = $_GET['PpdsM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'ppds-m2-grid',
    'dataProvider' => $modPpds->searchDialogPPDS(),
    'filter' => $modPpds,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectPpds",
                "onClick" => "$(\".ppds_id3\").val(\"$data->ppds_id\");
                              $(\".ppds_nama3\").val(\"$data->ppds_nama\");   
                              $(\"#dialogPpds3\").dialog(\"close\");    
                              return false;
                    "))',
        ),
        array(
            'header' => 'NIM',
            'name' => 'ppds_nim',
            'value' => '$data->ppds_nim',
        ),
        array(
            'header' => 'Nama PPDS',
            'name' => 'ppds_nama',
            'value' => '$data->ppds_nama',
        ),
        array(
            'header' => 'Tahap',
            'name' => 'ppds_tahap',
            'value' => '$data->ppds_tahap',
        ),
        array(
            'header' => 'Prodi',
            'filter'=>  CHtml::activeDropDownList($modPpds, 'programstudi_id', CHtml::listData(ProgramstudiM::model()->findAll("programstudi_aktif = TRUE ORDER BY programstudi_nama ASC"), 'programstudi_id', 'programstudi_nama'),array('empty'=>'-- Pilih --')),
            'value' => function($data) {
                    $programstudi_nama = "";
                    if(!empty($data->programstudi_id)){
                        $programstudi_nama = ProgramstudiM::model()->findByPk($data->programstudi_id)->programstudi_nama;
                    }
                    return $programstudi_nama;
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Search data PPDS =============================
?>
<?php
    //========= Dialog buat cari DPJP ==========
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogDokter3',
        'options' => array(
            'title' => 'Daftar DPJP',
            'autoOpen' => false,
            'modal' => true,
            'width' => 750,
            'resizable' => false,
        ),
    ));

    $modPegawai = new PegawairuanganV('searchDokter');
    $modPegawai->unsetAttributes();
    if (isset($_GET['PegawairuanganV']))
        $modPegawai->attributes = $_GET['PegawairuanganV'];

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'dokter3-m-grid',
        'dataProvider' => $modPegawai->searchDokter(),
        'filter' => $modPegawai,
        'template' => "{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            ////'pegawai_id',
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectBahan",
					"onClick" => "
						$(\'.dokter_id3\').val(\'$data->pegawai_id\');	
						$(\'.dokter_nama3\').val(\'$data->NamaLengkap\');
						$(\'#dialogDokter3\').dialog(\'close\');
						return false;"))',
            ),
             array(
            'header' => 'NIP',
            'filter' => CHtml::activeTextField($modPegawai, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPegawai, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function($data){
                        $hasil ='';
                        $j = JabatanM::model()->findByPk($data->jabatan_id);
                                
                        if (!empty($j)){
                            $hasil = $j->jabatan_nama;
                        }
                            return $hasil;
            },
            'filter' => Chtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));

    $this->endWidget();
 //========= Dialog buat cari Petugas ==========
?>





<?php
//========= Dialog buat Pencarian Riwayat Imunisasi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogAntibiotik',
    'options' => array(
        'title' => 'Pencarian Data Antibiotik',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 440,
        'resizable' => false,
    ),
));
$modAntibiotik = new AntibiotikmikroM('search');
$modAntibiotik->unsetAttributes();
if (isset($_GET['AntibiotikmikroM'])) {
    $modAntibiotik->attributes = $_GET['AntibiotikmikroM'];
    $modAntibiotik->antibiotikmikro_jenis = $_GET['AntibiotikmikroM']['antibiotikmikro_jenis'];
    $modAntibiotik->antibiotikmikro_nama = $_GET['AntibiotikmikroM']['antibiotikmikro_nama'];
}
    

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'imunisasi-m-grid',
    'dataProvider' => $modAntibiotik->search(),
    'filter' => $modAntibiotik,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectDiagnosaImunisasi",
                                    "onClick" => "
                                                
                                            var data = $(\"#' . CHtml::activeId($modKirimKeUnitLain, 'antibiotikygdiberi') . '\").val();
                                                if (data == \"\"){
                                                    $(\"#' . CHtml::activeId($modKirimKeUnitLain, 'antibiotikygdiberi') . '\").val(\"$data->antibiotikmikro_nama\");
                                                } else {
                                                    $(\"#' . CHtml::activeId($modKirimKeUnitLain, 'antibiotikygdiberi') . '\").val(data+\", $data->antibiotikmikro_nama\");                                                  
                                                }
                                                $(\"#dialogAntibiotik\").dialog(\"close\");    
                                        "))',
        ),
        // 'antibiotikmikro_kode',
        array(
            'header' => 'Jenis Antibiotik',
            'type' => 'raw',
            'filter' => CHtml::activeTextField($modAntibiotik, 'antibiotikmikro_jenis'),
            'value' => '$data->antibiotikmikro_jenis',
        ),
        array(
            'header' => 'Nama Antibiotik',
            'type' => 'raw',
            'filter' => CHtml::activeTextField($modAntibiotik, 'antibiotikmikro_nama'),
            'value' => '$data->antibiotikmikro_nama',
        ),
        // 'antibiotikmikro_nama',
        // 'antibiotikmikro_jenis',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Pencarian Riwayat Imunisasi dialog =============================
?>