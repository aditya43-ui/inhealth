<?php
/**
* - digunakan untuk Admin Teknisi Peralatan
* @author : Elham Budianto
* @email : elhambudianto1@gmail.com
* @wiki : ..
**/
?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'teknisi-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array(
        'enctype' => 'multipart/form-data',
        'onKeyPress'=>'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'),
	'focus'=>'#'.CHtml::activeId($model,'teknisi_nama'),
)); ?>
<div class="panel panel-primary panel-success">
        <div class="panel-heading">
            <div class="panel-title">											
                <i class="glyphicon glyphicon-file"></i> Informasi																	
            </div>
        </div>
        <div class="panel-body">
            <div class="row-fluid">
                <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
                <?php echo $form->errorSummary($model); ?>
                <div class="col-sm-6">
                    <?php echo $form->textFieldRow($model,'namateknisi',array('class'=>'span3','placeholder'=>'Ketik Nama Teknisi', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,"jeniskelamin",array('class' => 'control-label')); ?>
                        <div class="controls">
                           <?php echo $form->radioButtonList($model,'jeniskelamin',array('LAKI-LAKI'=>'LAKI-LAKI','PEREMPUAN'=>'PEREMPUAN')); ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($model,'tempatlahir',array('class'=>'span3','placeholder'=>'Ketik Tempat Lahir','onkeyup'=>'setKode(this);', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <div class="control-group ">
                        <?php echo CHtml::label('Tanggal Lahir','', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                $this->widget('MyDateTimePicker',array(
                                    'model'=>$model,
                                    'attribute'=>'tgllahir',
                                    'mode'=>'date',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
            //										'maxDate' => 'd',
                                    ),
                                    'htmlOptions'=>array('style' => 'width: 180px','readonly'=>true,'class'=>'dtPicker3','onclick'=>"return $(this).focusNextInputField(event)"),
                                )); ?> 
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Pendidikan","",array('class' => 'control-label')); ?>
                        <div class="controls">
                           <?php echo $form->dropDownList($model, 'pendidikan_id', CHtml::listData(PendidikanM::model()->findAll(), 'pendidikan_id', 'pendidikan_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,'empty'=>'--Pilih--')); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                      <div class="control-group">
                        <?php echo $form->labelEx($model,"statusperkawinan",array('class' => 'control-label')); ?>
                        <div class="controls">
                           <?php echo $form->dropDownList($model, 'statusperkawinan', LookupM::getItems('statusperkawinan'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,'empty'=>'--Pilih--')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,"kabupaten_id",array('class' => 'control-label')); ?>
                        <div class="controls">
                           <?php //echo $form->dropDownList($model, 'kabupaten_id', CHtml::listData(KabupatenM::model()->findAll(), 'kabupaten_id', 'kabupaten_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,'empty'=>'--Pilih--')); ?>
                               <?php echo $form->hiddenField($model,'kabupaten_id',array('class'=>'span3','placeholder'=>'Ketik Nama Teknisi')); ?> 
                               <?php $this->widget('MyJuiAutoComplete', array(
                                        'model'=>$model,
                                        'attribute' => 'kabupaten_nama',
                                        'source' => 'js: function(request, response) {
                                                $.ajax({
                                                        url: "' . $this->createUrl('AutoCompleteKabupaten') . '",
                                                        dataType: "json",
                                                        data: {
                                                                term: request.term,
                                                        },
                                                        success: function (data) {
                                                                response(data);
                                                        }
                                                })
                                        }',
                                        'options' => array(
                                                'showAnim' => 'fold',
                                                'minLength' => 3,
                                                'focus' => 'js:function( event, ui ) {
                                                        $(this).val( ui.item.label);                                                        
                                                        return false;
                                                }',
                                                'select' => 'js:function( event, ui ) {
                                                        $("#'.Chtml::activeId($model, 'kabupaten_id') . '").val(ui.item.kabupaten_id); 
                                                        $("#'.Chtml::activeId($model, 'kabupaten_nama') . '").val(ui.item.kabupaten_nama); 
                                                        return false;
                                                }',
                                        ),
                                        'htmlOptions' => array(
                                                'class'=>'span3',
                                            'placeholder'=>'Ketik Nama Domisili',
                                                'onkeyup'=>"return $(this).focusNextInputField(event)",
                                        ),
                                        ))?>
                        </div>
                    </div>
                     <div class="control-group">
                        <?php echo $form->labelEx($model,"alamat_teknisi",array('class' => 'control-label')); ?>
                        <div class="controls">
                           <?php echo $form->textArea($model, 'alamat_teknisi', array('class' => 'span3','placeholder'=>'Ketik Alamat Teknisi', 'onkeypress' => "return $(this).focusNextInputField(event);",)); ?>
                        </div>
                    </div>
                     <div class="control-group">
                        <?php echo $form->labelEx($model,"supplier_id",array('class' => 'control-label')); ?>
                        <div class="controls">
                           <?php echo $form->hiddenField($model, 'supplier_id', array('class' => 'span3','placeholder'=>'Ketik Alamat Teknisi', 'onkeypress' => "return $(this).focusNextInputField(event);",)); ?>
                            <?php
                                $this->widget('MyJuiAutoComplete', array(
                                        'model'=>$model,
                                        'attribute' => 'supplier_nama',
                                        'source' => 'js: function(request, response) {
                                                $.ajax({
                                                        url: "' . $this->createUrl('AutoCompleteSupplier') . '",
                                                        dataType: "json",
                                                        data: {
                                                                term: request.term,
                                                        },
                                                        success: function (data) {
                                                                response(data);
                                                        }
                                                })
                                        }',
                                        'options' => array(
                                                'showAnim' => 'fold',
                                                'minLength' => 3,
                                                'focus' => 'js:function( event, ui ) {
                                                        $(this).val( ui.item.label);
                                                        refreshDialogOA();
                                                        return false;
                                                }',
                                                'select' => 'js:function( event, ui ) {
                                                        $("#'.Chtml::activeId($model, 'supplier_id') . '").val(ui.item.supplier_id); 
                                                        $("#'.Chtml::activeId($model, 'supplier_nama') . '").val(ui.item.supplier_nama); 
                                                        return false;
                                                }',
                                        ),
                                        'htmlOptions' => array(
                                                'class'=>'span3',
                                            'placeholder'=>'Ketik Nama Supplier',
                                                'onkeyup'=>"return $(this).focusNextInputField(event)",
                                                //'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modPermintaanPembelian, 'supplier_id') . '").val(""); '
                                        ),
                                        'tombolDialog' => array('idDialog' => 'dialogSupplier'),
                                ));
                                ?>
                        </div>
                    </div>
                     <div class="control-group">
                        <?php echo $form->labelEx($model,"no_kontak_teknisi",array('class' => 'control-label')); ?>
                        <div class="controls">
                           <?php echo $form->textField($model, 'no_kontak_teknisi', array('class' => 'span3 numbers-only','placeholder'=>'Ketik No Kontak Teknisi', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,'empty'=>'--Pilih--')); ?>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
<div class="panel panel-primary panel-success">
        <div class="panel-heading">
            <div class="panel-title">											
                <i class="glyphicon glyphicon-file"></i> Sertifikat																	
            </div>
        </div>
    <div class="panel-body" style="overflow-x: scroll;">
            <div class="row-fluid">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo Chtml::label("No Sertifikat",'',array('class' => 'control-label')); ?>
                        <div class="controls">
                           <?php echo Chtml::textField('no_sertifikat_teknisi','', array('class' => 'span3','placeholder'=>'Ketik No Sertifikat', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo Chtml::label("Nama Sertifikat",'',array('class' => 'control-label')); ?>
                        <div class="controls">
                           <?php echo Chtml::textField('nama_sertifikat','', array('class' => 'span3','placeholder'=>'Ketik Nama Sertifikat', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo Chtml::label("Keterangan",'',array('class' => 'control-label')); ?>
                        <div class="controls">
                           <?php echo Chtml::textArea('sertifikat_ket','', array('class' => 'span3','placeholder'=>'Ketik Keterangan Sertifikat', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group ">
                        <?php echo Chtml::label("Berlaku Sampai",'',array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php   
                                $this->widget('MyDateTimePicker',array(
                                    //'model'=>$modSertifikat,
                                    'name'=>'berlaku_sd',
                                    'mode'=>'date',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions'=>array('style' => 'width: 180px','readonly'=>true,'class'=>'dtPicker3','onclick'=>"return $(this).focusNextInputField(event)"),
                                )); ?> 
                             <?php
                                echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', 
                                array('onclick' => 'tambahSertifikat();return false;',
                                    'class' => 'btn btn-primary',
                                    'onkeypress' => "tambahSertifikat();return $(this).focusNextInputField(event)",
                                    'rel' => "tooltip",
                                    'title' => "Klik untuk menambahkan Sertifikat",));
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-tabel" >
                <table class="items table table-bordered table-striped table-condensed" id="table-sertifikat">
                    <thead>
                        <tr>
                            <th>No Sertifikat</th>
                            <th>Nama Sertifikat</th>
                            <th>Keterangan</th>
                            <th>Berlaku Sampai</th>
                            <th>File</th>
                            <th>Batal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        /*if(count($modObatAlkesPasien) > 0){
                            foreach($modObatAlkesPasien AS $i=> $modDetail){
                                $modDetail->jmlstok = StokobatalkesT::getJumlahStokOaTersimpan($modDetail->obatalkespasien_id);
                                echo $this->renderPartial($this->path_view.'_rowDetail',array('modObatAlkesPasien'=> $modDetail));
                            }
                        }*/
                        ?>
                    </tbody>
                </table>
            </div>
    </div>
</div>
<?php
//========= Dialog buat cari data Bidang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogSupplier',
    'options'=>array(
        'title'=>'Data Supplier',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>600,
        'height'=>650,
        'resizable'=>false,
    ),
));
$supplier = new SupplierM('search');
$supplier->unsetAttributes();
if(isset($_GET['SupplierM'])){
    $supplier->attributes = $_GET['SupplierM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'barang-v-grid',
    'dataProvider' => $supplier->search(),
    'filter' => $supplier,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>",
                        "#",
                        array(
                            "class"=>"btn-small", 
                            "id" => "selectKelompoks",
                            "onClick" => "
                            $(\"#'.CHtml::activeId($model,'supplier_id').'\").val($data->supplier_id);
                            $(\"#'.CHtml::activeId($model,'supplier_nama').'\").val(\"$data->supplier_nama\");  
                            $(\"#dialogSupplier\").dialog(\"close\"); 
                            "))
                        ',
        ),
        array(
            'header'=>'Nama',
            'name'=>'supplier_nama',
            'value'=>'$data->supplier_nama',
            'filter'=>Chtml::activeTextField($supplier, 'supplier_nama', array('class' => ''))
        ),
        array(
            'header'=>'Alamat',
            //n 'filter'=>  CHtml::activeTextField($modSupplier, 'supplier_alamat'),
            'value'=>'$data->supplier_alamat',
            'filter'=>Chtml::activeTextField($supplier, 'supplier_alamat'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>           
<div class="form-actions">
	<?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
		Yii::t('mds','{icon} Simpan',array('{icon}'=>'<i class="entypo-check"></i>')),
		array('class'=>'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
		'',
		array('class'=>'btn btn-default',
		'onclick'=>'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
	<?php //$this->widget('UserTips',array('type'=>'create'));?>
	<?php
		echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Teknisi', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
		$tips = array(
			'0' => 'simpan',
			'1' => 'ulang',
		);
		$content = $this->renderPartial($this->path_tips.'informasi',array('tips'=>$tips),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>
</div>
<?php $this->endWidget(); ?>
<script>
function namaLain(obj){
    $("#<?php echo Chtml::activeId($model, 'teknisi_namalainnya') ?>").val($(obj).val());
}
</script>

