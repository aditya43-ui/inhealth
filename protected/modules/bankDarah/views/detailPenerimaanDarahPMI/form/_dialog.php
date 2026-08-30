<?php
//========= Dialog untuk ....  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog_penerimaan',
    'options' => array(
        'title' => 'Penerimaan Darah PMI',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

$modTerima = new BDPenerimaandarahpmiT('searchDialogDetail');
$modTerima->unsetAttributes();
if (isset($_GET['BDPenerimaandarahpmiT'])) {
    $modTerima->attributes = $_GET['BDPenerimaandarahpmiT'];
    $modTerima->petugas_penerima_nama = isset($_GET['BDPenerimaandarahpmiT']['petugas_penerima_nama'])? $_GET['BDPenerimaandarahpmiT']['petugas_penerima_nama'] : "";
    $modTerima->petugas_mengetahui_nama = isset($_GET['BDPenerimaandarahpmiT']['petugas_mengetahui_nama'])? $_GET['BDPenerimaandarahpmiT']['petugas_mengetahui_nama'] : "";
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'drafter-grid',
    'dataProvider' => $modTerima->searchDialogDetail(),
    'filter' => $modTerima,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                $petugas_penerima_nama = "";
                $petugas_mengetahui_nama = "";
                if (!empty($data->petugas_penerima_id)) {
                    $petugas_penerima_nama = PegawaiM::model()->findByPk($data->petugas_penerima_id)->nama_pegawai;
                }
                if (!empty($data->petugas_mengetahui_id)) {
                    $petugas_mengetahui_nama = PegawaiM::model()->findByPk($data->petugas_mengetahui_id)->nama_pegawai;
                }
                return CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectItem",
                "onClick" => "
                    $(\".penerimaandarahpmi_id\").val(".$data->penerimaandarahpmi_id.");
                    $(\".no_penerimaan\").val(\"".$data->no_penerimaan."\");
                    $(\".petugas_penerima_nama\").val(\"".$petugas_penerima_nama."\");
                    $(\".petugas_mengetahui_nama\").val(\"".$petugas_mengetahui_nama."\");
                    $(\".tgl_penerimaan\").val(\"".$data->tgl_penerimaan."\");
                    $(\".keterangan_penerimaan\").val(\"".$data->keterangan_penerimaan."\");
                    setDetailPenerimaan(".$data->penerimaandarahpmi_id.");
                    $(\"#dialog_penerimaan\").dialog(\"close\");
                    return false;"));
            },
        ),
        'no_penerimaan',
        array(
            'name'=>'tgl_penerimaan',
            'type'=>'raw',
            'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_penerimaan)',
            'filter'=>false,
        ),
        array(
            'name'=>'petugas_penerima_nama',
            'type'=>'raw',
            'value'=>function($data) {
                if (empty($data->petugas_penerima_id)) {
                    return "-";
                }else{
                    $peg = PegawaiM::model()->findByPk($data->petugas_penerima_id);
                    return $peg->nama_pegawai;
                }
            }
        ),
        array(
            'name'=>'petugas_mengetahui_nama',
            'type'=>'raw',
            'value'=>function($data) {
                if (empty($data->petugas_mengetahui_id)) {
                    return "-";
                }else{
                    $peg = PegawaiM::model()->findByPk($data->petugas_mengetahui_id);
                    return $peg->nama_pegawai;
                }
            }
        )
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>