<div class="row-fluid">
    <div class="col-sm-12">
        <table id="tabelTimTeknis" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th style="text-align: center">No.</th>
                    <th style="text-align: center">Nama Tim Teknis <span class="required">*</span> </th>
                    <th style="text-align: center">NIP </th>
                    <th style="text-align: center">Jabatan <span class="required">*</span> </th>
                    <th style="text-align: center" class="aksi"> Aksi </th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialog1',
    'options' => array(
        'title' => 'Pencarian Pegawai Tim Teknis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modTimteknis = new PejabatpengadaanM('search');
$modTimteknis->default = 'ada';
if (isset($_GET['PejabatpengadaanM'])) {
    $modTimteknis->attributes = $_GET['PejabatpengadaanM'];
    $modTimteknis->nomorindukpegawai = isset($_GET['PejabatpengadaanM']['nomorindukpegawai']) ? $_GET['PejabatpengadaanM']['nomorindukpegawai'] : null;
    $modTimteknis->nama_pegawai = isset($_GET['PejabatpengadaanM']['nama_pegawai']) ? $_GET['PejabatpengadaanM']['nama_pegawai'] : null;
    $modTimteknis->namaunitkerja = isset($_GET['PejabatpengadaanM']['namaunitkerja']) ? $_GET['PejabatpengadaanM']['namaunitkerja'] : null;
    $modTimteknis->jabatan_nama = isset($_GET['PejabatpengadaanM']['jabatan_nama']) ? $_GET['PejabatpengadaanM']['jabatan_nama'] : null;
    $modTimteknis->default = isset($_GET['PejabatpengadaanM']['default']) ? $_GET['PejabatpengadaanM']['default'] : null;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pejabatpa-m-grid',
    'dataProvider' => $modTimteknis->searchDialogTimteknis(),
    'filter' => $modTimteknis,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::Link("<i class=\"icon-form-check\"></i>", "", array("class" => "btn-small",
                            "id" => "selectPegawai",
                            "href" => "",
                            "onClick" => "
                                setPegawaiDialog(" . $data->pegawai_id . ");
                                $('#dialog1').dialog('close');    
                                return false;
                            "));
            }
        ),
        array(
            'header' => 'NIP',
            'filter' => CHtml::activeTextField($modTimteknis, 'nomorindukpegawai'),
            'value' => '$data->pegawai->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modTimteknis, 'nama_pegawai'),
            'value' => '$data->pegawai->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'filter' => CHtml::activeTextField($modTimteknis, 'jabatan_nama'),
            'value' => function($data) {
                if (empty($data->pegawai->jabatan_id))
                    return "-";
                $jabatan = JabatanM::model()->findByPk($data->pegawai->jabatan_id);
                return $jabatan->jabatan_nama;
            },
        ),
        array(
            'header' => 'Unit Kerja',
            'filter' => CHtml::activeTextField($modTimteknis, 'namaunitkerja'),
            'value' => function($data) {
                $j = UnitkerjaM::model()->findByPk($data->pegawai->unitkerja_id);

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

$this->endWidget();
?>