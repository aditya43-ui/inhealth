<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'penyedia-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions' => array(
            'enctype'=>'multipart/form-data',
            'onKeyPress' => 'return disableKeyPress(event)'
            ),
	'focus'=>'#',
)); ?>
<div class="panel panel-success">
    <div class="panel panel-heading">
        <div class="panel-title"> Tambah <b> Penyedia </b> </div>
    </div>
    <div class="panel-body">
	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">
            <div class="col-md-6">
                <?php echo $form->textFieldRow($model,'penyedia_nama',array('disabled' => true, 'class'=>'span3 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?> 
                <?php echo $form->textFieldRow($model,'penyedia_namalain',array('disabled' => true, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
                <?php echo $form->dropDownListRow($model,'penyedia_jenis', LookupM::getItems('jenissupplier'),
                    array('class' => 'span3 required', 'disabled' => true ,'onclick' => 'cekPBF(this);', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                <div class="pbf">
                    <div class="control-group">
                        <?php echo CHtml::label("Perusahaan Besar Farmasi","",array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php 
                                echo $form->hiddenField($model, 'pbf_id', array('readonly' => true)); 
                                if (!empty($model->pbf_id)) {
                                    $pbf = PbfM::model()->findByPk($model->pbf_id);
                                    $model->pbf_nama = $pbf->pbf_nama;
                                    echo $form->textField($model, 'pbf_nama', array('readonly' => true, 'class' => 'span3'));  
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <br>
                <?php echo $form->textAreaRow($model,'penyedia_alamat',array('disabled' => true, 'rows'=>6, 'cols'=>50, 'class'=>'span3 required', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                
                <?php echo $form->dropDownListRow($model,'penyedia_propinsi', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), 
                                          array('empty'=>'-- Pilih --', 'disabled' => true, 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                'ajax'=>array('type'=>'POST',
                                                              'url'=>Yii::app()->createUrl('pengadaan/penyediaM/setDropdownKabupaten',array('encode'=>false,'namaModel'=>'PenyediaM')),
                                                              'update'=>'#PenyediaM_penyedia_kabupaten'))); ?>
                
                <?php echo $form->dropDownListRow($model,'penyedia_kabupaten', array(), 
                                          array('empty'=>'-- Pilih --', 'disabled' => true, 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                'ajax'=>array('type'=>'POST', 
                                                              'url'=>Yii::app()->createUrl('ActionDynamic/GetKecamatan',array('encode'=>false,'namaModel'=>'PenyediaM'))))); ?>
                
                <?php echo $form->textFieldRow($model,'penyedia_kodepos',array('disabled' => true, 'class'=>'span3 required numbers-only', 'max-length' => 5, 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>5)); ?>
            </div>
            <div class="col-md-6">
                <?php echo $form->textFieldRow($model,'penyedia_kode',array('disabled' => true, 'class'=>'span3', 'disabled' => true, 'placeholder' => '-- Otomatis --' ,'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>12)); ?>
                
                <?php echo $form->textFieldRow($model,'penyedia_telepon',array('disabled' => true, 'class'=>'span3 required numbers-only', 'max-length' => 13, 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>12)); ?>
                
                <?php echo $form->textFieldRow($model,'penyedia_fax',array('disabled' => true, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>12)); ?>
                
                <?php echo $form->textFieldRow($model,'penyedia_website',array('disabled' => true, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>250)); ?>
                
                <?php echo $form->textFieldRow($model,'penyedia_email',array('disabled' => true, 'class'=>'span3 required', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                
                <?php echo $form->textFieldRow($model,'penyedia_norekening',array('disabled' => true, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                
                <?php echo $form->textFieldRow($model,'penyedia_direktur',array('disabled' => true, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
                
                <?php echo $form->textFieldRow($model,'penyedia_cp',array('disabled' => true, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
                
                <?php echo $form->textFieldRow($model,'penyedia_jabatancp',array('disabled' => true, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>150)); ?>
               
                <?php echo $form->textFieldRow($model,'penyedia_nomobilecp',array('disabled' => true, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>16)); ?>

                <?php echo $form->checkBoxRow($model,'penyedia_aktif', array('disabled' => true, 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
	</div>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel panel-heading">
        <div class="panel-title"> <b> Dokumen Pendukung Penyedia </b> </div>
    </div>
    <div class="panel-body" >
        <i><label ><span class="required">Maksimal Ukuran file adalah 200kb/2mb</span></label></i>

        <table class="table table-bordered table-striped table-condensed" id="dokPendukung">
            <thead>
                <tr>
                    <th style="text-align: center;">Jenis Dokumen</th>
                    <th style="text-align: center;">Nomor Dokumen</th>
                    <th style="text-align: left;">File</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($modDetail as $det){?>
                <tr>
                    <td> <label> <?php echo $det->jenis_dokumen; ?> </label> </td>
                    <td> <?php echo $det->nomor_dokumen; ?></td>
                    <td> <?php echo CHtml::link("$det->pengadaandokumenpenyedia_file", $this->createUrl('Unduh', array('id' => $det->pengadaandokumenpenyedia_id)), array('title' => 'Unduh Dokumen', 'rel' => 'tooltip', 'style' => 'color:black;')); ?></td>
                </tr>
                <?php }?>
            </tbody>
        </table>                
    </div>
</div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Setuju',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array(
                        'class'=>'btn btn-blue submit', 
                        'type'=>'button',
                        'onclick'=>'setSetuju();return false;',
                ));  
                    echo "&nbsp;&nbsp;";
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Tolak',array('{icon}'=>'<i class="glyphicon glyphicon-remove"></i>')),array(
                        'class'=>'btn btn-red submit', 
                        'type'=>'button',
                        'onclick'=>'setTolak();return false;',
                )); 
                    echo "&nbsp;&nbsp;";
                    if (!empty(Yii::app()->user->getState('ruangan_id'))) {
                        echo CHtml::link(Yii::t('mds','{icon} Kembali',array('{icon}'=>'<i class="entypo-back"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));
                    } else {
                        echo " ";
                    } 
                    ?>
            </div>
	</div>
<?php $this->endWidget(); ?>
<script>
    function setSetuju(){
        var id = "<?php echo $_GET['id']?>";
        $.ajax({
            type: 'POST',
            url:'<?php echo $this->createUrl('setSetuju'); ?>',
            data:{
                id:id, 
            },
            dataType:'json',
            success:function(data){
                    if(data.status == 'proses_form'){
                        window.location.replace("<?php echo $this->createUrl('penyediaM/admin')?>");
                    }else{
                        myAlert("Pembatalan Gagal Disimpan");
                    }
            },
            error: function(data) { // if error occured
                  myAlert("Pembatalan Gagal Disimpan");
             },
       });
    }
    function setTolak(){
        var id = "<?php echo $_GET['id']?>";
        $.ajax({
            type: 'POST',
            url:'<?php echo $this->createUrl('setTolak'); ?>',
            data:{
                id:id, 
            },
            dataType:'json',
            success:function(data){
                    if(data.status == 'proses_form'){
                        window.location.replace("<?php echo $this->createUrl('penyediaM/admin')?>");
                    }else{
                        myAlert("Pembatalan Gagal Disimpan");
                    }
            },
            error: function(data) { // if error occured
                  myAlert("Pembatalan Gagal Disimpan");
             },
       });
    }
    
    function cekPBF(obj){
        var jenis = $('#PenyediaM_penyedia_jenis').val();
        if (jenis === "Farmasi") {
            $('.pbf').show();
            console.log(jenis);
        } else {
            $('.pbf').hide();
            $('#PenyediaM_pbf_id').val("");
            $('#pbf_nama').val("");
            console.log(jenis);
        }
    }
    
    $(document).ready(function(){
        cekPBF();
    });
</script>
    
    