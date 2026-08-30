<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'gfstoreed-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
	'focus'=>'#',
)); ?>
<?php $disabled = isset($_GET['sukses'])?true:false; ?>
<?php $disabled2 = isset($_GET['sukses'])?false:true; ?>
<?php echo $form->errorSummary($model); ?>
<div class="panel panel-success">
    <div class="panel-heading">
	<div class="panel-title"><i class="glyphicon glyphicon-file"></i> Obat dan Alat Kesehatan</div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial($this->path_view.'_formInputObat', array('model'=>$model, 'form'=>$form, 'modDetails'=>$modDetails, 'disabled'=>$disabled)); ?>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
	<div class="panel-title"><i class="glyphicon glyphicon-credit-card"></i> Store Obat Alkes Expired Date</div>
    </div>
    <div class="panel-body">
        <table class="items table table-striped table-condensed" id="table-obatalkesED">
                <thead>
                        <tr>
                                <th>No.</th>
                                <th>Nama Obat</th>
                                <th>Supplier</th>
                                <th>Tanggal Kadaluarsa</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Total Harga</th>
                                <th>Satuan Kecil</th>
                                <?php echo ($disabled)?"":"<th>Batal</th>"; ?>
                        </tr>
                </thead>
                <tbody>

                </tbody>
        </table>
    </div>
</div>

<div class="form-actions">
	<?php
		echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
				Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
				array('id'=>'btn_submit','class'=>'btn btn-danger', 'type'=>'button','onclick'=>'cekObat();', 'onKeypress'=>'cekObat();','disabled'=>$disabled));
	
	?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
							$this->createUrl($this->module->id.'/Index'), 
							array('class'=>'btn btn-default',
								'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('Index').'";} ); return false;'));  ?>
	<?php
			echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')", 'disabled'=>$disabled2));
			echo "&nbsp;";
	?>
	<?php
		$content = $this->renderPartial('farmasiApotek.views.pemakaianObat.tips.informasi',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>
</div>
<?php $this->endWidget(); ?>
