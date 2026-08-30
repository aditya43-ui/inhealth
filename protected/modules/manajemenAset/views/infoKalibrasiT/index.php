<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'invperizinan-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);', 'onkeyup' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '', 'onclick' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : ''),
    'focus' => '#',
        ));
?>    

<div class="row-fluid">
    <div class="span6">
        <div class="control-group ">
            <label class="control-label">
                <?php echo CHtml::label("Periode Izin <span style='color:red'>*</span> ",'', array('class' => 'control-label')) ?>
            </label>
            <div class="controls">
                <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tglkalibrasi)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->berlaku_sdtgl)) ?>">
                    <i class="entypo-calendar"></i>
                    <span ><?php echo date('F d, Y', strtotime($model->tglkalibrasi)) ?> - <?php echo date('F d, Y', strtotime($model->berlaku_sdtgl)) ?></span>
                    <?php echo $form->hiddenField($model,'tglkalibrasi', array('class' => 'start required')) ?>
                    <?php echo $form->hiddenField($model,'berlaku_sdtgl', array('class' => 'end required')) ?>
                </div>
            </div>
        </div>
         <div class="control-group">
                            <?php echo CHtml::label("Nomor Kalibrasi <span style='color:red'>*</span>",'',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'nokalibrasi', array('placeholder'=>'Nomor Kalibrasi','readonly' => false, 'class' => 'required span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
        <div class="control-group ">
            <label class="control-label">
                <?php echo CHtml::label("Vendor <span style='color:red'>*</span>",'supplier_id');?>
            </label>
            <div class="controls">
                  <?php echo $form->hiddenField($model,'supplier_id',array('class' => 'required','readonly'=>true)); ?>
                <?php // echo $form->textField($model, 'pelaksana_id', array('placeholder'=>'Ketik Nama Pelaksana','class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                
                                      
               <?php
                
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'vendor',
                    'source' => 'js: function(request, response) {
                                   $.ajax({
                                       url: "' . $this->createUrl('/ActionAutoComplete/Supplier') . '",
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
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                                 $(this).val("");
                                 return false;
                             }',
                        'select' => 'js:function( event, ui ) {
                                $(this).val( ui.item.value);
                                $("#' . CHtml::activeId($model, 'vendor') . '").val(ui.item.supplier_nama);
                                $("#' . CHtml::activeId($model, 'supplier_id') . '").val(ui.item.supplier_id); 
                                return false;
                            }',
                    ),
                    'tombolDialog'=>array('idDialog'=>'dialogSupplier'),
                    'htmlOptions'=>array('class' => 'span3', 'placeholder'=>'Ketik Nama Vendor','rel'=>'tooltip',
                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group ">
            <label class="control-label">
                <?php echo CHtml::label("Pelaksana <span style='color:red'>*</span>",'pegpelaksana_id');?>
            </label>
            <div class="controls">
                  <?php echo $form->hiddenField($model, 'pegpelaksana_id',array('class' => 'required','readonly'=>true)); ?>
                <?php // echo $form->textField($model, 'pelaksana_id', array('placeholder'=>'Ketik Nama Pelaksana','class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'pegawai',
                    'source' => 'js: function(request, response) {
                                   $.ajax({
                                       url: "' . $this->createUrl('/ActionAutoComplete/GetPegawai') . '",
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
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                                 $(this).val("");
                                 return false;
                             }',
                        'select' => 'js:function( event, ui ) {
                                $(this).val( ui.item.value);
                                $("#' . CHtml::activeId($model, 'pegawai') . '").val(ui.item.nama_pegawai);
                                $("#' . CHtml::activeId($model, 'pegpelaksana_id') . '").val(ui.item.pegawai_id); 
                                return false;
                            }',
                    ),
                    'tombolDialog'=>array('idDialog'=>'dialogPegawai'),
                    'htmlOptions'=>array('class' => 'span3', 'placeholder'=>'Ketik Nama Pelaksana','rel'=>'tooltip',
                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">
                <?php echo CHtml::label("Keterangan",'invkalibrasi_ket');?>
            </label>
            <div class="controls">
                <?php echo $form->textField($model, 'invkalibrasi_ket', array('placeholder' => 'Keterangan Kalibrasi', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">
                <?php echo CHtml::label("Dokumen",'lampiran_berkas');?>
            </label>
            <div class="controls">
                <?php echo $form->fileField($model, 'lampiran_berkas', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group">
                            <?php echo CHtml::label("Laik Pakai",'',array('class' => 'control-label required')); ?>

                        <div class="controls">
                            <?php echo $form->checkBox($model,'islaikpakai', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>

                        </div>
        </div>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Tabel Riwayat Kalibrasi
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'data-m-grid',
            'dataProvider' => $modRiwayatKalibarasi->searchdata(),
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-condensed',
            'columns' => array(
                ////'triase_id',
                array(
                    'header' => 'No.',
                    'value' => '($this->grid->dataProvider->pagination) ? 
                                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                    : ($row+1)',
                                    'type'=>'raw',
                                    'htmlOptions'=>array('style'=>'text-align:right;'),
                                ),
				
                                array(
                                    'header'=>'Tanggal Kalibrasi',
                                    'name'=>'tglkalibrasi',
                                    'value'=>function($data){
                                        $format = new MyFormatter();
                                        return $format->formatDateTimeForUser($data->tglkalibrasi);
                                    }
                                ),
                                  array(
                                    'header'=>'Berlaku Sampai',
                                    'name'=>'berlaku_sdtgl',
                                    'value'=>function($data){
                                        $format = new MyFormatter();
                                        return $format->formatDateTimeForUser($data->berlaku_sdtgl);
                                    }
                                ),
                                        
                                
				 array(
                                   
                                   'name'=>'supplier_id',
                                    'header'=>'Vendor',
                                    'value'=>function($data) {
                                    $modul = SupplierM::model()->findByPk($data->supplier_id);
                                    if (!empty($modul)){
                                    return $modul->supplier_nama;}
                                    }),
                                 
                                array(
                                   
                                   'header'=>'Pelaksana',
                                    'value'=>function($data) {
                                    $modul = PegawaiM::model()->findByPk($data->pegpelaksana_id);
                                    if (!empty($modul)){
                                    return $modul->nama_pegawai;}
                                    }),
				
				array(
                                   
                                   'header'=>'Keterangan',
                                   'name'=>'invkalibrasi_ket',
                                    'value'=>function($data) {
                                          return $data->invkalibrasi_ket;  
                                    }),
                                
                                 array(
                                     'header'=>'Dokumen',
                                     'type'=>'raw',
                                     'value'=>function($data){
                                            return (!empty($data->lampiran_berkas."<br>") ? CHtml::link($data->lampiran_berkas,$this->createUrl('Unduh',array('id'=>$data->invkalibrasi_id)),array('title'=>'Download dokumen 1','rel'=>'tooltip'))."<br>" : "");
                                                         
                                                
                                     }
                                 ),
                                 array(
                                        'header'=>'Hapus',
                                        'type'=>'raw',
                                        'value'=>'($data->invkalibrasi_id)?CHtml::link("<i class=\'glyphicon glyphicon-trash\'></i> ", "javascript:deleteRecord($data->invkalibrasi_id)",array("id"=>"$data->invkalibrasi_id","rel"=>"tooltip","title"=>"Hapus Kalibrasi")):CHtml::link("<i class=\'glyphicon glyphicon-trash\'></i> ", "javascript:deleteRecord($data->invkalibrasi_id)",array("id"=>"$data->invkalibrasi_id","rel"=>"tooltip","title"=>"Hapus Kalibrasi"));',
                                        'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
                                ),        
		),
	   
	)); ?>
    </div>
</div>
<div class="form-actions ">
    <?php
    echo "<table><tr><td>";
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' =>(isset($_GET['sukses']))? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)','disabled'=>(isset($_GET['sukses']))? true : false));
    echo "</td>";
    echo "<td>";
    echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
    $this->createUrl($this->id.'/index'.'&id='.$_GET['id']),
    array('class'=>'btn btn-danger controls',
    'onclick'=>'return refreshForm(this);'));
    echo "</td></tr></table>";
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);
    ?>
</div>
<br>
<?php $this->endWidget(); ?>
<?php
/* ====================================== Widget Dialog Nama Pelaksana ====================================== */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Daftar Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'resizable' => false,
    ),
));
$modPegawai = new PegawaiM('search');
$modPegawai->unsetAttributes();
if (isset($_GET['PegawaiM'])) {
    $modPegawai->attributes = $_GET['PegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-m-grid',
    'dataProvider' => $modPegawai->search(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                    "id" => "selectPegawai",
                    "onClick" => "
						$(\"#' . CHtml::activeId($model, 'pegawai') . '\").val(\"$data->nama_pegawai\");
                                                $(\"#' . CHtml::activeId($model, 'pegpelaksana_id') . '\").val(\"$data->pegawai_id\");
                        $(\"#dialogPegawai\").dialog(\"close\");
                    "))',
        ),
        'nama_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){
            // $("#kategoritindakan_id").val($("#idKategori").val());
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
/* ====================================== endWidget Dialog Nama Pelaksana ====================================== */
?>
<?php
/* ====================================== Widget Dialog Nama Supplier ====================================== */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogSupplier',
    'options' => array(
        'title' => 'Daftar Supplier',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'resizable' => false,
    ),
));
$modPegawai = new SupplierM('search');
$modPegawai->unsetAttributes();
if (isset($_GET['SupplierM'])) {
    $modPegawai->attributes = $_GET['SupplierM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'Supplier-m-grid',
    'dataProvider' => $modPegawai->search(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                    "id" => "selectSupplier",
                    "onClick" => "
						$(\"#' . CHtml::activeId($model, 'vendor') . '\").val(\"$data->supplier_nama\");
                                                $(\"#' . CHtml::activeId($model, 'supplier_id') . '\").val(\"$data->supplier_id\");
                        $(\"#dialogSupplier\").dialog(\"close\");
                    "))',
        ),
        'supplier_nama',
    ),
    'afterAjaxUpdate' => 'function(id, data){
            // $("#kategoritindakan_id").val($("#idKategori").val());
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
/* ====================================== endWidget Dialog Nama  Supplier ====================================== */
?>
<script>
    function deleteRecord(id) {
        var id = id;
        console.log(id);
        var url = '<?php echo $url."/delete"; ?>';
        myConfirm('Yakin Akan Menghapus Data ini ?','Perhatian!',function(r){
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'sukses'){
                                $.fn.yiiGridView.update('data-m-grid');
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
           }
        });
    }
</script>