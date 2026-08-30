<?php
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'dokumenpengadaan-m-search',
    'type'=>'horizontal',
)); 
$format = new MyFormatter();
?>

<div class="row-fluid">
    <div class="col-sm-6">
        <div class = "control-group">
            <?php echo Chtml::label("Periode Anggaran",'periodeanggaran_id', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->dropDownList($model,'periodeanggaran_id', $model->getPeriodeAnggaran(),
                    array('onkeypress'=>"return $(this).focusNextInputField(event)",'class' => 'span4')); ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Nama Pekerjaan",'nama_pekerjaan', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'nama_pekerjaan',array('placeholder'=>'Ketik Nama Pekerjaan')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Unit Kerja",'namaunitkerja', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'namaunitkerja',array('placeholder'=>'Ketik Unit Kerja')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Nama Supplier",'supplier_nama', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'supplier_nama',array('placeholder'=>'Ketik Nama Supplier')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Pejabat Pembuat Komitmen",'nama_pegawai', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'nama_pegawai',array('placeholder'=>'Ketik Nama Pejabat Pembuat Komitmen')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Kuasa Pengguna Anggaran",'nama_kpa', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'nama_kpa',array('placeholder'=>'Ketik Nama Kuasa Pengguna Anggaran')) ?>
            </div>
        </div>
        <div class = "control-group">
        <?php
            echo Chtml::label("Kode SIRUP",'koderup_final', array('class'=>'control-label'));
        ?>
            <div class = "controls">
            <?php
                echo $form->textField($model,'koderup_final',array('placeholder'=>'Ketik Kode SIRUP'));
            ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class = "control-group">
            <?php echo Chtml::label("Nomor RUP",'rencanaumumpengadaan_nomor', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'rencanaumumpengadaan_nomor',array('placeholder'=>'Ketik Nomor RUP')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Nomor Persiapan Pengadaan",'persiapanpengadaan_nomor', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'persiapanpengadaan_nomor',array('placeholder'=>'Ketik Nomor Persiapan Pengadaan')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Nomor Transaksi Kontrak",'nosuratperjanjiankerja', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'nosuratperjanjiankerja',array('placeholder'=>'Ketik Nomor Transaksi SPK')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Nomor Dokumen Kontrak",'nomor_dokumen', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'nomor_dokumen',array('placeholder'=>'Ketik Nomor Dokumen SPK')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Nomor Transaksi Nota Dinas PPTK",'notadinaspptk_nomor', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'notadinaspptk_nomor',array('placeholder'=>'Ketik Nomor Transaksi Nota Dinas PPTK')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Nomor Dokumen Nota Dinas PPTK",'nomor_notadinas', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'nomor_notadinas',array('placeholder'=>'Ketik Nomor Dokumen Nota Dinas PPTK')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Status",'status', array('class'=>'control-label')) ?>
            <div class = "controls">                
                <?php echo $form->dropDownList($model,'status', LookupM::getItemsUrutan('statusinfodokpengadaan'),array('empty'=>'-- Pilih --')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Kode Kegiatan",'kode_kegiatan', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'kode_kegiatan',array('placeholder'=>'Ketik Status')) ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
        $this->createUrl($this->id.'/indexPribadi'), 
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