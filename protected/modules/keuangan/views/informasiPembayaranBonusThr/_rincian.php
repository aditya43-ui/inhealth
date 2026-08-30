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
                    <h4><b>RINCIAN PEMBAYARAN <?php echo strtoupper($model->jenisgaji); ?> PEGAWAI</b></h4>
                </div>
                <table class='table' style = "border: 0;">
                    <tr>
                        <td width="50%">
                            <table class='table' style = "border: 0;">
                                <tr>
                                    <td width="180px"> Tgl. Kas Keluar </td>
                                   <td>
                                       : <?php echo MyFormatter::formatDateTimeForUser($modBuktiKeluar->tglkaskeluar); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Tgl. Pembayaran</td>
                                    <td>
                                       : <?php echo MyFormatter::formatDateTimeForUser($model->tglpembayaran); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> No. Kas Keluar </td>
                                   <td>
                                       : <?php echo CHtml::encode($modBuktiKeluar->nokaskeluar); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> No. Pembayaran </td>
                                   <td>
                                       : <?php echo $model->nopembayaran; ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Cara Pembayaran </td>
                                   <td>
                                       : <?php echo $modBuktiKeluar->carabayarkeluar; ?>
                                   </td>
                                </tr>
                                <?php if($modBuktiKeluar->carabayarkeluar == Params::CARAPEMBAYARAN_TRANSFER){ ?>
                                    <tr>
                                        <td> Nama Bank Penerima </td>
                                       <td>
                                           : <?php echo (isset($modBuktiKeluar->bank_id)?BankM::model()->findByPk($modBuktiKeluar->bank_id)->namabank:""); ?>
                                       </td>
                                    </tr>
                                    <tr>
                                        <td> No Rekening Penerima </td>
                                       <td>
                                           : <?php echo $modBuktiKeluar->denganrekening; ?>
                                       </td>
                                    </tr>
                                    <tr>
                                        <td> No Struk Bukti Transfer </td>
                                       <td>
                                           : <?php echo $modBuktiKeluar->nobukti_transfer; ?>
                                       </td>
                                    </tr>
                                    <?php } ?>
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
                                    <tr>
                                        <td> Keterangan </td>
                                        <td>
                                            : <?php echo CHtml::encode($modBuktiKeluar->untukpembayaran); ?>
                                        </td>
                                    </tr>
                            </table>
                        </td>
                        <td width="50%">
                            <table class='table' style = "border: 0;">

                                <tr>
                                    <td width="150px"> Total Utang </td>
                                   <td>
                                       : Rp <?php echo (!empty($model->totalhutang)? MyFormatter::formatNumberForPrint($model->totalhutang, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                   <td> Total Yang Dibayarkan </td>
                                   <td>
                                       : Rp <?php echo (!empty($model->totaldibayarkan)? MyFormatter::formatNumberForPrint($model->totaldibayarkan, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Biaya Administrasi </td>
                                   <td>
                                       : Rp <?php echo (!empty($modBuktiKeluar->biayaadministrasi)? MyFormatter::formatNumberForPrint($modBuktiKeluar->biayaadministrasi, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Jumlah Kas Keluar </td>
                                   <td>
                                       : Rp <?php echo (!empty($modBuktiKeluar->jmlkaskeluar)? MyFormatter::formatNumberForPrint($modBuktiKeluar->jmlkaskeluar, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                   <td> Total Sisa Utang </td>
                                   <td>
                                       : Rp <?php echo (!empty($model->totalsisahutang)? MyFormatter::formatNumberForPrint($model->totalsisahutang, 2): "-"); ?>
                                   </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <p style="text-align: center;">RINCIAN HUTANG <p style="margin: 0; text-align: center;"><div style="border: 1px solid black; width: 80%;"></div></p></p>
                <br>
            <table width="85%" style='margin-left:auto; margin-right:auto;' class ="border">
                <thead class="border">
                   <th>No.</th>
                    <th>Periode</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Total Utang</th>
                    <th>Total Yang Dibayarkan</th>
                    <th>Total Sisa Utang</th>
                    <th>Keterangan</th>
                </thead>
                <?php
                foreach ($modDetail as $i=>$modData){
                ?>
                     <tr class="border">
                        <td><?php echo ($i+1)."."; ?></td>
                        <td><?php echo (isset($modData->pengbonusthr)? MyFormatter::getMonthId(date('m', strtotime($modData->pengbonusthr->periodebonusthr)))." ".date('Y', strtotime($modData->pengbonusthr->periodebonusthr)) : ""); ?></td>
                        <td><?php echo (isset($modData->pengbonusthr)? MyFormatter::formatDateTimeForUser($modData->pengbonusthr->tglpengajuan) : ""); ?></td>
                        <td style = "text-align:right;">Rp <?php echo MyFormatter::formatNumberForPrint($modData->jmlhutang, 2); ?></td>
                        <td style = "text-align:right;">Rp <?php echo MyFormatter::formatNumberForPrint($modData->jmldibayarkan, 2); ?></td>
                        <td style = "text-align:right;">Rp <?php echo MyFormatter::formatNumberForPrint($modData->jmlsisahutang, 2); ?></td>
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
$urlPrint= $this->createUrl('rincian',array('tandabuktikeluar_id'=>$modBuktiKeluar->tandabuktikeluar_id, 'caraPrint'=>'PRINT'));
$js = <<< JSCRIPT
function print(caraPrint)
{
window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');

}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);

}else{
  ?>
  <div class="footer">
      <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
  </div>
  <?php
}
?>
