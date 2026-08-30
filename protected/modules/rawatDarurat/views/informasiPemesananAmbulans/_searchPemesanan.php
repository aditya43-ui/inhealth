<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'enableAjaxValidation' => false,
    'method' => 'get',
    'id' => 'pesanambulans-t-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($modPemesanan, 'pesanambulans_no'),
)); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Pemesanan", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($modPemesanan->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($modPemesanan->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($modPemesanan->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($modPemesanan->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($modPemesanan, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($modPemesanan, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label for="namaPasien" class="control-label">No. Pesan Ambulans</label>
            <div class="controls">
                <?php echo $form->textField($modPemesanan, 'pesanambulans_no', array('placeholder' => 'No. Pesan Ambulans', 'class' => 'span4 angkahuruf-only', 'maxlength' => 20)); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="namaPasien" class="control-label">No. Rekam medis</label>
            <div class="controls">
                <?php echo $form->textField($modPemesanan, 'norekammedis', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4 numbers-only', 'maxlength' => 10)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <label for="namaPasien" class="control-label">Nama Pasien</label>
            <div class="controls">
                <?php echo $form->textField($modPemesanan, 'namapasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4 hurufs-only', 'maxlength' => 100)); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="namaPasien" class="control-label">Ruangan</label>
            <div class="controls">
                <?php echo $form->dropDownList($modPemesanan, 'ruangan_id', Chtml::listData(RuanganM::model()->findAll("ruangan_aktif = TRUE ORDER BY ruangan_nama ASC"), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'placeholder' => 'Nama Ruangan', 'class' => 'span4')); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="namaPasien" class="control-label">Nama Pemakai</label>
            <div class="controls">
                <?php echo $form->textField($modPemesanan, 'nama_pemakai', array('placeholder' => 'Nama Pemakai', 'class' => 'span4 angkahuruf-only', 'maxlength' => 10)); ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
    ?>
    <?php
    $content = $this->renderPartial('rawatDarurat.views.tips.informasi_ambulans', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/Print');
$js = <<< JSCRIPT
    function print(caraPrint){
        window.open("${urlPrint}/"+$('#pesanambulans-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>