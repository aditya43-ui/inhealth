<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gradinginsidenrs-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>
<div class="col-md-6">
    <div class="control-group">
        <?php echo CHtml::label('Tanggal ', 'tgl_gradingunit', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tgl_laporan',
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    'changeYear' => false,
                ),
                'htmlOptions' => array('class' => 'dtPicker2 span3', 'onkeyup' => "return $(this).focusNextInputField(event)"),
            ));
            ?>
        </div>
    </div>
    <div class = "control-group">
        <?php echo Chtml::label("Status Laporan", 'statuslaporan', array('class' => 'control-label')) ?>
        <div class = "controls">
            <?php
            echo $form->dropDownList($model, 'statuslaporan', array(
                'Disetujui' => 'Disetujui',
                'Ditolak' => 'Ditolak'
                ), array('empty' => '-- Pilih --', 'class' => 'span3', 'onchange' => 'setDitolak()'));
            ?>
        </div>
    </div>
    <div class="control-group" id="penolakan" hidden="true">
        <?php echo Chtml::label("Kategori Penolakan", 'statuslaporan', array('class' => 'control-label')) ?>
        <div class = "controls">
            <?php echo $form->dropDownList($model, 'kategoripenolakan', LookupM::getItems("kategoripenolakan"), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Keterangan', 'tindakan', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textArea($model, 'keterangan', array('class' => 'span3', 'rows' => 5)); ?>
            <?php echo $form->hiddenField($model, 'insidenrs_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 300)); ?> 
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
            ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    function setDitolak(){
        var status = $('#YKMInsidenRST_statuslaporan').val();
        if (status == 'Ditolak') {
            $("#penolakan").removeAttr('hidden');
        } else {
            $("#penolakan").attr('hidden', true);
            $("#YKMInsidenRST_kategoripenolakan").val('');
        }
    }
    function setLaporan() {
        var id = $('#YKMInsidenRST_insidenrs_id').val();
        var tanggal = $('#YKMInsidenRST_tgl_laporan').val();
        var status = $('#YKMInsidenRST_statuslaporan').val();
        var keterangan = $('#YKMInsidenRST_keterangan').val();
        var kategori = $('#YKMInsidenRST_kategoripenolakan').val();
        if (tanggal != '' && status != '' && keterangan != '') {
            var data = $("#informasiae-r-grid").serialize();
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('ajaxUbahStatus'); ?>',
                data: {
                    id: id,
                    tanggal: tanggal,
                    status: status,
                    keterangan: keterangan,
                    kategori: kategori
                },
                dataType: 'json',
                success: function (data) {
                    if (data.status == 'proses_form') {
                        window.parent.$('#dialogLaporan').dialog('close');
                        window.parent.reloadTabel();
                    } else {
                        myAlert("Perubahan Status Laporan Gagal Disimpan");
                    }
                },
                error: function (data) { // if error occured
                    myAlert("Perubahan Status Laporan Gagal Disimpan");
                },
            });
        } else {
            myAlert("Isikan Tanggal, Status dan Keterangan Terlebih dahulu");
            return false;
        }
    }
</script>

<?php $this->endWidget(); ?>

