<legend class="rim"><i class="entypo-search"></i> Pencarian</legend>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(	
	'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type'=>'horizontal',
        'id'=>'search-penunjangrujukan-form',
        'focus'=>'#'.CHtml::activeId($model,'no_pendaftaran'),
        'htmlOptions'=>array(),
)); 
?>
<table style="width: 100%; border: none;">
    <tr>
        <td>
            <div class="control-group">
                <label for="noPendaftaran" class="control-label">No. Pendaftaran</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model,'no_pendaftaran',array('placeholder'=>'No. Pendaftaran')); ?>
                </div>
            </div>    
            <div class="control-group">
                <label for="noRekamMedik" class="control-label">No. Rekam Medik</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model,'no_rekam_medik',array('placeholder'=>'No. Rekam Medik')); ?>
                </div>
            </div>    
            <div class="control-group">
                <label for="namaPasien" class="control-label">Nama Pasien</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model,'nama_pasien',array('placeholder'=>'Nama Pasien')); ?>
                </div>
            </div> 
        </td>
        <td>
            <div class="control-group">
                <label for="namaPasien" class="control-label">
                    <?php $model->cbTglMasuk = true; ?>
                    <?php echo CHtml::activeCheckBox($model,'cbTglMasuk', array('uncheckValue'=>0,'onClick'=>'cekTanggal()')); ?>
                    Tanggal Rujukan 
              </label>
                <div class="controls">
                    <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
                    <?php   $format = new MyFormatter;
                            $this->widget('MyDateTimePicker',array(
                            'model' => $model,
                            'attribute' => 'tgl_awal',
                            'mode' => 'date',
//                                          'maxDate'=>'d',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                    )); 
                       ?> 
                    <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
                </div></div>
						<div class="control-group">
                    <label for="namaPasien" class="control-label">
                       Sampai dengan
                    </label>
                    <div class="controls">
                            <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                            <?php   
                            $this->widget('MyDateTimePicker',array(
                            'model' => $model,
                            'attribute' => 'tgl_akhir',
                            'mode' => 'date',
//                                          'maxDate'=>'d',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                    )); ?>
                        <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                </div>
            </div>
        </td>
    </tr>
</table>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit','name'=>'submitSearch')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                        $this->createUrl($this->id.'/index'), 
                        array('class' => 'btn btn-default',
//                                      'onclick'=>'if(!confirm("Apakah Anda ingin mengulang ini ?")) return false;'));
                                  'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
    <?php 
    $content = $this->renderPartial('../tips/informasi',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>
</div>

<?php $this->endWidget(); ?>
