<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'konfigkoperasi-k-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">

    <div class="col-sm-4">
        <?php echo $form->textFieldRow($model, 'persjasasimpanan', array('class' => 'span3 float2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'persjasapinjaman', array('class' => 'span3 float2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'persdanapengurus', array('class' => 'span3 float2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'persdanakaryawan', array('class' => 'span3 float2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'persdanapendidikan', array('class' => 'span3 float2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'persdanasosial', array('class' => 'span3 float2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'persdanacadangan', array('class' => 'span3 float2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'persbiayaprovisasi', array('class' => 'span3 float2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'persjasadeposito', array('class' => 'span3 float2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    </div>
    <div class="col-sm-4">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'pimpinankoperasi_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pimpinankoperasi_id', array('readonly' => true)); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'pimpinan_nama',
                    'source' => 'js: function(request, response) {
										$.ajax({
											url: "' . $this->createUrl('AutocompletePegawaiKoperasi') . '",
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
								$("#' . CHtml::activeId($model, 'pimpinankoperasi_id') . '").val(ui.item.pegawai_id); 
								return false;
							}',
                    ),
                    'htmlOptions' => array(
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#' . CHtml::activeId($model, 'pimpinankoperasi_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawai', 'jsFunction' => 'bukaDialog(0);'),
                ));
                ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'penguruskoperasi_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'penguruskoperasi_id', array('readonly' => true)); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'pengurus_nama',
                    'source' => 'js: function(request, response) {
										$.ajax({
											url: "' . $this->createUrl('AutocompletePegawaiKoperasi') . '",
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
								$("#' . CHtml::activeId($model, 'penguruskoperasi_id') . '").val(ui.item.pegawai_id); 
								return false;
							}',
                    ),
                    'htmlOptions' => array(
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#' . CHtml::activeId($model, 'penguruskoperasi_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawai', 'jsFunction' => 'bukaDialog(1);'),
                ));
                ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'bendaharakoperasi_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'bendaharakoperasi_id', array('readonly' => true)); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'bendahara_nama',
                    'source' => 'js: function(request, response) {
										$.ajax({
											url: "' . $this->createUrl('AutocompletePegawaiKoperasi') . '",
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
								$("#' . CHtml::activeId($model, 'bendaharakoperasi_id') . '").val(ui.item.pegawai_id); 
								return false;
							}',
                    ),
                    'htmlOptions' => array(
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#' . CHtml::activeId($model, 'bendaharakoperasi_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawai', 'jsFunction' => 'bukaDialog(2);'),
                ));
                ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'bendaharars_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'bendaharars_id', array('readonly' => true)); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'bendahara_rs_nama',
                    'source' => 'js: function(request, response) {
										$.ajax({
											url: "' . $this->createUrl('AutocompletePegawaiKoperasi') . '",
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
								$("#' . CHtml::activeId($model, 'bendaharars_id') . '").val(ui.item.pegawai_id); 
								return false;
							}',
                    ),
                    'htmlOptions' => array(
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#' . CHtml::activeId($model, 'bendaharars_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawai', 'jsFunction' => 'bukaDialog(3);'),
                ));
                ?>
            </div>
        </div>

        <?php // echo $form->textFieldRow($model,'pimpinankoperasi_id',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php // echo $form->textFieldRow($model,'penguruskoperasi_id',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php // echo $form->textFieldRow($model,'bendaharakoperasi_id',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php // echo $form->textFieldRow($model,'bendaharars_id',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>

        <?php // echo $form->checkBoxRow($model,'status_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php // echo $form->textFieldRow($model,'create_time',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php // echo $form->textFieldRow($model,'update_time',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php // echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3 float2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php // echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3 float2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php // echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3 float2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
    </div>
    <div class="col-sm-4">

    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Konfigurasi Koperasi', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>

<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Pencarian Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$pegawaiKoperasi = new PegawaiV();
$pegawaiKoperasi->unsetAttributes();

if (isset($_GET['PegawaiV'])) {
    $pegawaiKoperasi->attributes = $_GET['PegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-grid',
    'dataProvider' => $pegawaiKoperasi->search(),
    'filter' => $pegawaiKoperasi,
    //'template'=>"{items}\n{pager}",
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
												  pilihPegawai(\"".$data->pegawai_id."\",\"".$data->nama_pegawai."\");
                                                  $(\"#dialogPegawai\").dialog(\"close\"); 
                                                  
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'filter' =>  CHtml::activeTextField($pegawaiKoperasi, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ), /*
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($pegawaiKoperasi, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ), */
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($pegawaiKoperasi, 'nama_pegawai'),
            'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
        ), /*
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($pegawaiKoperasi, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ), */
        array(
            'header' => 'Alamat Pegawai',
            'filter' =>  CHtml::activeTextField($pegawaiKoperasi, 'alamat_pegawai'),
            'value' => '$data->alamat_pegawai',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>

<script>
    var tipe_pegawai = 0;

    function bukaDialog(tipe) {
        tipe_pegawai = tipe;
        $("#dialogPegawai").dialog("open");
    }

    function pilihPegawai(id, nama) {
        switch (tipe_pegawai) {
            case 0:
                $("#KonfigkoperasiK_pimpinankoperasi_id").val(id);
                $("#KonfigkoperasiK_pimpinan_nama").val(nama);
                break;
            case 1:
                $("#KonfigkoperasiK_penguruskoperasi_id").val(id);
                $("#KonfigkoperasiK_pengurus_nama").val(nama);
                break;
            case 2:
                $("#KonfigkoperasiK_bendaharakoperasi_id").val(id);
                $("#KonfigkoperasiK_bendahara_nama").val(nama);
                break;
            case 3:
                $("#KonfigkoperasiK_bendaharars_id").val(id);
                $("#KonfigkoperasiK_bendahara_rs_nama").val(nama);
                break;
        }
    }
</script>