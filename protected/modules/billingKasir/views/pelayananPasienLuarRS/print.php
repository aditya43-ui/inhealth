<?php $data = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); ?>
<style>
    body {
        color: black;
    }

    /* .border th,
    .border td {
        border: 1px solid #000;
        padding: 2px;
    } */

    /* .table thead:first-child {
        border-top: 1px solid #000;
    } */

    /* thead th {
        background: none;
        color: #333;
    } */

    .table tbody tr td,
    .table tbody tr th {
        background-color: none;
    }

    .table {
        box-shadow: none;
    }
    .tblpadding td, th{
        padding: 5px;
    }

    .borderclass{
        border: 1px solid black;
    }

    .bordertopclass{
        border-top: 1px solid black;
    }
</style>
<?php
// $admisi = PasienadmisiT::model()->findByPk($modTindakans->pasienadmisi_id);

?>
<table style="width: 100%; border: none;">
    <thead>
        <tr>
            <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultV3', array());
                ?></div>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                    <div class="judulcontent">
                        <b>RINCIAN PELAYANAN TINDAKAN PASIEN LUAR RUMAH SAKIT</b>
                    </div>
                    <br/>
                    <table width="100%">
                        <tr>
                            <td width="50%" valign="top">
                                <table class="tblpadding">
                                    <tr>
                                        <td width="180px"> No. Pendaftaran </td>
                                        <td>
                                            : <?php echo $modPendaftaran->no_pendaftaran; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Tgl. Pendaftaran</td>
                                        <td>
                                            : <?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> No. Rekam Medik </td>
                                        <td>
                                        : <?php echo $modPasien->no_rekam_medik; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Nama Pasien </td>
                                        <td>
                                        : <?php echo $modPasien->nama_pasien; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Kelas Pelayanan </td>
                                        <td>
                                        : <?php 
                                            foreach($modTindakans as $data){

                                            }
                                            echo $data->kelaspelayanan->kelaspelayanan_nama; ?>
                                        </td>
                                    </tr>
                                    <!-- <tr>
                                        <td> Jenis Kasus Penyakit </td>
                                        <td>
                                        : <?php //echo $modKunjungan->jeniskasuspenyakit_nama; ?>
                                        </td>
                                    </tr> -->
                                </table>
                            </td>
                            <td width="50%" valign="top">
                                <table class="tblpadding">
                                    <tr>
                                        <td width="150px"> Jenis Penjamin </td>
                                        <td>
                                        : <?php echo (!empty($admisi)? $admisi->carabayar->carabayar_nama: $data->carabayar->carabayar_nama); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Penjamin </td>
                                        <td>
                                        : <?php echo (!empty($admisi)? $admisi->penjamin->penjamin_nama: $data->penjamin->penjamin_nama); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Instalasi </td>
                                        <td>
                                        : <?php echo $data->instalasi->instalasi_nama; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Ruangan </td>
                                        <td>
                                        : <?php echo (!empty($admisi)? $admisi->ruangan->ruangan_nama: $data->ruangan->ruangan_nama); ?>
                                        </td>
                                    </tr>
                                    <!-- <tr>
                                        <td> Total Keseluruhan Tindakan </td>
                                        <td>
                                            : Rp <?php //echo (!empty($totalkeseluruhan) ? MyFormatter::formatNumberForPrint($totalkeseluruhan, 2) : "-"); ?>
                                        </td>
                                    </tr> -->
                                </table>
                            </td>
                        </tr>
                    </table>
                   
                    <br>
                    <table width="100%" style='margin-left:auto; margin-right:auto;' class="tblpadding">
                        <thead>
                            <tr>
                                <th class="borderclass">No.</th>
                                <th class="borderclass">Tanggal Tindakan</th>
                                <th class="borderclass">Uraian Tindakan</th>
                                <th class="borderclass">Komponen Tarif</th>
                                <th class="borderclass">Tarif Komponen</th>
                                <th class="borderclass">Jumlah</th>
                                <th class="borderclass">Keringanan</th>
                                <th class="borderclass">Total Tarif Akhir</th>
                            </tr>
                        </thead>
                        <?php
                        $no = 0;
                        foreach ($modTindakans as $i => $dataTindakan) {
                            $komponen = TindakankomponenT::model()->findAllByAttributes(array('tindakanpelayanan_id' => $dataTindakan->tindakanpelayanan_id));
                            $no++;
                        ?>
                            <tr>
                                <td class="borderclass" rowspan="2"><?php echo $no; ?></td>
                                <td class="borderclass" rowspan="2"><?php echo MyFormatter::formatDateTimeForUser($dataTindakan->tgl_tindakan); ?></td>
                                <td class="borderclass" rowspan="2"><?php echo $dataTindakan->tindakanluar_nama; ?></td>
                                <td  class="borderclass" style="margin: 0px !important; padding: 0px !important;">
                                    <table width="100%">
                                        <?php
                                        if(!empty($komponen)){
                                            foreach($komponen as $j =>$dataKomp){
                                                $cls="";
                                                if($j > 0){
                                                    $cls="bordertopclass";
                                                }
                                                ?>
                                                    <tr>
                                                        <td class="<?php echo $cls; ?>">
                                                            <?php echo $dataKomp->komponentarif->komponentarif_nama; ?>
                                                        </td>
                                                    </tr>    
                                                <?php 
                                            }
                                        }?>
                                    </table>
                                </td>
                                <td  class="borderclass" style="margin: 0px !important; padding: 0px !important;">
                                    <table width="100%">
                                        <?php
                                        if(!empty($komponen)){
                                            foreach($komponen as $j =>$dataKomp){
                                                $cls="";
                                                if($j > 0){
                                                    $cls="bordertopclass";
                                                }
                                                ?>
                                                    <tr>
                                                        <td class="<?php echo $cls; ?>" style="text-align:right">
                                                            <?php echo MyFormatter::formatNumberForPrint($dataKomp->tarif_tindakankomp,2); ?>
                                                        </td>
                                                    </tr>    
                                                <?php 
                                            }
                                        }?>
                                    </table>
                                </td>
                                <td class="borderclass"  style="text-align:center"><?php echo $dataTindakan->qty_tindakan; ?></td>
                                <td  class="borderclass" style="margin: 0px !important; padding: 0px !important;">
                                    <table width="100%">
                                        <?php
                                        if(!empty($komponen)){
                                            foreach($komponen as $j =>$dataKomp){
                                                $cls="";
                                                if($j > 0){
                                                    $cls="bordertopclass";
                                                }
                                                ?>
                                                    <tr>
                                                        <td class="<?php echo $cls; ?>" style="text-align:right">
                                                            <?php echo MyFormatter::formatNumberForPrint($dataKomp->discountkomptindakan,2); ?>
                                                        </td>
                                                    </tr>    
                                                <?php 
                                            }
                                        }?>
                                    </table>
                                </td>
                                <td  class="borderclass" style="margin: 0px !important; padding: 0px !important;">
                                    <table width="100%">
                                        <?php
                                        if(!empty($komponen)){
                                            foreach($komponen as $j =>$dataKomp){
                                                $cls="";
                                                if($j > 0){
                                                    $cls="bordertopclass";
                                                }
                                                ?>
                                                    <tr>
                                                        <td class="<?php echo $cls; ?>" style="text-align:right">
                                                            <?php echo MyFormatter::formatNumberForPrint($dataKomp->tarif_tindakankomp,2); ?>
                                                        </td>
                                                    </tr>    
                                                <?php 
                                            }
                                        }?>
                                    </table>
                                </td>        
                            </tr>
                            <tr class="border">
                                <td colspan="2"><?php 
                                if(!empty($dataTindakan->dokter1) && !empty($dataTindakan->dokter2->namaLengkap)){
                                    echo "Dokter Pemeriksaan 1 : ". $dataTindakan->dokter1->namaLengkap." "." Dokter Pemeriksaan 2 : ". $dataTindakan->dokter2->namaLengkap;
                                }else if(!empty($dataTindakan->dokter1)){
                                    echo "Dokter Pemeriksaan 1 : ". (!empty($dataTindakan->dokter1)? $dataTindakan->dokter1->namaLengkap: "-");
                                }else if(!empty($dataTindakan->dokter2)){
                                    echo " Dokter Pemeriksaan 2 : ". (!empty($dataTindakan->dokter2)? $dataTindakan->dokter2->namaLengkap: "-");
                                }
                                ?></td>
                                <td style="font-weight: bold;">Total</td>
                                <td style="font-weight: bold; text-align:right"><?php echo MyFormatter::formatNumberForPrint($dataTindakan->discount_tindakan,2); ?></td>
                                <td style="font-weight: bold; text-align:right"><?php echo MyFormatter::formatNumberForPrint($dataTindakan->tarif_tindakan,2); ?></td>
                            </tr>
                        <?php } ?>
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

<?php
$profil = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT);
$alamat = !empty($profil->alamatlokasi_rumahsakit) ? $profil->alamatlokasi_rumahsakit : "";
$motto = !empty($profil->motto) ? $profil->motto : "";
$telp = !empty($profil->no_telp_profilrs) ? $profil->no_telp_profilrs : "";
$email = !empty($profil->email) ? $profil->email : "";
$website = !empty($profil->website) ? $profil->website : "";
$layoutkiri = $alamat . "<br>" . "Telp:" . $telp . " Email:" . $email . " Website:" . $website;
?>
 <table width="100%" style="margin-top:20px;">
    <tr>
        <td></td>
        <td></td>
        <td width="30%" align="center" align="top">
            <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
            <div>Operator</div>
            <div style="margin-top:60px;"><?php echo Yii::app()->user->getState('nama_pegawai'); ?></div>
        </td>
    </tr>
</table>
<!-- <table width="100%" class="footer">
    <tr>
        <td width="70%" style="text-align:left" align="left" class="alamatfooter"><?php  //echo  $layoutkiri ?></td>
        <td class="mottofooter" style="text-align:right" width="30%" align="right"><?php // echo $motto ?></td>
    </tr>

</table> -->