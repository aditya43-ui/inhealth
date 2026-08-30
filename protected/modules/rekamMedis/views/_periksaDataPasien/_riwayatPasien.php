<?php
$this->breadcrumbs = array(
    'Informasi Pasien Lama' => Yii::app()->request->getUrlReferrer(),
    'Detail Riwayat Pasien'
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Detail <b>Riwayat Pasien</b>
        </div>
    </div>
    <!-- <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Detail <b>Riwayat Pasien</b>
                </div>
            </div> -->
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
                    <th rowspan="2" colspan="2">Persalinan</th>
                    <th rowspan="2" colspan="2">Kelahiran</th>
                    <th rowspan="2" colspan="2">Anamnesis</th>
                    <th rowspan="2">Pemeriksaan Fisik</th>
                    <th colspan="2">Pemeriksaan Penunjang</th>
                    <th rowspan="2">Konsul Poliklinik</th>
                    <th colspan="3">Pelayanan</th>
                    <th rowspan="2">Diagnosis</th>
                    <th rowspan="2">Operasi</th>
                    <th rowspan="2">Dokter Pemeriksa</th>
                    <th rowspan="2">Dirujuk Keluar</th>
                </tr>
                <tr>
                    <th>Ke penunjang</th>
                    <th>Hasil</th>
                    <th>Tindakan</th>
                    <th>Terapi</th>
                    <th>Pemakaian Bahan</th>
                    <!--<th colspan="5"><p style="margin: 0; text-align: center;">&nbsp;</p></th>-->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($modKunjungan as $modKunjungan) { ?>
                    <tr>
                        <td><?php echo $modKunjungan->no_pendaftaran; ?><br><?php echo $modKunjungan->tgl_pendaftaran; ?></td>
                        <td colspan="2" style="width: 60px; text-align: center;">
                            <?php
                            echo CHtml::link("<i class='icon-form-persalinan'></i> ",  Yii::app()->createUrl(
                                "rawatJalan/daftarPasien/detailPersalinan",
                                array("id" => $modKunjungan->pendaftaran_id)
                            ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Persalinan", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Pelayanan/Persalinan"));
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
                        <td colspan="2" style="width: 60px; text-align: center;">
                            <?php
                            echo CHtml::link("<i class='icon-form-anamnesa'></i> ",  Yii::app()->createUrl(
                                "rawatJalan/daftarPasien/detailAnamnesa",
                                array("id" => $modKunjungan->pendaftaran_id)
                            ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Anamnesis", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Pelayanan/Anamnesis"));
                            ?>
                        </td>
                        <td style="width: 60px; text-align: center;">
                            <?php
                            echo CHtml::link("<i class='icon-form-periksa'></i> ",  Yii::app()->createUrl(
                                "rawatJalan/daftarPasien/detailPeriksaFisik",
                                array("id" => $modKunjungan->pendaftaran_id)
                            ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Periksa Fisik", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Pelayanan/Periksa Fisik"));
                            ?>
                        </td>
                        <td>
                            <ul><?php $this->renderPartial('/_periksaDataPasien/_kepenunjang', array('pendaftaran_id' => $modKunjungan->pendaftaran_id)); ?></ul>
                        </td>
                        <td style="width: 60px; text-align: center;">
                            <?php
                            //                        if(count((array)$modKunjungan->hasilpemeriksaanlab) != 0){
                            //                            echo CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl("daftarPasien/detailHasilLab",array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"pesan","rel"=>"tooltip","title"=>"Klik untuk Detail Hasil Pemeriksaan Lab", "onclick"=>"window.parent.$('#dialogDetailHasilLab').dialog('open');"));
                            //                        }
                            ?>
                            <?php
                            $modMasukPenunjang = RJPasienMasukPenunjangT::model()->with('ruangan')->findAllByAttributes(array('pendaftaran_id' => $modKunjungan->pendaftaran_id));
                            $jumlah = count((array)$modMasukPenunjang);
                            $result = "";
                            foreach ($modMasukPenunjang as $row) {
                                $modHasilLab = RJHasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $row->pasienmasukpenunjang_id));
                                $modHasilRad = HasilpemeriksaanradT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $row->pasienmasukpenunjang_id));
                                if ($modHasilLab) { //cek jika sudah ada hasil lab
                                    $result .= "" . CHtml::link("<i class='icon-form-detail'></i> ", Yii::app()->createUrl("rawatJalan/daftarPasien/detailHasilLab", array("pendaftaran_id" => $modKunjungan->pendaftaran_id, "pasien_id" => $modKunjungan->pasien_id, "pasienmasukpenunjang_id" => $row->pasienmasukpenunjang_id)), array("id" => "$modKunjungan->no_pendaftaran", "target" => "pesan", "rel" => "tooltip", "title" => "Klik untuk Detail Hasil Pemeriksaan '" . $row->ruangan->ruangan_nama . "'", "onclick" => "window.parent.$('#dialogDetailHasilLab').dialog('open');")) . "<br>";
                                } elseif ($modHasilRad) { //jika radiologi
                                    $result .= "" . CHtml::link("<i class='icon-form-detail'></i> ", Yii::app()->createUrl("rawatJalan/daftarPasien/detailHasilRad", array("pendaftaran_id" => $modKunjungan->pendaftaran_id, "pasien_id" => $modKunjungan->pasien_id, "pasienmasukpenunjang_id" => $row->pasienmasukpenunjang_id)), array("id" => "$modKunjungan->no_pendaftaran", "target" => "pesan", "rel" => "tooltip", "title" => "Klik untuk Detail Hasil Pemeriksaan '" . $row->ruangan->ruangan_nama . "'", "onclick" => "window.parent.$('#dialogDetailHasilLab').dialog('open');")) . "<br>";
                                } else {
                                    $result .= "<br>";
                                }
                            }
                            echo $result;
                            ?></ul>
                        </td>
                        </td style="width: 60px; text-align: center;">
                        <td><?php $this->renderPartial('/_periksaDataPasien/_konsulpoli', array('pendaftaran_id' => $modKunjungan->pendaftaran_id));
                            echo "&nbsp &nbsp";
                            echo CHtml::link("<i class='icon-konsulpoli'></i> ",  Yii::app()->createUrl(
                                "rawatJalan/daftarPasien/detailKonsul",
                                array("id" => $modKunjungan->pendaftaran_id)
                            ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Konsul", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Konsul Poliklinik"));
                            ?>
                        </td>
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
                            ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Terapi", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Pemakaian Bahan")) ?>
                        </td>
                        <td><?php $this->renderPartial('/_periksaDataPasien/_diagnosa', array('pendaftaran_id' => $modKunjungan->pendaftaran_id)); ?></td>
                        <td><?php $this->renderPartial('/_periksaDataPasien/_operasi', array('pendaftaran_id' => $modKunjungan->pendaftaran_id, 'pasien_id' => $modKunjungan->pasien_id)); ?></td>
                        <td><?php echo isset($modKunjungan->pegawai_id) ? $modKunjungan->pegawai->nama_pegawai : ' - '; ?></td>
                        <td><?php $this->renderPartial('/_periksaDataPasien/_rujukKeluar', array('pendaftaran_id' => $modKunjungan->pendaftaran_id, 'pasien_id' => $modKunjungan->pasien_id)); ?></td>
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
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- </div>
    </div> -->
</div>
<?php
//========= Dialog Detail Hasil Pemeriksaaan Lab =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailHasilLab',
    'options' => array(
        'title' => 'Data Hasil Pemeriksaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="pesan" width="100%" height="500">
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
        'width' => 700,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="detailDialog" width="100%" height="500">
</iframe>
<?php
$this->endWidget();
?>