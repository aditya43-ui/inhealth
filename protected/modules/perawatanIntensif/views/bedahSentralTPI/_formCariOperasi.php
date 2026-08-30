<div id="form-carioperasi" class="form-horizontal">
    <div class="row">
        <div class="control-group" style="float:left;">
            <?php echo CHtml::label('Kelompok Operasi', '',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($kegiatanOperasiSearch, 'kegiatanoperasi_nama',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)","onchange"=>"updateChecklistOperasi();",)); ?>
            </div>
        </div>
        <div class="control-group" style="float:left;">
            <?php echo CHtml::label('Tindakan Operasi', '',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($operasiSearch, 'operasi_nama',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)","onchange"=>"updateChecklistOperasi();",)); ?>
            </div>
        </div>
        <div style="float:right; margin-right: 20px;">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="entypo-search"></i>')),array('class' => 'btn btn-danger', 'type'=>'button',"onclick"=>"updateChecklistOperasi();", 'rel'=>'tooltip', 'title'=>'Klik untuk mencari tindakan operasi')); ?> &nbsp; 
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class' => 'btn btn-default', 'type'=>'button', "onclick"=>"setChecklistOperasiReset();", 'rel'=>'tooltip', 'title'=>'Klik untuk mengulang tindakan operasi')); ?>
        </div>
    </div>
</div>