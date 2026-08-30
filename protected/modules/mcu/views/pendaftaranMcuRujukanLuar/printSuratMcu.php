<style>
    .barcode-label {
        margin-top: -20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }

    td,
    th {
        font-size: 11pt !important;
    }

    body {
        width: 21.7cm;
    }
</style>
<?php echo $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan._headerPrintStatus'); ?>
<style>
    p {
        text-indent: 50px;
        text-align: justify;
    }
</style>
<?php $date = date('Y-m-d'); ?>
<TABLE>
    <p>
    <table align='left'>
        <tr>
            <td colspan="3"><?php echo Yii::app()->user->getState('kabupaten_nama'); ?>, <?php echo $format->formatDateTimeId($date); ?></td>
        </tr>
        <tr>
            <td colspan="3">No. <?php echo isset($modRujukanKeluar->nosuratrujukan) ? $modRujukanKeluar->nosuratrujukan : ""; ?></td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td>Perihal</td>
            <td>:</td>
            <td><b>JAMINAN LAYANAN KESEHATAN MCU PISA KAPITASI - RS</b></td>
        </tr>
        <tr>
            <td>Lampiran</td>
            <td>:</td>
            <td>4 (Empat Lembar)</td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3">
                Kepada Yth
            </td>
        </tr>
        <tr>
            <td colspan="3">
                Direktur <?php echo isset($modRujukanKeluar->rujukankeluar_id) ? $modRujukanKeluar->rujukankeluar->rumahsakitrujukan : ""; ?>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <?php echo isset($modRujukanKeluar->rujukankeluar_id) ? $modRujukanKeluar->rujukankeluar->alamatrsrujukan : ""; ?>
            </td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr style="text-align:justify;">
            <td colspan="3">
                Dengan hormat,<br>
                Mohon dierikan layanan kesehatan Medical Check Up (MCU) sebagaimana surat permintaan terlampir kepada pasien berikut,
                <table width="50%" style="margin-left:100px;width: auto;">
                    <tr>
                        <td style="padding-right:75px;">Nama Peserta MCU</td>
                        <td>:</td>
                        <td><?php echo $modPasien->nama_pasien ?></td>
                    </tr>
                    <tr>
                        <td style="padding-right:75px;">Nama Pekerja/Penanggung</td>
                        <td>:</td>
                        <td><?php echo !empty($modPasien->pegawai_id) ? $modPasien->pegawai->NamaLengkap : ' - '; ?></td>
                    </tr>
                    <tr>
                        <td style="padding-right:75px;">Nomor Kartu Peserta</td>
                        <td>:</td>
                        <td><?php echo !empty($modPasien->pegawai_id) ? $modPasien->pegawai->nomorindukpegawai : " - "; ?></td>
                    </tr>
                    <tr>
                        <td style="padding-right:75px;">Masa Berlaku Surat</td>
                        <td>:</td>
                        <td><?php echo $format->formatDateTimeId($modRujukanKeluar->tglberlakusurat) . " -" . $format->formatDateTimeId($modRujukanKeluar->sampaidengan);; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr style="text-align:justify;">
            <td colspan="3">
                Jika dari hasil MCU ditemukan adanya kelainan yang tidak bersifat darurat, maka mohon kasus dapat dikembalikan ke RS untuk ditindaklanjuti. Namun apabila dibutuhkan pemeriksaan/tindakan dengan indikasi kegawatdaruratan medis, maka mohon dilakukan konfirmasi atas persetujuan tindakan terlebih dahulu ke unit Administrasi Kesehatan (0548-55 2154 atau 0548-5126414).
                Semua biaya yang timbul sesuai ketentuan dalam surat ini menjadi bebas RS, alamat penagihan ditujukan ke Direktur cq. Wakit Direktur Keuangan dengan melampirkan:
                <table width="50%" style="margin-left:100px;width: auto;">
                    <tr>
                        <td>
                            <ol type="1">
                                <li>Kuitansi Bermeterai.</li>
                                <li>Copy surat jaminan layanan kesehatan.</li>
                                <li>Hasil Medical Check Up.</li>
                                <li>Rincian Pemeriksaan MCU yang telah ditandatangani dan berstempel.</li>
                                <li>Resume medis atas sejenisnya yang telah ditandatangani dan berstempel untuk diagnosa rawat jalan dan atau rawat inap tingkat lanjut yang telah mendapat persetujuan.</li>
                            </ol>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr style="text-align:justify;">
            <td colspan="3">
                Atas kepercayaan diterimanya jaminan layanan kesehatan dan bantuan layanan yang diberikan, disampaikan terima kasih.
            </td>
        </tr>
    </table>
    </p>

    </div><br>
    <?php
    if (isset($_GET['frame'])) {
        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')"));
    ?>
        <script type='text/javascript'>
            /**
             * print
             */
            function print(caraPrint) {
                window.open('<?php echo $this->createUrl('printSuratMcu', array('pendaftaran_id' => $_GET['pendaftaran_id'], 'pasiendirujukeluar_id' => $_GET['pasiendirujukeluar_id'])); ?>', 'printwin', 'left=100,top=100,width=860,height=480');
            }
        </script>
    <?php
    } else { ?>
        <div style="margin-left: 0;text-align: left;">
            RS<br>
            Ka. MPKS,
            <br><br><br><br><br>
            <?php echo (!empty($modRujukanKeluar->pegawai_id) ? "<u><b>" . $modRujukanKeluar->pegawai->NamaLengkap . "</b></u>" : " _________________ "); ?>
        </div>
        <br><br>
    <?php } ?>
</TABLE>