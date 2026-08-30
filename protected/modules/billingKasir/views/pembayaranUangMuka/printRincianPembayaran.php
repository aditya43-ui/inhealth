<?php $data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<style>
  body {
        color: black;
    }

    .border th, .border td{
        border:1px solid #000;
        padding:2px;
    }
    .table thead:first-child{
        border-top:1px solid #000;
    }

    thead th{
        background:none;
        color:#333;
    }

    .table tbody tr td, .table tbody tr th {
        background-color: none;
        border: none !important;
    }
    .table {
        box-shadow: none;
    }
</style>

<table width="100%">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?></div>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                <div class="judulcontent">
                    <b>RINCIAN PEMBAYARAN UANG MUKA PASIEN</b>
                </div>
                <br/>
                <table class='table' style = "border: 0px;">
                    <tr>
                        <td width="40%">
                            <table class='table' style = "border: 0px;">
                                <tr>
                                    <td width="180px"> No Pendaftaran </td>
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
                                    <td> Instalasi </td>
                                   <td>
                                       : <?php echo (isset($modPasienAdmisi->instalasi)?$modPasienAdmisi->instalasi->instalasi_nama:$modPendaftaran->instalasi->instalasi_nama); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Poliklinik/ Ruangan </td>
                                   <td>
                                       : <?php echo (isset($modPasienAdmisi->ruangan)?$modPasienAdmisi->ruangan->ruangan_nama:$modPendaftaran->ruangan->ruangan_nama); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Jenis Penjamin </td>
                                   <td>
                                       : <?php echo (isset($modPasienAdmisi->carabayar)?$modPasienAdmisi->carabayar->carabayar_nama:$modPendaftaran->carabayar->carabayar_nama); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Penjamin </td>
                                   <td>
                                       : <?php echo (isset($modPasienAdmisi->penjamin)?$modPasienAdmisi->penjamin->penjamin_nama:$modPendaftaran->penjamin->penjamin_nama); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Kelas Pelayanan </td>
                                   <td>
                                       : <?php echo (isset($modPasienAdmisi->kelaspelayanan)?$modPasienAdmisi->kelaspelayanan->kelaspelayanan_nama:$modPendaftaran->kelaspelayanan->kelaspelayanan_nama); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> No Rekam Medik </td>
                                   <td>
                                       : <?php echo $modPasien->no_rekam_medik; ?>
                                   </td>
                                </tr>
                                <tr>
                                   <td> Nama Pasien </td>
                                   <td>
                                       : <?php echo $modPasien->namadepan.' '.$modPasien->nama_pasien; ?>
                                   </td>
                                </tr>
                            </table>
                        </td>
                        <td width="60%">
                            <table class='table' style = "border: 0px;">
                                <tr>
                                    <td width="240px"> No. Pembayaran Uang Muka Pasien</td>
                                   <td>
                                       : <?php echo $modBayar->nouangmuka; ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Tgl. Pembayaran Uang Muka Pasien </td>
                                   <td>
                                       : <?php echo MyFormatter::formatDateTimeForUser($modBayar->tgluangmuka); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> No. Bukti Bayar </td>
                                   <td>
                                       : <?php echo $modTandaBukti->nobuktibayar; ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Tgl. Bukti Bayar </td>
                                   <td>
                                       : <?php echo MyFormatter::formatDateTimeForUser($modTandaBukti->tglbuktibayar); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Total Tagihan Sementara </td>
                                   <td>
                                       : Rp. <?php echo MyFormatter::formatNumberForPrint($jumlah_tagihan, 2); ?>
                                   </td>
                                </tr>
                                <tr>
                                   <td> Jumlah Uang Muka </td>
                                   <td>
                                       : Rp. <?php echo (!empty($modBayar->jumlahuangmuka)? MyFormatter::formatNumberForPrint($modBayar->jumlahuangmuka, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Jumlah Pembulatan </td>
                                   <td>
                                       : Rp. <?php echo (!empty($modTandaBukti->jmlpembulatan)? MyFormatter::formatNumberForPrint($modTandaBukti->jmlpembulatan, 2, true): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Jumlah Pembayaran </td>
                                   <td>
                                       : Rp. <?php echo (!empty($modTandaBukti->jmlpembayaran)? MyFormatter::formatNumberForPrint($modTandaBukti->jmlpembayaran, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Pembayaran Tunai </td>
                                   <td>
                                       : Rp. <?php echo (!empty($modTandaBukti->uangditerima)? MyFormatter::formatNumberForPrint($modTandaBukti->uangditerima, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                   <td> Jenis Pembayaran </td>
                                   <td>
                                       : <?php echo $jenispembayaran; ?>
                                   </td>
                                </tr>
                                <tr>
                                   <td> Bank </td>
                                   <td>
                                       : <?php echo $bank; ?>
                                   </td>
                                </tr>
                                <tr>
                                   <td> Pembayaran Non Tunai </td>
                                   <td>
                                       : Rp. <?php echo (!empty($jmlpembayaran)? MyFormatter::formatNumberForPrint($jmlpembayaran, 2): "-"); ?>
                                   </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
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
$profil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
        $alamat=!empty($profil->alamatlokasi_rumahsakit)?$profil->alamatlokasi_rumahsakit:"";
	$motto=!empty($profil->motto)?$profil->motto:"";
        $telp=!empty($profil->no_telp_profilrs)?$profil->no_telp_profilrs:"";
        $email=!empty($profil->email)?$profil->email:"";
        $website=!empty($profil->website)?$profil->website:"";
        $layoutkiri=$alamat."<br>"."Telp:".$telp." Email:".$email." Website:".$website;
?>
<table width="100%" class="footer">
    <tr><td width="70%" style="text-align:left" align="left" class="alamatfooter" ><?php echo  $layoutkiri ?></td><td class="mottofooter" style="text-align:right"  width="30%" align="right"><?php echo $motto ?></td></tr>

</table>
