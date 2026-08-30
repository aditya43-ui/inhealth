<div class="panel panel-success">
	<div class="panel-heading">
		<div class="panel-title">Pencarian <i class="entypo-search"></i></div>
	</div>
	<div class="panel-body">

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'aksaldoawal-t-search',
        'type'=>'horizontal',
)); ?>

<div class="col-sm-6">
	<?php /*
	<div class="control-group">
		<?php echo CHtml::label("Unit Kerja",'unitkerja_id', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo $form->dropDownList($model,'unitkerja_id', 
			CHtml::listData(UnitkerjaM::model()->findAll("unitkerja_aktif = TRUE ORDER BY namaunitkerja ASC"), 'unitkerja_id', 'namaunitkerja'), 

			array('empty'=>'-- Pilih --','class'=>'span3 numbers-only')); ?>
		</div>
	</div>
	
	 * 
	 */ ?>
	<div class="control-group">
		<?php echo CHtml::label("Periode Posting",'periodeposting_id', array('class' => 'control-label')) ?>
		<div class="controls">
	<?php echo $form->dropDownList($model,'periodeposting_id',CHtml::listData(
					PeriodepostingM::model()->findAll(" periodeposting_aktif = TRUE ORDER BY periodeposting_nama ASC "), 'periodeposting_id', 'periodeposting_nama'
					), array('empty'=>'-- Pilih --','class'=>'span3 custom-only')); ?>
		</div>
	</div>
</div>
<div class="col-sm-6">
	<?php echo $form->textFieldRow($model,'kdrekening5',array('class'=>'span3 numbers-only')); ?>
	<?php echo $form->textFieldRow($model,'nmrekening5',array('class'=>'span3 custom-only')); ?>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="'.MyIcon::getIcons('cari').'"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="'.MyIcon::getIcons('ulang').'"></i>')), 
        Yii::app()->createUrl($this->module->id.'/SaldoAwal/informasi'), 
        array('class'=>'btn btn-danger',
           	  'onclick'=>'if(!confirm("'.Yii::t('mds','Do You want to cancel?').'")) return false;')); ?>
  	<?php
                $tips = array(
                    '0' => 'cari',
                    '1' => 'ulang2'
                );
	?>
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')),
						array('class'=>'btn btn-info', 'type'=>'button', 'onclick'=>'print("PRINT")'))."&nbsp;"; 
		$content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>
</div>
		<?php $this->endWidget(); ?>
<?php 
	$debit = 0;
	$kredit = 0;
	foreach ($saldoawal as $val){
		$debit += $val->jmlsaldoawald;

		$kredit += $val->jmlsaldoawalk;
	}
	


    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printInfoSaldoAwal'); 
?>
<script>    
	function print(caraPrint){		
		if (<?php echo $debit ?> != <?php echo $kredit ?>){
			myConfirm("Nilai saldo awal tidak balance. Apakah anda tetap akan melanjutkan untuk mencetak data ini ?","Perhatian",function(r){
				if (r){
					window.open("<?php echo $urlPrint; ?>/"+$('#aksaldoawal-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
				}else{
					
				}
			});
		}else{
			window.open("<?php echo $urlPrint; ?>/"+$('#aksaldoawal-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
		}
    }
</script>

