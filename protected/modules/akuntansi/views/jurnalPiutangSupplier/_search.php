
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'jurnalpiutangsupplier-search',
        'type'=>'horizontal',
        'htmlOptions'=>array(
                'onKeyPress'=>'return disableKeyPress(event)'
        ),
        'focus'=>'#',
)); ?>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->labelEx($model,'tglfaktur',array('class'=>'control-label'));?>
                <div class="controls">
                    <?php   
                        $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'tglAwal',
                            'mode'=>'date',
                            'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions'=>array(
                                'class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'readonly'=>true
                            ),
                        ));
                    ?>

                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="AKRincianfakturhutangsupplierV_tglAkhir">Sampai Dengan</label>
                <div class="controls">
                    <?php   
                        $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'tglAkhir',
                            'mode'=>'date',
                            'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions'=>array(
                                'class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'readonly'=>true
                            ),
                        ));
                    ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <?php echo $form->textFieldRow($model,'nofaktur',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php
                echo $form->dropDownListRow($model, 'supplier_id', CHtml::listData(SupplierM::model()->findAll(array('order'=>'supplier_nama'),'supplier_aktif = true'), 'supplier_id', 'supplier_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50));
            ?>
        </div>
    <div class="clear"></div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('id'=>'btn_submit','class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'addDetail()')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('id'=>'btn_resset','class' => 'btn btn-default', 'type'=>'reset','onclick'=>'konfirmasi();')); ?>
    </div>

<?php $this->endWidget();
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai	
    Yii::app()->clientScript->registerScript('reloadPage', '
    function konfirmasi(){
        window.location.href="'.Yii::app()->createUrl($module.'/'.$controller.'/Index', array('modul_id'=>Yii::app()->session['modul_id'])).'";
    }', CClientScript::POS_HEAD);
?>
   