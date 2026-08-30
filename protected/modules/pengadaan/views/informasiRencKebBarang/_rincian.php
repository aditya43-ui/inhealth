<?php 
echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>"", 'colspan'=>10));
 
$sukses = null;
if(isset($_GET['sukses'])){
	$sukses = $_GET['sukses'];
}
if($sukses > 0){
	Yii::app()->user->setFlash('success',"Status menyetujui berhasil disimpan !");
}
$this->widget('bootstrap.widgets.BootAlert'); 
//echo "No. Rencana : ".$model->renkebbarang_no."";
?>
<style>
    .border{
        border:1px solid #000;
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
	h5, h3{
		color: black !important;
	}
</style>
<br/>
    <table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
        <tr>
            <td><h5>No. Rencana : <?php echo $model->renkebbarang_no; ?></h5></td>
            <td><h5>Sumber Dana : <?php echo (!empty($model->sumberdana_id)?$model->sumberdana_nama:""); ?></h5></td>
        </tr>
        <tr>
            <td><h5>Tanggal Rencana : <?php echo MyFormatter::formatDateTimeForUser($model->renkebbarang_tgl); ?></h5></td>
            <td></td>
        </tr>
    </table>
<table class = "table" style = "box-shadow:none;" id="table-rencanaanggaranpenerimaan">
	<thead>
		<tr>
			<th class = "border">No.</th>
			<th class = "border">Nama Barang</th>
			<th class = "border">Satuan</th>
			<th class = "border">Stok Akhir</th>
			<th class = "border">Minimal Stok</th>
			<th class = "border">Maksimal Stok</th>
			<th class = "border">Jumlah Kebutuhan</th>
			<th class = "border">Harga Satuan (Rp)</th>
			<th class = "border">PPN (%)</th>
			<th class = "border">PPN (Rp)</th>
			<th class = "border">Sub Total (Rp)</th>
			
		</tr>
	</thead>
	<tbody>
		<?php 
		$total = 0;
		foreach($modDetails as $i => $modDetail){
                    $total += $modDetail->hpp;
		?>
		<tr>
                    <td class = "border"><?php echo $i+1; echo ". "; ?></td>
                    <td class = "border"><?php echo (!empty($modDetail->barang_id)) ? $modDetail->barang->barang_nama : ""; ?></td>
                    <td class = "border"><?php echo $modDetail->satuanbarangdet; ?></td>
                    <td class = "border" style="text-align:right;"><?php echo number_format($modDetail->stokakhir_barangdet,2,",","."); ?></td>
                    <td class = "border" style="text-align:right;"><?php echo $modDetail->minstok_barangdet; ?></td>
                    <td class = "border" style="text-align:right;"><?php echo $modDetail->makstok_barangdet; ?></td>
                    <td class = "border" style="text-align:right;"><?php echo number_format($modDetail->jmlpermintaanbarangdet,2,",","."); ?></td>
                    <td class = "border" style="text-align:right;"><?php echo (Params::cekHiddenHargaGudangUmum()==true)?"Rp ".number_format($modDetail->harga_barangdet,2,",","."):"Hidden"; ?></td>
                    <td class = "border" style="text-align:right;"><?php echo $modDetail->persen_ppn; ?></td>
                    <td class = "border" style="text-align:right;"><?php echo (Params::cekHiddenHargaGudangUmum()==true)?"Rp ".number_format($modDetail->ppn,2,",","."):"Hidden"; ?></td>
                    <td class = "border" style="text-align:right;">
					<?php 
                    
                    echo (Params::cekHiddenHargaGudangUmum()==true)?"Rp ".number_format($modDetail->hpp,2,",","."):"Hidden"; ?>
				</td>
		</tr>
		<?php } ?>
		<tfoot>
			<tr>
				<td class = "border" colspan="10" style="text-align:right;"><b>Total</b></td>
				<td class = "border" style="text-align:right;"><b>
					<?php echo (Params::cekHiddenHargaGudangUmum()==true)?"Rp ".number_format($total,2,",","."):"Hidden"; ?>
					</b>
				</td>
			</tr>
		</tfoot>
	</tbody>
</table>



<div class="row-fluid">
    <div class="span6" style="text-align:center;"> &nbsp;
		<!--<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>-->
		<!--Mengetahui,-->
		<!--</div>-->
		<!--<div class="control-group">-->
			<!--( <?php // echo isset($modHead->pegmengetahui_id) ? $modHead->pegawaimengetahui->NamaLengkap : "" ?> )-->
		<!--</div>-->	
	</div>
	<div class="span6" style="text-align:center;">
		<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>
			Menyetujui
		</div>
		<div class="control-group">
			( <?php echo isset($modHead->pegmenyetujui_id) ? $modHead->pegawaimenyetujui->NamaLengkap : "" ?> )
		</div>
	</div>
</div>
<?php 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-success', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    $urlPrint= $this->createUrl('print',array('renkebbarang_id'=>$model->renkebbarang_id));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}"+$('#inforencanapen-form').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
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
    <tr><td width="70%" style="text-align:left" align="left" class="alamatfooter" ><?php echo  $layoutkiri ?></td><td class="mottofooter" style="text-align:right"  width="30%" align="right"><?php echo $motto ?></td></tr>
        
</table>



