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
                    array('disabled' => true, 'class' => 'span3 required', 'onclick' => 'cekPBF(this);', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
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
                                          array('disabled' => true, 'empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                'ajax'=>array('type'=>'POST',
                                                              'url'=>Yii::app()->createUrl('pengadaan/penyediaM/setDropdownKabupaten',array('encode'=>false,'namaModel'=>'PenyediaM')),
                                                              'update'=>'#PenyediaM_penyedia_kabupaten'))); ?>
                
                <?php echo $form->dropDownListRow($model,'penyedia_kabupaten', array(), 
                                          array('disabled' => true, 'empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
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
<?php $this->endWidget(); ?>
<?php // $this->renderPartial($this->path_view.'_jsFunction', array('model' => $model)); ?>

<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPBF',
    'options' => array(
        'title' => 'Pencarian Perusahaan Besar Farmasi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPBF = new PbfM('search');
$modPBF->unsetAttributes();
if (isset($_GET['PbfM'])) {
    $modPBF->attributes = $_GET['PbfM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimengetahui-grid',
    'dataProvider' => $modPBF->search(),
    'filter' => $modPBF,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#' . CHtml::activeId($model, 'pbf_id') . '\").val(\"$data->pbf_id\");
                                                  $(\"#' . CHtml::activeId($model, 'pbf_nama') . '\").val(\"$data->pbf_nama\");
                                                       $(\"#pbf_nama\").val(\"$data->pbf_nama\");  
                                                  $(\"#dialogPBF\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'Kode PBF',
            'filter' => CHtml::activeTextField($modPBF, 'pbf_kode'),
            'value' => '$data->pbf_kode',
        ),
        array(
            'header' => 'Nama PBF',
            'filter' => CHtml::activeTextField($modPBF, 'pbf_nama'),
            'value' => '$data->pbf_nama',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>

<script>
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
    
    