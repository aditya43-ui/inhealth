<?php
//========= Dialog Detail Asesmen Nyeri =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAsesmennyeri',
    'options' => array(
        'title' => 'Data Asesmen Nyeri',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1160,
        'height' => 600,
        'resizable' => false,
        'close' => 'js:function(){getDataAsesmenNyeri("");}',
    ),
));
?>
<iframe id="frameAsesmenNyeri" name="pesan" width="100%" height="500">
</iframe>
<?php
$this->endWidget();
?>
<?php
//========= Dialog buat cari data Perawat 1 =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPerawat1',
    'options' => array(
        'title' => 'Pencarian Perawat 1',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 600,
        'resizable' => false,
    ),
));

$modPerawat1 = new PegawairuanganV('search');
$modPerawat1->unsetAttributes();
$modPerawat1->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['PegawairuanganV'])) {
    $modPerawat1->attributes = $_GET['PegawairuanganV'];
    $modPerawat1->nama_pegawai = $_GET['PegawairuanganV']['nama_pegawai'];
    $modPerawat1->nomorindukpegawai = $_GET['PegawairuanganV']['nomorindukpegawai'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'perawat1-m-grid',
    'dataProvider' => $modPerawat1->searchPerawatRuangan(),
    'filter' => $modPerawat1,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                        "id" => "selectDokter",
                        "href"=>"",
                        "onClick" => "
                            $(\"#MonitoringPreHdT_perawat1_id\").val(\"$data->pegawai_id\");
                            $(\"#MonitoringPreHdT_perawat1_nama\").val(\"$data->nama_pegawai\");
                            $(\"#dialogPerawat1\").dialog(\"close\");    
                            return false;
                        "))',
        ),
        'nama_pegawai',
        'nomorindukpegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Perawat 1 dialog =============================
?>
<?php
//========= Dialog buat cari data Perawat 2 =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPerawat2',
    'options' => array(
        'title' => 'Pencarian Perawat 2',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 600,
        'resizable' => false,
    ),
));

$modPerawat2 = new PegawairuanganV('search');
$modPerawat2->unsetAttributes();
$modPerawat2->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['PegawairuanganV'])) {
    $modPerawat2->attributes = $_GET['PegawairuanganV'];
    $modPerawat2->nama_pegawai = $_GET['PegawairuanganV']['nama_pegawai'];
    $modPerawat2->nomorindukpegawai = $_GET['PegawairuanganV']['nomorindukpegawai'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'perawat2-m-grid',
    'dataProvider' => $modPerawat2->searchPerawatRuangan(),
    'filter' => $modPerawat2,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                        "id" => "selectDokter",
                        "href"=>"",
                        "onClick" => "
                            $(\"#MonitoringPreHdT_perawat2_id\").val(\"$data->pegawai_id\");
                            $(\"#MonitoringPreHdT_perawat2_nama\").val(\"$data->nama_pegawai\");
                            $(\"#dialogPerawat2\").dialog(\"close\");    
                            return false;
                        "))',
        ),
        'nama_pegawai',
        'nomorindukpegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Perawat 2 dialog =============================
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDiagnosa',
    'options' => array(
        'title' => 'Daftar Diagnosis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<?php
$modDiagnosa = new DiagnosaM('search');
$modDiagnosa->unsetAttributes();
if (isset($_GET['DiagnosaM'])) {
    $modDiagnosa->attributes = $_GET['DiagnosaM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'giagnosautama-m-grid',
    'dataProvider' => $modDiagnosa->search(),
    'filter' => $modDiagnosa,
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
                            'id' => 'selectPasien',
                            'onclick' => "
                        $('#MonitoringPreHdT_diagnosa_id').val(" . $data->diagnosa_id . ");
                        $('#MonitoringPreHdT_diagnosa_nama').val('" . $data->diagnosa_nama . "');
                        $('#dialogDiagnosa').dialog('close'); return false;"
                ));
            },
        ),
        'diagnosa_kode',
        array(
            'header' => 'Diagnosis',
            'name' => 'diagnosa_nama',
            'value' => '$data->diagnosa_nama',
        ),
        array(
            'header' => 'Catatan',
            'name' => 'diagnosa_namalainnya',
            'value' => '$data->diagnosa_namalainnya',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )
);
$this->endWidget();
?>