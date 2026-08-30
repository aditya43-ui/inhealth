<div class="panel_dialog_cari dialog_pasien">
<?php

$modPasien = new InfokunjunganrdV('searchDialogKunjungan');
$modPasien->unsetAttributes();
$modPasien->instalasi_id = Params::INSTALASI_ID_RJ;
$modPasien->tgl_pencarian = date('m/d/Y', strtotime('-3 months')) . ' - ' . date('m/d/Y');
$modPasien->default = 'kosong';

if (isset($_GET['InfokunjunganrdV'])) {
    $modPasien->attributes = $_GET['InfokunjunganrdV'];
    $modPasien->tgl_pencarian = isset($_GET['InfokunjunganrdV']['tgl_pencarian'])?$_GET['InfokunjunganrdV']['tgl_pencarian']:null;
    $modPasien->default = isset($_GET['InfokunjunganrdV']['default'])?$_GET['InfokunjunganrdV']['default']:null;
    $modPasien->instalasi_id = isset($_GET['InfokunjunganrdV']['instalasi_id'])?$_GET['InfokunjunganrdV']['instalasi_id']:null;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'datakunjungan-grid',
    'dataProvider' => $modPasien->searchDialogKunjunganForSRK(),
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
                    setNomorDanCariRiwayatSEP(".$data->pendaftaran_id.", '".$asuransi->nokartuasuransi."');
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
<div class="panel_dialog_cari dialog_sep" style="display: none;">
    <table class="table table-bordered table-condensed tab_riwayat_base">
        <thead>
            <tr>
                <th>Pilih</th>
                <th>No. Sep</th>
                <th>Tgl. Sep</th>
                <th>No. Kartu dan Nama Peserta</th>
                <th>No. Rujukan</th>
                <th>Diagnosa</th>
                <th>Poliklinik</th>
            </tr>
        </thead>
        <tbody class="tab_riwayat_sep">

        </tbody>
    </table>
</div>

<script>

    function setNomorDanCariRiwayatSEP(pendaftaran_id, no_kartu) {
        var_pendaftaran_id = pendaftaran_id;

        $(".panel_dialog_cari").hide();
        $(".dialog_sep").show();

        $(".tab_riwayat_sep").empty();
        $(".tab_riwayat_base").addClass('animation-loading');

        $.post('<?php echo $this->createUrl('getLoadRiwayatSEP'); ?>', {
            nokartu: no_kartu,
            id: pendaftaran_id
        }, function(data) {
            if (data.ok != 1) {
                myAlert(data.msg);
            } else {
                $(".tab_riwayat_sep").html(data.html);
            }
            $(".tab_riwayat_base").removeClass('animation-loading');
        }, 'json');
    }

    function setTampilPilihPasien() {
        $(".panel_dialog_cari").hide();
        $(".dialog_pasien").show();
    }

</script>