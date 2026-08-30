<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'penerimaandarah-r-search',
    'type'=>'horizontal',
)); 
$format = new MyFormatter();
?>
<div class="row">
    <div class="col-sm-6">
        <div class="row">
            <div class="control-group">
                <?php echo CHtml::label("Tgl. Distribusi Darah",'tgl_distribusi', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span ><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
        </div>    
        <div class="row">
            <div class="control-group">
                <?php echo Chtml::label("Nomor Pengiriman",'nomor_pengiriman', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model,'nomor_pengiriman',array('placeholder'=>'Nomor Pengiriman')) ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="control-group">
                <?php echo Chtml::label("Shift Distribusi",'shift_distribusi', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model,'shift_distribusi',array('placeholder'=>'Shift')) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="row">
            <div class="control-group">
                <?php echo Chtml::label("Petugas Distribusi Pelayanan Donor",'nama_pegawai', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model,'nama_pegawai',array('placeholder'=>'Nama Petugas')) ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="control-group">
                <?php echo Chtml::label("Status",'status', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'status', array('Sudah'=>'Sudah Diterima', 'Belum'=>'Belum Diterima'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
                </div>
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
