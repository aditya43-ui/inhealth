<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'batalriskregister-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>

<div class="control-group">
    <?php echo CHtml::label('Alasan Pembatalan <span class="required"> * </span> ', 'tindakan', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo $form->textArea($model, 'alasanpembatalan', array('class' => 'span3', 'rows' => 5)); ?>
        <?php echo $form->hiddenField($model, 'identifikasiresiko_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 300)); ?> 

    </div>
</div>
<div class="row-fluid">
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array(
            'class' => 'btn btn-primary submit',
            'type' => 'button',
            'onclick' => 'setLaporan();return false;',
            'onKeypress' => 'return formSubmit(this,event)'
        ));
        ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('create'), array('class' => 'btn btn-danger',
            'onclick' => 'return refreshForm(this);'));
        
        echo "&nbsp";
        echo '<a class="btn btn-danger" onclick="tutup()" style="color:#fff;" href="#"><i class="fa fa-times"></i> Tutup </a>';
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
function tutup(){
    window.parent.$("#dialogBatal").dialog("close"); 
}
    function setLaporan() {
        var id = $('#YKMIdentifikasiresikoT_identifikasiresiko_id').val();
        var keterangan = $('#YKMIdentifikasiresikoT_alasanpembatalan').val();
        if (keterangan != '') {
            var data = $("#informasiae-r-grid").serialize();
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('ajaxUbahStatus'); ?>',
                data: {
                    id: id,
                    keterangan: keterangan
                },
                dataType: 'json',
                success: function (data) {
                    if (data.status == 'proses_form') {
                        window.parent.$('#dialogBatal').dialog('close');
                    } else {
                        myAlert("Perubahan Status Laporan Gagal Disimpan");
                    }
                },
                error: function (data) { // if error occured
                    myAlert("Pembatalan Gagal Dilakukan");
                }
            });
        } else {
            myAlert("Isikan Alasan Pembatalan Terlebih Dahulu");
            return false;
        }
    }
</script>