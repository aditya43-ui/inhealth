
<style> 
    .form-horizontal .control-label{
        width: 185px !important
    } 
</style>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <b> Nota Dinas Ka. UPBJ </b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.BootAlert');
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'notadinaspengadaan-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#',
        ));
        ?>
        <div class="row-fluid">
            <div class="col-sm-6">
                <div class = "control-group">
                    <?php echo CHtml::label("Template Surat <i style='color: red'> * </i>", 'konfigtemplatesurat_id', array('class' => 'control-label required')) ?>
                    <div class = "controls">
                        <?php echo $form->dropDownList($model, 'konfigtemplatesurat_id', CHtml::listData(KonfigtemplatesuratK::model()->findAllByAttributes(array('jenissurat_id' => 25)), 'konfigtemplatesurat_id', 'konfigtemplatesurat_nama'), array('class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event)", 'return false;')); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'notadinaspengadaan_nomor', array('disabled' => true, 'class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
        <hr>
        <div class="row-fluid">
            <div class="col-sm-6">
                <div class = "control-group">
                    <?php echo CHtml::label('Nomor Surat', 'nomor_notadinas', array('class' => 'control-label')) ?>
                    <div class = "controls">
                        <?php echo $form->textField($model, 'nomor_notadinas', array('class' => 'span3')); ?>
                        <?php echo $form->hiddenField($model, 'persiapanpengadaan_id', array('class' => 'span3')); ?>
                    </div>
                </div>
                <div class = "control-group">
                    <?php echo CHtml::label("Tanggal Surat", 'notadinaspengadaan_tanggal', array('class' => 'control-label')) ?>
                    <div class = "controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'notadinaspengadaan_tanggal',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('class' => 'dtPicker3 span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:180px;'
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Nama Penyedia", "", array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        echo $form->hiddenField($model, 'supplier_id', array('class' => 'span3 supplier_id', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
                        echo $form->textField($model, 'supplier_nama', array('disabled' => true, 'class' => 'span3'));
                        ?>
                    </div>
                </div>
                <div class = "control-group">
                    <?php echo CHtml::label('Alamat Penyedia', '', array('class' => 'control-label')) ?>
                    <div class = "controls">
                        <?php echo $form->textArea($model, 'supplier_alamat', array('disabled' => true, 'class' => 'span3', 'rows'=>3)); ?>
                    </div>
                </div>
                <div class = "control-group">
                    <?php echo CHtml::label('NPWP', '', array('class' => 'control-label')) ?>
                    <div class = "controls">
                        <?php echo $form->textField($model, 'supplier_npwp', array('disabled' => true, 'class' => 'span3', 'readonly' => true)); ?>
                    </div>
                </div>
                <div class = "control-group">
                    <?php echo CHtml::label('Harga setelah negosiasi', 'harga_negosiasi', array('class' => 'control-label')) ?>
                    <div class = "controls">
                        <?php echo $form->textField($model, 'harga_negosiasi', array('readonly' => !empty($model->pengumumanpemenang_id) ? true : false, 'class' => 'span3 integer2')); ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class = "control-group">
                    <?php echo CHtml::label('Nomor Pengumuman Pemenang', 'nomor_notadinas', array('class' => 'control-label')) ?>
                    <div class = "controls">
                        <?php echo $form->textField($model, 'pengumuman_nomor', array('class' => 'span3','readonly' => !empty($model->pengumumanpemenang_id) ? true : false, )); ?>
                        <?php echo $form->hiddenField($model, 'pengumumanpemenang_id', array('class' => 'span3')); ?>
                    </div>
                </div>
                <div class = "control-group">
                    <?php echo CHtml::label("Tanggal Pengumuman Pemenang", 'pengumuman_tanggal', array('class' => 'control-label')) ?>
                    <div class = "controls">
                        
                        <?php
                        if(empty($model->pengumumanpemenang_id)) {
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'pengumuman_tanggal',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('class' => 'dtPicker3 span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:180px;'
                            ),
                        ));
                        } else {
                            echo $form->textField($model, 'pengumuman_tanggal', array('class' => 'span3','readonly' => true));
                        }
                        ?>
                    </div>
                </div> 
                <?php 
                    $cekInfoUmum = InfoumumpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id));
                    if(!empty($cekInfoUmum->pegpengadaan_id)) { 
                ?>
                <div class = "control-group">
                    <?php echo CHtml::label('Pejabat Pengadaan', '', array('class' => 'control-label')) ?>
                    <div class = "controls">
                        <?php echo $form->textField($model, 'nama_pegawai', array('disabled' => true, 'class' => 'span3')); ?>
                        <?php echo $form->hiddenField($model, 'pegawai_id', array('class' => 'span3')); ?>
                    </div>
                </div>
                <div class = "control-group">
                    <?php echo CHtml::label('NIP', '', array('class' => 'control-label')) ?>
                    <div class = "controls">
                        <?php echo $form->textField($model, 'noindukpegawai', array('disabled' => true, 'class' => 'span3')); ?>
                    </div>
                </div>
                <div class = "control-group">
                    <?php echo CHtml::label('Jabatan Pengadaan', '', array('class' => 'control-label')) ?>
                    <div class = "controls">
                        <?php echo $form->textField($model, 'peg_jabatan', array( 'readonly' => true, 'class' => 'span3')); ?>
                    </div>
                </div>
                    <?php } ?>
            </div>
        </div>
        <?php echo CHtml::hiddenField('verifikasi', '', array('class' => 'span3'))?>
        <div class="row-fluid">
            <?php 
            $cekSPK = SuratperjanjiankerjaT::model()->findByAttributes(array('persiapanpengadaan_id' => $_GET['id'],'isbatal' => false, 'isaddendum' => true));
            if (!empty($cekSPK)) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="glyphicon glyphicon-ok"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                echo "&nbsp;";
            }else{
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="glyphicon glyphicon-ok"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => "cekSimpan();return false;", 'onKeypress' => 'return formSubmit(this,event)')); 
            }
            ?>
            
            <?php echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl('index&id=' . $model->persiapanpengadaan_id), array('class' => 'btn btn-danger','onclick' => 'return refreshForm(this);'));?>
            <?php
                if (!empty($model->notadinaspengadaan_id)) {
                    echo "&nbsp;";
                    echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "window.open('" . $this->createUrl('print', array('id' => $model->notadinaspengadaan_id)) . "', 'printwin', 'left=100,top=100,width=790,height=1120')"));
                    echo "&nbsp;";
                    if (empty($model->isverifikasi)) {
                        echo CHtml::link(Yii::t('mds', '{icon} Verifikasi', array('{icon}' => '<i class="glyphicon glyphicon-ok"></i>')), 'javascript:void(0);', array('class' => 'btn btn-success', 'onclick' => 'persetujuan(' . $model->notadinaspengadaan_id . '); return false;'));
                        echo "&nbsp;";
                    }
                        
                }
            $content = $this->renderPartial('pengadaan.views.tips/transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<script>
    function cekSimpan(){
        $("#notadinaspengadaan-t-form").find('.integer2').maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2});
        $("#notadinaspengadaan-t-form").submit();
    }
    $("#notadinaspengadaan-t-form").find('.integer2').maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2});

    function persetujuan(id){
        var nomor = $("#NotadinaspengadaanT_nomor_notadinas").val();
        var tanggal = $("#NotadinaspengadaanT_notadinaspengadaan_tanggal").val();
        
        if (nomor == "" || tanggal == "") {
            if (nomor == "") {
                $('#NotadinaspengadaanT_nomor_notadinas').css('border-color', '#b94a48');
            } else {
                $('#NotadinaspengadaanT_nomor_notadinas').css('border-color', ''); 
            }
            
            if (tanggal == "") {
                $('#NotadinaspengadaanT_notadinaspengadaan_tanggal').css('border-color', '#b94a48');
            } else {
                $('#NotadinaspengadaanT_notadinaspengadaan_tanggal').css('border-color', ''); 
            }
            myAlert("Nomor dan Tanggal Nota Dinas Wajib Diisi", "Perhatian!");
            return false; 
        } else {
            $("#verifikasi").val('verifikasi');
            $('#notadinaspengadaan-t-form').submit();
        }
    }
</script>