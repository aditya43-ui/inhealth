<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pengirimanrm-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
));
$this->widget('bootstrap.widgets.BootAlert');
?>

<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                            ?></p>-->
<?php echo $form->errorSummary(array($model)); ?>


<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Pegawai</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label("NIP", '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modPeg, 'nomorindukpegawai', array('class' => 'span3', 'readonly' => true)) ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo CHtml::label("Nama Pegawai", '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modPeg, 'nama_pegawai', array('class' => 'span3', 'readonly' => true)) ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo CHtml::label("Jenis Kelamin", '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modPeg, 'jeniskelamin', array('class' => 'span3', 'readonly' => true)) ?>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label("Kelompok Pegawai", '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modPeg, 'kelompokpegawai_nama', array('class' => 'span3', 'readonly' => true)) ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo CHtml::label("Nama Pegawai", '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modPeg, 'nama_pegawai', array('class' => 'span3', 'readonly' => true)) ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo CHtml::label("Jenis Kelamin", '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modPeg, 'jeniskelamin', array('class' => 'span3', 'readonly' => true)) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Jadwal Pegawai</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label("Asal Shift", '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modDet, 'asalshift_nama', array('class' => 'span3', 'readonly' => true)) ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo CHtml::label("Asal Shift Jam Awal", '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modDet, 'asalshift_awal', array('class' => 'span3', 'readonly' => true)) ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo CHtml::label("Asal Shift Jam Akhir", '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modDet, 'asalshift_akhir', array('class' => 'span3', 'readonly' => true)) ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo CHtml::label("Asal Ruangan", '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modDet, 'asalruangan_nama', array('class' => 'span3', 'readonly' => true)) ?>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label("Shift Baru  <span class='required'>*</span>", '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php

                    echo $form->dropDownList($modDet, 'shift_id',  CHtml::listData(ShiftpegawaiM::model()->getShiftPegawai($modPeg->pegawai_id), 'shift_id', 'shiftPegawaiJam'), array('empty' => '-- Pilih --', 'class' => 'span3 required', 'onchange' => 'cekShift(this);'))
                    ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo CHtml::label("Shift Jam Awal <span class='required'>*</span>", '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modDet, 'shift_jamawal', array('class' => 'span3 required', 'readonly' => true)) ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo CHtml::label("Shift Jam Akhir <span class='required'>*</span>", '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modDet, 'shift_jamakhir', array('class' => 'span3 required', 'readonly' => true)) ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo CHtml::label("Instalasi <span class='required'>*</span>", '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo $form->dropDownList(
                        $modDet,
                        'instalasi_id',
                        $dropIns,
                        array(
                            'class' => 'span3 required', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('/ActionDynamic/GetRuanganDariInstalasi', array('encode' => false, 'namaModel' => get_class($model))),
                                'update' => "#" . CHtml::activeId($modDet, 'ruangan_id'),
                            )
                        )
                    );
                    ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo CHtml::label("Ruangan Baru  <span class='required'>*</span>", '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php

                    echo $form->dropDownList($modDet, 'ruangan_id',  $dropRuang, array('empty' => '-- Pilih --', 'class' => 'span3 required'))
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php
    if (!isset($_GET['sukses'])) {
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
        );
    } else {
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('disabled' => true, 'class' => 'btn btn-danger', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)')
        );
    }
    ?>

    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array('class' => 'btn btn-default', 'onclick' => "window.parent.$('#dialogUbahJadwal').dialog('close');")
    ); ?>
</div>
<?php $this->endWidget(); ?>

<script>
    function cekShift(obj) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/actionAjax/cekShift'); ?>',
            data: {
                shift_id: $(obj).find('option:selected').val()
            },
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($modDet, 'shift_jamawal') ?>").val(data.shift_jamawal);
                $("#<?php echo CHtml::activeId($modDet, 'shift_jamakhir') ?>").val(data.shift_jamakhir);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    //$(document).ready(function(){
    //	if ('<?php //echo !empty($status)?$status:'tidakada'; 
                ?>' == true){
    //		setTimeout("window.parent.$('#dialogUbahJadwal').dialog('close');",500);			
    //	}
    //});
</script>