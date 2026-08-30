
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'gradinginsidenrs-t-search',
    'type' => 'horizontal',
        ));
?>
<style>
    .listtanggal{
        float: left;
        width: 125px;
    }
    .listtanggal1{
        padding-left:2px;
        font-size:11.5px;
        float: left;
        font-weight: normal;
        line-height:18px;
    }
</style>
<div class="col-sm-6">
    <div class="control-group">	
        <?php echo $form->checkBox($model, 'tipeLapor', array('class' => 'listtanggal', 'rel' => 'tooltip', 'title' => 'Klik/centang untuk filter dengan periode')); ?>
        <?php echo CHtml::label("Tanggal Pelaporan &nbsp;&nbsp;", 'insidenrs_tgllapor', array('class' => 'listtanggal1 ')) ?>
        <div class="controls">
            <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tanggal_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tanggal_akhir)) ?>">
                <i class="entypo-calendar"></i>
                <span ><?php echo date('F d, Y', strtotime($model->tanggal_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tanggal_akhir)) ?></span>
                <?php echo $form->hiddenField($model, 'tanggal_awal', array('class' => 'start')) ?>
                <?php echo $form->hiddenField($model, 'tanggal_akhir', array('class' => 'end')) ?>
            </div>
        </div>
    </div>
    <div class="control-group">	
        <?php echo $form->checkBox($model, 'tipeInsiden', array('class' => 'listtanggal', 'rel' => 'tooltip', 'title' => 'Klik/centang untuk filter dengan periode')); ?>
        <?php echo CHtml::label("Tanggal Insiden &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", 'insidenrs_tglinsiden', array('class' => 'listtanggal1')); ?>
        <div class="controls">
            <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tanggal_awal2)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tanggal_akhir2)) ?>">
                <i class="entypo-calendar"></i>
                <span ><?php echo date('F d, Y', strtotime($model->tanggal_awal2)) ?> - <?php echo date('F d, Y', strtotime($model->tanggal_akhir2)) ?></span>
                <?php echo $form->hiddenField($model, 'tanggal_awal2', array('class' => 'start')) ?>
                <?php echo $form->hiddenField($model, 'tanggal_akhir2', array('class' => 'end')) ?>
            </div>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Instalasi / Ruangan', 'penelitian_nomor', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll(), 'instalasi_id', 'instalasi_nama'), array('class' => 'span2', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                'ajax' => array('type' => 'POST',
                    'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($model))),
                    'update' => "#" . CHtml::activeId($model, 'ruangan_id'),
            )));
            ?>
        </div>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'ruangan_id', CHtml::listData(RuanganM::model()->findAll(), 'ruangan_id', 'ruangan_nama'), array('class' => 'span2', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('No. Rekam Medis', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'no_rekammedik', array('placeholder' => 'Ketik No. Rekam Medis', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        </div>
    </div>
</div>    
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('Jenis Insiden', 'insidenrs_jenis', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'insidenrs_jenis', LookupM::getItems('jenisinsiden'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Lokasi Kejadian', 'lokasikejadian_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'lokasikejadian_id', Chtml::listData(RuanganM::model()->findAllByAttributes(array('ruangan_aktif' => true)), 'ruangan_id', 'ruangan_nama'), array('class' => 'span4', 'empty' => '-- Pilih --')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Grading', 'gradingrisiko', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'gradingrisiko', Chtml::listData(GradingrisikoM::model()->findAllByAttributes(array('gradingrisiko_aktif' => true)), 'tingkatrisiko.tingkatrisiko_warna', 'tingkatrisiko.tingkatrisiko_warna'), array('class' => 'span4', 'empty' => '-- Pilih --')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Status', 'status_laporan', array('class' => 'control-label')) ?>
        <div class="controls"> 
            <?php echo $form->dropDownList($model, 'status_laporan', array('Kirim Laporan' => 'Kirim Laporan', 'Menunggu Persetujuan' => "Menunggu Persetujuan", 'Laporan Disetujui' => "Laporan Disetujui"), array('class' => 'span4', 'empty' => '-- Pilih --')); ?>
        </div>
    </div>
</div>
<div class="clear"></div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')) . "&nbsp"; ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('informasiLaporanInsiden/index'), array('class' => 'btn btn-danger')) . "&nbsp"; ?>

    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp"; ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp"; ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp"; ?>
    <?php
    $modPetunjuk = PetunjuktransaksiM::model()->findAllByAttributes(array('petunjuktransaksi_type' => 'Informasi Pelaporan Insiden Pasien', 'petunjuktransaksi_aktif' => true), array('order' => 'petunjuktransaksi_urutan asc'));
    $content = $this->renderPartial('yankesMasyarakat.views.tips.petunjukGrading', array('modPetunjuk' => $modPetunjuk), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>