    <?php
		$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
			'action' => Yii::app()->createUrl($this->route),
			'method' => 'get',
			'type' => 'horizontal',
			'id' => 'searchLaporan',
			'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
		));
    ?>
 <style>

        #penjamin label.checkbox{
            width: 100px;
            display:inline-block;
        }

    </style>
	<div class="row-fluid">
            <div class="control-group">
                <?php echo CHtml::hiddenField('type', ''); ?>

                <?php echo $form->hiddenField($model,'jns_periode', array('class'=>'span2')); ?>
                <?php echo $form->hiddenField($model,'bln_awal', array('class'=>'span2')); ?>
                <?php echo $form->hiddenField($model,'bln_akhir', array('class'=>'span2')); ?>
                <?php echo $form->hiddenField($model,'thn_awal', array('class'=>'span2')); ?>
                <?php echo $form->hiddenField($model,'thn_akhir', array('class'=>'span2')); ?>
                <?php echo CHtml::label("Tanggal Pelayanan",'', array('class' => 'control-label')) ?>
                <div class="controls">
                        <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                                <i class="entypo-calendar"></i>
                                <span ><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                                <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                                <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                        </div>
                </div>       
            </div>
        </div>
        <div class="row-fluid">	
            <div class="col-sm-6">
                    <div id='searching'>
                            <?php
                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'pelayanan',
                        'slide' => true,
                        'content' => array(
                            'content1' => array(
                                'multi' => 'multi',
                                'header' => 'Berdasarkan Kelas Pelayanan',
                                'isi' => CHtml::hiddenField('filter', 'kelaspelayanan_id', array('disabled' => 'disabled')) . 
                                    '<div class="control-group">
                                        '.CHtml::label('Kelas Pelayanan','kelaspelayanan_id', array('class' => 'control-label')).' 
                                        <div class="controls">
                                            '.$form->dropDownList($model,'kelaspelayanan_id', CHtml::listData(KelaspelayananM::model()->findAll("kelaspelayanan_aktif = TRUE ORDER BY kelaspelayanan_nama ASC"), 'kelaspelayanan_id', 'kelaspelayanan_nama'),array(
                                            'class'=>'form-control', 'multiple'=>'multiple')).'											
                                        </div>
                                    </div>',
                                'active' => true,
                            ),
                        ),
                    ));
                ?>														
                    </div>
            </div>
            <div class="col-sm-6">
                <div id='searching'>			
                    <?php
                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'carabayar',
                            'slide' => true,
                            'content' => array(
                                'content2' => array(
                                        'multi' => 'multi',
                                        'header' => 'Berdasarkan Jenis Penjamin',
                                        'isi' => CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) . 
                                                '<div class="control-group">
                                                        '.CHtml::label('Jenis Penjamin','carabayar_id', array('class' => 'control-label')).' 
                                                        <div class="controls">
                                                                '.$form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'),array(
                                                                'class'=>'form-control', 'multiple'=>'multiple')).'											
                                                        </div>
                                                </div>
                                                <div class="control-group">
                                                        '.CHtml::label('Penjamin','penjamin_id', array('class' => 'control-label')).' 
                                                        <div class="controls">												 
                                                                '.$form->dropDownList($model,'penjamin_id',
                                                                                array(),
                                                                                array('class'=>'form-control', 'multiple'=>'multiple')).' 													
                                                        </div>
                                                </div>',
                                        'active' => true,
                                ),
                            ),
                        )
                    );
                    ?>	
                </div> 
            </div>
            <div class="col-sm-6">
		<div id='searching'>
                    <?php
                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'dokter',
                        'slide' => true,
                        'content' => array(
                            'content3' => array(
                                'multi' => 'multi',
                                'header' => 'Berdasarkan Dokter',
                                'isi' => CHtml::hiddenField('filter', 'nama_pegawai', array('disabled' => 'disabled')) . 
                                    '<div class="control-group">
                                        '.CHtml::label('Dokter','nama_pegawai', array('class' => 'control-label')).' 
                                        <div class="controls">
                                            '.$form->dropDownList($model,'nama_pegawai',  CHtml::listData(DokterpegawaiV::model()->findAll("pegawai_aktif = TRUE   "), 'nama_pegawai', 'namaLengkap'),array(
                                            'class'=>'form-control', 'multiple'=>'multiple')).'											
                                        </div>
                                    </div>',
                                'active' => true,
                            ),
                        ),
                    ));
                    ?>											
                </div>		
            </div>
        </div>
		
<!--		<div class="span6">
			<div class="panel-heading">
                            <div class="panel-title">Berdasarkan Dokter</div>
                            </div>
                            <div class="panel-body">
				<div class="control-group ">
					<?php // echo $form->labelEx($model, 'Nama Dokter', array('class'=>'control-label')); ?>
					<div class="controls">
						<?php 
						//echo CHtml::activeHiddenField($model, 'pegawai_id');
//						$this->widget('MyJuiAutoComplete', array(
//							'name'=>CHtml::activeId($model, 'nama_pegawai'),
//							 'model'=>$model,
//							 'source'=>'js: function(request, response) {
//											$.ajax({
//												url: "'.$this->createUrl('AutocompleteDokter').'",
//												dataType: "json",
//												data: {
//													term: request.term,
//												},
//												success: function (data) {
//														response(data);
//												}
//											})
//										 }',
//							  'options'=>array(
//									'showAnim'=>'fold',
//									'minLength' => 2,
//									'focus'=> 'js:function( event, ui ) {
//										 $(this).val(ui.item.value);
//										 return false;
//									 }',
//									'select'=>'js:function( event, ui ) {
//										 $("#'.CHtml::activeId($model, 'nama_pegawai').'").val(ui.item.nama_pegawai);
//										 return false;
//									 }',
//							 ),
//							 'htmlOptions'=>array(
//								 'readonly'=>false,
//								 'placeholder'=>'Nama Dokter',
//								 'class'=>'span3',
//								 'onkeypress'=>"return $(this).focusNextInputField(event);",
//							 ),
//							 'tombolDialog'=>array('idDialog'=>'dialogPegawai'),
//						)); ?>
					</div>
				</div>
			</div>
		</div>-->
		
    
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan',
            'ajax' => array(
                 'type' => 'GET', 
                 'url' => array("/".$this->route), 
                 'update' => '#tableLaporan',
                 'beforeSend' => 'function(){
                                      $("#tableLaporan").addClass("animation-loading");
                                  }',
                 'complete' => 'function(){
                                      $("#tableLaporan").removeClass("animation-loading");
                                  }',
             )
            )); 
        ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                            array('class'=>'btn btn-danger',
                                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); ?>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php Yii::app()->clientScript->registerScript('cekAll','
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
',  CClientScript::POS_READY);
?>
<?php 
//$urlGetPenjamin = Yii::app()->createUrl('ActionDynamic/GetPenjaminPasienForCheckBox', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().''));
//Yii::app()->clientScript->registerScript('ajax','
//    $("#'.CHtml::activeId($model, 'carabayar_id').'").change(function(){
//        id = $(this).val();
//        $.post("'.$urlGetPenjamin.'", {id:id},function(data){
//            
//        });
//    });
//',CClientScript::POS_READY); ?>

<?php //Yii::app()->clientScript->registerScript('onclickButton','
//  var tampilGrafik = "<div class=\"tampilGrafik\" style=\"display:inline-block\"> <i class=\"icon-arrow-right icon-white\"></i> Grafik</div>";
//  $(".accordion-heading a.accordion-toggle").click(function(){
//            $(this).parents(".accordion").find("div.tampilGrafik").remove();
//            $(this).parents(".accordion-group").has(".accordion-body.in").length ? "" : $(this).append(tampilGrafik);
//            
//            
//  });
//',  CClientScript::POS_READY);
?>
<?php 
    // Dialog buat nambah data pegawai =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogPegawai',
        'options'=>array(
            'title'=>'Pencarian Dokter',
            'autoOpen'=>false,
            'modal'=>true,
            'minWidth'=>800,
            'minHeight'=>400,
            'resizable'=>false,
        ),
));

    $modPegawai = new HDDokterpegawaiV('searchDialog');
//    $modPegawai->unsetAttributes();
    if(isset($_GET['HDDokterpegawaiV'])) {
        $modPegawai->attributes = $_GET['HDDokterpegawaiV'];
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',array( 
        'id'=>'sapegawai-m-grid', 
        'dataProvider'=>$modPegawai->searchDialog(), 
//        'filter'=>$modPegawai, 
        'template'=>"{summary}\n{items}\n{pager}", 
        'itemsCssClass'=>'table table-striped table-bordered table-condensed', 
        'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::link("<i class=\"icon-form-check\"></i>","#", array("id" => "selectPegawai",
                                              "onClick"=>"
                                                $(\"#'.CHtml::activeId($model, 'nama_pegawai').'\").val(\"$data->nama_pegawai\");
                                                $(\"#dialogPegawai\").dialog(\"close\");    
                                                "
                                         ))',
            ),
            'nomorindukpegawai',
            'nama_pegawai',
            'jeniskelamin',
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>

<?php $this->endWidget(); ?>
<script>
        function checkAll() {
            if ($("#checkAllCaraBayar").is(":checked")) {
                $('#penjamin input[name*="HDLaporanpendapatanruangan"]').each(function(){
                   $(this).attr('checked',true);
                })
            } else {
               $('#penjamin input[name*="HDLaporanpendapatanruangan"]').each(function(){
                   $(this).removeAttr('checked');
                })
            }
            //setAll();
        }

        function checkAllRuangan() {
            if ($("#checkAllR").is(":checked")) {
                $('#Ruangan input[name*="HDLaporanpendapatanruangan"]').each(function(){
                   $(this).attr('checked',true);
                })
            } else {
               $('#Ruangan input[name*="HDLaporanpendapatanruangan"]').each(function(){
                   $(this).removeAttr('checked');
                })
            }
            //setAll();
        }
        
        function setAll(obj){
            $('.cekList').each(function(){
               if ($(this).is(':checked')){

                    $(this).parents('tr').find('.cekList').val(1);
                    }else{
                        $(this).parents('tr').find('.cekList').val(0);
                    }
            });
        }
</script>
<?php $this->renderPartial('rawatJalan.views.laporan._jsFunctions', array('model' => $model)); ?>