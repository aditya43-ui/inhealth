<?php
$this->widget('bootstrap.widgets.BootAlert');

?>
<?php  ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'guinvtanah-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);','onkeyup'=>(!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '','onclick'=>(!isset($_GET['sukses']))? 'cekDisabled(this);' : ''),
        'focus'=>'#',
)); ?>
<div>
    <p class="help-block"style="color:#333;"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
    <?php echo $form->errorSummary($model); ?>
    <?php $this->renderPartial('_dataTanah', array('form'=>$form, 'modBarang' => $modBarang, 'model'=>$model, 'jenisAset'=>'01')); ?>
    <br>
    <div class="panel panel-primary panel-success">
        <div class="panel-heading">
            <div class="panel-title">											
                <i class="glyphicon glyphicon-file"></i> Data Inventarisasi Tanah																	
            </div>
        </div>
        <div class="panel-body">
    
            <div class="col-sm-6">
                <?php echo $form->dropDownListRow($model,'pemilikbarang_id',CHtml::listData(PemilikbarangM::model()->findAll(), 'pemilikbarang_id', 'pemilikbarang_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                <?php echo $form->hiddenField($model,'barang_id'); ?>
                <?php echo $form->hiddenField($model,'barang_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->dropDownListRow($model,'asalaset_id',CHtml::listData(AsalasetM::model()->findAll(), 'asalaset_id', 'asalaset_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'lokasi_id', array(
                        'class'=>'control-label',
                    )); ?>
                    <div class="controls">
                        <?php echo CHtml::activeHiddenField($model, 'lokasi_id', array(
                            'id'=>'lokasi_id'
                        )); ?>
                        <?php 
                            $this->widget('MyJuiAutoComplete', array(
                                    'model'=>$model,
                                    'attribute'=>'lokasi_nama',
                                            //'name'=>'barang_nama',
                                            //'value'=>$modBarang->barang_nama,
                                            'source'=>'js: function(request, response) {
                                                $.ajax({
                                                    url: "'.Yii::app()->createUrl('ActionAutoComplete/getLokasiAset').'",
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
                                                    $("#lokasi_id").val(ui.item.lokasi_id);
                                                    $("#lokasi_nama").val(ui.item.lokasiaset_namalokasi);
                                                    $("#alamat_lokasi").val(ui.item.alamat_lokasi);
                                                    return false;
                                                }',
                                            ),
                                            'htmlOptions'=>array(
                                                'id'=>'lokasi_nama',
                                                'class'=>'span3',
                                                'placeholder'=>'Ketik Lokasi',
                                                'onkeypress'=>"return $(this).focusNextInputField(event)"
                                            ),
                                            'tombolDialog'=>array('idDialog'=>'dialogLokasiAset'),
                                        )); 
                        ?>
                    </div>
                </div>  
                    
                <?php // echo $form->dropDownListRow($model,'lokasi_id',CHtml::listData(LokasiasetM::model()->findAll(), 'lokasi_id', 'lokasiaset_namalokasi'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>

                <?php echo $form->textFieldRow($model,'kode_wilayah',array('readonly'=>false,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model,'invtanah_kode',array('class'=>'span2', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                <div class="control-group ">
                    <label class="control-label" for="barang_kode">
                        <?php echo $form->labelEx($model, "invtanah_noregister", array('class'=>'control-label', 'label'=>'Kode Lokasi'));?>
                    </label>
                    <div class="controls">
                        <?php echo $form->textField($model,'invtanah_noregister',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>        
                    </div>
                </div>
                <?php echo $form->textFieldRow($model,'invtanah_namabrg',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'invtanah_luas', array(
                        'class'=>'control-label'
                    )); ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'invtanah_luas',array('class'=>'span2 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                        <label class=control-label">m<sup>2</sup></label>
                    </div>
                </div>
                
                
                <?php echo $form->textFieldRow($model,'invtanah_thnpengadaan',array('class'=>'span1 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>4)); ?>

                
            </div>
            <div class="col-sm-6">
                <div class="control-group ">
                    <?php echo $form->labelEx($model,'invtanah_tglguna', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'invtanah_tglguna',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'maxDate' => 'd',
                                                    //
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:204px;'
                                                ),
                        )); ?>
                        <?php echo $form->error($model, 'invtanah_tglguna'); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model,'invtanah_status',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                <?php echo $form->textAreaRow($model,'invtanah_alamat',array(
                    'rows'=>5, 
                    'cols'=>50, 
                    'class'=>'span3', 
                    'onkeypress'=>"return $(this).focusNextInputField(event);", 
                    'id'=>'alamat_lokasi'
                )); ?>
                <div class="control-group ">
                    <?php echo $form->labelEx($model,'invtanah_tglsertifikat', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'invtanah_tglsertifikat',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'maxDate' => 'd',
                                                    //
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:204px;'
                                                ),
                        )); ?>
                        <?php echo $form->error($model, 'invtanah_tglsertifikat'); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model,'invtanah_nosertifikat',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                <?php echo $form->textFieldRow($model,'invtanah_penggunaan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                <?php echo $form->textFieldRow($model,'invtanah_harga',array('class'=>'span2 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'id'=>'harga_tanah')); ?>
                <?php echo $form->textAreaRow($model,'invtanah_ket',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                <?php //echo $form->textFieldRow($model,'create_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php // echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php // echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                
            </div>
        </div>
        <div class="panel panel-primary panel-success" hidden>
            <div class="panel-heading">
                <div class="panel-title">											
                    Penjurnalan																	
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_penjurnalan', array('model'=>$model, 'form'=>$form,)); ?>		
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
        Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
        array('class'=>(isset($_GET['sukses']))? 'btn btn-primary' : 'btn btn-primary submit', 'disabled'=>(isset($_GET['sukses']))? true : false, 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>

    <?php // echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')), 
//                        Yii::app()->createUrl($this->module->id.'/invtanahT/admin'), 
//                        array('class'=>'btn btn-danger',
//                              'onclick'=>'if(!confirm("'.Yii::t('mds','Anda yakin akan mengulang?').'")) return false;')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
        $this->createUrl($this->module->id.'/Create'), 
        array('class'=>'btn btn-danger',
            'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('Create').'";} ); return false;'));  ?>
    <?php $content = $this->renderPartial('tips/transaksi',array(),true) ?>
    <?php $content = $this->renderPartial('tips/transaksi',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>
</div>

<?php $this->endWidget(); ?>

<?php
////========= Dialog buat cari data Pemilik Barang =========================
//$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
//    'id'=>'dialogPemilikBarang',
//    'options'=>array(
//        'title'=>'Pemilik Barang',
//        'autoOpen'=>false,
//        'modal'=>true,
//        'width'=>750,
//        'height'=>600,
//        'resizable'=>false,
//    ),
//));
//
//$modPemilik = new MAPemilikbarangM('search');
//$modPemilik->unsetAttributes();
//if(isset($_GET['MAPemilikbarangM']))
//    $modPemilik->attributes = $_GET['MAPemilikbarangM'];
//
//$this->widget('ext.bootstrap.widgets.BootGridView',array(
//	'id'=>'sainstalasi-m-grid',
//	'dataProvider'=>$modPemilik->search(),
//	'filter'=>$modPemilik,
//        'template'=>"{summary}\n{items}\n{pager}",
//        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//	'columns'=>array(
//               'pemilikbarang_id',
//                'pemilikbarang_kode',
//                'pemilikbarang_nama',
//                
//                array(
//                    'header'=>'Pilih',
//                    'type'=>'raw',
//                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>",
//                                "#",
//                                array(
//                                    "class"=>"btn-small", 
//                                    "id" => "selectBidang",
//                                    "onClick" => "
//                                    $(\"#'.CHtml::activeId($model, 'pemilikbarang_id').'\").val(\'$data->pemilikbarang_id\');
//                                    $(\"#pemilikNama\").val(\'$data->pemilikbarang_nama\');
//                                    $(\'#dialogPemilikBarang\').dialog(\'close\');return false;"))'
//                ),
//	),
//        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
//)); 
//
//$this->endWidget();
?>
<?php
////========= Dialog buat cari data Asal Aset =========================
//$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
//    'id'=>'dialogAsalAset',
//    'options'=>array(
//        'title'=>'Asal Aset',
//        'autoOpen'=>false,
//        'modal'=>true,
//        'width'=>750,
//        'height'=>600,
//        'resizable'=>false,
//    ),
//));
//
//$modAsalAset = new MAAsalasetM('search');
//$modAsalAset->unsetAttributes();
//if(isset($_GET['MAAsalasetM']))
//    $modAsalAset->attributes = $_GET['MAAsalasetM'];
//
//$this->widget('ext.bootstrap.widgets.BootGridView',array(
//	'id'=>'sainstalasi-m-grid',
//	'dataProvider'=>$modAsalAset->search(),
//	'filter'=>$modAsalAset,
//        'template'=>"{summary}\n{items}\n{pager}",
//        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//	'columns'=>array(
//               'asalaset_id',
//                'asalaset_nama',
//                'asalaset_singkatan',
//                
//                array(
//                    'header'=>'Pilih',
//                    'type'=>'raw',
//                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>",
//                                "#",
//                                array(
//                                    "class"=>"btn-small", 
//                                    "id" => "selectBidang",
//                                    "onClick" => "
//                                    $(\"#'.CHtml::activeId($model, 'asalaset_id').'\").val(\'$data->asalaset_id\');
//                                    $(\"#asalAsetNama\").val(\'$data->asalaset_nama\');
//                                    $(\'#dialogAsalAset\').dialog(\'close\');return false;"))'
//                ),
//	),
//        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
//)); 
//
//$this->endWidget();
?>
<?php
//========= Dialog buat cari data Lokasi Aset =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogLokasiAset',
    'options'=>array(
        'title'=>'Lokasi Aset',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modLokasiAset = new MALokasiasetM('search');
$modLokasiAset->unsetAttributes();
if (isset($_GET['MALokasiasetM'])) {
    $modLokasiAset->attributes = $_GET['MALokasiasetM'];
    $modLokasiAset->jenis_lokasi = $_GET['MALokasiasetM']['jenis_lokasi'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'lokasiaset-m-grid',
    'dataProvider'=>$modLokasiAset->search(),
    'filter'=>$modLokasiAset,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectBidang",
                                    "onClick" => "
                                    $(\"#lokasi_id\").val(\'$data->lokasi_id\');
                                    $(\"#lokasi_nama\").val(\'$data->lokasiaset_namalokasi\');
                                    $(\"#alamat_lokasi\").val(\'$data->alamat_lokasi\');
                                    $(\'#dialogLokasiAset\').dialog(\'close\');return false;"))'
                ),
                'lokasiaset_kode',
                array(
                    'header'=>'Nama Lokasi',
                    'name'=>'lokasiaset_namalokasi',
                ),
                
                //'lokasiaset_namainstalasi',
                array(
                    'name'=>'jenis_lokasi',
                    'filter'=>CHtml::activeDropDownList($modLokasiAset, 'jenis_lokasi', LookupM::getItems('jenis_lokasiaset'), array(
                        'empty'=>'-- Pilih --'
                    )),
                ),
                
                
	),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>
<?php 

$js = <<< JS
$('.numbersOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
Yii::app()->clientScript->registerScript('numberOnly',$js,CClientScript::POS_READY);?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script>
    function konfirmasi(){
    location.reload();
	}

function setKodeRegister(barang_id) {
		$.ajax({
			type: 'POST',
			url: '<?php echo $this->createUrl('GetkodeRegister'); ?>',
			data: {barang_id: barang_id}, 
			dataType: "json",
			success: function (data) {
				$('#MAInvtanahT_invtanah_noregister').val(data.value);
				$('#MAInvtanahT_invtanah_kode').val(data.kode);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});

	}
        
	$( document ).ready(function(){
            cekDisabled($('#guinvtanah-t-form'));
            <?php if(isset($_GET['sukses'])){ ?>
		$("input, select, textarea").attr('disabled', true);
            <?php } ?>
        });
</script>
