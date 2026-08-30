<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDokter',
    'options' => array(
        'title' => 'Daftar Dokter',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modDokter = new JadwaldoktermodV('searchDialog');
$modDokter->unsetAttributes();
if (isset($_GET['JadwaldoktermodV'])) {
    $modDokter->attributes = $_GET['JadwaldoktermodV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaiYangMengajukanPK-m-grid',
    'dataProvider' => $modDokter->searchDialog(),
    'filter' => $modDokter,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"                            
                            $(\"#' . CHtml::activeId($modPasienMasukPenunjang, 'pegawai_nama') . '\").val(\"$data->namalengkap\");                            
                            $(\"#' . CHtml::activeId($modPasienMasukPenunjang, 'pegawai_id') . '\").val(\"$data->pegawai_id\");                            
                            $(\"#dialogDokter\").dialog(\"close\");
                            return false;"
                ))'
        ),

        //'gelardepan',
        array(
            'header' => 'NIP',
            'value' => '$data->nomorindukpegawai',
            'name' => 'nomorindukpegawai',
            'filter' => Chtml::activeTextField($modDokter, 'nomorindukpegawai', array('class' => 'numbers-only')),
        ),
        array(
            'name' => 'nama_pegawai',
            'header' => 'Nama Dokter',
            'value' => '$data->namalengkap',
            'filter' => Chtml::activeTextField($modDokter, 'nama_pegawai', array('class' => 'hurufs-only')),
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function ($data) {
                echo $data->jabatan_nama;
            },
            'filter' => Chtml::activeDropDownList($modDokter, 'jabatan_id',  Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function() {
        setNumbersOnly(this);
        });
        $(".hurufs-only").keyup(function() {
        setHurufsOnly(this);
        });                '
        . '}',
));

$this->endWidget();
?>