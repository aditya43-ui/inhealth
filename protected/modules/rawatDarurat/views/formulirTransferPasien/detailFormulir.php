<?php
    $this->breadcrumbs = array(
        'Detail Formulir Transfer Pasien',
    );
?>

<style type="text/css">
    .tablefont td{
        color: black;
        padding: 5px;
    }
    .borderclass {
        border: 1px solid black;
    }
</style>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title" style="width: 100%">
            <span style="float: left !important; width:80% !important;"><b>Detail Formulir Transfer Pasien</b></span><span style="float: right !important;">
               <?php
                if (!empty(Yii::app()->request->urlReferrer)) {
                    echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', Yii::app()->request->urlReferrer, array('class'=>'btn btn-red', 'style'=>'color: white;'));
                } ?>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
            if(empty($_GET['frame'])){ 
                $this->renderPartial($this->path_view.'_dataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien)); 
            } 
        ?>
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title"><strong>Data Transfer Pasien</strong></div>
            </div>
            <div class="panel-body">
                <table width="100%">
                    <tr>
                        <td width="50%">
                            <table width="100%" class="tablefont">
                                <tr>
                                    <td width="200px">Ruangan Asal</td>
                                    <td width="10px">:</td>
                                    <td><?php echo $model->ruanganasal->instalasi->instalasi_nama.'/ '.$model->ruanganasal->ruangan_nama; ?></td>
                                </tr>
                                <tr>
                                    <td>Waktu Transfer</td>
                                    <td>:</td>
                                    <td><?php echo $model->waktu_transfer; ?></td>
                                </tr>
                                <tr>
                                    <td>Diagnosa Masuk RS</td>
                                    <td>:</td>
                                    <td><?php echo $model->diagnosamasukrs; ?></td>
                                </tr>
                                <tr>
                                    <td>Dokter Pengirim</td>
                                    <td>:</td>
                                    <td><?php echo $model->dokterpengirim->namaLengkap; ?></td>
                                </tr>
                                <tr>
                                    <td>Petugas menyerahkan pasien</td>
                                    <td>:</td>
                                    <td><?php echo (isset($modProsesTransfer->sebelumtransferpegawaiygmenyerahkan)? $modProsesTransfer->sebelumtransferpegawaiygmenyerahkan->namaLengkap: "-"); ?></td>
                                </tr>
                            </table>
                        </td>
                        <td width="50%" valign="top">
                            <table width="100%" class="tablefont">
                                <tr>
                                    <td width="200px">Tanggal Transfer</td>
                                    <td width="10px">:</td>
                                    <td><?php echo MyFormatter::formatDateTimeForUser($model->tanggal_transfer); ?></td>
                                </tr>
                                <tr>
                                    <td>Ruangan yang dituju</td>
                                    <td>:</td>
                                    <td> <?php echo $model->instalasitujuan->instalasi_nama.'/ '.$model->ruangantujuan->ruangan_nama; ?></td>
                                </tr>
                                <tr>
                                    <td>Waktu Tiba</td>
                                    <td>:</td>
                                    <td> <?php echo (!empty($modProsesTransfer->setelahtransfer_waktutiba)? $modProsesTransfer->setelahtransfer_waktutiba: '-'); ?></td>
                                </tr>
                                <tr>
                                    <td>Indikasi Dirawat</td>
                                    <td>:</td>
                                    <td> <?php echo $model->indikasidirawat; ?></td>
                                </tr>
                                <tr>
                                    <td>Petugas yang menerima pasien</td>
                                    <td>:</td>
                                    <td> <?php echo (isset($modProsesTransfer->setelahtransferpegawaiygmenerima)? $modProsesTransfer->setelahtransferpegawaiygmenerima->namaLengkap: "-"); ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title"><strong>I. Ringkasan Riwayat Pasien</strong></div>
            </div>
            <div class="panel-body">
                <table width="100%" class="tablefont">
                    <tr>
                        <td width="100px">Pukul</td>
                        <td width="10px">:</td>
                        <td><?php echo $model->jamringkas_riwayatpasien; ?></td>
                    </tr>
                </table>
                <br/>
                <table width="100%">
                    <tr>
                        <td colspan="2" style="font-weight: bold; color: black;">Anamnesis</td>
                    </tr>
                    <tr>
                        <td width="50%">
                            <table width="100%" class="tablefont">
                                <tr>
                                    <td width="150px">Keluhan Utama</td>
                                    <td width="10px">:</td>
                                    <td><?php echo $model->dokter_keluhanutama; ?></td>
                                </tr>
                                <tr>
                                    <td width="200px">Riwayat Penyakit</td>
                                    <td width="10px">:</td>
                                    <td><?php echo $model->riwayatpenyakitterdahulu; ?></td>
                                </tr>
                                <tr>
                                    <td>Riwayat Alergi</td>
                                    <td>:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="padding-left: 20px;">
                                        <?php echo $model->riwayatalergi; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Keadaan Umum</td>
                                    <td>:</td>
                                    <td><?php echo $model->dokter_keadaanumum; ?></td>
                                </tr>
                            </table>
                        </td>
                        <td width="50%" valign="top">
                            <table width="100%" class="tablefont">
                                <tr>
                                    <td width="150px">Pemeriksaan Tanda Vital</td>
                                    <td width="10px">:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td style="padding-left:100px">Tensi</td>
                                    <td>:</td>
                                    <td> <?php echo $model->ttvdokter_td_systolic.'/ '.$model->ttvdokter_td_diastolic; ?> mmHg</td>
                                </tr>
                                <tr>
                                    <td style="padding-left:100px">Suhu</td>
                                    <td>:</td>
                                    <td> <?php echo $model->ttvdokter_suhutubuh; ?> &#176 Celcius</td>
                                </tr>
                                <tr>
                                    <td style="padding-left:100px">Nadi</td>
                                    <td>:</td>
                                    <td> <?php echo $model->ttvdokter_nadi; ?> x/menit </td>
                                </tr>
                                <tr>
                                    <td>Alasan Ditransfer</td>
                                    <td>:</td>
                                    <td> <?php echo $model->alasanditransfer; ?></td>
                                </tr>
                                <tr>
                                    <td>Kebutuhan Pelayanan</td>
                                    <td>:</td>
                                    <td> <?php echo $model->kebutuhanpelayanan; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title"><strong>II. Ringkasan Riwayat Pasien</strong></div>
            </div>
            <div class="panel-body">
              <div style="color: black;"><?php echo $model->dokter_ringkasanriwayatpasien; ?></div>
                <!-- <table class="table table-bordered table-condensed">
                    <thead>
                        <th>Tindakan</th>
                    </thead>
                    <tbody>
                <?php //foreach ($modTindakans as $i => $modTindakan) { ?>
                    <tr>
                        <td>
                            <?php //echo $modTindakan->tgl_tindakan; ?> <br/>
                            <?php //echo !empty($modTindakan->tipePaket->tipepaket_nama) ? $modTindakan->tipePaket->tipepaket_nama:"-"; ?> <br/>

                            <?php //echo $modTindakan->daftartindakan->daftartindakan_nama; ?>,
                            <?php //echo $modTindakan->qty_tindakan; ?>
                            <?php //echo $modTindakan->satuantindakan; ?> <br/>

                            Pemeriksa :
                            <?php
                                // echo (isset($modTindakan->dokter1->namaLengkap) ? $modTindakan->dokter1->namaLengkap : '');
                                // echo (!empty($modTindakan->dokterpemeriksa1_id)) ? ',' : '';
                            ?>
                            <?php //echo ((isset($modTindakan->dokter2)) ? $modTindakan->dokter2->namaLengkap : null); echo (!empty($modTindakan->dokterpemeriksa2_id)) ? ',' : ''; ?>
                            <?php //echo ((isset($modTindakan->dokterPendamping)) ? $modTindakan->dokterPendamping->namaLengkap : null); echo (!empty($modTindakan->dokterpendamping_id)) ? ',' : ''; ?>
                            <?php //echo ((isset($modTindakan->dokterAnastesi)) ? $modTindakan->dokterAnastesi->namaLengkap : null); echo (!empty($modTindakan->dokteranastesi_id)) ? ',' : ''; ?>
                            <?php //echo ((isset($modTindakan->dokterDelegasi)) ? $modTindakan->dokterDelegasi->namaLengkap : null); echo (!empty($modTindakan->dokterdelegasi_id)) ? ',' : ''; ?>
                            <?php //echo ((isset($modTindakan->bidan)) ? $modTindakan->bidan->nama_pegawai : null); echo (!empty($modTindakan->bidan_id)) ? ',' : ''; ?>
                            <?php //echo ((isset($modTindakan->bidan2)) ? $modTindakan->bidan2->nama_pegawai : null); echo (!empty($modTindakan->bidan2_id)) ? ',' : ''; ?>
                            <?php //echo ((isset($modTindakan->suster)) ? $modTindakan->suster->nama_pegawai : null); echo (!empty($modTindakan->suster_id)) ? ',' : ''; ?>
                            <?php //echo ((isset($modTindakan->perawat)) ? $modTindakan->perawat->nama_pegawai : null); echo (!empty($modTindakan->perawat_id)) ? ',' : ''; ?>
                            <?php //echo ((isset($modTindakan->perawat2)) ? $modTindakan->perawat2->nama_pegawai : null); echo (!empty($modTindakan->perawat2_id)) ? ',' : ''; ?>
                        </td>
                    </tr>
                <?php //} ?>
                    </tbody>
                </table> -->
            </div>
        </div>
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title"><strong>III. Tindakan Medis yang Sudah Dilakukan</strong></div>
            </div>
            <div class="panel-body">
              <div style="color: black;"><?php echo $model->dokter_pemberianterapi; ?></div>
                <!-- <table class="table table-bordered table-condensed">
                    <thead>
                        <th>Tindakan</th>
                    </thead>
                    <tbody>
                <?php //foreach ($modTindakans as $i => $modTindakan) { ?>
                    <tr>
                        <td>
                            <?php //echo $modTindakan->tgl_tindakan; ?> <br/>
                            <?php //echo !empty($modTindakan->tipePaket->tipepaket_nama) ? $modTindakan->tipePaket->tipepaket_nama:"-"; ?> <br/>

                            <?php //echo $modTindakan->daftartindakan->daftartindakan_nama; ?>,
                            <?php //echo $modTindakan->qty_tindakan; ?>
                            <?php //echo $modTindakan->satuantindakan; ?> <br/>

                            Pemeriksa :
                            <?php
                                // echo (isset($modTindakan->dokter1->namaLengkap) ? $modTindakan->dokter1->namaLengkap : '');
                                // echo (!empty($modTindakan->dokterpemeriksa1_id)) ? ',' : '';
                            ?>
                            <?php //echo ((isset($modTindakan->dokter2)) ? $modTindakan->dokter2->namaLengkap : null); echo (!empty($modTindakan->dokterpemeriksa2_id)) ? ',' : ''; ?>
                            <?php //echo ((isset($modTindakan->dokterPendamping)) ? $modTindakan->dokterPendamping->namaLengkap : null); echo (!empty($modTindakan->dokterpendamping_id)) ? ',' : ''; ?>
                            <?php //echo ((isset($modTindakan->dokterAnastesi)) ? $modTindakan->dokterAnastesi->namaLengkap : null); echo (!empty($modTindakan->dokteranastesi_id)) ? ',' : ''; ?>
                            <?php //echo ((isset($modTindakan->dokterDelegasi)) ? $modTindakan->dokterDelegasi->namaLengkap : null); echo (!empty($modTindakan->dokterdelegasi_id)) ? ',' : ''; ?>
                            <?php //echo ((isset($modTindakan->bidan)) ? $modTindakan->bidan->nama_pegawai : null); echo (!empty($modTindakan->bidan_id)) ? ',' : ''; ?>
                            <?php //echo ((isset($modTindakan->bidan2)) ? $modTindakan->bidan2->nama_pegawai : null); echo (!empty($modTindakan->bidan2_id)) ? ',' : ''; ?>
                            <?php //echo ((isset($modTindakan->suster)) ? $modTindakan->suster->nama_pegawai : null); echo (!empty($modTindakan->suster_id)) ? ',' : ''; ?>
                            <?php //echo ((isset($modTindakan->perawat)) ? $modTindakan->perawat->nama_pegawai : null); echo (!empty($modTindakan->perawat_id)) ? ',' : ''; ?>
                            <?php //echo ((isset($modTindakan->perawat2)) ? $modTindakan->perawat2->nama_pegawai : null); echo (!empty($modTindakan->perawat2_id)) ? ',' : ''; ?>
                        </td>
                    </tr>
                <?php //} ?>
                    </tbody>
                </table> -->
            </div>
        </div>
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title"><strong>IV. Pemberian Terapi</strong></div>
            </div>
            <div class="panel-body">
              <div style="color: black;"><?php echo $model->dokter_tindakanmedisygdilakukan; ?></div>
                <!-- <p style="font-weight: bold; color: black">Pemakaian Bahan Habis Pakai (BHP)</p>
                <table class="table table-bordered table-condensed" style="width: 900px">
                    <thead>
                        <th>Tgl. Pemakaian</th>
                        <th>Jenis Obat Alkes</th>
                        <th>Nama Obat Alkes</th>
                        <th>Jumlah</th>
                    </thead>
                    <tbody>
                <?php

                // if(count($modRiwayatResepBHP) > 0){
                // foreach ($modRiwayatResepBHP as $i => $bmhp) { ?>
                    <tr>
                        <td>
                            <?php //echo $bmhp->tglpelayanan; ?>
                        </td>
                        <td>
                            <?php //echo (isset($bmhp->obatalkes->jenisobatalkes)? $bmhp->obatalkes->jenisobatalkes->jenisobatalkes_nama: ""); ?>
                        </td>
                        <td>
                            <?php //echo $bmhp->obatalkes->obatalkes_nama; ?>
                        </td>
                        <td style="text-align:right;">
                            <?php //echo $bmhp->qty_oa; ?>
                        </td>
                    </tr>
                <?php //} ?>
                <?php  //}else{ ?>
                    <tr>
                        <td colspan="4">Tidak ditemukan hasil.</td>
                    </tr>
                    <?php //} ?>
                    </tbody>
                </table>
                <p style="font-weight: bold; color: black">Resep</p>
                <table class="items table table-bordered table-striped table-condensed" id="tblInputTindakan">
                    <thead>
                        <tr>
                            <th>Tanggal Resep</th>
                            <th>No. Resep</th>
                            <th>Nama Dokter</th>
                            <th>Lihat Detail</th>
                        </tr>
                    </thead>
                    <?php
                    // if(count($modRiwayatResep) > 0){
                    // foreach ($modRiwayatResep as $i => $resep) { ?>
                    <tr>
                        <td><?php //echo $resep->tglreseptur ?></td>
                        <td><?php //echo $resep->noresep ?></td>
                        <?php //$pegawai = PegawaiM::model()->findByPk($resep->pegawai_id) ?>
                        <td><?php //echo  $pegawai->namaLengkap ?></td>
                        <td><center><?php //echo CHtml::link("<i class='icon-eye-open'></i>", 'javascript:void(0)', array('onclick'=>'viewDetailResep("'.$resep->reseptur_id.'","'.$model->pendaftaran_id.'");return false;','rel'=>'tooltip','title'=>'Klik untuk melihat detail resep'));  ?></center></td>
                    </tr>
                    <?php //}  ?>
                   <?php  //}else{ ?>
                    <tr>
                        <td colspan="4">Tidak ditemukan hasil.</td>
                    </tr>
                    <?php //} ?>
                </table> -->
            </div>
        </div>
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title"><strong>V. Lain-Lain</strong></div>
            </div>
            <div class="panel-body">
                <div style="color: black;"><?php echo $model->dokter_catatanlainlain; ?></div>
            </div>
        </div>
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title"><strong>Kategori dan Pendampiangan Pasien Transfer</strong></div>
            </div>
            <div class="panel-body">
                <table width="100%" class="tablefont">
                    <tr>
                        <td width="30%" valign="top">
                            Derajat Pasien : <?php echo (!empty($modProsesTransfer->derajatpasien)?$modProsesTransfer->derajatpasien:"-"); ?>
                        </td>
                        <td width="40%" valign="top">
                            <table width="100%">
                                <tr>
                                    <td>Nama Petugas Pendamping</td>
                                </tr>
                                <?php
                                    if(!empty($modProsesTransfer->prosestransferpasien_id)){
                                        $modPendamping = PegawaipendampingtransferpasienT::model()->findAllByAttributes(array('prosestransferpasien_id'=>$modProsesTransfer->prosestransferpasien_id));

                                        if(count($modPendamping) > 0){
                                            $pendampingvalue = "";
                                            $index= 1;
                                            foreach ($modPendamping as $i => $dataPendamping){
                                                if($i > 0){
                                                    $pendampingvalue .= "<br />";
                                                }
                                                $pendampingvalue .= "<tr><td>".$index.". ".$dataPendamping->pegawai_nama."</td></tr>";
                                                $index++;
                                            }
                                            echo $pendampingvalue;
                                        }
                                    }
                                ?>
                            </table>
                        </td>
                        <td width="30%" valign="top">
                            Catatan : <?php echo (!empty($modProsesTransfer->catatanpendampingtransfer)?$modProsesTransfer->catatanpendampingtransfer:"-"); ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title"><strong>VI. Kondisi Pasien</strong></div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default panel-shadow">
                            <div class="panel-heading">
                                <div class="panel-title" style="width: 100%">
                                    <span style="float: left !important; width:30% !important;"><b>Sebelum Ditransfer</b></span><span style="float: right !important;">
                                      Tanggal & Jam : <?php echo (!empty($modProsesTransfer->sebelumtransfer_tanggal)? MyFormatter::formatDateTimeForUser($modProsesTransfer->sebelumtransfer_tanggal):"-"); ?>
                                    </span>
                                </div>
                            </div>
                            <div class="panel-body">
                                <table width="100%" class="tablefont">
                                    <tr>
                                        <td width="150px">Keadaan Umum</td>
                                        <td width="10px">:</td>
                                        <td><?php echo (!empty($modProsesTransfer->sebelumtransfer_keadaanumum)?$modProsesTransfer->sebelumtransfer_keadaanumum:"-"); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Kesadaran</td>
                                        <td>:</td>
                                        <td><?php echo (!empty($modProsesTransfer->sebelumtransfer_kesadaran)?$modProsesTransfer->sebelumtransfer_kesadaran:"-"); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight: bold; color: black;">Pemeriksaan Tanda Vital</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:100px">Tensi</td>
                                        <td>:</td>
                                        <td> <?php echo (!empty($modProsesTransfer->sebelumtransfer_td_systolic)?$modProsesTransfer->sebelumtransfer_td_systolic:"-").'/ '.(!empty($modProsesTransfer->sebelumtransfer_td_diastolic)?$modProsesTransfer->sebelumtransfer_td_diastolic:"-"); ?> mmHg</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:100px">Suhu</td>
                                        <td>:</td>
                                        <td> <?php echo (!empty($modProsesTransfer->sebelumtransfer_suhutubuh)?$modProsesTransfer->sebelumtransfer_suhutubuh:"-"); ?> &#176 Celcius</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:100px">Nadi</td>
                                        <td>:</td>
                                        <td> <?php echo (!empty($modProsesTransfer->sebelumtransfer_nadi)?$modProsesTransfer->sebelumtransfer_nadi:"-"); ?> x/menit </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; color: black;">Skor EWS</td>
                                        <td>:</td>
                                        <td> <?php echo (!empty($modProsesTransfer->sebelumtransfer_skorews)?$modProsesTransfer->sebelumtransfer_skorews:"-").' '.(!empty($modProsesTransfer->sebelumtransfer_klasifikasi_skorews)?$modProsesTransfer->sebelumtransfer_klasifikasi_skorews:"-"); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight: bold; color: black;">Catatan Penting</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"> <?php echo (!empty($modProsesTransfer->sebelumtransfer_catatanpenting)?$modProsesTransfer->sebelumtransfer_catatanpenting:"-"); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default panel-shadow">
                            <div class="panel-heading">
                                <div class="panel-title" style="width: 100%">
                                    <span style="float: left !important; width:30% !important;"><b>Setelah Ditransfer</b></span><span style="float: right !important;">
                                      Tanggal & Jam : <?php echo (!empty($modProsesTransfer->sebelumtransfer_tanggal)?MyFormatter::formatDateTimeForUser($modProsesTransfer->setelahtransfer_tanggal):"-"); ?>
                                    </span>
                                </div>
                            </div>
                            <div class="panel-body">
                                <table width="100%" class="tablefont">
                                    <tr>
                                        <td width="150px">Keadaan Umum</td>
                                        <td width="10px">:</td>
                                        <td><?php echo (!empty($modProsesTransfer->setelahtransfer_keadaanumum)?$modProsesTransfer->setelahtransfer_keadaanumum:"-"); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Kesadaran</td>
                                        <td>:</td>
                                        <td><?php echo (!empty($modProsesTransfer->setelahtransfer_kesadaran)?$modProsesTransfer->setelahtransfer_kesadaran:"-"); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight: bold; color: black;">Pemeriksaan Tanda Vital</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:100px">Tensi</td>
                                        <td>:</td>
                                        <td> <?php echo (!empty($modProsesTransfer->setelahtransfer_td_systolic)?$modProsesTransfer->setelahtransfer_td_systolic:"-").'/ '.(!empty($modProsesTransfer->setelahtransfer_td_diastolic)?$modProsesTransfer->setelahtransfer_td_diastolic:"-"); ?> mmHg</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:100px">Suhu</td>
                                        <td>:</td>
                                        <td> <?php echo (!empty($modProsesTransfer->setelahtransfer_suhutubuh)?$modProsesTransfer->setelahtransfer_suhutubuh:"-"); ?> &#176 Celcius</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:100px">Nadi</td>
                                        <td>:</td>
                                        <td> <?php echo (!empty($modProsesTransfer->setelahtransfer_nadi)?$modProsesTransfer->setelahtransfer_nadi:"-"); ?> x/menit </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; color: black;">Skor EWS</td>
                                        <td>:</td>
                                        <td> <?php echo (!empty($modProsesTransfer->setelahtransfer_skorews)?$modProsesTransfer->setelahtransfer_skorews:"-").' '.(!empty($modProsesTransfer->setelahtransfer_klasifikasi_skorews)?$modProsesTransfer->setelahtransfer_klasifikasi_skorews:"-"); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight: bold; color: black;">Catatan Penting</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"> <?php echo (!empty($modProsesTransfer->setelahtransfer_catatanpenting)?$modProsesTransfer->setelahtransfer_catatanpenting:"-"); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="form-actions">
                <?php
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'printRiwayat('.$model->formtransferpasien_id.','.$model->pendaftaran_id.',"PRINT")'))."&nbsp&nbsp";
                    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'printRiwayat('.$model->formtransferpasien_id.','.$model->pendaftaran_id.',"PDF")'))."&nbsp&nbsp";
                    echo "&nbsp;";
                    if (!empty(Yii::app()->request->urlReferrer)) {
                        echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', Yii::app()->request->urlReferrer, array('class'=>'btn btn-red', 'style'=>'color: white;'));
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogDetailresep',
    'options'=>array(
        'title'=>'Detail Reseptur',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1002,
        'width'=>800,
        'resizable'=>false,
        'position'=>'top',
    ),
));

    echo '<div id="contentDetailResep"></div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<script type='text/javascript'>
function viewDetailResep(idReseptur,pendaftaran_id)
{
    $.post('<?php echo $this->createUrl('ajaxDetailResep') ?>', {idReseptur: idReseptur, pendaftaran_id: pendaftaran_id}, function(data){
                $('#contentDetailResep').html(data.result);
        }, 'json');
        $('#dialogDetailresep').dialog('open');
}

function printReseptur(caraPrint, idReseptur)
{
    var pendaftaran_id = '<?php echo isset($_GET["pendaftaran_id"]) ? $_GET["pendaftaran_id"] : null ?>';
    window.open('<?php echo $this->createUrl('printReseptur'); ?>&id='+pendaftaran_id+'&idReseptur='+idReseptur+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

function printRiwayat(formtransferpasien_id, pendaftaranid,caraPrint)
{
    window.open('<?php echo $this->createUrl('print'); ?>&formtransferpasien_id='+formtransferpasien_id+'&pendaftaran_id='+pendaftaranid+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=793,height=1122,scrollbars=yes');
}
</script>
