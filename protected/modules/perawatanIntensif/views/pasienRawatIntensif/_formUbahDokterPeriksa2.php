<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'ubahdokterdpjp-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        )
    );
?>
<p class="help-block">
    <?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?>
</p>
<?php echo $form->errorSummary(array($model,$modUbahDokter)); ?>
<?php echo $form->hiddenField($model, 'pendaftaran_id',array('readonly'=>true)); ?>
<?php echo $form->hiddenField($model, 'pasienadmisi_id',array('readonly'=>true)); ?>
<?php echo $form->textFieldRow($model, 'no_pendaftaran',array('readonly'=>true)); ?>
<div class="control-group">
    <?php echo CHtml::label('Nama Pasien', 'np', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('np','np',array('readonly'=>true)); ?>
    </div>
</div>
<?php
    echo $form->dropDownListRow($model,'ruangan_id',
        CHtml::listData($model->getRuanganItems(Yii::app()->user->getState('instalasi_id')), 'ruangan_id', 'ruangan_nama'),
        array('empty'=>'-- Pilih --','disabled'=>'disabled')
    );
?>
<?php /*
<div class="control-group">
    <?php echo CHtml::label('Dokter Lama', 'dp', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('dp','dp',array('readonly'=>true)); ?>
    </div>
</div>
 * 
 */ ?>
<div class="control-group">
    <?php echo CHtml::label('DPJP 1', 'db', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php
                echo $form->hiddenField($model, 'pegawai_id[pegawai_id]', array('id'=>'dpjp1_id'));
                    $this->widget('MyJuiAutoComplete', array(
                        'name'=>'dpjp1',
                        'source'=>'js: function(request, response) {
                            $.ajax({
                            url: "'.$this->createUrl('pendaftaranRawatInap/getDokterDPJP').'",
                            dataType: "json",
                            data: {
                                term: request.term,
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }',
                    'options'=>array(
                        'showAnim'=>'fold',
                        'minLength' => 2,
                        'focus'=> 'js:function( event, ui ) {
                             $(this).val( ui.item.label);
                             return false;
                         }',
                        'select'=>'js:function( event, ui ) {
                             $("#dpjp1_id").val(ui.item.value); 
                             return false;
                         }',
                    ),
                    'tombolDialog'=>array(
                        'idDialog'=>'dialogDokterDPJP',
                        'jsFunction'=>'admisi_dokter_id = "#dpjp1_id"; admisi_dokter_label = "#dpjp1"; tampilTabDokter(true);',
                    ),
                )); 
            /*
			echo $form->dropDownList($model,'pegawai_id',
					CHtml::listData(
						$model->getDokterItems($model->ruangan_id), 'pegawai_id', 'nama_pegawai'
					),
					array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)")
				);
             * 
             */
		?>

    </div>
</div>

<div class="control-group">
    <?php echo CHtml::label('DPJP 2', 'db', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php
                echo $form->hiddenField($model, 'pegawai_id[dpjp2_id]', array('id'=>'dpjp2_id'));
                    $this->widget('MyJuiAutoComplete', array(
                        'name'=>'dpjp2',
                        'source'=>'js: function(request, response) {
                            $.ajax({
                            url: "'.$this->createUrl('pendaftaranRawatInap/getDokterDPJP').'",
                            dataType: "json",
                            data: {
                                term: request.term,
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }',
                    'options'=>array(
                        'showAnim'=>'fold',
                        'minLength' => 2,
                        'focus'=> 'js:function( event, ui ) {
                             $(this).val( ui.item.label);
                             return false;
                         }',
                        'select'=>'js:function( event, ui ) {
                             $("#dpjp1_id").val(ui.item.value); 
                             return false;
                         }',
                    ),
                    'tombolDialog'=>array(
                        'idDialog'=>'dialogDokterDPJP',
                        'jsFunction'=>'admisi_dokter_id = "#dpjp2_id"; admisi_dokter_label = "#dpjp2"; tampilTabDokter(true);',
                    ),
                )); 
            /*
			echo $form->dropDownList($model,'pegawai_id',
					CHtml::listData(
						$model->getDokterItems($model->ruangan_id), 'pegawai_id', 'nama_pegawai'
					),
					array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)")
				);
             * 
             */
		?>

    </div>
</div>

<div class="control-group">
    <?php echo CHtml::label('DPJP 3', 'db', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php
                echo $form->hiddenField($model, 'pegawai_id[dpjp3_id]', array('id'=>'dpjp3_id'));
                    $this->widget('MyJuiAutoComplete', array(
                        'name'=>'dpjp3',
                        'source'=>'js: function(request, response) {
                            $.ajax({
                            url: "'.$this->createUrl('pendaftaranRawatInap/getDokterDPJP').'",
                            dataType: "json",
                            data: {
                                term: request.term,
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }',
                    'options'=>array(
                        'showAnim'=>'fold',
                        'minLength' => 2,
                        'focus'=> 'js:function( event, ui ) {
                             $(this).val( ui.item.label);
                             return false;
                         }',
                        'select'=>'js:function( event, ui ) {
                             $("#dpjp1_id").val(ui.item.value); 
                             return false;
                         }',
                    ),
                    'tombolDialog'=>array(
                        'idDialog'=>'dialogDokterDPJP',
                        'jsFunction'=>'admisi_dokter_id = "#dpjp3_id"; admisi_dokter_label = "#dpjp3"; tampilTabDokter(true);',
                    ),
                )); 
            /*
			echo $form->dropDownList($model,'pegawai_id',
					CHtml::listData(
						$model->getDokterItems($model->ruangan_id), 'pegawai_id', 'nama_pegawai'
					),
					array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)")
				);
             * 
             */
		?>

    </div>
</div>

<div class="control-group">
    <?php echo CHtml::label('Alasan Perubahan', 'ap', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo $form->textArea($modUbahDokter,'alasanperubahandokter', 
                        array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3', 'cols'=>60, 'rows'=>2, 'style'=>'float:left; width:220px')); ?>   

    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Keterangan', 'k', array('class'=>'control-label')) ?>
    <div class="controls">
       <?php echo $form->hiddenField($modUbahDokter,'dokterlama_id',array('class'=>'span3 ', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
       <?php echo $form->textArea($modUbahDokter,'keterangan',array('placeholder'=>'Keterangan Perubahan Dokter','rows'=>2, 'cols'=>60, 'class'=>'span3 ', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </div>
</div>

<div class="form-actions">
    <?php
        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)'));
    ?>
	<?php
        echo CHtml::htmlButton(
			Yii::t('mds','{icon} Cancel', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
			array('class' => 'btn btn-default', 'type'=>'button','onClick'=>'closeDialog();')
		);
    ?>
</div>
<?php $this->endWidget(); ?>



<script type="text/javascript">
    
    admisi_dokter_id = null;
    admisi_dokter_label = null;
    
    function tampilTabDokter(status) {
        if (status) {
            $("#dialog-dpjp-m-grid").show();
            $("#ubahdokterdpjp-form").hide();
        } else {
            $("#dialog-dpjp-m-grid").hide();
            $("#ubahdokterdpjp-form").show();
        }
    }
    
    function setDokterAdmisi(label, value) {
        $(admisi_dokter_id).val(value);
        $(admisi_dokter_label).val(label);
        tampilTabDokter(false);
    }
    
    
    function loadDataPendaftaran()
    {
        var pendaftaran_id = $('#temp_idPendaftaranDP').val();
        var pasienadmisi_id = $('#temp_idPasienadmisiDP').val();
        $.post("<?php echo $this->createUrl('GetDataPendaftaranPI2'); ?>", { pendaftaran_id: pendaftaran_id,pasienadmisi_id:pasienadmisi_id },
            function(data){
                $('#PIPendaftaranT_no_pendaftaran').val(data.no_pendaftaran);
                $('#PIPendaftaranT_pendaftaran_id').val(data.pendaftaran_id);
                $('#PIPendaftaranT_pasienadmisi_id').val(data.pasienadmisi_id);
                $('#np').val(data.nama_pasien);
                $('#PIPendaftaranT_ruangan_id').val(data.ruangan_id);
                var dokter = data.gelardepan + " " + data.nama_pegawai + " " + data.gelarbelakang_nama;
                $('#dp').val(dokter);
				// $('#RIUbahdokterR_dokterlama_id').val(data.pegawai_id);
                $("#dpjp1_id").val(data.dpjp1_id);
                $("#dpjp1").val(data.dpjp1);
                $("#dpjp2_id").val(data.dpjp2_id);
                $("#dpjp2").val(data.dpjp2);
                $("#dpjp3_id").val(data.dpjp3_id);
                $("#dpjp3").val(data.dpjp3);
                // listDokterRuangan(data.ruangan_id);
                
                
                jQuery('#dpjp1').autocomplete(
                {
                    'showAnim':'fold',
                    'minLength':2,
                    'focus':function( event, ui ){
                        $(this).val( ui.item.label);
                        return false;
                    },
                    'select':function( event, ui ){
                        $("#dpjp1_id").val(ui.item.value); 
                        return false;
                    },
                    'source':'<?php echo $this->createUrl('getDokterDPJP'); ?>'
                });
                
                jQuery('#dpjp2').autocomplete(
                {
                    'showAnim':'fold',
                    'minLength':2,
                    'focus':function( event, ui ){
                        $(this).val( ui.item.label);
                        return false;
                    },
                    'select':function( event, ui ){
                        $("#dpjp2_id").val(ui.item.value); 
                        return false;
                    },
                    'source':'<?php echo $this->createUrl('getDokterDPJP'); ?>'
                });
                
                jQuery('#dpjp3').autocomplete(
                {
                    'showAnim':'fold',
                    'minLength':2,
                    'focus':function( event, ui ){
                        $(this).val( ui.item.label);
                        return false;
                    },
                    'select':function( event, ui ){
                        $("#dpjp3_id").val(ui.item.value); 
                        return false;
                    },
                    'source':'<?php echo $this->createUrl('getDokterDPJP'); ?>'
                });
            },
        "json");
    }
    loadDataPendaftaran();
    
    function listDokterRuangan(idRuangan)
    {
        $.post("<?php echo $this->createUrl('listDokterRuangan')?>", { idRuangan: idRuangan },
            function(data){
                $('#PIPendaftaranT_pegawai_id').html(data.listDokter);
        }, "json");
    }    
	function closeDialog(){
		window.parent.$('#editDokterPeriksa2').dialog('close');
	}
</script>