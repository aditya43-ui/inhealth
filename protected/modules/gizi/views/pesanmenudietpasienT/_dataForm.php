<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary($model); ?>
<div class="row-fluid">
    <div class="col-sm-6">
    <?php echo CHtml::hiddenField('menu_dipesan'); ?>
        <?php echo $form->hiddenField($model, 'nopesanmenu', array('readonly' => TRUE, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <div class = "control-group">
            <?php echo Chtml::label("No Pesan Menu <font style = 'color:red;'>*</font>", 'nopesanmenu', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model, 'temp_no', array('readonly' => TRUE, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'tglpesanmenu', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglpesanmenu',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3 ' . (!empty($model->pesanmenudiet_id) ? '' : ''), 'onkeypress' => "return $(this).focusNextInputField(event)",),
                ));
                ?>
                <?php echo $form->error($model, 'tglpesanmenu'); ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Pegawai Pemesan <font style='color:red'>*</font>", 'nama_pemesan', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model, 'nama_pemesan', array('readonly' => TRUE, 'placeholder' => 'Ketik Nama Pemesan', 'class' => 'span3 hurufs-only required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo CHtml::label('Instalasi', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'instalasi_id', CHtml::listData($model->getInstalasiItems(), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,
                    'ajax' => array('type' => 'POST',
                        'url' => $this->createUrl('setDropdownRuangan', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                        'update' => '#' . CHtml::activeId($model, 'ruangan_id') . ''),));
                ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Ruangan', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'ruangan_id', CHtml::listData($model->getRuanganItems($model->instalasi_id), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'onchange' => 'clearAll()')); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('No. Pendaftaran', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'no_pendaftaran', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'onchange' => 'clearAll()')); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('No. Rekam Medik', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'no_rekam_medik', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 8, 'onchange' => 'clearAll()')); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Nama pasien', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nama_pasien', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'clearAll()')); ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'cariPasien();')); ?>
</div>
<?php echo CHtml::css('input[type="checkbox"].span2{width:13px;}'); ?>

<script type="text/javascript">
    $(document).ready(function () {

        // Notifikasi Pasien


    });

    function setKelasKunjungan(id) {
        $("#GZInfokunjunganriV_kelaspelayanan_id").val(id);

        //clearPilihPasien();
        //$.fn.yiiGridView.update("gzinfokunjunganri-v-grid", {data: $("#dialogPasien :input").serialize()});
    }
</script>