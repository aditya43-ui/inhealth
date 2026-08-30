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
    
    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
</style>
<?php 
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$colspan = 10;
$judulLaporan = "SURAT PESANAN";
$konfig = KonfigsystemK::model()->find();
//$alamatrs = $konfig->alamatheadersurat;
$alamatrs = $modProfilRs->alamatlokasi_rumahsakit.", Kelurahan ".$modProfilRs->kelurahan->kelurahan_nama.", Kecamatan ".$modProfilRs->kecamatan->kecamatan_nama.", ".$modProfilRs->kabupaten->kabupaten_nama;
//echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>'SURAT PESANAN', 'deskripsi'=>$deskripsi, 'colspan'=>10));
 
//echo "<h5 style='color:#333;text-align:right'>".$modProfilRs->kecamatan->kecamatan_nama.", ".  MyFormatter::formatDateTimeForUser(date('Y-m-d'))."</h5>";
$sukses = null;
if(isset($_GET['sukses'])){
	$sukses = $_GET['sukses'];
}
if($sukses > 0){
	Yii::app()->user->setFlash('success',"Status menyetujui berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert'); 

?>
<?php  echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array()); ?>

<table style="margin:0 auto; ">
        <?php
            if(isset($judulLaporan) || strlen($judulLaporan) > 0){
        ?>
             <tr>
				 <td style="border-bottom: 2px solid #000000; text-align: center;" colspan=" <?php echo (!empty($colspan)) ? ($colspan) : "6"; ?>" ALIGN=CENTER VALIGN=MIDDLE ><span color="black"><h3><?php echo $judulLaporan ?></h3></span></td>
            </tr>
        <?php
            }
        ?>
        <?php
            $deskripsi = (isset($deskripsi) ? $deskripsi : null);
            if(isset($deskripsi) || strlen($deskripsi) > 0){
        ?>
             <tr>
				 <td style="text-align: center;" colspan=" <?php echo (!empty($colspan)) ? ($colspan) : "6"; ?>" ALIGN=CENTER VALIGN=MIDDLE><span color="black"><?php echo $deskripsi ?></span></td>
            </tr>  
        <?php
            }
        ?>
         <tr>
            <td colspan=" <?php echo (!empty($colspan)) ? ($colspan) : "6"; ?>" ALIGN=CENTER VALIGN=MIDDLE></td>
        </tr>  
        <tr>
            <td style="text-align: center;" colspan=" <?php echo (!empty($colspan)) ? ($colspan) : "6"; ?>" ALIGN=CENTER VALIGN=MIDDLE>Nomor : <?php echo $model->nopermintaan; ?></td>
        </tr>
</table>

<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr>
        <td>Yang bertanda tangan di bawah ini:</td>
    </tr>
        <tr>
            <td width="20%">Nama</td>
            <td>:</td>
            <td><?php echo $model->pegawaiapoteker->namaLengkap; ?></td>
        </tr>
        <tr>
            <td width="20%">Jabatan</td>
            <td>:</td>
            <td><?php echo (!empty($model->pegawaiapoteker->jabatan_id)?$model->pegawaiapoteker->jabatan->jabatan_nama:""); ?></td>
        </tr>
    </table><br>
    <table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr>
        <td>Mengajukan pesanan kepada :</td>
    </tr>
        <tr>
            <td width="20%">Nama Distributor</td>
            <td>:</td>
            <td><?php echo $model->supplier->supplier_nama; ?></td>
        </tr>
        <tr>
            <td width="20%">Alamat</td>
            <td>:</td>
            <td><?php echo (!empty($model->supplier_id)?$model->supplier->supplier_alamat:""); ?></td>
        </tr>
        <tr>
            <td width="20%">Telp</td>
            <td>:</td>
            <td><?php echo (!empty($model->supplier_id)?$model->supplier->supplier_telp:""); ?></td>
        </tr>
         <tr>
        <td width="20%">No Referensi</td>
        <td>:</td>
        <td><?php echo (!empty($model->noreferensi)?$model->noreferensi:""); ?></td>
    </tr>
    </table><br>
    <p>Dengan barang yang dipesan adalah : </p><br>
    <table width="100%" style='margin-left:auto; margin-right:auto;' class ="border">
        <thead class="border">
            <th>No.</th>
            <th>Nama Barang</th>
            <th>Merk Dagang</th>
            <th>Jumlah</th>
            <th>Satuan</th>
            <th>Harga Satuan</th>
            <th>PPn (%)</th>
            <th>PPn (Rp)</th>
            <th>HPP</th>
            <th>Sub Total</th>
        </thead>
        <?php 
        $total = 0;
        $subtotal = 0;
        foreach ($modDetails as $i=>$modObat){ 
            $oa = ObatalkesM::model()->findByPk($modObat->obatalkes_id);
            $zatobat = ObatalkeszataktifM::model()->findAllByAttributes(array('obatalkes_id'=>$modObat->obatalkes_id));
            $zatvalue = "";
            if(count((array)$zatobat)>0){
                foreach ($zatobat as $j => $datazat){
                    if($j >0){
                        $zatvalue .= ", ";
                    }
                    $zatvalue .= $datazat->obatalkeszataktif_nama;
                }
            }
            
            $total += $modObat->hpp;
            
        ?>
             <tr class="border">
                <td><?php echo ($i+1)."."; ?></td>
                <td><?php echo $modObat->obatalkes->obatalkes_nama; ?></td>
                <td>
                    <?php 
                    echo $zatvalue;
                    ?>
                </td>
                
                <td style = "text-align:right;"><?php echo number_format($modObat->jmlpermintaan,0,"","."); ?></td>
                <td style = "text-align:right;"><?php 
                
                if (!empty($modObat->satuanbesar_id)) {
                    $besar = SatuanbesarM::model()->findByPk($modObat->satuanbesar_id);
                    echo $besar->satuanbesar_nama;
                } else if (!empty($modObat->satuankecil_id)) {
                    $kecil = SatuankecilM::model()->findByPk($modObat->satuankecil_id);
                    echo $kecil->satuankecil_nama;
                }
                
                ?></td>
                <td style = "text-align:right;"><?php echo "Rp".MyFormatter::formatNumberForPrint($modObat->harganettoper, 2); ?></td>
                <td style = "text-align:right;"><?php echo ($modObat->persenppn); ?></td>
                <td style = "text-align:right;"><?php echo "Rp".MyFormatter::formatNumberForPrint($modObat->ppn, 2); ?></td>
                <td style = "text-align:right;"><?php echo "Rp".MyFormatter::formatNumberForPrint($modObat->hpp, 2); ?></td>
                <td style = "text-align:right;"><?php echo "Rp".MyFormatter::formatNumberForPrint($modObat->hpp, 2); ?></td>
            </tr>
        <?php } ?>
        <tr>
            <!--td colspan="12" style="text-align: center;"><i> <?php // echo $format->kataterbilang($total) ?>/i></td-->
            <td colspan = "9" style="text-align:right;" align="center"><b>Total Harga</b></td>
            <td style = "text-align:right;" class="border"><b><?php echo "Rp".MyFormatter::formatNumberForPrint($total, 2); ?></b></td>
        </tr>
</table><br><br>
<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr>
        <td style="width: 80px" valign="top">Keterangan :</td>
        <td><?php echo preg_replace('/\s\s+/', '<br>', $model->keteranganpermintaan); ?></td>
    </tr>
    
    </table><br>
<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="3">Pesanan tersebut akan dipergunakan untuk :</td>
    </tr>
        <tr>
            <td width="20%">Nama Sarana</td>
            <td>:</td>
            <td>Instalasi Farmasi <?php echo $modProfilRs->nama_rumahsakit; ?></td>
        </tr>
        <tr>
            <td width="20%">Alamat</td>
            <td>:</td>
            <td><?php echo ucwords(strtolower($model->alamatpengiriman)); ?></td>
        </tr>
    </table><br>
    	
<div class="row">
	<div class="col-sm-4" style="text-align:center;">
		<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>
		<!--Manager Umum, <br>Mengetahui-->
		</div>
		<div class="control-group">
			<!--( <?php // echo $model->pegawaimengetahui->NamaLengkap;?> )-->
		</div>	
	</div>
    <div class="col-sm-4" style="text-align:center;">
		<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>
			<!--Manager Keuangan, <br>Mengetahui-->
		</div>
		<div class="control-group">
			<!--( <?php // echo $model->pegawaimengetahuiumum->NamaLengkap;?> )-->
		</div>
	</div>
	<div class="col-sm-4" style="text-align:center;">
		<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>
			<?php echo ucwords(strtolower($modProfilRs->kabupaten->kabupaten_nama)); ?>, <?php echo date('d', strtotime($model->tglpermintaanpembelian))." ". MyFormatter::getMonthId(date('m', strtotime($model->tglpermintaanpembelian))) ." ". date('Y', strtotime($model->tglpermintaanpembelian)); ?> <br> Apoteker Penanggung Jawab
		</div>
		<div class="control-group">
			( <?php echo $model->pegawaiapoteker->namaLengkap;?> )
		</div>
	</div>
</div>
     <br>
<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
<tr>
    <td>Surat Pesanan ini telah disetujui dan disahkan secara Elektronik</td>
</tr>

</table>
    
<br><br>
<?php 
//    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
//    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
//    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    $urlPrint= $this->createUrl('printRincian',array('permintaanpembelian_id'=>$model->permintaanpembelian_id));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
    ?>

<?php
//if((isset($model->tglmengetahui)) && (isset($model->tglmenyetujui))){
	echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
//}else{
//	echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','disabled'=>true)); 
//    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','disabled'=>true)); 
//    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','disabled'=>true)); 
//}
?>