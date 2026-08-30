<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'ubahDokter-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        )
    );

    $this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i>
           Ubah DPJP
        </div>
    </div>
    <div class="panel-body">
        
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
            <?php echo CHtml::label('&nbsp;&nbsp;Dokter Baru', 'db', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php
                    echo $form->dropDownList($modUbahDokter,'dokterbaru_id',
                            CHtml::listData(
                                $modPendaftaran->getDokterKondisi(), 'pegawai_id', 'namaLengkap'
                            ),
                            array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class' => 'dokterbaru')
                        );
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
        
    </div>
</div>
<?php $this->endWidget(); ?>


<script type="text/javascript">
    
    $(function(){
        var ru  = jQuery('.dokterbaru');
 
        jQuery(ru).multiselect({
                includeSelectAllOption: true,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '182px',
                enableCaseInsensitiveFiltering: true
        }).hide();
    })
    
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