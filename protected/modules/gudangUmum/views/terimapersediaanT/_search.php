<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'guterimapersediaan-t-search',
        'type'=>'horizontal',
)); ?>
<div class="row-fluid">
	<div class="col-sm-6">
		<div class="control-group">		
            <?php echo CHtml::label("Tanggal Terima",'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>	
		<div class = "control-group">
			<?php echo Chtml::label('No Penerimaan','nopenerimaan',array('class'=>'control-label')); ?>
			<div class = "controls">
				<?php echo $form->textField($model,'nopenerimaan',array('class'=>'span3 angkahuruf-only', 'maxlength'=>20, 'placeholder'=>'Ketik no. penerimaan', 'autofocus'=>true)); ?>
			</div>
		</div>                    
	</div>
	<div class="col-sm-6">
		<?php echo $form->dropDownListRow($model,'peg_penerima_id', CHtml::listData(PegawairuanganV::model()->findAll("pegawai_aktif = true AND ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ORDER BY nama_pegawai ASC"), 'pegawai_id', 'nama_pegawai'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20)); ?>              
		<?php echo $form->dropDownListRow($model,'supplier_id', CHtml::listData(SupplierM::model()->getSupplierUmumItems(), 'supplier_id', 'supplier_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20)); ?>              		
	</div>
</div>	                                
<?php //echo $form->dropDownListRow($model,'sumberdanabhn', LookupM::getItems('sumberdanabahan'),array('empty'=>'-- Pilih --')); ?>    
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
		Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
		array('class'=>'btn btn-danger',
		'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
	                <?php 
        echo " | ".CHtml::htmlButton(Yii::t('mds','{icon} Cetak',array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')),
            array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp;"; 
        
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="'.MyIcon::getIcons('pdf').'"></i>')),
            array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp;"; 
        
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="'.MyIcon::getIcons('excel').'"></i>')),
            array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp;"; 
        
        echo CHtml::htmlButton(Yii::t('mds','{icon} Export CSV',array('{icon}'=>'<i class="entypo-newspaper"></i>')),
            array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'CSV\')'))." | "; 
?>
<?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printInformasi');
        $urlEksportCsv=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/eksportCSV');
        
        
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#guterimapersediaan-t-search :input').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function exportTemplateCsv()
{
    window.open("${urlEksportCsv}","",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
?> 
            
    <?php
		$content = $this->renderPartial('tips/informasi',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>
</div>
<?php $this->endWidget(); ?>
