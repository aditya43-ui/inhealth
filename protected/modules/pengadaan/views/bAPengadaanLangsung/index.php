<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>


<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'bapengadaanlangsung-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data','onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>
<style>
    .form-horizontal .control-label{
        width: 135px;
    }
</style>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><span class='judul'>Berita Acara <b> Penjelasan Pengadaan Langsung </b></span></div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-6">
                <?php echo $form->dropDownListRow($model, 'konfigtemplatesurat_id', CHtml::listData(KonfigtemplatesuratK::model()->findAllByAttributes(array('jenissurat_id' => 39)), 'konfigtemplatesurat_id', 'konfigtemplatesurat_nama'), array('class' => 'span3 required jenisform', 'onkeyup' => "return $(this).focusNextInputField(event)", 'return false;')); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'bapengadaanlangsung_nomor', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
            <div class="clear"></div>
            <hr>
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'nomor_beritaacara', array('class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Nomor Surat')); ?>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'bapengadaanlangsung_tanggal', array('class' => 'control-label required')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'bapengadaanlangsung_tanggal',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('class' => 'span3 dtPicker3 required', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                        ));
                        ?>
                        <?php echo $form->error($model, 'bapengadaanlangsung_tanggal'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'supplier_id', array('class' => 'control-label required', 'label' => 'Nama Penyedia')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'supplier_nama', array('readonly' => true, 'class' => 'span3 required', 'onblur' => 'return false;')); ?>
                        <?php echo $form->hiddenField($model, 'supplier_id', array('readonly' => true, 'class' => 'span1 required', 'onblur' => 'return false;')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'supplier_id', array('class' => 'control-label required', 'label' => 'Alamat Penyedia')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textArea($model, 'alamat_supplier', array(
                            'readonly' => true,
                            'class' => 'span3 required',
                            'style' => 'height:65px !important',
                            'onblur' => 'return false;',
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'supplier_id', array('class' => 'control-label required', 'label' => 'Nama Direktur')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'nama_direktur', array('readonly' => true, 'class' => 'span3 required', 'onblur' => 'return false;')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'waktu_pertemuan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'waktu_pertemuan',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                        ));
                        ?>
                        <?php echo $form->error($model, 'bapengadaanlangsung_tanggal'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'lokasi_pertemuan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'lokasi_pertemuan', array('class' => 'span3')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'harga_penawaran', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'harga_penawaran', array('class' => 'span3 integer-decimal')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'harga_terkoreksi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'harga_terkoreksi', array('class' => 'span3 integer-decimal')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'total_negosiasi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'total_negosiasi', array('class' => 'span3 integer-decimal')); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <?php 
                    $cekInformasi = InfoumumpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id));
                    if(!empty($cekInformasi->pegpengadaan_id)) {
                ?>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'pejabat_pengadaan', array('class' => 'control-label required')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'pejabat_pengadaan', array('readonly' => true, 'class' => 'span3 required', 'onblur' => 'return false;')); ?>
                        <?php echo $form->hiddenField($model, 'pegpengadaan_id', array('readonly' => true, 'class' => 'span1', 'onblur' => 'return false;')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'pejabat_pengadaan_nip', array('class' => 'control-label', 'label' => 'NIP')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'pejabat_pengadaan_nip', array('readonly' => true, 'class' => 'span3', 'onblur' => 'return false;')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'jabatan_pengadaan', array('class' => 'control-label required')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'jabatan_pengadaan', array('readonly' => true, 'class' => 'span3', 'onblur' => 'return false;')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'nomor_sk', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'nomor_sk', array('readonly' => true, 'class' => 'span3', 'onblur' => 'return false;')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'tanggal_sk', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'tanggal_sk', array('readonly' => true, 'class' => 'span3', 'onblur' => 'return false;')); ?>
                    </div>
                </div>
                <?php } ?>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'kehadiran_pejabat', array('class' => 'control-label', 'label' => '<b>Kehadiran</b>')) ?>
                    <div class="controls">
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'kehadiran_pejabat', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'kehadiran_pejabat', array('class' => 'span1 numbers-only', 'onblur' => 'return false;')); ?> <label> orang</label>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'kehadiran_penyedia', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'kehadiran_penyedia', array('class' => 'span1 numbers-only', 'onblur' => 'return false;')); ?> <label> orang</label>
                    </div>
                </div>
                <div class="control-group ">
                <?php echo CHtml::label("Dokumen Pendukung", '', array('class' => 'control-label')); ?>
                    <div class="controls">
                    <?php echo $form->fileField($model, 'dokumen_pendukung', array('accept'=>'application/pdf','class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 500)); ?>
                    <?php
                        if (!empty($model->dokumen_pendukung)) {
                            echo CHtml::link("$model->dokumen_pendukung", $this->createUrl('Unduh', array('id' => $model->bapengadaanlangsung_id)), array('title' => 'Unduh dokumen pendukung', 'rel' => 'tooltip', 'style' => 'color:blue;'));
                        }
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls" >
                        <span class="required" style="font-size: 10px;"><i>Hanya file dengan ekstensi .pdf (maks 5mb)</i></span>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row-fluid">
            <div class="form-actions">
                <?php
                $cekSPK = SuratperjanjiankerjaT::model()->findByAttributes(array('persiapanpengadaan_id' => $_GET['id'],'isbatal' => false, 'isaddendum' => true));
                if (!empty($cekSPK)) {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                    echo "&nbsp;";
                }else{
                    if (!isset($_GET['sukses'])) {
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit'));
                        echo "&nbsp;";
                    } else {
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                        echo "&nbsp;";
                    }
                }
                
                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/index', array('id' => $modPersiapanPengadaan->persiapanpengadaan_id)), array('class' => 'btn btn-danger', 'onclick' => 'return refreshForm(this);'));
                echo "&nbsp;";
                if (empty($model->bapengadaanlangsung_id)) {
                    echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => 'true'));
                    echo "&nbsp;";
                } else {
                    echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print()"));
                    echo "&nbsp;";
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<script>
    function print() {
        window.open('<?php echo $this->createUrl('print', array('id' => $model->bapengadaanlangsung_id)); ?>', 'printwin', 'left=100,top=100,width=640,height=480');
    }

    $(document).ready(function () {
<?php if (isset($_GET['sukses'])) { ?>
            $('input').attr('readonly', true);
            $('.add-on').hide();
<?php } ?>
    });
    document.getElementById("BapengadaanlangsungT_dokumen_pendukung").onchange = function () {
        if(this.files[0].size>5000000){
            myAlert("ukuran maks : 5Mb");
            $("#BapengadaanlangsungT_dokumen_pendukung").attr("src","blank");
            $('#BapengadaanlangsungT_dokumen_pendukung').wrap('<form>').closest('form').get(0).reset();
            $('#BapengadaanlangsungT_dokumen_pendukung').unwrap();     
            return false;
        }
        if(this.files[0].type.indexOf("pdf")==-1){
            myAlert("Tipe file harus PDF");
            $("#BapengadaanlangsungT_dokumen_pendukung").attr("src","blank");
            $('#BapengadaanlangsungT_dokumen_pendukung').wrap('<form>').closest('form').get(0).reset();
            $('#BapengadaanlangsungT_dokumen_pendukung').unwrap();         
            return false;
        } 
    };
</script>