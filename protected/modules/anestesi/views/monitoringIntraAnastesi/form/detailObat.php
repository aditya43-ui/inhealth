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
        <div class="panel-title judul">Input Obat</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-md-12" id='form-input-anestesi'>
                <div id="OBAT" class="parent">
                    <div class="control-group lookup">
                        <label class="control-label">Obat</label>
                        <?php
                        $modInput = new ATInputintraanastesiT();
                        $cekObat = ATInputintraanastesiT::model()->findAllByAttributes(array('monitoringintraanastesi_id' => $model->monitoringintraanastesi_id, 'jenis_input' => 'OBAT'));
                        if (!empty($cekObat)) {
                            foreach ($cekObat as $i => $det) {
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