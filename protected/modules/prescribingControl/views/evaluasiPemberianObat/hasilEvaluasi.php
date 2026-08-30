<table width="100%"  id="tblFormHasilPemeriksaanRad" class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th><div style="text-align: center; font-size: 11pt;">Nama Obat</div></th>
            <th><div style="text-align: center; font-size: 11pt;">Keluhan</div></th>
            <th><div style="text-align: center; font-size: 11pt;">Efek Samping</div></th>
            <th><div style="text-align: center; font-size: 11pt;">Hasil Evaluasi</div></th>
        </tr>
    </thead>
<?php 
$model = PCObatalkesdetailM::model()->findAllByAttributes(array('obatalkes_id'=>221),array('limit'=>5));
?>
<?php foreach($model as $i=>$hasil): ?>
    <tr>
		<td><?php echo $hasil->obatalkes->obatalkes_nama; ?></td>
		<td><?php $this->widget('ext.redactorjs.Redactor',array('model'=>$hasil,'attribute'=>'['.$i.']keluhan','name'=>'PCObatalkesdetailM_'.$i.'_keluhan','toolbar'=>'mini','height'=>'150px')) ?></td>
		<td><?php $this->widget('ext.redactorjs.Redactor',array('model'=>$hasil,'attribute'=>'['.$i.']efeksamping','name'=>'PCObatalkesdetailM_'.$i.'_efeksamping','toolbar'=>'mini','height'=>'150px')) ?></td>
		<td><?php $this->widget('ext.redactorjs.Redactor',array('model'=>$hasil,'attribute'=>'['.$i.']hasilevaluasi','name'=>'PCObatalkesdetailM_'.$i.'_hasilevaluasi','toolbar'=>'mini','height'=>'150px')) ?></td>
		
	</tr>
<?php endforeach;?>
</table>
<div class='form-actions'>
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
								 array('class' => 'btn btn-danger', 
								 'onKeypress'=>'return formSubmit(this,event)',
								 'onsubmit'=>'#',
								 'id'=>'btn_simpan',)); ?>
        <?php
            echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('index',array('modul_id'=>Yii::app()->session['modul_id'])), array('class'=>'btn btn-danger'));
        ?>
        <?php
            echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
	?>

</div>
