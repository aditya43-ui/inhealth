<table class="items table table-striped table-condensed" id="tblInputTindakan">
    <thead>
        <tr>
            <th>Tanggal Periksa</th>
            <th>Dokter</th>
            <th>Paramedis</th>
            <th>PPDS</th>
            <th>Lihat Detail</th>
            <th>Ubah</th>
            <th>Hapus</th>
        </tr>
    </thead>
    <?php foreach ($tabelPemeriksaan as $i => $Fisik) { ?>
        <tr>
            <?php //echo "<pre>"; print_r($format->formatDateTimeForUser($modPemeriksaanFisik->tglperiksafisik)); exit(); ?>
            <td><?php echo $format->formatDateTimeForUser($Fisik->tglperiksafisik); ?></td>
            <?php $pegawai = PegawaiM::model()->findByPk($Fisik->pegawai_id) ?>
            <td><?php echo $pegawai->nama_pegawai ?? "" ; ?></td>
           <td><?php echo $Fisik->paramedis_nama ?? ""; ?></td>
           <td><?php echo $Fisik->ppds->ppds_nama ?? "" ; ?></td>
            <td style="text-align: center; width: 60px;"><?php echo CHtml::link("<i class='icon-form-lihat'></i>", '#', array('onclick' => 'viewDetailFisik("' . $Fisik->pemeriksaanfisik_id . '","' . $_GET["pendaftaran_id"] . '");return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk melihat detail pemeriksaan fisik')); ?></td>
            <td style="text-align: center; width: 60px;"><?php echo CHtml::link("<i class='icon-form-ubah'></i>", array('pemeriksaanFisikTRI/index', 'pendaftaran_id' => $Fisik->pendaftaran_id, 'pasienadmisi_id' => $Fisik->pasienadmisi_id, 'tglperiksafisik' => $Fisik->tglperiksafisik)); ?>
            </td>
            <td style="text-align: center; width: 60px;">
                <?php
                $tglperiksafisik = (isset($_GET['tglperiksafisik']) ? $_GET['tglperiksafisik'] : null);
                if ($tglperiksafisik !== $Fisik->tglperiksafisik) {
                    ?>
                    <a onclick="hapuspemeriksaan('<?php echo $Fisik->pemeriksaanfisik_id; ?>', this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Pemeriksaan Fisik"><i class="icon-form-sampah"></i></a>
                    <?php }
                    ?>
            </td>
        </tr>
    <?php } ?>
</table>

<script type="text/javascript">
function hapuspemeriksaan(pemeriksaanfisik_id, obj)
{
    tabel = obj;
    myConfirm('Apakah Anda akan menghapus Pemeriksaan Fisik ini?', 'Perhatian!', function (r)
    {
        if (r) {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('hapusRiwayatPemeriksaan'); ?>',
                data: {pemeriksaanfisik_id: pemeriksaanfisik_id},
                dataType: "json",
                success: function (data) {
                    if (data.sukses) {
                        var delete_row = $(tabel).parents('tr');
                        delete_row.detach();
                    }
                    myAlert(data.pesan);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    });
}

function viewDetailFisik(idFisik, pendaftaran_id)
{

    $.post('<?php echo $this->createUrl('ajaxDetailFisik') ?>', {idFisik: idFisik, pendaftaran_id: pendaftaran_id}, function (data) {
        $('#contentDetailFisik').html(data.result);
        $('#contentDetailFisik').trigger("load_detail_periksagambar");
    }, 'json');
    $('#dialogDetailFisik').dialog('open');
}
</script>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id' => 'dialogDetailFisik',
'options' => array(
    'title' => 'Detail Pemeriksaan Fisik',
    'autoOpen' => false,
    'modal' => true,
    'width' => 800,
    'resizable' => false,
    'position' => 'top',
),
));

echo '<div id="contentDetailFisik">dialog content here</div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>