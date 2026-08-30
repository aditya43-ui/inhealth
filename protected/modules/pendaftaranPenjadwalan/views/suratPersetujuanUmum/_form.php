<?php
$this->widget('bootstrap.widgets.BootAlert');

$modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
$modAnamnesa = AnamnesaT::model()->findByAttributes(array(
    'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
), array(
    'order' => 'anamesa_id desc',
));

if (empty($modAnamnesa)) {
    $modAnamnesa = new AnamnesaT;
}

$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();


$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'suratpersetujuanumum-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
));


?>

<style>
    .header {
        text-align: center;
        height: 100%;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .signature {
        text-align: center;
        font-size: 14pt !important;
    }

    .main-content p {
        text-align: justify;
        font-size: 14pt !important;
    }

    .title-content h3 {
        text-align: center;
        font-size: 16pt !important;
        margin-bottom: 15px;
        font-weight: bolder;
    }
</style>
<div>
    <div class="header">
        <div>
            <table>
                <tr>
                    <td>
                        <img src="<?php echo Params::urlProfilRSDirectory() . 'logo_jatim.png' ?> " style="max-width: 80px; width:80px;" />
                    </td>
                    <td>
                        <p>
                            <span style="font-size: 20px;">PEMERINTAH PROVINSI JAWA TIMUR</span><br>
                            <b><?php echo strtoupper($modProfilRs->nama_rumahsakit); ?></b></font></b><br>
                            <img src="<?php echo Params::urlProfilRSDirectory() . 'bintang.png' ?> " style="max-width: 80px; width:80px;" /><br>
                            18 FEBRUARI 2018 s.d 31 DESEMBER 2021 <br>
                            <font color="black" face="Liberation Serif"><?php echo $modProfilRs->alamatlokasi_rumahsakit; ?></font>&nbsp;
                            <font color="black" face="Liberation Serif">Telp. <?php echo $modProfilRs->no_telp_profilrs; ?> &nbsp; Fax. / <?php echo $modProfilRs->no_faksimili . " - " . $modProfilRs->kabupaten->kabupaten_nama; ?></font><br>
                            <font color="black" face="Liberation Serif">Email: staf-rsu-drsaifulanwar@jatimprov.go.id &nbsp; Website : www.rsusaifulanwar.jatimprov.go.id </font>
                        </p>
                    </td>
                    <td>
                        <img src="<?php echo Params::urlProfilRSDirectory() . $modProfilRs->logo_rumahsakit ?> " style="max-width: 80px; width:80px;" />

                    </td>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="content">
        <div class="title-content">
            <h3>FORMULIR PEMBERIAN INFORMASI DAN PERSETUJUAN UMUM <br> (GENERAL CONSENT)</h3>
        </div>
        <div class="identity">
            <table width="100%">
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td><?php echo $modPasien->nama_pasien; ?></td>
                </tr>
                <tr>
                    <td>Tgl. Lahir</td>
                    <td>:</td>
                    <td><?php echo MyFormatter::formatDateTimeId($modPasien->tanggal_lahir); ?></td>
                </tr>
                <tr>
                    <td>No. RM</td>
                    <td>:</td>
                    <td><?php echo $modPasien->no_rekam_medik; ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td><?php echo $modPasien->alamat_pasien; ?></td>
                </tr>
            </table>
        </div>
        <div class="main-content">
            <table width="100%">
                <tr>
                    <td style="vertical-align: top; text-align: left; font-size: 14pt !important;">1. </td>
                    <td>
                        <p>
                            <strong>Hak dan Kewajiban sebagai pasien</strong> : Dengan menandatangani dokumen ini saya mengakui bahwa pada proses pendaftaran untuk mendapatkan perawatan di RSUD Dr. Saiful Anwar telah mendapatkan informasi tentang hak dakn kewajiban saya sebagai pasien(melaui leaflet/banner dan atau petugas).
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; text-align: left; font-size: 14pt !important;">2. </td>
                    <td>
                        <p>
                            <strong>Persetujuan Pelayanan</strong> : Saya menyetujui dan memberikan persetujuan untuk dirawat di RSUD Dr. Saiful Anwar dan dengan ini saya meminta dan memberikan kuasa kepada RSUD Dr. Saiful Anwar dan dengan ini saya meminta dan memberikan kuasa kepada RSUD Dr. Saiful Anwar, dokter dan perawat dan tenaga kesehatan lainnya untuk memberikan asuhan keperawatan, pemeriksaan fisik yang dilakukan oleh dokter dan perawat dan melakukan prosedur diagnostik radiologi dan/atau terapi dan tatalaksana seusai pertimbangan dokter yang diperlukan atau disarankan pada perawatan saya. Hal ini mencakup seluruh pemeriksaan dan prosedur diagnostik rutin termasuk X ray, pemberian dan.atau tindakan medis serta penyuntikan (intramuskular, intarvena dan prosedur incasif lainnya) produk farmasi dan obta-obatan, pemasangan alat kesehatan (kecuali yang membutuhkan persetujuan khusus/tertulis) dan pengambilan darah untuk pemeriksaan laboratorium atau pemeriksaan patologi.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; text-align: left; font-size: 14pt !important;">3. </td>
                    <td>
                        <p>
                            <strong>Akses Informasi Kesehatan</strong> : Saya memberi kuasa kepada setiap dan seluruh orang yang merawat saya untuk memeriksa dan atau memberitahukan informasi kesehatan saya kepada pemberi kesehatan lain yang turut merawat saya selama di rumah sakit ini.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; text-align: left; font-size: 14pt !important;">4. </td>
                    <td>
                        <p>
                            <strong>Rahasia Kedokteran</strong> : Saya setuju RSUD Dr. Saiful Anwar Malang wajib menjamin kerahasiaan informasi medis saya baik untuk kepentingan perawatan dan pengobatan, pendidikan maupun penelitian.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; text-align: left; font-size: 14pt !important;">5. </td>
                    <td>
                        <p>
                            <strong>Membuka Rahasia Kedokteran</strong> : Saya setuju untuk membuka rahasia kedokteran terkait dengan kondisi kesehatan, asuhan dan pengobatan yang saya terima kepada : <br>
                            a) Dokter dan tenaga kesehatan lain yang turut merawat/memberikan asuhan kepada saya <br>
                            b) Perusahaan asuransi kesehatan atau perusahaan lainnya atau pihak lain yang menjamin pembiayaan saya <br>
                            c) Anggota keluarga saya / Pihak yang diberikan wewenang:<br>
                            <span style="margin-left: 10px;">&nbsp;&bull; .......................</span> <br>
                            <span style="margin-left: 10px;">&nbsp;&bull; .......................</span>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; text-align: left; font-size: 14pt !important;">6. </td>
                    <td>
                        <p>
                            <strong>Privasi</strong> : Saya meberi kuasa kepada RSUD Dr. Saiful Anwar Malang untuk menjada privasi dan kerahasiaan penyaki saya selama dalam perawatan.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; text-align: left; font-size: 14pt !important;">7. </td>
                    <td>
                        <p>
                            <strong>Barang Pribadi</strong> : Saya setuju untuk tidak mebawa barang-barang berharga yang tidak diperlukan (seperti perhiasan, elektronik, dll) selama dalam perawatan di RSUD Dr. Saiful Anwar, dan saya menyetujui jika membawanya maka RSUD Dr. Saiful Anwar tidak bertanggung jawab terhadap kehilangan, kerusakan atau pencurian.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; text-align: left; font-size: 14pt !important;">8. </td>
                    <td>
                        <p>
                            <strong>Pengajuan Keluhan</strong> : Saya menyatakan bahwa saya telah menerima informasi tentang adanya tata cara mengajukan dan mengatasi keluhan terkait pelayanan medik yang diberikan terhadap diri saya. Saya setuju untuk mengikuti tata cara mengajukan keluhan sesuai prosedur yang ada.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; text-align: left; font-size: 14pt !important;">9. </td>
                    <td>
                        <p>
                            <strong>Kewajiban Pembayaran</strong> : Saya menyatakan setuju, baik sebagai wali ataupun sebagai pasien, bahwa sesuai pertimbangan pelayanan yang diberikan kepada pasien, maka saya wajib untuk membayar total biaya pelayanan sesuai acuan biaya dan ketentuan RSUD Dr. Saiful Anwar Malang dengan jaminan atau pribadi. Apabila asuransi kesehatan swasta atau program pemerintah menanggung pembiayaan saya, saya memberikan wewenang kepada rumah sakit untuk memberi tagihan dari semua pelayanan dan tindakan medis yang diberikan. Tanggungan Asuransi saya mungkin menyatakan bahwa sebagian pembayaran tetap menjadi tanggung jawab pribadi saya atau tidak ditanggung oleh asuransi, maka rumah sakit berwenang memberi tagihan untuk biaya yang tidak ditanggung oleh asuransi dan saya bertanggung jawab untuk membayarnya. Apabila saya tidak memberikan persetujuan, atau dikemudian hari mencabut persetujuan saya untuk melepaskan rahasia kedokteran saya kepada perusahaan asuransi yang saya tentukan, maka saya pribadi bertanggung jawab untuk membayar semua pelayanan dan tindakan medis dari RSUD Dr. Saiful Anwar Malang.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; text-align: left; font-size: 14pt !important;">10. </td>
                    <td>
                        <p>
                            <strong>Rumah Sakit Pendidikan</strong> : Saya mengetahui bahwa RSUD Dr. Saiful Anwar merupakan rumah sakit pendidikan yang menjadi tempat praktek klinik bagi mahasiswa kedokteran dan profesi-profesi kesehatan lainnya, karena itu mereka mungkin berpartisipasi dan atau terlibat dalam perawatan saya dan saya menyetujui bahwa mereka berpartisipasi dalam perawatan saya sepanjangndi bawah supervisi dokter penanggung jawab pasien (DPJP).
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; text-align: left; font-size: 14pt !important;">11. </td>
                    <td>
                        <p>
                            Selama dalam perawatan saya dan keluarga saya akan mematuhi ketentuan untuk tidak mengambil, menyimpan, mengedarkan gambar/video dokumen dan aktivitas pelayanan selama di RS tanpa persetujuan RS.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; text-align: left; font-size: 14pt !important;">12. </td>
                    <td>
                        <p>
                            Melalui dokumen ini, saya menegaskan kembali bahwa saya mempercayakan kepada semua tenaga kesehatan rumah sakit untuk memberikan perawatan, diagnostik dan terapi kepada saya sebagai pasien rawat inap atau rawat jalan atau Insatalasi gawat darurat (IGD), termasuk semua pemeriksaan penunjang, yang dibutuhkan untuk pengobatan dan tindakan yang diperlukan.
                        </p>
                    </td>
                </tr>
            </table>
        </div>
        <div class="footer-content">
            <p style="font-size: 14pt !important;">Saya menyetujui setiap pertanyaan yang terdapa pada formulir ini dan menandatangani tanpa paksaan dan dengan kesadaran penuh.</p>
            <div align="left">
                <?php echo Yii::app()->user->getState('kabupaten_nama'); ?>,
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_persetujuan',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array(
                        'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'style' => 'width: 150px; float-left',
                    ),
                )); ?>

            </div>
            <div class="signature">
                <table width="100%" class="signature">
                    <tr>
                        <td width="20%" style="font-size: 14pt !important;">Pasien/keluarga/penanggung jawab</td>
                        <td width="25%" style="font-size: 14pt !important;">Pemberi Informasi</td>
                        <td width="30%" style="font-size: 14pt !important;">Saksi I <br> (Keluarga / Pengantar)</td>
                        <td width="25%" style="font-size: 14pt !important;">Saksi II <br> (Petugas selain yang menerima pendaftaran pasien)</td>
                    </tr>
                    <tr height="100px">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->textField($model, 'penanggungjawab_pasien', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?></td>
                        <td><?php echo $form->textField($model, 'petugas_admisi', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?></td>
                        <td><?php echo $form->textField($model, 'saksi_pasien', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?></td>
                        <td><?php echo $form->textField($model, 'petugas_saksi', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <br>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
        ); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'onclick' => 'print();', 'disabled' => $model->isNewRecord)); ?>

    </div>
</div>
</div>

<?php $this->endWidget(); ?>

<script>
    function print() {
        window.open('<?php echo $this->createUrl('printGeneralConsent', array('pendaftaran_id' => $model->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=860,height=480');
    }
</script>