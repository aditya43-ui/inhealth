<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'penjadwalanpemeriksaan-m-search',
    'type' => 'horizontal',
        ));
$format = new MyFormatter();
?>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">		
            <?php echo CHtml::label("Tanggal Penjadwalan", 'dari_tanggal', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline " data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tanggal_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tanggal_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span ><?php echo date('F d, Y', strtotime($model->tanggal_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tanggal_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tanggal_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tanggal_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label required">Nomor SPK </label>
            <div class="controls">
                <?php echo CHtml::activeTextField($model, 'nosuratperjanjiankerja', array('placeholder' => 'Ketik Nomor Surat Perjanjian Kerja', 'readonly' => false, 'class' => 'span4',)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Nomor Penjadwalan Pemeriksaan</label>
            <div class="controls">
                <?php echo CHtml::activeTextField($model, 'pengadaanjadwalpemeriksaan_nomor', array('placeholder' => 'Ketik Nomor Penjadwalan Pemeriksaan', 'readonly' => false, 'class' => 'nama_pekerjaan span4 autogrow')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label">Nama Pekerjaan</label>
            <div class="controls">
                <?php echo CHtml::activeTextField($model, 'nama_pekerjaan', array('placeholder' => 'Ketik Nama Pekerjaan', 'readonly' => false, 'class' => 'nama_pekerjaan span4 autogrow')); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Nama Penyedia</label>
            <div class="controls">
                <?php echo CHtml::activeTextField($model, 'supplier_nama', array('placeholder' => 'Ketik Nama Penyedia', 'readonly' => false, 'class' => 'nama_pekerjaan span4 autogrow')); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Status</label>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'pengadaanjadwalpemeriksaan_status', LookupM::getItems('statuspenjadwalanpemeriksaan'), array('empty' => '--Pilih--', 'class' => 'span4')); ?>
            </div>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="form-actions">
        <?php 
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')). "&nbsp&nbsp"; 

        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('index'), array(
            'class' => 'btn btn-danger',
            'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl('index') . '";}); return false;')) . "&nbsp&nbsp"; 

        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp";


        $tips = array(
            '0' => 'tanggal',
            '1' => 'cari',
            '2' => 'ulang'
        );
        $content = $this->renderPartial('pengadaan.views.tips.informasi', array('tips' => $tips), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>