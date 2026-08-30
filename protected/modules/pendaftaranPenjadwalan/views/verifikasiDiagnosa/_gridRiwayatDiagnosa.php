<?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftarpasien-v-grid',
    'dataProvider' => $modRiwayat->searchRiwayatDiagnosa(),
    'template' => "{summary}\n{items}\n{pager}",
    "replaceUrl" => true,
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => [
        [
            'header' => 'No',
            'value' => '$row+1',
        ],  [
            'header' => 'Tanggal Pendaftaran',
            'value' => function ($data) {
                return date('d M Y', strtotime($data->pendaftaran->tgl_pendaftaran));
            }
        ],
        [
            'header' => 'Tanggal Diagnosa',
            'value' => function ($data) {
                return MyFormatter::formatDateTimeForUser($data->tglmorbiditas);
            }
        ],
        [
            'header' => 'Nama Dokter',
            'value' => function ($data) {
                return !empty($data->pegawai_id) ? $data->pegawai->namaLengkap : "";
            }
        ],
        [
            'header' => 'Ruangan',
            'type' => 'raw',
            'value' => function ($data) {
                return !empty($data->ruangan_id) ? $data->ruangan->ruangan_nama : "";
            }
        ],
        [
            'header' => 'PPDS',
            'type' => 'raw',
            'value' => function ($data) {
                return !empty($data->ppds_id) ? $data->ppds->ppds_nama : "";
            }
        ],
        [
            'header' => 'Lihat detail',
            'type' => 'raw',
            'value' => function ($data) {
                return "<center>" . CHtml::link("<i class='icon-eye-open'></i>", '#', array('onclick' => 'viewDetailDiagnosa("' . $data->pasienmorbiditas_id . '","' . $data->pendaftaran_id . '");return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk melihat detail diagnosa'));
            }
        ],
        [
            'header' => 'Riwayat',
            'type' => 'raw',
            'value' => function($data) {
                return "<center>" . CHtml::link("<i class='entypo-eye'></i>", '#', array('onclick' => 'viewDetailRiwayatDiagnosa("' . $data->pendaftaran_id . '");return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk melihat detail riwayat diagnosa'));
            }
        ],
        /*
        [
            'header' => 'Salin',
            'type' => 'raw',
            'value' => function ($data) {
                //if($_GET['pendaftaran_id'] != $data->pendaftaran_id){
                    // return "<center>" . CHtml::link("<i class='fa fa-copy'></i>", $this->createUrl('index', array('pendaftaran_id' => $_GET['pendaftaran_id'],'salin' => $data->pendaftaran_id)), array('rel' => 'tooltip', 'title' => 'Klik untuk melihat salin diagnosa'));
                //}else{
                    return "<center>" . CHtml::link("<i class='fa fa-copy'></i>", '', array('rel' => 'tooltip', 'title' => 'Klik untuk melihat salin diagnosa', 'onClick' => "window.parent.myAlert('Diagnosa sudah ada di tabel diagnosa.', 'Perhatian!')"));
                //}

            }
        ],*/
    ],
    'afterAjaxUpdate' => 'function(id, data){
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
        disableLink();}',
    )); 
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogDetailDiagnosa',
    'options'=>array(
        'title'=>'Detail Diagnosa',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1002,
        'width'=>800,
        'resizable'=>false,
        'position'=>'top',
    ),
));

echo '<div id="contentDetailDiagnosa"></div>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogDetailRiwayatDiagnosa',
    'options'=>array(
        'title'=>'Detail Riwayat Diagnosa',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1002,
        'width'=>800,
        'resizable'=>false,
        'position'=>'top',
    ),
));

echo '<div id="contentDetailRiwayatDiagnosa"></div>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<script>
    function viewDetailDiagnosa(pasienmorbiditas_id,pendaftaran_id){

    $.post('<?php echo $this->createUrl('ajaxDetailDiagnosa') ?>', {
        pasienmorbiditas_id: pasienmorbiditas_id, 
        pendaftaran_id: pendaftaran_id
    }, function(data){
        $('#contentDetailDiagnosa').html(data.result);
    }, 'json');
        $('#dialogDetailDiagnosa').dialog('open');
    }

    function viewDetailRiwayatDiagnosa(pendaftaran_id) {
        $.post('<?php echo $this->createUrl('ajaxDetailRiwayatDiagnosa') ?>', {
            pendaftaran_id: pendaftaran_id
        }, function(data){
            $('#contentDetailRiwayatDiagnosa').html(data.result);
        }, 'json');
        $('#dialogDetailRiwayatDiagnosa').dialog('open');
    }
    

    /**
     * Fungsi copy resep 
     */
    const copy_resep = (penjualanresep_id) => {
        var hitung = 0;
        $('#table-obatalkespasien > tbody > tr').each(function() {
            var det_id = $(this).find('.penjualanresep_id').val();
            if (penjualanresep_id == det_id) {
                hitung++;
            }
        });

        if (hitung >= 1) {
            myAlert("Data Penjualan Resep sudah ada di tabel. Silahkan pilih yang lain.", "Perhatian!");
            return false;
        }

        $.ajax({
            type: 'POST',
            url: '<?php //echo $this->createUrl('copyResep'); ?>',
            data: {
                penjualanresep_id: penjualanresep_id
            }, //
            dataType: "json",
            success: function(data) {
                $('#table-obatalkespasien > tbody').append(data.tr);
                renameInputRowObatAlkes($("#table-obatalkespasien"));

                var row = 0;

                $("#table-obatalkespasien").find("tbody > tr").each(function() {
                    $(this).find(".r").val(row + 1);
                    $(this).find(".rke").val(row + 1);
                    
                    row++;
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
</script>