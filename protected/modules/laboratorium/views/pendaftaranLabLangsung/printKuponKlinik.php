<style>
    .barcode-label {
        margin-top: -20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }

    body {
        width: 11cm;
        height: 16.5cm;
        /* border:1px solid; */
    }

    th,
    td,
    div {
        font-family: Times New Roman;
        font-size: 9.7pt;
        line-height: 14px;
        padding: 2px;
        vertical-align: top;
    }

    .judulcontent {
        /* margin:10px 0px; */
    }
</style>
<?php
$format = new MyFormatter;
//echo $this->renderPartial('application.views.headerReport.headerRincianV2');
?>

<table style="width: 100%; border: none;">
    <!-- <thead>
        <tr>
             <td>
                <div class="header"><?php
                                    // echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                                    ?></div>  
            </td>
        </tr>
    </thead> -->
    <tbody>
        <?php
        if (count((array)$modPasienMasukPenunjangs) > 0) {
            foreach ($modPasienMasukPenunjangs as $i => $penunjang) {
        ?>
                <tr>
                    <td>
                        <div class="content">
                            <div class="judulcontent" style="font-size:10pt !important;"><?php echo $judul_print ?></div>
                            <table class="status">

                                <!-- <tr>
            <td align="center" valig="middle" colspan="3">
                Data Pasien
            </td>
        </tr> -->
                                <tr>
                                    <td width="40%">Nomor Lab</td>
                                    <td>:</td>
                                    <td><?php echo !empty($penunjang->noorderlis) ? $penunjang->noorderlis : ""; ?><?php //echo $penunjang->no_masukpenunjang; 
                                                                                                                ?></td>
                                </tr>
                                <tr>
                                    <td>No. RM</td>
                                    <td>:</td>
                                    <td><?php echo $modPasien->no_rekam_medik; ?></td>
                                </tr>
                                <tr>
                                    <td>Tanggal Permintaan</td>
                                    <td>:</td>
                                    <td><?php echo MyFormatter::formatDateTimeId(date('Y/m/d'), strtotime($penunjang->tglmasukpenunjang)); ?></td>
                                </tr>
                                <tr>
                                    <td>Nama Pasien</td>
                                    <td>:</td>
                                    <td><?php echo $modPasien->namadepan . $modPasien->nama_pasien . (!empty($modPasien->nama_bin) ? " (" . $modPasien->nama_bin . ")" : ""); ?></td>
                                </tr>
                                <tr>
                                    <td>NIK</td>
                                    <td>:</td>
                                    <td><?php echo !empty($modPasien->no_identitas_pasien) ? $modPasien->no_identitas_pasien : ""; ?></td>
                                </tr>
                                <tr>
                                    <td>Poli</td>
                                    <td>:</td>
                                    <td><?php echo $penunjang->ruanganasal->ruangan_nama; ?><?php //echo $penunjang->ruangan->ruangan_nama; 
                                                                                            ?></td>
                                </tr>
                                <tr>
                                    <td>Dokter Pengririm</td>
                                    <td>:</td>
                                    <td><?php echo isset($modPendaftaran->pegawai->NamaLengkap) ? $modPendaftaran->pegawai->NamaLengkap : "-"; ?></td>
                                </tr>
                                <tr>
                                    <td>Umur / Jenis Kelamin</td>
                                    <td>:</td>
                                    <td><?php echo $modPendaftaran->umur; ?> / <?php echo $modPasien->jeniskelamin; ?></td>
                                </tr>
                                <tr>
                                    <td>Jaminan</td>
                                    <td>:</td>
                                    <td><?php echo $modPendaftaran->carabayar->carabayar_nama; ?> - <?php echo !empty($modPendaftaran->sep_id) ? $modPendaftaran->sepTs->nokartuasuransi : "-"; ?> / <?php echo !empty($modPendaftaran->sep_id) ? $modPendaftaran->sepTs->nosep : "-"; ?></td>
                                </tr>
                                <tr>
                                    <td>Nomor Telepon</td>
                                    <td>:</td>
                                    <td><?php echo $modPasien->no_mobile_pasien; ?></td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>:</td>
                                    <td><?php echo $modPasien->alamat_pasien; ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>:</td>
                                    <td><?php echo " - " . $modPasien->kecamatan->kecamatan_nama . " - " . $modPasien->kabupaten->kabupaten_nama; ?></td>
                                </tr>
                                <tr>
                                    <td>Diagnosa</td>
                                    <td>:</td>
                                    <td><?php
                                        // echo $penunjang->pasienkirimkeunitlain_id;
                                        $morbi = PasienmorbiditasT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
                                        $diagnosa_nama = !empty($morbi->diagnosa_id) ? $morbi->diagnosa->diagnosa_nama : "";

                                        echo !empty($diagnosa_nama) ? $diagnosa_nama : "-"; ?></td>
                                </tr>
                                <tr>
                                    <td valign=top>Pemeriksaan Lab</td>
                                    <td valign=top>:</td>
                                    <td valign=top>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign=top colspan="3" style="font-size:10pt !important; text-align:left !important">

                                        <?php
                                        $namatindakan = "";
                                        foreach ($daftartindakan[$i] as $i => $daftartindakans) {

                                            // var_dump($det) ;die;
                                            if (!empty($daftartindakans->detailhasilpemeriksaanlab_id)) {
                                                $det = DetailhasilpemeriksaanlabT::model()->findByAttributes(array('tindakanpelayanan_id' => $daftartindakans->tindakanpelayanan_id));
                                                $pemeriksaan = LBPemeriksaanlabM::model()->findAllByAttributes(array('pemeriksaanlab_id' => $det->pemeriksaanlab_id));
                                            } else {
                                                $pemeriksaan = PemeriksaanlabM::model()->findAllByAttributes(array('daftartindakan_id' => $daftartindakans->daftartindakan_id));
                                            }
                                            // $detail = DetailhasilpemeriksaanlabT::model()->findAllByAttributes(array('daftartindakan_id' => $daftartindakans->daftartindakan_id));
                                            foreach ($pemeriksaan as $ii => $per) {
                                            }
                                            // if(count((array)$pemeriksaan) > 1){
                                            $namatindakan .= $per->pemeriksaanlab_nama . ", ";
                                            // $namatindakan .= $daftartindakans->daftartindakan->daftartindakan_nama.",";
                                            // }else{
                                            //     $namatindakan .= $per->pemeriksaanlab_nama;
                                            //     // $namatindakan .= $daftartindakans->daftartindakan->daftartindakan_nama;
                                            // }
                                        }
                                        // $namatindakan .= "";
                                        echo $namatindakan;
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Petugas Sampling</td>
                                    <td>:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="center" style="padding:3px 0px !important;">
                                        <div align="center" valign="middle">--------------------------------<i>potong disini</i>--------------------------------</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="center" style="padding:3px;">
                                        <div class="judulcontent" align="center" valign="middle" style="font-size:10pt !important;">KUPON PEMERIKSAAN LABORATORIUM</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>NOMOR SAMPLE</td>
                                    <td>:</td>
                                    <td><?php echo !empty($penunjang->noorderlis) ? $penunjang->noorderlis : ""; ?></td>
                                </tr>
                                <tr>
                                    <td>NAMA</td>
                                    <td>:</td>
                                    <td><?php echo $modPasien->namadepan . $modPasien->nama_pasien . (!empty($modPasien->nama_bin) ? " (" . $modPasien->nama_bin . ")" : ""); ?></td>
                                </tr>
                                <tr>
                                    <td>UMUR / JENIS KELAMIN</td>
                                    <td>:</td>
                                    <td><?php echo $modPendaftaran->umur; ?> / <?php echo $modPasien->jeniskelamin; ?></td>
                                </tr>
                                <tr>
                                    <td>Tanggal</td>
                                    <td>:</td>
                                    <td><?php echo MyFormatter::formatDateTimeId(date('Y/m/d'), strtotime($penunjang->tglmasukpenunjang)); ?></td>
                                </tr>
                                <tr>
                                    <td>ALAMAT</td>
                                    <td>:</td>
                                    <td><?php echo $modPasien->alamat_pasien; ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>:</td>
                                    <td><?php echo " - " . $modPasien->kecamatan->kecamatan_nama . " - " . $modPasien->kabupaten->kabupaten_nama; ?></td>
                                </tr>
                                <tr>
                                    <td valign=top>Pemeriksaan Lab</td>
                                    <td valign=top>:</td>
                                    <td valign=top>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign=top colspan="3" style="font-size:10pt !important; text-align:left !important">

                                        <?php
                                        echo $namatindakan;
                                        ?>
                                    </td>
                                </tr>


                        <?php
                    }
                } ?>



                            </table>
                        </div>
                    </td>
                </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>