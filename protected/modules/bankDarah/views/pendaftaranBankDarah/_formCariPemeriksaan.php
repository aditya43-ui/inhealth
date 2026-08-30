<div id="form-caripemeriksaan" class="form-horizontal">
    <?php echo CHtml::hiddenField("form_index", null, array('readonly' => true)); ?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanLab, 'ruangan_id', array('readonly' => true, 'class' => 'span3')); ?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanLab, 'penjamin_id', array('readonly' => true, 'class' => 'span3')); ?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanLab, 'kelaspelayanan_id', array('readonly' => true, 'class' => 'span3')); ?>
    <div class="row">
        <div class="control-group" style="float:left;">
            <?php echo CHtml::Label('Jenis Pemeriksaan', 'jenispemeriksaanlab_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modPemeriksaanLab, 'jenispemeriksaanlab_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanLab();", 'placeholder' => 'Nama Jenis Pemeriksaan Bank Darah',)); ?>
            </div>
        </div>
        <div class="control-group" style="float:left;">
            <?php echo CHtml::Label('Pemeriksaan', 'pemeriksaanlab_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modPemeriksaanLab, 'pemeriksaanlab_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanLab();", 'placeholder' => 'Nama Pemeriksaan Bank Darah',)); ?>
            </div>
        </div>
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', "onclick" => "updateChecklistPemeriksaanLab();", 'rel' => 'tooltip', 'title' => 'Klik untuk mencari pemeriksaan')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'button', "onclick" => "setChecklistPemeriksaanLabReset();", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang pencarian')); ?>
    </div>
</div>