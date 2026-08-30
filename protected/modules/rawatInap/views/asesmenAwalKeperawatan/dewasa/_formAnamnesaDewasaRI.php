<div class="row-fluid">
     <div class="panel panel-primary panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"><strong>Pemeriksaam Anamnesa</strong></div>
        </div>
         <div class="panel-body">
             <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
             <div class="row-fluid">
                 <div class="col-sm-6">
                     <div class="control-group ">
                            <?php echo CHtml::label('Perawat Pengkaji <span class="required">*</span>', 'paramedis_nama', array('class' => 'control-label required')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($modAsesmenawalkeperawatanT,'paramedis_nama', CHtml::listData($dropPerawat, 'nama_pegawai', 'NamaLengkap'),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            </div>
                    </div>
                     <?php echo $form->dropDownListRow($modAsesmenawalkeperawatanT, 'dokterpemeriksa_id', CHtml::listData($dropDokter, 'pegawai_id', 'NamaLengkap'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",)); ?>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modAsesmenawalkeperawatanT, 'jam_masukruangan', array('class' => 'control-label')) ?>
                        <div class="controls">
                                <?php
                                        $this->widget('MyDateTimePicker', array(
                                                'model' => $modAsesmenawalkeperawatanT,
                                                'attribute' => 'jam_masukruangan_dws',
                                                'mode' => 'time',
                                                'options' => array(
                                                ),
                                                'htmlOptions' => array('class'=>'span3',
                                                        'onkeypress' => "return $(this).focusNextInputField(event)"),
                                        ));
                                ?>
                        </div>
                    </div>
                     <div class="control-group ">
                        <?php echo $form->labelEx($modAsesmenawalkeperawatanT, 'tgl_assesmen_awal', array('class' => 'control-label')) ?>
                        <div class="controls">
                                <?php
                                        $this->widget('MyDateTimePicker', array(
                                                'model' => $modAsesmenawalkeperawatanT,
                                                'attribute' => 'tgl_assesmen_awal_dws',
                                                'mode' => 'datetime',
                                                'options' => array(
                                                        'dateFormat' => Params::DATE_FORMAT,
//                                                        'maxDate' => 'd',
                                                ),
                                                'htmlOptions' => array('readonly' => true, 'class'=>'span3',
                                                        'onkeypress' => "return $(this).focusNextInputField(event)"),
                                        ));
                                ?>
                        </div>
                    </div>

                     <div class="control-group ">
                            <?php echo $form->labelEx($modAsesmenawalkeperawatanT, 'keluhanutama', array('class' => 'control-label')) ?>
                            <div class="controls">
                                    <?php
                                            $this->widget('application.extensions.FCBKcomplete.FCBKcomplete',array(
                                                    'model'=>$modAsesmenawalkeperawatanT,
                                                    'attribute'=>'keluhanutama_dws',
                                                    'data'=> explode(',', $modAsesmenawalkeperawatanT->keluhanutama),
                                                    'debugMode'=>true,
                                                    'options'=>array(
                                                            //'bricket'=>false,
                                                            'json_url'=>$this->createUrl('MasterKeluhan'),
                                                            'addontab'=> true,
                                                            'maxitems'=> 10,
                                                            'input_min_size'=> 0,
                                                            'cache'=> true,
                                                            'newel'=> true,
                                                            'addoncomma'=>true,
                                                            'select_all_text'=> "",
                                                            'autoFocus'=>true,
                                                    ),
                                            ));
                                    ?>
                                    <?php echo $form->error($modAsesmenawalkeperawatanT, 'keluhanutama'); ?>
                            </div>
                    </div>
                            <div class="control-group ">
                                    <?php echo $form->labelEx($modAsesmenawalkeperawatanT, 'keluhantambahan', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                            <?php
                                                    $this->widget('application.extensions.FCBKcomplete.FCBKcomplete',array(
                                                            'model'=>$modAsesmenawalkeperawatanT,
                                                            'attribute'=>'keluhantambahan_dws',
                                                            'data'=> explode(',', $modAsesmenawalkeperawatanT->keluhantambahan),
                                                            'debugMode'=>true,
                                                            'options'=>array(
                                                                    //'bricket'=>false,
                                                                    'json_url'=>$this->createUrl('MasterKeluhan'),
                                                                    'addontab'=> true,
                                                                    'maxitems'=> 10,
                                                                    'input_min_size'=> 0,
                                                                    'cache'=> true,
                                                                    'newel'=> true,
                                                                    'addoncomma'=>true,
                                                                    'select_all_text'=> "",
                                                            ),
                                                    ));
                                            ?>
                                            <?php echo $form->error($modAsesmenawalkeperawatanT, 'keluhantambahan'); ?>
                                    </div>
                            </div>
                     <div class="control-group ">
                        <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'sumberdata', array('class'=>'control-label required','label'=>'Sumber Data <span class="required">*</span>')) ?>
                        <div class="controls">
                            <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'sumberdata',array('Pasien'=>'Pasien','Keluarga'=>'Keluarga','Lainnya'=>'Lainnya') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'sumberdata','onclick'=>'setSumberData();')); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                       <?php echo CHtml::label('','', array('class'=>'control-label')) ?>
                       <div class="controls">
                           <?php echo $form->textField($modAsesmenawalkeperawatanT, 'sumberdata_lainnya', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                       </div>
                   </div>
                   <div class="control-group ">
                      <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'namapasien_verifikator', array('class'=>'control-label required','label'=>'Nama Pasien/ Keluarga Verifikator <span class="required">*</span>')) ?>
                      <div class="controls">
                          <?php echo $form->textField($modAsesmenawalkeperawatanT, 'namapasien_verifikator', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                      </div>
                  </div>
                  <div class="control-group ">
                      <?php echo $form->labelEx($modAsesmenawalkeperawatanT, 'riwayatperjalanan_penyakitpasien', array('class' => 'control-label')) ?>
                      <div class="controls">
                          <?php echo $form->textArea($modAsesmenawalkeperawatanT, 'riwayatperjalanan_penyakitpasien', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                          <?php echo $form->error($modAsesmenawalkeperawatanT, 'riwayatperjalanan_penyakitpasien'); ?>
                      </div>
                  </div>
                  <div class="control-group ">
                    <?php echo $form->labelEx($modAsesmenawalkeperawatanT, 'riwayatpenyakitkeluarga', array('class' => 'control-label')) ?>
                    <div class="controls">
                      <?php echo $form->textArea($modAsesmenawalkeperawatanT, 'riwayatpenyakitkeluarga', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                      <?php
                      echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array('class' => 'btn btn-primary', 'onclick' => "$('#dialogDiagnosa').dialog('open');$('#formDiagnosa').val('formDewasa');refreshGridDiagnosa();",
                        'id' => 'btnAddRiwayatPenyakitKeluarga', 'onkeypress' => "return $(this).focusNextInputField(event)",
                        'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $modAsesmenawalkeperawatanT->getAttributeLabel('riwayatpenyakitkeluarga')))
                      ?>
                      <?php echo $form->error($modAsesmenawalkeperawatanT, 'riwayatpenyakitkeluarga'); ?>
                    </div>
                  </div>

                 </div>
                 <div class="col-sm-6">
                   <div class="control-group ">
                      <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'statusalergipasien', array('class'=>'control-label')) ?>
                      <div class="controls">
                          <!--<div class="radio">-->
                                  <div class="controls">
                                          <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'statusalergipasien',array(1=>'Tidak Ada',2=>'Tidak Tahu',3=>'Ada') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'statusalergipasien','onclick'=>'setStatusAlergi_dws(this);')); ?>
                                  </div>
                          <!--</div>-->
                          <?php echo $form->error($modAsesmenawalkeperawatanT, 'statusalergipasien'); ?>
                      </div>
                  </div>

                      <?php echo $form->textAreaRow($modAsesmenawalkeperawatanT, 'riwayatalergiobat', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
                   <?php echo $form->textAreaRow($modAsesmenawalkeperawatanT, 'riwayatalergimakanan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
                     <?php echo $form->textAreaRow($modAsesmenawalkeperawatanT, 'riwayatalergilainnya', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'readonly'=>true)); ?>

                     <div class="control-group ">
                         <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'riwayatpembedahan_status', array('class'=>'control-label','label'=>'Riwayat Operasi')) ?>
                         <div class="controls">
                             <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'riwayatpembedahan_status',array('Tidak Pernah'=>'Tidak Pernah','Pernah'=>'Pernah') , array('class'=>'riwayatpembedahan_status','onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setStatusPembedahanAnastesi_dws(this);')); ?>
                         </div>
                     </div>
                     <div class="control-group">
                         <label class="control-label"></label>
                         <div class="controls">
                            Jenis dan kapan <br/>
                             <?php echo $form->textArea($modAsesmenawalkeperawatanT, 'riwayatpembedahan_keterangan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
                         </div>
                     </div>
                     <div class="control-group ">
                         <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'riwayattransfusi_status', array('class'=>'control-label','label'=>'Riwayat Transfusi')) ?>
                         <div class="controls">
                             <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'riwayattransfusi_status',array('Tidak'=>'Tidak','Ya'=>'Ya') , array('class'=>'riwayattransfusi_status','onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setStatusRiwayattransfusi_dws();')); ?>
                         </div>
                     </div>
                     <div class="control-group">
                         <label class="control-label"></label>
                         <div class="controls">
                           <div class="control-group ">
                               <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'riwayattransfusi_isreaksi', array('class'=>'control-label','label'=>'Reaksi Transfusi')) ?>
                               <div class="controls">
                                   <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'riwayattransfusi_isreaksi',array('Tidak'=>'Tidak','Ya'=>'Ya') , array('class'=>'riwayattransfusi_isreaksi disabledinputan','onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setReaksiRiwayattransfusi_dws();')); ?>
                               </div>
                           </div>
                           <div class="control-group">
                               <label class="control-label"></label>
                               <div class="controls">
                                  Reaksi yang timbul <br/>
                                   <?php echo $form->textArea($modAsesmenawalkeperawatanT, 'riwayattransfusi_reaksiygtimbul', array('class' => 'span3 disabledinputan', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                               </div>
                           </div>
                         </div>
                     </div>

                 </div>
             </div>
         </div>
     </div>
</div>

<?php
//========= Dialog buat Pemesanan obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPengobatanYgSudahDilakukan_dws',
    'options' => array(
        'title' => 'Pencarian Data Obat Alkes',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 440,
        'resizable' => false,
    ),
));

$modObatAlkes = new RIObatalkesM('searchObatAlkes');
$modObatAlkes->unsetAttributes();
$modObatAlkes->default = 'kosong';
if(isset($_GET['RIObatalkesM']))
    $modObatAlkes->attributes = $_GET['RIObatalkesM'];
    $modObatAlkes->obatalkes_kode = (isset($_GET['RIObatalkesM']['obatalkes_kode']) ? $_GET['RIObatalkesM']['obatalkes_kode'] : "");
	$modObatAlkes->obatalkes_nama = (isset($_GET['RIObatalkesM']['obatalkes_nama']) ? $_GET['RIObatalkesM']['obatalkes_nama'] : "");

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatalkes-m-grid',
    'dataProvider' => $modObatAlkes->searchObatAlkes(),
    'filter' => $modObatAlkes,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
                                    "id" => "selectObatAlkes",
                                    "onClick" => "
                                                var data = $(\".formDewasa\").find(\"#' . CHtml::activeId($modAsesmenawalkeperawatanT, 'pengobatanygsudahdilakukan') . '\").val();
                                                if (data == \"\"){
                                                    $(\".formDewasa\").find(\"#' . CHtml::activeId($modAsesmenawalkeperawatanT, 'pengobatanygsudahdilakukan') . '\").val(\"$data->obatalkes_nama\");
                                                } else {
                                                    $(\".formDewasa\").find(\"#' . CHtml::activeId($modAsesmenawalkeperawatanT, 'pengobatanygsudahdilakukan') . '\").val(data+\", $data->obatalkes_nama\");
                                                }
                                                  $(\"#dialogPengobatanYgSudahDilakukan_dws\").dialog(\"close\");
                                        "))',
        ),
        'obatalkes_kode',
        'obatalkes_nama',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
//========= Dialog buat Pemesanan obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogObatygdibawa_dws',
    'options' => array(
        'title' => 'Pencarian Data Obat Alkes',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 440,
        'resizable' => false,
    ),
));

$modObatAlkesObatyddibawa = new RIObatalkesM('searchObatAlkes');
$modObatAlkesObatyddibawa->unsetAttributes();
$modObatAlkes->default = 'kosong';
if(isset($_GET['RIObatalkesM']))
    $modObatAlkesObatyddibawa->attributes = $_GET['RIObatalkesM'];
    $modObatAlkesObatyddibawa->obatalkes_kode = (isset($_GET['RIObatalkesM']['obatalkes_kode']) ? $_GET['RIObatalkesM']['obatalkes_kode'] : "");
	$modObatAlkesObatyddibawa->obatalkes_nama = (isset($_GET['RIObatalkesM']['obatalkes_nama']) ? $_GET['RIObatalkesM']['obatalkes_nama'] : "");

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatygdibawa-m-grid',
    'dataProvider' => $modObatAlkesObatyddibawa->searchObatAlkes(),
    'filter' => $modObatAlkesObatyddibawa,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
                                    "id" => "selectObatAlkes",
                                    "onClick" => "
                                                var data = $(\".formDewasa\").find(\"#' . CHtml::activeId($modAsesmenawalkeperawatanT, 'obatyangdibawa') . '\").val();
                                                if (data == \"\"){
                                                    $(\".formDewasa\").find(\"#' . CHtml::activeId($modAsesmenawalkeperawatanT, 'obatyangdibawa') . '\").val(\"$data->obatalkes_nama\");
                                                } else {
                                                    $(\".formDewasa\").find(\"#' . CHtml::activeId($modAsesmenawalkeperawatanT, 'obatyangdibawa') . '\").val(data+\", $data->obatalkes_nama\");
                                                }
                                                  $(\"#dialogObatygdibawa_dws\").dialog(\"close\");
                                        "))',
        ),
        'obatalkes_kode',
        'obatalkes_nama',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
//========= Dialog buat Pemesanan obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogObatygrutindigunakan_dws',
    'options' => array(
        'title' => 'Pencarian Data Obat Alkes',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 440,
        'resizable' => false,
    ),
));

$modObatAlkesObatygrutindigunkan = new RIObatalkesM('searchObatAlkes');
$modObatAlkesObatygrutindigunkan->unsetAttributes();
$modObatAlkes->default = 'kosong';
if(isset($_GET['RIObatalkesM']))
    $modObatAlkesObatygrutindigunkan->attributes = $_GET['RIObatalkesM'];
    $modObatAlkesObatygrutindigunkan->obatalkes_kode = (isset($_GET['RIObatalkesM']['obatalkes_kode']) ? $_GET['RIObatalkesM']['obatalkes_kode'] : "");
	$modObatAlkesObatygrutindigunkan->obatalkes_nama = (isset($_GET['RIObatalkesM']['obatalkes_nama']) ? $_GET['RIObatalkesM']['obatalkes_nama'] : "");

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatygrutindigunakan-m-grid',
    'dataProvider' => $modObatAlkesObatygrutindigunkan->searchObatAlkes(),
    'filter' => $modObatAlkesObatygrutindigunkan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
                                    "id" => "selectObatAlkes",
                                    "onClick" => "
                                                var data = $(\".formDewasa\").find(\"#' . CHtml::activeId($modAsesmenawalkeperawatanT, 'obatygrutindigunakan') . '\").val();
                                                if (data == \"\"){
                                                    $(\".formDewasa\").find(\"#' . CHtml::activeId($modAsesmenawalkeperawatanT, 'obatygrutindigunakan') . '\").val(\"$data->obatalkes_nama\");
                                                } else {
                                                    $(\".formDewasa\").find(\"#' . CHtml::activeId($modAsesmenawalkeperawatanT, 'obatygrutindigunakan') . '\").val(data+\", $data->obatalkes_nama\");
                                                }
                                                  $(\"#dialogObatygrutindigunakan_dws\").dialog(\"close\");
                                        "))',
        ),
        'obatalkes_kode',
        'obatalkes_nama',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>