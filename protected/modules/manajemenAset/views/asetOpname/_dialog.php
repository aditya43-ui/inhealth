

<?php

//========= Dialog buat cari data Alat Kesehatan ala cak lontong (non racik - therapi obat)  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogMesin',
    'options' => array(
        'title' => 'Daftar Aset',
        'autoOpen' => false,
//        'position' => ['top', 20],
        'modal' => true,
        'width' => 550,
        'height' => 600,
        'resizable' => false,
    ),
));

$modInv = new InvperalatanT('searchDialog');
if (isset($_GET['InvperalatanT'])) {
    $modInv->attributes = $_GET['InvperalatanT'];    
    $modInv->default = isset($_GET['InvperalatanT']['default'])?$_GET['InvperalatanT']['default']:null;
    $modInv->lokasiaset_namalokasi = isset($_GET['InvperalatanT']['lokasiaset_namalokasi'])?$_GET['InvperalatanT']['lokasiaset_namalokasi']:null;
    $modInv->periodeasetopname_id = isset($_GET['InvperalatanT']['periodeasetopname_id'])?$_GET['InvperalatanT']['periodeasetopname_id']:null;
}
$modInv->load_belum_aset_opname = true;

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'mesinpengemasan-m-grid',
    'dataProvider' => $modInv->searchDialogInvPeralatan(),
    'filter' => $modInv,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                $dt = $data->attributes;
                $dt['barang_dan_kode'] = $data->invperalatan_kode.' - '.$data->invperalatan_namabrg;
                $res = json_encode($dt);
                
                return CHtml::Link("<i class=\"icon-form-check\"></i>", "javascript:;", array("class" => "btn-small",
                            "id" => "selectObat",
                            "onClick" => "
                                                setMesin(" . $res . ")
                                                return false;"));
            },
        ),
        [
            'header' => 'Kode',
            'name' => 'invperalatan_kode',
        ],
        [
            'header' => 'Nama Aset',
            'name' => 'invperalatan_namabrg',
        ],
         [
            'header' => 'Merk',
            'name' => 'invperalatan_merk',
        ],
        [
            'header' => 'Lokasi Aset',
            'name' => 'lokasiaset_namalokasi'
        ]
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
