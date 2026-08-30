<?php $modPendaftaran = new RKKPendaftaranT; ?>
                <?php $this->widget('bootstrap.widgets.BootPager', array(
                    'pages' => $pages,
                    'header' => '<div class="pagination" id="pagin">',
                    'footer' => '</div>',
                )); ?>
                <table class="items table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th rowspan="2">Tgl. Kunjungan/<br>No. Pendaftaran</th>
                            <th rowspan="2">Dokter Pemeriksa</th>
                            <th rowspan="2" colspan="2">Riwayat Pemeriksaan Pasien</th>
                            <!-- <th rowspan="2" colspan="2">Anamnesis</th> -->
                            <!-- <th rowspan="2">Pemeriksaan Fisik</th> -->
                            <th rowspan="2">Diagnosis</th>
                            <th colspan="3">Pelayanan</th>
                            <th rowspan="2" hidden>Pengkajian Keperawatan Jiwa</th>
                            <th colspan="2">Pemeriksaan Penunjang</th>
                            <th rowspan="2">Konsul Poliklinik</th>
                            <th rowspan="2">Rehab</th>
                            <th rowspan="2">MCU</th>
                            <th rowspan="2">Bedah/Operasi</th>
                            <th rowspan="2" colspan="2">Persalinan</th>
                            <th rowspan="2" colspan="2">Ginekologi</th>
                            <th rowspan="2" colspan="2">Kelahiran</th>
                            <!--th rowspan="2">Operasi</th-->
                            <th rowspan="2">Dirujuk Keluar</th>
                            <th rowspan="2">Riwayat Rekam Medis Elektronik Pasien</th>
                        </tr>
                        <tr>
                            <th>Tindakan</th>
                            <th>Terapi</th>
                            <th>Pemakaian Bahan</th>
                            <th>Ke penunjang</th>
                            <th>
                                <?php
                                // $pasien_id = $_GET['id'];
                                echo CHtml::link("<i class='icon-form-anamnesa'></i> ",  Yii::app()->controller->createUrl(
                                    "daftarPasien/detailPemeriksaanLab",
                                    array("id" => $pasien_id)
                                ), array("id" => "$pasien_id", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Hasil Laboratorium", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Hasil Laboratorium"));

                                ?>
                                Hasil
                            </th>
                            <!--<th colspan="5">&nbsp;</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($modKunjungan as $modKunjungan) { ?>
                            <tr>
                                <td><?php echo $modKunjungan->no_pendaftaran; ?><br>
                                <?php
                                    $modPendaftaran = PendaftaranT::model()->findByPk($modKunjungan->pendaftaran_id);
                                    $morbid = PasienmorbiditasT::model()->findAllByAttributes(array(
                                        'pendaftaran_id'=>$modKunjungan->pendaftaran_id,
                                        'kelompokdiagnosa_id'=>Params::KELOMPOKDIAGNOSA_UTAMA,
                                    ));
                                    if(!empty($morbid)){
                                        if(count((array)$morbid) > 0) {
                                            foreach ($morbid as $val => $item) {
                                                echo MyFormatter::formatDateTimeForUser($item->tglmorbiditas);//var_dump($morbid);die;
                                            }
                                        };
                                    }else{
                                        echo MyFormatter::formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
                                    }
                                ?>
                                <?php //echo MyFormatter::formatDateTimeForUser($modKunjungan->tgl_pendaftaran); ?></td>
                                <td><?php

                                    echo isset($modKunjungan->pegawai_id) ? $modKunjungan->pegawai->namaLengkap : ' - ';
                                    $anamnesa_cek_ada = AnamnesaT::model()->findByAttributes(array(
                                        'pendaftaran_id' => $modKunjungan->pendaftaran_id,
                                    ));

                                    if (!empty($anamnesa_cek_ada)) {
                                        $anamnesa_cek = AnamnesaT::model()->findByAttributes(array(
                                            'pendaftaran_id' => $modKunjungan->pendaftaran_id,
                                        ), array(
                                            'condition' => 'dokterverifikasi_id is null'
                                        ));

                                        if (empty($anamnesa_cek)) {
                                            echo "<br>(SUDAH DILAKUKAN VERIFIKASI)";
                                        }
                                    } else {
                                        echo "<br>(BELUM INPUT DATA ANAMNESA)";
                                    }


                                    ?></td>
                                <td colspan="2" style="width: 60px; text-align: center;">
                                    <?php
                                        echo CHtml::link('<i class="icon-form-periksa"></i>', '#', array(
                                            'onclick'=>'getRiwayatPeriksa('.$modKunjungan->pendaftaran_id.'); return false;',
                                        ));
                                    ?>
                                </td>
                                <td colspan="2" style="width: 60px; text-align: center;" hidden>
                                    <?php
                                    echo CHtml::link("<i class='icon-form-anamnesa'></i> ",  Yii::app()->createUrl(
                                        "rawatJalan/daftarPasien/detailAnamnesa",
                                        array("id" => $modKunjungan->pendaftaran_id)
                                    ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Anamnesis", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Pelayanan/Anamnesis"));

                                    ?>
                                </td>
                                <td style="width: 60px; text-align: center;" hidden>
                                    <?php
                                    echo CHtml::link("<i class='icon-form-periksa'></i> ",  Yii::app()->createUrl(
                                        "rawatJalan/daftarPasien/detailPeriksaFisik",
                                        array("id" => $modKunjungan->pendaftaran_id)
                                    ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Periksa Fisik", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Pelayanan/Periksa Fisik"));

                                    ?>
                                </td>
                                <td><?php $this->renderPartial('rawatJalan.views._periksaDataPasien._diagnosa', array('pendaftaran_id' => $modKunjungan->pendaftaran_id)); ?></td>
                                <td style="width: 60px; text-align: center;">
                                    <?php //$this->renderPartial('/_periksaDataPasien/_tindakan', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id, 'pasien_id'=>$modKunjungan->pasien_id)); 
                                    ?>
                                    <?php //if (count((array)$modKunjungan->tindakanpelayanan->daftartindakan_id) != 0){
                                    echo CHtml::link("<i class='icon-form-tindakan'></i> ",  Yii::app()->createUrl(
                                        "rawatJalan/daftarPasien/detailTindakan",
                                        array("id" => $modKunjungan->pendaftaran_id)
                                    ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Tindakan", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Pelayanan/Tindakan"));

                                    //        }
                                    ?>
                                </td>
                                <td style="width: 60px; text-align: center;">
                                    <?php //$this->renderPartial('/_periksaDataPasien/_terapi', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id, 'pasien_id'=>$modKunjungan->pasien_id)); 
                                    ?>
                                    <?php

                                    echo CHtml::link("<i class='icon-form-terapi'></i> ",  Yii::app()->createUrl(
                                        "rawatJalan/daftarPasien/detailTerapi",
                                        array("id" => $modKunjungan->pendaftaran_id)
                                    ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Terapi", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Resep Dokter/Terapi")) ?>
                                </td>
                                <td style="width: 60px; text-align: center;">
                                    <?php //$this->renderPartial('/_periksaDataPasien/_pemakaianBahan', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id, 'pasien_id'=>$modKunjungan->pasien_id)); 
                                    ?>
                                    <?php echo CHtml::link("<i class='icon-form-pakaibahan'></i> ",  Yii::app()->createUrl(
                                        "rawatJalan/daftarPasien/detailPemakaianBahan",
                                        array("id" => $modKunjungan->pendaftaran_id)
                                    ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Pemakaian Bahan", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Pemakaian Bahan")) ?>
                                </td>
                                <td style="width: 60px; text-align: center;" hidden>
                                    <?php
                                    echo CHtml::link("<i class='icon-form-periksa'></i> ",  Yii::app()->createUrl(
                                        "rawatJalan/daftarPasien/detailKeperawatanJiwa",
                                        array("id" => $modKunjungan->pendaftaran_id)
                                    ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Kajian Keperawatan Jiwa", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Kajian Keperawatan Jiwa"));

                                    ?>
                                </td>

                                <td colspan="2">
                                    <ul><?php $this->renderPartial('rawatJalan.views._periksaDataPasien._kepenunjang', array('pendaftaran_id' => $modKunjungan->pendaftaran_id)); ?></ul>
                                </td>
                                <td style="width: 60px; text-align: center;">
                                    <?php $this->renderPartial('rawatJalan.views._periksaDataPasien._konsulpoli', array('pendaftaran_id' => $modKunjungan->pendaftaran_id));
                                    echo "&nbsp &nbsp";
                                    echo CHtml::link("<i class='icon-form-poliklinik'></i> ",  Yii::app()->createUrl(
                                        "rawatJalan/daftarPasien/detailKonsul",
                                        array("id" => $modKunjungan->pendaftaran_id)
                                    ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Konsul", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Konsul Poliklinik"));
                                    ?>
                                </td>
                                <td style="width: 60px; text-align: center;">
                                    <?php
                                    echo CHtml::link("<i class='icon-form-periksa'></i> ",  Yii::app()->createUrl(
                                        "rawatJalan/daftarPasien/detailRehab",
                                        array("id" => $modKunjungan->pendaftaran_id)
                                    ), array("id" => "operasi_" . $modKunjungan->no_pendaftaran, "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Rehab Medis", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Rehab Medis"));
                                    ?>
                                </td>
                                <td style="width: 60px; text-align: center;">
                                    <?php
                                    echo CHtml::link("<i class='icon-form-periksa'></i> ",  Yii::app()->createUrl(
                                        "rawatJalan/daftarPasien/detailMCU",
                                        array("id" => $modKunjungan->pendaftaran_id)
                                    ), array("id" => "operasi_" . $modKunjungan->no_pendaftaran, "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail MCU", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat MCU"));

                                    ?>
                                </td>
                                <td style="width: 60px; text-align: center;">
                                    <?php
                                    echo CHtml::link("<i class='icon-form-roperasi'></i> ",  Yii::app()->createUrl(
                                        "rawatJalan/daftarPasien/detailOperasi",
                                        array("id" => $modKunjungan->pendaftaran_id)
                                    ), array("id" => "operasi_" . $modKunjungan->no_pendaftaran, "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Pelayanan/Operasi", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Pelayanan/Operasi"));

                                    ?>
                                </td>
                                <td colspan="2" style="width: 60px; text-align: center;">
                                    <?php
                                    echo CHtml::link("<i class='icon-form-persalinan'></i> ",  Yii::app()->createUrl(
                                        "rawatJalan/daftarPasien/detailPersalinan",
                                        array("id" => $modKunjungan->pendaftaran_id)
                                    ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Persalinan", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Pelayanan/Persalinan"));

                                    $cekParto = PemeriksaanpartografT::model()->findByAttributes(array('pendaftaran_id' => $modKunjungan->pendaftaran_id));

                                    if (!empty($cekParto)) {
                                        echo "<hr>";
                                        echo CHtml::link(Yii::t('mds', '{icon} Depan', array('{icon}' => '<i class="icon-form-periksa"></i>')), 'javascript:void(0);', array('onclick' => "printPartograf(" . $modKunjungan->pendaftaran_id . ");return false",)) . "<br>";
                                        echo CHtml::link(Yii::t('mds', '{icon} Belakang', array('{icon}' => '<i class="icon-form-periksa"></i>')), 'javascript:void(0);', array('onclick' => "printPartografBelakang(" . $modKunjungan->pendaftaran_id . ");return false",));

                                        //echo "<hr>";
                                        //echo CHtml::link("<i class='icon-form-periksa'></i> ",  Yii::app()->controller->createUrl("daftarPasien/detailPartograf",
                                        //array("id"=>$modKunjungan->pendaftaran_id)),array("pendaftaran_id"=>"$modKunjungan->pendaftaran_id","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Partograf", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Pemeriksaan Partograf")); 
                                    }
                                    ?>
                                </td>
                                <td colspan="2" style="width: 60px; text-align: center;">
                                    <?php
                                    //var_dump(Yii::app()->controller->module->id);
                                    echo CHtml::link("<i class='icon-form-periksa'></i> ",  Yii::app()->createUrl(
                                        "rawatJalan/daftarPasien/detailGinekologi",
                                        array("id" => $modKunjungan->pendaftaran_id)
                                    ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Ginekologi", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Pelayanan/Ginekologi"));

                                    ?>
                                </td>
                                <td colspan="2" style="width: 60px; text-align: center;">
                                    <?php
                                    echo CHtml::link("<i class='icon-form-kelahiran'></i> ",  Yii::app()->createUrl(
                                        "rawatJalan/daftarPasien/detailKelahiran",
                                        array("id" => $modKunjungan->pendaftaran_id)
                                    ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Kelahiran", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Pelayanan/Kelahiran"));

                                    ?>
                                </td>
                                <?php /* <td><?php $this->renderPartial('rawatJalan.views._periksaDataPasien._operasi', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id, 'pasien_id'=>$modKunjungan->pasien_id)); ?></td> */ ?>
                                <td><?php $this->renderPartial('rawatJalan.views._periksaDataPasien._rujukKeluar', array('pendaftaran_id' => $modKunjungan->pendaftaran_id, 'pasien_id' => $modKunjungan->pasien_id)); ?></td>
                                <td style="width: 60px; text-align: center;">
                                    <?php
                                    echo CHtml::link("<i class='icon-bayarklaim'></i> ",  Yii::app()->createUrl(
                                        "rawatJalan/daftarPasien/detailTerapi",
                                        array("id" => $modKunjungan->pendaftaran_id)
                                    ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Terapi", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Resep Dokter/Terapi"))

                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td colspan="2"></td>
                            <td colspan="4"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
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