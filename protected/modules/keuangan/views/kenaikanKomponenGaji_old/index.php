<div class="white-container">
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'kenaikankomponengaji-t-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
                             'onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#',
)); ?>
<legend class="rim2">Transaksi <b>Kenaikan Komponen Gaji</b></legend>
<?php
$sukses = null;
if(isset($_GET['sukses'])){
	$sukses = $_GET['sukses'];
}
if($sukses > 0){
	Yii::app()->user->setFlash('success',"Data berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="block-tabel">
	<h6>Tabel Komponen Gaji</h6>
    <table id="tblInputKomponenGaji" class="table table-bordered table-condensed">
        <thead>
            <tr>
                <th width="3%">Nomor</th>
                <th width="50%">Nama Komponen</th>
                <th width="15%">Jumlah</th>
                <th>Jumlah Kenaikan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($model as $i => $rincian){?>
            <tr>
                <td width="3%" style="text-align: center;"><?php echo $i+1; ?></td>
                <td width="50%"><?php echo $rincian->komponen->komponengaji_nama; ?><?php echo $form->hiddenField($rincian, '['.$i.']penggajiankomp_id',array('class'=>'span3','readonly'=>true)); ?></td>
                <td width="15%"><?php echo MyFormatter::formatUang($rincian->jumlah); ?><?php echo CHtml::hiddenField('jumlah',$rincian->jumlah,array('class'=>'span3','readonly'=>true)); ?></td>
                <td><?php echo CHtml::textField('jml_kenaikan','',array('class'=>'span3 integer','readonly'=>true)); ?><?php echo $form->hiddenField($rincian,'['.$i.']jml_kenaikan',array('class'=>'span3 jml_kenaikan','readonly'=>true)); ?></td>
                <td><?php echo CHtml::textField('total','',array('class'=>'span3 integer','readonly'=>true)); ?><?php echo $form->hiddenField($rincian, '['.$i.']total',array('class'=>'span3 total','readonly'=>true)); ?></td>
            </tr>
			<?php } ?>
        </tbody>
    </table>
</div>
<div class="control-group">
	<?php echo CHtml::label('Persentase Kenaikan <span class="required">*</span>','',array('class'=>'control-label')); ?>  
	<div class="controls">
		<?php echo CHtml::textField('persentase_kenaikan','',array('class'=>'span3','onkeyPress'=>'return $(this).focusNextInputField(event)')); ?>
		<?php echo CHtml::label('%',''); ?>
		<?php echo CHtml::htmlButton('Hitung', array('class' => 'btn btn-danger', 'type'=>'button', 'onkeypress'=>'hitungPersentase()', 'onclick'=>'hitungPersentase()')); ?>
	</div>
</div>
<div class="form-actions">
	<?php $disableSave = (isset($_GET['sukses'])) ? 'disabled' : ''; ?>
	<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type'=>'submit', 'onkeypress'=>'return formSubmit(this,event)','disabled'=>$disableSave)); ?>
    <?php
		echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl("/".$this->route), array('class' => 'btn btn-default',
		'onclick' => 'return refreshForm(this);'));
	?>
	<?php
		$content = $this->renderPartial('/tips/transaksi',array(),true);
		$this->widget('UserTips',array('content'=>$content));
	?>
</div>
<?php $this->endWidget(); ?>
</div>

<?php $this->renderPartial("_jsFunctions",array('model'=>$model)); ?>
