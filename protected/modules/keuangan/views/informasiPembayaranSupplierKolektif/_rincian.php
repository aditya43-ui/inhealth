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
                <div class="judulcontent" style="text-align:center">
                    <b>RINCIAN PEMBAYARAN SUPPLIER KOLEKTIF</b>
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
                                       : <?php echo $tglsetoran; ?>
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
                                       : <?php echo CHtml::encode($modBuktiKeluar->no_setorpajakpembelian); ?>
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
                                <?php if($modBuktiKeluar->carabayarkeluar == Params::CARAPEMBAYARAN_TUNAI){ ?>
                                    <tr>
                                        <td> Keterangan </td>
                                        <td>
                                            : <?php echo CHtml::encode($modBuktiKeluar->untukpembayaran); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </td>
                        <td width="50%">
                            <table class='table' style = "border: 0;">
                                <?php
                                //     $widthjenis = 'width="150px"';
                                // if($modBuktiKeluar->carabayarkeluar == Params::CARAPEMBAYARAN_TRANSFER){
                                //     $widthjenis = '';
                                ?>
                                    <tr>
                                        <td width="150px"> Supplier </td>
                                       <td>
                                           : <?php echo $supplier; ?>
                                       </td>
                                    </tr>
                                <?php //} ?>
                                    <tr>
                                        <td> Jenis Supplier </td>
                                       <td>
                                           : <?php echo $jenisupplier; ?>
                                       </td>
                                    </tr>

                                <tr>
                                    <td> Total Tagihan </td>
                                   <td>
                                       : Rp <?php echo (!empty($totaltagihan)? MyFormatter::formatNumberForPrint($totaltagihan, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                   <td> Total Yang Dibayarkan </td>
                                   <td>
                                       : Rp <?php echo (!empty($jmlpembayaran)? MyFormatter::formatNumberForPrint($jmlpembayaran, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Biaya Administrasi </td>
                                   <td>
                                       : Rp <?php echo (!empty($modBuktiKeluar->biayaadministrasi)? MyFormatter::formatNumberForPrint($modBuktiKeluar->biayaadministrasi, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Biaya Ongkos Kirim </td>
                                   <td>
                                       : Rp <?php echo (!empty($modBuktiKeluar->biayaongkos_kirim)? MyFormatter::formatNumberForPrint($modBuktiKeluar->biayaongkos_kirim, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Jumlah Kas Keluar </td>
                                   <td>
                                       : Rp <?php echo (!empty($modBuktiKeluar->jmlkaskeluar)? MyFormatter::formatNumberForPrint($modBuktiKeluar->jmlkaskeluar, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                   <td> Total Sisa Tagihan </td>
                                   <td>
                                       : Rp <?php echo (!empty($totalsisahutang)? MyFormatter::formatNumberForPrint($totalsisahutang, 2): "-"); ?>
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
                        <th>No Faktur</th>
                        <th>Tgl. Faktur</th>
                        <th>Tgl. Jatuh Tempo</th>
                        <th>Instalasi</th>
                        <th>Ruangan</th>
                        <th>Total Tagihan</th>
                        <th>Total Yang Dibayarkan</th>
                        <th>Sisa Tagihan</th>
                        <th>Keterangan</th>
                    </thead>
                    <?php
                    foreach ($detailPembayaran as $i=>$modData){
                    ?>
                         <tr class="border">
                            <td><?php echo ($i+1)."."; ?></td>
                            <td><?php echo $modData['nofaktur']; ?></td>
                            <td><?php echo $modData['tglfaktur']; ?></td>
                            <td><?php echo $modData['tgljatuhtempo']; ?></td>
                            <td><?php echo $modData['instalasi']; ?></td>
                            <td><?php echo $modData['ruangan']; ?></td>
                            <td style = "text-align:right;"><?php echo MyFormatter::formatNumberForPrint($modData['totaltagihan'], 2); ?></td>
                            <td style = "text-align:right;"><?php echo MyFormatter::formatNumberForPrint($modData['jmldibayarkan'], 2); ?></td>
                            <td style = "text-align:right;"><?php echo MyFormatter::formatNumberForPrint($modData['totalsisatagihan'], 2); ?></td>
                            <td>
                                <?php echo $modData['keterangan']; ?>
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
<div class="">
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
<?php } ?>
