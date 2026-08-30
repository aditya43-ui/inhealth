<?php
//========= Dialog buat cari data pemeriksa =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
	'id'		 => 'dialogPemeriksaLengkap',
	'options'	 => array(
		'title'		 => 'Dokter Pemeriksa',
		'autoOpen'	 => false,
		'modal'		 => true,
		'width'		 => 800,
		'height'	 => 256,
		'resizable'	 => false,
	),
));
?> 
<table>
	<tr>
		<td>
			<?php echo CHtml::hiddenField('baris', '', array('id' => 'rowTindakan',
				'readonly' => true)) ?>
			<div class="control-group">
					<?php echo CHtml::activeLabel($modTindakan, 'Dokter Pemeriksa'); ?>
				<div class="controls">
					<?php
					$this->widget('MyJuiAutoComplete', array(
						'name'			 => 'dokterpemeriksa1_id',
						'value'			 => '',
						'sourceUrl'		 => Yii::app()->createUrl('perawatanIntensif/tindakanTPI/GetDokter'),
						'options'		 => array(
							'showAnim'	 => 'fold',
							'minLength'	 => 4,
							'focus'		 => 'js:function( event, ui ) {
                                            $("#dokterpemeriksa1_id").val( ui.item.label);
                                            return false;
                                        }',
							'select'	 => 'js:function( event, ui ) {
                                            setDokterPemeriksa1(ui.item);
                                            return false;
                                        }',
						),
						'htmlOptions'	 => array(
							'onblur'	 => 'if(this.value === ""){ $("#dokterpemeriksa1_id").val("");updateDokterPemeriksa1(this.value);} ',
							'onkeypress' => "return $(this).focusNextInputField(event)"),
					));
					?>
				</div>
			</div>
			<div class="control-group">
					<?php echo CHtml::activeLabel($modTindakan, 'dokterdelegasi_id'); ?>
				<div class="controls">
					<?php
					$this->widget('MyJuiAutoComplete', array(
						'name'			 => 'dokterdelegasi_id',
						'value'			 => '',
						'sourceUrl'		 => Yii::app()->createUrl('perawatanIntensif/tindakanTPI/GetDokter'),
						'options'		 => array(
							'showAnim'	 => 'fold',
							'minLength'	 => 4,
							'focus'		 => 'js:function( event, ui ) {
                                            $("#dokterdelegasi_id").val( ui.item.label);
                                            return false;
                                        }',
							'select'	 => 'js:function( event, ui ) {
                                            setDokterDelegasi(ui.item);
                                            return false;
                                        }',
						),
						'htmlOptions'	 => array(
							'onblur'	 => 'if(this.value === ""){ $("#dokterdelegasi_id").val("");updateDokterDelegasi(this.value);} ',
							'onkeypress' => "return $(this).focusNextInputField(event)"),
					));
					?>
				</div>
			</div>
			<!--<div class="control-group">
			<?php echo CHtml::activeLabel($modTindakan, 'dokterpemeriksa2_id'); ?>
				<div class="controls">
			<?php
			$this->widget('MyJuiAutoComplete', array(
				'name'			 => 'dokterpemeriksa2_id',
				'value'			 => '',
				'sourceUrl'		 => Yii::app()->createUrl('perawatanIntensif/tindakanTPI/GetDokter'),
				'options'		 => array(
					'showAnim'	 => 'fold',
					'minLength'	 => 4,
					'focus'		 => 'js:function( event, ui ) {
                                            $("#dokterpemeriksa2_id").val( ui.item.label);
                                            return false;
                                        }',
					'select'	 => 'js:function( event, ui ) {
                                            setDokterPemeriksa2(ui.item);
                                            return false;
                                        }',
				),
				'htmlOptions'	 => array(
					'onblur'	 => 'if(this.value === "") $("#dokterpemeriksa2_id").val(""); ',
					'onkeypress' => "return $(this).focusNextInputField(event)"),
			));
			?>
				</div>
			</div>
			<div class="control-group">
			<?php echo CHtml::activeLabel($modTindakan, 'dokterpendamping_id'); ?>
				<div class="controls">
			<?php
			$this->widget('MyJuiAutoComplete', array(
				'name'			 => 'dokterpendamping_id',
				'value'			 => '',
				'sourceUrl'		 => Yii::app()->createUrl('perawatanIntensif/tindakanTPI/GetDokter'),
				'options'		 => array(
					'showAnim'	 => 'fold',
					'minLength'	 => 4,
					'focus'		 => 'js:function( event, ui ) {
                                            $("#dokterpendamping_id").val( ui.item.label);
                                            return false;
                                        }',
					'select'	 => 'js:function( event, ui ) {
                                            setDokterPendamping(ui.item);
                                            return false;
                                        }',
				),
				'htmlOptions'	 => array(
					'onblur'	 => 'if(this.value === "") $("#dokterpendamping_id").val(""); ',
					'onkeypress' => "return $(this).focusNextInputField(event)"),
			));
			?>
				</div>
			</div>
			<div class="control-group">
			<?php echo CHtml::activeLabel($modTindakan, 'dokteranastesi_id'); ?>
				<div class="controls">
			<?php
			$this->widget('MyJuiAutoComplete', array(
				'name'			 => 'dokteranastesi_id',
				'value'			 => '',
				'sourceUrl'		 => Yii::app()->createUrl('perawatanIntensif/tindakanTPI/GetDokter'),
				'options'		 => array(
					'showAnim'	 => 'fold',
					'minLength'	 => 4,
					'focus'		 => 'js:function( event, ui ) {
                                            $("#dokteranastesi_id").val( ui.item.label);
                                            return false;
                                        }',
					'select'	 => 'js:function( event, ui ) {
                                            setDokterAnastesi(ui.item);
                                            return false;
                                        }',
				),
				'htmlOptions'	 => array(
					'onblur'	 => 'if(this.value === ""){ $("#dokteranastesi_id").val("");} ',
					'onkeypress' => "return $(this).focusNextInputField(event)"),
			));
			?>
				</div>
			</div>-->
		</td>

		<td>
			<div class="control-group">
					<?php echo CHtml::activeLabel($modTindakan, 'bidan_id'); ?>
				<div class="controls">
					<?php
					$this->widget('MyJuiAutoComplete', array(
						'name'			 => 'bidan_id',
						'value'			 => '',
						'sourceUrl'		 => Yii::app()->createUrl('perawatanIntensif/tindakanTPI/GetBidan'),
						'options'		 => array(
							'showAnim'	 => 'fold',
							'minLength'	 => 4,
							'focus'		 => 'js:function( event, ui ) {
                                            $("#bidan_id").val( ui.item.label);
                                            return false;
                                        }',
							'select'	 => 'js:function( event, ui ) {
                                            setBidan(ui.item);
                                            return false;
                                        }',
						),
						'htmlOptions'	 => array(
							'onblur'	 => 'if(this.value === ""){ $("#bidan_id").val("");updateBidan(this.value);} ',
							'onkeypress' => "return $(this).focusNextInputField(event)"),
					));
					?>
				</div>
			</div>
			<div class="control-group">
					<?php echo CHtml::activeLabel($modTindakan, 'suster_id'); ?>
				<div class="controls">
					<?php
					$this->widget('MyJuiAutoComplete', array(
						'name'			 => 'suster_id',
						'value'			 => '',
						'sourceUrl'		 => Yii::app()->createUrl('perawatanIntensif/tindakanTPI/GetSuster'),
						'options'		 => array(
							'showAnim'	 => 'fold',
							'minLength'	 => 4,
							'focus'		 => 'js:function( event, ui ) {
                                            $("#suster_id").val( ui.item.label);
                                            return false;
                                        }',
							'select'	 => 'js:function( event, ui ) {
                                            setSuster(ui.item);
                                            return false;
                                        }',
						),
						'htmlOptions'	 => array(
							'onblur'	 => 'if(this.value === ""){ $("#suster_id").val("");updateSuster(this.value);} ',
							'onkeypress' => "return $(this).focusNextInputField(event)"),
					));
					?>
				</div>
			</div>
			<div class="control-group">
					<?php echo CHtml::activeLabel($modTindakan, 'perawat_id'); ?>
				<div class="controls">
					<?php
					$this->widget('MyJuiAutoComplete', array(
						'name'			 => 'perawat_id',
						'value'			 => '',
						'sourceUrl'		 => Yii::app()->createUrl('perawatanIntensif/tindakanTPI/GetPerawat'),
						'options'		 => array(
							'showAnim'	 => 'fold',
							'minLength'	 => 4,
							'focus'		 => 'js:function( event, ui ) {
                                            $("#perawat_id").val( ui.item.label);
                                            return false;
                                        }',
							'select'	 => 'js:function( event, ui ) {
                                            setPerawat(ui.item);
                                            return false;
                                        }',
						),
						'htmlOptions'	 => array(
							'onblur'	 => 'if(this.value === ""){ $("#perawat_id").val("");updatePerawat(this.value);} ',
							'onkeypress' => "return $(this).focusNextInputField(event)"),
					));
					?>
				</div>
			</div>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<div class="">
<?php
echo CHtml::htmlButton(Yii::t('mds', '{icon} Ok', array('{icon}' => '<i class="entypo-check"></i>')), array(
	'class'		 => 'btn btn-primary', 'onKeypress' => 'return formSubmit(this,event)',
	'onclick'	 => '$("#dialogPemeriksaLengkap").dialog("close");'));
?>
			</div>
		</td>
	</tr>
</table>
<?php
$this->endWidget();
//========= end pemeriksa dialog =============================
?>  