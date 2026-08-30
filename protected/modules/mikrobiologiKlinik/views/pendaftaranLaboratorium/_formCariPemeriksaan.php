<div id="form-caripemeriksaan" class="col-sm-12 form-horizontal" style="margin-bottom: 17px;">
    <?php echo CHtml::hiddenField("form_index", null, array('readonly' => true)); ?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanLab, 'ruangan_id', array('readonly' => true, 'class' => 'span3')); ?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanLab, 'penjamin_id', array('readonly' => true, 'class' => 'span3')); ?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanLab, 'pegawai_id', array('readonly' => true, 'class' => 'span3')); ?>
    <div class="row">
        <div class="control-group" style="float:left;">
            <?php echo CHtml::activeLabel($modPemeriksaanLab, 'jenispemeriksaanlab_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeDropDownList($modPemeriksaanLab, 'jenispemeriksaanlab_nama', CHtml::listData(JenispemeriksaanlabM::model()->findAll(array(
                    'condition' => 'jenispemeriksaanlab_aktif = true',
                    'order' => 'jenispemeriksaanlab_urutan',
                )), 'jenispemeriksaanlab_nama', 'jenispemeriksaanlab_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanLab();", 'placeholder' => 'Nama Jenis Pemeriksaan Lab',)); ?>
            </div>
        </div>
        <div class="control-group" style="float:left;">
            <?php echo CHtml::activeLabel($modPemeriksaanLab, 'kelaspelayanan_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeDropDownList($modPemeriksaanLab, 'kelaspelayanan_id', CHtml::listData(KelaspelayananM::model()->findAll(array(
                    'condition' => 'kelaspelayanan_aktif = true',
                    'order' => 'urutankelas',
                )), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanLab();", 'placeholder' => 'Kelas Pelayanan Pemeriksaan Lab',)); ?>
            </div>
        </div>
        <div class="control-group" style="float:left;">
            <?php echo CHtml::activeLabel($modPemeriksaanLab, 'pemeriksaanlab_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modPemeriksaanLab, 'pemeriksaanlab_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanLab();", 'placeholder' => 'Nama Pemeriksaan Lab',)); ?>
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', "onclick" => "updateChecklistPemeriksaanLab();", 'rel' => 'tooltip', 'title' => 'Klik untuk mencari pemeriksaan')); ?>
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'button', "onclick" => "setChecklistPemeriksaanLabReset();", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang pencarian')); ?>
            </div>
        </div>
    </div>
</div>