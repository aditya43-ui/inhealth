<?php
//komen buat ngepull
$this->breadcrumbs = array(
    'Anamnesa',
);

$this->widget('bootstrap.widgets.BootAlert');
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjanamnesa-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('class'=>'form-iframe','onKeyPress' => 'return disableKeyPress(event)','onsubmit'=>'requiredCheck(this);'),
    // 'focus' => '#RJAnamnesaT_keluhanutama_annoninput .maininput',
));

$sukses = isset($_GET['sukses'])?$_GET['sukses']:'';
echo CHtml::hiddenField('sukses', $sukses);
?>
<!--div class="white-container"-->
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Pemeriksaan <b>Anamnesa</b>
        </div>
    </div>
    <div class="panel-body">
        <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <?php echo $form->errorSummary($modAnamnesa); ?>
        <?php if(isset($_GET['pendaftaran_id'])):
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'tabel-riwayatanamnesa',
            'content' => array(
                'content-detailanamnesa' => array(
                    'header' => '<b>Tabel Riwayat Anamnesa</b>',
                    'isi' => $this->renderPartial($this->path_view . '_tabelRiwayatAnamnesaRekamMedis', array(
                        'tabelAnamnesa' => $tabelAnamnesa,
                        'tabelAnamnesaPasien' => $tabelAnamnesaPasien,
                        'format' => new MyFormatter(),
                    ), true),
                    'active' => true,
                ),
            ),
        ));
        endif;
        
        if ($this->module->id == 'rawatJalan'){
            $diag = $modPendaftaran->cekMorbiditasAkutKronis();            
            if (!empty($diag)){                
                $hari = CustomFunction::hitungHari(date('Y-m-d'),$diag->create_time);
                if ( ($diag->statusdiagnosapasien == 'akut' && $hari >= 30) ){
                    $hari = 30;
                }else if ( ($diag->statusdiagnosapasien == 'kronis' && $hari >= 90) ){
                    $hari = 90;
                }
                
                if ($hari == 30 || $hari == 90){
        ?>
        <div class="col-sm-4" style="background: #cf2a27;height:5vw;padding:10px;">
            <div class="col-sm-3">
                <span style="color:#e69037;font-size:2.5vw" class="fa fa-warning"></span>
            </div>
            <div class="col-sm-9">
                <span style="color:#fff;font-weight:bold">Anamnesa lebih dari <?= $hari ?> hari<br />Anda harus
                    menginputkan anamnesa baru</span>
            </div>
        </div>
        <div class="clear"></div>
        <br />
        <?php
                }
            }
        }
        ?>
        <div class="row">
            <div class="col-sm-6">
                <?php if(isset($_GET['pendaftaran_id'])):?>
                <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
                <?php endif;?>
                <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>

                <?php if(isset($_GET['is_triage'])):?>
                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'nomor_triage', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modAnamnesa, 'nomor_triage', array('placeholder' => '', 'class' => '', 'onkeypress' => "return $(this).focusNextInputField(event);", "maxlength" => 2)); ?>
                    </div>
                </div>
                <?php endif;?>
               
                <?php echo $form->dropDownListRow($modAnamnesa, 'pegawai_id', CHtml::listData($modAnamnesa->getDokterItems(), 'pegawai_id', 'NamaLengkap'), array('onkeypress' => "return $(this).focusNextInputField(event);",)); ?>
                <?php // echo $form->dropDownListRow($modAnamnesa, 'paramedis_nama', CHtml::listData(ParamedisV::model()->findAll("ruangan_id = ".Yii::app()->user->getState('ruangan_id')), 'nama_pegawai', 'NamaLengkap'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); 
                ?>
                <?php 
        $loginpemakai = Yii::app()->user->id;
        $criteria = new CDbCriteria;
        $criteria->addCondition('loginpemakai_id = ' . $loginpemakai);
        $pegawai = LoginpemakaiK::model()->find($criteria);
        $kelPegawai = PegawaiM::model()->findByPk($pegawai->pegawai_id);
        $kelPegawaippds = PpdsM:: model()->findByPk($pegawai->ppds_id);
        if ($kelPegawai !== null) {
        if ((!empty($kelPegawai->loginpemakai_id == Yii::app()->user->getState('loginpemakai_id')) && !empty($kelPegawai->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP))) {



        }else{
?>
               <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'ppds_id', array('class' => 'control-label')) ?>
                    <div class="controls">
               <?php
               echo $form->dropDownList(
                    $modAnamnesa, 'ppds_id', CHtml::listData($modAnamnesa->getPPDS(), 'ppds_id', 'ppds_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")
            );
            ?>      </div>
            </div>
    
                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'paramedis_nama', array('class' => 'control-label required')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($modAnamnesa, 'paramedis_nama', CHtml::listData($modAnamnesa->getParamedisItems(), 'pegawai.nama_pegawai', 'pegawai.NamaLengkap'), array('readonly'=>true,'empty' => '-- Pilih --','class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    </div>
                </div>
                <?php  } ?>
                <?php }else{?>
                  <?php  if ((!empty($kelPegawaippds->loginpemakai_id == Yii::app()->user->getState('loginpemakai_id')) && !empty($kelPegawaippds->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP))) {

            }else{
            ?>
       <div class="control-group">
            <?php echo $form->labelEx($modAnamnesa, 'ppds_id', array('class' => 'control-label')) ?>
            <div class="controls">
       <?php
       echo $form->dropDownList(
            $modAnamnesa, 'ppds_id', CHtml::listData($modAnamnesa->getPPDS(), 'ppds_id', 'ppds_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")
    );
    ?>      </div>
    </div>

        <div class="control-group">
            <?php echo $form->labelEx($modAnamnesa, 'paramedis_nama', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($modAnamnesa, 'paramedis_nama', CHtml::listData($modAnamnesa->getParamedisItems(), 'pegawai.nama_pegawai', 'pegawai.NamaLengkap'), array('readonly'=>true,'empty' => '-- Pilih --','class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            </div>
        </div>
        <?php  } ?>
                <?php }?>
                <?php //echo $form->textAreaRow($modAnamnesa, 'keluhanutama', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);"));  
                ?>
                <div class="control-group redactor-left">
                    <?php echo $form->labelEx($modAnamnesa, 'keluhanutama', array('class' => 'control-label required')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                            'model' => $modAnamnesa,
                            'attribute' => 'keluhanutama',
                            'data' => explode(',', $modAnamnesa->keluhanutama),
                            'debugMode' => true,
                            'options' => array(
                                //'bricket'=>false,
                                'json_url' => $this->createUrl('MasterKeluhan'),
                                'addontab' => true,
                                'maxitems' => 10,
                                'input_min_size' => 0,
                                'cache' => true,
                                'newel' => true,
                                'addoncomma' => true,
                                'select_all_text' => "",
                               
                            ),
                        ));
                        ?>
                        <?php echo $form->error($modAnamnesa, 'keluhanutama'); ?>
                    </div>
                </div>
                <div class="control-group redactor-left">
                    <?php echo $form->labelEx($modAnamnesa, 'keluhantambahan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                            'model' => $modAnamnesa,
                            'attribute' => 'keluhantambahan',
                            'data' => explode(',', $modAnamnesa->keluhantambahan),
                            'debugMode' => true,
                            'options' => array(
                                //'bricket'=>false,
                                'json_url' => $this->createUrl('MasterKeluhan'),
                                'addontab' => true,
                                'maxitems' => 10,
                                'input_min_size' => 0,
                                'cache' => true,
                                'newel' => true,
                                'addoncomma' => true,
                                'select_all_text' => "",
                            ),
                        ));
                        ?>
                        <?php echo $form->error($modAnamnesa, 'keluhantambahan'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="RJAnamnesaT_riwayatperjalananpasien">Riwayat Penyakit Pasien</label>
                    <div class="controls">
                        <?php echo $form->textArea($modAnamnesa, 'riwayatperjalananpasien', array('placeholder' => 'Riwayat Penyakit Pasien', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

                        <?php echo $form->error($modAnamnesa, 'riwayatperjalananpasien'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'keterangananamesa', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modAnamnesa, 'attribute' => 'keterangananamesa', 'toolbar' => 'mini', 'height' => '200px')) ?>
                    </div>
                </div>
                <?php if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_KEBIDANAN) : ?>
                <div class="control-group">
                    <?php
                        if (!empty($modAnamnesa->hpht))
                            $modAnamnesa->hpht = MyFormatter::formatDateTimeForUser($modAnamnesa->hpht);
                        echo $form->labelEx($modAnamnesa, 'hpht', array('class' => 'control-label'))
                        ?>
                    <div class="controls">
                        <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modAnamnesa,
                                'attribute' => 'hpht',
                                'value' => null,
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true,
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'class' => 'span3 htpd',
                                ),
                            ));
                            ?>
                        <?php
                            echo CHtml::htmlButton('Kosongkan', array(
                                'class' => 'btn btn-danger', 'onclick' => "$('.htpd').val('');",
                                'id' => 'btnKosongAPHT', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            ))
                            ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php
                        if (!empty($modAnamnesa->tgl_persalinan))
                            $modAnamnesa->tgl_persalinan = MyFormatter::formatDateTimeForUser($modAnamnesa->tgl_persalinan);
                        echo $form->labelEx($modAnamnesa, 'tgl_persalinan', array('class' => 'control-label'))
                        ?>
                    <div class="controls">
                        <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modAnamnesa,
                                'attribute' => 'tgl_persalinan',
                                'value' => null,
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    //'maxDate' => 'd',
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true,
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'class' => 'span3 tgl_persalinan',
                                ),
                            ));
                            ?>
                        <?php
                            echo CHtml::htmlButton('Kosongkan', array(
                                'class' => 'btn btn-danger', 'onclick' => "$('.tgl_persalinan').val('');",
                                'id' => 'btnKosongTglPersalinan', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            ))
                            ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-sm-6">
 
               
               
            </div>
        </div>
        <?php
        if (Yii::app()->user->getState('is_klinikanak')) {
            echo $this->renderPartial($this->path_view . "klinik_anak._form", array(
                'modAnamnesa' => $modAnamnesa, 'form' => $form,
            ), true);
        }
        ?>
    </div>
</div>

<?php if(isset($_GET['pendaftaran_id'])):

if ($modPasien->jeniskelamin == 'PEREMPUAN'){
    echo $this->renderPartial($this->path_view . "pasien-ibu-hamil/index", array(
        'form' => $form,
        'model' => $modAnamnesa,
    ), true);
}

endif;

echo $this->renderPartial($this->path_view . "_skriningGiziDewasa", array(
    'form' => $form,
    'modAnamnesa' => $modAnamnesa,
), true);

echo $this->renderPartial($this->path_view . "_jsFunction", array(), true);
?>



<?php /*
  if(Yii::app()->user->getState('instalasi_id') == PARAMS::INSTALASI_ID_RD){ ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><b>Triase</b></div>
    </div>
    <div class="panel-body">
        <?php
  //$this->renderPartial($this->path_view.'_formInputTriase',array('modAnamnesa'=>$modAnamnesa,'form'=>$form));
  ?>
    </div>
</div>
<?php
  }
 */ ?>

<div class="form-actions">
    <?php
    $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<!--/div-->
<?php
$js = <<< JS

//===============Awal untu Mengecek Form Sudah DiUbah Atw Belum====================    
    $(":input").keyup(function(event){
            $('#berubah').val('Ya');
         });
    $(":input").change(function(event){
            $('#berubah').val('Ya');
         });  
    $(":input").click(function(event){
            $('#berubah').val('Ya');
         });  
//================Akhir untuk Mengecek  Form Sudah DiUbah Atw Belum===================         
JS;
Yii::app()->clientScript->registerScript('asuransi', $js, CClientScript::POS_READY);
?>


<?php
$js = <<< JS
//==================================================Validasi===============================================
//*Jangan Lupa untuk menambahkan hiddenField dengan id "berubah" di setiap form
//* hidden field dengan id "url"
//*Copas Saja hiddenfield di Line 34 dan 35
//* ubah juga id button simpannya jadi "btn_simpan"


function palidasiForm(obj)
   {
        var berubah = $('#berubah').val();
        if(berubah=='Ya') 
        {
            myConfirm("Apakah Anda Akan menyimpan Perubahan Yang Sudah Dilakukan?","Perhatian!",function(r) {
                if(r)
                    {
                         $('#url').val(obj);
                         $('#btn_simpan').click();

                    }
            });

        }      
   }
JS;
Yii::app()->clientScript->registerScript('validasi', $js, CClientScript::POS_HEAD);
?>

<?php
//========= Dialog buat Pemesanan obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogAddRiwayatPenyakitTerdahulu',
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
if (isset($_GET['RJDiagnosaM']))
    $modDataDiagnosa->attributes = $_GET['RJDiagnosaM'];
$modDataDiagnosa->diagnosa_nama = (isset($_GET['RJDiagnosaM']['diagnosa_nama']) ? $_GET['RJDiagnosaM']['diagnosa_nama'] : "");
$modDataDiagnosa->diagnosa_namalainnya = (isset($_GET['RJDiagnosaM']['diagnosa_namalainnya']) ? $_GET['RJDiagnosaM']['diagnosa_namalainnya'] : "");
$modDataDiagnosa->diagnosa_kode = (isset($_GET['RJDiagnosaM']['diagnosa_kode']) ? $_GET['RJDiagnosaM']['diagnosa_kode'] : "");
//echo $modDataDiagnosa->diagnosa_nama;exit;

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
                                                var data = $(\"#' . CHtml::activeId($modAnamnesa, 'riwayatpenyakitterdahulu') . '\").val();
                                                if (data == \"\"){
                                                    $(\"#' . CHtml::activeId($modAnamnesa, 'riwayatpenyakitterdahulu') . '\").val(\"$data->diagnosa_nama\");
                                                } else {
                                                    $(\"#' . CHtml::activeId($modAnamnesa, 'riwayatpenyakitterdahulu') . '\").val(data+\", $data->diagnosa_nama\");                                                  
                                                }
                                                  $(\"#dialogAddRiwayatPenyakitTerdahulu\").dialog(\"close\");    
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
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogAddRiwayatPenyakitKeluarga',
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
if (isset($_GET['RJDiagnosaM']))
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
                                                var data = $(\"#' . CHtml::activeId($modAnamnesa, 'riwayatpenyakitkeluarga') . '\").val();
                                                if (data == \"\"){
                                                    $(\"#' . CHtml::activeId($modAnamnesa, 'riwayatpenyakitkeluarga') . '\").val(\"$data->diagnosa_nama\");
                                                } else {
                                                    $(\"#' . CHtml::activeId($modAnamnesa, 'riwayatpenyakitkeluarga') . '\").val(data+\", $data->diagnosa_nama\");
                                                }
                                                $(\"#dialogAddRiwayatPenyakitKeluarga\").dialog(\"close\");    
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
//========= Dialog buat Pencarian Riwayat Imunisasi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogAddRiwayatImunisasi',
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
if (isset($_GET['RJDiagnosaM']))
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
                                                var data = $(\"#' . CHtml::activeId($modAnamnesa, 'riwayatimunisasi') . '\").val();
                                                if (data == \"\"){
                                                    $(\"#' . CHtml::activeId($modAnamnesa, 'riwayatimunisasi') . '\").val(\"$data->diagnosa_nama\");
                                                } else {
                                                    $(\"#' . CHtml::activeId($modAnamnesa, 'riwayatimunisasi') . '\").val(data+\", $data->diagnosa_nama\");
                                                }
                                                $(\"#dialogAddRiwayatImunisasi\").dialog(\"close\");    
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
?>

<?php
//========= Dialog buat Pemesanan obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPengobatanYgSudahDilakukan',
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
if (isset($_GET['RJObatAlkesM']))
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
                                                var data = $(\"#' . CHtml::activeId($modAnamnesa, 'pengobatanygsudahdilakukan') . '\").val();
                                                if (data == \"\"){
                                                    $(\"#' . CHtml::activeId($modAnamnesa, 'pengobatanygsudahdilakukan') . '\").val(\"$data->obatalkes_nama\");
                                                } else {
                                                    $(\"#' . CHtml::activeId($modAnamnesa, 'pengobatanygsudahdilakukan') . '\").val(data+\", $data->obatalkes_nama\");                                                  
                                                }
                                                  $(\"#dialogPengobatanYgSudahDilakukan\").dialog(\"close\");    
                                        "))',
        ),
        'obatalkes_kode',
        'obatalkes_nama',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<script type="text/javascript">
/**
 * print status
 */
function printAnamnesa() {
    window.open(
        '<?php echo $this->createUrl('printAnamnesa', array('pendaftaran_id' => $modAnamnesa->pendaftaran_id)); ?>',
        'printwin', 'left=100,top=100,width=793,height=1122,scrollbars=yes');
}

function defaultparamedis() {
    var paramedis = '<?php
                            $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                            if (!empty($pegawai))
                                echo $pegawai->nama_pegawai;
                            ?>';
    $("#<?php echo CHtml::activeId($modAnamnesa, 'paramedis_nama') ?>").val(paramedis);
}

function setJumlahRokok(obj) {
    var status = $(obj).val();
    if (status == 0) {
        $('.jmlbtg').attr('readonly', true);
    } else {
        $('.jmlbtg').removeAttr('readonly', true);
    }
}

$(document).ready(function() {
    $('input[name$="[statusmerokok]"][type="radio"]').each(function() {
        if ($(this).is(':checked')) {
            var status = $(this).val();
            if (status == 0) {
                $('.jmlbtg').attr('readonly', true);
            } else {
                $('.jmlbtg').removeAttr('readonly', true);
            }
        }
    });



$(document).ready(function() {
        var ppds = jQuery('#<?php echo CHtml::activeId($modAnamnesa, 'ppds_id') ?>');
        jQuery(ppds).multiselect({
            includeSelectAllOption: false,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

    });

    // defaultparamedis(); 


    $("#rjanamnesa-t-form").find("input,select,textarea").change(function() {
        $("#rjanamnesa-t-form").attr('changed', true);
    });
});
</script>