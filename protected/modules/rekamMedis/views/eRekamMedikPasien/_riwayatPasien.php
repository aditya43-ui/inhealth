<?php $this->widget('bootstrap.widgets.BootPager', array(
    'pages' => $pages,
    'header' => '<div class="pagination" id="pagin">',
    'footer' => '</div>',
)); ?>
<table class="items table table-striped table-bordered table-condensed">
    <thead>
        <tr>
            <th rowspan="2">Tgl. Kunjungan/<br>No. Pendaftaran</th>
            <th rowspan="2" colspan="2">Persalinan</th>
            <th rowspan="2" colspan="2">Ginekologi</th>
            <th rowspan="2" colspan="2">Kelahiran</th>
            <th colspan="2">Pemeriksaan Penunjang</th>
            <th rowspan="2">Konsul Poliklinik</th>
            <th rowspan="2">Rehab</th>
            <th rowspan="2">MCU</th>
            <th rowspan="2">Bedah/Operasi</th>
            <th colspan="3">Pelayanan</th>
            <th rowspan="2">Diagnosis</th>
            <th rowspan="2">Pegawai Input</th>
        </tr>
        <tr>
            <th>Ke penunjang</th>
            <th>
                <?php
                $pasien_id = $_GET['id'];
                echo CHtml::link("<i class='icon-form-anamnesa'></i> ",  Yii::app()->controller->createUrl(
                    "detailPemeriksaanLab",
                    array("id" => $pasien_id)
                ), array("id" => "$pasien_id", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Hasil Laboratorium", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Hasil Laboratorium"));

                ?>
                Hasil
            </th>
            <th>Tindakan</th>
            <th>Terapi</th>
            <th>Pemakaian Bahan</th>
        </tr>

    </thead>
    <tbody>
        <?php
        if(!empty($modKunjungan)){
         foreach ($modKunjungan as $modKunjungan) { ?>
            <tr>
                <td><?php echo $modKunjungan->no_pendaftaran; ?><br><?php echo MyFormatter::formatDateTimeForUser($modKunjungan->tgl_pendaftaran); ?></td>
                <td colspan="2" style="width: 60px; text-align: center;">
                    <?php
                    echo CHtml::link("<i class='icon-form-persalinan'></i> ",  Yii::app()->controller->createUrl(
                        "detailPersalinan",
                        array("id" => $modKunjungan->pendaftaran_id)
                    ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Persalinan", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Pelayanan/Persalinan"));

                    $cekParto = PemeriksaanpartografT::model()->findByAttributes(array('pendaftaran_id' => $modKunjungan->pendaftaran_id));

                    if (!empty($cekParto)) {
                        echo "<hr>";
                        echo CHtml::link(Yii::t('mds', '{icon} Depan', array('{icon}' => '<i class="icon-form-periksa"></i>')), 'javascript:void(0);', array('onclick' => "printPartograf(" . $modKunjungan->pendaftaran_id . ");return false",)) . "<br>";
                        echo CHtml::link(Yii::t('mds', '{icon} Belakang', array('{icon}' => '<i class="icon-form-periksa"></i>')), 'javascript:void(0);', array('onclick' => "printPartografBelakang(" . $modKunjungan->pendaftaran_id . ");return false",));
                    }
                    ?>
                </td>
                <td colspan="2" style="width: 60px; text-align: center;">
                    <?php
                    echo CHtml::link("<i class='icon-form-periksa'></i> ",  Yii::app()->controller->createUrl(
                        "detailGinekologi",
                        array("id" => $modKunjungan->pendaftaran_id)
                    ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Ginekologi", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Pelayanan/Ginekologi"));

                    ?>
                </td>
                <td colspan="2" style="width: 60px; text-align: center;">
                    <?php
                    echo CHtml::link("<i class='icon-form-kelahiran'></i> ",  Yii::app()->controller->createUrl(
                        "detailKelahiran",
                        array("id" => $modKunjungan->pendaftaran_id)
                    ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Kelahiran", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Pelayanan/Kelahiran"));

                    ?>
                </td>
                <td colspan="2">
                    <ul><?php $this->renderPartial($this->path_view .'periksaDataPasien._kepenunjang', array('pendaftaran_id' => $modKunjungan->pendaftaran_id)); ?></ul>
                </td>
                <td style="width: 60px; text-align: center;">
                    <?php $this->renderPartial($this->path_view .'periksaDataPasien._konsulpoli', array('pendaftaran_id' => $modKunjungan->pendaftaran_id));
                    echo "&nbsp &nbsp";
                    echo CHtml::link("<i class='icon-form-poliklinik'></i> ",  Yii::app()->controller->createUrl(
                        "detailKonsul",
                        array("id" => $modKunjungan->pendaftaran_id)
                    ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Konsul", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Konsul Poliklinik"));
                    ?>
                </td>
                <td style="width: 60px; text-align: center;">
                    <?php
                    echo CHtml::link("<i class='icon-form-periksa'></i> ",  Yii::app()->controller->createUrl(
                        "detailRehab",
                        array("id" => $modKunjungan->pendaftaran_id)
                    ), array("id" => "operasi_" . $modKunjungan->no_pendaftaran, "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Rehab Medis", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Rehab Medis"));
                    ?>
                </td>
                <td style="width: 60px; text-align: center;">
                    <?php
                    echo CHtml::link("<i class='icon-form-periksa'></i> ", Yii::app()->controller->createUrl(
                        "detailMCU",
                        array("id" => $modKunjungan->pendaftaran_id)
                    ), array("id" => "operasi_" . $modKunjungan->no_pendaftaran, "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail MCU", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat MCU"));

                    ?>
                </td>
                <td style="width: 60px; text-align: center;">
                    <?php
                    echo CHtml::link("<i class='icon-form-roperasi'></i> ",  Yii::app()->controller->createUrl(
                        "detailOperasi",
                        array("id" => $modKunjungan->pendaftaran_id)
                    ), array("id" => "operasi_" . $modKunjungan->no_pendaftaran, "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Pelayanan/Operasi", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Pelayanan/Operasi"));

                    ?>
                </td>
                <td style="width: 60px; text-align: center;">
                    <?php
                    echo CHtml::link("<i class='icon-form-tindakan'></i> ",  Yii::app()->controller->createUrl(
                        "detailTindakan",
                        array("id" => $modKunjungan->pendaftaran_id)
                    ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Tindakan", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Pelayanan/Tindakan"));
                    ?>
                </td>
                <td style="width: 60px; text-align: center;">
                    <?php

                    echo CHtml::link("<i class='icon-form-terapi'></i> ",  Yii::app()->controller->createUrl(
                        "detailTerapi",
                        array("id" => $modKunjungan->pendaftaran_id)
                    ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Terapi", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Resep Dokter/Terapi")) ?>
                </td>
                <td style="width: 60px; text-align: center;">
                    <?php echo CHtml::link("<i class='icon-form-pakaibahan'></i> ",  Yii::app()->controller->createUrl(
                        "detailPemakaianBahan",
                        array("id" => $modKunjungan->pendaftaran_id)
                    ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Pemakaian Bahan", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Pemakaian Bahan")) ?>
                </td>
                <td><?php $this->renderPartial($this->path_view .'periksaDataPasien._diagnosa', array('pendaftaran_id' => $modKunjungan->pendaftaran_id)); ?></td>
                <td><?php

                    $namaPegawai = "";
                    $jabatan = "";
                    $modPendaftaran = PendaftaranT::model()->findByPk($modKunjungan->pendaftaran_id);
                    $createLogin = LoginpemakaiK::model()->findByPk($modPendaftaran->create_loginpemakai_id);

                    if(!empty($createLogin) && !empty($createLogin->pegawai_id)){
                        $peg = PegawaiM::model()->findByPk($createLogin->pegawai_id);
                        if(!empty($peg)){
                            $namaPegawai = $peg->namaLengkap;
                            $jabatan = (!empty($peg->jabatan)?$peg->jabatan->jabatan_nama:"");
                        }
                    }
                    echo $namaPegawai.'<br/> ('.$jabatan.')';
                    ?></td>
            </tr>
        <?php } 
        }else{
            echo '<tr><td colspan="18">Data Tidak Ditemukan</td></tr>';
        }
        ?>
    </tbody>
</table>

<script>
    /**
    * print pemerikaan partograf
    * @returns {undefined} */
    function printPartograf(id) {
        window.open("<?php echo $this->createUrl('printDetailPartograf'); ?>&id=" + id, "", 'location=_new, width=1024px');

    }

    function printPartografBelakang(id) {
        window.open("<?php echo $this->createUrl('printDetailPartografBelakang'); ?>&id=" + id, "", 'location=_new, width=1024px');

    }
</script>