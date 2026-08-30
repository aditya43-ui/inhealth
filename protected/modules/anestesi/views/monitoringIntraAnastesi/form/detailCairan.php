<?php
$this->widget('bootstrap.widgets.BootAlert');

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rootwizard',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'class' => 'form-horizontal',
        'enctype' => 'multipart/form-data',
        'onKeyPress' => 'return disableKeyPress(event)'
    ),
        ));
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title judul">Input Cairan</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-md-12" id='form-input-anestesi'>
                <div id="KRISTAOLOID" class="parent">
                    <div class="control-group lookup">
                        <label class="control-label">Kristaloid</label>
                        <?php
                        $modInput = new ATInputintraanastesiT();
                        $cekKristaloid = ATInputintraanastesiT::model()->findAllByAttributes(array('monitoringintraanastesi_id' => $model->monitoringintraanastesi_id, 'jenis_input' => 'KRISTALOID'));
                        if (!empty($cekKristaloid)) {
                            foreach ($cekKristaloid as $i => $det) {
                                ?>
                                <div class="control-group">
                                    <label class="control-label"></label>
                                    <div class="controls">
                                        <?php echo CHtml::activeTextField($det, '[' . $i . ']nama_input', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="control-group">
                                <label class="control-label"></label>
                                <div class="controls">
                                    <?php echo CHtml::activeTextField($modInput, 'nama_input', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div id="KOLLOID" class="parent">
                    <div class="control-group lookup">
                        <label class="control-label">Kolloid</label>
                        <?php
                        $modInput = new ATInputintraanastesiT();
                        $cekKolloid = ATInputintraanastesiT::model()->findAllByAttributes(array('monitoringintraanastesi_id' => $model->monitoringintraanastesi_id, 'jenis_input' => 'KOLLOID'));
                        if (!empty($cekKolloid)) {
                            foreach ($cekKolloid as $i => $det) {
                                ?>
                                <div class="control-group">
                                    <label class="control-label"></label>
                                    <div class="controls">
                                        <?php echo CHtml::activeTextField($det, '[' . $i . ']nama_input', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="control-group">
                                <label class="control-label"></label>
                                <div class="controls">
                                    <?php echo CHtml::activeTextField($modInput, 'nama_input', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div id="LAIN_LAIN" class="parent">
                    <div class="control-group lookup">
                        <label class="control-label">Darah</label>
                        <?php
                        $modInput = new ATInputintraanastesiT();
                        $cekLain = ATInputintraanastesiT::model()->findAllByAttributes(array('monitoringintraanastesi_id' => $model->monitoringintraanastesi_id, 'jenis_input' => 'DARAH'));
                        if (!empty($cekLain)) {
                            foreach ($cekLain as $i => $det) {
                                ?>
                                <div class="control-group">
                                    <label class="control-label"></label>
                                    <div class="controls">
                                        <?php echo CHtml::activeTextField($det, '[' . $i . ']sub_jenis_input', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                        <?php echo CHtml::activeTextField($det, '[' . $i . ']nama_input', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                        <?php echo CHtml::activeTextField($det, '[' . $i . ']ukuran', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>CC</label>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="control-group">
                                <label class="control-label"></label>
                                <div class="controls">
                                    <?php echo CHtml::activeTextField($modInput, 'sub_jenis_input', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);",'placeholder'=>'Darah')); ?>
                                    <?php echo CHtml::activeTextField($modInput, 'nama_input', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);",'placeholder'=>'No. Kantong')); ?>
                                    <?php echo CHtml::activeTextField($modInput, 'ukuran', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);",'placeholder'=>'Volume')); ?><label>CC</label>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div id="LAIN_LAIN" class="parent">
                    <div class="control-group lookup">
                        <label class="control-label">Lain-Lain</label>
                        <?php
                        $modInput = new ATInputintraanastesiT();
                        $cekLain = ATInputintraanastesiT::model()->findAllByAttributes(array('monitoringintraanastesi_id' => $model->monitoringintraanastesi_id, 'jenis_input' => 'LAIN_LAIN'));
                        if (!empty($cekLain)) {
                            foreach ($cekLain as $i => $det) {
                                ?>
                                <div class="control-group">
                                    <label class="control-label"></label>
                                    <div class="controls">
                                        <?php echo CHtml::activeTextField($det, '[' . $i . ']nama_input', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="control-group">
                                <label class="control-label"></label>
                                <div class="controls">
                                    <?php echo CHtml::activeTextField($modInput, 'nama_input', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>   
<script>
    $(document).ready(function () {
        $("#rootwizard").find('input,select,textarea').each(function () {
            $(this).attr('disabled', true);
        });

        $(".add-on").hide();
        $(".buttontambah").hide();
        $(".buttonhapus").hide();
        $(".rowbutton").attr("style", "display:none;");
    });
</script>