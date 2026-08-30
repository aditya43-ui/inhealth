<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'pelamar-t-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'nama_pelamar'),
));
$format = new MyFormatter();
?>
<?php //echo $form->textFieldRow($model,'pelamar_id',array('class'=>'span5')); 
?>
<div class="row">
    <div class="col-sm-12">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Melamar", 'dari_tanggal', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-min-date="<?php echo date('d M Y', strtotime('-3 months + 1 day')); ?>" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Nama Pelamar', 'nama_pelamar', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->textField($model, 'nama_pelamar', array('placeholder' => 'Nama Pelamar', 'class' => 'span4 hurufs-only'));
                /*$this->widget('MyJuiAutoComplete',array(
                    'model'=>$model,
                    'attribute'=>'nama_pelamar',
                    'sourceUrl'=>  Yii::app()->createUrl('kepegawaian/ActionAutoCompleteKP/NamaPelamar'),
                    'options'=>array(
                        'showAnim'=>'fold',
                        'minLength'=>2,
                        'select'=>'js:function( event, ui ) {
                                $("#HRDPelamarT_nama_pelamar").val(ui.item.nama_pelamar);
                                    }',
                    ),
//                                'tombolDialog'=>array('idDialog'=>'dialogPegawaiYangMengajukan'),
                    'htmlOptions'=>array('class'=>'span2','style'=>'float:left;')
                ));*/
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Jenis Kelamin', 'jeniskelamin', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('class' => 'span4', 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Status Perkawinan', 'statusperkawinan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'statusperkawinan', LookupM::getItems('statusperkawinan'), array('class' => 'span4', 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Jenis Tenaga Kerja', 'minatpekerjaan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php // echo $form->textField($model, 'minatpekerjaan',array('class'=>'hurufs-only span4')); 
                ?>
                <?php echo $form->dropDownList($model, 'minatpekerjaan',  CHtml::listData($model->MinatPekerjaan, 'lookup_name', 'lookup_name'), array('class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event)", 'empty' => ' -- Pilih Minat -- ')); ?>
            </div>
        </div>
        <?php echo $form->dropDownListRow($model, 'pendidikan_id', CHtml::listData($model->PendidikanItems, 'pendidikan_id', 'pendidikan_nama'), array('class' => 'span4', 'empty' => '-- Pilih --')); ?>
        <div class="control-group">
            <?php echo CHtml::label('Semua Pelamar', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'semuapelamar', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('pelamarT/admin'),
        array(
            'title' => 'Ulang', 'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/informasi_pelamar', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>