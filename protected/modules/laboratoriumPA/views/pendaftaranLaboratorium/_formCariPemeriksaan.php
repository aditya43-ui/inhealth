<div id="form-caripemeriksaan" class="form-horizontal">
    <?php echo CHtml::hiddenField("form_index",null,array('readonly'=>true));?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanLab, 'ruangan_id',array('readonly'=>true,'class'=>'span3')); ?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanLab, 'penjamin_id',array('readonly'=>true,'class'=>'span3')); ?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanLab, 'kelaspelayanan_id',array('readonly'=>true,'class'=>'span3')); ?>
    <div class="row-fluid">
        <div class="control-group" style="float:left;">
            <?php echo CHtml::activeLabel($modPemeriksaanLab, 'jenispemeriksaanlab_id',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeDropDownList($modPemeriksaanLab, 'jenispemeriksaanlab_nama', CHtml::listData(JenispemeriksaanlabM::model()->findAll(array(
                    'condition'=>"jenispemeriksaanlab_aktif = true and jenispemeriksaanlab_kelompok ='PATOLOGI ANATOMI'",
                    'order'=>'jenispemeriksaanlab_urutan',
                )), 'jenispemeriksaanlab_nama', 'jenispemeriksaanlab_nama') ,array('empty'=>'-- Pilih --','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)","onchange"=>"updateChecklistPemeriksaanLab();",'placeholder'=>'Ketik Nama Jenis Pemeriksaan Lab',)); ?>
            </div>
        </div>
        <div class="control-group" style="float:left;">
            <?php echo CHtml::activeLabel($modPemeriksaanLab, 'pemeriksaanlab_id',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modPemeriksaanLab, 'pemeriksaanlab_nama',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)","onchange"=>"updateChecklistPemeriksaanLab();",'placeholder'=>'Ketik Nama Pemeriksaan Lab',)); ?>
            </div>
        </div>
        <div style="float:right;">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button',"onclick"=>"updateChecklistPemeriksaanLab();", 'rel'=>'tooltip', 'title'=>'Klik untuk mencari pemeriksaan')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'button', "onclick"=>"setChecklistPemeriksaanLabReset();", 'rel'=>'tooltip', 'title'=>'Klik untuk mengulang pencarian')); ?>
        </div>
    </div>
</div>