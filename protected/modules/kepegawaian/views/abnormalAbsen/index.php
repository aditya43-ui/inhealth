<?php
$this->breadcrumbs = array(
    'Pengajuan Abnormal Absen' => array('index')
);

?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Pengajuan <b>Abnormal Absen</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php
            $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'id' => 'abnormal-absen-t-frm',
                'enableAjaxValidation' => false,
                'type' => 'horizontal',
                'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
            ));
        ?>
         <div class="row-fluid">
             <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->label($model, 'tglpengajuan', array('class' => 'control-label required','label'=>'Tanggal Pengajuan <span class="required">*</span>')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglpengajuan',
                            'mode' => 'datetime',
                            'options' => array(
                                'showOn' => false,
                                'yearRange' => "-150:+0",
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,  'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"
                            ),
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Pegawai Mengajukan', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model,'pegawai_id') ?>
                        <?php echo $form->textField($model, 'nama_pegawai', array('readonly'=>true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Unit Kerja', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'nama_unitkerja', array('readonly'=>true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->label($model, 'tglabnormalabsen', array('class' => 'control-label required','label'=>'Tanggal Presensi <span class="required">*</span>')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglabnormalabsen',
                            'mode' => 'datetime',
                            'options' => array(
                                'showOn' => false,
                                'yearRange' => "-150:+0",
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,  'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"
                            ),
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'jammasuk', array('class' => 'control-label required','label'=>'Jam Masuk <span class="required">*</span>')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'jammasuk',
                            'mode' => 'time',
                            'options' => array(
                                'showOn' => false,
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'width:120px;'
                            ),
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'jamkeluar', array('class' => 'control-label required','label'=>'Jam Keluar <span class="required">*</span>')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'jamkeluar',
                            'mode' => 'time',
                            'options' => array(
                                'showOn' => false,
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'width:120px;'
                            ),
                        )); ?>
                    </div>
                </div>

             </div>
             <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'alasan', array('class' => 'control-label required','label'=>'Alasan <span class="required">*</span>')); ?>
                    <div class="controls">
                        <?php
                            echo $form->dropdownList($model, 'alasan', LookupM::getItems('alasanabnormalabsen'), array('class'=>'span3','empty'=>'Pilih'));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'keterangan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($model, 'keterangan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'pegawaimengetahui_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'pegawaimengetahui_id'); ?>
                        <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'pegawaimengetahui_nama',
                                'source' => 'js: function(request, response) {
                                                        $.ajax({
                                                            url: "' . $this->createUrl('AutocompletePegawai') . '",
                                                            dataType: "json",
                                                            data: {
                                                                term: request.term
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
                                                    $("#' . CHtml::activeId($model, 'pegawaimengetahui_nama') . '").val( ui.item.label );
                                                    return false;
                                                }',
                                    'select' => 'js:function( event, ui ) {
                                                    $("#' . CHtml::activeId($model, 'pegawaimengetahui_id') . '").val( ui.item.value );
                                                    $("#' . CHtml::activeId($model, 'pegawaimengetahui_nama') . '").val( ui.item.label );
                                                    return false;
                                                }',
                                ),
                                'tombolDialog' => array("idDialog" => 'dlgPegMengetahui'),
                                'htmlOptions' => array( 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'pegawaimenyetujui_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'pegawaimenyetujui_id'); ?>
                        <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'pegawaimenyetujui_nama',
                                'source' => 'js: function(request, response) {
                                                        $.ajax({
                                                            url: "' . $this->createUrl('AutocompletePegawai') . '",
                                                            dataType: "json",
                                                            data: {
                                                                term: request.term
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
                                                    $("#' . CHtml::activeId($model, 'pegawaimenyetujui_nama') . '").val( ui.item.label );
                                                    return false;
                                                }',
                                    'select' => 'js:function( event, ui ) {
                                                    $("#' . CHtml::activeId($model, 'pegawaimenyetujui_id') . '").val( ui.item.value );
                                                    $("#' . CHtml::activeId($model, 'pegawaimenyetujui_nama') . '").val( ui.item.label );
                                                    return false;
                                                }',
                                ),
                                'tombolDialog' => array("idDialog" => 'dlgPegMenyetujui'),
                                'htmlOptions' => array( 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                    </div>
                </div>

             </div>
         </div>   
         <div class="form-actions">
             <?php 
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                );
                echo '&nbsp;';
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'return refreshForm(this);'
                    )
                );
             ?>
         </div>   
        <?php $this->endWidget(); ?>
    </div>
</div>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dlgPegMengetahui',
    'options' => array(
        'title' => 'Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'zIndex'=>1002,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));
?>

<?php
    $modPegMenge = new PegawaiM();					
    if (isset($_GET['PegawaiM'])) {
        $modPegMenge->attributes = $_GET['PegawaiM'];	
    }
				
    $this->widget('bootstrap.widgets.BootGridView',array(
        'id'=>'pegmenge-m-grid',
        'dataProvider'=>$modPegMenge->searchPegawaiDialog(),
        'filter'=>$modPegMenge,					
        'itemsCssClass' => 'table table-bordered datatable dataTable',
        'columns'=>array(		
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                        "href"=>"",
                        "id" => "selectObat",
                        "onClick" => "
                                        $(\"#'.CHtml::activeId($model,'pegawaimengetahui_id').'\").val(\"$data->pegawai_id\");
                                        $(\"#'.CHtml::activeId($model,'pegawaimengetahui_nama').'\").val(\"$data->NamaLengkap\");
                                        $(\"#dlgPegMengetahui\").dialog(\"close\"); 
                                        return false;
                            "))',
                ),
                'nomorindukpegawai',
                array(
                    'header' => 'Nama Pegawai',
                    'name' => 'nama_pegawai',
                    'value' => '$data->namaLengkap'
                ),							
                array(
                    'header' => 'Unit Kerja',
                    'name' => 'unitkerja_id',
                    'value' => function($data){
                        if (!empty($data->unitkerja)){
                            return $data->unitkerja->namaunitkerja;
                        }else{
                            return '-';
                        }
                    },
                    'filter' => CHtml::activeDropDownList($modPegMenge, 'unitkerja_id', CHtml::listData(UnitkerjaM::model()->findAll(" unitkerja_aktif = TRUE ORDER BY namaunitkerja ASC "), 'unitkerja_id', 'namaunitkerja'),array('class'=>'form-control','empty'=>'-- Choose --'))
                ),																								
            
        ),
    ));
							
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dlgPegMenyetujui',
    'options' => array(
        'title' => 'Pegawai Menyetujui',
        'autoOpen' => false,
        'modal' => true,
        'zIndex'=>1002,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));
?>

<?php
    $modPegMenye = new PegawaiM();					
    if (isset($_GET['PegawaiM'])) {
        $modPegMenye->attributes = $_GET['PegawaiM'];	
    }
				
    $this->widget('bootstrap.widgets.BootGridView',array(
        'id'=>'pegmenye-m-grid',
        'dataProvider'=>$modPegMenye->searchPegawaiDialog(),
        'filter'=>$modPegMenye,					
        'itemsCssClass' => 'table table-bordered datatable dataTable',
        'columns'=>array(		
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                        "href"=>"",
                        "id" => "selectObat",
                        "onClick" => "
                                        $(\"#'.CHtml::activeId($model,'pegawaimenyetujui_id').'\").val(\"$data->pegawai_id\");
                                        $(\"#'.CHtml::activeId($model,'pegawaimenyetujui_nama').'\").val(\"$data->NamaLengkap\");
                                        $(\"#dlgPegMenyetujui\").dialog(\"close\"); 
                                        return false;
                            "))',
                ),
                'nomorindukpegawai',
                array(
                    'header' => 'Nama Pegawai',
                    'name' => 'nama_pegawai',
                    'value' => '$data->namaLengkap'
                ),							
                array(
                    'header' => 'Unit Kerja',
                    'name' => 'unitkerja_id',
                    'value' => function($data){
                        if (!empty($data->unitkerja)){
                            return $data->unitkerja->namaunitkerja;
                        }else{
                            return '-';
                        }
                    },
                    'filter' => CHtml::activeDropDownList($modPegMenye, 'unitkerja_id', CHtml::listData(UnitkerjaM::model()->findAll(" unitkerja_aktif = TRUE ORDER BY namaunitkerja ASC "), 'unitkerja_id', 'namaunitkerja'),array('class'=>'form-control','empty'=>'-- Choose --'))
                ),																								
            
        ),
    ));
							
$this->endWidget();
?>