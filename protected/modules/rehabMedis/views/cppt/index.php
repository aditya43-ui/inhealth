
<?php 
if(!empty($modPendaftaran)) {
    if($modPendaftaran->validasiRekamMedis()) {
       echo CustomFunction::alertRekamMedis();
    }
}
?>
<?php
    $this->breadcrumbs = array(
        'Catatan Perkembangan Pasien Terintegrasi',
    );
    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success',"Data berhasil disimpan");
    }
    $this->widget('bootstrap.widgets.BootAlert');

    $module = Yii::app()->user->getState('modul_id');
    // var_dump($module); die;
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php

if (!isset($_GET['frame']) || $_GET['frame'] != 1) {
    $this->renderPartial($this->path_view.'_dataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien)); 
}


?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title" style="width: 100%">
            <span style="float: left !important; width:80% !important;"><b>Catatan Perkembangan Pasien Terintegrasi</b></span><span style="float: right !important;">
               <?php
                //if (!empty(Yii::app()->request->urlReferrer)) {
                //    echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', $this->referer, array('class'=>'btn btn-red', 'style'=>'color: white;'));
                // } ?>
            </span>
        </div>
    </div>
    <div class="panel-body">
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'observasiigd-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
));
?>
        <?php echo $form->hiddenField($model, 'pendaftaran_id'); ?>
        <?php echo $form->hiddenField($model, 'pasienadmisi_id'); ?>
        <?php echo $form->hiddenField($model, 'pasien_id'); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><strong>Tambah Catatan Perkembangan Pasien Terintegrasi (CPPT)</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><strong>Riwayat Pemeriksaan Terakhir Pasien</strong></div>
                    </div>
                    <div class="panel-body">

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="control-group ">
                            <?php echo $form->labelEx($model,'tanggal_cppt', array('class'=>'control-label required', 'label'=>'Tanggal/ Jam Input CPPT <span class="required">*</span>')) ?>
                            <div class="controls">
                                <?php
                                    $this->widget('MyDateTimePicker',array(
                                    'model'=>$model,
                                    'attribute'=>'tanggal_cppt',
                                    'mode'=>'datetime',
                                    'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                            'maxDate' => 'd',
                                    ),
                                    'htmlOptions'=>array('readonly'=>true,'class'=>'span3','style'=>'width:150px;'),
                                )); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo $form->labelEx($model,'ppa_namajenis', array('class'=>'control-label required', 'label'=>'Profesional Pemberi Asuhan (PPA) <span class="required">*</span>')) ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'ppa_namajenis'); ?>
                                <?php
                                        echo $form->dropDownList($model, 'ppa_jenis', LookupM::getItems('cppt_pemberiasuhan'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'onchange'=>'changeJenisPPA(this)'));
                                       
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model,'ppa_namajenis', array('class'=>'control-label required', 'label'=>'Nama Profesional Pemberi Asuhan (PPA)<span class="required">*</span>')) ?>
                            <div class="controls">
                                <!-- Pegawai Ruangan -->
                                <?php 
                                 $gelarBelakang = GelarbelakangM::model()->findByPk(Yii::app()->user->getState('gelarbelakang_id'));
                                $gelarBelakangNama = $gelarBelakang->gelarbelakang_nama ?? '';
                                echo $form->hiddenField($model, 'pegawaippa_id', array('class'=>'pegawaippa_id', 'onkeypress' => "return $(this).focusNextInputField(event);",)); 
                               $pegawaippa_nama = Yii::app()->user->getState('gelardepan') . Yii::app()->user->getState('nama_pegawai') . ' ' . $gelarBelakangNama;
                                
                                $this->widget('MyJuiAutoComplete', array(
                                    'name'=>'pegawaippa_nama',
                                     'value'=>$pegawaippa_nama,
                                    'source'=>'js: function(request, response) {
                                                   $.ajax({
                                                       url: "'.$this->createUrl('autocompletePPA').'",
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
                                                $(this).val(ui.item.value);

                                                return false;
                                            }',
                                           'select'=>'js:function( event, ui ) {
                                                $(".pegawaippa_id").val(ui.item.pegawai_id);
                                                $(".pegawaippa_nama").val(ui.item.nama_pegawai);
                                                return false;
                                            }',
                                    ),
                                    'tombolDialog'=>array('idDialog'=>'dialogPegawaiPPA','idTombol'=>'tombolPPA'),
                                    'htmlOptions'=>array('class'=>'span3 pegawaippa_nama', 'placeholder'=>'Pegawai PPA','onkeypress'=>"return $(this).focusNextInputField(event)"),
                                ));
                                
                                ?>
                                
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model,'dpjp_id', array('class'=>'control-label required', 'label'=>'DPJP')) ?>
                            <div class="controls">
                                <!-- Dokter -->
                                <?php 
                                echo $form->hiddenField($model, 'dpjp_id', array('class'=>'dpjp_id','onkeypress' => "return $(this).focusNextInputField(event);",));
                                 
                                $dpjp_nama = !empty($modPendaftaran->pegawai) ? $modPendaftaran->pegawai->namaLengkap : null;
                                //echo $form->textField($model,'dpjp_nama',array('value'=>$dpjp_nama,'class'=>'span3','readonly'=>false, 'onkeypress'=>"return $(this).focusNextInputField(event)"));  
                                $this->widget('MyJuiAutoComplete', array(
                                    'name'=>'dpjp_nama',
                                    'value'=>$dpjp_nama,
                                    'source'=>'js: function(request, response) {
                                                   $.ajax({
                                                       url: "'.$this->createUrl('autocompleteDPJP').'",
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
                                                $(this).val(ui.item.value);

                                                return false;
                                            }',
                                           'select'=>'js:function( event, ui ) {
                                                $(".dpjp_id").val(ui.item.pegawai_id);
                                                $(".dpjp_nama").val(ui.item.nama_pegawai);
                                                return false;
                                            }',
                                    ),
                                    'tombolDialog'=>array('idDialog'=>'dialogDPJP','idTombol'=>'tombolDPJP'),
                                    'htmlOptions'=>array('class'=>'span3 dpjp_nama', 'placeholder'=>'DPJP','onkeypress'=>"return $(this).focusNextInputField(event)"),
                                ));
                                
                                ?>
                                
                            </div>
                            
                        </div>
                        
                        <!-- <div class="control-group"> -->
                            <?php // echo $form->labelEx($model,'supervisi_id', array('class'=>'control-label required', 'label'=>'SUPERVISI')) ?>
                            <!-- <div class="controls"> -->
                                <!-- Dokter -->
                                <?php 
                            //     echo $form->hiddenField($model, 'supervisi_id', array('class'=>'supervisi_id','onkeypress' => "return $(this).focusNextInputField(event);",));
                            //    // echo $form->textField($model,'dpjp_nama',array('value'=>$dpjp_nama,'class'=>'span3','readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)"));  
                            //     $this->widget('MyJuiAutoComplete', array(
                            //         'name'=>'dpjp_nama',
                            //         'source'=>'js: function(request, response) {
                            //                        $.ajax({
                            //                            url: "'.$this->createUrl('autocompleteDPJP').'",
                            //                            dataType: "json",
                            //                            data: {
                            //                                term: request.term,

                            //                            },
                            //                            success: function (data) {
                            //                                    response(data);
                            //                            }
                            //                        })
                            //                     }',
                            //          'options'=>array(
                            //                'showAnim'=>'fold',
                            //                'minLength' => 2,
                            //                'focus'=> 'js:function( event, ui ) {
                            //                     $(this).val(ui.item.value);

                            //                     return false;
                            //                 }',
                            //                'select'=>'js:function( event, ui ) {
                            //                     $(".supervisi_id").val(ui.item.pegawai_id);
                            //                     $(".dpjp_nama").val(ui.item.nama_pegawai);
                            //                     return false;
                            //                 }',
                            //         ),
                            //         'tombolDialog'=>array('idDialog'=>'dialogSupervisi','idTombol'=>'tombolSupervisi'),
                            //         'htmlOptions'=>array('class'=>'span3 dpjp_nama', 'placeholder'=>'Supervisi','onkeypress'=>"return $(this).focusNextInputField(event)"),
                            //     ));
                                
                                ?>
                                
                            <!-- </div> -->
                            
                        <!-- </div> -->
                    </div>
                </div>

                <div class="panel panel-default panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><strong>SOAP/ADIME</strong></div>
                    </div>
                    <div class="panel-body">
                        <table style="width: 100%">
                            <tr class="soap">
                                <td style="color: black; font-size:20px; font-weight:bold;">Subjective</td>
                                <td style="padding-bottom: 10px;text-align:right;">
                                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'soap_subjective', 'toolbar'=>'mini','height'=>'250px','width'=>'800px')) ?>
                                </td>
                            </tr>
                            <tr class="soap">
                                <td style="color: black; font-size:20px; font-weight:bold; ">Objective</td>
                                <td style="padding-bottom: 10px">
                                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'soap_objective', 'toolbar'=>'mini','height'=>'250px')) ?>
                                </td>
                            </tr>
                            <tr class="soap">
                                <td style="color: black; font-size:20px; font-weight:bold;">Assessment</td>
                                <td style="padding-bottom: 10px">
                                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'soap_asesmen', 'toolbar'=>'mini','height'=>'250px')) ?>
                                </td>
                            </tr>
                            <tr class="soap">
                                <td style="color: black; font-size:20px; font-weight:bold;">Planning</td>
                                <td style="padding-bottom: 10px">
                                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'soap_planning', 'toolbar'=>'mini','height'=>'250px')) ?>
                                </td>
                            </tr>
                            <tr class="soapahligizi">
                                <td style="color: black; font-size:20px; font-weight:bold;">Asesmen</td>
                                <td style="padding-bottom: 10px">
                                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'soapgizi_asesmen', 'toolbar'=>'mini','height'=>'250px')) ?>
                                </td>
                            </tr>
                            <tr class="soapahligizi">
                                <td style="color: black; font-size:20px; font-weight:bold;">Diagnosa Gizi</td>
                                <td style="padding-bottom: 10px">
                                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'soapgizi_diagnosagizi', 'toolbar'=>'mini','height'=>'250px')) ?>
                                </td>
                            </tr>
                            <tr class="soapahligizi">
                                <td style="color: black; font-size:20px; font-weight:bold;">Intervensi</td>
                                <td style="padding-bottom: 10px">
                                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'soapgizi_intervensi', 'toolbar'=>'mini','height'=>'250px')) ?>
                                </td>
                            </tr>
                            <tr class="soapahligizi">
                                <td style="color: black; font-size:20px; font-weight:bold;">Monitoring</td>
                                <td style="padding-bottom: 10px">
                                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'soapgizi_monitoring', 'toolbar'=>'mini','height'=>'250px')) ?>
                                </td>
                            </tr>
                            <tr class="soapahligizi">
                                <td style="color: black; font-size:20px; font-weight:bold;">Evaluasi</td>
                                <td style="padding-bottom: 10px">
                                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'soapgizi_evaluasi', 'toolbar'=>'mini','height'=>'250px')) ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="color: black; font-size:20px; font-weight:bold;">Instruksi</td>
                                <td style="padding-bottom: 10px">
                                    <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'instruksi', 'toolbar'=>'mini','height'=>'250px')) ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="form-actions <?php echo isset($_GET['lihat']) ? 'hide' : '' ?>">
                        <?php
                            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan'));
                            echo "&nbsp;";
                            echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                                $this->createUrl($this->id.'/index/&pendaftaran_id='.$_GET['pendaftaran_id']),
                                array('class'=>'btn btn-danger',
                                    'onclick'=>'return refreshForm(this);'));
                        ?>
                        <?php
                            $content = $this->renderPartial('rawatJalan.views.tips.tips',array(),true);
                            $this->widget('UserTips',array('type'=>'admin','content'=>$content));
                        ?>
                    </div>
                </div>
            </div>
        </div>
<?php $this->endWidget(); ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><strong>Riwayat Catatan Perkembangan Pasien Terintegrasi (CPPT)</strong></div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view.'_riwayatCPPT', array('modelRiwayat'=>$modelRiwayat,'modPendaftaran'=>$modPendaftaran)); ?>
            </div>
        </div>
    </div>
</div>


<?php $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model)); ?>

<script>
        $(document).ready(function() {
           var ppa_jenis = jQuery('#<?php echo CHtml::activeId($model, 'ppa_jenis') ?>');	
           jQuery(ppa_jenis).multiselect({
                   includeSelectAllOption: false,
                   buttonClass: "form-control",
                   maxHeight: 300,
                   buttonWidth: '182px',
                   enableCaseInsensitiveFiltering: true
           }).hide();
       });
       </script>

<?php
    //=============================== Dialog Pemeriksa Terapi =======================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogPegawaiPPA',
            'options'=>array(
                'title'=>'Profesional Pemberi Asuhan (PPA)' ,
                'autoOpen'=>false,
                'width' => 840,
				'height' => 420,
                'resizable' => true,
            ),
        )
    );
	
	$modPPA=new PegawairuanganV('search');
	$modPPA->unsetAttributes();
    $modPPA->ruangan_id = $modPendaftaran->ruangan_id;
	if(isset($_GET['PegawairuanganV'])){
		$modPPA->attributes=$_GET['PegawairuanganV'];
	}
    
    $prov = $modPPA->search();
    $prov->sort->defaultOrder = 'nama_pegawai';
    
	$this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'ppa-grid',
		'dataProvider'=>$prov,
		'filter'=>$modPPA,
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
                'value'=>function($data) {
                    $res = $data->attributes;
                    $res['nama_pegawai'] = $data->namaLengkap;
                    $res = CJSON::encode($res);
        
                    return CHtml::Link('<i class="icon-form-check"></i>',"#",array("class"=>"btn-small", 
								"onclick" => "$('.pegawaippa_id').val(".$data->pegawai_id.");
                                                $('.pegawaippa_nama').val('".$data->namaLengkap."'); "
                        . "$('#dialogPegawaiPPA').dialog('close');"
                        . "return false; "));
                },
			),
			array(
                'name'=>'nama_pegawai',
                // 'filter'=>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
                'value'=>'$data->namaLengkap',
            ),
            array(
                'name'=>'jabatan_id',
                'type'=>'raw',
                'value'=>function($data) {
                    if (empty($data->jabatan_id)) return "-";
                    $model = JabatanM::model()->findByPk($data->jabatan_id);
                    return $model->jabatan_nama;
                },
                'filter'=>CHtml::activeDropDownList($modPPA, 'jabatan_id', JabatanM::jabatanList(), array(
                    'empty'=>'--- Pilih ---',
                )),
            ),
		),
			'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	));
			
    $this->endWidget('zii.widgets.jui.CJuiDialog');
	//=============================== END Pemeriksa Terapi =======================================
?>

<?php
    //=============================== Dialog Pemeriksa Terapi =======================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogDPJP',
            'options'=>array(
                'title'=>'DPJP' ,
                'autoOpen'=>false,
                'width' => 840,
				'height' => 420,
                'resizable' => true,
            ),
        )
    );
	
	$modDPJP=new PegawairuanganV('search');
	$modDPJP->unsetAttributes();
    $modDPJP->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK;
    $modDPJP->ruangan_id = Yii::app()->user->getState('ruangan_id');
	
    if(isset($_GET['PegawairuanganV'])){
		$modDPJP->attributes=$_GET['PegawairuanganV'];
	}
    
    $prov = $modDPJP->search();
    $prov->sort->defaultOrder = 'nama_pegawai';
    
	$this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'dpjp-grid',
		'dataProvider'=>$prov,
		'filter'=>$modDPJP,
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
                'value'=>function($data) {
                    $res = $data->attributes;
                    $res['nama_pegawai'] = $data->namaLengkap;
                    $res = CJSON::encode($res);
        
                    return CHtml::Link('<i class="icon-form-check"></i>',"#",array("class"=>"btn-small", 
								"onclick" => "$('.dpjp_id').val(".$data->pegawai_id.");
                                                $('.dpjp_nama').val('".$data->namaLengkap."'); "
                        . "$('#dialogDPJP').dialog('close');"
                        . "return false; "));
                },
			),
			array(
                'name'=>'nama_pegawai',
                // 'filter'=>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
                'value'=>'$data->namaLengkap',
            ),
            array(
                'name'=>'jabatan_id',
                'type'=>'raw',
                'value'=>function($data) {
                    if (empty($data->jabatan_id)) return "-";
                    $model = JabatanM::model()->findByPk($data->jabatan_id);
                    return $model->jabatan_nama;
                },
                'filter'=>CHtml::activeDropDownList($modPPA, 'jabatan_id', JabatanM::jabatanList(), array(
                    'empty'=>'--- Pilih ---',
                )),
            ),
		),
			'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	));
			
    $this->endWidget('zii.widgets.jui.CJuiDialog');
	//=============================== END Pemeriksa Terapi =======================================
?>




<?php
    //=============================== Dialog Pemeriksa Terapi =======================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogSupervisi',
            'options'=>array(
                'title'=>'Supervisi' ,
                'autoOpen'=>false,
                'width' => 840,
				'height' => 420,
                'resizable' => true,
            ),
        )
    );
	
	$modSupervisi=new PegawairuanganV('search');
	$modSupervisi->unsetAttributes();
    $modSupervisi->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK;
    $modSupervisi->ruangan_id = Yii::app()->user->getState('ruangan_id');
	
    if(isset($_GET['PegawairuanganV'])){
		$modSupervisi->attributes=$_GET['PegawairuanganV'];
	}
    
    $prov = $modSupervisi->search();
    $prov->sort->defaultOrder = 'nama_pegawai';
    
    
	$this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'supervisi-grid',
		'dataProvider'=>$prov,
		'filter'=>$modSupervisi,
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
                'value'=>function($data) {
                    $res = $data->attributes;
                    $res['nama_pegawai'] = $data->namaLengkap;
                    $res = CJSON::encode($res);
        
                    return CHtml::Link('<i class="icon-form-check"></i>',"#",array("class"=>"btn-small", 
								"onclick" => "$('.supervisi_id').val(".$data->pegawai_id.");
                                                $('.dpjp_nama').val('".$data->namaLengkap."'); "
                        . "$('#dialogSupervisi').dialog('close');"
                        . "return false; "));
                },
			),
			array(
                'name'=>'nama_pegawai',
                // 'filter'=>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
                'value'=>'$data->namaLengkap',
            ),
            array(
                'name'=>'jabatan_id',
                'type'=>'raw',
                'value'=>function($data) {
                    if (empty($data->jabatan_id)) return "-";
                    $model = JabatanM::model()->findByPk($data->jabatan_id);
                    return $model->jabatan_nama;
                },
                'filter'=>CHtml::activeDropDownList($modPPA, 'jabatan_id', JabatanM::jabatanList(), array(
                    'empty'=>'--- Pilih ---',
                )),
            ),
		),
			'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	));
			
    $this->endWidget('zii.widgets.jui.CJuiDialog');
	//=============================== END Pemeriksa Terapi =======================================
?>