<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogVerifikasiPJANonTindakan',
    'options' => array(
        'title' => 'Validasi PJA',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 300,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
            data: $('#daftarPasien-form').serialize()
        }); }",
    ),
));
?>
<form id="formVerifikasiPJANonTindakan" class="form-horizontal" style="padding: 10px;">
    <div class="row-fluid">
        <div class="col-sm-12">
            <div class="control-group">
                <label class="control-label">Petugas Validasi</label>
                <div class="controls">
                    <?php echo CHtml::hiddenField('verifikasi[pendaftaran_id]', null, array('class'=>'verifikasi_pendaftaran_id')); ?>
                    <?php echo CHtml::hiddenField('verifikasi[pasienpulang_id]', null, array('class'=>'verifikasi_pasienpulang_id')); ?>
                    <?php echo CHtml::hiddenField('verifikasi[userapprovaltindaklanjut_id]', Yii::app()->user->getState('pegawai_id')); ?>
                    <?php echo CHtml::textField('verifikasi[userapprovaltindaklanjut_nama]', Yii::app()->user->getState('nama_pegawai'), array(
                        'class'=>'span3', 'readonly'=>true,
                    )); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Tanggal Validasi</label>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'name' => 'verifikasi[tanggal_approvaltindaklanjut]',
                        'value' => MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s')),
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat'=>Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array(
                            'class'=>'span3',
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                        ),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Keterangan Tidak Melakukan Tindakan</label>
                <div class="controls">
                    <?php echo CHtml::textArea('verifikasi[keterangantidakmelakukantindakan]', "", array(
                        'class'=>'span3 keterangantidakmelakukantindakan', 'readonly'=>false, 'rows'=>3
                    )); ?>
                </div>
            </div>
            
        </div>
        <div class="form-action">
            <?php echo CHtml::htmlButton('<i class="entypo-check"></i> Simpan', array(
                'class'=>'btn btn-danger', 'onclick'=>'verifikasiPJASimpanNonTindakan();',
            )); ?>
        </div>
    </div>
</form>
<?php $this->endWidget(); ?>


<script>

    var verifikasi_pendaftaran_id = null;

    function verifikasiPJADialogNonTindakan(pendaftaran_id, pasienpulang_id) {
        $("#formVerifikasiPJANonTindakan .verifikasi_pendaftaran_id").val(pendaftaran_id);
        $("#formVerifikasiPJANonTindakan .verifikasi_pasienpulang_id").val(pasienpulang_id);
        $("#formVerifikasiPJANonTindakan .keterangantidakmelakukantindakan").val("");

        $("#dialogVerifikasiPJANonTindakan").dialog("open");
    }

    function verifikasiPJASimpanNonTindakan() {
        $.post('<?php echo $this->createUrl('verifikasiPJANonTindakan'); ?>', $("#formVerifikasiPJANonTindakan").serialize(), function(data) {
            if (data.ok == 1) {
                $("#dialogVerifikasiPJANonTindakan").dialog("close");
                myAlert(data.msg);
            } else {
                myAlert(data.msg);
            }
        }, 'json');
    }

    function batalPJANonTindakan(pendaftaran_id, no_pendaftaran, pasienpulang_id) {
        myConfirm("Anda yakin untuk membatalkan validasi PJA ini ?", no_pendaftaran, function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('batalPJANonTindakan'); ?>', {
                    pendaftaran_id: pendaftaran_id,
                    pasienpulang_id: pasienpulang_id,
                }, function(data) {
                    if (data.ok == 1) {
                        myAlert(data.msg);
                        $.fn.yiiGridView.update('daftarPasien-grid');
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }
</script>