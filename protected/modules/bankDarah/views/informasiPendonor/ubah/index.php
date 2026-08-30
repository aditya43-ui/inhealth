<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pendaftaranDonorDarah-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
        ));
?>

<div class="panel panel-gradient">	

    <div class="panel-heading">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="panel-title">Pendaftaran Donor Darah</div>
    </div><br>
    <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
    <?php // echo $form->errorSummary($modDaftarDonasi, $modPendonor); ?>
    <div class="panel-body">
        <div class="panel panel-primary panel-success">
            <div class="panel-heading">
                <div class="panel-title">											
                    Pendaftaran Donor Darah																	
                </div>
            </div>
            <div class="row-fluid"><br><br>
                <div class="col-sm-6">  
                    <div class="control-group ">
                        <?php echo CHtml::label('No. Registrasi', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->hiddenField($modPendonor, 'pendonor_id', array('readonly' => true)); ?>
                            
                            <?php echo $form->textField($modPendonor, 'no_pendonor', array('class' => 'span3', 'readonly' => true)); ?>
                        </div>
                    </div>   
                    <div class="control-group ">
                        <?php echo CHtml::label("No Identitas <span class=\"required\">*</span>", '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modPendonor, 'jenisidentitas', LookupM::getItemsUrutan('jenisidentitas'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 form-control jenisidentitas', /* 'style'=>'float:left; width:80px', */ 'onchange' => 'cekLength(this);'));
                            ?>   
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $modPendonor,
                                'attribute' => 'no_identitas',
                                'source' => 'js: function(request, response) {
                                                       $.ajax({
                                                           url: "' . $this->createUrl('AutocompletePendonorLama') . '",
                                                           dataType: "json",
                                                           data: {
                                                               no_identitas: request.term,
                                                           },
                                                           success: function (data) {
                                                                   response(data);
                                                           }
                                                       })
                                                    }',
                                'options' => array(
                                    'minLength' => 3,
                                    'focus' => 'js:function( event, ui ) {
                                                     $(this).val( "");
                                                     return false;
                                                }',
                                    'select' => 'js:function( event, ui ) {
                                                    $(this).val( ui.item.no_identitas_pasien);
                                                    return false;
                                                }',
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => 'No. Identitas',
                                    'rel' => 'tooltip',
                                    'title' => 'Ketik No. Identitas',
                                    'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'class' => 'form-control span3 numbers-only required',
                                ),
                            ));
                            ?>
                        </div>
                    </div>                  
                    <div class="control-group">
                        <?php echo CHtml::label('Nama lengkap <span class="required">*</span>', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($modPendonor, 'nama_lengkap', array('class' => 'span3 hurufs-only required all-caps', 'readonly' => false)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Tempat Lahir <span class="required">*</span>', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $modPendonor,
                                'attribute' => 'tempat_lahir',
                                'source' => 'js: function(request, response) {
                                        $.ajax({
                                            url: "' . $this->createUrl('AutocompleteTempatLahir') . '",
                                            dataType: "json",
                                            data: {
                                            tempat_lahir: request.term,
                                       },
                                       success: function (data) {
                                               response(data);
                                       }
                                   })
                                }',
                                'options' => array(
                                    'minLength' => 3,
                                    'focus' => 'js:function( event, ui ) {
                                        $(this).val(ui.item.value);
                                        $(this).val().toUpperCase();
                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                        $(this).val(ui.item.value);
                                        $(this).val().toUpperCase();
                                        return false;
                                    }',
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => 'Kota/Kabupaten Kelahiran',
                                    'rel' => 'tooltip',
                                    'title' => 'Ketik tempat lahir pasien',
                                    'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'class' => 'required form-control span3 all-caps hurufs-only',
                                    'onblur' => '',
                                ),
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo CHtml::label('Tanggal Lahir <span class="required">*</span>', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modPendonor,
                                'attribute' => 'tgllahir',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => '-17y',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2 required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:204px;'
                                ),
                            ));
                            ?>
                        </div>
                    </div>
                    <?php echo $form->radioButtonListInlineRow($modPendonor, 'jenis_kelamin', LookupM::getItems('jeniskelamin'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'form-control')); ?>


                    <div class="control-group" id="pekerjaanpendonor" style="display: block">
                        <?php echo CHtml::label("Pekerjaan<span class='required'>*</span>", 'pekerjaan_id', array('class' => 'control-label')) ?>
                        <div class = "controls">
                            <?php
                            echo $form->hiddenField($modPendonor, 'pekerjaan_id',array('class' => 'reset required'));
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $modPendonor,
                                'attribute' => 'pekerjaan_nama',
                                'source' => 'js: function(request, response) {
                                        $.ajax({
                                            url: "' . $this->createUrl('AutocompletePekerjaan') . '",
                                            dataType: "json",
                                            data: {
                                            pekerjaan_nama: request.term,
                                       },
                                       success: function (data) {
                                            response(data);
                                       }
                                   })
                                }',
                                'options' => array(
                                    'minLength' => 3,
                                    'focus' => 'js:function( event, ui ) {
                                        $(this).val(ui.item.label);
                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                        $("#' . Chtml::activeId($modPendonor, 'pekerjaan_id') . '").val(ui.item.value);                                         
                                        return false;
                                    }',
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => 'Ketikan Pekerjaan Pendonor',
                                    'rel' => 'tooltip',
                                    'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'class' => 'form-control span3 hurufs-only required',
                                    'onblur' => '',
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogPekerjaan'),
                            ));
                            ?>
                        </div>
                    </div>
                    
                     <?php echo $form->dropDownListRow($modPendonor, 'agama', LookupM::getItems('agama'), array('class' => '', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>

                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('Alamat Lengkap <span class="required">*</span>', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textArea($modPendonor, 'alamat_lengkap', array('placeholder' => '', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Propinsi', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($modPendonor, 'propinsi_id', CHtml::listData($modPendonor->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class'=>'span3',
                                'ajax' => array('type' => 'POST',
                                    'url' => Yii::app()->createUrl('ActionDynamic/GetKabupaten', array('encode' => false, 'model_nama' => '' . $modPendonor->getNamaModel() . '')),
                                    'update' => '#BDPendonorM_kabupaten_id')));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Kabupaten', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($modPendonor, 'kabupaten_id', CHtml::listData($modPendonor->getKabupatenItems(), 'kabupaten_id', 'kabupaten_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class'=>'span3',
                                'ajax' => array('type' => 'POST',
                                    'url' => Yii::app()->createUrl('ActionDynamic/GetKecamatan', array('encode' => false, 'model_nama' => '' . $modPendonor->getNamaModel() . '')),
                                    'update' => '#BDPendonorM_kecamatan_id')));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Kecamatan', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($modPendonor, 'kecamatan_id', CHtml::listData($modPendonor->getKecamatanItems(), 'kecamatan_id', 'kecamatan_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class'=>'span3',
                                'ajax' => array('type' => 'POST',
                                    'url' => Yii::app()->createUrl('ActionDynamic/GetKelurahan', array('encode' => false, 'model_nama' => '' . $modPendonor->getNamaModel() . '')),
                                    'update' => '#BDPendonorM_kelurahan_id')));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Kelurahan', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modPendonor, 'kelurahan_id', CHtml::listData($modPendonor->getKelurahanItems(), 'kelurahan_id', 'kelurahan_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class'=>'span3',)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Berat Badan <span class="required">*</span>', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($modPendonor, 'beratbadan_kg', array('class' => 'span3 integer required', 'readonly' => false, 'maxlength' => 3)); ?> <label>kg</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Tinggi Badan', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($modPendonor, 'tinggibadan_cm', array('class' => 'span3 integer', 'readonly' => false, 'maxlength' => 3)); ?> <label>cm</label>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <?php echo CHtml::label('No telp aktif', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($modPendonor, 'notelp_pendonor', array('class' => 'span3 numbers-only', 'readonly' => false)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('No mobile aktif <span class="required">*</span>', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($modPendonor, 'nomobile_pendonor', array('class' => 'span3 numbers-only required', 'readonly' => false)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Status Perkawinan <span class="required">*</span>', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modPendonor, 'statusperkawinan', LookupM::getItems('statusperkawinan'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'form-control span1 required')); ?>
                        </div>
                    </div>
                    <?php echo $form->radioButtonListInlineRow($modPendonor, 'gol_darah', array("A" => "A", "B" => "B", "O" => "O", "AB" => "AB"), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    <?php echo $form->radioButtonListInlineRow($modPendonor, 'rhesus', array("Positif" => "Positif", "Negatif" => "Negatif"), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>

        </div>
        <?php echo $this->renderPartial($this->path_ubah."form/_formAmbilPhoto", array('model' => $modPendonor), true); ?>
        <div class="panel-heading">
            <div class="panel-title">											

            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>

    <?php
        echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),'#', array('class'=>'btn btn-danger','onclick'=>'location.reload();'));
    ?>
    <?php
    $content = $this->renderPartial('sistemAdministrator.views.tips.transaksi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
    <?php 
        echo CHtml::link(Yii::t('mds','{icon} Cetak',array('{icon}'=>'<i class="entypo-print"></i>')),'#', array('class'=>'btn btn-succes','onclick'=>'print();'));

    
    echo "&nbsp;";
    if (isset($_GET['frame'])) {
        if (isset($_GET['sukses'])) {
           echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class'=>'btn btn-success','onclick'=>'window.history.go(-2); return false;', 'style'=>'color: white;'));   
        } else {
           echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class'=>'btn btn-success','onclick'=>'window.history.back(); return false;', 'style'=>'color: white;'));
        }    
    }
    ?>
</div>

<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_ubah.'_jsFunctions', array('modPendonor' => $modPendonor)); ?>
<script>
    function print(){
        window.open('<?php echo $this->createUrl('/bankDarah/pendaftaranDonorDarah/print',array('id'=>$modPendonor->pendonor_id)); ?>','printwin','left=100,top=100,width=640,height=480');
    }
</script>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPekerjaan',
    'options' => array(
        'title' => 'Daftar Pekerjaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 500,
        'resizable' => false,
    ),
));

$modDialogPekerjaan = new PekerjaanpendonorM('search');
$modDialogPekerjaan->unsetAttributes();

if (isset($_GET['PekerjaanpendonorM'])) {
    $modDialogPekerjaan->attributes = $_GET['PekerjaanpendonorM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pekerjaanpendonor-m-grid',
    'dataProvider' => $modDialogPekerjaan->search(),
    'filter' => $modDialogPekerjaan,
    'template' => "{summaryNonPage}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                    "id" => "selectPekerjaan",
                    "onClick" => "
                        $(\"#' . CHtml::activeId($modPendonor, 'pekerjaan_id') . '\").val($data->pekerjaanpendonor_id);
                        $(\"#' . CHtml::activeId($modPendonor, 'pekerjaan_nama') . '\").val(\"$data->pekerjaanpendonor_nama\");
                        $(\"#dialogPekerjaan\").dialog(\"close\");
                "))',
        ),
        'pekerjaanpendonor_nama',
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
        }',
));
$this->endWidget();
?>