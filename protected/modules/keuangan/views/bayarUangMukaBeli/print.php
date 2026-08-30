<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
<?php $data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<style>

    tr:last-child > td:first-child
    {
        border-bottom-left-radius: 0;
    }

    .table
    {
        border: 1px solid #000;
        border-radius: 0 0px 0px 0px;
        box-shadow: 0 0px 0px 0px;
    }

    .table-striped tbody tr:nth-child(2n+1) td
    {
        background-color: #fff;
    }

    .table th
    {
        border-top: 1px solid #000;
        border-bottom: 1px solid #000;

    }

    .c th + th, .c td + td, .c th + td, .c td + th
    {
        border-left: 1px solid #000;

    }

    .d th + th, .d td + td, .d th + td, .d td + th
    {
        border-left: 0;

    }

    table.d{
        border: 0;
    }

   thead th {
    background: none;
    border-bottom: 4px solid #6B994D;
    color: #333333;
    }
</style>

<?php
    $nopermintaan = "";
    $tglUangmuka = "";
    $jmlUangMuka = "";
    $typepermintaan = "";
    $permintaanid = null;
    $sumberdanaid = null;

    if(!empty($model->pembelianbarang_id)){
        $typepermintaan = "barang";
        $permintaanid = $model->pembelianbarang_id;
    }else if(!empty($model->permintaanpembelian_id)){
        $typepermintaan = "obatalkes";
        $permintaanid = $model->permintaanpembelian_id;
    }else if(!empty($model->pengajuanbahanmkn_id)){
        $typepermintaan = "gizi";
        $permintaanid = $model->pengajuanbahanmkn_id;
    }
    $modPembelian = PermintaanpembeliantouangmukaV::model()->findByAttributes(array('permintaanpembelian_id'=>$permintaanid,'typepermintaan'=>$typepermintaan));

    if(isset($modPembelian)){
        $nopermintaan = $modPembelian->nopermintaan;
        $tglUangmuka = $modPembelian->tglpermintaanuangmuka;
        $jmlUangMuka = $modPembelian->jmlpermintaanuangmuka;
        $sumberdanaid = $modPembelian->sumberdana_id;
    }

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
                    <b>RINCIAN PEMBAYARAN UANG MUKA PEMBELIAN</b>
                </div>
                <table class='table' style = "border: 0;">
                    <tr>
                        <td width="50%">
                            <table class='table' style = "border: 0;">
                                <tr>
                                    <td width="230px"> No. Pembayaran </td>
                                   <td>
                                       : <?php echo $model->nopembayaran; ?>
                                   </td>

                                </tr>
                                <tr>
                                    <td> Tgl. Pembayaran</td>
                                    <td>
                                       : <?php echo MyFormatter::formatDateTimeForUser($model->tgluangmukabeli); ?>
                                   </td>

                                </tr>
                                <tr>
                                    <td> No. Kas Keluar </td>
                                   <td>
                                       : <?php echo CHtml::encode($modBuktiKeluar->nokaskeluar); ?>
                                   </td>
                                </tr>
                                <tr>
                                     <td> Tgl. Kas Keluar </td>
                                   <td>
                                       : <?php echo MyFormatter::formatDateTimeForUser($modBuktiKeluar->tglkaskeluar); ?>
                                   </td>
                                </tr>
                                <tr>
                                     <td> No. Permintaan </td>
                                   <td>
                                       : <?php echo $nopermintaan; ?>
                                   </td>
                                </tr>
                                <tr>
                                     <td> Tgl. Permintaan Uang Muka </td>
                                   <td>
                                       : <?php echo (!empty($tglUangmuka)? MyFormatter::formatDateTimeForUser(CHtml::encode(MyFormatter::formatDateTimeForDb($tglUangmuka))):""); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Jumlah Permintaan Uang Muka </td>
                                   <td>
                                      : Rp<?php echo (!empty($jmlUangMuka)? MyFormatter::formatNumberForPrint($jmlUangMuka, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Sebagai Pembayaran </td>
                                   <td>
                                       : <?php echo CHtml::encode($modBuktiKeluar->untukpembayaran); ?>
                                   </td>
                                </tr>
                                <?php if($modBuktiKeluar->carabayarkeluar == Params::CARAPEMBAYARAN_TRANSFER){ ?>
                                    <tr>
                                        <td> Cara Pembayaran </td>
                                       <td>
                                           : <?php echo $modBuktiKeluar->carabayarkeluar; ?>
                                       </td>
                                    </tr>
                                    <tr>
                                        <td> Bank Pengirim </td>
                                       <td>
                                           : <?php echo (isset($modBuktiKeluar->bank_id)?BankM::model()->findByPk($modBuktiKeluar->bank_id)->namabank:""); ?>
                                       </td>
                                    </tr>

                                <?php } ?>
                            </table>
                        </td>
                        <td width="50%">
                            <table class='table' style = "border: 0;">
                                <?php if($modBuktiKeluar->carabayarkeluar == Params::CARAPEMBAYARAN_TRANSFER){ ?>
                                    <tr>
                                        <td width="200px"> No Rekening </td>
                                       <td>
                                           : <?php echo $modBuktiKeluar->denganrekening; ?>
                                       </td>
                                    </tr>
                                    <tr>
                                        <td> No. Bukti Transfer </td>
                                       <td>
                                           : <?php echo $modBuktiKeluar->nobukti_transfer; ?>
                                       </td>
                                    </tr>
                                    <tr>
                                        <td> Bank Penerima </td>
                                       <td>
                                           : <?php echo $modBuktiKeluar->melalubank; ?>
                                       </td>
                                    </tr>
                                <?php }else{ ?>
                                    <tr>
                                        <td width="200px"> Cara Pembayaran </td>
                                       <td>
                                           : <?php echo $modBuktiKeluar->carabayarkeluar; ?>
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
                                    <td> Total Permintaan Pembelian </td>
                                   <td>
                                       : Rp<?php echo (!empty($model->totalpo)? MyFormatter::formatNumberForPrint($model->totalpo, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Jumlah Pembayaran </td>
                                   <td>
                                       : Rp<?php echo (!empty($model->jumlahuang)? MyFormatter::formatNumberForPrint($model->jumlahuang, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                   <td> Biaya Administrasi </td>
                                   <td>
                                       : Rp<?php echo (!empty($modBuktiKeluar->biayaadministrasi)? MyFormatter::formatNumberForPrint($modBuktiKeluar->biayaadministrasi, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Biaya Meterai </td>
                                   <td>
                                       : Rp<?php echo (!empty($modBuktiKeluar->biaya_materai)? MyFormatter::formatNumberForPrint($modBuktiKeluar->biaya_materai, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Jumlah Kas Keluar </td>
                                   <td>
                                       : Rp<?php echo (!empty($modBuktiKeluar->jmlkaskeluar)? MyFormatter::formatNumberForPrint($modBuktiKeluar->jmlkaskeluar, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Jumlah Sisa Permintaan Uang Muka </td>
                                   <td>
                                       : Rp<?php echo (!empty($model->jmlsisauangmuka)? MyFormatter::formatNumberForPrint($model->jmlsisauangmuka, 2): "-"); ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Total Sisa Utang Permintaan Pembelian </td>
                                   <td>
                                       : Rp<?php echo (!empty($model->totalsisahutangpo)? MyFormatter::formatNumberForPrint($model->totalsisahutangpo, 2): "-"); ?>
                                   </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

<table width="100%" style="margin-top:20px;">
	<tr>
		<td width="100%" align="left" align="top">
			<table style="width: 100%; border: none;">
				<tr>
					<td width="35%" align="center">
					</td>
					<td width="35%" align="center">
					</td>
					<td width="35%" align="center">
						<div>Yang Mengetahui</div>
						<div style="margin-top:60px;"><?php
                  $modApproval = ApprovalotorisasiM::model()->find();
                  $pegawaimengetahui = "";
                  if(!empty($sumberdanaid)){
                    if ($sumberdanaid == 2){
                      $pegawaimengetahui = (isset($modApproval->managerkeuanganpt) ? $modApproval->managerkeuanganpt->NamaLengkap : "");
                    }else{
                      $pegawaimengetahui = (isset($modApproval->managerkeuangan) ? $modApproval->managerkeuangan->NamaLengkap : "");
                    }
                  }

                  echo $pegawaimengetahui ?></div>
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
