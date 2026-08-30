<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'manpower-search',
    'type'=>'horizontal',
    'focus'=>'#'.CHtml::activeId($model,'nama_pegawai'),
)); 
$format = new MyFormatter();
?>

<?php //echo $form->textFieldRow($model,'pelamar_id',array('class'=>'span5')); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">		
            <?php echo CHtml::label("Tgl. Rencana",'dari_tanggal', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                // var_dump($model->attributes); die;
                $model->bln_periode = MyFormatter::formatMonthForUser($model->bln_periode);
                $this->widget('MyMonthPicker', array(
                    'model' => $model,
                    'attribute' => 'bln_periode',
                    'options' => array(
                        'dateFormat' => Params::MONTH_FORMAT,
                        'yearRange' => "-100y:+0y",
                    ),
                    'htmlOptions' => array('readonly' => true,
                        'class' => "span2 bln_periode",
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                    ),
                )); 
                ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
        $this->createUrl($this->id.'/index'), 
        array('class' => 'btn btn-default',
            'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
    <?php
        $tips = array(
            '0' => 'tanggal',
            '1' => 'cari',
            '2' => 'ulang'
        );
        $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>

<?php $this->endWidget(); ?>
