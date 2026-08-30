<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Pemesanan Kantong Darah
        </div>
    </div>
    <div class="panel-body" style="overflow-y: auto;">
        <?php echo CHtml::hiddenField('no_row', '', array('readonly' => true)); ?>

        <table id="table-detailbarang" class="table table-striped table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Nomor Kantong</th>
                    <th>Jenis Darah</th>
                    <?php /*
                    <th colspan="5" style="text-align: center;">Pemeriksaan Goldar Metode Slide Test</th>
                    <th colspan="6" style="text-align: center;">Hasil Uji Silang Serasi</th>
                     * 
                     */ ?>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php

                if (!empty($modPermintaanDetail)) {
                    foreach ($modPermintaanDetail as $data) {
                        $modPengujianDarah = new BDPengujiandarahT();
                        $modUjiKompatibilitas = new BDUjikompatibilitasT();
                        $modUjiKompatibilitas->permintaandarahdet_id = $data->permintaandarahdet_id;
                        $modUjiKompatibilitas->singkatan_komp = isset($data->singkatan_komp) ? $data->singkatan_komp : " ";

                        echo $this->renderPartial($this->path_view . 'form/ajaxLoadAset', array(
                            'modPengujianDarah' => $modPengujianDarah,
                            'modUjiKompatibilitas' => $modUjiKompatibilitas
                        ), true);
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

</div>

<?php
/* ========= Dialog buat cari Kantong Darah ========================= */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogKantongDarah',
    'options' => array(
        'title' => 'Daftar Kantong Darah',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'resizable' => false,
    ),
));

$modKantong = new BDInfostokkantongdarahV('searchDialogPengujianKompatibilitas');
$modKantong->unsetAttributes();
if (isset($_GET['BDInfostokkantongdarahV'])) {
    $modKantong->attributes = $_GET['BDInfostokkantongdarahV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'kantong-m-grid',
    'dataProvider' => $modKantong->searchDialogPengujianKompatibilitas(),
    'filter' => $modKantong,
    'template' => "{summary}\n{items}{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                $res = CJSON::encode($data->attributes);

                return CHtml::Link("<i class='icon-form-check'></i>", "#", array(
                    "class" => "btn-small",
                    "id" => "selectBahan",
                    "onClick" => "
                                    setKantong(" . $res . ");
                                    $('#dialogKantongDarah').dialog('close');
                                    $('#BDPasienM_alamat_pasien').blur();
                                    return false;"
                ));
            },
        ),
        array(
            'header' => 'Nomor Kantong Darah',
            'name' => 'no_kantongdarah',
            'value' => '$data->no_kantongdarah',
        ),
        array(
            'header' => 'Golongan Darah',
            'name' => 'gol_darah',
            'value' => '$data->gol_darah',
            'filter' => CHtml::activeHiddenField($modKantong, 'singkatan_komp') . "" . CHtml::activeDropDownList($modKantong, 'gol_darah', LookupM::getItems('golongandarah'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Rhesus',
            'name' => 'rhesus',
            'value' => '$data->rhesus',
        ),
        array(
            'header' => 'Jenis Kantong',
            'name' => 'nama_jenis',
            'value' => '$data->nama_jenis',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});cekStok();}',
));

echo "<div id='note-stok' style='color:red;' ></div>";

$this->endWidget();
?>