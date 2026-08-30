<div id="form-caripemeriksaan" class="form-horizontal">
    <?php echo CHtml::hiddenField("form_index",null,array('readonly'=>true));?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanLab, 'ruangan_id',array('readonly'=>true,'class'=>'span3')); ?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanLab, 'penjamin_id',array('readonly'=>true,'class'=>'span3')); ?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanLab, 'kelaspelayanan_id',array('readonly'=>true,'class'=>'span3')); ?>
    <div class="row-fluid">
        <div class="control-group" style="float:left;">
            <?php echo CHtml::label('Jenis Pemeriksaan', 'jenispemeriksaanlab_id',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modPemeriksaanLab, 'jenispemeriksaanlab_nama',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)","onchange"=>"updateChecklistPemeriksaan();",'placeholder'=>'Ketik Nama Jenis Pemeriksaan',)); ?>
            </div>
        </div>
        <div class="control-group" style="float:left;">
            <?php echo CHtml::label('Pemeriksaan', 'pemeriksaanlab_id',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modPemeriksaanLab, 'pemeriksaanlab_nama',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)","onchange"=>"updateChecklistPemeriksaan();",'placeholder'=>'Ketik Nama Pemeriksaan',)); ?>
            </div>
        </div>
        <div style="float:right;">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button',"onclick"=>"updateChecklistPemeriksaanLab();", 'rel'=>'tooltip', 'title'=>'Klik untuk mencari pemeriksaan')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'button', "onclick"=>"setChecklistPemeriksaanLabReset();", 'rel'=>'tooltip', 'title'=>'Klik untuk mengulang pencarian')); ?>
        </div>
    </div>
</div>