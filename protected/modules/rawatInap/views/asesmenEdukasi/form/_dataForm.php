<div class="row-fluid">
    <div class="col-sm-12">
        <div class="control-group">    
            <?php echo $form->labelEx($model, 'tgl_edukasi', array(
                'class'=>'control-label'
            )); ?>                              
            <div class="controls">
                <?php 

                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_edukasi',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class'=>'tgl_edukasi span3',
                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
            </div>                                
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model,'ppa_namajenis', array('class'=>'control-label required', 'label'=>'Profesional Pemberi Asuhan (PPA) <span class="required">*</span>')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'ppa_namajenis'); ?>
                <?php
                    $module = Yii::app()->user->getState('modul_id');
                    if(in_array($module, [7, 15, 72])) {
                        echo $form->dropDownList($model, 'ppa_jenis', LookupM::getItems('cppt_pemberiasuhan'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'onchange'=>'changeJenisPPA(this)'));
                    } else {
                        echo $form->dropDownList($model, 'ppa_jenis', CHtml::listData(LookupM::model()->findAll('lookup_id in (3012, 3014)'), 'lookup_value', 'lookup_name'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'onchange'=>'changeJenisPPA(this)')); 
                    } 
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model,'ppa_namajenis', array('class'=>'control-label required', 'label'=>'Nama Profesional Pemberi Asuhan (PPA)<span class="required">*</span>')) ?>
            <div class="controls">
                <!-- Pegawai Ruangan -->
                <?php 
                    // $dpjp_nama = empty($model->pendaftaran->pegawai) ? null : $model->pendaftaran->pegawai->namaLengkap;
                
                echo $form->hiddenField($model, 'pegawaippa_id', array('class'=>'pegawaippa_id', 'onkeypress' => "return $(this).focusNextInputField(event);",)); 
                $pegawaippa_nama = Yii::app()->user->getState('nama_pegawai');
            //      echo $form->textField($model,'pegawaippa_nama',array('class'=>'span3','readonly'=>false, 'onkeypress'=>"return $(this).focusNextInputField(event)")); 
                
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
            <?php echo $form->labelEx($model,'dpjp_id', array('class'=>'control-label required', 'label'=>'DPJP <span class="required">*</span>')) ?>
            <div class="controls">
                <!-- Dokter -->
                <?php 
                echo $form->hiddenField($model, 'dpjp_id', array('class'=>'dpjp_id','onkeypress' => "return $(this).focusNextInputField(event);",));
                $dpjp_nama = '';
                if(!empty($modPenunjang->pegawai_id)) {
                    $pegDpjp = PegawaiM::model()->findByPk($modPenunjang->pegawai_id);
                    $dpjp_nama = empty($pegDpjp) ? null : $pegDpjp->namaLengkap;
                }
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
        <div class="control-group">
            <?php echo $form->labelEx($model,'supervisi_id', array('class'=>'control-label required', 'label'=>'Supervisi  <span class="required">*</span>')) ?>
            <div class="controls">
                <!-- Dokter -->
                <?php 
                echo $form->hiddenField($model, 'supervisi_id', array('class'=>'supervisi_id','onkeypress' => "return $(this).focusNextInputField(event);",));
                    
                $pegSupervisi = PegawaiM::model()->findByPk($model->supervisi_id);
                $supervisi_nama = empty($pegSupervisi) ? null : $pegSupervisi->namaLengkap;
                //echo $form->textField($model,'dpjp_nama',array('value'=>$dpjp_nama,'class'=>'span3','readonly'=>false, 'onkeypress'=>"return $(this).focusNextInputField(event)"));  
                $this->widget('MyJuiAutoComplete', array(
                    'name'=>'supervisi_nama',
                    'value'=>$supervisi_nama,
                    'source'=>'js: function(request, response) {
                                    $.ajax({
                                        url: "'.$this->createUrl('autocompleteSupervisi').'",
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
                                $(".supervisi_id").val(ui.item.pegawai_id);
                                $(".supervisi_nama").val(ui.item.nama_pegawai);
                                return false;
                            }',
                    ),
                    'tombolDialog'=>array('idDialog'=>'dialogSupervisi','idTombol'=>'tombolSupervisi'),
                    'htmlOptions'=>array('class'=>'span3 supervisi_nama', 'placeholder'=>'Supervisi','onkeypress'=>"return $(this).focusNextInputField(event)"),
                ));
                
                ?>
                
            </div>
            
        </div>
    </div>
</div>
<hr />


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
    $modPPA->ruangan_id = Yii::app()->user->getState('ruangan_id');
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
    // $modSupervisi->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK;
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
                                                $('.supervisi_nama').val('".$data->namaLengkap."'); "
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