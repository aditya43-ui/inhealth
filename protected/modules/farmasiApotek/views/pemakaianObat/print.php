<style>
    .table {
        box-shadow: none;
        border: 1px solid black;
    }
    .table th, .table td {
        border: 1px solid black;
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
			<div class="judulcontent"><?php echo  $judulLaporan ?> </div>
                        <table class='table'>
    <tr>
        <td>
             <b><?php echo CHtml::encode($model->getAttributeLabel('nopemakaian_obat')); ?>:</b>
            <?php echo CHtml::encode($model->nopemakaian_obat); ?>
            <br>
             <b><?php echo CHtml::encode($model->getAttributeLabel('tglpemakaianobat')); ?>:</b>
            <?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($model->tglpemakaianobat)); ?>
             <br>
             
        </td>
    </tr>   
</table>

<table id="tableObatAlkes" class="table">
    <thead>
        <tr>
			<th>Kode</th>
                        <th>Nama Obat</th>
			<th hidden>Satuan Kecil</th>
			<th>Jumlah</th>
			<th hidden>Stok</th>
			<th>Harga Satuan</th>
			<th>Sub Total</th>
		</tr>
    </thead>
    <tbody>
		<?php
		if(count((array)$modDetails) > 0){
			foreach($modDetails AS $i=> $modDetail){
				$modDetail->jmlstok = StokobatalkesT::getJumlahStokOaPemakaianTersimpan($modDetail->pemakaianobatdetail_id);
				$modDetail->subtotal = $modDetail->qty_satuanpakai*$modDetail->harga_satuanpakai;
				echo $this->renderPartial($this->path_view.'_rowDetail',array('modPemakaianObatDetail'=> $modDetail, 'nobatal'=>true));
			}
		}
		?>
	</tbody>
</table>

<table width="100%" style="margin-top:20px;">
	<tr>
		<td width="100%" align="left" align="top">
			<table style="width: 100%; border: none;">
				<tr>
					<td width="65%" align="center">
					</td>
					<td width="35%" align="center">
						<div>Dibuat Oleh :</div>
						<div style="margin-top:60px;"><?php echo isset($model->pegawai_id) ? $model->pegawai->NamaLengkap : "-" ?></div>
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
<div class="footer">
   
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
  
</div>

<?php if(isset($caraPrint)){
    
}else{ ?>
<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),
            array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); ?>
<?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print&id='.$modPesan->pesanbarang_id);
        $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#gupesanbarang-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<?php } ?>