<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'ppinformasiloketantrian-search',
        'focus'=>'#'.CHtml::activeId($model,'loket_nama'),
        'type'=>'horizontal',
)); ?>
<fieldset class="box">
 <legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
    <table width='100%' class="table-condensed">
        <tbody>
            <tr>
                <td>
                    <?php //echo  $form->textFieldRow($model,'tgl_pendaftaran'); ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'tglantrian', array('class' => 'control-label')) ?>
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
                                'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3'),
                            ));
                            ?>
                            <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class='control-label'>Sampai Dengan</label>
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
                                'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3'),
                            ));
                            ?>
                            <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($model,'loket_nama',array('class'=>'span3','maxlength'=>50,'placeholder'=>'Nama Loket')); ?>
                </td>
                <td>
                    	<?php echo $form->textFieldRow($model,'noantrian',array('class'=>'span3','maxlength'=>6,'placeholder'=>'No. Antrian')); ?>
                        <?php echo $form->textFieldRow($model,'no_pendaftaran',array('class'=>'span3','maxlength'=>20,'placeholder'=>'No. Pendaftaran')); ?>
                </td>
            </tr>
    </table>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                                    $this->createUrl($this->id.'/index'), 
                                    array('class'=>'btn btn-danger',
                                        'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index').'";} ); return false;')); ?>
        <?php   $content = $this->renderPartial('../tips/informasi',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>	
    </div>
</fieldset>
<?php $this->endWidget(); ?>
