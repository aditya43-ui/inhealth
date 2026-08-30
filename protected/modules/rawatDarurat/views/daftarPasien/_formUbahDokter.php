<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'ubahDokter-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onSubmit' => 'return requiredCheck(this);'),
        )
    );

    $arr_spesialis = [];
    $modPegawaiM = PegawaiM::model()->findAll('spesialis_id is not null and pegawai_aktif is true');
    foreach ($modPegawaiM as $ii => $data) {
        $arr_spesialis[] = $data->spesialis_id;
    }
    $arr_spesialis = array_unique($arr_spesialis);

    $condition = '';
    if(count($arr_spesialis) > 0) {
        $condition = ' and jeniskasuspenyakit_id IN (' . implode(",", $arr_spesialis) .')';
    }
?>
<p class="help-block">
    <?php echo Yii::t('mds','&nbsp;&nbsp;Fields with <span class="required">*</span> are required.') ?>
</p>
<?php echo $form->errorSummary(array($modPendaftaran,$modUbahDokter)); ?>
<?php echo $form->hiddenField($modPendaftaran, 'pendaftaran_id'); ?>
<div class="control-group">
    <?php echo CHtml::label('&nbsp;&nbsp;Tanggal Pengalihan', 'tglubahdokter', array('class'=>'control-label')) ?>
    <div class="controls">
    <?php 
    $formats = MyFormatter::formatDateTimeForDb(date('d/m/Y H:i:s')); ?>
        <?php echo CHtml::textField('tglubahdokter',$formats,array('readonly'=>true, 'class'=>'realtime' )); ?>
    </div>
</div>
<?php echo $form->textFieldRow($modPendaftaran, 'no_pendaftaran',array('readonly'=>true)); ?>
<div class="control-group">
    <?php echo CHtml::label('&nbsp;&nbsp;Nama Pasien', 'np', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo $form->hiddenField($modPendaftaran, 'pasien_id',array('readonly'=>true)); ?>
        <?php echo $form->textField($modPendaftaran, 'nama_pasien',array('readonly'=>true)); ?>
    </div>
</div>
<?php
    echo $form->dropDownListRow($modPendaftaran,'ruangan_id',
        CHtml::listData($modPendaftaran->getRuanganItems(Yii::app()->user->getState('instalasi_id')), 'ruangan_id', 'ruangan_nama'),
        array('empty'=>'-- Pilih --','disabled'=>'disabled')
    );
?>
<div class="control-group">
    <?php echo CHtml::label('&nbsp;&nbsp;Dokter Lama', 'dp', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo $form->hiddenField($modUbahDokter, 'dokterlama_id', array('readonly'=>true)); ?>
        <?php echo $form->textField($modUbahDokter, 'dokterlama_nama', array('readonly'=>true)); ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label">&nbsp;&nbsp;Spesialis</label>
    <div class="controls">
        <?= $form->dropDownList($modUbahDokter, 'spesialis_id', CHtml::listData(JeniskasuspenyakitM::model()->findAll(['condition' => 'jeniskasuspenyakit_aktif is true' . $condition, 'order' => 'jeniskasuspenyakit_nama asc']), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'), [
            'empty' => '-- Pilih --',
            'class' => 'spesialis_id',
            'onchange' => 'setDokterBaru(this)'
        ]); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('&nbsp;&nbsp;Dokter Baru', 'db', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php
			echo $form->dropDownList($modUbahDokter,'dokterbaru_id',
					CHtml::listData(
						$modPendaftaran->getDokterALL(), 'pegawai_id', 'namaLengkap'
					),
					array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class' => 'dokterbaru',
                        'onchange' => 'getSpesialis(this)' 
                    )
				);
		?>

    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('&nbsp;&nbsp;Alasan Perubahan', 'ap', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php $modUbahDokter->alasanperubahandokter = 'Disposisi'; ?>
        <?php echo $form->dropDownList($modUbahDokter,'alasanperubahandokter', Chtml::listData(LookupM::model()->findAll("lookup_type = 'alasanperubahandokter' and lookup_name = 'Disposisi'"), 'lookup_value', 'lookup_name'),  
                        array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'float:left; width:220px')); ?>   

    </div>
</div>
<div class="control-group hide">
    <?php echo CHtml::label('&nbsp;&nbsp;Keterangan', 'k', array('class'=>'control-label')) ?>
    <div class="controls">
       <?php echo $form->hiddenField($modUbahDokter,'dokterlama_id',array('class'=>'span3 ', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
       <?php echo $form->textArea($modUbahDokter,'keterangan',array('placeholder'=>'Keterangan Perubahan Dokter','rows'=>2, 'cols'=>60, 'class'=>'span3 ', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </div>
</div>

<div class="form-actions">
    <?php
        $count = UbahdokterR::model()->findAllByAttributes(['pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'create_ruangan' => Yii::app()->user->getState('ruangan_id')], 'is_approve is true');


        $dispos = count($count);

        if($dispos < 1) {
            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)'));
        } 
    ?>
	<?php
        echo CHtml::htmlButton(
			Yii::t('mds','{icon} Cancel', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
			array('class' => 'btn btn-default', 'type'=>'button','onClick'=>'closeDialog();')
		);
    ?>
</div>
<div style="line-height: 200px;">.</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    $(function(){
        var ru  = jQuery('.dokterbaru');
 
        jQuery(ru).multiselect({
                includeSelectAllOption: true,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '350px',
                enableCaseInsensitiveFiltering: true
        }).hide();

        var spesialis  = jQuery('.spesialis_id');
 
        jQuery(spesialis).multiselect({
                includeSelectAllOption: true,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '350px',
                enableCaseInsensitiveFiltering: true
        }).hide();
    })

    function loadDataPendaftaran()
    {
        var pendaftaran_id = $('#temp_idPendaftaranDP').val();
        $.post("<?php echo $this->createUrl('getDataPendaftaranRD'); ?>", { pendaftaran_id: pendaftaran_id},
            function(data){
                $('#<?php echo CHtml::activeId($modPendaftaran,"no_pendaftaran"); ?>').val(data.no_pendaftaran);
                $('#<?php echo CHtml::activeId($modPendaftaran,"pendaftaran_id"); ?>').val(data.pendaftaran_id);
                $('#np').val(data.nama_pasien);
                $('#<?php echo CHtml::activeId($modPendaftaran,"ruangan_id"); ?>').val(data.ruangan_id);
                var dokter = data.gelardepan + " " + data.nama_pegawai + " " + data.gelarbelakang_nama;
                $('#dp').val(dokter);
				$('#RDUbahdokterR_dokterlama_id').val(data.pegawai_id);
                listDokterRuangan(data.ruangan_id);
            },
        "json");
    }
    loadDataPendaftaran();
    
    function listDokterRuangan(idRuangan)
    {
        $.post("<?php echo $this->createUrl('listDokterRuangan')?>", { idRuangan: idRuangan },
            function(data){
                $('#<?php echo CHtml::activeId($modPendaftaran,"pegawai_id"); ?>').html(data.listDokter);
        }, "json");
    }    
	function closeDialog(){
		window.parent.$('#editDokterPeriksa').dialog('close');
	}

    function setDokterBaru(obj) { 
        var jeniskasuspenyakit_id = $(obj).val();

        $.post('<?= $this->createUrl('setDokterBaru') ?>', {
            jeniskasuspenyakit_id:jeniskasuspenyakit_id
        }, function(data){
            $('.dokterbaru').html(data.option);
            $('.dokterbaru').multiselect('rebuild');
        }, 'json');

    }

    function getSpesialis(obj) {
        var pegawai_id = $(obj).val();

        $.get('<?= $this->createUrl('SetSpesialis') ?>', {
            pegawai_id:pegawai_id
        }, function(data){
            if(data.spesialis_id != '') {
                $('.spesialis_id').val(data.spesialis_id);
                $('.spesialis_id').multiselect('refresh');
            }
        }, 'json');
    }
</script>