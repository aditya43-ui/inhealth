<div class="panel_dialog_cari dialog_pasien">
<?php

$modPasien = new InfokunjunganrdV('searchDialogKunjungan');
$modPasien->unsetAttributes();
$modPasien->instalasi_id = Params::INSTALASI_ID_RJ;
$modPasien->tgl_pencarian = date('m/d/Y') . ' - ' . date('m/d/Y');
$modPasien->default = 'kosong';

if (isset($_GET['InfokunjunganrdV'])) {
    $modPasien->attributes = $_GET['InfokunjunganrdV'];
    $modPasien->tgl_pencarian = isset($_GET['InfokunjunganrdV']['tgl_pencarian'])?$_GET['InfokunjunganrdV']['tgl_pencarian']:null;
    $modPasien->default = isset($_GET['InfokunjunganrdV']['default'])?$_GET['InfokunjunganrdV']['default']:null;
    $modPasien->instalasi_id = isset($_GET['InfokunjunganrdV']['instalasi_id'])?$_GET['InfokunjunganrdV']['instalasi_id']:null;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'datakunjungan-grid',
    'dataProvider' => $modPasien->searchDialogKunjunganForSinkronSEP(),
    'filter' => $modPasien,
    'template' => "{summaryNonPage}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                $daftar = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                $asuransi = AsuransipasienM::model()->findByPk($daftar->asuransipasien_id);

                if (empty($asuransi)) {
                    return "-";
                }

                // return $asuransi->nokartuasuransi;

                return CHtml::Link('<i class="icon-form-check"></i>',"javascript:void(0);",array("class"=>"btn-small", 
                "id" => "selectPendaftaran",
                "onClick" => "
                    setInfoPasien(".$data->pendaftaran_id.", '".$asuransi->nokartuasuransi."');
                    $(\"#dialogPasien\").dialog(\"close\");
                ",
                //"onClick" => "
                //    setInfoPasien(".$data->pendaftaran_id.");
                //    $(\"#dialogPasien\").dialog(\"close\");
                //",
                ));
            },
        ),
        'no_pendaftaran',
        array(
            'header' => 'Tanggal Pendaftaran / Masuk Kamar',
            'type' => 'raw',            
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',            
            'htmlOptions' => array('width' => '150px', 'style' => 'text-align:center'),
            'filter' =>
            CHtml::activeTextField($modPasien, 'tgl_pencarian', array('class' => 'span3', 'readonly' => true)),      
        ),
        array(
            'name' => 'no_rekam_medik',
            'type' => 'raw',
            'value' => '$data->no_rekam_medik',
        ),
        'nama_pasien',
        array(
            'name' => 'jeniskelamin',
            'type' => 'raw',
            'filter' => LookupM::model()->getItems('jeniskelamin'),
        ),
        array(
            'name' => 'instalasi_id',
            'value' => '$data->instalasi_nama',
            'type' => 'raw',
            'filter' => CHtml::activeHiddenField($modPasien, 'instalasi_id') . CHtml::activeTextField($modPasien, 'instalasi_nama'),
        ),
        array(
            'name' => 'ruangan_nama',
            'type' => 'raw',
        ),
        array(
            'name' => 'carabayar_nama',
            'type' => 'raw',
            'value' => '$data->carabayar_nama',
        ),
        array(
            'name' => 'alamat_pasien',
            'type' => 'raw',
            'value' => '$data->alamat_pasien',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
            setPickerRangeTanggal();
    }',
));

?>
</div>


