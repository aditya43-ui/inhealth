<?php

/**
 * - digunakan untuk menampilkan detail poin pegawai
 * 
 * @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
 */
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
//echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

if (!isset($_GET['caraPrint'])) {
    $size = '14px';
} else {
    $size = '18px';
}
?>
<style>
    table {
        font-size: <?php echo $size ?> !important;
    }
</style>

<table class='table noborder'>
    <tr>
        <td colspan="4" style="text-align:center;">
            <img src="<?php echo Params::urlProfilRSDirectory() . $profil->logo_rumahsakit ?> " style="max-width: 210px; width:210px;" class='image_report' />
        </td>
    </tr>
    <tr>
        <td>
            &nbsp;
        </td>
        <td width='30%'>
            &nbsp;
        </td>
        <td colspan="3">Jombang, <?php echo date('d') . ' ' . date('F') . ' ' . date('Y') ?></td>
    </tr>
    <tr>
        <td>
            Hal : Permohonan Cuti
        </td>
        <td>

        </td>
        <td colspan="3">
            Kepada Yth.
        </td>
    </tr>
    <tr>
        <td>
            &nbsp;
        </td>
        <td>
            &nbsp;
        </td>
        <td colspan="3">
            Direktur <?php echo $profil->jenisrs_profilrs . ' ' . $profil->nama_rumahsakit ?>
        </td>
    </tr>
    <tr>
        <td>
            &nbsp;
        </td>
        <td>
            &nbsp;
        </td>
        <td colspan="3">
            Up. Kepada Bagian Umum
        </td>
    </tr>
    <tr>
        <td>
            &nbsp;
        </td>
        <td>
            &nbsp;
        </td>
        <td colspan="3">
            Di Tempat
        </td>
    </tr>
    <tr>
        <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="5">Dengan hormat,</td>
    </tr>
    <tr>
        <td colspan="5">Yang bertanda tangan dibawah ini :</td>
    </tr>
</table>
<table class='table noborder'>
    <tr>
        <td width='10%'>Nama</td>
        <td width='5%'>:</td>
        <td width='40%' style="border-bottom: 1px solid #333 !important;"><?php echo $model->NamaLengkapPemohon; ?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>Jabatan</td>
        <td>:</td>
        <td width='40%' style="border-bottom: 1px solid #333 !important;"><?php echo $model->jabatan_nama; ?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>Unit</td>
        <td>:</td>
        <td width='40%' style="border-bottom: 1px solid #333 !important;"><?php echo $model->ruangan_nama; ?></td>
        <td>&nbsp;</td>
    </tr>
</table>

<table class="table noborder">
    <tr>
        <td width='100%' style="text-align: justify;" colspan="4">
            Dengan ini mengajukan ....................................... <?php echo $model->jeniscuti_nama ?> ............................... Selama ..... <?php echo $model->lamacuti ?> ..... hari. <br>
            Terhitung tanggal ................... <?php echo date('d', strtotime($model->tglmulaicuti)) ?> .................. Bulan ................. <?php echo date('F', strtotime($model->tglmulaicuti)) ?> ................ Tahun <?php echo date('Y', strtotime($model->tglmulaicuti)) ?> .......... <br>
            Pengganti ..................<?php echo !empty($model->status_cuti == Params::STATUS_CUTI_DISETUJUI) ? $model->NamaLengkapPengganti . '....................' : '.....................................................' ?><br>
            Demikian pengajuan cuti ini harap menjadikan periksa adanya. Terima kasih.
        </td>
    </tr>
</table>

<table class="table noborder">
    <tr>
        <td style="text-align:center;">
            Menyetujui,
        </td>
        <td style="text-align:center;">
            Mengetahui,
        </td>
        <td style="text-align:center;">

        </td>
    </tr>
    <tr>
        <td style="text-align:center;padding: 0;">
            Kabag Umum
        </td>
        <td style="text-align:center;padding: 0;">
            Atasan Langsung
        </td>
        <td style="text-align:center;padding: 0;">
            Yang Mengajukan
        </td>
    </tr>
    <tr>
        <td colspan="3">
            &nbsp;
        </td>
    </tr>
    <tr>
        <td colspan="3">
            &nbsp;
        </td>
    </tr>
    <tr>
        <td style="text-align:center;padding: 0;">
            <?php echo ($model->status_cuti == Params::STATUS_CUTI_DISETUJUI) ? $model->namaLengkapMenyetujui : ''; ?><br>
            ................................................
        </td>
        <td style="text-align:center;padding: 0;">
            <?php echo $model->namaLengkapMengetahui; ?><br>
            ................................................
        </td>
        <td style="text-align:center;padding: 0;">
            <?php echo $model->namaLengkapPemohon; ?><br>
            ................................................
        </td>
    </tr>
    <tr>
        <td colspan="3">
            &nbsp;
        </td>

    </tr>
    <tr>
        <td>

            <table class="table noborder" style="width:180px !important;">
                <tr style="padding: 0;">
                    <th style="padding: 0;font-size:16px" colspan="3"><u> &nbsp;Jenis Cuti : &nbsp; </u></th>
                </tr>
                <?php
                $jeniscuti = JeniscutiM::model()->findAll("jeniscuti_aktif = TRUE ORDER BY jeniscuti_nama ASC");
                $i = 1;
                foreach ($jeniscuti as $det) {
                    if ($det->jeniscuti_id == $model->jeniscuti_id) {
                        $check = true;
                    } else {
                        $check = false;
                    }
                ?>
                    <tr style="padding: 0;">
                        <td style="padding: 0;"><?php echo $i ?>.</td>
                        <td style="padding: 0;"><?php echo $det->jeniscuti_nama ?></td>
                        <td style="padding: 0;">
                            <?php echo CHtml::checkBox("jeniscuti_" . $det->jeniscuti_id, $check, array('value' => $det->jeniscuti_id, 'onchange' => 'checkThis(this);')) ?>
                        </td>
                    </tr>
                <?php
                    $i++;
                }
                ?>
            </table>
        </td>
        <td colspan="2" style="padding-left:120px;padding-right:20px;text-align: center;">
            <table class="table noborder" style="width:270px !important;">
                <tr style="padding: 0;">
                    <th style="padding: 0;font-size:16px" colspan="2"><u> &nbsp;Jumlah Cuti Yang Telah Diambil : &nbsp; </u></th>
                </tr>
                <?php
                $i = 1;
                foreach ($jeniscuti as $det) {
                ?>
                    <tr style="padding: 0;">
                        <td style="padding: 0;"> <?php echo $i ?>.</td>
                        <td style="padding: 0;"> <?php echo '...................' . $det->getTotalJenisCuti($det->jeniscuti_id, $model->pegawai_id, $model->tanggal_transaksi, $model->pegawaicuti_id) . '...................'; ?> </td>
                    </tr>
                <?php
                    $i++;
                }
                ?>
            </table>
        </td>

    </tr>
</table>

<?php
if (!isset($_GET['caraPrint'])) {
?>
    <div class="control-group">
        <?php echo CHtml::label("", 'asd', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo CHtml::link("<i class='" . MyIcon::getIcons('cetak') . "'></i> Cetak", 'javascript:;', array('data-placement' => 'right', 'rel' => 'tooltip', 'title' => 'Klik button/ikon ini, jika Anda ingin mencetak surat permohonan ini ', 'data-html' => true, 'onclick' => 'printPermohonan(' . $model->pegawaicuti_id . ',\'PRINT\')', 'class' => 'btn btn-info', 'style' => 'color:#fff !important;')); ?>
        </div>
    </div>
<?php
} else {
?>
    <script>
        $(document).ready(function() {
            window.print();
        });
    </script>
<?php
}
?>

<script>
    function printPermohonan(id, print) {
        window.open('<?php echo $this->createUrl('detailPrint'); ?>&id=' + id + '&caraPrint=' + print, 'printwin', 'left=100,top=0,width=768,height=640');
    }

    function checkThis(obj) {
        var jeniscuti_id = $(obj).attr('value');

        $("#jeniscuti_" + jeniscuti_id).prop("checked", false);
        $("#jeniscuti_" + <?php echo $model->jeniscuti_id; ?>).prop("checked", true);

    }
</script>