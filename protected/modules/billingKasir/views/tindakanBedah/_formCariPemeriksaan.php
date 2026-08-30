<div id="form-caripemeriksaan" class="form-horizontal">
    <?php echo CHtml::activeHiddenField($modPemeriksaanBedahSentral, 'ruangan_id', array('readonly' => true, 'class' => 'span3')); ?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanBedahSentral, 'penjamin_id', array('readonly' => true, 'class' => 'span3')); ?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanBedahSentral, 'kelaspelayanan_id', array('readonly' => true, 'class' => 'span3')); ?>
    <?php echo CHtml::HiddenField('ispilihtindakan'); ?>

    <div class="control-group" style="float:left;">
        <?php echo CHtml::activeLabel($modPemeriksaanBedahSentral, 'kegiatanoperasi_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modPemeriksaanBedahSentral, 'kegiatanoperasi_nama', array('placeholder' => 'Nama Kegiatan Operasi', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanBedahSentral();",)); ?>
        </div>
    </div>
    <div class="control-group" style="float:left;">
        <?php echo CHtml::activeLabel($modPemeriksaanBedahSentral, 'operasi_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modPemeriksaanBedahSentral, 'operasi_nama', array('placeholder' => 'Nama Operasi', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanBedahSentral();",)); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', "onclick" => "updateChecklistPemeriksaanBedahSentral();", 'rel' => 'tooltip', 'title' => 'Klik untuk mencari pemeriksaan')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'button', "onclick" => "setChecklistPemeriksaanBedahSentralReset();", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang pemeriksaan')); ?>
        </div>
    </div>
</div>