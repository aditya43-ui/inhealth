<?php
$this->breadcrumbs = array(
    'Bedah Sentral',
);

?>
<?php
if(isset($_GET['sukses'])){
	Yii::app()->user->setFlash('success',"Data berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert');
?>
<!--<legend class="rim2">Bedah Sentral</legend>-->
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjkonsul-poli-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($modKirimKeUnitLain, 'catatandokterpengirim'),
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'
    ),
)); ?>
<?php 
$loginpemakai = Yii::app()->user->id;
$criteria = new CDbCriteria;
$criteria->addCondition('loginpemakai_id = ' . $loginpemakai);
$pegawai = LoginpemakaiK::model()->find($criteria);
$kelPegawai = PegawaiM::model()->findByPk($pegawai->pegawai_id);

if (Yii::app()->user->getState('kelompokpegawai_id') == Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN) {     
?>

<div class="formInputTab">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-credit-card"></i> Tabel <b>Riwayat Bedah Sentral Pasien</b>
            </div>
        </div>
        <div class="panel-body table-responsive">
            <div class="block-tabel">
                <?php $this->renderPartial($this->path_view . '_listKirimKeUnitLain2', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain)) ?>
            </div>
        </div>
    </div>

    <?php $this->endWidget(); ?>
<script type="text/javascript">
    // function idOperasi(){
    //     var operasi_id = [];
    //     var tgl = $('#RJPasienKirimKeUnitLainT_tgl_rencanaoperasi').val();

    //     $("input:checked").each(function() {
    //         operasi_id.push($(this).val());
    //     });

    //     $.post('<?php echo $this->createUrl('CekTanggal') ?>', {
    //         operasi_id: operasi_id,
    //         tgl: tgl
    //     }, function(data) {
    //         if (data.ada == 1) {
    //             window.parent.toastr.error(data.pesan);
    //         }else{
    //             window.parent.toastr.success(data.pesan);
    //         }
    //     }, 'json');

    // }

    function batalKirim(idPasienKirimKeUnitLain, pendaftaran_id) {
        myConfirm("Apakah Anda akan membatalkan kirim pasien ke Bedah Sentral?", "Perhatian!", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('ajaxBatalKirim') ?>', {
                    idPasienKirimKeUnitLain: idPasienKirimKeUnitLain,
                    pendaftaran_id: pendaftaran_id
                }, function(data) {
                    $('#tblListRencanaOperasi').html(data.result);
                    myAlert(data.pesan);
                }, 'json');
            }
        });
    }


/**
 * update (refresh) checklist pemeriksaan bedah
 * harus include /js/jquery.tiler.js
 * @param {obj} form_checklist
 */
function updateChecklistPemeriksaanBedah(){
	var sukses = '<?= isset($_GET['sukses'])?1:0; ?>';

    var keg_operasi = $("#RJTarifoperasiruanganV_kegiatanoperasi_nama").val();
    var operasi = $("#RJTarifoperasiruanganV_operasi_nama").val();
    var pendaftaran_id = $("#pendaftaran_id").val();

    var tbl = [];
    var cp = $("#tblFormRencanaOperasi tbody").find('tr').length;

    if(cp > 0) {

        $("#tblFormRencanaOperasi tbody").find('tr').each(function () {

            var id = $(this).attr('id').replace("operasi_", "");

            tbl.push(parseInt(id));

        });

    }

    $('.daftar-pemeriksaan').addClass("animation-loading");
    
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetChecklistPemeriksaanBedah'); ?>',
        data: {keg_operasi: keg_operasi, operasi: operasi, sukses:sukses, pendaftaran_id:pendaftaran_id},
        dataType: "json",
        success:function(data){
            $('.daftar-pemeriksaan').html(data.content);
            //$('.checkboxlist-tile').tile({widths : [ 256 ]});


            if(tbl.length > 0) {

                $.each(tbl, function(idx, val) {

                    $('input[type="checkbox"][value="' + val + '"]').prop('checked', 'checked');

                });

            }

            $('.daftar-pemeriksaan').removeClass("animation-loading");
            //setCheckedPemeriksaan($("#form-tindakanpemeriksaan"));
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

    const cekForm2 = () => {
        if(list_operasi.length > 0){
            if (requiredCheck($("#rjkonsul-poli-t-form"))){
                $("#formOperasi").find("input:checkbox").each(function(){
                    if ($(this).prop('checked') == false){
                        $(this).attr("disabled", true);        
                    }
                });
                
                var jenisoperasi_list = $(".jenisoperasi_list").val();
                var val_jenis = "";
                if (jenisoperasi_list != null) {
                    val_jenis = jenisoperasi_list.join(", ");
                }
    
                $(".jenisoperasi").val(val_jenis);
                            
                disableOnSubmit($("#btn_simpan"));
                $("#rjkonsul-poli-t-form").submit();
            }
        }
        return false;
    }

    $(document).ready(function() {
        var jenisoperasi_list = jQuery('#<?php echo CHtml::activeId($modKirimKeUnitLain, 'jenisoperasi_list') ?>');

        jQuery(jenisoperasi_list).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '240px',
            enableCaseInsensitiveFiltering: true
        }).hide(); 

        // Notifikasi Pasien
        <?php
        if (isset($_GET['smspasien'])) {
            if ($_GET['smspasien'] == 0) {
        ?>
                var params = [];
                params = {
                    instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                    modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                    judulnotifikasi: 'GAGAL KIRIM SMS PASIEN',
                    isinotifikasi: 'Pasien <?php echo $modPasien->nama_pasien; ?> tidak memiliki nomor mobile'
                }; // 16 
                insert_notifikasi(params);
        <?php
            }
        }
        ?>

        <?php
        if (isset($modKirimKeUnitLain->pasienkirimkeunitlain_id)) {
        ?>
            var params = [];
            params = {
                instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                modul_id: <?php echo Params::MODUL_ID_BEDAHSENTRAL ?>,
                judulnotifikasi: 'Pasien Rujukan',
                isinotifikasi: '<?php echo $modPasien->nama_pasien ?> dengan <?php echo $modPasien->no_rekam_medik ?> telah dirujuk pada <?php echo $modKirimKeUnitLain->tgl_kirimpasien ?> dari <?php echo $modKirimKeUnitLain->ruangan->ruangan_nama ?>'
            }; // 16 
            insert_notifikasi(params);
        <?php
        }
        ?>

    });
</script>
<?php
$js = <<< JS
//==================================================Validasi===============================================
//*Jangan Lupa untuk menambahkan hiddenField dengan id "berubah" di setiap form
//* hidden field dengan id "url"
//*Copas Saja hiddenfield di Line 36 dan 35
//* ubah juga id button simpannya jadi "btn_simpan"

function palidasiForm(obj)
{
    var berubah = $('#berubah').val();
    if(berubah=='Ya'){
        myConfirm("Apakah Anda Akan menyimpan Perubahan Yang Sudah Dilakukan?","Perhatian!",function(r) {
            if(r){
                $('#url').val(obj);
                $('#btn_simpan').click();
            }
        });
    }      
}

JS;
Yii::app()->clientScript->registerScript('js', $js, CClientScript::POS_READY);
?>

<?php } else { ?>

    <div class="formInputTab">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-credit-card"></i> Tabel <b>Riwayat Bedah Sentral Pasien</b>
            </div>
        </div>
        <div class="panel-body table-responsive">
            <div class="block-tabel">
                <?php $this->renderPartial($this->path_view . '_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain)) ?>
            </div>
        </div>
    </div>

    <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Daftar Rencana Operasi
                </div>
            </div>
            <div class="panel-body" id='content-pemeriksaan-bedah'>
                <?php $this->renderPartial($this->path_view . '_formCariPemeriksaan', array('modPemeriksaanBedah' => $modPemeriksaanBedah,)); ?>
                <div class='checklists'></div>
            </div>
    </div>
    <div class="daftar-pemeriksaan">
        <?php echo $this->renderPartial($this->path_view . '_formOperasi', array('modKegiatanOperasi' => $modKegiatanOperasi, 'modOperasi' => $modOperasi)); ?>
    </div>
    <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($modKirimKeUnitLain); ?>

    <div class="antirow">
        <div class="row">
            <div class="col-sm-6">
                <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
                <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                <?php echo CHtml::hiddenField('pendaftaran_id', $modPendaftaran->pendaftaran_id, array('readonly' => TRUE)); ?>
                <div class="control-group">
                <?php // echo Chtml::label("Tanggal Rencana Operasi", 'no_identitas_pasien', array('class' => 'control-label')) ?>
                    <?php echo $form->labelEx($modKirimKeUnitLain, 'tgl_kirimpasien', array('class' => 'control-label')) ?>
                    <?php $modKirimKeUnitLain->tgl_kirimpasien = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modKirimKeUnitLain->tgl_kirimpasien, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modKirimKeUnitLain,
                            'attribute' => 'tgl_kirimpasien',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => '+6m',
                            ),
                            'htmlOptions' => array('readonly' => true),
                        )); ?>
                    </div>
                </div>
                <?php echo $form->dropDownListRow(
                    $modKirimKeUnitLain,
                    'pegawai_id',
                    CHtml::listData($modKirimKeUnitLain->getDokterItems(), 'pegawai_id', 'NamaLengkap'),
                    array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")
                ); ?>
                <?php echo $form->textAreaRow($modKirimKeUnitLain, 'catatandokterpengirim', array('placeholder' => 'Keterangan Nama Operasi', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                <div class='control-group'>
                <div class='control-group'>
                    <?php echo CHtml::label("Ruangan <span class='required'>*</span>", CHtml::activeId($modKirimKeUnitLain, 'is_cyto'), array('class' => 'control-label required')) ?>
                    <div class='controls'>
                        <?php 
                        
                        $listRuangan = RuanganM::model()->findAllByAttributes(array(
                            'instalasi_id' => 7, 'ruangan_aktif'=>true
                        ), array(
                            'order'=>'ruangan_nama'
                        ));
                        $listItemRuangan = CHtml::listData($listRuangan, 'ruangan_id', 'ruangan_nama');
                        $listOptionRuangan = array();
                        foreach ($listRuangan as $item) {
                            $listOptionRuangan[$item->ruangan_id] = array(
                                'data-batas' => $item->is_batasorderbedah ? 1 : 0
                            );
                        }
                        
                        
                        echo CHtml::activeDropDownList($modKirimKeUnitLain, 'ruangan_id', $listItemRuangan, array('empty' => '-- Pilih --','onchange'=>'hitungBatasRuangan();','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span3 input_ruangan_id', 'options'=>$listOptionRuangan)); ?>
                    </div>
                </div>
                <div class='control-group'>
                <?php echo CHtml::label("Cyto <span class='required'>*</span>", CHtml::activeId($modKirimKeUnitLain, 'is_cito'), array('class' => 'control-label required')) ?>
                <div class='controls'>
                <?php echo CHtml::activeDropDownList($modKirimKeUnitLain, 'is_cito', array('0'=>'Biasa','1'=>'Cyto'), array('onchange'=>'hitungCyto(this)','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span3')); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <?php echo $this->renderPartial(
                    $this->path_view . '_formRencanaOperasi',
                    array('modPendaftaran' => $modPendaftaran, 'modJenisTarif' => $modJenisTarif)
                ); ?>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'disabled'=>$modPendaftaran->isPasienPulangAtauTindakLanjut($_GET['konsulpoli_id'] ?? null))
        ); ?>   
        <?php 
        //$disableSave = (isset($_GET['sukses']) ? true : false);
        //echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return', 'id' => 'btn_simpan', 'onclick'=>'cekForm();', 'disabled' => $disableSave)); ?>
        <?php
        if (isset($_GET['idPasienKirimKeUnitLain'])) {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp";
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
        } else {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled')) . "&nbsp";
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled'));
        }
        ?>
        <?php
        $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
        $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php //$this->renderPartial($this->path_view . '_jsFunctions', array('modKunjungan' => $modKunjungan, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'modTindakan' => $modTindakan, 'modRencanaOperasi' => $modRencanaOperasi)); ?>
<?php
$idPasienKirimKeUnitLain = isset($_GET['idPasienKirimKeUnitLain']) ? $_GET['idPasienKirimKeUnitLain'] : null;
$urlPrint = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id . '&idPasienKirimKeUnitLain=' . $idPasienKirimKeUnitLain);
$urlPrintRiwayat = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/printRiwayat&id=' . $modPendaftaran->pendaftaran_id);

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=460px');
}
function printRiwayat(caraPrint)
{
    window.open("${urlPrintRiwayat}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}

JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>

<script type="text/javascript">
    // function idOperasi(){
    //     var operasi_id = [];
    //     var tgl = $('#RJPasienKirimKeUnitLainT_tgl_rencanaoperasi').val();

    //     $("input:checked").each(function() {
    //         operasi_id.push($(this).val());
    //     });

    //     $.post('<?php echo $this->createUrl('CekTanggal') ?>', {
    //         operasi_id: operasi_id,
    //         tgl: tgl
    //     }, function(data) {
    //         if (data.ada == 1) {
    //             window.parent.toastr.error(data.pesan);
    //         }else{
    //             window.parent.toastr.success(data.pesan);
    //         }
    //     }, 'json');

    // }

    function batalKirim(idPasienKirimKeUnitLain, pendaftaran_id) {
        myConfirm("Apakah Anda akan membatalkan kirim pasien ke Bedah Sentral?", "Perhatian!", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('ajaxBatalKirim') ?>', {
                    idPasienKirimKeUnitLain: idPasienKirimKeUnitLain,
                    pendaftaran_id: pendaftaran_id
                }, function(data) {
                    $('#tblListRencanaOperasi').html(data.result);
                    myAlert(data.pesan);
                }, 'json');
            }
        });
    }


/**
 * update (refresh) checklist pemeriksaan bedah
 * harus include /js/jquery.tiler.js
 * @param {obj} form_checklist
 */
function updateChecklistPemeriksaanBedah(){
	var sukses = '<?= isset($_GET['sukses'])?1:0; ?>';

    var keg_operasi = $("#RJTarifoperasiruanganV_kegiatanoperasi_nama").val();
    var operasi = $("#RJTarifoperasiruanganV_operasi_nama").val();
    var pendaftaran_id = $("#pendaftaran_id").val();

    var tbl = [];
    var cp = $("#tblFormRencanaOperasi tbody").find('tr').length;

    if(cp > 0) {

        $("#tblFormRencanaOperasi tbody").find('tr').each(function () {

            var id = $(this).attr('id').replace("operasi_", "");

            tbl.push(parseInt(id));

        });

    }

    $('.daftar-pemeriksaan').addClass("animation-loading");
    
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetChecklistPemeriksaanBedah'); ?>',
        data: {keg_operasi: keg_operasi, operasi: operasi, sukses:sukses, pendaftaran_id:pendaftaran_id},
        dataType: "json",
        success:function(data){
            $('.daftar-pemeriksaan').html(data.content);
            //$('.checkboxlist-tile').tile({widths : [ 256 ]});


            if(tbl.length > 0) {

                $.each(tbl, function(idx, val) {

                    $('input[type="checkbox"][value="' + val + '"]').prop('checked', 'checked');

                });

            }

            $('.daftar-pemeriksaan').removeClass("animation-loading");
            //setCheckedPemeriksaan($("#form-tindakanpemeriksaan"));
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

    const cekForm = () => {
        if(list_operasi.length > 0){
            if (requiredCheck($("#rjkonsul-poli-t-form"))){
                $("#formOperasi").find("input:checkbox").each(function(){
                    if ($(this).prop('checked') == false){
                        $(this).attr("disabled", true);        
                    }
                });
                
                var jenisoperasi_list = $(".jenisoperasi_list").val();
                var val_jenis = "";
                if (jenisoperasi_list != null) {
                    val_jenis = jenisoperasi_list.join(", ");
                }
    
                $(".jenisoperasi").val(val_jenis);
                            
                disableOnSubmit($("#btn_simpan"));
                $("#rjkonsul-poli-t-form").submit();
            }
        }
        return false;
    }

    $(document).ready(function() {
        var jenisoperasi_list = jQuery('#<?php echo CHtml::activeId($modKirimKeUnitLain, 'jenisoperasi_list') ?>');

        jQuery(jenisoperasi_list).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '240px',
            enableCaseInsensitiveFiltering: true
        }).hide(); 

        // Notifikasi Pasien
        <?php
        if (isset($_GET['smspasien'])) {
            if ($_GET['smspasien'] == 0) {
        ?>
                var params = [];
                params = {
                    instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                    modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                    judulnotifikasi: 'GAGAL KIRIM SMS PASIEN',
                    isinotifikasi: 'Pasien <?php echo $modPasien->nama_pasien; ?> tidak memiliki nomor mobile'
                }; // 16 
                insert_notifikasi(params);
        <?php
            }
        }
        ?>

        <?php
        if (isset($modKirimKeUnitLain->pasienkirimkeunitlain_id)) {
        ?>
            var params = [];
            params = {
                instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                modul_id: <?php echo Params::MODUL_ID_BEDAHSENTRAL ?>,
                judulnotifikasi: 'Pasien Rujukan',
                isinotifikasi: '<?php echo $modPasien->nama_pasien ?> dengan <?php echo $modPasien->no_rekam_medik ?> telah dirujuk pada <?php echo $modKirimKeUnitLain->tgl_kirimpasien ?> dari <?php echo $modKirimKeUnitLain->ruangan->ruangan_nama ?>'
            }; // 16 
            insert_notifikasi(params);
        <?php
        }
        ?>

    });
</script>
<?php
$js = <<< JS
//==================================================Validasi===============================================
//*Jangan Lupa untuk menambahkan hiddenField dengan id "berubah" di setiap form
//* hidden field dengan id "url"
//*Copas Saja hiddenfield di Line 36 dan 35
//* ubah juga id button simpannya jadi "btn_simpan"

function palidasiForm(obj)
{
    var berubah = $('#berubah').val();
    if(berubah=='Ya'){
        myConfirm("Apakah Anda Akan menyimpan Perubahan Yang Sudah Dilakukan?","Perhatian!",function(r) {
            if(r){
                $('#url').val(obj);
                $('#btn_simpan').click();
            }
        });
    }      
}

JS;
Yii::app()->clientScript->registerScript('js', $js, CClientScript::POS_READY);
?>

<?php 
$konfig = KonfigsystemK::model()->find(); 
$batas_jam = $konfig->jambataspesanbedah ?? 24;
?>

<script>
    var singkatan_waktu = {'Asia/Jakarta': 'WIB', 'Asia/Makassar': 'WITA', 'Asia/Jayapura': 'WIT'};
    var mon = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
    var batasjam = <?php echo $batas_jam; ?>;

    function cekJam(){
        var currentTime = new Date();
        var currentHours = currentTime.getHours();
        var currentMinutes = currentTime.getMinutes();
        // currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;
        // currentHours = (currentHours == 0) ? 24 : currentHours;
        // var jamsekarang = currentHours + ":" + currentMinutes;

        //        var result = ''+days[day]+' '+months[month]+' '+d+' '+year+' '+h+':'+m+':'+s;
        var result = 'Tidak bisa melakukan rujukan Bedah Sentral lebih dari pukul 13:00';
        
        if (app_timezone != null && singkatan_waktu[app_timezone] != null) {
            result += " " + singkatan_waktu[app_timezone];
        }
        
//        $("input[class*='realtimeHeader']").val(result);
        $("div[class*='singkatan']").html(result);

        if(currentHours<=13){
            $('.jam1-13').show();
            $('.jam13plus').hide();
        }else{
            $('.jam1-13').hide();
            $('.jam13plus').show();
        }
    }

    function hitungBatasRuangan() {

        var ruangan_nama = $(".input_ruangan_id option:selected").html();
        var is_batas = $(".input_ruangan_id option:selected").data('batas');
        var currentTime = new Date();
        var currentHours = currentTime.getHours();
        if (is_batas == 1 && currentHours >= batasjam) {
            myAlert("Pemesanan ke ruangan " + ruangan_nama + " dibatasi sampai jam " + batasjam + ".");
            $(".input_ruangan_id").val(null).change();
            return false;
        }

    }

    $(document).ready(function() {
        // cekJam();
        // setInterval(cekJam, 10000);
    });
</script>
<?php } ?>