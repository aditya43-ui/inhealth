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

echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>'SURAT PESANAN', 'deskripsi'=>$deskripsi, 'colspan'=>10));
 
echo "<h5 style='color:#333;text-align:right'>".$modProfilRs->kecamatan->kecamatan_nama.", ".  MyFormatter::formatDateTimeForUser(date('Y-m-d'))."</h5>";
$sukses = null;
if(isset($_GET['sukses'])){
	$sukses = $_GET['sukses'];
}
if($sukses > 0){
	Yii::app()->user->setFlash('success',"Status menyetujui berhasil disimpan !");
}
$this->widget('bootstrap.widgets.BootAlert'); 

?>
<table width="74%z" style="margin:0px;" cellpadding="0" cellspacing="0">
        <tr>
            <td  width="20%">Rayon</td>
            <td>:</td>
            <td><?php echo Yii::app()->user->getState('propinsi_nama'); ?></td>
        </tr>
        <tr>
            <td  width="20%">No. PO</td>
            <td>:</td>
            <td><?php echo $model->nopermintaan; ?></td>
        </tr>
        <?php /*
        <tr>
            <td>Lampiran</td>
            <td>:</td>
            <td></td>
        </tr>
        <tr>
            <td>Perihal</td>
            <td>:</td>
            <td>Pesanan Obat / Alat Kesehatan habis pakai rutin</td>
        </tr>
        <tr>
            <td>No. Rek</td>
            <td>:</td>
            <td></td>
        </tr>
		<tr>
            <td>No. Perencanaan</td>
            <td>:</td>
            <td><?php echo !empty($model->rencanakebfarmasi_id)?$model->rencanakebfarmasi->noperencnaan:' - '; ?></td>
        </tr>
         * 
         */ ?>
    </table><br/>
    <?php /*
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Kepada Yth. <?php echo $model->supplier->supplier_nama; ?><br>
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Di  <?php echo $model->supplier->supplier_alamat; ?><br>
    Dengan hormat,<br>
    Dengan ini kami mohon pada saudara untuk dapat menyediakan obat dan alat kesehatan <?php echo $modProfilRs->nama_rumahsakit; ?>
     * 
     */
    
    if (!empty($model->pegawaiapoteker_id)) {
        $peg = PegawaiM::model()->findByPk($model->pegawaiapoteker_id);
        $model->pegawaiapoteker_nama = $peg->namaLengkap;
        $model->pegawaiapoteker_alamat = $peg->alamat_pegawai;
        $model->pegawaiapoteker_alamat_ktp = $peg->alamat_pegawai_ktp;
        $model->pegawaiapoteker_sipa = $peg->suratizinpraktek;
    }
    
    ?>
    
	Kepada Yth:
	<br/>
	<?php echo $model->supplier->supplier_nama; ?>
	<br/>
	<br/>
	
    Surat Pesanan Obat/Prekursor/Narkotik/Obat-obat Tertentu/Alkes
    
    <br/><br/>
    
    <table>
        <tr>
            <td nowrap>Apoteker Penanggung Jawab</td><td>: </td><td>
                <?php
                if (!empty($model->pegawaiapoteker_id)) {
                    $peg = PegawaiM::model()->findByPk($model->pegawaiapoteker_id);
                    echo $peg->namaLengkap;
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>No. SIPA</td><td>: </td><td><?php echo $model->pegawaiapoteker_sipa; ?></td>
        </tr>
        <tr>
            <td>Alamat KTP</td><td>: </td><td><?php echo $model->pegawaiapoteker_alamat_ktp; ?></td>
        </tr>
        <tr>
            <td>Alamat Domisili</td><td>: </td><td><?php echo $model->pegawaiapoteker_alamat; ?></td>
        </tr>
    </table>
    
    <br><br>
    Jenis Obat yang akan dipesan :
    <table width="100%" style='margin-left:auto; margin-right:auto;' class ="border" >
        <thead class="border">
            <th style="text-align: center;">No.</th>
            <th style="text-align: center;" hidden>Asal Barang</th>
            <th style="text-align: center;">Nama</th>
            <th style="text-align: center;">Zat Aktif</th>
            <th style="text-align: center;">Bentuk / Kekuatan Obat</th>
            <th style="text-align: center;" hidden>Jumlah Kemasan (Satuan) </th>
            <th style="text-align: center;">Satuan</th>
            <th style="text-align: center;">Jumlah Pembelian</th>
            <?php /*
            <th style="text-align: center;">Harga Netto</th>
            <th style="text-align: center;">Stok Akhir</th>
            <th style="text-align: center;">PPN</th>
            <th style="text-align: center;">PPH</th>
            <th style="text-align: center;">Diskon (%)</th>
            <th style="text-align: center;">Diskon Total (Rp.)</th>
            <th style="text-align: center;">Minimal Stok</th>
            <th style="text-align: center;">Sub Total</th>
             * 
             */ ?>
            <th style="text-align: center;">Keterangan</th>
        </thead>
        <?php 
        $total = 0;
        $subtotal = 0;
        foreach ($modDetails as $i=>$modObat){ 
            $oa = ObatalkesM::model()->findByPk($modObat->obatalkes_id);
        ?>
             <tr class="border">
                <td><?php echo ($i+1)."."; ?></td>
                <td hidden><?php // echo $modObat->sumberdana->sumberdana_nama; ?></td>
                <td><?php echo $modObat->obatalkes->obatalkes_nama; ?></td>
                <td>
                    <?php 
                    $modZatAktif = ObatalkeszataktifM::model()->findAllByAttributes(array(
                        'obatalkes_id'=>$oa->obatalkes_id
                    ));

                    $zatAktif = "-";
                    if (count((array)$modZatAktif) > 0) {
                        $zatAktif = "<ul>";
                        foreach ($modZatAktif as $item) {
                            $zatAktif .= "<li>".$item->obatalkeszataktif_nama."</li>";
                        }
                        $zatAktif .= "</ul>";
                    }
                    echo $zatAktif;


                    ?>
                </td>
                <td><?php echo $oa->bentuk_obat." / ".$oa->kekuatan." ".$oa->satuankekuatan; ?></td>
                <td style = "text-align:right;" hidden><?php // echo number_format($modObat->kemasanbesar,0,"","."); ?></td>
                <td style = "text-align:right;"><?php 
                
                if (!empty($modObat->satuanbesar_id)) {
                    $besar = SatuanbesarM::model()->findByPk($modObat->satuanbesar_id);
                    echo $besar->satuanbesar_nama;
                } else if (!empty($modObat->satuankecil_id)) {
                    $kecil = SatuankecilM::model()->findByPk($modObat->satuankecil_id);
                    echo $kecil->satuankecil_nama;
                }
                
                ?></td>
                <td style = "text-align:right;"><?php echo number_format($modObat->jmlpermintaan,0,"","."); ?></td>
                <?php /*
                <td style = "text-align:right;"><?php echo "Rp".number_format($modObat->harganettoper,0,"","."); ?></td>
                <td style = "text-align:right;"><?php echo number_format($modObat->stokakhir,0,"","."); ?></td>
                <td style = "text-align:right;"><?php echo $modObat->persenppn; ?></td>
                <td style = "text-align:right;"><?php echo $modObat->persenpph; ?></td>
                <td style = "text-align:right;"><?php echo $modObat->persendiscount; ?></td>
                <td style = "text-align:right;"><?php echo "Rp".number_format($modObat->jmldiscount,0,"","."); ?></td>
                <td style = "text-align:right;"><?php echo number_format($modObat->minimalstok,0,"","."); ?></td>
                <td style = "text-align:right;"><?php 
                    $subtotal = ($modObat->harganettoper * $modObat->jmlpermintaan);
                    $total += $subtotal;
                    echo "Rp".number_format($subtotal,0,"","."); ?>
                </td>
                 * 
                 */ ?>
                <td><?php echo $modObat->keterangan; ?></td>
            </tr>
        <?php } ?>
        <tr hidden>
            <td colspan="12" style="text-align: center;"><i>( <?php echo $format->kataterbilang($total) ?> rupiah )</i></td>
            <td colspan = "2" style="text-align:right;border-left:1px double #fff" align="center"><strong>Total</strong></td>
            <td    style = "text-align:right;" class="border"><?php echo "Rp".number_format($total,0,"","."); ?></td>
            <td></td>
        </tr>
    </table><br>
    Demikian Surat Pesanan ini kami buat untuk dapat dipergunakan seperlunya,<br>
    Atas perhatian dan kerja sama yang baik kami ucapkan terima kasih.<br><br>
	
<?php if((isset($model->tglmengetahui)) && (isset($model->tglmenyetujui))){ ?>
	
<div class="row-fluid">
	<div class="span4" style="text-align:center;">
		<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>
		Manager Umum, <br>Mengetahui
		</div>
		<div class="control-group">
			( <?php echo $model->pegawaimengetahui->NamaLengkap;?> )
		</div>	
	</div>
    <div class="span4" style="text-align:center;">
		<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>
			Manager Keuangan, <br>Mengetahui
		</div>
		<div class="control-group">
			( <?php echo $model->pegawaimengetahuiumum->NamaLengkap;?> )
		</div>
	</div>
	<div class="span4" style="text-align:center;">
		<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>
			Direktur, <br>Menyetujui
		</div>
		<div class="control-group">
			( <?php echo $model->pegawaimenyetujui->NamaLengkap;?> )
		</div>
	</div>
</div>
<?php 
//    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
//    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-success', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
//    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    $urlPrint= $this->createUrl('printMengetahui',array('permintaanpembelian_id'=>$model->permintaanpembelian_id));
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
	
<?php }else if(isset($model->tglmenyetujui)){ ?>

<div class="row-fluid">
	<div class="span6" style="text-align:center;">
		&nbsp;
	</div>
	<div class="span6" style="text-align:center;">
		<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>
			Menyetujui
		</div>
		<div class="control-group">
			( <?php echo $model->pegawaimenyetujui->NamaLengkap;?> )
		</div>
	</div>
</div>
<?php
    $urlPrint= $this->createUrl('printMenyetujui',array('permintaanpembelian_id'=>$model->permintaanpembelian_id));
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

	
<?php }else{ ?>
<br><br>

<?php 
//    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
//    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-success', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
//    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    $urlPrint= $this->createUrl('printMenyetujui',array('permintaanpembelian_id'=>$model->permintaanpembelian_id));
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


<?php } ?>
<br><br>
<?php
if((isset($model->tglmengetahui)) && (isset($model->tglmenyetujui))){
	echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-success', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
}else{
	echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','disabled'=>true))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-success', 'type'=>'button','disabled'=>true))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','disabled'=>true))."&nbsp&nbsp"; 
}
?>