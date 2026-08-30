<?php
$this->breadcrumbs = array(
    'Informasi Pencarian Pasien' => Yii::app()->request->getUrlReferrer(),
    'Riwayat Pasien',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-clock"></i> Detail <b>Riwayat Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Data <b>Pasien</b>
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial("pendaftaranPenjadwalan.views._periksaDataPasien/_dataPasien", array('modPasien' => $modPasien)); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-book-open"></i> Detail <b>Riwayat Pasien</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $modPendaftaran = new RJPendaftaranT; ?>
                <?php $this->widget('bootstrap.widgets.BootPager', array(
                    'pages' => $pages,
                    'header' => '<div class="pagination" id="pagin">',
                    'footer' => '</div>',
                )); ?>
                <table class="items table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th rowspan="2">Tgl. Kunjungan/<br>No. Pendaftaran</th>
                            <th colspan="2">
                                <p style="margin: 0; text-align: center;">Persalinan</p>
                            </th>
                            <th colspan="2">
                                <p style="margin: 0; text-align: center;">Kelahiran</p>
                            </th>
                            <!--<th colspan ="2"><p style="margin: 0; text-align: center;">Anamnesis</p></th>-->
                            <!--<th rowspan ="2"><p style="margin: 0; text-align: center;">Pemeriksaan Fisik</p></th>-->
                            <th colspan="2" rowspan="2">
                                <p style="margin: 0; text-align: center;">Pemeriksaan Penunjang</p>
                            </th>
                            <th valign='middle' rowspan="2">
                                <p style="margin: 0; text-align: center;">Konsul Poliklinik</p>
                            </th>
                            <th colspan="7">
                                <p style="margin: 0; text-align: center;">Pelayanan</p>
                            </th>
                            <th valign='middle' rowspan="2">
                                <p style="margin: 0; text-align: center;">Diagnosis</p>
                            </th>
                            <th valign='middle' rowspan="2">
                                <p style="margin: 0; text-align: center;">Operasi</p>
                            </th>
                            <th valign='middle' rowspan="2">
                                <p style="margin: 0; text-align: center;">KIE</p>
                            </th>
                            <th valign='middle' rowspan="2">
                                <p style="margin: 0; text-align: center;">Dokter Pemeriksa</p>
                            </th>
                            <th valign='middle' rowspan="2">
                                <p style="margin: 0; text-align: center;">Surat Persetujuan/ Penolakan</p>
                            </th>
                            <!--<th valign='middle' rowspan="2"><p style="margin: 0; text-align: center;">Dirujuk Keluar</p></th>-->
                        </tr>
                        <tr>
                            <th colspan="2">
                                <p style="margin: 0; text-align: center;">&nbsp;</p>
                            </th>
                            <th colspan="2">
                                <p style="margin: 0; text-align: center;">&nbsp;</p>
                            </th>
                            <th>
                                <p style="margin: 0; text-align: center;">Tindakan</p>
                            </th>
                            <th>
                                <p style="margin: 0; text-align: center;">Terapi</p>
                            </th>
                            <th>
                                <p style="margin: 0; text-align: center;">Pemakaian Bahan</p>
                            </th>
                            <th>
                                <p style="margin: 0; text-align: center;">RD</p>
                            </th>
                            <th>
                                <p style="margin: 0; text-align: center;">RJ</p>
                            </th>
                            <th>
                                <p style="margin: 0; text-align: center;">RI</p>
                            </th>
                            <th>
                                <p style="margin: 0; text-align: center;">VK</p>
                            </th>
                            <!--<th colspan="5"><p style="margin: 0; text-align: center;">&nbsp;</p></th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($modKunjungan as $modKunjungan) { ?>
                            <tr>
                                <td><?php echo $modKunjungan->no_pendaftaran; ?><br><?php echo $modKunjungan->tgl_pendaftaran; ?></td>
                                <td colspan="2" style="text-align: center;">
                                    <?php

                                    echo CHtml::link("<i class='icon-form-persalinan'></i> <br>Detail",  Yii::app()->controller->createUrl(
                                        "detailPersalinanPelayanan",
                                        array("pendaftaran_id" => $modKunjungan->pendaftaran_id)
                                    ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Persalinan", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Pelayanan/Persalinan"));

                                    $cekParto = PemeriksaanpartografT::model()->findByAttributes(array('pendaftaran_id' => $modKunjungan->pendaftaran_id));

                                    if (!empty($cekParto)) {
                                        echo "<hr>";
                                        echo CHtml::link(Yii::t('mds', '{icon} <br>Depan', array('{icon}' => '<i class="icon-form-periksa"></i>')), 'javascript:void(0);', array('onclick' => "printPartograf(" . $modKunjungan->pendaftaran_id . ");return false",)) . "<br>";
                                        echo "<br>";
                                        echo CHtml::link(Yii::t('mds', '{icon} <br>Belakang', array('{icon}' => '<i class="icon-form-periksa"></i>')), 'javascript:void(0);', array('onclick' => "printPartografBelakang(" . $modKunjungan->pendaftaran_id . ");return false",));

                                        //echo "<hr>";
                                        //echo CHtml::link("<i class='icon-form-periksa'></i> ",  Yii::app()->controller->createUrl("daftarPasien/detailPartograf",
                                        //array("id"=>$modKunjungan->pendaftaran_id)),array("pendaftaran_id"=>"$modKunjungan->pendaftaran_id","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Partograf", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Pemeriksaan Partograf")); 
                                    }

                                    ?>
                                </td>
                                <td colspan="2" style="text-align: center;">
                                    <?php
                                    echo CHtml::link("<i class='icon-form-kelahiran'></i> <br>Detail",  Yii::app()->createUrl(
                                        Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . "/detailKelahiran",
                                        array("id" => $modKunjungan->pendaftaran_id)
                                    ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Kelahiran", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Pelayanan/Kelahiran"));

                                    ?>
                                </td>
                                <!--<td colspan="2">
                        <?php
                            echo CHtml::link("<i class='icon-form-anamnesa'></i> <br>Detail",  Yii::app()->createUrl(
                                Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . "/detailAnamnesa",
                                array("id" => $modKunjungan->pendaftaran_id)
                            ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Anamnesis", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Pelayanan/Anamnesis"));

                        ?>
                    </td>-->
                                <!--<td>
                        <?php
                            echo CHtml::link("<i class='icon-form-periksa'></i> <br>Detail",  Yii::app()->createUrl(
                                Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . "/detailPeriksaFisik",
                                array("id" => $modKunjungan->pendaftaran_id)
                            ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Periksa Fisik", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Pelayanan/Periksa Fisik"));

                        ?>
                    </td>-->

                                <td colspan="2">
                                    <ul><?php $this->renderPartial('pendaftaranPenjadwalan.views._periksaDataPasien._kepenunjang', array('pendaftaran_id' => $modKunjungan->pendaftaran_id)); ?></ul>
                                </td>

                                <td style="text-align: center;"><?php // $this->renderPartial('pendaftaranPenjadwalan.views._periksaDataPasien._konsulpoli', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id)); echo"&nbsp &nbsp";
                                                                echo CHtml::link("<i class='icon-konsulpoli' style='margin: 6px;'></i> <br>Detail",  Yii::app()->createUrl(
                                                                    Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . "/detailKonsul",
                                                                    array("id" => $modKunjungan->pendaftaran_id)
                                                                ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Konsul", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Konsul Poliklinik"));
                                                                ?>
                                </td>
                                <td style="text-align: center;"><?php //$this->renderPartial('/_periksaDataPasien/_tindakan', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id, 'pasien_id'=>$modKunjungan->pasien_id)); 
                                                                ?>
                                    <?php //if (count((array)$modKunjungan->tindakanpelayanan->daftartindakan_id) != 0){
                                    echo CHtml::link("<i class='icon-form-tindakan'></i> <br>Detail",  Yii::app()->createUrl(
                                        Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . "/detailTindakan",
                                        array("id" => $modKunjungan->pendaftaran_id)
                                    ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Tindakan", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Pelayanan/Tindakan"));

                                    //        }
                                    ?>
                                </td>
                                <td style="text-align: center;"><?php //$this->renderPartial('/_periksaDataPasien/_terapi', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id, 'pasien_id'=>$modKunjungan->pasien_id)); 
                                                                ?>
                                    <?php

                                    echo CHtml::link("<i class='icon-form-terapi'></i> <br>Detail",  Yii::app()->controller->createUrl(
                                        '/' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . "/detailTerapi",
                                        array("id" => $modKunjungan->pendaftaran_id)
                                    ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Terapi", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Resep Dokter/Terapi")) ?>
                                </td>
                                <td style="text-align: center;"><?php //$this->renderPartial('/_periksaDataPasien/_pemakaianBahan', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id, 'pasien_id'=>$modKunjungan->pasien_id)); 
                                                                ?>
                                    <?php echo CHtml::link("<i class='icon-form-pakaibahan'></i> <br>Detail",  Yii::app()->createUrl(
                                        Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . "/detailPemakaianBahan",
                                        array("id" => $modKunjungan->pendaftaran_id)
                                    ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Terapi", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Pemakaian Bahan")) ?>
                                </td>
                                <td style="text-align: center;"><?php
                                                                echo !$modKunjungan->cekPemeriksaanInstalasi(Params::INSTALASI_ID_RD) ? "-" : CHtml::link("<i class='icon-form-rd'></i> <br>Detail",  Yii::app()->createUrl(
                                                                    Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . "/detailRd",
                                                                    array("pendaftaran_id" => $modKunjungan->pendaftaran_id)
                                                                ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Riwayat Rawat Darurat", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Rawat Darurat")) ?>
                                </td>
                                <td style="text-align: center;"><?php echo !$modKunjungan->cekPemeriksaanInstalasi(Params::INSTALASI_ID_RJ) ? "-" : CHtml::link("<i class='icon-form-rj'></i> <br>Detail",  Yii::app()->createUrl(
                                                                    Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . "/detailRj",
                                                                    array("pendaftaran_id" => $modKunjungan->pendaftaran_id)
                                                                ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Riwayat Rawat Jalan", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Rawat Jalan")) ?>
                                </td>
                                <td style="text-align: center;"><?php echo !$modKunjungan->cekPemeriksaanInstalasi(array(Params::INSTALASI_ID_RI, Params::INSTALASI_ID_PERAWATAN_INTENSIF)) ? "-" : CHtml::link("<i class='icon-form-ri'></i> <br>Detail",  Yii::app()->createUrl(
                                                                    Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . "/detailRi",
                                                                    array("pendaftaran_id" => $modKunjungan->pendaftaran_id)
                                                                ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Riwayat Rawat Inap", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Rawat Inap")) ?>
                                </td>
                                <td style="text-align: center;"><?php
                                                                echo !$modKunjungan->cekPemeriksaanInstalasi(Params::INSTALASI_ID_PERSALINAN) ? "-" : CHtml::link("<i class='icon-form-persalinan'></i> <br>Detail",  Yii::app()->createUrl(
                                                                    Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . "/detailPersalinan",
                                                                    array("pendaftaran_id" => $modKunjungan->pendaftaran_id)
                                                                ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Riwayat Rawat Darurat", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Persalinan")) ?>
                                </td>
                                <td><?php $this->renderPartial('pendaftaranPenjadwalan.views._periksaDataPasien/_diagnosa', array('pendaftaran_id' => $modKunjungan->pendaftaran_id)); ?></td>
                                <td style="text-align: center;">
                                    <?php
                                    echo CHtml::link("<i class='icon-form-roperasi'></i> <br>Detail",  Yii::app()->controller->createUrl(
                                        "detailOperasi",
                                        array("id" => $modKunjungan->pendaftaran_id)
                                    ), array("id" => "operasi_" . $modKunjungan->no_pendaftaran, "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Pelayanan / Operasi", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Pelayanan/Operasi"));

                                    ?>
                                </td>
                                
                                <!-- KIE -->
                                <td>
                                    <?php 
                                    
                                    $kie = KiepasienT::model()->findByAttributes(array('pendaftaran_id' => $modKunjungan->pendaftaran_id));
                                    //echo CJSON::encode($kie);
                                    // $modKieFarmasi = PenjualanresepT::model()->findByAttributes(array('pendaftaran_id' => $modKunjungan->pendaftaran_id));
                                    //  echo CJSON::encode($modKieFarmasi);

                                    // if(!empty($kie || $modKieFarmasi)){
                                        if(!empty($kie)){
                                        echo CHtml::link("<i class='icon-form-tindakan'></i> ",  Yii::app()->controller->createUrl("/rawatJalan/daftarPasien/detailKIE",
                                            array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail KIE", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat KIE"));
                                    }else {
                                        echo "-";
                                    }
                                    
                                    ?>
                                </td>

                                <td><?php echo isset($modKunjungan->pegawai_id) ? $modKunjungan->pegawai->nama_pegawai : ' - '; ?></td>
                                <td style="text-align: center;">
                                    <?php echo CHtml::link("<i class='icon-form-detail'></i><br>Tindakan",  Yii::app()->controller->createUrl(
                                        "detailPersetujuanTindakan",
                                        array("id" => $modKunjungan->pendaftaran_id)
                                    ), array("id" => "persetujuantindakan_" . $modKunjungan->no_pendaftaran, "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Persetujuan/Penolakan Tindakan", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Persetujuan/Penolakan Tindakan")); ?>
                                    <br><?php echo CHtml::link("<i class='icon-form-detail'></i><br>Inform Consent",  Yii::app()->controller->createUrl(
                                            "detailInformConsent",
                                            array("id" => $modKunjungan->pendaftaran_id)
                                        ), array("id" => "persetujuantindakan_" . $modKunjungan->no_pendaftaran, "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Persetujuan/Penolakan Inform Consent", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Inform Consent")); ?>
                                    <br><?php echo CHtml::link("<i class='icon-form-detail'></i><br>Anestesi",  Yii::app()->controller->createUrl(
                                            "detailTindakanAnestesi",
                                            array("id" => $modKunjungan->pendaftaran_id)
                                        ), array("id" => "persetujuantindakan_" . $modKunjungan->no_pendaftaran, "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Persetujuan/Penolakan Anestesi", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Anestesi")); ?>
                                    <br><?php
                                        $umum = SuratpersetujuanumumT::model()->findByAttributes(array(
                                            'pendaftaran_id' => $modKunjungan->pendaftaran_id,
                                        ));
                                        if (!empty($umum)) {
                                            echo CHtml::link(
                                                "<icon class='icon-form-detail'></icon><br>General<br>Consent",
                                                Yii::app()->controller->createUrl('detailGeneralConsent', array('pendaftaran_id' => $modKunjungan->pendaftaran_id)),
                                                array("target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk melihat General Consent", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "General Consent")
                                            );
                                        } ?>
                                </td>
                                <!--<td><?php //$this->renderPartial('pendaftaranPenjadwalan.views._periksaDataPasien/_rujukKeluar', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id, 'pasien_id'=>$modKunjungan->pasien_id)); 
                                        ?></td>-->
                            </tr>
                        <?php } ?>
                    </tbody>
                    <!--<tfoot><tr>
                    <td></td>
                    <td colspan="2"></td>
                    <td colspan="2"></td>
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
                </tr></tfoot>-->
                </table>
            </div>
        </div>

        <?php
        //========= Dialog Detail Hasil Pemeriksaaan Lab =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogDetailHasilLab',
            'options' => array(
                'title' => 'Data Hasil Pemeriksaan',
                'autoOpen' => false,
                'modal' => true,
                'width' => 1000,
                'height' => 550,
                'resizable' => false,
            ),
        ));
        ?>
        <iframe src="" name="pesan" width="100%" height="98%">
        </iframe>
        <?php
        $this->endWidget();
        //=======================================================================
        ?>

        <?php
        //========= Dialog Detail Tindakan, Terapi dan Pemakaian Bahan =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogDetailData',
            'options' => array(
                'title' => 'Detail Data',
                'autoOpen' => false,
                'modal' => true,
                'width' => 1000,
                'height' => 550,
                'resizable' => false,
            ),
        ));
        ?>
        <iframe src="" name="detailDialog" width="100%" height="98%">
        </iframe>
        <?php
        $this->endWidget();
        ?>
    </div>
</div>
<script>
    function printPartograf(id) {
        window.open("<?php echo $this->createUrl('printDetailPartograf'); ?>&id=" + id, "", 'location=_new, width=1024px');

    }

    function printPartografBelakang(id) {
        window.open("<?php echo $this->createUrl('printDetailPartografBelakang'); ?>&id=" + id, "", 'location=_new, width=1024px');

    }
</script>