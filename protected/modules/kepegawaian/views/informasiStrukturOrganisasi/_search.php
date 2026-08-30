<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'pegmutasi-r-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'nama_pegawai'),
));
$format = new MyFormatter();
?>
<?php //echo $form->textFieldRow($model,'pelamar_id',array('class'=>'span5')); 
?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Periode", 'dari_tanggal', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label("No SK", 'organigram_kode', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'organigram_kode', array('placeholder' => 'No SK', 'class' => 'custom-only span4')) ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label("Unit Kerja", 'organigram_unitkerja', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'organigram_unitkerja', Chtml::listData(UnitkerjaM::model()->findAll("unitkerja_aktif = TRUE ORDER BY namaunitkerja ASC"), 'namaunitkerja', 'namaunitkerja'), array('class' => 'span4', 'empty' => '-- Pilih --')) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo Chtml::label("NIP", 'nomorindukpegawai', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nomorindukpegawai', array('placeholder' => 'NIP', 'class' => 'span4 numbers-only')) ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label("Nama Pegawai", 'nama_pegawai', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nama_pegawai', array('placeholder' => 'Nama Pegawai', 'class' => 'span4 hurufs-only')) ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label("Jabatan", 'jabatan_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('class' => 'span4', 'empty' => '-- Pilih --')) ?>
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
        $this->createUrl($this->id . '/index'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Print Organigram', array('{icon}' => '<i class="entypo-print"></i>')),
        array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print("PRINT")')
    );
    ?>
    <?php
    $tips = array(
        '0' => 'tanggal',
        '1' => 'cari',
        '2' => 'ulang',
        '3' => 'print',
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
$js = <<< JSCRIPT
    function print(caraPrint)
    {
        window.open("${urlPrint}/"+$('#pegmutasi-r-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>