<?php
    $this->breadcrumbs = array(
        'SBAR',
    );
    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success',"Data berhasil disimpan");
    }
    $this->widget('bootstrap.widgets.BootAlert');
?>

<?php 
    if(empty($_GET['frame'])){
        $this->renderPartial($this->path_view.'_dataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien));
    }
 ?>
<div class="panel panel-gradient">
  <div class="panel-heading">
      <div class="panel-title" style="width: 100%">
        <span style="float: left !important; width:80% !important;"><b>Form SBAR</b></span><span style="float: right !important;">
           <?php
            echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', Yii::app()->user->getState('current_url_daftarpasien'), array('class'=>'btn btn-red', 'style'=>'color: white;'));
            ?>
        </span>
      </div>
  </div>
  <div class="panel-body">
      
      
     <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Riwayat SBAR</div>
        </div>
        <div class="panel-body">
          <?php echo $this->renderPartial($this->path_view."_riwayat", array('modPendaftaran'=>$modPendaftaran), true); ?>
        </div>
      </div>
      <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
          'id'=>'frm-sbar',
          'enableAjaxValidation'=>false,
          'type'=>'horizontal',
          'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this)')
      ));
      ?>
        <div class="panel panel-success">
           <div class="panel-heading">
               <div class="panel-title">SBAR</div>
           </div>
           <div class="panel-body">
             <?php echo CHtml::activeHiddenField($model,'pendaftaran_id');?>
             <?php echo CHtml::activeHiddenField($model,'pasien_id');?>
             <div class="row">
               <div class="col-sm-4">
                 <div class="control-group ">
                     <?php echo $form->labelEx($model, 'tgl_sbar', array('class' => 'control-label')) ?>
                     <div class="controls">
                         <?php
                         $this->widget('MyDateTimePicker', array(
                             'model' => $model,
                             'attribute' => 'tgl_sbar',
                             'mode' => 'datetime',
                             'options' => array(
                                 'dateFormat' => Params::DATE_FORMAT,
                             ),
                             'htmlOptions' => array(
                                 'readonly' => true,
                                 'onkeypress' => "return $(this).focusNextInputField(event)",
                                 'class' => 'span3',
                             ),
                         ));
                         ?>
                     </div>
                 </div>
               </div>
               <div class="col-sm-4">
                 <div class="control-group ">
                     <?php echo $form->labelEx($model, 'pegawai_sbar', array('class' => 'control-label')) ?>
                     <div class="controls">
                        <?php // echo $form->dropDownList($model, 'pegawai_sbar', CHtml::listData(PegawairuanganV::model()->findAll('ruangan_id = '.Yii::app()->user->getState('ruangan_id')),'pegawai_id','namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        <?php 
                            echo $form->hiddenField($model, 'pegawai_sbar', array('id'=>'pegawai_sbar'));
                            
                            if (!empty($model->pegawai_sbar)) {
                                $sbar_nama = PegawaiM::model()->findByPk($model->pegawai_sbar);
                            }
                            
                            $this->widget('MyJuiAutoComplete', array(
                                'name'=>'pegawai_sbar_nama',
                                'value'=>empty($sbar_nama) ? "" : $sbar_nama->namaLengkap,
                                'source'=>'js: function(request, response) {
                                    $.ajax({
                                    url: "'.$this->createUrl('getPegawaiSBAR').'",
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
                                    $("#pegawai_sbar").val(ui.item.value); 
                                    $("#pegawai_sbar_nama").val(ui.item.label); 
                                    return false;
                                }',
                            ),
                            'tombolDialog'=>array(
                                'idDialog'=>'dialogPegawaiSBAR',
                            ),
                        )); 
                        ?>
                         
                         
                     </div>
                 </div>
               </div>
               <div class="col-sm-4">
                 <div class="control-group ">
                     <?php echo $form->labelEx($model, 'jenispenginputan_nama', array('class' => 'control-label')) ?>
                     <div class="controls">
                         <?php echo $form->dropDownList($model, 'jenispenginputan_nama', array('Dokter','Perawat'), array('onchange'=>'changeJenisInput(this);','empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                     </div>
                 </div>
               </div>
               <div class="clear"></div>
               <div class="col-sm-6">
                   <div class="panel panel-primary panel-default">
                       <div class="panel-heading">
                           <div class="panel-title">Situation</div>
                       </div>
                       <div class="panel-body">
                           <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model,'attribute'=>'situation', 'toolbar'=>'mini','height'=>'200px')) ?>
                       </div>
                   </div>
                   <div class="panel panel-primary panel-default">
                       <div class="panel-heading">
                           <div class="panel-title">Assesment</div>
                       </div>
                       <div class="panel-body">
                           <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model,'attribute'=>'assesmen', 'toolbar'=>'mini','height'=>'200px')) ?>
                       </div>
                   </div>
               </div>
               <div class="col-sm-6">
                   <div class="panel panel-primary panel-default">
                       <div class="panel-heading">
                           <div class="panel-title">Background</div>
                       </div>
                       <div class="panel-body">
                           <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model,'attribute'=>'background', 'toolbar'=>'mini','height'=>'200px')) ?>
                       </div>
                   </div>
                   <div class="panel panel-primary panel-default">
                       <div class="panel-heading">
                           <div class="panel-title">Recomendation</div>
                       </div>
                       <div class="panel-body">
                           <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model,'attribute'=>'rekomendasi', 'toolbar'=>'mini','height'=>'200px')) ?>
                       </div>
                   </div>
               </div>
             </div>
             <div class="form-actions">
             	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
             		array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan')); ?>

                     <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
             		$this->createUrl($this->module->id.'/Index'),
             		array('class'=>'btn btn-danger',
             			'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('#').'";} ); return false;'));  ?>

             </div>
           </div>
         </div>
       <?php $this->endWidget(); ?>


  </div>
</div>
<?php $this->renderPartial($this->path_view.'_jsFunctions', array('model'=>$model)); ?>


                                                        
<?php
    //=============================== Dialog DPJP =======================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogPegawaiSBAR',
            'options'=>array(
                'title'=>'Pegawai SBAR' ,
                'autoOpen'=>false,
                'width' => 840,
				'height' => 420,
                'resizable' => true,
            ),
        )
    );
	
	$format = new MyFormatter();
	$pegawai=new PegawairuanganV('search');
	$pegawai->unsetAttributes();
    $pegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
    
	if(isset($_GET['PegawairuanganV'])){
		$pegawai->attributes=$_GET['PegawairuanganV'];
	}
    
    $prov = $pegawai->search();
    $prov->sort->defaultOrder = 'nama_pegawai';
    
	$this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'dialog-dpjp-m-grid',
		'dataProvider'=>$prov,
		'filter'=>$pegawai,
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
                'value'=>function($data) {
                    return CHtml::Link('<i class="icon-form-check"></i>',"#",array("class"=>"btn-small", 
								"onclick" => "$('#pegawai_sbar').val(".$data->pegawai_id."); $('#pegawai_sbar_nama').val('".$data->namaLengkap."'); $('#dialogPegawaiSBAR').dialog('close'); return false;"));
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


