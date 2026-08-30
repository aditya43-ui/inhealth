<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'search',
    'type' => 'horizontal',
        ));

         Yii::app()->clientScript->registerScript('search', "
				$('.search-button').click(function(){
						$('.search-form').toggle();
						return false;
				});
				$('#search').submit(function(){
						$.fn.yiiGridView.update('bed-triage-m-grid', {
								data: $(this).serialize()
						});
						return false;
				});
				");

                $this->widget('bootstrap.widgets.BootAlert');
?>
<div class="row-fluid">
    <div class="col-sm-6">
        <?php
        echo $form->textFieldRow($model, 'no_bed', array('placeholder' => '', 'class' => 'span3',
            'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'disabled' => false
        ));
        ?>
        <div class="control-group ">
            <div class="controls">
                <?php echo $form->labelEx($model, 'is_aktif', array('class' => 'control-label')) ?>
                <div class="radio inline">
                    <div class="form-inline">
                        <?php echo $form->checkBox($model, 'is_aktif', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?> <label class="control-label"> Aktif</label>
                    </div>
                </div>
                <?php echo $form->error($model, 'is_aktif'); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">

    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'search')); ?>
    <?php
    echo CHtml::link(
            Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/' . $this->id . '/create'), array(
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
    );
    ?>
</div>
<?php $this->endWidget(); ?>
