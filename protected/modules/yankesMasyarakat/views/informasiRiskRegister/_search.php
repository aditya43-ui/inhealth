<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'riskregister-m-search',
    'type'=>'horizontal',
)); ?>

    <div class="col-sm-6">
        <div class="control-group">		
            <?php echo CHtml::label("Tanggal Mulai",'tgl_penilaian', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class="control-group">		
            <?php echo CHtml::label("Batas Waktu",'tgl_penilaian', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal2)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir2)) ?>">
                    <i class="entypo-calendar"></i>
                    <span ><?php echo date('F d, Y', strtotime($model->tgl_awal2)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir2)) ?></span>
                    <?php echo $form->hiddenField($model,'tgl_awal2', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model,'tgl_akhir2', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Sumber","",array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'sumber_riskregister', LookupM::getItems('sumber_riskregister'), array('empty'=>'--Pilih--','class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Tipe Risiko","",array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model,'tiperesiko_id',Chtml::listData(TiperesikoM::model()->findAllByAttributes(array('tiperesiko_aktif'=>true)),'tiperesiko_id','tiperesiko_nama'),array('class'=>'span3','empty'=>'-- Pilih --')); ?>
            </div>
        </div>
    </div>    
    
    <div class="col-sm-6"> 
        <div class="control-group">
            <?php echo CHtml::label("Penanggung Jawab","",array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model,'penanggungjawab',array('class'=>'span3',)); ?>
            </div>
        </div> 
        <div class="control-group">
            <?php echo CHtml::label("Status","",array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'status_riskregister', LookupM::getItems('status_riskregister'), array('empty'=>'--Pilih--','class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
<div class="clear"></div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit'))."&nbsp"; ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('informasiRiskRegister/index'), array('class'=>'btn btn-danger'))."&nbsp"; ?>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp"; ?>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp"; ?>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cetak',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp"; ?>
    <?php
        $modPetunjuk = PetunjuktransaksiM::model()->findAllByAttributes(array('petunjuktransaksi_type' => 'Informasi Risk Register', 'petunjuktransaksi_aktif' => true), array('order' => 'petunjuktransaksi_urutan asc'));
        $content = $this->renderPartial('yankesMasyarakat.views.tips.petunjukGrading', array('modPetunjuk' => $modPetunjuk), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); 
    ?>
</div>

<?php $this->endWidget(); ?>
