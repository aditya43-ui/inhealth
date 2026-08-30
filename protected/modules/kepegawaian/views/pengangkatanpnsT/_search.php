<fieldset class="box">
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'kppengangkatanpns-t-search',
    'type'=>'horizontal',
    'focus'=>'#'.CHtml::activeId($model,'nomorindukpegawai'),
)); ?>
<?php //echo $form->checkBoxRow($model,'pengangkatanpns_id'); ?>
    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->textFieldRow($model,'nomorindukpegawai',array('class'=>'span3')); ?>
            <?php echo $form->textFieldRow($model,'nama_pegawai',array('class'=>'span3')); ?>

        </div>
        <div class="col-sm-6">
            <?php echo $form->dropDownListRow($model,'jabatan', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 
            'jabatan_id', 'jabatan_nama'), array('empty'=>'-- Pilih --','style'=>'width:130px')); ?>
        </div>
    </div>

    <div class="form-actions">
        <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>            
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
            $this->createUrl('informasi'), 
            array('class' => 'btn btn-default',
            'onclick'=>'return refreshForm(this);')); ?>
        <?php
            $content = $this->renderPartial('../tips/informasi',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </div>
</fieldset>
<?php $this->endWidget(); ?>
