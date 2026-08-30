<?php

/**
 * view ini digunakan untuk menampilkan data dialog
 * 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPetugas',
    'options' => array(
        'title' => 'Pencarian <span class="judul-dialog-petugas"></span>',
        'autoOpen' => false,
        'width' => 760,
        'height' => 600,
        'resizable' => true,
    ),
        )
);

$modPihak1 = new PegawaiM('search');
$modPihak1->default = 'ada';
if (isset($_GET['PegawaiM'])) {
    $modPihak1->attributes = $_GET['PegawaiM'];
    $modPihak1->nomorindukpegawai = isset($_GET['PegawaiM']['nomorindukpegawai']) ? $_GET['PegawaiM']['nomorindukpegawai'] : null;
    $modPihak1->nama_pegawai = isset($_GET['PegawaiM']['nama_pegawai']) ? $_GET['PegawaiM']['nama_pegawai'] : null;
    $modPihak1->namaunitkerja = isset($_GET['PegawaiM']['namaunitkerja']) ? $_GET['PegawaiM']['namaunitkerja'] : null;
    $modPihak1->jabatan_nama = isset($_GET['PegawaiM']['jabatan_nama']) ? $_GET['PegawaiM']['jabatan_nama'] : null;
    $modPihak1->default = isset($_GET['PegawaiM']['default']) ? $_GET['PegawaiM']['default'] : null;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pejabatpa-m-grid',
    'dataProvider' => $modPihak1->searchDialogPPHPdanPJPHP(),
    'filter' => $modPihak1,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                        "id" => "selectDokter",
                           "onClick" => "
                                $(\"#ADSuratdendaT_ketuapphp_id\").val(\"$data->pegawai_id\");
                                $(\"#ADSuratdendaT_ketuapphp_nama\").val(\"$data->nama_pegawai\");
                                $(\"#dialogPetugas\").dialog(\"close\");
                                return false;
                            "
                        ))',
        ),
        array(
            'header' => 'NIP',
            'filter' => CHtml::activeTextField($modPihak1, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPihak1, 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'filter' => CHtml::activeTextField($modPihak1, 'jabatan_nama'),
            'value' => function($data) {
                if (empty($data->jabatan_id))
                    return "-";
                $jabatan = JabatanM::model()->findByPk($data->jabatan_id);
                return $jabatan->jabatan_nama;
            },
        ),
        array(
            'header' => 'Unit Kerja',
            'filter' => CHtml::activeTextField($modPihak1, 'namaunitkerja'),
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
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>


