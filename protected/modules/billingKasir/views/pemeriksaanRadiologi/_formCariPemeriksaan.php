<div id="form-caripemeriksaan" class="form-horizontal">
    <?php echo CHtml::activeHiddenField($modPemeriksaanRad, 'ruangan_id', array('readonly' => true, 'class' => 'span3')); ?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanRad, 'penjamin_id', array('readonly' => true, 'class' => 'span3')); ?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanRad, 'kelaspelayanan_id', array('readonly' => true, 'class' => 'span3')); ?>

    <div class="control-group" style="float:left;">
        <?php echo CHtml::activeLabel($modPemeriksaanRad, 'jenispemeriksaanrad_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeDropDownList($modPemeriksaanRad, 'jenispemeriksaanrad_nama', CHtml::listData(JenispemeriksaanradM::model()->findAll(array(
                'condition' => 'jenispemeriksaanrad_aktif = true',
                'order' => 'jenispemeriksaanrad_urutan',
            )), 'jenispemeriksaanrad_nama', 'jenispemeriksaanrad_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanRad();", 'placeholder' => 'Nama Jenis Pemeriksaan Radiologi',)); ?>
        </div>
    </div>
    <div class="control-group" style="float:left;">
        <?php echo CHtml::activeLabel($modPemeriksaanRad, 'pemeriksaanrad_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modPemeriksaanRad, 'pemeriksaanrad_nama', array('placeholder' => 'Pemeriksaan', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanRad();",)); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', "onclick" => "updateChecklistPemeriksaanRad();", 'rel' => 'tooltip', 'title' => 'Klik untuk mencari pemeriksaan')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'button', "onclick" => "setChecklistPemeriksaanRadReset();", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang pemeriksaan')); ?>
        </div>
    </div>
</div>