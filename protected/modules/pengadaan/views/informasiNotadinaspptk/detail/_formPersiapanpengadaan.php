<div class="col-md-12">
    <div class="control-group">
        <?php echo CHtml::label("Kategori Pengadaan <span class='required'>*</span>", "", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
                echo $form->textField($model, 'kategori_pengadaan', array('class' => 'span3', 'readonly' => true));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Nomor Referensi <span class='required'>*</span>", "", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            echo $form->hiddenField($model, 'persiapanpengadaan_id', array('class' => 'span3 persiapan_id', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
            echo $form->textField($model, 'persiapanpengadaan_nomor', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
            ?>
        </div>
    </div>
    <?php if (!empty($model->perintahpengiriman_id)) { ?>
    <div class="control-group" id="field-perintah-pengiriman">
        <label class="control-label"> Perintah Pengiriman </label>
        <div class="controls">
            <?php echo $form->hiddenField($model, 'perintahpengiriman_id', array('class' => 'span3', 'readonly' => true)); ?>
            <?php 
                $modPerintah = PerintahpengirimanT::model()->findByPk($model->perintahpengiriman_id);
                $nomor = "Termin ".$modPerintah->terminke." (".$modPerintah->termin_persen."%) - ".$modPerintah->perintahpengiriman_nomor;
                echo CHtml::textField('perintahpengiriman_nomor', $nomor, array('class' => 'span3', 'readonly' => true))?>
        </div>
    </div>
    <?php } ?>
    <div class="control-group">
        <?php echo CHtml::label("Tahun Anggaran", "", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'tahunanggaran', array('class' => 'span3', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Program", "", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'programkerja_nama', array('class' => 'span6', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Kegiatan", "", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'kegiatanprogram_nama', array('class' => 'span6', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Sub Kegiatan", "", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'subkegiatanprogram_nama', array('class' => 'span6', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Paket Pekerjaan", "", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'paket_pekerjaan', array('class' => 'span6', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Kode Rekening", "", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'koderekening', array('class' => 'span6', 'readonly' => true)); ?>
        </div>
    </div>
</div>