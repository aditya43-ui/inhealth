<div id="form-caripemeriksaan" class="form-horizontal">
    <?php echo CHtml::activeHiddenField($modPemeriksaanBedah, 'ruangan_id', array('readonly' => true, 'class' => 'span3')); ?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanBedah, 'penjamin_id', array('readonly' => true, 'class' => 'span3')); ?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanBedah, 'kelaspelayanan_id', array('readonly' => true, 'class' => 'span3')); ?>
    <div class="row">
        <div class="col-sm-4">
            <div class="control-group" style="float:left;">
                <?php echo CHtml::activeLabel($modPemeriksaanBedah, 'kegiatanoperasi_nama', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::activeTextField($modPemeriksaanBedah, 'kegiatanoperasi_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanBedah();",)); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="control-group" style="float:left;">
                <?php echo CHtml::activeLabel($modPemeriksaanBedah, 'operasi_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::activeTextField($modPemeriksaanBedah, 'operasi_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanBedah();",)); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', "onclick" => "updateChecklistPemeriksaanBedah();", 'rel' => 'tooltip', 'title' => 'Klik untuk mencari operasi')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'button', "onclick" => "setChecklistPemeriksaanBedahReset();", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang operasi')); ?>
        </div>
    </div>
</div>