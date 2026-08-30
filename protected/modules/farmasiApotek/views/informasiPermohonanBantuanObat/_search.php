<div id="divSearch-form">
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'permohonanoa-t-search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'permohonanoa_nomor'),
)); ?> 
<fieldset class="box">
    <legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
    <table style="width: 100%; border: none;">
        <tr>
            <td>
                <div class="control-group">
                        <?php echo CHtml::label('Tgl. Permohonan','permohonanoa_tgl', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php   
                                    $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
                                    $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'tgl_awal',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                        ),
                                    )); 
                                    $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
                                ?>
                            </div>
                    </div>
            </td>
            <td>
                <div class="control-group">
                    <?php echo CHtml::label('Sampai Dengan','sampaiDengan', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tgl_akhir',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                                )); 
                                $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
                            ?>
                        </div>
                </div>
            </td>
            <td>
                <?php echo $form->textFieldRow($model,'permohonanoa_nomor',array('placeholder'=>'No. Permohonan','class'=>'numberOnly')); ?>
            </td>
        </tr>
    </table>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
        <?php
             if(!isset($_GET['frame'])){
                echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                    $this->createUrl($this->id.'/index'), 
                    array('class' => 'btn btn-default',
                          'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
            }
        ?>
        <?php
            $content = $this->renderPartial('../tips/informasi_pencarian',array(),true);
           $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </div>
</fieldset>
<?php $this->endWidget(); ?>
</div>