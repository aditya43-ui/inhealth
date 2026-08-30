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
    .judulcontent{
        text-align: center;
    }
</style>
<?php
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
?>
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
                    <h4><b>RINCIAN PENERIMAAN PEMBAYARAN PIUTANG BANK DAN PEMBAYARAN DIGITAL</b></h4>
                </div>
                <table class='table' style = "border: 0;">
                    <tr>
                        <td width="50%">
                            <table class='table' style = "border: 0;">
                                <tr>
                                    <td width="180px"> No Pembayaran Piutang </td>
                                   <td>
                                       : <?php echo $model->nopembayaran; ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> No Kas Masuk</td>
                                    <td>
                                       : <?php echo $modBuktibayar->nobuktibayar; ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Tgl. Pembayaran Piutang </td>
                                   <td>
                                       : <?php echo MyFormatter::formatDateTimeForUser($model->tglpembayaran); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Tgl. Kas Masuk </td>
                                   <td>
                                       : <?php echo MyFormatter::formatDateTimeForUser($modBuktibayar->tglbuktibayar); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Cara Pembayaran </td>
                                   <td>
                                       : <?php echo (($modBuktibayar->carapembayaran == "CASH")?"TUNAI":$modBuktibayar->carapembayaran); ?>
                                   </td>
                                </tr>
                                <?php if($modBuktibayar->carapembayaran == Params::CARAPEMBAYARAN_TRANSFER){ ?>
                                    <tr>
                                        <td> Nama Bank Penerima </td>
                                       <td>
                                           : <?php echo (isset($modBuktibayar->bank_id)?BankM::model()->findByPk($modBuktibayar->bank_id)->namabank:""); ?>
                                       </td>
                                    </tr>
                                    <tr>
                                        <td> No Rekening Penerima </td>
                                       <td>
                                           : <?php echo $modBuktibayar->norekpenerima; ?>
                                       </td>
                                    </tr>
                                    <tr>
                                        <td> No Struk Bukti Transfer </td>
                                       <td>
                                           : <?php echo $modBuktibayar->nostrukkartu; ?>
                                       </td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                       <td> Nama Pengirim </td>
                                       <td>
                                           : <?php echo $modBuktibayar->namapengirim; ?>
                                       </td>
                                    </tr>
                                    <tr>
                                        <td> Alamat Pengirim </td>
                                       <td>
                                           : <?php echo $modBuktibayar->alamatpengirim; ?>
                                       </td>
                                    </tr>
                                    <tr>
                                        <td> Keterangan </td>
                                        <td>
                                            : <?php echo CHtml::encode($modBuktibayar->sebagaipembayaran_bkm); ?>
                                        </td>
                                    </tr>
                            </table>
                        </td>
                        <td width="50%">
                            <table class='table' style = "border: 0;">
                                <tr>
                                    <td width="200px"> Jenis Pembayaran </td>
                                   <td>
                                       : <?php echo $jenispembayaran; ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Bank </td>
                                   <td>
                                       : <?php echo $banknama; ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Total Piutang </td>
                                   <td>
                                       : Rp<?php echo (!empty($model->totalpiutang)? MyFormatter::formatNumberForPrint($model->totalpiutang, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                   <td> Total Yang Dibayarkan </td>
                                   <td>
                                       : Rp<?php echo (!empty($model->totalbayar)? MyFormatter::formatNumberForPrint($model->totalbayar, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Total Biaya Administrasi Bank</td>
                                   <td>
                                       : Rp<?php echo (!empty($modBuktibayar->biayaadministrasi)? MyFormatter::formatNumberForPrint($modBuktibayar->biayaadministrasi, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td>Total Biaya Meterai </td>
                                   <td>
                                       : Rp<?php echo (!empty($modBuktibayar->biayamaterai)? MyFormatter::formatNumberForPrint($modBuktibayar->biayamaterai, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Total Penerimaan </td>
                                   <td>
                                       : Rp<?php echo (!empty($modBuktibayar->uangditerima)? MyFormatter::formatNumberForPrint($modBuktibayar->uangditerima, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                   <td> Total Sisa Piutang </td>
                                   <td>
                                       : Rp<?php echo (!empty($model->totalsisapiutang)? MyFormatter::formatNumberForPrint($model->totalsisapiutang, 2): "-"); ?>
                                   </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                    <p style="text-align: center;">RINCIAN PEMBAYARAN <p style="margin: 0; text-align: center;"><div style="border: 1px solid black; width: 80%;"></div></p></p>
                    <br>
                <table width="85%" style='margin-left:auto; margin-right:auto;' class ="border">
                    <thead class="border">
                       <th>No.</th>
                        <th>Tgl. Pembayaran |<br>No Pembayaran</th>
                        <th>Tgl. Jatuh Tempo</th>
                        <th>Tgl. Pendaftaran |<br>No. Pendaftaran</th>
                        <th>No. Rekam Medik</th>
                        <th>Nama Pasien</th>
                        <th>Instalasi</th>
                        <th>Ruangan</th>
                        <th>Bayar Ke- </th>
                        <th>Jenis Pembayaran</th>
                        <th>Bank</th>
                        <th>Jumlah Piutang</th>
                        <th>Jumlah Yang Dibayarkan</th>
                        <th>Jumlah Biaya Administrasi Bank</th>
                        <th>Jumlah Biaya Meterai</th>
                        <th>Jumlah Penerimaan</th>
                        <th>Jumlah Sisa Piutang</th>
                        <th>Keterangan</th>
                    </thead>
                    <?php
                    foreach ($modPembDetail as $i=>$modData){
                      $listData = PenerimaanbayarpiutangV::model()->findByAttributes(array('pembayaranpelayanan_id'=>$modData->pembayaranpelayanan_id,'jnspembayar_id'=>$modData->jnspembayar_id,'bankpenerima_id'=>$modData->bank_id));
                    ?>
                         <tr class="border">
                            <td><?php echo ($i+1)."."; ?></td>
                            <td><?php echo MyFormatter::formatDateTimeForUser($listData->tglpembayaran)."<br>".$listData->nopembayaran; ?></td>
                            <td><?php echo (!empty($listData->tgljatuhtempo) ? MyFormatter::formatDateTimeForUser($listData->tgljatuhtempo):""); ?></td>
                            <td><?php echo MyFormatter::formatDateTimeForUser($listData->tgl_pendaftaran)."<br>".$listData->no_pendaftaran; ?></td>
                            <td><?php echo $listData->no_rekam_medik ?></td>
                            <td><?php echo $listData->nama_pasien; ?></td>
                            <td><?php echo $listData->instalasi_nama; ?></td>
                            <td><?php echo $listData->ruangan_nama; ?></td>
                            <td><?php echo $modData->bayarke; ?></td>
                            <td><?php echo $listData->jnspembayar_nama; ?></td>
                            <td><?php echo (!empty($listData->namabank)?$listData->namabank:"-"); ?></td>
                            <td style = "text-align:right;"><?php echo MyFormatter::formatNumberForPrint($modData->jmlpiutang, 2); ?></td>
                            <td style = "text-align:right;"><?php echo MyFormatter::formatNumberForPrint($modData->jmlbayar, 2); ?></td>
                            <td style = "text-align:right;"><?php echo MyFormatter::formatNumberForPrint($modData->biayaadministrasi, 2); ?></td>
                            <td style = "text-align:right;"><?php echo MyFormatter::formatNumberForPrint($modData->biaya_materai, 2); ?></td>
                            <td style = "text-align:right;"><?php echo MyFormatter::formatNumberForPrint($modData->jmlpenerimaan, 2); ?></td>
                            <td style = "text-align:right;"><?php echo MyFormatter::formatNumberForPrint($modData->jmlsisapiutang, 2); ?></td>
                            <td>
                                <?php echo $modData->keterangan; ?>
                            </td>
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
<br><br>
<br><br>
<div class="footer">
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
</div>
<br>
<?php
    if(!isset($_GET['caraPrint'])){
?>
        <div class="form-actions">
            <?php
                echo CHtml::link(
                    Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),
                    'javascript:void(0);',
                    array(
                        'class'=>'btn btn-info',
                        'onClick'=>'print("PRINT")'
                    )
                );
            ?>
		</div>
<?php
$urlPrint= $this->createUrl('rincian',array('tandabuktibayar_id'=>$modBuktibayar->tandabuktibayar_id,'pembpiutangbank_id'=>$model->pembpiutangbank_id, 'caraPrint'=>'PRINT'));
$js = <<< JSCRIPT
function print(caraPrint)
{
window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');

}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);

}
?>
