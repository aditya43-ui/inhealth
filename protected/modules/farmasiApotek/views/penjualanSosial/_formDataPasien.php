<?php
    $nama_kapital = ((Yii::app()->user->getState('nama_huruf_capital') == true) ? "all-caps":"");
    $alamat_kapital = ((Yii::app()->user->getState('alamat_huruf_capital') == true) ? "all-caps":"");
?>
<div class="span5">
    <?php echo CHtml::hiddenField('supplier_id',"", array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <?php echo CHtml::hiddenField('permohonanoa_id',$modPermohonanOa->permohonanoa_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)",)); ?>
    <?php echo $form->textFieldRow($modPermohonanOa,'permohonanoa_nomor',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <div class="control-group">
        <?php echo $form->labelEx($modPermohonanOa,'permohonanoa_tgl', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php   
                    $modPermohonanOa->permohonanoa_tgl = (!empty($modPermohonanOa->permohonanoa_tgl) ? date("d/m/Y H:i:s",strtotime($modPermohonanOa->permohonanoa_tgl)) : null);
                    $this->widget('MyDateTimePicker',array(
                        'model'=>$modPermohonanOa,
                        'attribute'=>'permohonanoa_tgl',
                        'mode'=>'datetime',
                        'options'=> array(
//                            'dateFormat'=>Params::DATE_FORMAT,
                            'showOn' => false,
                            'maxDate' => 'd',
                            'yearRange'=> "-150:+0",
                        ),
                        'htmlOptions'=>array('placeholder'=>'00/00/0000 00:00:00','class'=>'dtPicker2 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"
                        ),
                )); ?>
            </div>
    </div>
    
    <div class="control-group">
        <?php echo $form->labelEx($modPermohonanOa,'pemohon_noidentitas', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modPermohonanOa,'pemohon_jenisidentitas', LookupM::getItems('jenisidentitas'),  
                        array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1','style'=>'float:left; width:80px')); ?>   
            <?php echo $form->textField($modPermohonanOa,'pemohon_noidentitas',array('placeholder'=>'No. Identitas','class'=>'span2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    
    <div class="control-group">
        <?php echo $form->labelEx($modPermohonanOa,'pemohon_nama', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($modPermohonanOa,'pemohon_nama',array('placeholder'=>'Nama Pemohon','class'=>'span3 '.$nama_kapital, 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>    
    <?php echo $form->radioButtonListInlineRow($modPermohonanOa, 'pemohon_jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'')); ?>    
    <?php echo $form->textAreaRow($modPermohonanOa,'pemohon_alamat',array('placeholder'=>'Alamat Lengkap Pasien','rows'=>2, 'cols'=>50, 'class'=>'span3 '.$alamat_kapital, 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <div class="control-group">
        <?php echo $form->labelEx($modPermohonanOa,'rt', array('class'=>'control-label inline')) ?>
        <div class="controls">
            <?php echo $form->textField($modPermohonanOa,'rt', array('onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numbers-only','maxlength'=>3,'placeholder'=>'RT')); ?>   / 
            <?php echo $form->textField($modPermohonanOa,'rw', array('onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numbers-only','maxlength'=>3,'placeholder'=>'RW')); ?>            
            <?php echo $form->error($modPermohonanOa, 'rt'); ?>
            <?php echo $form->error($modPermohonanOa, 'rw'); ?>
        </div>
    </div>
</div>
<div class="span5">
    <div class="control-group">
        <?php echo $form->labelEx($modPermohonanOa,'propinsi_id', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modPermohonanOa,'propinsi_id', CHtml::listData($modPermohonanOa->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), 
                        array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                'ajax'=>array('type'=>'POST',
                                            'url'=>$this->createUrl('SetDropdownKabupaten',array('encode'=>false,'model_nama'=>get_class($modPermohonanOa))),
                                            'update'=>"#".CHtml::activeId($modPermohonanOa, 'kabupaten_id'),
                                ),
                                'onchange'=>"setClearDropdownKelurahan();setClearDropdownKecamatan();",));?>
            <?php echo $form->error($modPermohonanOa, 'propinsi_id'); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($modPermohonanOa,'kabupaten_id', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modPermohonanOa,'kabupaten_id', CHtml::listData($modPermohonanOa->getKabupatenItems($modPermohonanOa->propinsi_id), 'kabupaten_id', 'kabupaten_nama'), 
                        array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                'ajax'=>array('type'=>'POST',
                                            'url'=>$this->createUrl('SetDropdownKecamatan',array('encode'=>false,'model_nama'=>get_class($modPermohonanOa))),
                                            'update'=>"#".CHtml::activeId($modPermohonanOa, 'kecamatan_id'),
                                ),
                                'onchange'=>"setClearDropdownKelurahan();",));?>
            <?php echo $form->error($modPermohonanOa, 'kabupaten_id'); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($modPermohonanOa,'kecamatan_id', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modPermohonanOa,'kecamatan_id', CHtml::listData($modPermohonanOa->getKecamatanItems($modPermohonanOa->kabupaten_id), 'kecamatan_id', 'kecamatan_nama'), 
                        array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                'ajax'=>array('type'=>'POST',
                                            'url'=>$this->createUrl('SetDropdownKelurahan',array('encode'=>false,'model_nama'=>get_class($modPermohonanOa))),
                                            'update'=>"#".CHtml::activeId($modPermohonanOa, 'kelurahan_id'),
                                ),
                                'onchange'=>"",));?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($modPermohonanOa,'kelurahan_id', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modPermohonanOa,'kelurahan_id',CHtml::listData($modPermohonanOa->getKelurahanItems($modPermohonanOa->kecamatan_id), 'kelurahan_id', 'kelurahan_nama'),
                                              array('empty'=>'-- Pilih --', 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->error($modPermohonanOa, 'kelurahan_id'); ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($modPermohonanOa,'pemohon_notelp',array('placeholder'=>'No. Telepon','class'=>'span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
    <?php echo $form->textFieldRow($modPermohonanOa,'pemohon_nomobile',array('placeholder'=>'No. Handphone','class'=>'span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>15)); ?>
</div>
<div class="span5">    
    <?php echo $form->textFieldRow($modPermohonanOa,'pemohon_alamatemail',array('placeholder'=>'contoh: info@pinformasi.com','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
    <?php echo $form->textAreaRow($modPermohonanOa,'permohonan_alasan',array('placeholder'=>'Ket. Permohonan','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <?php echo $form->textAreaRow($modPermohonanOa,'permohonan_keterangan',array('placeholder'=>'Alasan Permohonan','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <div class="control-group">
        <?php echo $form->labelEx($modPermohonanOa, 'pegawaimengetahui_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->hiddenField($modPermohonanOa, 'pegawaimengetahui_id',array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model'=>$modPermohonanOa,
                'attribute' => 'pegawaimengetahui_nama',
                'source' => 'js: function(request, response) {
                                   $.ajax({
                                       url: "' . $this->createUrl('AutocompletePegawaiMengetahui') . '",
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
                        $("#'.Chtml::activeId($modPermohonanOa, 'pegawaimengetahui_id') . '").val(ui.item.pegawai_id); 
                        return false;
                    }',
                ),
                'htmlOptions' => array(
                    'class'=>'pegawaimengetahui_nama',
                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                    'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modPermohonanOa, 'pegawaimengetahui_id') . '").val(""); '
                ),
                'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($modPermohonanOa, 'pegawaimenyetujui_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->hiddenField($modPermohonanOa, 'pegawaimenyetujui_id',array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model'=>$modPermohonanOa,
                'attribute' => 'pegawaimenyetujui_nama',
                'source' => 'js: function(request, response) {
                                   $.ajax({
                                       url: "' . $this->createUrl('AutocompletePegawaiMenyetujui') . '",
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
                        $("#'.Chtml::activeId($modPermohonanOa, 'pegawaimenyetujui_id') . '").val(ui.item.pegawai_id); 
                        return false;
                    }',
                ),
                'htmlOptions' => array(
                    'class'=>'pegawaimenyetujui_nama',
                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                    'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modPermohonanOa, 'pegawaimenyetujui_id') . '").val(""); '
                ),
                'tombolDialog' => array('idDialog' => 'dialogPegawaiMenyetujui'),
            ));
            ?>
        </div>
    </div>
</div>
<?php 
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMengetahui',
    'options'=>array(
        'title'=>'Pencarian Pegawai Mengetahui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiMengetahui = new FAPegawaiV('search');
$modPegawaiMengetahui->unsetAttributes();
if(isset($_GET['FAPegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['FAPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimengetahui-grid',
	'dataProvider'=>$modPegawaiMengetahui->search(),
	'filter'=>$modPegawaiMengetahui,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($modPermohonanOa,'pegawaimengetahui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($modPermohonanOa,'pegawaimengetahui_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
                ),
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
                    'value'=>'$data->nama_pegawai',
                ),
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ),
                array(
                    'header'=>'Alamat Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'alamat_pegawai'),
                    'value'=>'$data->alamat_pegawai',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>

<?php 
//========= Dialog buat cari data Pegawai Menyetujui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMenyetujui',
    'options'=>array(
        'title'=>'Pencarian Pegawai Menyetujui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiMenyetujui = new FAPegawaiV('search');
$modPegawaiMenyetujui->unsetAttributes();
if(isset($_GET['FAPegawaiV'])) {
    $modPegawaiMenyetujui->attributes = $_GET['FAPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimenyetujui-grid',
	'dataProvider'=>$modPegawaiMenyetujui->search(),
	'filter'=>$modPegawaiMenyetujui,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($modPermohonanOa,'pegawaimenyetujui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($modPermohonanOa,'pegawaimenyetujui_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMenyetujui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
                ),
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'nama_pegawai'),
                    'value'=>'$data->nama_pegawai',
                ),
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ),
                array(
                    'header'=>'Alamat Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'alamat_pegawai'),
                    'value'=>'$data->alamat_pegawai',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Menyetujui dialog =============================
?>