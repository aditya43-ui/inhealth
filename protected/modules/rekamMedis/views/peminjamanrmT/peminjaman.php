<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$idDokumen = CHtml::activeId($model, 'dokrekammedis_id');
$idPeminjaman = CHtml::activeId($model, 'peminjamanrm_id');
$pasien_id = CHtml::activeId($model, 'pasien_id');
$idRuangan = CHtml::activeId($model, 'ruangan_id');
$pendaftaran_id = CHtml::activeId($model, 'pendaftaran_id');
$noRekamMedik = CHtml::activeId($model, 'no_rekam_medik');
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rkpeminjamanrm-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
)); ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="white-container">
    <legend class="rim2">Transaksi <b>Peminjaman Dokumen Rekam Medis</b></legend>
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-user"></i> Data <b>Pasien</b></legend>
        <?php echo $form->hiddenField($model, 'pasien_id', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'pendaftaran_id', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'dokrekammedis_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'ruangan_id', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'pengirimanrm_id', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <table style="width: 100%; border: none;">
            <tr>
                <td>
                    <div class="control-group">
                        <?php echo CHtml::activeLabel($model, 'no_rekam_medik', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'no_rekam_medik',
                                'value' => '',
                                'sourceUrl' => $this->createUrl('PasienLamauntukPeminjaman'),
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ) {
                                        $(this).val(ui.item.label);
                                        return true;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                    $(this).val(ui.item.label);
                                    $("#' . CHtml::activeId($model, 'jenis_kelamin') . '").val(ui.item.jeniskelamin);
                                    $("#' . CHtml::activeId($model, 'nama_pasien') . '").val(ui.item.nama_pasien);
                                    $("#' . CHtml::activeId($model, 'tanggal_lahir') . '").val(ui.item.tanggal_lahir);
                                    $("#' . CHtml::activeId($model, 'dokrekammedis_id') . '").val(ui.item.dokrekammedis_id);
                                    $("#' . CHtml::activeId($model, 'pasien_id') . '").val(ui.item.pasien_id);
                                    $("#' . CHtml::activeId($model, 'pendaftaran_id') . '").val(ui.item.pendaftaran_id);
                                    $("#' . CHtml::activeId($model, 'ruangan_id') . '").val(ui.item.ruangan_id);
                                    $("#' . CHtml::activeId($model, 'lokasirak_nama') . '").val(ui.item.lokasirak_nama);
                                    $("#' . CHtml::activeId($model, 'subrak_nama') . '").val(ui.item.subrak_nama);
                                    $("#' . CHtml::activeId($model, 'warnadokrm_namawarna') . '").val(ui.item.warnadokrm_namawarna);
									setUmur(ui.item.tanggal_lahir);
                                    return true;
                                }',
                                ),
                                'htmlOptions' => array(
                                    'onkeypress' => 'return $(this).focusNextInputField(event)',
                                    'disabled' => ($model->isNewRecord) ? '' : 'disabled',
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogRekamMedik'),

                            ));
                            ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($model, 'nama_pasien', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                </td>
                <td>
                    <?php echo $form->textFieldRow($model, 'jenis_kelamin', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php echo $form->textFieldRow($model, 'tanggal_lahir', array('class' => 'span3', 'readonly' => true, 'onblur' => 'setUmur(this.value);', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php echo $form->textFieldRow($model, 'umur', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                </td>
                <td>
                    <?php echo $form->textFieldRow($model, 'lokasirak_nama', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php echo $form->textFieldRow($model, 'subrak_nama', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php echo $form->textFieldRow($model, 'warnadokrm_namawarna', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                </td>
            </tr>
        </table>
    </fieldset><br><br>
    <!--<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->-->
    <?php echo $form->errorSummary($model); ?>
    <?php
    if (!$model->isNewRecord) {
        echo $form->hiddenField($model, 'peminjamanrm_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);"));
    }
    ?>
    <fieldset class="box">
        <legend class="rim"> Peminjaman Dokumen Rekam Medis</legend>
        <table style="width: 100%; border: none;">
            <tr>
                <td>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'tglpeminjamanrm', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $model->tglpeminjamanrm = MyFormatter::formatDateTimeForUser($model->tglpeminjamanrm);
                            $model->tglakandikembalikan = MyFormatter::formatDateTimeForUser($model->tglakandikembalikan);
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglpeminjamanrm',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3'),
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'tglakandikembalikan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglakandikembalikan',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3'),
                            ));
                            ?>
                        </div>
                    </div>
                    <?php //echo $form->textFieldRow($model,'tglakandikembalikan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <?php //echo $form->checkBoxRow($model,'printpeminjaman', array('onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <?php //echo $form->textFieldRow($model,'create_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <?php //echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <?php //echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <?php //echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                </td>
                <td>
                    <div class="control-group">
                        <?php echo CHtml::activeLabel($model, 'namapeminjam', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'namapeminjam',
                                'value' => '',
                                'sourceUrl' => $this->createUrl('GetNamaPeminjam'),
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ) {
											$(this).val(ui.item.namapeminjam);
											return false;
										}',
                                    'select' => 'js:function( event, ui ) {
											$("#' . CHtml::activeId($model, 'namapeminjam') . '").val(ui.item.nama_pegawai);
											return false; }',
                                ),
                                'htmlOptions' => array(
                                    'onkeypress' => 'return $(this).focusNextInputField(event)',
                                    'disabled' => ($model->isNewRecord) ? '' : 'disabled',
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogNamaPeminjam'),
                            ));
                            ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($model, 'untukkepentingan', array('disabled' => ($model->isNewRecord) ? '' : 'disabled', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Alasan peminjaman', 'autofocus' => true)); ?>
                <td>
                    <?php echo $form->textAreaRow($model, 'keteranganpeminjaman', array('disabled' => ($model->isNewRecord) ? '' : 'disabled', 'rows' => 4, 'cols' => 7, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Ket. peminjaman berkas')); ?>
                </td>
                <?php //echo $form->textFieldRow($model,'nourut_pinjam',array('class'=>'span3', 'readonly'=>true,'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>5)); 
                ?>
                <?php //echo $form->textFieldRow($model,'pasien_id',array('class'=>'span3', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                ?>
                <?php //echo $form->textFieldRow($model,'pendaftaran_id',array('class'=>'span3', 'readonly'=>true,'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                ?>
                <?php //echo $form->textFieldRow($model,'ruangan_id',array('class'=>'span3', 'readonly'=>true,'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                ?>
                </td>
            </tr>
        </table>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => ($model->isNewRecord ? '' : 'disabled'))
            ); ?>
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/peminjaman'),
                array(
                    'class' => 'btn btn-default',
                    'onclick' => 'return refreshForm(this);'
                )
            );
            ?>
            <?php //echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
            //                            Yii::app()->createUrl($this->module->id.'/'.peminjamanrmT.'/admin'), 
            //                            array('class' => 'btn btn-default',
            //                                  'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); 
            ?>

            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print()', 'disabled' => ($model->isNewRecord ? 'disabled' : ''))); ?>
            <?php
            $content = $this->renderPartial('../tips/transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </fieldset>
</div>
<?php

//$this->widget('UserTips',array('type'=>'admin'));
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
$cetak = Yii::app()->createUrl('rekamMedis/peminjamanrmT');

$js = <<< JSCRIPT
function print()
   {    
        id = $('#${idPeminjaman}').val();        
        pasien_id = $('#${pasien_id}').val();
        if (pasien_id == ''){
            myAlert('Isi Data Pasien yang akan d print');
            return false;
        }
        
        
               window.open('${cetak}/printPeminjaman/id/'+id+'','printwin','left=100,top=100,width=355,height=450,scrollbars=0');
   }
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>
<!--======================== Begin Widget Dialog Rekam Medik =============================-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRekamMedik',
    'options' => array(
        'title' => 'Detail Data',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1100,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<?php
$modDokumenPasienLama = new RKDokumenpasienrmlamaV();
$modDokumenPasienLama->unsetAttributes();
if (isset($_GET['RKDokumenpasienrmlamaV'])) {
    $modDokumenPasienLama->attributes = $_GET['RKDokumenpasienrmlamaV'];
}
?>
<?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rkdokumenpasienrmlama-v-grid',
    'dataProvider' => $modDokumenPasienLama->searchDialogPeminjaman(),
    'filter' => $modDokumenPasienLama,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-check\"></i>","#",array("class"=>"btn-small", 
                            "id" => "selectDokumen",
                            "onClick" => "
                                        $(\'#' . CHtml::activeId($model, 'lokasirak_nama') . '\').val(\'$data->lokasirak_nama\');
                                        $(\'#' . CHtml::activeId($model, 'subrak_nama') . '\').val(\'$data->subrak_nama\');
                                        $(\'#' . CHtml::activeId($model, 'warnadokrm_namawarna') . '\').val(\'$data->warnadokrm_namawarna\');
                                        $(\'#' . CHtml::activeId($model, 'nama_pasien') . '\').val(\'$data->nama_pasien\');
                                        $(\'#' . CHtml::activeId($model, 'jenis_kelamin') . '\').val(\'$data->jeniskelamin\');
                                        $(\'#' . CHtml::activeId($model, 'tanggal_lahir') . '\').val(\'$data->tanggal_lahir\');
                                        $(\'#' . CHtml::activeId($model, 'ruangan_id') . '\').val(\'$data->ruangan_id\');
                                        $(\'#' . CHtml::activeId($model, 'pengirimanrm_id') . '\').val(\'$data->pengirimanrm_id\');
                                        submitRekamMedis(\'$data->no_rekam_medik\', $data->dokrekammedis_id, $data->pasien_id, $data->pendaftaran_id, $data->ruangan_id);
                                        setUmur(\'$data->tanggal_lahir\');
                                        $(\'#dialogRekamMedik\').dialog(\'close\');
                                        return false;"))',
        ),
        array(
            'name' => 'lokasirak_id',
            'filter' =>  CHtml::listData(LokasirakM::model()->findAll('lokasirak_aktif = true'), 'lokasirak_id', 'lokasirak_nama'),
            'value' => '$data->lokasirak_nama',
        ),
        array(
            'name' => 'subrak_id',
            'filter' =>  CHtml::listData(SubrakM::model()->findAll('subrak_aktif = true'), 'subrak_id', 'subrak_nama'),
            'value' => '$data->subrak_nama',
        ),
        array(
            'header' => 'Warna Dokumen',
            'type' => 'raw',
            'value' => '$this->grid->getOwner()->renderPartial(\'_warnaDokumen\', array(\'warnadokrm_id\'=>$data->warnadokrm_id), true)',
        ),
        'no_rekam_medik',
        //        'pendaftaran.tgl_pendaftaran',
        'no_pendaftaran',
        'nama_pasien',
        array(
            'name' => 'tanggal_lahir',
            'filter' => false,
            'value' => '$data->tanggal_lahir',
        ),
        array(
            'name' => 'jeniskelamin',
            'filter' => LookupM::getItems('jeniskelamin'),
            'value' => '$data->jeniskelamin',
        ),
        array(
            'name' => 'alamat_pasien',
            'filter' => false,
            'value' => '$data->jeniskelamin',
        ),
        array(
            'name' => 'instalasi_id',
            'filter' => false,
            'value' => '$data->instalasi_nama',
        ),
        array(
            'name' => 'instalasi_id',
            'filter' =>  CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true'), 'instalasi_id', 'instalasi_nama'),
            'value' => '$data->instalasi_nama',
        ),
        array(
            'name' => 'ruangan_id',
            'filter' =>  CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true'), 'ruangan_id', 'ruangan_nama'),
            'value' => '$data->ruangan_nama',
        ),
        array(
            'header' => 'Kelengkapan',
            'class' => 'CCheckBoxColumn',
            'selectableRows' => 0,
            'id' => 'rows',
            //            'checked'=>'(isset($data->pengiriman) ? $data->pengiriman->kelengkapandokumen : "")',
            'checked' => '!empty($data->pengirimanrm_id) ? TRUE : FALSE',
        ),
        array(
            'header' => 'Print',
            'class' => 'CCheckBoxColumn',
            'selectableRows' => 0,
            'id' => 'rows',
            'checked' => '$data->printpeminjaman',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
                        var colors = jQuery(\'input[rel="colorPicker"]\').attr(\'colors\').split(\',\');
                        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                        jQuery(\'input[rel="colorPicker"]\').colorPicker({colors:colors});
                }',
)); ?>

<?php $this->endWidget(); ?>
<!--=============================== endWidget Dialog Rekam Medik ============================-->

<!--======================== Begin Widget Dialog Nama Peminjam =============================-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogNamaPeminjam',
    'options' => array(
        'title' => 'Peminjam Dokumen',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 400,
        'resizable' => false,
    ),
));
?>
<?php
$modPeminjam = new RKPegawaiV('searchDialog');
$modPeminjam->unsetAttributes();
if (isset($_GET['RKPegawaiV'])) {
    $modPeminjam->attributes = $_GET['RKPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'namapeminjam-grid',
    'dataProvider' => $modPeminjam->searchDialog(),
    'filter' => $modPeminjam,
    'template' => "{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectNamaPeminjam",
                                    "onClick" => "
                                                  $(\"#' . CHtml::activeId($model, 'namapeminjam') . '\").val(\"$data->nama_pegawai\");
                                                  $(\"#dialogNamaPeminjam\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'filter' =>  CHtml::activeTextField($modPeminjam, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPeminjam, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget(); ?>
<!--=============================== endWidget Dialog Nama Peminjam ============================-->

<?php

$js = <<< JS
    function submitRekamMedis(no_rekam_medik, dokrekammedis_id, pasien_id, pendaftaran_id, ruangan_id){
        $('#${idDokumen}').val(dokrekammedis_id);
        $('#${pasien_id}').val(pasien_id);
        $('#${pendaftaran_id}').val(pendaftaran_id);
        $('#${noRekamMedik}').val(no_rekam_medik);
    }
JS;

$jsOnReady = <<< JS
   $('form').submit(function(){
       if ($('#${idDokumen}').val() == ''){
           myAlert('Silakan pilih dokumen rekam medis yang akan dipinjam!');
           return false;
       }
   });
JS;

Yii::app()->clientScript->registerScript('SubmitDokumen', $js, CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScript('ONReady', $jsOnReady, CClientScript::POS_READY);

?>
<script type="text/javascript">
    /**
     * set nilai umur dari tanggal_lahir 
     * @param {type} tanggal_lahir
     * @returns {undefined} */
    function setUmur(tanggal_lahir) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetUmur'); ?>',
            data: {
                tanggal_lahir: tanggal_lahir
            }, //
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($model, "umur"); ?>").val(data.umur);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
</script>