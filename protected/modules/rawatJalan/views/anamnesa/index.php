
<?php 
if(!empty($modPendaftaran)) {
    if($modPendaftaran->validasiRekamMedis()) {
       echo CustomFunction::alertRekamMedis();
    }
}
?>
<?php
//komen buat ngepull
$this->breadcrumbs = array(
    'Anamnesa',
);

$this->widget('bootstrap.widgets.BootAlert');
$hide = '';
if(isset($_GET['lihat'])) {
    $hide = 'hide';
}
?>
<style>
    .ui-autocomplete {
    z-index: 999;
}

/* Set the z-index of the CJui dialog to 1000 */
.ui-dialog {
    z-index: 1000;
}
</style>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjanamnesa-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('class'=>'form-iframe','onKeyPress' => 'return disableKeyPress(event)','onsubmit'=>'requiredCheck(this);'),
    // 'focus' => '#RJAnamnesaT_keluhanutama_annoninput .maininput',
));

$sukses = isset($_GET['sukses'])?$_GET['sukses']:'tak de';
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



<?php 
        $loginpemakai = Yii::app()->user->id;
        $criteria = new CDbCriteria;
        $criteria->addCondition('loginpemakai_id = ' . $loginpemakai);
        $pegawai = LoginpemakaiK::model()->find($criteria);
        $kelPegawai = PegawaiM::model()->findByPk($pegawai->pegawai_id);
        $kelPegawaippds = PpdsM:: model()->findByPk($pegawai->ppds_id);
        if ($kelPegawai !== null) {
        if ((!empty($kelPegawai->loginpemakai_id == Yii::app()->user->getState('loginpemakai_id')) && !empty($kelPegawai->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK)||!empty($kelPegawai->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP))) {
          
?>
        <?php echo $form->errorSummary($modAnamnesa); ?>
        <?php //if(isset($_GET['pendaftaran_id'])):
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'tabel-riwayatanamnesa',
            'content' => array(
                'content-detailanamnesa' => array(
                    'header' => '<b>Tabel Riwayat Anamnesa</b>',
                    'isi' => $this->renderPartial($this->path_view . '_tabelRiwayatAnamnesa2', array(
                        'tabelAnamnesa' => $tabelAnamnesa,
                        'tabelAnamnesaPasien' => $tabelAnamnesaPasien,
                        'format' => new MyFormatter(),
                    ), true),
                    'active' => true,
                ),
            ),
        ));
        // endif;
        
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

<?php $this->endWidget(); ?>

<?php }else{ ?>
  
  
    <?php echo $form->errorSummary($modAnamnesa); ?>
        <?php //if(isset($_GET['pendaftaran_id'])):
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'tabel-riwayatanamnesa',
            'content' => array(
                'content-detailanamnesa' => array(
                    'header' => '<b>Tabel Riwayat Anamnesa</b>',
                    'isi' => $this->renderPartial($this->path_view . '_tabelRiwayatAnamnesa', array(
                        'tabelAnamnesa' => $tabelAnamnesa,
                        'tabelAnamnesaPasien' => $tabelAnamnesaPasien,
                        'format' => new MyFormatter(),
                    ), true),
                    'active' => true,
                ),
            ),
        ));
        // endif;
        
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

    // defaultparamedis(); 


    $("#rjanamnesa-t-form").find("input,select,textarea").change(function() {
        $("#rjanamnesa-t-form").attr('changed', true);
    });
});



$(document).ready(function() {
           var pegawai = jQuery('#<?php echo CHtml::activeId($modAnamnesa, 'pegawai_id') ?>');
           <?php if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_TINDAKAN) : ?>
                jQuery(pegawai).multiselect({
                        includeSelectAllOption: false,
                        buttonClass: "form-control",
                        maxHeight: 300,
                        buttonWidth: '182px',
                        enableCaseInsensitiveFiltering: true
                }).hide();
            <?php endif; ?>	
        
       });


    function searchPegawai() {
            $('#rjanamnesa-t-form input[name*="pegawai_id"]').each(function() {
            });
    }



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


    function searchPegawai() {
            $('#rjanamnesa-t-form input[name*="ppds_id"]').each(function() {
            });
    }
    
</script>
   
     
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

                <?php 
                    if(Yii::app()->user->getState('modul_id') != Params::MODUL_ID_TINDAKAN) {
                       echo $form->hiddenField($modAnamnesa, 'pegawai_id');
                    }
                ?>
                <?php 
                
             
                if(Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_REHAB){
                    if(isset($_GET['pasienmasukpenunjang_id'])){
                        $modPasienMasukPenunjang = PasienmasukpenunjangT::model()->findByPk($_GET['pasienmasukpenunjang_id']);
                        $modAnamnesa->pegawai_id = $modPasienMasukPenunjang->pegawai_id;
                    }
                    echo $form->dropDownListRow($modAnamnesa, 'pegawai_id', CHtml::listData($modAnamnesa->getDokterItems(Yii::app()->user->getState('ruangan_id'),Yii::app()->user->getState('pegawai_id')), 'pegawai_id', 'NamaLengkap'), array('onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => true));

                }else{
                    $disabled = true;
                    if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_TINDAKAN) {
                        $disabled = false;
                    }
                    echo $form->dropDownListRow($modAnamnesa, 'pegawai_id', CHtml::listData($modAnamnesa->getDokterItems(), 'pegawai_id', 'NamaLengkap'), array('onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => $disabled)); 
                }
                ?>
                <?php // echo $form->dropDownListRow($modAnamnesa, 'paramedis_nama', CHtml::listData(ParamedisV::model()->findAll("ruangan_id = ".Yii::app()->user->getState('ruangan_id')), 'nama_pegawai', 'NamaLengkap'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); 
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
                    <?php echo $form->labelEx($modAnamnesa, 'paramedis_nama', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($modAnamnesa, 'paramedis_nama', CHtml::listData($modAnamnesa->getParamedisItems(), 'pegawai.nama_pegawai', 'pegawai.NamaLengkap'), array('disabled'=>true,'empty' => '-- Pilih --','class' => 'span3 ', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    </div>
                </div>
                <?php //echo $form->textAreaRow($modAnamnesa, 'keluhanutama', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);"));  
                ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'keluhanutama', array('class' => 'control-label required')) ?>
                    <div class="controls <?= (isset($_GET['sukses'])) ? '' : 'mouseenter' ?>">
                    <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modAnamnesa, 'attribute' => 'keluhanutama', 'toolbar' => 'mini', 'height' => '200px')) ?>
                 
                    <?php
                        // $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                        //     'model' => $modAnamnesa,
                        //     'attribute' => 'keluhanutama',
                        //     'data' => empty($modAnamnesa->keluhanutama) ? array() : (is_array($modAnamnesa->keluhanutama) ? $modAnamnesa->keluhanutama : explode(',', $modAnamnesa->keluhanutama)),
                        //     'debugMode' => true,
                        //     'options' => array(
                        //         //'bricket'=>false,
                        //         'json_url' => $this->createUrl('MasterKeluhan'),
                        //         'addontab' => true,
                        //         'maxitems' => 10,
                        //         'input_min_size' => 0,
                        //         'cache' => true,
                        //         'newel' => true,
                        //         'addoncomma' => true,
                        //         'select_all_text' => "",
                        //         'autoFocus' => true,
                        //     ),
                        // ));
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
                <div class="control-group redactor-left">
                    <label class="control-label" for="RJAnamnesaT_riwayatperjalananpasien">Riwayat Penyakit Pasien</label>
                    <div class="controls">
                        <?php echo $form->textArea($modAnamnesa, 'riwayatperjalananpasien', array('placeholder' => 'Riwayat Penyakit Pasien', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

                        <?php echo $form->error($modAnamnesa, 'riwayatperjalananpasien'); ?>
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
                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'tglanamnesis', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modAnamnesa,
                            'attribute' => 'tglanamnesis',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 'class' => 'span3', //hapus class 'realtime' RSCMS-4640
                                'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <?php //echo $form->textAreaRow($modAnamnesa, 'keluhantambahan', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); 
                ?>
                <?php //echo $form->textAreaRow($modAnamnesa, 'riwayatpenyakitkeluarga', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); 
                ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'pengobatanygsudahdilakukan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textArea($modAnamnesa, 'pengobatanygsudahdilakukan', array('placeholder' => 'Pengobatan Yang Sudah Dilakukan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php
                        echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array(
                            'class' => 'btn btn-primary', 'onclick' => "$('#dialogPengobatanYgSudahDilakukan').dialog('open');",
                            'id' => 'btnAddPengobatanYgSudahDilakukan', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $modAnamnesa->getAttributeLabel('pengobatanygsudahdilakukan')
                        ))
                        ?>
                        <?php echo $form->error($modAnamnesa, 'pengobatanygsudahdilakukan'); ?>
                    </div>
                </div>
                <?php //echo $form->textAreaRow($modAnamnesa, 'riwayatalergiobat', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));  
                ?>
                <?php echo $form->textAreaRow($modAnamnesa, 'riwayatmakanan', array('placeholder' => 'Riwayat Alergi Makanan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textAreaRow($modAnamnesa, 'riwayatkelahiran', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); 
                ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'riwayatkelahiran', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                            'model' => $modAnamnesa,
                            'attribute' => 'riwayatkelahiran',
                            'data' => explode(',', $modAnamnesa->riwayatkelahiran),
                            'debugMode' => true,
                            'options' => array(
                                //'bricket'=>false,
                                'htmlOptions' => array('style' => 'width:100%;'),
                                'json_url' => $this->createUrl('/ActionAutoComplete/MasterRiwayatKelahiran'),
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
                        <?php echo $form->error($modAnamnesa, 'riwayatkelahiran'); ?>
                    </div>
                </div>

                <?php if(isset($_GET['pendaftaran_id'])):?>

                <?php if ($modPasien->jeniskelamin == 'PEREMPUAN' && in_array($modPasien->kelompokumur_id, Params::getKelompokUmurHamil())) { ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'ispasienwanitahamil', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->radioButtonList($modAnamnesa, 'ispasienwanitahamil', array('Tidak' => 'Tidak', 'Ya' => 'Ya'), array(
                                'template' => '<div class="radio-inline">{input}{label} </div>',
                                'uncheckValue' => null,
                                'class' => 'ispasienwanitahamil'
                            )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'ispasienwanitamenyusui', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->radioButtonList($modAnamnesa, 'ispasienwanitamenyusui', array('Tidak' => 'Tidak', 'Ya' => 'Ya'), array(
                                'template' => '<div class="radio-inline">{input}{label} </div>',
                                'uncheckValue' => null,
                                'class' => 'ispasienwanitamenyusui'
                            )); ?>
                    </div>
                </div>
                <?php } ?>
                <?php if ($modPasien->jeniskelamin == 'PEREMPUAN' && in_array($modPasien->kelompokumur_id, Params::getKelompokUmurCongenital())) { ?>
                <div class="panel_radio_group">
                    <div class="control-group">
                        <?php echo $form->labelEx($modAnamnesa, 'isbayianak_kelainanconginetal', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButtonList($modAnamnesa, 'isbayianak_kelainanconginetal', array('Tidak' => 'Tidak', 'Ya' => 'Ya'), array(
                                    'template' => '<div class="radio-inline">{input}{label} </div>',
                                    'uncheckValue' => null,
                                    'class' => 'isbayianak_kelainanconginetal panel_radio_ceklis'
                                )); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modAnamnesa, 'kelainanconginetal_jenis', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modAnamnesa, 'kelainanconginetal_jenis', array(
                                    'class' => 'span3 isbayianak_kelainanconginetal panel_radio_text',
                                    'data-ceklis' => 'Ya'
                                )); ?>
                        </div>
                    </div>
                </div>
                <?php } ?>

                <?php endif;?>

                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'riwayatimunisasi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textArea($modAnamnesa, 'riwayatimunisasi', array('placeholder' => 'Riwayat Imunisasi', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php
                        echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array(
                            'class' => 'btn btn-primary', 'onclick' => "$('#dialogAddRiwayatImunisasi').dialog('open');",
                            'id' => 'btnAddRiwayatImunisasi', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $modAnamnesa->getAttributeLabel('riwayatimunisasi')
                        ))
                        ?>
                        <?php echo $form->error($modAnamnesa, 'riwayatimunisasi'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'riwayat_operasi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textArea($modAnamnesa, 'riwayat_operasi', array(
                            'class' => 'span3 riwayat_operasi', 'placeholder' => 'Riwayat Operasi',
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'statusmerokok', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->radioButtonList($modAnamnesa, 'statusmerokok', array('0' => 'Tidak', '1' => 'Ya'), array('template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'statusrokok', 'onclick' => 'setJumlahRokok(this);')); ?>

                        <?php echo $form->error($modAnamnesa, 'statusmerokok'); ?>
                    </div>
                </div>
                <div class="control-group" hidden>
                    <?php echo $form->labelEx($modAnamnesa, 'jmlrokok_btg_hr', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modAnamnesa, 'jmlrokok_btg_hr', array('class' => 'span1 jmlbtg', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->labelEx($modAnamnesa, 'Per Hari') ?>
                    </div>
                </div>
                <div class="panel_radio_group">
                    <div class="control-group">
                        <?php echo $form->labelEx($modAnamnesa, 'keb_konsumsialkohol', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButtonList($modAnamnesa, 'keb_konsumsialkohol', array('Tidak' => 'Tidak', 'Ya' => 'Ya'), array(
                                'template' => '<div class="radio-inline">{input}{label} </div>',
                                'uncheckValue' => null,
                                'class' => 'keb_konsumsialkohol panel_radio_ceklis'
                            )); ?>
                        </div>
                    </div>
                    <div class="control-group" hidden>
                        <?php echo $form->labelEx($modAnamnesa, 'jmlalkohol_rutinminum', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modAnamnesa, 'jmlalkohol_rutinminum', array(
                                'class' => 'span3 jmlalkohol_rutinminum panel_radio_text',
                                'data-ceklis' => 'Ya'
                            )); ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Kembiasaan Minum Teh/Kopi//Soda", "", array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="checkbox">
                            <?php echo $form->checkBox($modAnamnesa, 'keb_minumkopi') . $form->label($modAnamnesa, 'keb_minumkopi'); ?>
                        </div>
                        <div class="checkbox">
                            <?php echo $form->checkBox($modAnamnesa, 'keb_minumteh') . $form->label($modAnamnesa, 'keb_minumteh'); ?>
                        </div>
                        <div class="checkbox">
                            <?php echo $form->checkBox($modAnamnesa, 'keb_minumsoda') . $form->label($modAnamnesa, 'keb_minumsoda'); ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'keb_olahraga', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->radioButtonList($modAnamnesa, 'keb_olahraga', array('Tidak' => 'Tidak', 'Ya' => 'Ya'), array(
                            'template' => '<div class="radio-inline">{input}{label} </div>',
                            'uncheckValue' => null,
                            'class' => 'keb_olahraga'
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Gangguan Komunikasi", "", array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="checkbox">
                            <?php echo $form->checkBox($modAnamnesa, 'gangguankomunikasi_bahasaindonesia') . $form->label($modAnamnesa, 'gangguankomunikasi_bahasaindonesia'); ?>
                        </div>
                        <div class="checkbox">
                            <?php echo $form->checkBox($modAnamnesa, 'gangguankomunikasi_gangguanpendengaran') . $form->label($modAnamnesa, 'gangguankomunikasi_gangguanpendengaran'); ?>
                        </div>
                        <div class="checkbox">
                            <?php echo $form->checkBox($modAnamnesa, 'gangguankomunikasi_gangguanbicara') . $form->label($modAnamnesa, 'gangguankomunikasi_gangguanbicara'); ?>
                        </div>
                        <div class="checkbox">
                            <?php echo $form->checkBox($modAnamnesa, 'gangguankomunikasi_tidakada') . $form->label($modAnamnesa, 'gangguankomunikasi_tidakada'); ?>
                        </div>
                    </div>
                </div>
                <div class="panel_radio_group">
                    <div class="control-group">
                        <?php echo $form->labelEx($modAnamnesa, 'riwayatperiksa_diagnosahiv', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButtonList($modAnamnesa, 'riwayatperiksa_diagnosahiv', array('Tidak' => 'Tidak', 'Ya' => 'Ya'), array(
                                'template' => '<div class="radio-inline">{input}{label} </div>',
                                'uncheckValue' => null,
                                'class' => 'riwayatperiksa_diagnosahiv panel_radio_ceklis'
                            )); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modAnamnesa, 'riwayatperiksa_diagnosahivhasil', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textArea($modAnamnesa, 'riwayatperiksa_diagnosahivhasil', array(
                                'class' => 'span3 riwayatperiksa_diagnosahivhasil panel_radio_text',
                                'data-ceklis' => 'Ya'
                            )); ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Apakah Pasien memakai Gigi Palsu & Alat Bantu Dengar", "", array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="checkbox">
                            <?php echo $form->checkBox($modAnamnesa, 'ismemakaigigipalsu') . $form->label($modAnamnesa, 'ismemakaigigipalsu'); ?>
                        </div>
                        <div class="checkbox">
                            <?php echo $form->checkBox($modAnamnesa, 'ismemakaialatbantudengar') . $form->label($modAnamnesa, 'ismemakaialatbantudengar'); ?>
                        </div>
                        <div class="checkbox">
                            <?php echo $form->checkBox($modAnamnesa, 'istidakmemakai_gigipalsualatbantudengar') . $form->label($modAnamnesa, 'istidakmemakai_gigipalsualatbantudengar'); ?>
                        </div>
                    </div>
                </div>
                <?php //echo $form->textAreaRow($modAnamnesa, 'riwayatimunisasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));  
                ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modAnamnesa, 'keterangananamesa', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modAnamnesa, 'attribute' => 'keterangananamesa', 'toolbar' => 'mini', 'height' => '200px')) ?>
                    </div>
                </div>
                <?php //echo $form->textAreaRow($modAnamnesa, 'riwayatimunisasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); 
                ?>
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

<div class="form-actions <?= $hide ?>">
    <?php
    if ($modAnamnesa->isNewRecord) {
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'enabled' => true)
        );
        echo CHtml::link(Yii::t('mds', '{icon} Print Anamnesa', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => 'true', 'style' => 'cursor:not-allowed;'));
    } else if($_GET['tipe'] === 'ubah' || $_GET['tipe'] === 'salin'){
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'enabled' => true)
        );
        echo CHtml::link(Yii::t('mds', '{icon} Print Anamnesa', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => 'true', 'style' => 'cursor:not-allowed;'));
    }
    else {
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'onclick' => "", 'disabled' => true)
        ); //RND-8620
        echo CHtml::link(Yii::t('mds', '{icon} Print Anamnesa', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printAnamnesa();return false", 'enabled' => 'true'));
    }
    ?>
    <?php
    $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>
<?php } ?>
<?php }else{?>
<?php if ((!empty($kelPegawaippds->loginpemakai_id == Yii::app()->user->getState('loginpemakai_id')) && !empty($kelPegawaippds->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK)||!empty($kelPegawaippds->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP))) {
          
          ?>
                  <?php echo $form->errorSummary($modAnamnesa); ?>
                  <?php //if(isset($_GET['pendaftaran_id'])):
                  $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                      'id' => 'tabel-riwayatanamnesa',
                      'content' => array(
                          'content-detailanamnesa' => array(
                              'header' => '<b>Tabel Riwayat Anamnesa</b>',
                              'isi' => $this->renderPartial($this->path_view . '_tabelRiwayatAnamnesa2', array(
                                  'tabelAnamnesa' => $tabelAnamnesa,
                                  'tabelAnamnesaPasien' => $tabelAnamnesaPasien,
                                  'format' => new MyFormatter(),
                              ), true),
                              'active' => true,
                          ),
                      ),
                  ));
                  // endif;
                  
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
          
          <?php $this->endWidget(); ?>
          
          <?php }else{ ?>
            
            
              <?php echo $form->errorSummary($modAnamnesa); ?>
                  <?php //if(isset($_GET['pendaftaran_id'])):
                  $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                      'id' => 'tabel-riwayatanamnesa',
                      'content' => array(
                          'content-detailanamnesa' => array(
                              'header' => '<b>Tabel Riwayat Anamnesa</b>',
                              'isi' => $this->renderPartial($this->path_view . '_tabelRiwayatAnamnesa', array(
                                  'tabelAnamnesa' => $tabelAnamnesa,
                                  'tabelAnamnesaPasien' => $tabelAnamnesaPasien,
                                  'format' => new MyFormatter(),
                              ), true),
                              'active' => true,
                          ),
                      ),
                  ));
                  // endif;
                  
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
          
              // defaultparamedis(); 
          
          
              $("#rjanamnesa-t-form").find("input,select,textarea").change(function() {
                  $("#rjanamnesa-t-form").attr('changed', true);
              });
          });
          
          
          
          $(document).ready(function() {
                     var pegawai = jQuery('#<?php echo CHtml::activeId($modAnamnesa, 'pegawai_id') ?>');
                     
                     <?php if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_TINDAKAN) : ?>
                        jQuery(pegawai).multiselect({
                                includeSelectAllOption: false,
                                buttonClass: "form-control",
                                maxHeight: 300,
                                buttonWidth: '182px',
                                enableCaseInsensitiveFiltering: true
                        }).hide();
                     <?php endif; ?>
                 });
          
          
              function searchPegawai() {
                      $('#rjanamnesa-t-form input[name*="pegawai_id"]').each(function() {
                      });
              }
          
          
          
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
          
          
              function searchPegawai() {
                      $('#rjanamnesa-t-form input[name*="ppds_id"]').each(function() {
                      });
              }
              
          </script>
             
               
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
          
                          <?php echo $form->hiddenField($modAnamnesa, 'pegawai_id') ?>
                          <?php
                                                 
                          echo $form->dropDownListRow($modAnamnesa, 'pegawai_id', CHtml::listData($modAnamnesa->getDokterItems(), 'pegawai_id', 'NamaLengkap'), array('onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => true)); ?>
                          <?php // echo $form->dropDownListRow($modAnamnesa, 'paramedis_nama', CHtml::listData(ParamedisV::model()->findAll("ruangan_id = ".Yii::app()->user->getState('ruangan_id')), 'nama_pegawai', 'NamaLengkap'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); 
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
                              <?php echo $form->labelEx($modAnamnesa, 'paramedis_nama', array('class' => 'control-label')) ?>
                              <div class="controls">
                                  <?php echo $form->dropDownList($modAnamnesa, 'paramedis_nama', CHtml::listData($modAnamnesa->getParamedisItems(), 'pegawai.nama_pegawai', 'pegawai.NamaLengkap'), array('readonly'=>true,'empty' => '-- Pilih --','class' => 'span3 ', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                              </div>
                          </div>
                          <?php //echo $form->textAreaRow($modAnamnesa, 'keluhanutama', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);"));  
                          ?>
                          <div class="control-group">
                              <?php echo $form->labelEx($modAnamnesa, 'keluhanutama', array('class' => 'control-label required')) ?>
                              <div class="controls <?= (isset($_GET['sukses'])) ? '' : 'mouseenter' ?>">
                              <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modAnamnesa, 'attribute' => 'keluhanutama', 'toolbar' => 'mini', 'height' => '200px')) ?>
                           
                              <?php
                                  // $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                                  //     'model' => $modAnamnesa,
                                  //     'attribute' => 'keluhanutama',
                                  //     'data' => empty($modAnamnesa->keluhanutama) ? array() : (is_array($modAnamnesa->keluhanutama) ? $modAnamnesa->keluhanutama : explode(',', $modAnamnesa->keluhanutama)),
                                  //     'debugMode' => true,
                                  //     'options' => array(
                                  //         //'bricket'=>false,
                                  //         'json_url' => $this->createUrl('MasterKeluhan'),
                                  //         'addontab' => true,
                                  //         'maxitems' => 10,
                                  //         'input_min_size' => 0,
                                  //         'cache' => true,
                                  //         'newel' => true,
                                  //         'addoncomma' => true,
                                  //         'select_all_text' => "",
                                  //         'autoFocus' => true,
                                  //     ),
                                  // ));
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
                          <div class="control-group redactor-left">
                              <label class="control-label" for="RJAnamnesaT_riwayatperjalananpasien">Riwayat Penyakit Pasien</label>
                              <div class="controls">
                                  <?php echo $form->textArea($modAnamnesa, 'riwayatperjalananpasien', array('placeholder' => 'Riwayat Penyakit Pasien', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
          
                                  <?php echo $form->error($modAnamnesa, 'riwayatperjalananpasien'); ?>
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
                          <div class="control-group">
                              <?php echo $form->labelEx($modAnamnesa, 'tglanamnesis', array('class' => 'control-label')) ?>
                              <div class="controls">
                                  <?php
                                  $this->widget('MyDateTimePicker', array(
                                      'model' => $modAnamnesa,
                                      'attribute' => 'tglanamnesis',
                                      'mode' => 'datetime',
                                      'options' => array(
                                          'dateFormat' => Params::DATE_FORMAT,
                                          'maxDate' => 'd',
                                      ),
                                      'htmlOptions' => array(
                                          'readonly' => true, 'class' => 'span3', //hapus class 'realtime' RSCMS-4640
                                          'onkeypress' => "return $(this).focusNextInputField(event)"
                                      ),
                                  ));
                                  ?>
                              </div>
                          </div>
                          <?php //echo $form->textAreaRow($modAnamnesa, 'keluhantambahan', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); 
                          ?>
                          <?php //echo $form->textAreaRow($modAnamnesa, 'riwayatpenyakitkeluarga', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); 
                          ?>
                          <div class="control-group">
                              <?php echo $form->labelEx($modAnamnesa, 'pengobatanygsudahdilakukan', array('class' => 'control-label')) ?>
                              <div class="controls">
                                  <?php echo $form->textArea($modAnamnesa, 'pengobatanygsudahdilakukan', array('placeholder' => 'Pengobatan Yang Sudah Dilakukan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                  <?php
                                  echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array(
                                      'class' => 'btn btn-primary', 'onclick' => "$('#dialogPengobatanYgSudahDilakukan').dialog('open');",
                                      'id' => 'btnAddPengobatanYgSudahDilakukan', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                      'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $modAnamnesa->getAttributeLabel('pengobatanygsudahdilakukan')
                                  ))
                                  ?>
                                  <?php echo $form->error($modAnamnesa, 'pengobatanygsudahdilakukan'); ?>
                              </div>
                          </div>
                          <?php //echo $form->textAreaRow($modAnamnesa, 'riwayatalergiobat', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));  
                          ?>
                          <?php echo $form->textAreaRow($modAnamnesa, 'riwayatmakanan', array('placeholder' => 'Riwayat Alergi Makanan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                          <?php //echo $form->textAreaRow($modAnamnesa, 'riwayatkelahiran', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); 
                          ?>
                          <div class="control-group">
                              <?php echo $form->labelEx($modAnamnesa, 'riwayatkelahiran', array('class' => 'control-label')) ?>
                              <div class="controls">
                                  <?php
                                  $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                                      'model' => $modAnamnesa,
                                      'attribute' => 'riwayatkelahiran',
                                      'data' => explode(',', $modAnamnesa->riwayatkelahiran),
                                      'debugMode' => true,
                                      'options' => array(
                                          //'bricket'=>false,
                                          'htmlOptions' => array('style' => 'width:100%;'),
                                          'json_url' => $this->createUrl('/ActionAutoComplete/MasterRiwayatKelahiran'),
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
                                  <?php echo $form->error($modAnamnesa, 'riwayatkelahiran'); ?>
                              </div>
                          </div>
          
                          <?php if(isset($_GET['pendaftaran_id'])):?>
          
                          <?php if ($modPasien->jeniskelamin == 'PEREMPUAN' && in_array($modPasien->kelompokumur_id, Params::getKelompokUmurHamil())) { ?>
                          <div class="control-group">
                              <?php echo $form->labelEx($modAnamnesa, 'ispasienwanitahamil', array('class' => 'control-label')) ?>
                              <div class="controls">
                                  <?php echo $form->radioButtonList($modAnamnesa, 'ispasienwanitahamil', array('Tidak' => 'Tidak', 'Ya' => 'Ya'), array(
                                          'template' => '<div class="radio-inline">{input}{label} </div>',
                                          'uncheckValue' => null,
                                          'class' => 'ispasienwanitahamil'
                                      )); ?>
                              </div>
                          </div>
                          <div class="control-group">
                              <?php echo $form->labelEx($modAnamnesa, 'ispasienwanitamenyusui', array('class' => 'control-label')) ?>
                              <div class="controls">
                                  <?php echo $form->radioButtonList($modAnamnesa, 'ispasienwanitamenyusui', array('Tidak' => 'Tidak', 'Ya' => 'Ya'), array(
                                          'template' => '<div class="radio-inline">{input}{label} </div>',
                                          'uncheckValue' => null,
                                          'class' => 'ispasienwanitamenyusui'
                                      )); ?>
                              </div>
                          </div>
                          <?php } ?>
                          <?php if ($modPasien->jeniskelamin == 'PEREMPUAN' && in_array($modPasien->kelompokumur_id, Params::getKelompokUmurCongenital())) { ?>
                          <div class="panel_radio_group">
                              <div class="control-group">
                                  <?php echo $form->labelEx($modAnamnesa, 'isbayianak_kelainanconginetal', array('class' => 'control-label')) ?>
                                  <div class="controls">
                                      <?php echo $form->radioButtonList($modAnamnesa, 'isbayianak_kelainanconginetal', array('Tidak' => 'Tidak', 'Ya' => 'Ya'), array(
                                              'template' => '<div class="radio-inline">{input}{label} </div>',
                                              'uncheckValue' => null,
                                              'class' => 'isbayianak_kelainanconginetal panel_radio_ceklis'
                                          )); ?>
                                  </div>
                              </div>
                              <div class="control-group">
                                  <?php echo $form->labelEx($modAnamnesa, 'kelainanconginetal_jenis', array('class' => 'control-label')) ?>
                                  <div class="controls">
                                      <?php echo $form->textField($modAnamnesa, 'kelainanconginetal_jenis', array(
                                              'class' => 'span3 isbayianak_kelainanconginetal panel_radio_text',
                                              'data-ceklis' => 'Ya'
                                          )); ?>
                                  </div>
                              </div>
                          </div>
                          <?php } ?>
          
                          <?php endif;?>
          
                          <div class="control-group">
                              <?php echo $form->labelEx($modAnamnesa, 'riwayatimunisasi', array('class' => 'control-label')) ?>
                              <div class="controls">
                                  <?php echo $form->textArea($modAnamnesa, 'riwayatimunisasi', array('placeholder' => 'Riwayat Imunisasi', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                  <?php
                                  echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array(
                                      'class' => 'btn btn-primary', 'onclick' => "$('#dialogAddRiwayatImunisasi').dialog('open');",
                                      'id' => 'btnAddRiwayatImunisasi', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                      'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $modAnamnesa->getAttributeLabel('riwayatimunisasi')
                                  ))
                                  ?>
                                  <?php echo $form->error($modAnamnesa, 'riwayatimunisasi'); ?>
                              </div>
                          </div>
                          <div class="control-group">
                              <?php echo $form->labelEx($modAnamnesa, 'riwayat_operasi', array('class' => 'control-label')) ?>
                              <div class="controls">
                                  <?php echo $form->textArea($modAnamnesa, 'riwayat_operasi', array(
                                      'class' => 'span3 riwayat_operasi', 'placeholder' => 'Riwayat Operasi',
                                  )); ?>
                              </div>
                          </div>
                          <div class="control-group">
                              <?php echo $form->labelEx($modAnamnesa, 'statusmerokok', array('class' => 'control-label')) ?>
                              <div class="controls">
                                  <?php echo $form->radioButtonList($modAnamnesa, 'statusmerokok', array('0' => 'Tidak', '1' => 'Ya'), array('template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'statusrokok', 'onclick' => 'setJumlahRokok(this);')); ?>
          
                                  <?php echo $form->error($modAnamnesa, 'statusmerokok'); ?>
                              </div>
                          </div>
                          <div class="control-group" hidden>
                              <?php echo $form->labelEx($modAnamnesa, 'jmlrokok_btg_hr', array('class' => 'control-label')) ?>
                              <div class="controls">
                                  <?php echo $form->textField($modAnamnesa, 'jmlrokok_btg_hr', array('class' => 'span1 jmlbtg', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                  <?php echo $form->labelEx($modAnamnesa, 'Per Hari') ?>
                              </div>
                          </div>
                          <div class="panel_radio_group">
                              <div class="control-group">
                                  <?php echo $form->labelEx($modAnamnesa, 'keb_konsumsialkohol', array('class' => 'control-label')) ?>
                                  <div class="controls">
                                      <?php echo $form->radioButtonList($modAnamnesa, 'keb_konsumsialkohol', array('Tidak' => 'Tidak', 'Ya' => 'Ya'), array(
                                          'template' => '<div class="radio-inline">{input}{label} </div>',
                                          'uncheckValue' => null,
                                          'class' => 'keb_konsumsialkohol panel_radio_ceklis'
                                      )); ?>
                                  </div>
                              </div>
                              <div class="control-group" hidden>
                                  <?php echo $form->labelEx($modAnamnesa, 'jmlalkohol_rutinminum', array('class' => 'control-label')) ?>
                                  <div class="controls">
                                      <?php echo $form->textField($modAnamnesa, 'jmlalkohol_rutinminum', array(
                                          'class' => 'span3 jmlalkohol_rutinminum panel_radio_text',
                                          'data-ceklis' => 'Ya'
                                      )); ?>
                                  </div>
                              </div>
                          </div>
                          <div class="control-group">
                              <?php echo CHtml::label("Kembiasaan Minum Teh/Kopi//Soda", "", array('class' => 'control-label')) ?>
                              <div class="controls">
                                  <div class="checkbox">
                                      <?php echo $form->checkBox($modAnamnesa, 'keb_minumkopi') . $form->label($modAnamnesa, 'keb_minumkopi'); ?>
                                  </div>
                                  <div class="checkbox">
                                      <?php echo $form->checkBox($modAnamnesa, 'keb_minumteh') . $form->label($modAnamnesa, 'keb_minumteh'); ?>
                                  </div>
                                  <div class="checkbox">
                                      <?php echo $form->checkBox($modAnamnesa, 'keb_minumsoda') . $form->label($modAnamnesa, 'keb_minumsoda'); ?>
                                  </div>
                              </div>
                          </div>
                          <div class="control-group">
                              <?php echo $form->labelEx($modAnamnesa, 'keb_olahraga', array('class' => 'control-label')) ?>
                              <div class="controls">
                                  <?php echo $form->radioButtonList($modAnamnesa, 'keb_olahraga', array('Tidak' => 'Tidak', 'Ya' => 'Ya'), array(
                                      'template' => '<div class="radio-inline">{input}{label} </div>',
                                      'uncheckValue' => null,
                                      'class' => 'keb_olahraga'
                                  )); ?>
                              </div>
                          </div>
                          <div class="control-group">
                              <?php echo CHtml::label("Gangguan Komunikasi", "", array('class' => 'control-label')) ?>
                              <div class="controls">
                                  <div class="checkbox">
                                      <?php echo $form->checkBox($modAnamnesa, 'gangguankomunikasi_bahasaindonesia') . $form->label($modAnamnesa, 'gangguankomunikasi_bahasaindonesia'); ?>
                                  </div>
                                  <div class="checkbox">
                                      <?php echo $form->checkBox($modAnamnesa, 'gangguankomunikasi_gangguanpendengaran') . $form->label($modAnamnesa, 'gangguankomunikasi_gangguanpendengaran'); ?>
                                  </div>
                                  <div class="checkbox">
                                      <?php echo $form->checkBox($modAnamnesa, 'gangguankomunikasi_gangguanbicara') . $form->label($modAnamnesa, 'gangguankomunikasi_gangguanbicara'); ?>
                                  </div>
                                  <div class="checkbox">
                                      <?php echo $form->checkBox($modAnamnesa, 'gangguankomunikasi_tidakada') . $form->label($modAnamnesa, 'gangguankomunikasi_tidakada'); ?>
                                  </div>
                              </div>
                          </div>
                          <div class="panel_radio_group">
                              <div class="control-group">
                                  <?php echo $form->labelEx($modAnamnesa, 'riwayatperiksa_diagnosahiv', array('class' => 'control-label')) ?>
                                  <div class="controls">
                                      <?php echo $form->radioButtonList($modAnamnesa, 'riwayatperiksa_diagnosahiv', array('Tidak' => 'Tidak', 'Ya' => 'Ya'), array(
                                          'template' => '<div class="radio-inline">{input}{label} </div>',
                                          'uncheckValue' => null,
                                          'class' => 'riwayatperiksa_diagnosahiv panel_radio_ceklis'
                                      )); ?>
                                  </div>
                              </div>
                              <div class="control-group">
                                  <?php echo $form->labelEx($modAnamnesa, 'riwayatperiksa_diagnosahivhasil', array('class' => 'control-label')) ?>
                                  <div class="controls">
                                      <?php echo $form->textArea($modAnamnesa, 'riwayatperiksa_diagnosahivhasil', array(
                                          'class' => 'span3 riwayatperiksa_diagnosahivhasil panel_radio_text',
                                          'data-ceklis' => 'Ya'
                                      )); ?>
                                  </div>
                              </div>
                          </div>
                          <div class="control-group">
                              <?php echo CHtml::label("Apakah Pasien memakai Gigi Palsu & Alat Bantu Dengar", "", array('class' => 'control-label')) ?>
                              <div class="controls">
                                  <div class="checkbox">
                                      <?php echo $form->checkBox($modAnamnesa, 'ismemakaigigipalsu') . $form->label($modAnamnesa, 'ismemakaigigipalsu'); ?>
                                  </div>
                                  <div class="checkbox">
                                      <?php echo $form->checkBox($modAnamnesa, 'ismemakaialatbantudengar') . $form->label($modAnamnesa, 'ismemakaialatbantudengar'); ?>
                                  </div>
                                  <div class="checkbox">
                                      <?php echo $form->checkBox($modAnamnesa, 'istidakmemakai_gigipalsualatbantudengar') . $form->label($modAnamnesa, 'istidakmemakai_gigipalsualatbantudengar'); ?>
                                  </div>
                              </div>
                          </div>
                          <?php //echo $form->textAreaRow($modAnamnesa, 'riwayatimunisasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));  
                          ?>
                          <div class="control-group">
                              <?php echo $form->labelEx($modAnamnesa, 'keterangananamesa', array('class' => 'control-label')) ?>
                              <div class="controls">
                                  <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modAnamnesa, 'attribute' => 'keterangananamesa', 'toolbar' => 'mini', 'height' => '200px')) ?>
                              </div>
                          </div>
                          <?php //echo $form->textAreaRow($modAnamnesa, 'riwayatimunisasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); 
                          ?>
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
              if ($modAnamnesa->isNewRecord) {
                  echo CHtml::htmlButton(
                      Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                      array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'enabled' => true)
                  );
                  echo CHtml::link(Yii::t('mds', '{icon} Print Anamnesa', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => 'true', 'style' => 'cursor:not-allowed;'));
              } else if($_GET['tipe'] === 'ubah' || $_GET['tipe'] === 'salin'){
                  echo CHtml::htmlButton(
                      Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                      array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'enabled' => true)
                  );
                  echo CHtml::link(Yii::t('mds', '{icon} Print Anamnesa', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => 'true', 'style' => 'cursor:not-allowed;'));
              }
              else {
                  echo CHtml::htmlButton(
                      Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                      array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'onclick' => "", 'disabled' => true)
                  ); //RND-8620
                  echo CHtml::link(Yii::t('mds', '{icon} Print Anamnesa', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printAnamnesa();return false", 'enabled' => 'true'));
              }
              ?>
              <?php
              $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
              $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
              ?>
          </div>
          <?php $this->endWidget(); ?>
          <?php } ?>
    <?php }?>
<!--/div-->
