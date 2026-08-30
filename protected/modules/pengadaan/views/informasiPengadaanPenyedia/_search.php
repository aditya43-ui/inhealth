<?php
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'persiapanpengadaan-m-search',
    'type'=>'horizontal',
)); 
$format = new MyFormatter();
?>

<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">		
            <?php echo CHtml::label("Tanggal Diumumkan", 'periode', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Nomor Pekerjaan",'rencanaumumpengadaan_nomor', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'rencanaumumpengadaan_nomor',array('placeholder'=>'Ketik Nomor Pekerjaan')) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class = "control-group">
            <?php echo Chtml::label("Nama Pekerjaan",'nama_pekerjaan', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'nama_pekerjaan',array('placeholder'=>'Ketik Nama Pekerjaan')) ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
        $this->createUrl($this->id.'/index'), 
        array('class'=>'btn btn-danger',
            'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')). "&nbsp&nbsp";    
    ?>
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
