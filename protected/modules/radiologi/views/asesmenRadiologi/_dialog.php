<?php

/**
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author Elham Budianto <elhambudianto@.com>
 * 
 * RSST-1431
 */
/** =============== TIM MEDIS ===================== * */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDPJP',
    'options' => array(
        'title' => 'Dokter/DPJP',
        'autoOpen' => false,
        'width' => 490,
        'height' => 600,
        'resizable' => true,
    ),
        )
);

$format = new MyFormatter();
$modMedis = new PegawaiV('searchDokter');
$modMedis->unsetAttributes();
if (isset($_GET['PegawaiV'])) {
    $modMedis->attributes = $_GET['PegawaiV'];
}
$modMedis->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK;
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialog-dpjp-m-grid',
    'dataProvider' => $modMedis->searchAllPegawai(),
    'filter' => $modMedis,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::Link('<i class="icon-form-check"></i>', "#", array("class" => "btn-small",
                            "onclick" => " setDokter(\"" . $data->namaLengkap . "\"," . $data->pegawai_id . "); return false; "));
            },
        ),
        array(
            'header' => 'Nama',
            //'name'=>'nama_pegawai',
            'filter' => CHtml::activeTextField($modMedis, 'nama_pegawai', array('class' => 'span3')),
            'value' => '$data->namaLengkap',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
//=============================== END TIM MEDIS =======================================
//=============================== START KEPERAWATAN =======================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPPJP',
    'options' => array(
        'title' => 'Pencarian Perawat',
        'autoOpen' => false,
        'width' => 600,
        'height' => 600,
        'resizable' => true,
    ),
        )
);

$format = new MyFormatter();
$modPerawat = new PegawaiV('searchParamedis');
if (isset($_GET['RIPegawairuanganV'])) {
    $modPerawat->attributes = $_GET['RIPegawairuanganV'];
}
$modPerawat->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN;

$provider = $modPerawat->searchAllPegawai();

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialog-keperawatan-m-grid',
    'dataProvider' => $provider,
    'filter' => $modPerawat,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::Link('<i class="icon-form-check"></i>', "#", array("class" => "btn-small",
                            "onclick" => " setPerawat(\"" . $data->namaLengkap . "\"," . $data->pegawai_id . "); return false; "));
            },
        ),
        array(
            'header' => 'Nama',
            //'name'=>'nama_pegawai',
            'filter' => CHtml::activeTextField($modPerawat, 'nama_pegawai', array('class' => 'span3')),
            'value' => '$data->namaLengkap',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
//=============================== END KEPERAWATAN =======================================
    
//========= Dialog buat Diagnosa =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'diagnosa-dialog',
    'options' => array(
        'title' => 'Pencarian Data Diagnosa',
        'autoOpen' => false,
        'position' => ['top', 10],
        'modal' => true,
        'width' => 900,
        'resizable' => false,
    ),
));

$modDiagnosa = new RIDiagnosaM('searchDiagnosis');
$modDiagnosa->unsetAttributes();
if (isset($_GET['RIDiagnosaM'])) {
    $modDiagnosa->attributes = $_GET['RIDiagnosaM'];
    $modDiagnosa->diagnosa_nama = (isset($_GET['RIDiagnosaM']['diagnosa_nama']) ? $_GET['RIDiagnosaM']['diagnosa_nama'] : "");
    $modDiagnosa->diagnosa_namalainnya = (isset($_GET['RIDiagnosaM']['diagnosa_namalainnya']) ? $_GET['RIDiagnosaM']['diagnosa_namalainnya'] : "");
    $modDiagnosa->diagnosa_kode = (isset($_GET['RIDiagnosaM']['diagnosa_kode']) ? $_GET['RIDiagnosaM']['diagnosa_kode'] : "");
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'diagnosa-m-grid',
    'dataProvider' => $modDiagnosa->searchDiagnosis(),
    'filter' => $modDiagnosa,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectDiagnosa",
                                    "onClick" => "
                                                  $(\"#diagnosa-dialog\").dialog(\"close\");    
                                                  $(\"#RIAsesmenAwalKeperawatanT_diagnosa_nama\").val(\"$data->diagnosa_nama\");  
                                                  $(\"#RIAsesmenAwalKeperawatanT_diagnosa_masuk\").val(\"$data->diagnosa_id\");
                                                  $(\"#RIAsesmenAwalMedisT_riwayat_penyakit_sekarang\").blur();
                                        "))',
        ),
        'diagnosa_kode',
        'diagnosa_nama',
        'diagnosa_namalainnya',
    // 'diagnosa_katakunci',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>