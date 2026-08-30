<div id="form-caripemeriksaan" class="form-horizontal">
    <?php echo CHtml::activeHiddenField($modPemeriksaanRm, 'ruangan_id', array('readonly' => true, 'class' => 'span3')); ?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanRm, 'penjamin_id', array('readonly' => true, 'class' => 'span3')); ?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanRm, 'kelaspelayanan_id', array('readonly' => true, 'class' => 'span3')); ?>
    <div class="row">
        <div class="control-group" style="float:left;">
            <?php echo CHtml::activeLabel($modPemeriksaanRm, 'jenistindakanrm_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modPemeriksaanRm, 'jenistindakanrm_nama', array('placeholder' => 'Jenis Tindakan', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanRehab();",)); ?>
            </div>
        </div>
        <div class="control-group" style="float:left;">
            <?php echo CHtml::label('Tindakan Rehab Medik', 'tindakanrm_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modPemeriksaanRm, 'tindakanrm_nama', array('placeholder' => 'Tindakan Rehab Medik', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanRehab();",)); ?>
            </div>
        </div>
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'button', "onclick" => "updateChecklistPemeriksaanRehab();", 'rel' => 'tooltip', 'title' => 'Klik untuk mencari pemeriksaan')
        ); ?>
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'button', "onclick" => "setChecklistPemeriksaanRehabReset();", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang pemeriksaan')
        ); ?>
    </div>
</div>