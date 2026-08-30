<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'informasiae-r-search',
    'type' => 'horizontal',
        ));
?>
<style>
    .listtanggal{
        float: left;
    }
     .listtanggal1{
        padding-left:2px;
        font-size:11.5px;
        float: left;
        font-weight: normal;
        line-height:18px;
        width: 110px;
    }
</style>
<div class="col-md-6">
    <div class="control-group">	
        <?php  echo $form->checkBox($model, 'tipeLapor', array('class' => 'listtanggal','checked' => 'tipeLapor', 'rel' => 'tooltip', 'title' => 'Klik/centang untuk filter dengan periode')); ?>
        <?php echo CHtml::label("Tanggal Pelaporan",'tanggal_akhir_sk', array('class' => 'listtanggal1')); ?>
        <div class="controls">
            <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tglawallapor)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tglakhirlapor)) ?>">
                <i class="entypo-calendar"></i>
                <span ><?php echo date('F d, Y', strtotime($model->tglawallapor)) ?> - <?php echo date('F d, Y', strtotime($model->tglakhirlapor)) ?></span>
                <?php echo $form->hiddenField($model,'tglawallapor', array('class' => 'start')) ?>
                <?php echo $form->hiddenField($model,'tglakhirlapor', array('class' => 'end')) ?>
            </div>
        </div>
    </div>
    <div class="control-group">	
        <?php  echo $form->checkBox($model, 'tipeInsiden', array('class' => 'listtanggal','rel' => 'tooltip', 'title' => 'Klik/centang untuk filter dengan periode')); ?>
        <?php echo CHtml::label("Tanggal Insiden",'tanggal_akhir_sk', array('class' => 'listtanggal1')); ?>
        <div class="controls">
            <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tglawalinsiden)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tglakhirinsiden)) ?>">
                <i class="entypo-calendar"></i>
                <span ><?php echo date('F d, Y', strtotime($model->tglawalinsiden)) ?> - <?php echo date('F d, Y', strtotime($model->tglakhirinsiden)) ?></span>
                <?php echo $form->hiddenField($model,'tglawalinsiden', array('class' => 'start')) ?>
                <?php echo $form->hiddenField($model,'tglakhirinsiden', array('class' => 'end')) ?>
            </div>
        </div>
    </div>
    <div class = "control-group">
        <?php echo Chtml::label("Nomor Rekam Medis", '', array('class' => 'control-label')) ?>
        <div class = "controls">
            <?php echo $form->textField($model, 'no_rekam_medik', array('placeholder' => 'Nomor Rekam Medis')) ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Jenis Insiden', 'insidenrs_jenis', array('class' => 'control-label required')) ?>
        <div class="controls"> 
            <?php
            echo $form->dropDownList($model, 'insidenrs_jenis', LookupM::getItems('jenisinsiden'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                'class' => 'span3 required'));
            ?>
        </div>
    </div>


</div>
<div class="col-md-6">
    <div class="control-group">
            <?php echo CHtml::label('Tingkat Risiko', 'tingkatrisiko_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo $form->dropDownList($model, 'tingkatrisiko_id', Chtml::listData(TingkatrisikoM::model()->findAllByAttributes(array('tingkatrisiko_aktif' => true)), 'tingkatrisiko_id', 'tingkatrisiko_nama'), array(
                'empty' => '-- Pilih --',
                'class' => 'span3',
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
            <?php echo CHtml::label('Regrading Risiko Kejadian', 'gradingrisiko', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'regradingrisiko', CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type' => 'tingkatwarna_risiko')), 'lookup_value', 'lookup_name'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
        </div>
    </div>
    <div class = "control-group">
        <?php echo Chtml::label("Status Laporan",'statuslaporan', array('class'=>'control-label')) ?>
        <div class = "controls">
            <?php echo $form->dropDownList($model,'statuslaporan', 
                    array(
                            'Kirim Laporan'=>'Kirim Laporan', 
                            'Menunggu Persetujuan'=>'Menunggu Persetujuan',
                            'Disetujui' => 'Disetujui',
                            'Ditolak' => 'Ditolak' 
                        ),
                    array('empty'=>'-- Pilih --', 'class' => 'span3')) ?>
        </div>
    </div>
</div>
<div class="clear"></div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('InformasiLaporanInsidenRS/index'), array('class'=>'btn btn-danger')); ?>
    <?php
        $modPetunjuk = PetunjuktransaksiM::model()->findAllByAttributes(array('petunjuktransaksi_type' => 'Informasi Pelaporan Insiden Pasien', 'petunjuktransaksi_aktif' => true), array('order' => 'petunjuktransaksi_urutan asc'));
        $content = $this->renderPartial('yankesMasyarakat.views.tips.petunjukGrading', array('modPetunjuk' => $modPetunjuk), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); 
    ?>
</div>

<?php
$this->endWidget();
?>