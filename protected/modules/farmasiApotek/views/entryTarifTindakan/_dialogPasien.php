
<?php
//========= Dialog buat cari data pendaftaran =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
$modDialogPasien = new FAPasienM('searchDialogKunjungan');
$modDialogPasien->unsetAttributes();
$modDialogPasien->idInstalasi = Params::INSTALASI_ID_RJ;
if (isset($_GET['FAPasienM'])) {
    $modDialogPasien->attributes = $_GET['FAPasienM'];
    $modDialogPasien->idInstalasi = $_GET['FAPasienM']['idInstalasi'];
    $modDialogPasien->jeniskelamin = isset($_GET['FAPasienM']['jeniskelamin']) ? $_GET['FAPasienM']['jeniskelamin'] : '';
    $modDialogPasien->no_pendaftaran = (isset($_GET['FAPasienM']['no_pendaftaran']) ? $_GET['FAPasienM']['no_pendaftaran'] : "");
    $modDialogPasien->no_rekam_medik = (isset($_GET['FAPasienM']['no_rekam_medik']) ? $_GET['FAPasienM']['no_rekam_medik'] : "");
    $modDialogPasien->nama_pasien = (isset($_GET['FAPasienM']['nama_pasien']) ? $_GET['FAPasienM']['nama_pasien'] : "");
    $modDialogPasien->carabayar_nama = (isset($_GET['FAPasienM']['carabayar_nama']) ? $_GET['FAPasienM']['carabayar_nama'] : "");
    $modDialogPasien->ruangan_nama = (isset($_GET['FAPasienM']['ruangan_nama']) ? $_GET['FAPasienM']['ruangan_nama'] : "");
}

$cr = new CDbCriteria();
if (!empty($modDialogPasien->idInstalasi)) {
    $cr->addCondition("instalasi_id = $modDialogPasien->idInstalasi");
}
$cr->order = 'ruangan_nama';
$r1 = RuanganM::model()->findAll($cr);

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pendaftaran-t-grid',
    'dataProvider' => $modDialogPasien->searchPasienRumahsakitV(),
    'filter' => $modDialogPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {

                $res = CJSON::encode(Yii::app()->controller->getJsonKunjungan($data));


                return CHtml::Link('<i class="icon-form-check"></i>', 'javascript:void(0);', array(
                    'class' => 'btn-small',
                    'id' => 'selectPendaftaran',
                    'onClick' => 'isiDataPasien(' . $res . ');  $("#dialogPasien").dialog("close"); return false;'
                ));
            },
        ),
        array(
            'name' => 'no_pendaftaran',
            'type' => 'raw',
            'value' => '$data->no_pendaftaran',
            'filter' => Chtml::activeTextField($modDialogPasien, 'no_pendaftaran', array('class' => 'angkahuruf-only'))
        ),
        array(
            'name' => 'no_rekam_medik',
            'type' => 'raw',
            'value' => '$data->no_rekam_medik',
            'filter' => Chtml::activeTextField($modDialogPasien, 'no_rekam_medik', array('class' => 'numbers-only'))
        ),
        array(
            'name' => 'nama_pasien',
            'type' => 'raw',
            'value' => '$data->namadepan." ".$data->nama_pasien',
            'filter' => Chtml::activeTextField($modDialogPasien, 'nama_pasien', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => CHtml::dropDownList('FAPasienM[jeniskelamin]', $modDialogPasien->jeniskelamin, LookupM::getItems('jeniskelamin'), array('empty' => '-- Pilih --')) .
                CHtml::activeHiddenField($modDialogPasien, 'idInstalasi'),
        ),
        array(
            'name' => 'tgl_pendaftaran',

            'filter' => false,
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran);'
            //CHtml::activeTextField($modDialogPasien, 'tgl_pendaftaran_cari', array('placeholder'=>'contoh: 15 Jan 2013')),
        ),
        array(
            'header' => 'Ruangan',
            'name' => 'ruangan_nama',
            'type' => 'raw',
            'filter' => CHtml::activeDropDownList($modDialogPasien, 'ruangan_nama', CHtml::listData(
                RuanganM::model()->findAllByAttributes(array(
                    'instalasi_id' => $modDialogPasien->idInstalasi,
                    'ruangan_aktif' => true,
                ), array('order' => 'ruangan_nama')),
                'ruangan_nama',
                'ruangan_nama'
            ), array(
                'empty' => '-- Pilih --',
            )),
        ),
        array(
            'header' => 'Jenis Penjamin',
            'name' => 'carabayar_id',
            'type' => 'raw',
            'value' => '$data->carabayar_nama',
            'filter' =>  CHtml::dropDownList('FAPasienM[carabayar_id]', $modDialogPasien->carabayar_id, CHtml::listData(CarabayarM::model()->findAll("carabayar_aktif = TRUE ORDER BY carabayar_nama ASC"), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --'))
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function() {
                setNumbersOnly(this);
            });
            $(".hurufs-only").keyup(function() {
                setHurufsOnly(this);
            });
            $(".angkahuruf-only").keyup(function() {
                setAngkaHurufOnly(this);
            });'
        . '}',
));

$this->endWidget();
////======= end pendaftaran dialog =============
?>