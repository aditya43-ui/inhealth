<?php
if (isset($_POST["EXCEL"])) {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . "Surat Keterangan" . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
$data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$format = new MyFormatter();
$model->hasilperiksanarkoba = CJSON::decode($model->hasilperiksanarkoba) ?? array();
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<style>
    body {
        font-size: 8pt;
    }

    .content td {
        font-size: 8pt !important;
    }

    .content li {
        font-size: 8pt;
    }

    .content p {
        font-size: 8pt;
    }



    p {
        margin-left: 0;
        text-align: justify;
    }

    .tab-foot,
    .tab-foot td {
        /*        font-size: 6pt;*/
    }

    .line-words {
        text-decoration: line-through;
    }

    .table-checklist {
        border: #000 1px solid;
        padding: 6px;
        border-collapse: collaps;
    }

    .table-checklist tr>td {
        padding: 6px;
    }

    .table-checklist .btm {
        padding: 6px;
        border-bottom: #000 1px solid;
    }

    .table-checklist .bord {
        border-left: #000 1px solid;
        border-right: #000 1px solid;
        text-align: center;
        padding: 6px;
    }
</style>

<div>
    <div class="header">
        <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
    </div>
    <div>
        <div class="content">
            <TABLE ALIGN="CENTER">
                <tr>
                    <td ALIGN=CENTER VALIGN=MIDDLE>
                        <div class="judulcontent"> <B><span SIZE=4><U><?php echo $model->judulsurat; ?></U></span></B></div>
                    </td>
                </tr>
                <tr>
                    <td ALIGN=CENTER VALIGN=MIDDLE>
                        <B><span SIZE=4>NO : <?php echo $model->nomorsurat; ?></span></B>
                    </td>
                </tr>
            </TABLE>
            </br><br />
            <p align="justify">
                Yang bertanda tangan dibawah ini menerangkan bahwa :
            </p>
            <?php
            $pegawaiList = DokterV::model()->findAll(array(
                'condition' => 'pegawai_aktif = true AND kelompokpegawai_id = ' . Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,
                'order' => 'nama_pegawai'
            ));

            $pegawaiOpt = array();
            foreach ($pegawaiList as $item) {
                if (trim(strtolower($model->mengetahui_surat)) != trim(strtolower($item->namaLengkap))) {
                    continue;
                }

                $pegawaiOpt = array(
                    'nama' => $item->namaLengkap,
                    'sip' => $item->suratizinpraktek ?? "-",
                    'jabatan' => $item->jabatan->jabatan_nama ?? "-",
                    'instansi' => 'RSUD Kelet Provinsi Jawa Tengah',
                    'nip' => $item->nomorindukpegawai,
                );
            }

            ?>
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="160">Nama</td>
                    <td width="10">:</td>
                    <td><?php echo $pegawaiOpt['nama'] ?? "-" ?></td>
                </tr>
                <tr>
                    <td width="160">SIP</td>
                    <td width="10">:</td>
                    <td><?php echo $pegawaiOpt['sip'] ?? "-" ?></td>
                </tr>
                <tr>
                    <td width="160">Jabatan</td>
                    <td width="10">:</td>
                    <td><?php echo $pegawaiOpt['jabatan'] ?? "-" ?></td>
                </tr>
                <tr>
                    <td width="160">Instansi</td>
                    <td width="10">:</td>
                    <td><?php echo $pegawaiOpt['instansi'] ?? "-" ?></td>
                </tr>
            </table>
            <table width="100%" style="width:500px;margin-left:50px;">
                <tr>
                    <td width="180">Atas permintaan dari</td>
                    <td width="10">:</td>
                    <td>
                        <div class="controls">
                            <?php
                            echo $model->permintaandari;
                            ?>
                        </div>
                    </td>
                </tr>
            </table>
            <?php
            if ($model->permintaandari == 'Instansi') {
            ?>
                <div class="control-group" id="instansidiri" style="display:none;">
                    <div class="controls">
                        <table width="100%" style="width:500px;margin-left:80px;">
                            <tr>
                                <td width="150">Nama</td>
                                <td width="10">:</td>
                                <!-- <td><?php //echo CHtml::activeTextField($model, 'kepadayth', array('readonly'=>false,
                                            //'onkeypress'=>"return $(this).focusNextInputField(event)")); 
                                            ?></td> -->
                                <td><?php echo CHtml::textField('nama_pegawai_instansi', $model->nama_pegawai_instansi, array(
                                        'readonly' => false,
                                        'onkeypress' => "return $(this).focusNextInputField(event)"
                                    )); ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="150">Jabatan</td>
                                <td width="10">:</td>
                                <td><?php echo CHtml::textField('jabatan_instansi', $model->jabatan_instansi, array(
                                        'readonly' => false,
                                        'onkeypress' => "return $(this).focusNextInputField(event)"
                                    )); ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="150">Instansi</td>
                                <td width="10">:</td>
                                <td><?php echo CHtml::textField('instansi_instansi', $model->instansi_instansi, array(
                                        'readonly' => false,
                                        'onkeypress' => "return $(this).focusNextInputField(event)"
                                    )); ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="150">Perihal</td>
                                <td width="10">:</td>
                                <td><?php echo CHtml::textField('perihal_instansi', $model->perihal_instansi, array(
                                        'readonly' => false,
                                        'onkeypress' => "return $(this).focusNextInputField(event)"
                                    )); ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            <?php
            }
            ?>
            <br />
            <div style="text-align: justify; margin-left: 50px;" id="txt_tanggal">
                Telah melakukan pemeriksaan psikiatrik pada tanggal
                <?php
                $model->tgl_periksa;
                ?>
                terhadap :
            </div></br>
            <table width="100%" style="width:500px;margin-left:80px;">
                <tr>
                    <td width="150">Nama</td>
                    <td width="10">:</td>
                    <td><?php echo $model->nama_pasien ? $modPasien->nama_pasien : '-'; ?></td>
                </tr>
                <tr>
                    <td width="150">NIK</td>
                    <td width="10">:</td>
                    <td><?php $model->no_identitas_pasien ? $modPasien->no_identitas_pasien : '-'; ?></td>
                </tr>
                <tr>
                    <td>Tempat/ Tanggal Lahir</td>
                    <td>:</td>
                    <td><?php echo $model->tempat_lahir ? $modPasien->tempat_lahir : '-'; ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td><?php echo $modPasien->alamat_pasien; ?></td>
                </tr>
            </table>
            <div style="text-align: justify; margin-left: 50px;" id="txt_tanggal">
                Dengan Hasil Pemeriksaan Kesehatan Jiwa pada saat ini :
            </div></br>
            <table width="100%" style="width:500px;margin-left:80px;">
                <tr>
                    <td colspan="3">1. Psikopatologi :</td>
                </tr>
                <tr>
                    <td colspan="3"><?php echo $model->psikopatologi ? $model->psikopatologi : '-'; ?></td>
                </tr>
                <tr>
                    <td colspan="3">2. Kepribadian :</td>
                </tr>
                <tr>
                    <td colspan="3"><?php echo $model->kepribadian ? $model->kepribadian : '-'; ?></td>
                </tr>
            </table>
            <br />
            <div style="text-align: justify; margin: 0px 50px;" id="txt_tanggal">
                <!-- <p align="justify"> -->
                <?php echo $model->kelayakan_jiwa ? $model->kelayakan_jiwa : '-' ?>
                Sehat Rohani / Jiwa, sesuai UU Kesehatan Jiwa No.18, 2014 (individu menyadari kemampuan sendiri, dapat mengatasi tekanan, dan dapat bekerja secara produktif dan mampu memberikan kontribusi untuk komunitasnya)
                <br />
                Demikian surat keterangan pemeriksaan kesehatan jiwa dapat dibuat dengan sebenarnya untuk keperluan
                Demikian surat keterangan ini dibuat untuk digunakan dengan semestinya.
            </div>
            <br /><br />
            <table style="width: 100%; border: none;">
                <tr style="text-align: center;">
                    <td width="30%">
                    <?php
                    $this->widget('ext.qrcode.QRCodeGenerator', array(
                        'data' => $model->qrcode,
                        'subfolderVar' => false,
                        'matrixPointSize' => 5,
                        'displayImage' => true, // default to true, if set to false display a URL path
                        'errorCorrectionLevel' => 'L', // available parameter is L,M,Q,H
                        'matrixPointSize' => 3, // 1 to 10 only
                    ));
                    // echo $model->qrcode;
                    ?>
                    </td>
                    <td width="50%">
                    </td>
                    <td width="19%">
                        <?php $date = date('Y-m-d'); ?>
                        <?php echo strtoupper($data->kabupaten->kabupaten_nama); ?>, <?php //echo strtoupper($format->formatDateTimeForUser($date)); 
                                                                                        ?><br>
                        <!-- <?php //echo strtoupper($data->nama_rumahsakit);
                                ?>, -->
                        <!-- Dokter Pemeriksa -->
                        <br><br><br><br><br>

                        <?php

                        $pegawaiList = DokterV::model()->findAll(array(
                            'condition' => 'pegawai_aktif = true AND kelompokpegawai_id = ' . Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,
                            'order' => 'nama_pegawai'
                        ));

                        $pegawaiOpt = array();
                        foreach ($pegawaiList as $item) {
                            $pegawaiOpt[$item->namaLengkap] = array(
                                'data-nama' => $item->namaLengkap,
                                'data-sip' => $item->suratizinpraktek ?? "-",
                                'data-jabatan' => $item->jabatan->jabatan_nama ?? "-",
                                'data-instansi' => 'RSUD Ketet Provinsi Jawa Tengah',
                            );
                        }

                        echo $model->mengetahui_surat??'-';
                        ?>

                    </td>
                </tr>
                <!-- <tr>
                    <td></td>
                    <td width="200" style="text-align: center;">
                        <?php //$date = date('Y-m-d'); ?>
                        <?php //echo strtoupper($data->kabupaten->kabupaten_nama); ?>,<br>
                        <?php //echo $pegawaiOpt['jabatan'] ?? "Dokter" ?><br />
                        <?php //echo $pegawaiOpt['instansi'] ?? "Dokter" ?>
                        <br><br><br><br><br>
                        <strong>
                            <u><?php //echo $model->mengetahui_surat; ?></u><br />
                            <?php //echo $pegawaiOpt['nip'] ?? "-" ?>
                        </strong>

                    </td>
                </tr> -->
            </table>
        </div>
    </div>
</div>