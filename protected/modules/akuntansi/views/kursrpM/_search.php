<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'kursrp-m-search',
    'type' => 'horizontal',
)); ?>

<table style="width: 100%; border: none;">
    <tr>
        <td>
            <div class="col-sm-6">
                <div class='control-group'>
                    <?php echo $form->labelEx($model, 'matauang_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo  $form->dropDownList($model, 'matauang_id', CHtml::listData(MatauangM::model()->findAll(array('condition' => 'matauang_aktif = TRUE', 'order' => 'matauang ASC')), 'matauang_id', 'matauang'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
                    </div>
                </div>

                <div class='control-group'>
                    <?php echo $form->labelEx($model, 'tglkursrp', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php //$minDate = (Yii::app()->user->getState('tglpemakai')) ? '' : 'd'; 
                        ?>
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglkursrp',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                //                                                        'minDate' => 'd',
                                //                                                                'maxDate'=>$minDate,
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3',),
                        ));
                        ?>
                    </div>
                </div>
                <div class='control-group'>
                    <?php echo CHtml::label("", 'kursrp_aktif', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->checkBox($model, 'kursrp_aktif', array('checked' => 'checked')); ?> <label for="AKKursrpM_kursrp_aktif">Aktif</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class='control-group'>
                    <?php echo $form->labelEx($model, 'nilai', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'nilai', array('placeholder' => 'Nilai', 'class' => 'span3 integer2')); ?>
                    </div>
                </div>
                <div class='control-group'>
                    <?php echo $form->labelEx($model, 'rupiah', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'rupiah', array('placeholder' => 'Rupiah', 'class' => 'span3 integer2',)); ?>
                    </div>
                </div>
            </div>
        </td>
    </tr>
</table>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    );
    ?>
</div>

<?php $this->endWidget(); ?>