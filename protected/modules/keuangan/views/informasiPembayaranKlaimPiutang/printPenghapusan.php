<?php // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
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
    }
    .table {
        box-shadow: none;
    }
</style>

<table style="width: 100%; border: none;">
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
                    <b>RINCIAN PENGHAPUSAN PIUTANG PENJAMIN TAK TERTAGIH</b>
                </div>
                <table class='table' style = "border: 0;">
                    <tr>
                        <td width="50%">
                            <table class='table' style = "border: 0;">
                                <tr>
                                    <td width="180px"> Tgl. Pengajuan Klaim </td>
                                   <td>
                                       : <?php echo MyFormatter::formatDateTimeForUser($modPengajuan->tglpengajuanklaimanklaim); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> No Penganjuan Klaim</td>
                                    <td>
                                       : <?php echo $modPengajuan->nopengajuanklaimanklaim; ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Jenis Penjamin </td>
                                   <td>
                                       : <?php echo $modPengajuan->carabayar->carabayar_nama; ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Penjamin </td>
                                   <td>
                                       : <?php echo $modPengajuan->penjamin->penjamin_nama; ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Tgl. Penghapusan Piutang </td>
                                   <td>
                                       : <?php echo MyFormatter::formatDateTimeForUser($model->tglpenghapusanpiutang); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Pegawai Penghapusan </td>
                                   <td>
                                       : <?php echo $model->pegawaipenghapusan_nama; ?>
                                   </td>
                                </tr>
                            </table>
                        </td>
                        <td width="50%">
                            <table class='table' style = "border: 0;">
                                <tr>
                                    <td width="200px"> Alasan Penghapusan </td>
                                   <td>
                                       : <?php echo $model->alasanpenghapusan; ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Total Piutang </td>
                                   <td>
                                       : Rp <?php echo (!empty($modPengajuan->totalpiutang)? MyFormatter::formatNumberForPrint($modPengajuan->totalpiutang, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                   <td> Total Telah Bayar </td>
                                   <td>
                                       : Rp <?php echo (!empty($modPengajuan->tlhdibayar)? MyFormatter::formatNumberForPrint($modPengajuan->tlhdibayar, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Total Sisa Piutang </td>
                                   <td>
                                       : Rp <?php echo (!empty($modPengajuan->totalsisapiutang)? MyFormatter::formatNumberForPrint($modPengajuan->totalsisapiutang, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Total Piutang Tak Tertagih </td>
                                   <td>
                                       : Rp <?php echo (!empty($model->jmlpiutangtaktertagih)? MyFormatter::formatNumberForPrint($model->jmlpiutangtaktertagih, 2): "-"); ?>
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
    <tr><td width="70%" style="text-align:left" align="left" class="alamatfooter"><?php echo  $layoutkiri ?></td><td class="mottofooter" style="text-align:right"  width="30%" align="right"><?php echo $motto ?></td></tr>

</table>
