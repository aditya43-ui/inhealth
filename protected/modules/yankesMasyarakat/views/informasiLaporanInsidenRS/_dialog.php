<?php

//========= Dialog buat cari data diagnosa  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogDiagnosa',
    'options'=>array(
        'title'=>'Pencarian Diagnosa',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>600,
        'resizable'=>false,
    ),
));

$modDiagnosa = new YKMDiagnosaM('search');
$modDiagnosa -> unsetAttributes();
$modDiagnosa->diagnosa_aktif = true;
if(isset($_GET['YKMDiagnosaM'])) {
    $modDiagnosa->attributes = $_GET['YKMDiagnosaM'];    
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'ppds-m-grid',
    'dataProvider' => $modDiagnosa->searchDialog(),
    'filter' => $modDiagnosa,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
            "id" => "selectPpds",
            "onClick" => "
                    $(\"#InsidenrsT_diagnosa_nama\").val(\"$data->diagnosa_nama\");
                    $(\"#InsidenrsT_diagnosa_id\").val(\"$data->diagnosa_id\");
                    $(\"#dialogDiagnosa\").dialog(\"close\");
                "))',
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        array(
            'header' => 'Diagnosa',
            'name' => 'diagnosa_nama',
            'value' => '$data->diagnosa_nama',
        ),
        array(
            'header' => 'Klasifikasi',
            'value' => '$data->klasifikasidiagnosa->klasifikasidiagnosa_nama'
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Search data PPDS =============================
?>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogRuangan',
    'options' => array(
        'title' => 'Daftar Ruangan Kejadian',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 660,
        'resizable' => false,
    ),
));
?>
<?php
$modRuangan = new RuanganM('search');
$modRuangan->unsetAttributes();
$modRuangan->ruangan_aktif = true;
if (isset($_GET['RuanganM'])) {
    $modRuangan->attributes = $_GET['RuanganM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'ruangan-m-grid',
    'dataProvider' => $modRuangan->searchDialog(),
    'filter' => $modRuangan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                $attr = CJSON::encode($data->attributes);
                return CHtml::link('<i class="icon-form-check"></i>', '#', array(
                            'class' => 'btn-small',
                            'id' => 'selectRuangan',
                            'onclick' => " $('#InsidenrsT_lokasikejadian_id').val($data->ruangan_id);
                                           $('#InsidenrsT_lokasikejadian_nama').val('$data->ruangan_nama');
                                           refreshDialog(); 
                                           $('#dialogRuangan').dialog('close'); return false;"
                ));
            },
        ),
        'ruangan_nama',
        array(
            'header' => 'Instalasi',
            'type' => 'raw',
            'filter' => CHtml::activeDropDownList($modRuangan, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll(array(
                                'condition' => 'instalasi_aktif = true',
                                'order' => 'instalasi_nama asc',
                            )), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                echo $data->instalasi_nama; 
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )
);
$this->endWidget();
?>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogUnitKerja',
    'options' => array(
        'title' => 'Daftar Unit Kerja Kejadian',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 660,
        'resizable' => false,
    ),
));
?>
<?php
$modUnit = new UnitkerjaruanganM('search');
$modUnit->unsetAttributes();
if (isset($_GET['UnitkerjaruanganM'])) {
    $modUnit->attributes = $_GET['UnitkerjaruanganM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'unitkerja-m-grid',
    'dataProvider' => $modUnit->searchUnitKerjaRuangan(),
    'filter' => $modUnit,
    'template'=>"{summaryNonPage}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                $attr = CJSON::encode($data->attributes);
                $modUnit = UnitkerjaM::model()->findByPk($data->unitkerja_id);
                $kepala_unit = "";
                $kepala_unit = !empty($modUnit->kepalaunitpeg_id) ? $modUnit->kepalaunitkerja->namaLengkap : null;
                return CHtml::link('<i class="icon-form-check"></i>', '#', array(
                            'class' => 'btn-small',
                            'id' => 'selectRuangan',
                            'onclick' => " $('#InsidenrsT_unitkerjatempat_id').val($data->unitkerja_id);
                                           $('#InsidenrsT_unitkerja').val('$modUnit->namaunitkerja');
                                           $('#InsidenrsT_mengetahui_nama').val('$kepala_unit');
                                           $('#InsidenrsT_mengetahui_id').val('$modUnit->kepalaunitpeg_id');
                                           $('#dialogUnitKerja').dialog('close'); return false;"
                ));
            },
        ),
        array(
            'header' => 'Unit Kerja',
            'type' => 'raw',
            'filter' => CHtml::activeHiddenField($modUnit, 'ruangan_id', array('class' => 'ruangan_id'))
                        . CHtml::activeDropDownList($modUnit, 'unitkerja_id', CHtml::listData(UnitkerjaM::model()->findAll(array(
                                'condition' => 'unitkerja_aktif = true',
                                'order' => 'namaunitkerja asc',
                            )), 'unitkerja_id', 'namaunitkerja'), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                echo $data->unitkerja->namaunitkerja; 
            },
        ),
        array(
            'header' => 'Kepala Unit Kerja',
            'type' => 'raw',
            'value' => function($data){
                $modUnit = UnitkerjaM::model()->findByPk($data->unitkerja_id);
                if (!empty($modUnit->kepalaunitpeg_id)) {
                    echo $modUnit->kepalaunitkerja->namaLengkap; 
                } else {
                    echo "-";
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )
);
$this->endWidget();
?>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogRuanganPenyebab',
    'options' => array(
        'title' => 'Daftar Ruangan Penyebab',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 660,
        'resizable' => false,
    ),
));
?>
<?php
$modRuangan = new RuanganM('search');
$modRuangan->unsetAttributes();
$modRuangan->ruangan_aktif = true;
if (isset($_GET['RuanganM'])) {
    $modRuangan->attributes = $_GET['RuanganM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'ruanganpenyebab-m-grid',
    'dataProvider' => $modRuangan->searchDialog(),
    'filter' => $modRuangan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                $attr = CJSON::encode($data->attributes);
                return CHtml::link('<i class="icon-form-check"></i>', '#', array(
                            'class' => 'btn-small',
                            'id' => 'selectRuangan',
                            'onclick' => " $('#InsidenrsT_ruanganpenyebab_id').val($data->ruangan_id);
                                           $('#InsidenrsT_ruanganpenyebab_nama').val('$data->ruangan_nama');
                                           refreshDialogPenyebab(); 
                                           $('#dialogRuanganPenyebab').dialog('close'); return false;"
                ));
            },
        ),
        'ruangan_nama',
        array(
            'header' => 'Instalasi',
            'type' => 'raw',
            'filter' => CHtml::activeDropDownList($modRuangan, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll(array(
                                'condition' => 'instalasi_aktif = true',
                                'order' => 'instalasi_nama asc',
                            )), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                echo $data->instalasi_nama; 
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )
);
$this->endWidget();
?>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogUnitKerjaPenyebab',
    'options' => array(
        'title' => 'Daftar Unit Kerja Penyebab',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 660,
        'resizable' => false,
    ),
));
?>
<?php
$modUnit = new UnitkerjaruanganM('search');
$modUnit->unsetAttributes();
if (isset($_GET['UnitkerjaruanganM'])) {
    $modUnit->attributes = $_GET['UnitkerjaruanganM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'unitkerjapenyebab-m-grid',
    'dataProvider' => $modUnit->searchUnitKerjaRuangan(),
    'filter' => $modUnit,
    'template'=>"{summaryNonPage}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                $attr = CJSON::encode($data->attributes);
                $modUnit = UnitkerjaM::model()->findByPk($data->unitkerja_id); 
                $kepala_unit = "";
                $kepala_unit = !empty($modUnit->kepalaunitpeg_id) ? $modUnit->kepalaunitkerja->namaLengkap : null;
                return CHtml::link('<i class="icon-form-check"></i>', '#', array(
                            'class' => 'btn-small',
                            'id' => 'selectRuangan',
                            'onclick' => " $('#InsidenrsT_unitkerjapenyebab_id').val($data->unitkerja_id);
                                           $('#InsidenrsT_unitkerjapenyebab_nama').val('$modUnit->namaunitkerja');
                                           $('#InsidenrsT_mengetahui_kepalaunitpenyebab_id').val('$modUnit->kepalaunitpeg_id');
                                           $('#InsidenrsT_mengetahui_kepalaunitpenyebab_nama').val('$kepala_unit');
                                           $('#dialogUnitKerjaPenyebab').dialog('close'); return false;"
                ));
            },
        ),
        array(
            'header' => 'Unit Kerja',
            'type' => 'raw',
            'filter' => CHtml::activeHiddenField($modUnit, 'ruangan_id', array('class' => 'ruangan_id'))
                        . CHtml::activeDropDownList($modUnit, 'unitkerja_id', CHtml::listData(UnitkerjaM::model()->findAll(array(
                                'condition' => 'unitkerja_aktif = true',
                                'order' => 'namaunitkerja asc',
                            )), 'unitkerja_id', 'namaunitkerja'), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                echo $data->unitkerja->namaunitkerja; 
            },
        ),
        array(
            'header' => 'Kepala Unit Kerja',
            'type' => 'raw',
            'value' => function($data){
                $modUnit = UnitkerjaM::model()->findByPk($data->unitkerja_id);
                if (!empty($modUnit->kepalaunitpeg_id)) {
                    echo $modUnit->kepalaunitkerja->namaLengkap; 
                } else {
                    echo "-";
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )
);
$this->endWidget();
?>


<?php 

    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogPetugas',
            'options'=>array(
                'title'=>'Pencarian Petugas <span id="judul-petugas"></span>' ,
                'autoOpen'=>false,
                'width' => 760,
                'height' => 600,
                'resizable' => true,
            ),
        )
    );
        	        
    $format = new MyFormatter();
    $pegPengirim=new PegawaiV;
    $pegPengirim->default = 'ada';
    
    if(isset($_GET['PegawaiV'])){
            $pegPengirim->attributes=$_GET['PegawaiV'];            
            $pegPengirim->default=isset($_GET['PegawaiV']['default'])?$_GET['PegawaiV']['default']:null;            
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'dialog-pegawai-grid',
            'dataProvider'=>$pegPengirim->searchAllPegawai(),
            'filter'=>$pegPengirim,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-bordered table-condesed',
                'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>function($data) {
                            $res['pegawai_id'] = $data->pegawai_id;
                            $res['namaLengkap'] = $data->namaLengkap;
                            $res = json_encode($res);
                                   
                            return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>',"#",array("class"=>"btn-small", 
                                        "onclick" => " setPetugas(".$res."); return false; "));
                        },
                    ),
                    array(
                        'header' => 'NIP',
                        'name'=>'nomorindukpegawai',                        
                        'value'=>'$data->nomorindukpegawai',
                    ),                                 
                    array(
                        'header' => 'Nama Petugas',
                        'name'=>'nama_pegawai',
                        'value'=>'$data->namaLengkap',
                    ),                    
                    array(
                        'header' => 'Jabatan',
                        'name'=>'jabatan_id',
                        'type' => 'raw',
                        'value'=>'$data->jabatan_nama',
                        'filter' => CHtml::activeDropDownList($pegPengirim, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
                    ),
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
			
    $this->endWidget('zii.widgets.jui.CJuiDialog');   
    
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogPetugasPenyebab',
            'options'=>array(
                'title'=>'Pencarian Petugas <span id="judul-petugas-penyebab"></span>' ,
                'autoOpen'=>false,
                'width' => 760,
                'height' => 600,
                'resizable' => true,
            ),
        )
    );
        	        
    $format = new MyFormatter();
    $pegPengirim=new PegawaiV;
    $pegPengirim->default = 'ada';
    
    if(isset($_GET['PegawaiV'])){
            $pegPengirim->attributes=$_GET['PegawaiV'];            
            $pegPengirim->default=isset($_GET['PegawaiV']['default'])?$_GET['PegawaiV']['default']:null;            
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'dialog-pegawai-penyebab-grid',
            'dataProvider'=>$pegPengirim->searchAllPegawai(),
            'filter'=>$pegPengirim,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-bordered table-condesed',
                'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>function($data) {
                            $res['pegawai_id'] = $data->pegawai_id;
                            $res['namaLengkap'] = $data->namaLengkap;
                            $res = json_encode($res);
                                   
                            return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>',"#",array("class"=>"btn-small", 
                                        "onclick" => " setPetugasPenyebab(".$res."); return false; "));
                        },
                    ),
                    array(
                        'header' => 'NIP',
                        'name'=>'nomorindukpegawai',                        
                        'value'=>'$data->nomorindukpegawai',
                    ),                                 
                    array(
                        'header' => 'Nama Petugas',
                        'name'=>'nama_pegawai',
                        'value'=>'$data->namaLengkap',
                    ),                    
                    array(
                        'header' => 'Jabatan',
                        'name'=>'jabatan_id',
                        'type' => 'raw',
                        'value'=>'$data->jabatan_nama',
                        'filter' => CHtml::activeDropDownList($pegPengirim, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
                    ),
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
			
    $this->endWidget('zii.widgets.jui.CJuiDialog');   

//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogKepalaInstalasiKejadian',
    'options' => array(
        'title' => 'Pencarian Kepala Instalasi',
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
    $modPegawaiMengetahui->pegawai_aktif = true;
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'kepalainstalasi-kejadian-grid',
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
                                                  $(\"#InsidenrsT_mengetahui_kepalainstalasi_kejadian_id\").val(\"$data->pegawai_id\");
                                                  $(\"#InsidenrsT_mengetahui_kepalainstalasi_kejadian_nama\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogKepalaInstalasiKejadian\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'filter' => CHtml::activeTextField($modPegawaiMengetahui, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
            'value' => '$data->namaLengkap',
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
    'id' => 'dialogKepalaInstalasiPenyebab',
    'options' => array(
        'title' => 'Pencarian Kepala Instalasi',
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
    $modPegawaiMengetahui->pegawai_aktif = true;
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'kepalainstalasi-penyebab-grid',
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
                                                  $(\"#InsidenrsT_mengetahui_kepalainstalasi_penyebab_id\").val(\"$data->pegawai_id\");
                                                  $(\"#InsidenrsT_mengetahui_kepalainstalasi_penyebab_nama\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogKepalaInstalasiPenyebab\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'filter' => CHtml::activeTextField($modPegawaiMengetahui, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
            'value' => '$data->namaLengkap',
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