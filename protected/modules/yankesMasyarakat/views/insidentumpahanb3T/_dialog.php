<?php 
//========= Dialog buat cari data unitkerja =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogUnit',
    'options'=>array(
        'title'=>'Pencarian Data Satuan Kerja',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>600,
        'resizable'=>false,
    ),
));
$modDialogUnitKerja = new UnitkerjaM('search');
$modDialogUnitKerja->unitkerja_aktif = TRUE;
$modDialogUnitKerja->hasinstalasi = TRUE;
if(isset($_GET['UnitkerjaM'])) {
    $modDialogUnitKerja->attributes = $_GET['UnitkerjaM'];
    $modDialogUnitKerja->hasinstalasi = TRUE;
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'unitkerja-m-grid',
        'dataProvider'=>$modDialogUnitKerja->search(),
        'filter'=>$modDialogUnitKerja,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                    "id" => "selectPegawai",
                    "onClick" => "
                        $(\"#YKMInsidentumpahanb3T_unitkerja_kejadian_nama\").val(\"$data->namaunitkerja\");
                        $(\"#YKMInsidentumpahanb3T_unitkerja_kejadian_id\").val(\"$data->unitkerja_id\");
                        $(\"#dialogUnit\").dialog(\"close\");
                    "))',
            ),
            
            'namaunitkerja',
            array(
                'header' => 'Instalasi',
                'value' => '!empty($data->instalasi->instalasi_nama)?$data->instalasi->instalasi_nama:""'
            )
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
////======= unitkerja =============


//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Pencarian Pelapor',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPegawaiMengetahui = new PegawaiV('search');
$modPegawaiMengetahui->unsetAttributes();
if (isset($_GET['PegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['PegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimengetahui-grid',
    'dataProvider' => $modPegawaiMengetahui->search(),
    'filter' => $modPegawaiMengetahui,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#YKMInsidentumpahanb3T_pelapor_id\").val(\"$data->pegawai_id\");
                                                  $(\"#YKMInsidentumpahanb3T_pelapor_nama\").val(\"$data->NamaLengkap\");
                                                  $(\"#YKMInsidentumpahanb3T_nomorindukpegawai\").val(\"$data->nomorindukpegawai\");
                                                  $(\"#dialogPegawai\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Jabatan',
            'filter' => CHtml::activeDropDownList($modPegawaiMengetahui, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                } else {
                    return '-';
                }
            }
        ),
        array(
            'header' => 'Unit Kerja',
            'filter' => CHtml::activeDropDownList($modPegawaiMengetahui, 'unitkerja_id', CHtml::listData(UnitkerjaM::model()->findAll("unitkerja_aktif = TRUE ORDER BY namaunitkerja ASC"), 'unitkerja_id', 'namaunitkerja'), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                $j = UnitkerjaM::model()->findByPk($data->unitkerja_id);

                if (!empty($j)) {
                    return $j->namaunitkerja;
                } else {
                    return '-';
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget(); 

//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogKepalaSatuan',
    'options' => array(
        'title' => 'Pencarian Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPegawaiMengetahui = new PegawaiV('search');
$modPegawaiMengetahui->unsetAttributes();
if (isset($_GET['PegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['PegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'mengetahui-grid',
    'dataProvider' => $modPegawaiMengetahui->search(),
    'filter' => $modPegawaiMengetahui,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#YKMInsidentumpahanb3T_mengetahuipegawai_id\").val(\"$data->pegawai_id\");
                                                  $(\"#YKMInsidentumpahanb3T_mengetahuipegawai_nama\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogKepalaSatuan\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Jabatan',
            'filter' => CHtml::activeDropDownList($modPegawaiMengetahui, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                } else {
                    return '-';
                }
            }
        ),
        array(
            'header' => 'Unit Kerja',
            'filter' => CHtml::activeDropDownList($modPegawaiMengetahui, 'unitkerja_id', CHtml::listData(UnitkerjaM::model()->findAll("unitkerja_aktif = TRUE ORDER BY namaunitkerja ASC"), 'unitkerja_id', 'namaunitkerja'), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                $j = UnitkerjaM::model()->findByPk($data->unitkerja_id);

                if (!empty($j)) {
                    return $j->namaunitkerja;
                } else {
                    return '-';
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget(); 

//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogSaksi',
    'options' => array(
        'title' => 'Pencarian Karyawan yang Mengetahui / Melihat',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPegawaiMengetahui = new PegawaiV('search');
$modPegawaiMengetahui->unsetAttributes();
if (isset($_GET['PegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['PegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'kepalasatuan-grid',
    'dataProvider' => $modPegawaiMengetahui->search(),
    'filter' => $modPegawaiMengetahui,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>function($data) {
                            $load = $data->attributes;
                            $load['namaLengkap'] = $data->namaLengkap;
                            $res = json_encode($load);
    
                            return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>',"javascript:;",array("class"=>"btn-small", 
                                    "onclick" => 'setPegPemeriksa('.$res.');$("#dialogSaksi").dialog("close")'));
                    },
        ),  
        array(
            'header' => 'NIP',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Jabatan',
            'filter' => CHtml::activeDropDownList($modPegawaiMengetahui, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                } else {
                    return '-';
                }
            }
        ),
        array(
            'header' => 'Unit Kerja',
            'filter' => CHtml::activeDropDownList($modPegawaiMengetahui, 'unitkerja_id', CHtml::listData(UnitkerjaM::model()->findAll("unitkerja_aktif = TRUE ORDER BY namaunitkerja ASC"), 'unitkerja_id', 'namaunitkerja'), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                $j = UnitkerjaM::model()->findByPk($data->unitkerja_id);

                if (!empty($j)) {
                    return $j->namaunitkerja;
                } else {
                    return '-';
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget(); 
?> 