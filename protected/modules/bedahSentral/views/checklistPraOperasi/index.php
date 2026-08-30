<?php
    $this->breadcrumbs = array(
        'checklist Serah Terima Pre Operasi',
    );
    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success',"Data berhasil disimpan");
    }
    $this->widget('bootstrap.widgets.BootAlert');
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title" style="width: 100%">
          <b>Checklist Serah Terima Pre Operasi</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial($this->path_view.'_dataPasien',array('modPendaftaran'=>$modPendaftaran,'model'=>$model,'modPasien'=>$modPasien)); ?>

        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title"><strong>Riwayat</strong></div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view.'_riwayat', array('modPendaftaran'=>$modPendaftaran)); ?>
            </div>
        </div>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'praoperasi-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
));
?>
        <?php echo $form->hiddenField($model, 'pendaftaran_id'); ?>
        <?php echo $form->hiddenField($model, 'pasienadmisi_id'); ?>
        <?php echo $form->hiddenField($model, 'isterima'); ?>

        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title"><strong>Data Checklist Pre Operasi</strong></div>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="control-group ">
                      <?php echo $form->labelEx($model,'tanggal_penginputan', array('class'=>'control-label','label'=>'Tanggal Input')) ?>
                      <div class="controls">
                          <?php
                              $this->widget('MyDateTimePicker',array(
                              'model'=>$model,
                              'attribute'=>'tanggal_penginputan',
                              'mode'=>'date',
                              'options'=> array(
                                      'dateFormat'=>Params::DATE_FORMAT,
                                      'maxDate' => 'd',
                              ),
                              'htmlOptions'=>array('readonly'=>true,'class'=>'span3','style'=>'width:150px;'),
                          )); ?>
                      </div>
                  </div>
                  <div class="control-group">
                      <?php echo $form->labelEx($model,'petugas_pengisi', array('class'=>'control-label')) ?>
                      <div class="controls">
                          <?php
                          echo $form->hiddenField($model, 'petugas_pengisi', array('onkeypress' => "return $(this).focusNextInputField(event);"));

                          $this->widget('MyJuiAutoComplete', array(
                              'model'=>$model,
                              'attribute'=>'petugas_pengisi_nama',
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
                                          $("#'.CHtml::activeId($model,'petugas_pengisi').'").val(ui.item.pegawai_id);
                                          $("#'.CHtml::activeId($model,'petugas_pengisi_nama').'").val(ui.item.nama_pegawai);
                                          return false;
                                      }',
                              ),
                              'tombolDialog'=>array('idDialog'=>'dialogPegawaiPPA'),
                              'htmlOptions'=>array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)"),
                          ));

                          ?>

                      </div>
                  </div>

                </div>
                <div class="col-sm-6">
                  <div class="control-group ">
                      <?php echo $form->labelEx($model,'ruanganasal_id', array('class'=>'control-label')) ?>
                      <div class="controls">
                          <?php echo $form->hiddenField($model, 'ruanganasal_id'); ?>
                          <?php echo $form->textField($model,'ruanganasal_nama', array('class'=>'span3','readonly'=>true)) ?>
                      </div>
                  </div>
                  <div class="control-group ">
                      <?php echo $form->labelEx($model,'instalasitujuan_id', array('class'=>'control-label')) ?>
                      <div class="controls">
                        <?php
                            echo $form->hiddenField($model, 'instalasitujuan_id');
                            echo $form->textField($model,'instalasitujuan_nama', array('class'=>'span3','readonly'=>true));
                          ?>
                      </div>
                  </div>
                  <div class="control-group ">
                      <?php echo $form->labelEx($model,'ruangantujuan_id', array('class'=>'control-label')) ?>
                      <div class="controls">
                        <?php
                            echo $form->hiddenField($model, 'ruangantujuan_id');
                            echo $form->textField($model,'ruangantujuan_nama', array('class'=>'span3','readonly'=>true));
                          ?>
                      </div>
                  </div>

                </div>
              </div>
              <div class="panel panel-success panel-shadow">
                  <div class="panel-heading">
                      <div class="panel-title"><strong>Serah Terima Pre Operasi</strong></div>
                  </div>
                  <div class="panel-body">
                    <div class="row">
                      <?php
                        $modPrepostOperasi = PrepostoperasideskM::model()->findAllByAttributes(array('status'=>true,'parent_id'=>null,'jenischecklist'=>'Pre Operasi'),array('order'=>'urutan ASC'));
                        if(count($modPrepostOperasi) > 0){
                          $nourut = 0;
                          $indexTr = 0;
                          $indexOp = 0;
                          foreach($modPrepostOperasi as $dataPrePostOperasi){
                            $nourut += 1;

                            $status_pengisian_parent = "";
                            $keterangan_parent = "";

                            if(!empty($modDetail) > 0){
                              foreach ($modDetail as $oriDet_parent) {
                                if($oriDet_parent->prepostoperasidesk_id == $dataPrePostOperasi->prepostoperasidesk_id){
                                    $status_pengisian_parent = $oriDet_parent->status_pengisian;
                                    $keterangan_parent = $oriDet->keterangan;
                                }
                              }
                            }
                            
                            
                            $childrenPrepost = PrepostoperasideskM::model()->findAllByAttributes(array('status'=>true,'parent_id'=>$dataPrePostOperasi->prepostoperasidesk_id),array('order'=>'urutan ASC'));
                            if(count($childrenPrepost) > 0){
                              
                            ?>
                                <div class="col-sm-12">
                                  <div class="control-group">
                                      <?php echo CHtml::label($nourut.". ".$dataPrePostOperasi->nama_prepostoperasidesk,'', array('class'=>'control-label', 'style'=>'text-align: left !important;')) ?>
                                  </div>
                                  <div class="row">
                                    <?php
                                      $trIndexChild = 0;
                                      $nourutStep2 = 0;


                                      foreach($childrenPrepost as $children){
                                        $trIndexChild += 1;

                                        $status_pengisian = "";
                                        $keterangan = "";

                                        if(!empty($modDetail) > 0){
                                          foreach ($modDetail as  $oriDet) {
                                            if($oriDet->prepostoperasidesk_id == $children->prepostoperasidesk_id){
                                                $status_pengisian = $oriDet->status_pengisian;
                                                $keterangan = $oriDet->keterangan;
                                            }
                                          }
                                        }

                                        if($trIndexChild == 1 || $trIndexChild == 2){
                                          $checkPostPreOpChild = PrepostoperasideskM::model()->findByAttributes(array('parent_id'=>$children->prepostoperasidesk_id));

                                          $cekChildern = 0;
                                          if(!empty($checkPostPreOpChild)){
                                            $cekChildern = 1;
                                          }
                                          
                                        ?>
                                        <?php  if($cekChildern==0){ 
                                          ?>
                                        <div class="col-sm-6">

                                          <div class="control-group">
                                              <?php echo CHtml::label($children->nama_prepostoperasidesk,'', array('class'=>'control-label', 'style'=>'text-align: left; padding-left: 20px; width: 150px; padding-top: 0px !important')) ?>
                                              <div class="controls">
                                                <?php echo CHtml::radioButtonList('PrepostoperasidetailT['.$indexOp.'][status_pengisian]','',array('Ya'=>'Ya','Tidak'=>'Tidak') , array('class'=>'status_pengisian','onkeyup'=>"return $(this).focusNextInputField(event)",'template'=>'{input}{label}','separator'=>'','labelOptions'=>array('style'=> 'padding-left:5px; width: 30px; float: left;'),'style'=>'float:left;')); ?>
                                                 <div style="clear: both;"></div>
                                              </div>
                                          </div>
                                          <div class="control-group">
                                              <?php echo CHtml::label('Keterangan','', array('class'=>'control-label', 'style'=>'text-align: left; padding-left: 30px')) ?>
                                          </div>
                                          <div class="control-group">
                                              <div class="controls" style="padding-left: 20px">
                                                  <?php echo CHtml::hiddenField('PrepostoperasidetailT['.$indexOp.'][prepostoperasidesk_id]',$children->prepostoperasidesk_id); ?>
                                                  <?php echo CHtml::textArea('PrepostoperasidetailT['.$indexOp.'][keterangan]',$keterangan,array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                                              </div>
                                          </div>
                                        </div>
                                        
                                       
                                      <?php }else{?>
                                        <div class="col-sm-6"></div>
                                        <div class="clear"></div>
                                        <div class="col-sm-12">
                                          <div class="control-group">
                                              <?php echo CHtml::label($children->nama_prepostoperasidesk,'', array('class'=>'control-label', 'style'=>'text-align: left; padding-left: 20px; width: 150px; padding-top: 0px !important')) ?>
                                          </div>
                                          <div class="row">
                                            <?php
                                              $trIndexChild = 0;
                                              $childrenPrepostStep3 = PrepostoperasideskM::model()->findAllByAttributes(array('status'=>true,'parent_id'=>$children->prepostoperasidesk_id),array('order'=>'urutan ASC'));
                                              foreach($childrenPrepostStep3 as $childrenLast){
                                                $trIndexChild += 1;

                                                $status_pengisianLast = "";
                                                $keteranganLast = "";

                                                if(!empty($modDetail) > 0){
                                                  foreach ($modDetail as  $oriDet) {
                                                    if($oriDet->prepostoperasidesk_id == $childrenLast->prepostoperasidesk_id){
                                                        $status_pengisianLast = $oriDet->status_pengisian;
                                                        $keteranganLast = $oriDet->keterangan;
                                                    }
                                                  }
                                                }

                                                if($trIndexChild == 1 || $trIndexChild == 2){
                                                ?>
                                                <div class="col-sm-6">

                                                  <div class="control-group">
                                                      <?php echo CHtml::label("<i class='fa fa fa-minus'></i> ".$childrenLast->nama_prepostoperasidesk,'', array('class'=>'control-label', 'style'=>'text-align: left; padding-left: 50px; width: 150px; padding-top: 0px !important')) ?>
                                                      <div class="controls">
                                                        <?php echo CHtml::radioButtonList('PrepostoperasidetailT['.$indexOp.'][status_pengisian]',$status_pengisianLast,array('Ya'=>'Ya','Tidak'=>'Tidak') , array('class'=>'status_pengisian','onkeyup'=>"return $(this).focusNextInputField(event)",'template'=>'{input}{label}','separator'=>'','labelOptions'=>array('style'=> 'padding-left:5px; width: 30px; float: left;'),'style'=>'float:left;')); ?>
                                                         <div style="clear: both;"></div>
                                                      </div>
                                                  </div>
                                                  <div class="control-group">
                                                      <?php echo CHtml::label('Keterangan','', array('class'=>'control-label', 'style'=>'text-align: left; padding-left: 50px')) ?>
                                                  </div>
                                                  <div class="control-group">
                                                      <div class="controls" style="padding-left: 50px">
                                                          <?php echo CHtml::hiddenField('PrepostoperasidetailT['.$indexOp.'][prepostoperasidesk_id]',$childrenLast->prepostoperasidesk_id); ?>
                                                          <?php echo CHtml::textArea('PrepostoperasidetailT['.$indexOp.'][keterangan]',$keteranganLast,array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                                                      </div>
                                                  </div>

                                                </div>

                                                <?php
                                                }
                                                
                                                if($trIndexChild == 2){
                                                  $trIndexChild = 0;
                                                  ?>
                                                  <div class="clear"></div>
                                                  <?php
                                                }
                                                $indexOp = ($indexOp + 1);
                                              }
                                             ?>
                                          </div>
                                        </div>

                                        <?php } 
                                        
                                        }
                                        if($trIndexChild == 2){
                                          $trIndexChild = 0;
                                          ?>
                                          
                                          <div class="clear"></div>
                                          <?php
                                        }
                                        $indexOp = ($indexOp + 1);
                                        $nourutStep2 += 1;
                                      }
                                     
                                     ?>
                                   </div>
                                </div>
                                <div class="clear"></div>
                            <?php
                            if($indexTr >0){
                              $indexTr -= 1;
                            }
                            }else{
                              $indexTr += 1;
                              if($indexTr == 1 || $indexTr == 2){
                                ?>
                                <div class="col-sm-12">
                                <?php
                              }
                            ?>

                              <div class="control-group">
                                  <?php echo CHtml::label($nourut.". ".$dataPrePostOperasi->nama_prepostoperasidesk,'', array('class'=>'control-label', 'style'=>'text-align: left; width: 150px; padding-top: 0px !important')) ?>
                                  <div class="controls">
                                        <?php echo CHtml::radioButtonList('PrepostoperasidetailT['.$indexOp.'][status_pengisian]','',array('Ya'=>'Ya','Tidak'=>'Tidak') , array('class'=>'status_pengisian','onkeyup'=>"return $(this).focusNextInputField(event)",'template'=>'{input}{label}','separator'=>'','labelOptions'=>array('style'=> 'padding-left:5px; width: 30px; float: left;'),'style'=>'float:left;')); ?>
                                        <div style="clear: both;"></div>
                                  </div>
                              </div>
                              <div class="control-group">
                                  <?php echo CHtml::label('Keterangan','', array('class'=>'control-label', 'style'=>'text-align: left;  padding-left: 30px')) ?>
                              </div>
                              <div class="control-group">
                                  <div class="controls" style="padding-left: 20px">
                                    <?php echo CHtml::hiddenField('PrepostoperasidetailT['.$indexOp.'][prepostoperasidesk_id]',$dataPrePostOperasi->prepostoperasidesk_id); ?>
                                      <?php echo CHtml::textArea('PrepostoperasidetailT['.$indexOp.'][keterangan]',$keterangan_parent,array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                                  </div>
                              </div>
                            <?php
                            if($indexTr == 1 || $indexTr == 2){
                              ?>
                              </div>

                              <?php
                              }
                              if($indexTr == 2){
                                $vf= 1;
                                $indexTr=0;
                             ?>
                            <div class="clear"></div>
                            <?php
                          }
                          
                          $indexOp = ($indexOp + 1);
                            }
                          }
                        }
                       ?>
                    </div>
                  </div>
              </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="form-actions">
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
<?php $this->endWidget(); ?>
    </div>
</div>


<?php //$this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model)); ?>



<?php
    //=============================== Dialog Pemeriksa Terapi =======================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogPegawaiPPA',
            'options'=>array(
                'title'=>'Pencarian Petugas Pengisi' ,
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
                'value'=>function($data)use($model) {
                    return CHtml::Link('<i class="icon-form-check"></i>',"#",array("class"=>"btn-small",
								"onclick" => "$('#".CHtml::activeId($model,'petugas_pengisi')."').val(".$data->pegawai_id.");
                              $('#".CHtml::activeId($model,'petugas_pengisi_nama')."').val('".$data->namaLengkap."'); "
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
