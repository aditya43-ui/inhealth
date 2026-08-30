<?php
//========= Dialog buat cari data Keperawatan =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDPJP',
    'options' => array(
        'title' => 'Pencarian Data DPJP',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 540,
        'resizable' => false,
    ),
));
$pegawai = new PegawairuanganV();
$pegawai->unsetAttributes();
$pegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
$pegawai->kelompokpegawai_id = 1;
if (isset($_GET['PegawairuanganV'])) {
    $pegawai->attributes = $_GET['PegawairuanganV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'timmedik-t-grid',
    'dataProvider' => $pegawai->search(),
    'filter' => $pegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPendaftaran",
                                        "onClick" => "
                                            $(\"#BDSeleksipendonorT_dpjpkuesioner_id\").val(\"$data->pegawai_id\"); 
                                            $(\"#BDSeleksipendonorT_dpjpkuesioner_nama\").val(\"$data->nama_pegawai\");
                                            $(\"#dialogDPJP\").dialog(\"close\");
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'filter' => Chtml::activeTextField($pegawai, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'name' => 'nama_pegawai',
            'header' => 'Nama DPJP',
            'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
            'filter' => Chtml::activeTextField($pegawai, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>