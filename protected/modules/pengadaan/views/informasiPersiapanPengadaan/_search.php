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
            <?php echo CHtml::label("Tanggal RUP", 'periode', array('class' => 'control-label')) ?>
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
            <?php echo Chtml::label("Nomor Persiapan Pengadaan",'persiapanpengadaan_nomor', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'persiapanpengadaan_nomor',array('placeholder'=>'Ketik Nomor Persiapan Pengadaan')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Nomor RUP",'rencanaumumpengadaan_nomor', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'rencanaumumpengadaan_nomor',array('placeholder'=>'Ketik Nomor RUP')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Nomor SiRUP",'kode_rup', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'kode_rup',array('placeholder'=>'Ketik Nomor SiRUP')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Bidang / Bagian / Instalasi",'instalasi_nama', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'instalasi_nama',array('placeholder'=>'Ketik Bidang / Bagian / Instalasi')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Nama Pekerjaan",'nama_pekerjaan', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'nama_pekerjaan',array('placeholder'=>'Ketik Nama Pekerjaan')) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
         <div class = "control-group">
            <?php echo Chtml::label("Kategori Pengadaan",'rencanaumumpengadaan_kategori', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->dropDownList($model,'rencanaumumpengadaan_kategori', LookupM::getItems('kategoripengadaan'),
                    array('onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
            </div>
        </div>
         <div class = "control-group">
            <?php echo Chtml::label("Jenis Pengadaan",'daftarjenispengadaan', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->dropDownList($model,'daftarjenispengadaan', Chtml::listData(JenispengadaanM::model()->findAllByAttributes(array('jenispengadaan_aktif'=>true)),'jenispengadaan_nama','jenispengadaan_nama'),
                    array('onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
            </div>
        </div>
         <div class = "control-group">
            <?php echo Chtml::label("Metode Pengadaan",'metodepengadaan_nama', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->dropDownList($model,'metodepengadaan_nama', Chtml::listData(MetodepengadaanM::model()->findAllByAttributes(array('metodepengadaan_aktif'=>true)),'metodepengadaan_nama','metodepengadaan_nama'),
                    array('onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
            </div>
        </div>
         <div class = "control-group">
            <?php echo Chtml::label("Tipe Swakelola",'swakelola_tipe', array('class'=>'control-label')) ?>
            <div class = "controls">
               <?php echo $form->dropDownList($model,'swakelola_tipe', LookupM::getItems("swakelolatipe"),
                    array('onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
            </div>
        </div>
         <div class = "control-group">
            <?php echo Chtml::label("Status",'persiapanpengadaan_status', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->dropDownList($model,'persiapanpengadaan_status', LookupM::getItems('statuspersiapanpengadaan'),
                    array('onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
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
    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp";
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
    
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
