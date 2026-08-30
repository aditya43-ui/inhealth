<?php $modPendaftaran = new RJPendaftaranT; ?>
<?php $this->widget('bootstrap.widgets.BootPager', array(
    'pages' => $pages,
    'header' => '<div class="pagination" id="pagin">',
    'footer' => '</div>',
)); ?>
<table class="items table table-striped table-bordered table-condensed">
    <thead>
        <tr>
            <?php if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RJ) { ?>
            <th rowspan="2">Memiliki Kriteria Masuk PRMRJ</th>
            <?php } ?>
            <th rowspan="2">Tgl. Kunjungan/<br>No. Pendaftaran</th>
            <th rowspan="2">Diagnosis</th>
            <th rowspan="2" hidden>Pengkajian Keperawatan Jiwa</th>
            <th colspan="2">Pemeriksaan Penunjang</th>
            <!-- <th rowspan="2">Konsul Poliklinik</th>
            <th rowspan="2">Rehab</th>
            <th rowspan="2">MCU</th>
            <th rowspan="2">Bedah/Operasi</th> -->
            <!-- <th rowspan="2" colspan="2">Persalinan</th>
            <th rowspan="2" colspan="2">Ginekologi</th>
            <th rowspan="2" colspan="2">Kelahiran</th> -->
            <!--th rowspan="2">Operasi</th-->
            <!-- <th rowspan="2">Dirujuk Keluar</th>
            <th rowspan="2">Riwayat Rekam Medis Elektronik Pasien</th> -->
            <?php if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RJ) { ?>
                    <th rowspan="2">Tambah ke PRMRJ</th>
                <?php } ?>
        </tr>
        <tr>
            <!-- <th>Tindakan</th>
            <th>Terapi</th>
            <th>Pemakaian Bahan</th> -->
            <th>Ke penunjang</th>
            <th>
                <?php
                $pasien_id = $_GET['id'];
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
        <?php if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RJ) { ?>
                        <td>
                            <?php
                            $criteriaMorbid = new CDbCriteria();
                            $criteriaMorbid->join = "JOIN diagnosa_m ON diagnosa_m.diagnosa_id = t.diagnosa_id";
                            $criteriaMorbid->addCondition("diagnosa_m.dtd_id = 3 OR diagnosa_m.klasifikasidiagnosa_id in (643,1010,11,12) OR diagnosa_m.diagnosa_kode = 'I50.0'");
                            $criteriaMorbid->addCondition('t.kelompokdiagnosa_id = 3');
                            $criteriaMorbid->addCondition('t.pendaftaran_id = ' . $modKunjungan->pendaftaran_id);
                            $criteriaMorbid->addCondition('t.pasienadmisi_id IS NULL');
                            $cekPasienMordbid_1 = PasienmorbiditasT::model()->findAll($criteriaMorbid);
                            $cekPasienMordbid_2 = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $modKunjungan->pendaftaran_id, 'pasienadmisi_id' => null));
    
                            $cekPasienPunjang = PasienmasukpenunjangT::model()->findAllByAttributes(array('pendaftaran_id' => $modKunjungan->pendaftaran_id, 'pasienadmisi_id' => null));
                            $cekAnamnesaPasien = AnamnesaT::model()->findAllByAttributes(array('pendaftaran_id' => $modKunjungan->pendaftaran_id, 'pasienadmisi_id' => null), array('condition' => 'riwayatalergiobat IS NOT NULL'));
    
                            if ((count($cekPasienMordbid_1) > 0) || (count($cekPasienMordbid_2) >= 3) || (count($cekPasienPunjang) >= 3) || (count($cekAnamnesaPasien) > 0)) {
                                $status_prmrj = '<button class="btn btn-red nohover">Ya</button>';
                            } else {
                                $status_prmrj = '<button class="btn btn-orange nohover">Tidak</button>';
                            }
    
                            echo $status_prmrj;
                            ?>
                        </td>
                    <?php } ?>
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
            <td><?php $this->renderPartial('rawatJalan.views._periksaDataPasien._diagnosa', array('pendaftaran_id' => $modKunjungan->pendaftaran_id)); ?>
            </td>


            <td style="width: 60px; text-align: center;" hidden>
                <?php
                    echo CHtml::link("<i class='icon-form-periksa'></i> ",  Yii::app()->controller->createUrl(
                        "daftarPasien/detailKeperawatanJiwa",
                        array("id" => $modKunjungan->pendaftaran_id)
                    ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Kajian Keperawatan Jiwa", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Kajian Keperawatan Jiwa"));

                    ?>
            </td>

            <td>
                <div style=""><ul><?php $this->renderPartial('rawatJalan.views._periksaDataPasien._kepenunjang', array('pendaftaran_id' => $modKunjungan->pendaftaran_id)); ?>
                </ul></div>
            </td>
            <td style="text-align: center;">
                <?php

                    echo CHtml::link("<i class='icon-bayarklaim'></i> ",  Yii::app()->controller->createUrl(
                        "daftarPasien/hasilPemeriksaanPenunjang",
                        array("id" => $modKunjungan->pendaftaran_id)
                    ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialogPenunjang", "rel" => "tooltip", "title" => "Klik untuk Detail Hasil Pemeriksaan Penunjang",
                     "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailDataPenunjang').dialog('open');", "dialog-text" => "Riwayat Konsul Poliklinik"));
                
                ?>
            </td>

            <?php if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RJ) { ?>
                    <td>
                        <center>
                            <?php
                            $pdftrn = PendaftaranT::model()->findByPk($modKunjungan->pendaftaran_id);
                            if ($pdftrn->isprmrj) {
                                echo '<span><i class="icon-form-check"></i> Ditambahkan</span>';
                            } else {
                                echo CHtml::link('<i class="entypo-plus-circled" style="font-size:16pt"></i>', 'javascript:void(0)', array('onclick' => 'updatePRMRJ(' . $modKunjungan->pendaftaran_id . ')'));
                            }
                            ?>
                        </center>
                    </td>
        <?php } ?>

            <?php /* <td><?php $this->renderPartial('rawatJalan.views._periksaDataPasien._operasi', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id, 'pasien_id'=>$modKunjungan->pasien_id)); ?>
            </td> */ ?>

        </tr>
        <?php } ?>
    </tbody>
    <!-- <tfoot>
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
    </tfoot> -->
</table>

<script>
/**
 * print pemerikaan partograf
 * @returns {undefined} */
function printPartograf(id) {
    window.open("<?php echo $this->createUrl('printDetailPartograf'); ?>&id=" + id, "", 'location=_new, width=1024px');

}

function printPartografBelakang(id) {
    window.open("<?php echo $this->createUrl('printDetailPartografBelakang'); ?>&id=" + id, "",
        'location=_new, width=1024px');

}

function getRiwayatPeriksa(id) {
    window.open("<?php echo $this->createUrl('getRiwayatAllPemeriksaan') ?>&id=" + id, "",
        'location=_new, width=600px, height=480px, left=340px, top=100px');
}

function getRiwayatPeriksaCPPT(id) {
    window.open("<?php echo $this->createUrl('rawatDarurat/cppt/InformasiRiwayatPasien') ?>&id=" + id, "",
        'location=_new, width=600px, height=480px, left=340px, top=100px');
}

<?php if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RJ) { ?>
        function updatePRMRJ(pendaftaran_id) {
            myConfirm("Tambahkan Kunjungan ke Profil Ringkas Medis Rawat Jalan ?", "Peringatan", function (r) {
                if (r) {
                    var grid_id = $(parent.document).find('.isContent').find('#form-riwayatprofil').find('#content-riwayatprofil');
                    $.post('<?php echo $this->createUrl('/rawatJalan/daftarPasien/updatePasienPRMRJ'); ?>', {pendaftaran_id: pendaftaran_id}, function (data) {
                        if (data.sukses == 1) {
                            myAlert(data.msg);
                            $.post('<?php echo $this->createUrl('/rawatJalan/pemeriksaanPasien/CheckData'); ?>', {pendaftaran_id: pendaftaran_id}, function (data) {
                                if (data != null) {
                                    grid_id.find('.accordion-inner').html('');
                                    grid_id.find('.accordion-inner').html(data);
                                    window.location.reload(true);
                                }
                            }, 'html');
                        } else {
                            myAlert(data.msg);
                        }
                    }, 'json');
                }
            });
        }
<?php } ?>
</script>