<?php
/**
* - digunakan untuk untuk generate data CGS
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/
?>
<table class="table noborder">
	<tr>
		<td colspan="4">
			<div class="control-group">
					<?php echo $form->labelEx($modAsesTriase,'gcs_nilai', array('class'=>'control-label','style'=>'text-align:left;width:70px;')) ?>
				<div class="controls">
					<?php echo $form->textField($modAsesTriase,'gcs_nilai',array('class'=>'col-sm-4', 'readonly'=>true, 'style'=>'text-align:right;')) ?>
				</div>
			</div>
			<!--<div class="hasilKeterangan">-->
				
			<!--</div>-->
			<div class="control-group">
					<?php echo $form->label($modAsesTriase,'gcs_nama', array('class'=>'control-label','style'=>'text-align:left;width:70px;')) ?>
				<div class="controls">
					<?php echo $form->textField($modAsesTriase,'gcs_nama',array('class'=>'col-sm-12', 'readonly'=>true)) ?>
				</div>
			</div>
			
		</td>
	</tr>
	<tr>
		<td>		
			<div class="control-group">
					<?php echo $form->labelEx($modAsesTriase,'gcs_eye', array('class'=>'control-label','style'=>'text-align:left;')) ?>
				<div class="controls">
					<?php $crit = new CDbCriteria();
					$crit->compare('LOWER(metodegcs_singkatan)',"e");
					$crit->addCondition('metodegcs_nilai is not null');
					$crit->order = 'metodegcs_nilai ASC';
					echo $form->radioButtonList($modAsesTriase,'gcs_eye',  
					CHtml::listData(RJMetodeGCSM::model()->findAll($crit), 'metodegcs_nilai', 'textMetodeGCSM'),array('class'=>'', 'onkeypress'=>"return $(this).focusNextInputField(event);",'onchange'=>'hitungCGS()')); ?>
				</div>
			</div>
		</td>
		<td>
			<div class="control-group">
				<?php echo $form->labelEx($modAsesTriase,'gcs_verbal', array('class'=>'control-label','style'=>'text-align:left;')) ?>
				<div class="controls">
					<?php 
					$crit3 = new CDbCriteria();
					$crit3->compare('LOWER(metodegcs_singkatan)',"v");
					$crit3->addCondition('metodegcs_nilai is not null');
					$crit3->order = 'metodegcs_nilai ASC';
					echo $form->radioButtonList($modAsesTriase,'gcs_verbal',
					CHtml::listData(RJMetodeGCSM::model()->findAll($crit3), 'metodegcs_nilai', 'textMetodeGCSM'),array('empty'=>'-- Pilih --', 'class'=>'', 'onkeypress'=>"return $(this).focusNextInputField(event);",'onchange'=>'hitungCGS()')); ?>
				</div>
			</div>
		</td>
		<td colspan="2">
			<div class="control-group">
				<?php echo $form->labelEx($modAsesTriase,'gcs_motorik', array('class'=>'control-label','style'=>'text-align:left;')) ?>
				<div class="controls">
					<?php 
					$crit2 = new CDbCriteria();
					$crit2->compare('LOWER(metodegcs_singkatan)',"m");
					$crit2->addCondition('metodegcs_nilai is not null');
					$crit2->order = 'metodegcs_nilai ASC';
					echo $form->radioButtonList($modAsesTriase,'gcs_motorik',
					CHtml::listData(RJMetodeGCSM::model()->findAll($crit2), 'metodegcs_nilai', 'textMetodeGCSM'),array('empty'=>'-- Pilih --', 'class'=>'', 'onkeypress'=>"return $(this).focusNextInputField(event);",'onchange'=>'hitungCGS()')); ?>
				</div>
			</div>
		</td>
	</tr>
	<tr>
		<td colspan="4" style="text-align: center;">
			<b>SKOR</b> 
			<span id="skalanyerirange_1_8"  min="1" max="8"><b>1-8</b> : Cedera Kepala Berat</span> &nbsp; &nbsp; &nbsp; &nbsp;
			<span id="skalanyerirange_9_12"  min="9" max="12"><b>9-12</b> : Cedera Kepala Sedang</span> &nbsp; &nbsp; &nbsp; &nbsp;
			<span id="skalanyerirange_13_14"  min="13" max="14"><b>13-14</b> : Cedera Kepala Ringan</span> &nbsp; &nbsp; &nbsp; &nbsp;
			<span id="skalanyerirange_15"  min="15" max="15"><b>15</b> : Normal</span> &nbsp; &nbsp; &nbsp; &nbsp;
		</td>
	</tr>
</table>