<?php
/**
* - digunakan sebagai informasi sampel darah
* @author Aida Rahmawati <aidarahmawati@example.com>
**/
?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'method'=>'get',
    'id'=>'informasisampel-r-search',
    'type'=>'horizontal',
)); 
$format = new MyFormatter();
?>

<div class="row-fluid">
    <div class="col-sm-6">        
        <div class="control-group">		
            <?php echo CHtml::label("Tanggal",'tanggal', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
                
        <?php echo $form->textFieldRow($model,'no_bed_triage',array('placeholder'=>'Ketik nomor bed')) ?>
        <?php echo $form->textFieldRow($model,'no_triage_pasien',array('placeholder'=>'Ketik nomor triage')) ?>
        
    </div>
    <div class="col-sm-6">   
        <?php echo $form->textFieldRow($model,'no_pendaftaran',array('placeholder'=>'Ketik nomor pendaftaran')) ?>
        <?php echo $form->textFieldRow($model,'nama_pasien',array('placeholder'=>'Ketik nomor pendaftaran')) ?>
        <?php echo $form->textFieldRow($model,'no_rekam_medik',array('placeholder'=>'Ketik nomor rekam medik')) ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
        $this->createUrl($this->id.'/indexPribadi'), 
        array('class'=>'btn btn-danger',
            'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>   
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
