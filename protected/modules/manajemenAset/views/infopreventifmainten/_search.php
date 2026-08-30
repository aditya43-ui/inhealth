<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'preventifmaintenance-r-search',
    'type' => 'horizontal',
    //    'focus'=>'#'.CHtml::activeId($model,'nama_pegawai'),
)); ?>

    <div class="col-sm-6">
        <div class="control-group">		
            <?php echo CHtml::label("Tanggal Pemeliharaan",'tglprevmainten', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                <i class="entypo-calendar"></i>
                <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Nama Aset",'', array('class' => 'control-label')) ?>
            <div class="controls">
             <?php echo $form->TextField($model, 'invperalatan_namabrg', array('class'=>'span3', 'placeholder'=>'Ketik Nama Aset')); ?>

            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("No Aset",'', array('class' => 'control-label')) ?>
            <div class="controls">
             <?php echo $form->TextField($model, 'invperalatan_kode', array('class'=>'span3', 'placeholder'=>'Ketik no aset')); ?>

            </div>
        </div>
    </div>

<div class="clear"></div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('InfoPreventifMainten/Index'), array('class'=>'btn btn-default')); ?>

</div>
<?php $this->endWidget(); ?>