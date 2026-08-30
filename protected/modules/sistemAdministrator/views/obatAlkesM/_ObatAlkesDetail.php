<div class="panel panel-success">
	<div class="panel-heading">        
		<div class="panel-title"><?php echo CHtml::checkBox('pakeDetailObat',true , array('onkeypress'=>"return $(this).focusNextInputField(event)")) ?>
	Obat Alkes Detail</div>
	</div>
	<div class="panel-body">
		<div id="divObatalkesdetail" class="toggle">
			<table width='100%'>
				<tr>
					<td>
						<div class="control-label">Indikasi</div>
						<div class="controls">
						<?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modObatAlkesDetail,'attribute'=>'indikasi','toolbar'=>'mini','height'=>'100px','name'=>'ObatalkesdetailM_indikasi' )) ?>
						</div>
					</td>
					<td>
						<div class="control-label">Kontraindikasi</div>
						<div class="controls">
						<?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modObatAlkesDetail,'attribute'=>'kontraindikasi','toolbar'=>'mini','height'=>'100px','name'=>'ObatalkesdetailM_kontraindikasi')) ?>
						</div>
					</td>
				</tr>

				<tr>
					<td>
						<div class="control-label">Komposisi</div>
						<div class="controls">
						<?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modObatAlkesDetail,'attribute'=>'komposisi','toolbar'=>'mini','height'=>'100px','name'=>'ObatalkesdetailM_komposisi')) ?>
						</div>
					</td>
					<td>
						<div class="control-label">Efek Samping</div>
						<div class="controls">
						<?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modObatAlkesDetail,'attribute'=>'efeksamping','toolbar'=>'mini','height'=>'100px','name'=>'ObatalkesdetailM_efeksamping')) ?>
						</div>
					</td>
				</tr>

				<tr>
					<td>
						<div class="control-label">Interaksi Obat</div>
						<div class="controls">
						<?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modObatAlkesDetail,'attribute'=>'interaksiobat','toolbar'=>'mini','height'=>'100px','name'=>'ObatalkesdetailM_interaksiobat')) ?>
						</div>
					</td>
					<td>
						<div class="control-label">Cara Penyimpanan</div>
						<div class="controls">
						<?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modObatAlkesDetail,'attribute'=>'carapenyimpanan','toolbar'=>'mini','height'=>'100px','name'=>'ObatalkesdetailM_carapenyimpanan')) ?>
						</div>
					</td>
				</tr>

				<tr>
					<td>
						<div class="control-label">Peringatan</div>
						<div class="controls">
						<?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modObatAlkesDetail,'attribute'=>'peringatan','toolbar'=>'mini','height'=>'100px','name'=>'ObatalkesdetailM_peringatan')) ?>
						</div>
					</td>
					<td></td>
				</tr>

			</table>
		</div>
	</div>
</div>
       
<?php
$enableInputobatdetail = ($model->formObatAlkesDetail) ? 1 : 0;
$js = <<< JS
if(${enableInputobatdetail}) {
    $('#divObatalkesdetail input').removeAttr('disabled');
    $('#divObatalkesdetail select').removeAttr('disabled');
}
else {
    $('#divObatalkesdetail input').attr('disabled','true');
    $('#divObatalkesdetail select').attr('disabled','true');
}

$('#pakeDetailObat').change(function(){
        if ($(this).is(':checked')){
                $('#divObatalkesdetail input').removeAttr('disabled');
                $('#divObatalkesdetail select').removeAttr('disabled');
        }else{
                $('#divObatalkesdetail input').attr('disabled','true');
                $('#divObatalkesdetail select').attr('disabled','true');
                $('#divObatalkesdetail input').attr('value','');
                $('#divObatalkesdetail select').attr('value','');
        }
        $('#divObatalkesdetail').slideToggle(500);
    });

JS;
Yii::app()->clientScript->registerScript('obatalkesdetail',$js,CClientScript::POS_READY);
?>
<script>
//Set focus setelah page load semua
window.onload = function(){
    setTimeout('$(\'#GFObatAlkesM_obatalkes_kode\').focus();',500);
}
</script>