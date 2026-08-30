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
                 </div>
             </div>
         </div>
     </div>
</div>

<?php /**
//========= Dialog buat Pemesanan obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAddRiwayatPenyakitTerdahulu_dws',
    'options' => array(
        'title' => 'Pencarian Data Diagnosa Penyakit Terdahulu',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 440,
        'resizable' => false,
    ),
));

$modDataDiagnosa = new RJDiagnosaM('searchDiagnosaAnamnesa');
$modDataDiagnosa->unsetAttributes();
if(isset($_GET['RJDiagnosaM']))
    $modDataDiagnosa->attributes = $_GET['RJDiagnosaM'];
    $modDataDiagnosa->diagnosa_nama = (isset($_GET['RJDiagnosaM']['diagnosa_nama']) ? $_GET['RJDiagnosaM']['diagnosa_nama'] : "");
    $modDataDiagnosa->diagnosa_namalainnya = (isset($_GET['RJDiagnosaM']['diagnosa_namalainnya']) ? $_GET['RJDiagnosaM']['diagnosa_namalainnya'] : "");
    $modDataDiagnosa->diagnosa_kode = (isset($_GET['RJDiagnosaM']['diagnosa_kode']) ? $_GET['RJDiagnosaM']['diagnosa_kode'] : "");


$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'diagnosa-m-grid',
    'dataProvider' => $modDataDiagnosa->searchDiagnosaAnamnesa(),
    'filter' => $modDataDiagnosa,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
                                    "id" => "selectDiagnosa",
                                    "onClick" => "
                                                var data = $(\".formDewasa\").find(\"#' . CHtml::activeId($modAsesmenawalkeperawatanT, 'riwayatpenyakitterdahulu') . '\").val();
                                                if (data == \"\"){
                                                    $(\".formDewasa\").find(\"#' . CHtml::activeId($modAsesmenawalkeperawatanT, 'riwayatpenyakitterdahulu') . '\").val(\"$data->diagnosa_nama\");
                                                } else {
                                                    $(\".formDewasa\").find(\"#' . CHtml::activeId($modAsesmenawalkeperawatanT, 'riwayatpenyakitterdahulu') . '\").val(data+\", $data->diagnosa_nama\");
                                                }
                                                  $(\"#dialogAddRiwayatPenyakitTerdahulu_dws\").dialog(\"close\");
                                        "))',
        ),
        'diagnosa_kode',
        'diagnosa_nama',
        'diagnosa_namalainnya',

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<?php
//========= Dialog buat Pencarian Diagnosa Penyakit Keluarga =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAddRiwayatPenyakitKeluarga_dws',
    'options' => array(
        'title' => 'Pencarian Data Pencarian Diagnosa Penyakit Keluarga',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 440,
        'resizable' => false,
    ),
));
$modDataDiagnosaKeluarga = new RJDiagnosaM('searchDiagnosaAnamnesa');
$modDataDiagnosaKeluarga->unsetAttributes();
if(isset($_GET['RJDiagnosaM']))
    $modDataDiagnosaKeluarga->attributes = $_GET['RJDiagnosaM'];
    $modDataDiagnosaKeluarga->diagnosa_nama = (isset($_GET['RJDiagnosaM']['diagnosa_nama']) ? $_GET['RJDiagnosaM']['diagnosa_nama'] : "");
    $modDataDiagnosaKeluarga->diagnosa_namalainnya = (isset($_GET['RJDiagnosaM']['diagnosa_namalainnya']) ? $_GET['RJDiagnosaM']['diagnosa_namalainnya'] : "");
    $modDataDiagnosaKeluarga->diagnosa_kode = (isset($_GET['RJDiagnosaM']['diagnosa_kode']) ? $_GET['RJDiagnosaM']['diagnosa_kode'] : "");

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'penyakitkeluarga-m-grid',
    'dataProvider' => $modDataDiagnosaKeluarga->searchDiagnosaAnamnesa(),
    'filter' => $modDataDiagnosaKeluarga,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
                                    "id" => "selectDiagnosaPenyakit",
                                    "onClick" => "
                                                var data = $(\".formDewasa\").find(\"#' . CHtml::activeId($modAsesmenawalkeperawatanT, 'riwayatpenyakitkeluarga') . '\").val();
                                                if (data == \"\"){
                                                    $(\".formDewasa\").find(\"#' . CHtml::activeId($modAsesmenawalkeperawatanT, 'riwayatpenyakitkeluarga') . '\").val(\"$data->diagnosa_nama\");
                                                } else {
                                                    $(\".formDewasa\").find(\"#' . CHtml::activeId($modAsesmenawalkeperawatanT, 'riwayatpenyakitkeluarga') . '\").val(data+\", $data->diagnosa_nama\");
                                                }
                                                $(\"#dialogAddRiwayatPenyakitKeluarga_dws\").dialog(\"close\");
                                        "))',
        ),
        'diagnosa_kode',
        'diagnosa_nama',
        'diagnosa_namalainnya',

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Pencarian Diagnosa Penyakit Keluarga dialog =============================
?>

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

$modObatAlkes = new RJObatAlkesM('searchObatAlkes');
$modObatAlkes->unsetAttributes();
if(isset($_GET['RJObatAlkesM']))
    $modObatAlkes->attributes = $_GET['RJObatAlkesM'];
    $modObatAlkes->obatalkes_kode = (isset($_GET['RJObatAlkesM']['obatalkes_kode']) ? $_GET['RJObatAlkesM']['obatalkes_kode'] : "");
	$modObatAlkes->obatalkes_nama = (isset($_GET['RJObatAlkesM']['obatalkes_nama']) ? $_GET['RJObatAlkesM']['obatalkes_nama'] : "");

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

$modObatAlkesObatyddibawa = new RJObatAlkesM('searchObatAlkes');
$modObatAlkesObatyddibawa->unsetAttributes();
if(isset($_GET['RJObatAlkesM']))
    $modObatAlkesObatyddibawa->attributes = $_GET['RJObatAlkesM'];
    $modObatAlkesObatyddibawa->obatalkes_kode = (isset($_GET['RJObatAlkesM']['obatalkes_kode']) ? $_GET['RJObatAlkesM']['obatalkes_kode'] : "");
	$modObatAlkesObatyddibawa->obatalkes_nama = (isset($_GET['RJObatAlkesM']['obatalkes_nama']) ? $_GET['RJObatAlkesM']['obatalkes_nama'] : "");

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

$modObatAlkesObatygrutindigunkan = new RJObatAlkesM('searchObatAlkes');
$modObatAlkesObatygrutindigunkan->unsetAttributes();
if(isset($_GET['RJObatAlkesM']))
    $modObatAlkesObatygrutindigunkan->attributes = $_GET['RJObatAlkesM'];
    $modObatAlkesObatygrutindigunkan->obatalkes_kode = (isset($_GET['RJObatAlkesM']['obatalkes_kode']) ? $_GET['RJObatAlkesM']['obatalkes_kode'] : "");
	$modObatAlkesObatygrutindigunkan->obatalkes_nama = (isset($_GET['RJObatAlkesM']['obatalkes_nama']) ? $_GET['RJObatAlkesM']['obatalkes_nama'] : "");

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

<?php
//========= Dialog buat Pencarian Riwayat Imunisasi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAddRiwayatImunisasi_dws',
    'options' => array(
        'title' => 'Pencarian Data Riwayat Imunisasi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 440,
        'resizable' => false,
    ),
));

$modDataDiagnosaImunisasi = new RJDiagnosaM('searchImunisasi');
$modDataDiagnosaImunisasi->unsetAttributes();
if(isset($_GET['RJDiagnosaM']))
    $modDataDiagnosaImunisasi->attributes = $_GET['RJDiagnosaM'];
    $modDataDiagnosaImunisasi->diagnosa_nama = (isset($_GET['RJDiagnosaM']['diagnosa_nama']) ? $_GET['RJDiagnosaM']['diagnosa_nama'] : "");
    $modDataDiagnosaImunisasi->diagnosa_namalainnya = (isset($_GET['RJDiagnosaM']['diagnosa_namalainnya']) ? $_GET['RJDiagnosaM']['diagnosa_namalainnya'] : "");
    $modDataDiagnosaImunisasi->diagnosa_kode = (isset($_GET['RJDiagnosaM']['diagnosa_kode']) ? $_GET['RJDiagnosaM']['diagnosa_kode'] : "");

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'imunisasi-m-grid',
    'dataProvider' => $modDataDiagnosaImunisasi->searchImunisasi(),
    'filter' => $modDataDiagnosaImunisasi,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
                                    "id" => "selectDiagnosaImunisasi",
                                    "onClick" => "
                                                var data = $(\".formDewasa\").find(\"#' . CHtml::activeId($modAsesmenawalkeperawatanT, 'riwayatimunisasi') . '\").val();
                                                if (data == \"\"){
                                                    $(\".formDewasa\").find(\"#' . CHtml::activeId($modAsesmenawalkeperawatanT, 'riwayatimunisasi') . '\").val(\"$data->diagnosa_nama\");
                                                } else {
                                                    $(\".formDewasa\").find(\"#' . CHtml::activeId($modAsesmenawalkeperawatanT, 'riwayatimunisasi') . '\").val(data+\", $data->diagnosa_nama\");
                                                }
                                                $(\"#dialogAddRiwayatImunisasi_dws\").dialog(\"close\");
                                        "))',
        ),
        'diagnosa_kode',
        'diagnosa_nama',
        'diagnosa_namalainnya',

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Pencarian Riwayat Imunisasi dialog =============================
 * 
 */
?>
