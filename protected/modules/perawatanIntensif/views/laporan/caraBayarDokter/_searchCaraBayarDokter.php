<legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    ));
    ?>
    <style>

        #penjamin label.checkbox{
            width: 150px;
            display:inline-block;
        }
		label.checkbox{
			width:150px;
			display:inline-block;
		}

    </style>
    <div class="row">
        <div class="col-sm-4">
            <?php // echo CHtml::hiddenField('type', ''); ?>
			<div class='control-group'>
                <?php echo CHtml::label('Periode Pendaftaran', 'dari_tanggal', array('class' => 'control-label')) ?>
                <div class="controls">  
                    <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>                     
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_awal',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => "span3",
                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ));
                    ?>
                    <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>                     
                </div> 
            </div>
			<div class='control-group'>
                <?php echo CHtml::label('Jenis Penjamin', 'carabayar', array('class' => 'control-label')) ?>
                <div class="controls">
					<?php
					echo $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                        'ajax' => array('type' => 'POST',
                            'url' => $this->createUrl('GetPenjaminPasienForCheckBox', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                            'update' => '#penjamin', //selector to update
                        ),
                    ));
					?>
				</div>
			</div>
			<div class='control-group'>
                <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
                <div class="controls">
					<?php echo CHtml::checkBox('nursestation_id', $model->nursestation_id, array('onkeypress'=>"return $(this).focusNextInputField(event)")) ?>
					<label>Berdasarkan Nurse Station</label>
				</div>
			</div>
        </div>
		
		 <div class="col-sm-4">
            <div class='control-group'>
                <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                <div class="controls">  
                    <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_akhir',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => "span3",
                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ));
                    ?>
                    <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                </div> 
            </div>
			<div class='control-group'>
                <?php echo CHtml::label('Penjamin', 'penjamin', array('class' => 'control-label')) ?>
                <div class="controls">
					<div id="penjamin">
                        <label>data tidak ditemukan</label>
                    </div>
				</div>
			</div>
		 </div>
		
    </div>  
	
	<div class="form-actions">
		<?php
		echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan'));
		?>
		<?php
		echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''), array('class' => 'btn btn-default',
			'onclick' => 'window.parent.myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
		?>
	</div>    
</div>    
<?php
$this->endWidget();
?>

<script type="text/javascript">
function checkAll() {
            if ($("#checkAllCaraBayar").is(":checked")) {
                $('#penjamin input[name*="penjamin_id"]').each(function(){
                   $(this).attr('checked',true);
                })
            } else {
               $('.#penjamin input[name*="penjamin_id"]').each(function(){
                   $(this).removeAttr('checked');
                })
            }
}
</script>