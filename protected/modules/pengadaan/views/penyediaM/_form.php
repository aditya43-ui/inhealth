<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'penyedia-m-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array(
            'enctype'=>'multipart/form-data',
            'onKeyPress' => 'return disableKeyPress(event)',
        ),
    ));
?>
<div class="panel panel-success">
    <div class="panel panel-heading">
        <div class="panel-title"> Tambah <b> Penyedia </b> </div>
    </div>
    <div class="panel-body">

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">
            <div class="col-md-6">
                <?php echo $form->textFieldRow($model,'penyedia_nama',array('class'=>'span3 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
                
                <?php echo $form->textFieldRow($model,'penyedia_namalain',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
                <?php echo $form->dropDownListRow($model,'penyedia_jenis', LookupM::getItems('jenissupplier'),
                    array('class' => 'span3 required', 'onclick' => 'cekPBF(this);', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                <div class="pbf">
                    <div class="control-group">
                        <?php echo CHtml::label("Perusahaan Besar Farmasi","",array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->hiddenField($model, 'pbf_id', array('readonly' => true)); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'pbf_nama',
                            'model' => $model,
                            'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('AutocompletePegawai') . '",
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
                                    $("#' . Chtml::activeId($model, 'pbf_id') . '").val(ui.item.pbf_id); 
                                    return false;
                                }',
                            ),
                            'htmlOptions' => array(
                                'placeholder' => 'Ketik Nama Perusahaan Besar Farmasi',
                                'class' => 'span3 pbf_nama',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'pbf_id') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPBF'),
                        ));
                        ?>
                        </div>
                    </div>
                </div>
                <br>
                <?php echo $form->textAreaRow($model,'penyedia_alamat',array('rows'=>6, 'cols'=>50, 'class'=>'span3 required', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                
                <div class="control-group">
                    <?php echo CHtml::label("Propinsi",'',array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'propinsi_id', array('readonly' => true)); ?>
                        <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'penyedia_propinsi',
                                'source' => 'js: function(request, response) {
                                    $.ajax({
                                            url: "' . $this->createUrl('/actionAutoComplete/propinsi') . '",
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
                                        $(this).val(ui.item.value);
                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                        $(this).val(ui.item.value);
                                        $("#PenyediaM_propinsi_id").val(ui.item.propinsi_id); 
                                        return false;
                                    }',
                                ),
                                'htmlOptions' => array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Ketik Nama Kabupaten '),
                            ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Kabupaten",'',array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'penyedia_kabupaten',
                                'source' => 'js: function(request, response) {
                                    $.ajax({
                                            url: "' . $this->createUrl('/actionAutoComplete/getKabupaten') . '",
                                            dataType: "json",
                                            data: {
                                                term: request.term,
                                                propinsi_id: $("#PenyediaM_propinsi_id").val()
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
                                        $(this).val(ui.item.kabupaten_nama);
                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                        $(this).val(ui.item.kabupaten_nama);
                                        return false;
                                    }',
                                ),
                                'htmlOptions' => array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Ketik Nama Propinsi '),
                            ));?>
                    </div>
                </div> 
                <?php echo $form->textFieldRow($model,'penyedia_kodepos',array('class'=>'span3 required numbers-only', 'max-length' => 5, 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>5)); ?>
            </div>
            <div class="col-md-6">
                <div class="control-group">
                    <?php echo CHtml::label("Penyedia Kode <span class='required'> * </span> ","",array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'penyedia_kode',array('class'=>'span3', 'disabled' => true, 'placeholder' => '-- Otomatis --' ,'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>12)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Telepon <span class='required'> * </span> ","",array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'penyedia_telepon',array('class'=>'span3 required numbers-only', 'max-length' => 13, 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>12)); ?>
                    </div>
                </div>
                
                <?php echo $form->textFieldRow($model,'penyedia_fax',array('class'=>'span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>12)); ?>
                
                <?php echo $form->textFieldRow($model,'penyedia_website',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>250)); ?>
                
                <div class="control-group">
                    <?php echo CHtml::label("Email <span class='required'> * </span> ","",array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'penyedia_email',array('class'=>'span3 required', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                    </div>
                </div>
                
                <?php echo $form->textFieldRow($model,'penyedia_norekening',array('class'=>'span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                
                <?php echo $form->textFieldRow($model,'penyedia_direktur',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
                
                <?php echo $form->textFieldRow($model,'penyedia_cp',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
                
                <?php echo $form->textFieldRow($model,'penyedia_jabatancp',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>150)); ?>
               
                <?php echo $form->textFieldRow($model,'penyedia_nomobilecp',array('class'=>'span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>16)); ?>

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

            </tbody>
        </table>                
    </div>
</div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php 
//                 if (!empty($_GET['id'])) {
//                    echo CHtml::htmlButton($model->isNewRecord ? 
//                        Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')) :
//                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'onclick' => 'cekForm();'));
//                    echo '&nbsp;';
//                     echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'onclick' => 'cekForm();'));
//
//                 } else {
//                    echo CHtml::htmlButton(Yii::t('mds','{icon} Register',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)'));
//                 }
                 echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'onclick' => 'cekForm();'));
                ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
				$this->createUrl('create'), 
				array('class'=>'btn btn-default',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php
                    if (!empty(Yii::app()->user->getState('ruangan_id'))) {
                        echo CHtml::link(Yii::t('mds','{icon} Pengaturan Penyedia',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));
                    } else {
                        echo " ";
                    } 
                    ?>
    
		<?php 
                    $content = $this->renderPartial('pengadaan.views.tips/master', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));?>
            </div>
	</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view.'_jsFunction', array('model' => $model)); ?>

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