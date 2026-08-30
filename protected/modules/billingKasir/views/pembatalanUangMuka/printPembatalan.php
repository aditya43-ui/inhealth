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
        border: none !important;
    }
    .table {
        box-shadow: none;
    }
    .judulcontent{
      text-align: center;
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
                    <b>RINCIAN PENGEMBALIAN PEMBAYARAN UANG MUKA PASIEN</b>
                </div>
                <br/>
                <table class='table' style = "border: 0px;">
                    <tr>
                        <td width="50%">
                            <table class='table' style = "border: 0px;">
                                <tr>
                                    <td width="180px"> Tgl. Kas Keluar </td>
                                   <td>
                                       : <?php echo MyFormatter::formatDateTimeForUser($modBuktiKeluar->tglkaskeluar); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Tgl Pengembalian</td>
                                    <td>
                                       : <?php echo MyFormatter::formatDateTimeForUser($model->tglpembatalan); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> No. Kas Keluar </td>
                                   <td>
                                       : <?php echo CHtml::encode($modBuktiKeluar->nokaskeluar); ?>
                                   </td>
                                </tr>
                                <tr>
                                   <td> Nama Penerima </td>
                                   <td>
                                       : <?php echo $modBuktiKeluar->namapenerima; ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Alamat Penerima </td>
                                   <td>
                                       : <?php echo $modBuktiKeluar->alamatpenerima; ?>
                                   </td>
                                </tr>
                            </table>
                        </td>
                        <td width="50%">
                            <table class='table' style = "border: 0px;">
                                <tr>
                                    <td width="180px"> Alasan Pengembalian </td>
                                   <td>
                                       : <?php echo $model->keterangan_batal; ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Total Uang Muka </td>
                                   <td>
                                       : Rp. <?php echo (!empty($modUangMuka->jumlahuangmuka)? MyFormatter::formatNumberForPrint($modUangMuka->jumlahuangmuka, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Pemakaian Uang Muka </td>
                                   <td>
                                       : Rp. <?php echo (!empty($pemakaianUangMuka->pemakaianuangmuka)? MyFormatter::formatNumberForPrint($pemakaianUangMuka->pemakaianuangmuka, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Sisa Uang Muka </td>
                                   <td>
                                       : Rp. <?php echo (!empty($pemakaianUangMuka->sisauangmuka)? MyFormatter::formatNumberForPrint($pemakaianUangMuka->sisauangmuka, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Jumlah Kas Keluar </td>
                                   <td>
                                       : Rp. <?php echo (!empty($modBuktiKeluar->jmlkaskeluar)? MyFormatter::formatNumberForPrint($modBuktiKeluar->jmlkaskeluar, 2): "-"); ?>
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
