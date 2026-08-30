<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'ubahKelPenyakit2-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        )
    );
?>

<script type="text/javascript">
function getDate(){
   var todaydate = new Date();
   var day = todaydate.getDate();
   var month = todaydate.getMonth() + 1;
   var year = todaydate.getFullYear();
   var second = todaydate.getSeconds();
   var minute =  todaydate.getMinutes();
   var hour = todaydate.getHours();
   var datestring = day + "-" + month + "-" + year + "\n " + hour + ":"+ minute+":"+second ;
   document.getElementById("frmDate").value = datestring;
  } 
getDate();
</script>


<p class="help-block">
    <?php echo Yii::t('mds','&nbsp;&nbsp;Fields with <span class="required">*</span> are required.') ?>
</p>
<?php echo $form->errorSummary(array($model,$modUbahDokter)); ?>
<div class="control-group">
    <?php echo CHtml::label('&nbsp;&nbsp;Tanggal Pengalihan','tglubahdokter', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo $form->textField($modUbahDokter, 'tglubahdokter',array('id'=>'frmDate','style'=>'white-space: nowrap;','readonly'=>true)); ?>
    </div>
</div>
<?php echo $form->hiddenField($model, 'pendaftaran_id',array('readonly'=>true)); ?>
<?php echo $form->hiddenField($model, 'pasienadmisi_id',array('readonly'=>true)); ?>
<div class="control-group">
    <?php echo CHtml::label('&nbsp;&nbsp;Nomor Pendaftaran <span class="required">*</span>', 'no_pendaftaran', array('class'=>'control-label required')) ?>
<div class="controls">
<?php echo $form->textField($model, 'no_pendaftaran',array('style'=>'white-space: nowrap;','readonly'=>true)); ?>
</div>
</div>
<div class="control-group">
    <?php echo CHtml::label('&nbsp;&nbsp;Nama Pasien', 'np', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo $form->textField($modPasien, 'nama_pasien',array('readonly'=>true)); ?>
    </div>
</div>
<?php
    echo $form->dropDownListRow($model,'ruangan_id',
        CHtml::listData($model->getRuanganItems(Yii::app()->user->getState('instalasi_id')), 'ruangan_id', 'ruangan_nama'),
        array('empty'=>'-- Pilih --','disabled'=>'disabled')
    );
?>

<div class="control-group">
    <?php echo CHtml::label('&nbsp;&nbsp;DPJP 1', 'db', array('class'=>'control-label')) ?>
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
    <?php echo CHtml::label('&nbsp;&nbsp;DPJP 2', 'db', array('class'=>'control-label')) ?>
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
    <?php echo CHtml::label('&nbsp;&nbsp;DPJP 3', 'db', array('class'=>'control-label')) ?>
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
    <?php echo CHtml::label('&nbsp;&nbsp;DPJP 4', 'db', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php
                echo $form->hiddenField($model, 'pegawai_id[dpjp4_id]', array('id'=>'dpjp4_id'));
                    $this->widget('MyJuiAutoComplete', array(
                        'name'=>'dpjp4',
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
                        'jsFunction'=>'admisi_dokter_id = "#dpjp4_id"; admisi_dokter_label = "#dpjp4"; tampilTabDokter(true);',
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
    <?php echo CHtml::label('&nbsp;&nbsp;DPJP 5', 'db', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php
                echo $form->hiddenField($model, 'pegawai_id[dpjp5_id]', array('id'=>'dpjp5_id'));
                    $this->widget('MyJuiAutoComplete', array(
                        'name'=>'dpjp5',
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
                        'jsFunction'=>'admisi_dokter_id = "#dpjp5_id"; admisi_dokter_label = "#dpjp5"; tampilTabDokter(true);',
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
    <?php echo CHtml::label('&nbsp;&nbsp;Alasan Perubahan', 'ap', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo $form->dropDownList($modUbahDokter,'alasanperubahandokter', Chtml::listData(LookupM::model()->findAll("lookup_type = 'alasanperubahandokter' and lookup_name != 'Disposisi'"), 'lookup_value', 'lookup_name'),  
                        array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'float:left; width:220px')); ?>   

    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('&nbsp;&nbsp;Keterangan', 'k', array('class'=>'control-label')) ?>
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

<?php 
$this->renderPartial('_dialogDPJP', ['modAdmisi' => $modAdmisi]);
?>

<script type="text/javascript">
    
    admisi_dokter_id = null;
    admisi_dokter_label = null;
    
    function tampilTabDokter(status) {
        console.log(status)
        $('#dialogDokterDPJP').dialog("open");
       
    }
    
    function setDokterAdmisi(label, value) {
        $(admisi_dokter_id).val(value);
        $(admisi_dokter_label).val(label);
        // tampilTabDokter(false);
        $('#dialogDokterDPJP').dialog("close");

    }
    
    
    function loadDataPendaftaran()
    {
        var pendaftaran_id = <?= $model->pendaftaran_id ?? '' ?>;
        var pasienadmisi_id = <?= $model->pasienadmisi_id ?? '' ?>;
        $.post("<?php echo $this->createUrl('getDataPendaftaranRI'); ?>", { pendaftaran_id: pendaftaran_id,pasienadmisi_id:pasienadmisi_id },
            function(data){

                $('#RIPendaftaranT_ruangan_id').val(data.ruangan_id);
                var dokter = data.gelardepan + " " + data.nama_pegawai + " " + data.gelarbelakang_nama;
                $('#dp').val(dokter);
				// $('#RIUbahdokterR_dokterlama_id').val(data.pegawai_id);
                $("#dpjp1_id").val(data.dpjp1_id);
                $("#dpjp1").val(data.dpjp1);
                $("#dpjp2_id").val(data.dpjp2_id);
                $("#dpjp2").val(data.dpjp2);
                $("#dpjp3_id").val(data.dpjp3_id);
                $("#dpjp3").val(data.dpjp3);
                $("#dpjp4_id").val(data.dpjp4_id);
                $("#dpjp4").val(data.dpjp4);
                $("#dpjp5_id").val(data.dpjp5_id);
                $("#dpjp5").val(data.dpjp5);
                
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

                jQuery('#dpjp4').autocomplete(
                {
                    'showAnim':'fold',
                    'minLength':2,
                    'focus':function( event, ui ){
                        $(this).val( ui.item.label);
                        return false;
                    },
                    'select':function( event, ui ){
                        $("#dpjp4_id").val(ui.item.value); 
                        return false;
                    },
                    'source':'<?php echo $this->createUrl('getDokterDPJP'); ?>'
                });

                    jQuery('#dpjp5').autocomplete(
                {
                    'showAnim':'fold',
                    'minLength':2,
                    'focus':function( event, ui ){
                        $(this).val( ui.item.label);
                        return false;
                    },
                    'select':function( event, ui ){
                        $("#dpjp5_id").val(ui.item.value); 
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
                $('#RIPendaftaranT_pegawai_id').html(data.listDokter);
        }, "json");
    }    
	function closeDialog(){
		window.parent.$('#editDokterPeriksa').dialog('close');
	}
</script>