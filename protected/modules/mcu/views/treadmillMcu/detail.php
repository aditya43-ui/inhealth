<?php
$this->breadcrumbs = array(
    'Mcu',
);
$this->widget('bootstrap.widgets.BootAlert');
?>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'treadmill-mcu-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'
    ),
));
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Hasil Treadmil
        </div>
    </div>
    <div class="panel-body">
        <div class="panel-body">
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="100%">
                        <table id="form-treadmilldetail-mcu" class="table table-bordered table-condensed">

                            <thead>
                                <tr>
                                    <th>Duration</th>
                                    <th>Blood Preasure</th>
                                    <th>Heart Rate</th>
                                    <th>Work Load</th>
                                    <th>Est. 02 Rate</th>
                                    <th>Max. 02 Intake</th>
                                    <th>Mets</th>
                                    <th>Fitness Clasification</th>
                                    <th>Walking</th>
                                    <th>Jogging</th>
                                    <th>Bicycling</th>
                                    <th>Other Sport</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <?php //echo $form->textField($modTreadmill,'duration_treadmill',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); 
                                        ?>
                                        <?php echo $form->textField($modTreadmillDetail, 'duration_treadmill', array('readonly' => false, 'class' => 'span1')); ?>
                                    </td>
                                    <td><?php echo $form->textField($modTreadmillDetail, 'td_systolic', array('readonly' => false, 'class' => 'span1 integer')); ?> /
                                        <?php echo $form->textField($modTreadmillDetail, 'td_diastolic', array('readonly' => false, 'class' => 'span1 integer')); ?> mmHg</td>
                                    <td>
                                        <?php echo $form->textField($modTreadmillDetail, 'heartrate_treadmill', array('readonly' => false, 'class' => 'span1 integer')); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textField($modTreadmillDetail, 'workload_kph', array('readonly' => false, 'class' => 'span1 integer')); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textField($modTreadmillDetail, 'est02_rate_min', array('readonly' => false, 'class' => 'span1 integer')); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textField($modTreadmillDetail, 'max02_intake', array('readonly' => false, 'class' => 'span1 integer')); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textField($modTreadmillDetail, 'mets_treadmill', array('readonly' => false, 'class' => 'span1 integer')); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textField($modTreadmillDetail, 'fitnessclassification', array('readonly' => false, 'class' => 'span2')); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textField($modTreadmillDetail, 'walking_kmhr_treadmill', array('readonly' => false, 'class' => 'span2')); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textField($modTreadmillDetail, 'jogging_kmhr_treadmill', array('readonly' => false, 'class' => 'span2')); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textField($modTreadmillDetail, 'bicycling_kmhr_treadmill', array('readonly' => false, 'class' => 'span2')); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textArea($modTreadmillDetail, 'sports_kmhr_treadmill', array('readonly' => false, 'class' => 'span2')); ?>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </td>
                </tr>
            </table>

            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->LabelEx($modTreadmill, 'resttime_menit', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modTreadmill, 'resttime_menit', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?> min
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->LabelEx($modTreadmill, 'worktime_menit', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modTreadmill, 'worktime_menit', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?> min
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->LabelEx($modTreadmill, 'recoverytime_menit', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modTreadmill, 'recoverytime_menit', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?> min
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->LabelEx($modTreadmill, 'totaltime_menit', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modTreadmill, 'totaltime_menit', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?> min
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->LabelEx($modTreadmill, 'interpretation_tradmill', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modTreadmill, 'interpretation_tradmill', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->LabelEx($modTreadmill, 'namapemeriksa_treadmill', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php $this->widget('MyJuiAutoComplete', array(
                            'model' => $modTreadmill,
                            'attribute' => 'namapemeriksa_treadmill',
                            'value' => '',
                            'sourceUrl' => $this->createUrl('AutocompletePemeriksa'),
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                                $(this).val( ui.item.nama_pegawai);
                                return false;
                        }',
                            ),
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->LabelEx($modTreadmill, 'hasiltreadmill', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->radioButtonListInlineRow($modTreadmill, 'hasiltreadmill', array('Normal' => 'Normal', 'Ada Kelainan' => 'Ada Kelainan'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-primary', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;')) ?>
    </div>
</div>

<?php $this->endWidget(); ?>
<?php
echo $this->renderPartial($this->path_view . '_jsFunctions', array(
    'form' => $form,
    'modTreadmill' => $modTreadmill,
), true);
?>

<script>
    $(document).ready(function() {
        $("input, select, textarea").attr("readonly", true);
    });
</script>