<?php
$readonly = TRUE;
?>
<div class="span6">
    <?php echo CHtml::hiddenField('sep_id', $modInfoKunjungan->sep_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    <?php echo CHtml::hiddenField('tglsep', '', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    <?php echo CHtml::hiddenField('jnspelayanan', '', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    <?php echo CHtml::hiddenField('pendaftaran_id', $modInfoKunjungan->pendaftaran_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    
    <div class="control-group">
        <?php echo CHtml::label("Instalasi <font style=color:red;> * </font>", 'no_pendaftaran', array('class' => 'control-label required')); ?>
        <div class="controls">
            <?php 
            echo CHtml::dropDownList('instalasi_id', $modInfoKunjungan->instalasi_id, CHtml::listData(InstalasiM::model()->getDropInsPelayanan(), 'instalasi_id', 'instalasi_nama'), array('empty' => '--Pilih--', 'onchange' => 'refreshDialogInfoPasien();setInfoPasienReset();', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event)",));
            // echo $form->dropDownList($modInfoKunjungan, 'jenispelayanan_bpjs',  array('2' => 'Rawat Jalan', '1' => 'Rawat Inap'), array('empty' => '--Pilih--', 'class' => 'span3 required')); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("No. SEP <font style=color:red;> * </font>", 'no_pendaftaran', array('class' => 'control-label required')); ?>
        <div class="controls">
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'name' => 'nosep',
                'value' => $modInfoKunjungan->nama_pasien,
                'source' => 'js: function(request, response) {
                        $.ajax({
                                url: "' . $this->createUrl('GetDataInfoSEP') . '",
                                dataType: "json",
                                data: {
                                    nosep: request.term,
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
                            $(this).val(ui.item.nosep);
                            $("#sep_id").val(ui.item.sep_id);
                            $("#no_pendaftaran").val(ui.item.no_pendaftaran);
                            $("#no_rekam_medik").val(ui.item.no_rekam_medik);
                            $("#tgl_pendaftaran").val(ui.item.tgl_pendaftaran);
                            $("#pendaftaran_id").val(ui.item.pendaftaran_id);
                            $("#nama_pasien").val(ui.item.nama_pasien);
                            $("#tanggal_lahir").val(ui.item.tanggal_lahir);
                            $("#jeniskelamin").val(ui.item.jeniskelamin);
                            $("#alamat_pasien").val(ui.item.alamat_pasien);
                            $("#tglsep").val(ui.item.tglsep);
                            $("#nosep2").val(ui.item.nosep);    
                            $("#jnspelayanan").val(ui.item.jnspelayanan); 
                            return false;
                        }',
                ),
                'tombolDialog' => array('idDialog' => 'dialogPasien'),
                'htmlOptions' => array(
                    'placeholder' => 'Ketik NO Sep', 'rel' => 'tooltip', 'title' => 'Ketik nama pasien untuk mencari data kunjungan',
                    'onkeyup' => "return $(this).focusNextInputField(event)",
                    'class' => "required"
                ),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("No. Pendaftaran <font style=color:red;> * </font>", 'no_pendaftaran', array('class' => 'control-label required')); ?>
        <div class="controls">
            <?php
            echo CHtml::textField('no_pendaftaran', $modInfoKunjungan->no_pendaftaran, array('class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => $readonly));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("No. Rekam Medik <font style=color:red;> * </font>", 'no_rekam_medik required', array('class' => 'control-label required')); ?>
        <div class="controls">
            <?php
            echo CHtml::textField('no_rekam_medik', $modInfoKunjungan->no_rekam_medik, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => $readonly));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Tgl. Pendaftaran', 'tgl_pendaftaran', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('tgl_pendaftaran', $modInfoKunjungan->tgl_pendaftaran, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php //echo CHtml::hiddenField('tglselesaiperiksa',$modInfoKunjungan->tglselesaiperiksa,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('No. Peserta', 'nosep', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('nosep', $modInfoKunjungan->nosep, array('readonly' => true, 'class' => 'span3', 'id' =>'nosep2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>
<div class="span6">
    <div class="control-group">
        <?php echo CHtml::label("Nama Pasien <font style=color:red;> * </font>", 'nama_pasien', array('class' => 'control-label required')); ?>
        <div class="controls">
            <?php
            echo CHtml::textField('nama_pasien', $modInfoKunjungan->nama_pasien, array('class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => $readonly));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Tanggal Lahir', 'tanggal_lahir', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('tanggal_lahir', $modInfoKunjungan->tanggal_lahir, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Jenis Kelamin", 'jeniskelamin', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('jeniskelamin', $modInfoKunjungan->jeniskelamin, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Alamat Pasien", 'alamat_pasien', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php 
            echo CHtml::textArea('alamat_pasien', $modInfoKunjungan->alamat_pasien, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>

<?php

//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Data SEP Pasien <span class="instalasiNama"></span>',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 480,
        'resizable' => false,
    ),
));
$modDialogKunjungan = new PPPencarianseprujukankeluarV('searchDialog');
$modDialogKunjungan->unsetAttributes();
//$modDialogKunjungan->tglsep = date('Y-m-d');
//$modDialogKunjungan->tglsep = date('d/m/Y') . ' - ' . date('d/m/Y');
if (isset($_GET['PPPencarianseprujukankeluarV'])) {
    
    $modDialogKunjungan->attributes = $_GET['PPPencarianseprujukankeluarV'];
    $modDialogKunjungan->instalasi_nama = $_GET['PPPencarianseprujukankeluarV']['instalasi_nama'];
    
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'datakunjungan-grid',
    'dataProvider' => $modDialogKunjungan->searchDialog(),
    'filter' => $modDialogKunjungan,
    'template' => "{summaryNonPage}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data){
                return CHtml::Link("<i class='icon-form-check'></i>","javascript:void(0);",array("class"=>"btn-small", 
                    "id" => "selectPendaftaran",
                    "onClick" => '
                            $("#nosep").val("'.$data->nosep.'");
                            $("#nosep2").val("'.$data->nokartuasuransi.'");
                            $("#sep_id").val("'.$data->sep_id.'");
                            $("#no_pendaftaran").val("'.$data->no_pendaftaran.'");
                            $("#no_rekam_medik").val("'.$data->no_rekam_medik.'");
                            $("#tgl_pendaftaran").val("'.$data->tgl_pendaftaran.'");
                            $("#pendaftaran_id").val("'.$data->pendaftaran_id.'");
                            $("#nama_pasien").val("'.$data->nama_pasien.'");
                            $("#tanggal_lahir").val("'.$data->tanggal_lahir.'");
                            $("#jeniskelamin").val("'.$data->jeniskelamin.'");
                            $("#alamat_pasien").val("'.$data->alamat_pasien.'");
                            $("#tglsep").val("'.(date("d/m/Y H:i:s", strtotime($data->tglsep))).'");
                            $("#jnspelayanan").val("'.$data->jnspelayanan.'");
                            $("#dialogPasien").dialog("close");
                    '));
            },
        ),
        'nosep',
        'no_pendaftaran',
        array(
            'header' => 'Tanggal SEP',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglsep)',
            'filter' => false,
            //CHtml::activeTextField($modDialogKunjungan, 'tglsep', array('class' => 'span3', 'readonly' => true)),
            /*$this->widget('MyDateTimePicker', array(
                'model' => $modDialogKunjungan,
                'attribute' => 'tglsep',
                'mode' => 'date', //date / datetime
                'gridFilter' => true,
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array('readonly' => true, 'class' => "span2",
                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ), true),*/
        ),
        array(
            'name' => 'no_rekam_medik',
            'type' => 'raw',
            'value' => '$data->no_rekam_medik',
        ),
        'nama_pasien',
        'instalasi_nama',
        array(
            'name' => 'jeniskelamin',
            'type' => 'raw',
            'filter' => LookupM::model()->getItems('jeniskelamin'),
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){
				jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
//				jQuery("#' . CHtml::activeId($modDialogKunjungan, 'tglsep') . '").datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional["id"], {"dateFormat":"dd M yy","maxDate":"d","timeText":"Waktu","hourText":"Jam","minuteText":"Menit","secondText":"Detik","showSecond":true,"timeOnlyTitle":"Pilih Waktu","timeFormat":"hh:mm:ss","changeYear":true,"changeMonth":true,"showAnim":"fold","yearRange":"-80y:+20y"}));
//				jQuery("#' . CHtml::activeId($modDialogKunjungan, 'tglsep') . '_date").on("click", function(){jQuery("#' . CHtml::activeId($modDialogKunjungan, 'tgl_pendaftaran') . '").datepicker("show");});
                                jQuery("#' . CHtml::activeId($modDialogKunjungan, 'tglsep') . '").daterangepicker({
                                    // "maxDate": "' . date('m/d/Y') . '",
                                    "showDropdowns": true,
                                });
			}',
));

$this->endWidget();
////======= end pendaftaran dialog =============
?>
<script>
    $(document).ready(function() {
        $('input[name="PPPencarianseprujukankeluarV[tglsep]"]').daterangepicker({
            "maxDate": "<?php echo date('m/d/Y') ?>",
            "showDropdowns": true,
        });
    });
</script>