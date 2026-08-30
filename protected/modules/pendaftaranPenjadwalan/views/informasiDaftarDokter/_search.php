<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal',
	'focus'=>'#'.CHtml::activeId($modDokter,'nama_pegawai'),
	'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),
)); ?>
<fieldset class="box">
    <legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
	<div class="row">
            <div class="col-sm-4">
                <div class="control-group">  
                    <?php echo CHtml::label('NIP','nomorindukpegawai', array('class'=>'control-label')); ?> 
                    <div class="controls">
                        <?php echo $form->hiddenField($modDokter,'pegawai_id'); ?>
                        <?php 
                            $this->widget('MyJuiAutoComplete', array(
                                    'model'=>$modDokter,
                                    'attribute'=>'nomorindukpegawai',
                                    'source'=>'js: function(request, response) {
                                                               $.ajax({
                                                                       url: "'.$this->createUrl('AutocompleteDokter').'",
                                                                       dataType: "json",
                                                                       data: {
                                                                               nomorindukpegawai: request.term,
                                                                       },
                                                                       success: function (data) {
                                                                                       response(data);
                                                                       }
                                                               })
                                                            }',
                                     'options'=>array(
                                               'minLength' => 3,
                                                    'focus'=> 'js:function( event, ui ) {
                                                             $(this).val( "");
                                                             return false;
                                                     }',
                                               'select'=>'js:function( event, ui ) {
                                                            $(this).val( ui.item.value);
                                                            return false;
                                                    }',
                                    ),
                                    'tombolDialog'=>array('idDialog'=>'dialogDokterBadge'),
                                    'htmlOptions'=>array('placeholder'=>'NIP','rel'=>'tooltip','title'=>'Ketik NIP untuk mencari data dokter',
                                            'onkeyup'=>"return $(this).focusNextInputField(event)",
                                    ),
                            )); 
                        ?>
                    </div>          
                </div>
            </div>
            <div class="span8">
                <div class="control-group">  
                    <?php echo CHtml::label('Nama Dokter','nama_pegawai', array('class'=>'control-label')); ?> 
                    <div class="controls">
                        <?php echo $form->hiddenField($modDokter,'pegawai_id'); ?>
                        <?php 
                            $this->widget('MyJuiAutoComplete', array(
                                    'model'=>$modDokter,
                                    'attribute'=>'nama_pegawai',
                                    'source'=>'js: function(request, response) {
                                                               $.ajax({
                                                                       url: "'.$this->createUrl('AutocompleteDokter').'",
                                                                       dataType: "json",
                                                                       data: {
                                                                               nama_pegawai: request.term,
                                                                       },
                                                                       success: function (data) {
                                                                                       response(data);
                                                                       }
                                                               })
                                                            }',
                                     'options'=>array(
                                               'minLength' => 3,
                                                    'focus'=> 'js:function( event, ui ) {
                                                             $(this).val( "");
                                                             return false;
                                                     }',
                                               'select'=>'js:function( event, ui ) {
                                                            $(this).val( ui.item.nama_pegawai);
                                                            return false;
                                                    }',
                                    ),
                                    'tombolDialog'=>array('idDialog'=>'dialogDokterNama'),
                                    'htmlOptions'=>array('placeholder'=>'Nama Dokter','rel'=>'tooltip','title'=>'Ketik nama dokter untuk mencari data dokter',
                                            'onkeyup'=>"return $(this).focusNextInputField(event)",
                                    ),
                            )); 
                        ?>
                    </div>          
                </div>
            </div>
	</div>

	<div class="form-actions">
            <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('index'), array('class'=>'btn btn-danger')); ?>	
	</div>
<?php $this->endWidget(); ?>
<?php 
//========= Dialog buat cari data dokter berdasarkan badge =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogDokterBadge',
    'options'=>array(
        'title'=>'Pencarian Data Dokter',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>480,
        'resizable'=>false,
    ),
));
    $modDialogDokter = new PPPegawaiM('searchDokter');
    $modDialogDokter->unsetAttributes();
    if(isset($_GET['PPPegawaiM'])) {
        $modDialogDokter->attributes = $_GET['PPPegawaiM'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'datadokterbadge-grid',
            'dataProvider'=>$modDialogDokter->searchDokter(),
            'filter'=>$modDialogDokter,
            'template'=>"{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPendaftaran",
                                        "onClick" => "
                                            $(\"#'.CHtml::activeId($modDokter,'nomorindukpegawai').'\").val(\"$data->nomorindukpegawai\");
                                            $(\"#dialogDokterBadge\").dialog(\"close\");
                                        "))',
                    ),
                    array(
						'header'=>'No. Pegawai',
						'name'=>'nomorindukpegawai',
						'type'=>'raw',
						'value'=>'$data->nomorindukpegawai',
					),
					array(
						'header'=>'Nama Dokter',
						'name'=>'nama_pegawai',
						'type'=>'raw',
						'value'=>'$data->NamaLengkap',  
						'htmlOptions'=>array('style'=>'text-align: left')
					),
					array(
						'header'=>'Alamat',
						'name'=>'alamat_pegawai',
						'type'=>'raw',
						'value'=>'$data->alamat_pegawai',  
					), 
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));

$this->endWidget();
////======= end dialog dokter badge dialog =============
?>
<?php 
//========= Dialog buat cari data dokter berdasarkan nama =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogDokterNama',
    'options'=>array(
        'title'=>'Pencarian Data Dokter',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>480,
        'resizable'=>false,
    ),
));
    $modDialogDokter = new PPPegawaiM('searchDokter');
    $modDialogDokter->unsetAttributes();
    if(isset($_GET['PPPegawaiM'])) {
        $modDialogDokter->attributes = $_GET['PPPegawaiM'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'datadokternama-grid',
            'dataProvider'=>$modDialogDokter->searchDokter(),
            'filter'=>$modDialogDokter,
            'template'=>"{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPendaftaran",
                                        "onClick" => "
                                            $(\"#'.CHtml::activeId($modDokter,'nama_pegawai').'\").val(\"$data->nama_pegawai\");
                                            $(\"#dialogDokterNama\").dialog(\"close\");
                                        "))',
                    ),
                    array(
						'header'=>'No. Pegawai',
						'name'=>'nomorindukpegawai',
						'type'=>'raw',
						'value'=>'$data->nomorindukpegawai',
					),
					array(
						'header'=>'Nama Dokter',
						'name'=>'nama_pegawai',
						'type'=>'raw',
						'value'=>'$data->NamaLengkap',  
						'htmlOptions'=>array('style'=>'text-align: left')
					),
					array(
						'header'=>'Alamat',
						'name'=>'alamat_pegawai',
						'type'=>'raw',
						'value'=>'$data->alamat_pegawai',  
					), 
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));

$this->endWidget();
////======= end dialog dokter nama dialog =============
?>