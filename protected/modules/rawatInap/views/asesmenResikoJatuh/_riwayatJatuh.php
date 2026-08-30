<?php

/**
 * menampilkan riwayat risiko perjatuh berdasarkan pendaftarannya
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0 
 * @link    <http://piindonesia.co.id>
 */
$visibility = isset($_GET['lihat']) ? 'hidden' : '';
?>
<?php if ($modPendaftaran->masihAnak) :
    $upper_limit_rendah = 6;
    $upper_limit_tinggi = 11;
?>
    SKOR : 0 - 6 Tidak ada Resiko (TR), 7 - 11 Resiko Rendah (RR), > 11 Resiko Tinggi
<?php else :
    $upper_limit_rendah = 24;
    $upper_limit_tinggi = 50;
?>
    SKOR : 0 - 24 Tidak ada Resiko (TR), 25 - 50 Resiko Rendah (RR), > 50 Resiko Tinggi
<?php endif; ?>
<table class="items table table-bordered table-striped table-condensed" id="tblListKonsul">
    <thead>
        <tr>
            <th>No.</th>
            <th>Tangal Pemeriksaan </th>
            <th>Skor Jatuh</th>
            <th> Keterangan </th>
            <th>Detail </th>
            <th>Petugas</th>
            <th <?= $visibility ?>>Hapus</th>

        </tr>
    </thead>
    <tbody>
        <?php $no = 1; ?>
        <?php foreach ($modResikoJatuh as $i => $modJatuh) { ?>
            <?php $pegawai_id = isset($modAsesmen['pegawai_id']) ? $modAsesmen['pegawai_id'] : '';

            if (isset($pegawai_id)) {
                $modPegawai = PegawaiM::model()->findByPk($pegawai_id);
            }

            ?>
            <tr class="data-row">
                <td><?php echo $no++; ?></td>
                <td><?php echo MyFormatter::formatDateTimeForUser($modJatuh['tgl_skoring']); ?></td>
                <td><?php echo $modJatuh['totalskor']; ?></td>
                <?php if ($modJatuh['totalskor'] >= 0 && $modJatuh['totalskor'] <= $upper_limit_rendah) { ?>
                    <td><?php echo "Tidak Ada Resiko" ?></td>
                <?php } else if ($modJatuh['totalskor'] > $upper_limit_rendah && $modJatuh['totalskor'] <= $upper_limit_tinggi) { ?>
                    <td><?php echo "Resiko Rendah" ?></td>
                <?php } else { ?>
                    <td><?php echo "Resiko Tinggi" ?></td>
                <?php } ?>
                <td style="text-align: center; width: 60px;">
                    <?php echo CHtml::link(
                        '<i class="icon-form-view"></i>',
                        Yii::app()->controller->createUrl(
                            "detail",
                            array("pendaftaran_id" => $modJatuh->pendaftaran_id, 'skor_id' => $modJatuh->skoringresikojatuh_id)
                        ),
                        array(
                            'class' => '',
                            'target' => 'iframeDetail',
                            'onclick' => "{
                                        $(\"#dialogLihat\").dialog(\"open\");
                                    }"
                        )
                    );
                    ?>
                </td>
                <td><?php echo isset($modJatuh->pegawai->namaLengkap) ? $modJatuh->pegawai->namaLengkap : " "; ?></td>
                <td style="text-align: center; width: 60px;" <?= $visibility ?>>
                    <?php
                    $tglskoring = (isset($_GET['tglperiksafisik']) ? $_GET['tglperiksafisik'] : null);
                    if ($tglskoring !== $modJatuh->skoringresikojatuh_id) {

                        $onclick = 'window.parent.myAlert("Tidak bisa dihapus karena hak akses tidak sesuai")';
                        // var_dump($modJatuh->create_loginpemakai_id, Yii::app()->user->getState('loginpemakai_id'));
                        $bisa_hapus = CustomFunction::hakAksesHapus(Yii::app()->user->getState('loginpemakai_id'), $modJatuh->create_ruangan, $modJatuh->create_loginpemakai_id);
                        
                        if($bisa_hapus) {
                            $onclick = 'hapuspemeriksaan('. $modJatuh->skoringresikojatuh_id . ',this);return false;';
                        }
                        echo CHtml::link('<i class="icon-form-silang"></i>', 'javascript:void(0);', [
                            'onclick' => $onclick,
                            'rel' => 'tooltip',
                            'title' => 'Klik untuk menghapus Asesment Skoring Resiko Jatuh'
                        ]);
                    }
                    ?>
                </td>

            </tr>
        <?php } ?>
    </tbody>
</table>


</table>
<script type="text/javascript">
    function hapuspemeriksaan(skoringresikojatuh_id, obj) {
        tabel = obj;
        // untuk menentukan hanya data yang terbaru yang dapat dihapus
        // Temukan elemen <tr>  yang diklik
        var trElement = $(obj).closest("tr");
        // Dapatkan indeks elemen <tr> tersebut
        var trIndex = $(".data-row").index(trElement);
        // indeks <tr> yang diklik
        console.log("TR ke-" + trIndex + " di klik.");

        if(trIndex > 0) {
            window.parent.myAlert("Data tidak dapat dihapus karena sudah valid");
            return false;
        }
        
        window.parent.myConfirm('Apakah Anda akan menghapus Asesment Skoring Resiko Jatuh  ini?', 'Perhatian!', function(r) {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/perawatanIntensif/asesmenResikoJatuhPI/hapusRiwayatAsesmentResikoJatuh'); ?>',
                    data: {
                        skoringresikojatuh_id: skoringresikojatuh_id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.sukses) {
                            var delete_row = $(tabel).parents('tr');
                            delete_row.detach();
                        }
                        window.parent.myAlert(data.pesan);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        });
    }
</script>
<?php
// ===========================Dialog Resiko Jatuh =========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogLihat',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Resiko Jatuh',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
        'scroll' => false
    ),
));
?>
<iframe name='iframeDetail' id='iframeDetail' style="width: 100%; height: 100%; border: none;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
