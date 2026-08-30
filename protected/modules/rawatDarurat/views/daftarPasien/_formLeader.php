<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'formLeader-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
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
    <?php echo Yii::t('mds','Yang bertanda tangan dibawah ini : ') ?>
</p>
<?php echo $form->errorSummary(array($modPendaftaran,$modAlihLeader)); ?>
<?php echo $form->hiddenField($modPendaftaran, 'pendaftaran_id'); ?>
<?php echo CHtml::hiddenField('formalihleader', true); ?>

<div class="control-group">
    <?php echo CHtml::label('&nbsp;&nbsp;Nama', 'dokterlama_nama', array('class'=>'control-label')) ?>
    <div class="controls">

    <?php echo $form->hiddenField($modAlihLeader,'dokterlama_id',array('class'=>'span3 ', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>

    <?php echo $form->textField($modAlihLeader, 'dokterlama_nama', array('readonly'=>true)); ?>
     
    </div>
</div>

<div class="control-group">
    <?php echo CHtml::label('&nbsp;&nbsp;Subspesialis', 'spesialissubspesialis_nama', array('class'=>'control-label')) ?>
    <div class="controls">

    <?php echo $form->hiddenField($modPendaftaran,'spesialissubspesialis_id',array('class'=>'span3 ', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>

    <?php echo $form->textField($modAlihLeader, 'spesialissubspesialis_nama',array('readonly'=>true)); ?>
     
    </div>
</div>
<p> Selaku Dokter DPJP dari Pasien :</p>
<!-- bio pasien -->
<div class="control-group">
    <?php echo CHtml::label('&nbsp;&nbsp;Nama Pasien', 'np', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo $form->hiddenField($modPendaftaran, 'pasien_id',array('readonly'=>true)); ?>
        <?php echo $form->textField($modPendaftaran, 'nama_pasien',array('readonly'=>true)); ?>
    </div>
</div>

<div class="control-group">
    <?php echo CHtml::label('&nbsp;&nbsp;Alamat', 'alamat', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo $form->textArea($modPendaftaran, 'alamat_pasien', array('readonly'=>true)); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('&nbsp;&nbsp;Ruang Rawat', 'rawat', array('class'=>'control-label')) ?>
    <div class="controls">
    <?php echo $form->hiddenField($modPendaftaran,'ruangan_id',array('class'=>'span3 ', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textField($modPendaftaran, 'ruangan_nama',array('readonly'=>true)); ?>
   
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('&nbsp;&nbsp;Nomor Rekam Medik', 'no_rekam_medik', array('class'=>'control-label')) ?>
    <div class="controls">
    <?php echo $form->textField($modPendaftaran, 'no_rekam_medik', array('readonly'=>true)); ?>
    </div>
</div>
<p> Melimpahkan tanggung jawab perawatan pasien tersebut di atas kepada : </p>
<!-- dpjp baru -->

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
    <?php echo CHtml::label('&nbsp;&nbsp;Nama', 'dokterbaru_nama', array('class'=>'control-label')) ?>
    <div class="controls">

        <?php
			echo $form->dropDownList($modAlihLeader,'dokterbaru_id',
					CHtml::listData(
						PegawaiM::model()->findAll('kelompokpegawai_id = 1'), 'pegawai_id', 'namaLengkap'
					),
					array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'onchange' => 'getSpesialis(this)', 'class' => 'dokterbaru', 'style' => 'widht:300px !important')
				);
		?>
        
    </div>
</div>

<div class="control-group hide">
    <?php echo CHtml::label('&nbsp;&nbsp;Subspesialis', 'instalasi_nama', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo $form->hiddenField($modAlihLeader, 'spesialissubspesialis_id',array('readonly'=>true, 'id' => 'spesialissubspesialis_id')); ?>
        <?php echo $form->textField($modAlihLeader, 'subspesialis_baru',array('readonly'=>true, 'id' => 'subspesialis_baru')); ?>
    </div>
</div>

<div class="control-group">
    <?php echo CHtml::label('&nbsp;&nbsp;Tanggal Pelimpahan', 'instalasi_nama', array('class'=>'control-label')) ?>
    <div class="controls">
    <?php 
    $formats = MyFormatter::formatDateTimeForDb(date('d/m/Y H:i:s')); ?>
        <?php echo CHtml::textField('tglubahdokter',$formats,array('readonly'=>true, 'class'=>'realtime' )); ?>
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
<div style="line-height: 200px;">.</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function setSubspesialis(obj) {
        var pegawai_id = $(obj).val();
        console.log(pegawai_id);
        $.post(
            '<?= $this->createUrl('getSubSpesialis') ?>',
            {
                pegawai_id:pegawai_id
            },
            function(data) {
                if(data.sukses == 1 ) {
                    $('#subspesialis_baru').val(data.spesialissubspesialis_nama);
                    $('#spesialissubspesialis_id').val(data.spesialissubspesialis_id);
                }
            },
            'json'

        );
    }

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
</script>