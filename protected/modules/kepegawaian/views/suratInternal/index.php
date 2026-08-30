<?php
$this->breadcrumbs = array(
    'Pencatatan Surat Internal' => array('index')
);

?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Transaksi <b>Pencatatan Surat Internal</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php
            $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'id' => 'suratinternal-t-frm',
                'enableAjaxValidation' => false,
                'type' => 'horizontal',
                'htmlOptions' => array('enctype' => 'multipart/form-data','onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
            ));
        ?>
         <div class="row-fluid">
             <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'jenissurat', array('class' => 'control-label required','label'=>'Jenis Surat <span class="required">*</span>')); ?>
                    <div class="controls">
                        <?php
                            echo $form->dropdownList($model, 'jenissurat', LookupM::getItems('jenissurat'), array('class'=>'span3','empty'=>'Pilih','onchange'=>'changeJenisSurat()'));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->label($model, 'tglsurat', array('class' => 'control-label required','label'=>'Tanggal Surat <span class="required">*</span>')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglsurat',
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
                <div class="control-group pnl_jenissuratkeluar">
                    <?php echo $form->labelEx($model, 'tipesurat', array('class' => 'control-label required','label'=>'Tipe Surat <span class="required">*</span>')); ?>
                    <div class="controls">
                        <?php
                            echo $form->dropdownList($model, 'tipesurat', LookupM::getItems('tipesurat'), array('class'=>'span3','empty'=>'Pilih'));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Nomor Surat <span class="required">*</span>', '', array('class' => 'control-label required')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'nomorsurat', array('readonly'=>true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group pnl_jenissuratmasuk">
                    <?php echo CHtml::label('Asal Surat <span class="required">*</span>', '', array('class' => 'control-label required')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'asalsurat', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group pnl_jenissuratmou pnl_jenissuratizin">
                    <?php echo $form->label($model, 'tglmulaiberlaku', array('class' => 'control-label required','label'=>'Tanggal Mulai Berlaku <span class="required">*</span>')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglmulaiberlaku',
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
                <div class="control-group pnl_jenissuratmou pnl_jenissuratizin">
                    <?php echo $form->label($model, 'tglakhirberlaku', array('class' => 'control-label required','label'=>'Tanggal Akhir Berlaku <span class="required">*</span>')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglakhirberlaku',
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
             </div>
             <div class="col-sm-6">
                <div class="control-group pnl_jenissuratkeluar">
                    <?php echo CHtml::label('Tujuan <span class="required">*</span>', '', array('class' => 'control-label required')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'tujuansurat', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group pnl_jenissuratkeluar pnl_jenissuratmasuk">
                    <?php echo CHtml::label('Perihal <span class="required">*</span>', '', array('class' => 'control-label required')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'perihal', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>

                <div class="control-group pnl_jenissuratkeluar">
                    <?php echo $form->labelEx($model, 'jenisdistribusi', array('class' => 'control-label required','label'=>'Jenis distribusi <span class="required">*</span>')); ?>
                    <div class="controls">
                        <?php
                            echo $form->dropdownList($model, 'jenisdistribusi', LookupM::getItems('jenisdistribusisurat'), array('class'=>'span3','empty'=>'Pilih'));
                        ?>
                    </div>
                </div>
                <div class="control-group pnl_jenissuratmasuk">
                    <?php echo $form->label($model, 'tgldisposisi', array('class' => 'control-label','label'=>'Tanggal Disposisi')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgldisposisi',
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
                <div class="control-group pnl_jenissuratmasuk">
                    <?php echo CHtml::label('Tujuan Disposisi', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <table width="100%" id="tbl_tujuandisposisi">
                            <tbody>
                           
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="control-group pnl_jenissuratmou pnl_jenissuratizin">
                    <?php echo CHtml::label('Judul <span class="required">*</span>', '', array('class' => 'control-label required')) ?>
                    <div class="controls">
                        <?php echo $form->textArea($model, 'judul', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group pnl_jenissuratmou pnl_jenissuratizin">
                    <?php echo CHtml::label('Pihak 1 <span class="required">*</span>', '', array('class' => 'control-label required')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'pihak1', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group pnl_jenissuratmou pnl_jenissuratizin">
                    <?php echo CHtml::label('Pihak 2 <span class="required">*</span>', '', array('class' => 'control-label required')) ?>
                    <div class="controls">
                        <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'pihak2',
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
                                                    $("#' . CHtml::activeId($model, 'pihak2') . '").val( ui.item.label );
                                                    return false;
                                                }',
                                    'select' => 'js:function( event, ui ) {
                                                    $("#' . CHtml::activeId($model, 'pihak2') . '").val( ui.item.label );
                                                    return false;
                                                }',
                                ),
                                'tombolDialog' => array("idDialog" => 'dlgPihak'),
                                'htmlOptions' => array( 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                        ?>
                    </div>
                </div>
                <div class="control-group pnl_jenissuratmou pnl_jenissuratizin">
                    <?php echo CHtml::label('Unit Kerja Penanggung Jawab', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'unitkerja_penanggungjawab_id'); ?>
                        <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'unitkerja_penanggungjawab_nama',
                                'source' => 'js: function(request, response) {
                                                        $.ajax({
                                                            url: "' . $this->createUrl('AutocompleteUnitkerja') . '",
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
                                                    $("#' . CHtml::activeId($model, 'unitkerja_penanggungjawab_nama') . '").val( ui.item.label );
                                                    return false;
                                                }',
                                    'select' => 'js:function( event, ui ) {
                                                    $("#' . CHtml::activeId($model, 'unitkerja_penanggungjawab_id') . '").val( ui.item.value );
                                                    $("#' . CHtml::activeId($model, 'unitkerja_penanggungjawab_nama') . '").val( ui.item.label );
                                                    return false;
                                                }',
                                ),
                                'tombolDialog' => array("idDialog" => 'dlgUnitKerja'),
                                'htmlOptions' => array( 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Dokumentasi Kegiatan", '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->fileField($model, 'dokumen', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
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
<?php $this->renderPartial('_jsFunctions', array('model'=>$model)); ?>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Pencarian Tujuan Disposisi',
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
    $modPegwai = new PegawaiM();					
    if (isset($_GET['PegawaiM'])) {
        $modPegwai->attributes = $_GET['PegawaiM'];	
    }
				
    $this->widget('bootstrap.widgets.BootGridView',array(
        'id'=>'pegawai-m-grid',
        'dataProvider'=>$modPegwai->searchPegawaiDialog(),
        'filter'=>$modPegwai,					
        'itemsCssClass' => 'table table-bordered datatable dataTable',
        'columns'=>array(		
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                        "href"=>"",
                        "id" => "selectObat",
                        "onClick" => "
                            setPegawaiAuto($data->pegawai_id,\"$data->NamaLengkap\");
                            $(\"#dialogPegawai\").dialog(\"close\"); 
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
                    'filter' => CHtml::activeDropDownList($modPegwai, 'unitkerja_id', CHtml::listData(UnitkerjaM::model()->findAll(" unitkerja_aktif = TRUE ORDER BY namaunitkerja ASC "), 'unitkerja_id', 'namaunitkerja'),array('class'=>'form-control','empty'=>'-- Choose --'))
                ),																								
            
        ),
    ));
							
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dlgPihak',
    'options' => array(
        'title' => 'Pencarian Pihak 2',
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
                        "id" => "selectPihak",
                        "onClick" => "
                                        $(\"#'.CHtml::activeId($model,'pihak2').'\").val(\"$data->NamaLengkap\");
                                        $(\"#dlgPihak\").dialog(\"close\"); 
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

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dlgUnitKerja',
    'options' => array(
        'title' => 'Pencarian Unit Kerja Penanggung Jawab',
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
    $modUnitkerja = new UnitkerjaM();					
    if (isset($_GET['UnitkerjaM'])) {
        $modUnitkerja->attributes = $_GET['UnitkerjaM'];	
    }
				
    $this->widget('bootstrap.widgets.BootGridView',array(
        'id'=>'unitkerja-m-grid',
        'dataProvider'=>$modUnitkerja->searchDialog(),
        'filter'=>$modUnitkerja,					
        'itemsCssClass' => 'table table-bordered datatable dataTable',
        'columns'=>array(		
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                        "href"=>"",
                        "id" => "selectPihak",
                        "onClick" => "
                                        $(\"#'.CHtml::activeId($model,'unitkerja_penanggungjawab_id').'\").val(\"$data->unitkerja_id\");
                                        $(\"#'.CHtml::activeId($model,'unitkerja_penanggungjawab_nama').'\").val(\"$data->namaunitkerja\");
                                        $(\"#dlgUnitKerja\").dialog(\"close\"); 
                                        return false;
                            "))',
                ),
                array(
                    'header' => 'Nama Unit Kerja',
                    'name' => 'namaunitkerja',
                    'value' => '$data->namaunitkerja'
                )																								
            
        ),
    ));
							
$this->endWidget();
?>