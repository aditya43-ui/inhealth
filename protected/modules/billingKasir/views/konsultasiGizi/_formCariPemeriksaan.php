<div id="form-caripemeriksaan" class="form-horizontal">
    <?php echo CHtml::activeHiddenField($modPemeriksaanKonsultasiGizi, 'ruangan_id', array('readonly' => true, 'class' => 'span3')); ?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanKonsultasiGizi, 'penjamin_id', array('readonly' => true, 'class' => 'span3')); ?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanKonsultasiGizi, 'kelaspelayanan_id', array('readonly' => true, 'class' => 'span3')); ?>
    <?php echo CHtml::HiddenField('ispilihtindakan'); ?>

    <div class="control-group" style="float:left;">
        <?php echo CHtml::activeLabel($modPemeriksaanKonsultasiGizi, 'kategoritindakan_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modPemeriksaanKonsultasiGizi, 'kategoritindakan_nama', array('placeholder' => 'Kategori Tindakan', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanKonsultasiGizi();",)); ?>
        </div>
    </div>
    <div class="control-group" style="float:left;">
        <?php echo CHtml::activeLabel($modPemeriksaanKonsultasiGizi, 'daftartindakan_id', array('placeholder' => 'Daftar Tindakan', 'class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modPemeriksaanKonsultasiGizi, 'daftartindakan_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanKonsultasiGizi();",)); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', "onclick" => "updateChecklistPemeriksaanKonsultasiGizi();", 'rel' => 'tooltip', 'title' => 'Klik untuk mencari pemeriksaan')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'button', "onclick" => "setChecklistPemeriksaanKonsultasiGiziReset();", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang pemeriksaan')); ?>
        </div>
    </div>
</div>