<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'searchLaporan',
        'type'=>'horizontal',
)); ?>
<table style="width: 100%; border: none;"><tr>
    <td width="50%">
        <div class="control-group">
            <label class="control-label">Periode Penggajian</label>
            <div class="controls">
                <?php   
                    $this->widget('MyDateTimePicker',array(
                                    'model'=>$model,
                                    'attribute'=>'tgl_awal',
                                    'mode'=>'date',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:140px;',
                                    ),
                    )); 
                ?>
            </div>
        </div>
        
	<?php // echo $form->textFieldRow($model,'nobayarjasa',array('class'=>'span3','maxlength'=>10)); ?>

    </td>
    <td>
        <div class="control-group">
            <label class="control-label">Sampai dengan</label>
            <div class="controls">
                <?php  
                    $this->widget('MyDateTimePicker',array(
                                    'model'=>$model,
                                    'attribute'=>'tgl_akhir',
                                    'mode'=>'date',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:140px;',
                                    ),
                    )); 
                ?>
            </div>
        </div>
        <?php // echo $form->textFieldRow($model,'namaperujuk',array('class'=>'span3')); ?>
        
        <?php // echo $form->textFieldRow($model,'nama_pegawai',array('class'=>'span3')); ?>
            
        <?php // echo $form->textFieldRow($model,'nokaskeluar',array('class'=>'span3')); ?>
    </td>
</tr></table>
	<div class="form-actions">
            <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                Yii::app()->createUrl($this->route), 
                array('class'=>'btn btn-danger')); ?>
            <?php  
//                $content = $this->renderPartial('../tips/informasi',array(),true);
//                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
	</div>

<?php $this->endWidget(); ?>
