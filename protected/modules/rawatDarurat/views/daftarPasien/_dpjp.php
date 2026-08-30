<div class="main_form">
<div class="control-group hide">
    <?php echo $form->labelEx($modelPulang, 'dokterpenerima_id', array('class'=>'control-label ', 
        'label'=>'Dokter Penerima <span class="">*</span>"')); ?>
    <div class="controls">
        <?php 
             echo $form->hiddenField($modelPulang, 'dokterpenerima_id', array('id'=>'dokterpenerima_id'));
             $this->widget('MyJuiAutoComplete', array(
                 'name'=>'dokterpenerima',
                 'source'=>'js: function(request, response) {
                     $.ajax({
                     url: "'.$this->createUrl('getDokterPenerima').'",
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
                      $(this).val( ui.item.label);
                      return false;
                  }',
                 'select'=>'js:function( event, ui ) {
                      $("#dokterpenerima_id").val(ui.item.value); 
                      return false;
                  }',
             ),
             'tombolDialog'=>array(
                 'idDialog'=>'dialogDokterUmum',
                 'jsFunction'=>'dokter_id = "#dokterpenerima_id"; dokter_label = "#dokterpenerima"; $("#dialogDokterUmum").dialog("open")',
             ),
         )); 
        ?>
    </div>
</div>
<div class="control-group required">
    <?php echo $form->labelEx($modelPulang, 'dpjp1_id', array('class'=>'control-label required', 
        'label'=>'Dokter DPJP <span class="required">*</span>"')); ?>
    <div class="controls">
        <?php 
                echo $form->hiddenField($modelPulang, 'dpjp1_id', array('id'=>'dpjp1_id'));
                $this->widget('MyJuiAutoComplete', array(
                    'name'=>'dpjp1',
                    'source'=>'js: function(request, response) {
                        $.ajax({
                        url: "'.$this->createUrl('getDokterDPJP').'",
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
                         $(this).val( ui.item.label);
                         return false;
                     }',
                    'select'=>'js:function( event, ui ) {
                         $("#dpjp1_id").val(ui.item.value); 
                         return false;
                     }',
                ),
                'tombolDialog'=>array(
                    'idDialog'=>'dialogDokterDPJP',
                    'jsFunction'=>'dokter_id = "#dpjp1_id"; dokter_label = "#dpjp1"; $("#dialogDokterDPJP").dialog("open")',
                ),
            )); 
        ?>
    </div>
</div>
<div class="control-group hide">
    <?php echo $form->labelEx($modelPulang, 'dpjp2_id', array('class'=>'control-label')); ?>
    <div class="controls">
        <?php 
                echo $form->hiddenField($modelPulang, 'dpjp2_id', array('id'=>'dpjp2_id'));
                $this->widget('MyJuiAutoComplete', array(
                    'name'=>'dpjp2',
                    'source'=>'js: function(request, response) {
                        $.ajax({
                        url: "'.$this->createUrl('getDokterDPJP').'",
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
                         $(this).val( ui.item.label);
                         return false;
                     }',
                    'select'=>'js:function( event, ui ) {
                         $("#dpjp2_id").val(ui.item.value); 
                         return false;
                     }',
                ),
                'tombolDialog'=>array(
                    'idDialog'=>'dialogDokterDPJP',
                    'jsFunction'=>'dokter_id = "#dpjp2_id"; dokter_label = "#dpjp2"; $("#dialogDokterDPJP").dialog("open")',
                ),
            )); 
        ?>
    </div>
</div>
<div class="control-group hide">
    <?php echo $form->labelEx($modelPulang, 'dpjp3_id', array('class'=>'control-label')); ?>
    <div class="controls">
        <?php 
                echo $form->hiddenField($modelPulang, 'dpjp3_id', array('id'=>'dpjp3_id'));
                $this->widget('MyJuiAutoComplete', array(
                    'name'=>'dpjp3',
                    'source'=>'js: function(request, response) {
                        $.ajax({
                        url: "'.$this->createUrl('getDokterDPJP').'",
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
                         $(this).val( ui.item.label);
                         return false;
                     }',
                    'select'=>'js:function( event, ui ) {
                         $("#dpjp3_id").val(ui.item.value); 
                         return false;
                     }',
                ),
                'tombolDialog'=>array(
                    'idDialog'=>'dialogDokterDPJP',
                    'jsFunction'=>'dokter_id = "#dpjp3_id"; dokter_label = "#dpjp3"; $("#dialogDokterDPJP").dialog("open")',
                ),
            )); 
        ?>
    </div>
</div>

<div class="control-group hide">
    <?php echo $form->labelEx($modelPulang, 'dpjp4_id', array('class'=>'control-label')); ?>
    <div class="controls">
        <?php 
                echo $form->hiddenField($modelPulang, 'dpjp4_id', array('id'=>'dpjp4_id'));
                $this->widget('MyJuiAutoComplete', array(
                    'name'=>'dpjp4',
                    'source'=>'js: function(request, response) {
                        $.ajax({
                        url: "'.$this->createUrl('getDokterDPJP').'",
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
                         $(this).val( ui.item.label);
                         return false;
                     }',
                    'select'=>'js:function( event, ui ) {
                         $("#dpjp4_id").val(ui.item.value); 
                         return false;
                     }',
                ),
                'tombolDialog'=>array(
                    'idDialog'=>'dialogDokterDPJP',
                    'jsFunction'=>'dokter_id = "#dpjp4_id"; dokter_label = "#dpjp4"; $("#dialogDokterDPJP").dialog("open")',
                ),
            )); 
        ?>
    </div>
</div>
<div class="control-group hide">
    <?php echo $form->labelEx($modelPulang, 'dpjp5_id', array('class'=>'control-label')); ?>
    <div class="controls">
        <?php 
                echo $form->hiddenField($modelPulang, 'dpjp5_id', array('id'=>'dpjp5_id'));
                $this->widget('MyJuiAutoComplete', array(
                    'name'=>'dpjp5',
                    'source'=>'js: function(request, response) {
                        $.ajax({
                        url: "'.$this->createUrl('getDokterDPJP').'",
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
                         $(this).val( ui.item.label);
                         return false;
                     }',
                    'select'=>'js:function( event, ui ) {
                         $("#dpjp5_id").val(ui.item.value); 
                         return false;
                     }',
                ),
                'tombolDialog'=>array(
                    'idDialog'=>'dialogDokterDPJP',
                    'jsFunction'=>'dokter_id = "#dpjp5_id"; dokter_label = "#dpjp5"; $("#dialogDokterDPJP").dialog("open")',
                ),
            )); 
        ?>
    </div>
</div>
</div>

<?php
    //=============================== Dialog DPJP =======================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogDokterDPJP',
            'options'=>array(
                'title'=>'Dokter PJP' ,
                'autoOpen'=>false,
                'width' => 840,
				'height' => 420,
                'resizable' => true,
            ),
        )
    );
	
	$format = new MyFormatter();
	$modDPJP=new PegawaiV('search');
	$modDPJP->unsetAttributes();
	if(isset($_GET['PegawaiV'])){
		$modDPJP->attributes=$_GET['PegawaiV'];
	}
	$this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'dialog-dpjp-m-grid',
		'dataProvider'=>$modDPJP->searchDokter(),
		'filter'=>$modDPJP,
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
                'value'=>function($data) {
                    return CHtml::Link('<i class="icon-form-check"></i>',"#",array("class"=>"btn-small", 
								"onclick" => " setDokter('".$data->namaLengkap."',".$data->pegawai_id."); return false; "));
                },
			),
			array(
                'name'=>'nama_pegawai',
                // 'filter'=>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
                'value'=>'$data->namaLengkap',
            ),
		),
			'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	));
			
    $this->endWidget('zii.widgets.jui.CJuiDialog');
	//=============================== END DPJP =======================================
?>


<?php
    //=============================== Dialog Dokter Umum =======================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogDokterUmum',
            'options'=>array(
                'title'=>'Dokter Penerima' ,
                'autoOpen'=>false,
                'width' => 840,
				'height' => 420,
                'resizable' => true,
            ),
        )
    );
	
	$format = new MyFormatter();
	$modDokUmum=new PegawaiV('search');
	$modDokUmum->unsetAttributes();
	if(isset($_GET['PegawaiV'])){
		$modDokUmum->attributes=$_GET['PegawaiV'];
	}
	$this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'dialog-dokter-umum-m-grid',
		'dataProvider'=>$modDokUmum->searchDokter(),
		'filter'=>$modDokUmum,
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
                'value'=>function($data) {
                    return CHtml::Link('<i class="icon-form-check"></i>',"#",array("class"=>"btn-small", 
								"onclick" => "
									setDokter('".$data->namaLengkap."',".$data->pegawai_id.");
                                    return false;
								"));
                },
			),
			array(
                'name'=>'nama_pegawai',
                //'filter'=>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
                'value'=>'$data->namaLengkap',
            ),
		),
			'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	));
			
    $this->endWidget('zii.widgets.jui.CJuiDialog');
	//=============================== END Dialog Dokter Umum =======================================
?>


<script>
    
var dokter_id;
var dokter_label;

function setDokter(label, value) {
    $(dokter_id).val(value);
    $(dokter_label).val(label);
    $("#dialogDokterUmum").dialog("close");
    $("#dialogDokterDPJP").dialog("close");
}
    
</script>
