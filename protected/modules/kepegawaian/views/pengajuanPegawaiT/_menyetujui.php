<style>
    .uang {
        text-align: right !important;
    }
</style>

<?php 
echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
 
$sukses = null;
if(isset($_GET['sukses'])){
	$sukses = $_GET['sukses'];
}
if($sukses > 0){
	Yii::app()->user->setFlash('success',"Status Menyetujui berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert'); 
?>
<table bgcolor='white' class='table' style = "box-shadow:none;">
    <tr bgcolor='white' >
        <td>
             <b><?php echo CHtml::encode($model->getAttributeLabel('nopengajuan')); ?></b>
        </td>
        <td>
            : <?php echo CHtml::encode($model->nopengajuan); ?>
        </td>
        <td>
            &nbsp;
        </td>    
        <td>
            <b>Jumlah Orang</b>            
        </td>
        <td>: <?php echo CHtml::encode($model->jmlorang); ?></td>
    </tr>
    <tr>
        <td>
             <b><?php echo CHtml::encode($model->getAttributeLabel('tglpengajuan')); ?></b>
        </td>
        <td>
            : <?php echo !empty($model->tglpengajuan)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime(MyFormatter::formatDateTimeForDb($model->tglpengajuan)))):"-" ?>
        </td>
        <td>
            &nbsp;
        </td> 
         <td>
            <b>Untuk Keperluan</b>            
        </td>
        <td>: <?php echo CHtml::encode($model->untukkeperluan); ?></td>
        
     <tr>
          <td>
            <b>keterangan</b>            
        </td>
        <td>: <?php echo CHtml::encode($model->keterangan); ?></td>
        <td>
            &nbsp;
        </td> 
        <td>
            &nbsp;
        </td> 
        <td>
            &nbsp;
        </td> 
    </tr>
</table>
<div class="row">
	<div class="col-sm-6" style="text-align:center;">
		&nbsp;
	</div>
	<div class="col-sm-6" style="text-align:center;">
		<div class="control-group" style="margin-bottom: 57.5px;margin-top: 10px;">
			<?php 
			if(isset($_GET['sukses'])){
				echo "<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>";
				echo isset($_GET['ditolak'])? "Ditolak," : "Menyetujui, ";
			}else{
				echo "<div class='<div class='control-group' style='margin-bottom: 50px;'>";
				echo CHtml::link(Yii::t('mds',' Menyetujui'), 
				$this->createUrl($this->id.'/index'), 
				array('class' => 'btn btn-danger',
					'onclick'=>'myConfirm("Apakah Anda yakin?","Perhatian!",
					function(r) {if(r) window.location = "'.$this->createUrl('ApproveMenyetujui',array('pengajuanpegawai_id'=>$model->pengajuanpegawai_t_id,'approve'=>true)).'";} ); return false;'));  
				echo "&nbsp";
//				echo CHtml::link(Yii::t('mds',' Menolak'), 
//				$this->createUrl($this->id.'/index'), 
//				array('class'=>'btn btn-default',
//					'onclick'=>'myConfirm("Apakah Anda yakin?","Perhatian!",
//					function(r) {if(r) window.location = "'.$this->createUrl('Menyetujui',array('pembelianbarang_id'=>$model->pembelianbarang_id,'tolak'=>true)).'";} ); return false;'));  
			}
			?>
		</div>
	</div>
		<div class="control-group">
			( <?php echo $model->namaLengkapMenyetujui;?> )
		</div>
	</div>
</div>
<?php 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    $urlPrint= $this->createUrl('printApproveMenyetujui',array('pengajuanpegawai_id'=>$model->pengajuanpegawai_t_id));
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