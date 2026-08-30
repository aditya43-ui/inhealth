<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogBatalBea',
    'options' => array(
        'title' => 'Batal Pasien Iur Biaya',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 200,
        'resizable' => true,
        'close' => "js:function(){ loadListIurBiaya(); }",
    ),
));
?>
<form id="formBatalBea" class="form-horizontal" style="padding: 10px;">
    <div class="row-fluid">
        <div class="col-sm-12">
            <div class="control-group">
                <label class="control-label">Alasan Batal</label>
                <div class="controls">
                    <?php echo CHtml::hiddenField('verifikasi[iurbea_id]', null, array('class'=>'verifikasi_iurbea_id')); ?>
                    <?php echo CHtml::textArea('verifikasi[alasanpembatalan]', '', array(
                        'class'=>'span4 verifikasi_alasanpembatalan', 'rows'=>4
                    )); ?>
                </div>
            </div>
            
        </div>
        <div class="form-action">
            <?php echo CHtml::htmlButton('<i class="entypo-check"></i> Simpan', array(
                'class'=>'btn btn-danger', 'onclick'=>'submitBatalBea();',
            )); ?>
        </div>
    </div>
</form>
<?php $this->endWidget(); ?>


<script>


    function batalBeaDialog(id) {
        $("#formBatalBea .verifikasi_iurbea_id").val(id);
        $("#formBatalBea .verifikasi_alasanpembatalan").val("");

        $("#dialogBatalBea").dialog("open");
    }

    function submitBatalBea() {
        $.post('<?php echo $this->createUrl('batalBea'); ?>', $("#formBatalBea").serialize(), function(data) {
            if (data.ok == 1) {
                $("#dialogBatalBea").dialog("close");
                myAlert(data.msg);
            } else {
                myAlert(data.msg);
            }
        }, 'json');
    }

</script>