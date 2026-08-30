<style>
    .border th, .border td{
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
</style>
<?php 
echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>"", 'colspan'=>10));
 
$sukses = null;
if(isset($_GET['sukses'])){
	$sukses = $_GET['sukses'];
}
if($sukses > 0){
	Yii::app()->user->setFlash('success',"Status menyetujui berhasil disimpan !");
}
$this->widget('bootstrap.widgets.BootAlert'); 
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
?>
<br>
<table width="74%" style="margin:0px;" cellpadding="0" cellspacing="0">
        <tr>
            <td  width="20%">No. Rencana</td>
            <td>:</td>
            <td><?php echo $model->renkebbarang_no; ?></td>
            
            <td  width="20%">Sumber Dana</td>
            <td>:</td>
            <td><?php echo (!empty($model->sumberdana_id)?$model->sumberdana->sumberdana_nama:""); ?></td>
        </tr>
         <tr>
            <td  width="20%">Tanggal Rencana</td>
            <td>:</td>
            <td><?php echo MyFormatter::formatDateTimeForUser($model->renkebbarang_tgl); ?></td>
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
                <td class = "border" style="text-align:right;"><?php echo (Params::cekHiddenHargaGudangUmum()==true)?"Rp ".number_format($modDetail->hpp,2,",","."):"Hidden"; ?></td>
            </tr>
            <?php } ?>
	</tbody>
        <tfoot>
            <tr>
                <td class = "border" colspan="10" style="text-align:right;"><b>Total</b></td>
                <td class = "border" style="text-align:right;"><b>
                        <?php echo (Params::cekHiddenHargaGudangUmum()==true)?"Rp ".number_format($total,2,",","."):"Hidden"; ?>
                        </b>
                </td>
            </tr>
        </tfoot>
</table>

<div class="row-fluid">
    <div class="span6" style="text-align:center;">&nbsp;</div>
    <div class="span6" style="text-align:center;">
                    <?php 
                    if(isset($_GET['sukses'])){
                            echo "<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>";
                            echo "Menyetujui,";
                    }else{
                            echo "<div class='<div class='control-group' style='margin-bottom: 50px;'>";
                            echo CHtml::link(Yii::t('mds',' Menyetujui'), 
                            $this->createUrl($this->id.'/index'), 
                            array('class'=>'btn btn-primary',
                                    'onclick'=>'myConfirm("Apakah anda yakin ?","Perhatian!",
                                    function(r) {if(r) window.location = "'.$this->createUrl('ApproveMenyetujui',array('renkebbarang_id'=>$model->renkebbarang_id,'approve'=>true)).'";} ); return false;'));  
                    }
                    ?>
            </div>	
            <div class="control-group">
                    ( <?php echo isset($model->pegmenyetujui_id)?$model->pegawaimenyetujui->namaLengkap:"";?> )
            </div>	
   </div>	
    <!--<div class="span6" style="text-align:center;">-->
            <!--<div class="control-group" style="margin-bottom: 57.5px;margin-top: 10px;">-->
                    <!--Mengetahui,-->
            <!--</div>-->
            <!--<div class="control-group">-->
                    <!--( <?php // echo isset($model->pegmengetahui_id)?$model->pegawaimengetahui->namaLengkap:"";?> )-->
            <!--</div>-->
    <!--</div>-->
</div>
<?php 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-success', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    $urlPrint= $this->createUrl('printApproveMenyetujui',array('renkebbarang_id'=>$model->renkebbarang_id));
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