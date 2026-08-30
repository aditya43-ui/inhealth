<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<?php
//komen buat ngepull
$this->breadcrumbs = array(
    'Anamnesa',
);

$this->widget('bootstrap.widgets.BootAlert');
?>

<?php
//    if(empty($pasienadmisi_id))
//        $this->renderPartial('/_ringkasDataPasienPendaftaran',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien));
//    else
//        $this->renderPartial('/_ringkasDataPasienPendaftaranRI',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien));
?>
<?php //$this->renderPartial('/_tabulasi', array('modPendaftaran'=>$modPendaftaran)); 
?>

<?php
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.numbersOnly',
    'config' => array(
        'defaultZero' => true,
        'allowZero' => true,
        'decimal' => ',',
        'thousands' => '.',
        'precision' => 1,
        'symbol' => '',
    )
));
?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjanamnesa-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return cekValidasi()'),
    'focus' => '#',
));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->


<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Anamnesis Diet
        </div>
    </div>
    <div class="panel-body">
        <?php echo $form->errorSummary($modAnamnesa); ?>

        <div class="row">
            <div class="col-sm-6">
                <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
                <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>

                <div class="control-group">
                    <?php echo CHtml::label('Dokter / Konselor', 'dokter/konselor', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo CHtml::dropDownList(
                            'pegawai_id',
                            'pegawai_id',
                            CHtml::listData($modAnamnesa->DokterItemsKonsul, 'pegawai_id', 'namaLengkap'),
                            array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'empty' => '-- Pilih --')
                        );
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Ahli Gizi', 'Ahli Gizi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo CHtml::dropDownList(
                            'ahligizi',
                            'ahligizi',
                            CHtml::listData($modAnamnesa->getAhliGiziItems(), 'pegawai_id', 'namaLengkap'),
                            array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'empty' => '-- Pilih --')
                        );
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <?php echo $form->labelEx($modAnamnesa, 'tglanamesadiet', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        //                    'model' => $modAnamnesa,
                        //                    'attribute' => 'tglanamesadiet',
                        'value' =>  MyFormatter::formatDateTimeForUser(date("Y-m-d H:i:s")),
                        'name' => 'tglAnamnesadiet',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                            'dateFormat' => 'yy-mm-dd',
                            'timeFormat' => 'hh:ii:ss',
                        ),
                        'htmlOptions' => array(
                            'readonly' => true,
                            'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    ?>
                </div>
            </div>
        </div>

        <?php
        $this->renderPartial('_formInputAnamnesaDiet', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modAnamnesa' => $modAnamnesa));
        $this->renderPartial('_formInputTabelKomposisi', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modAnamnesa' => $modAnamnesa));
        ?>

        <div class="form-actions">
            <?php
            echo CHtml::htmlButton($modAnamnesa->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan'));
            ?>
            <?php
            $tips = array(
                '0' => 'waktutime',
                '1' => 'autocomplete-search',
                '2' => 'simpan'
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
            ?>
        </div>

    </div>
</div>

<?php $this->endWidget(); ?>

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
            myConfirm('Apakah Anda Akan menyimpan Perubahan Yang Sudah Dilakukan?','Perhatian!',
            function(r){
                if(r){
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
//========= Dialog buat cari data menudiet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDaftarMenuDiet',
    'options' => array(
        'title' => 'Daftar Menu',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 400,
        'resizable' => false,
    ),
));

$modMenuDiet = new MenuDietM('search');
$modMenuDiet->unsetAttributes();
if (isset($_GET['MenuDietM'])) {
    $modMenuDiet->attributes = $_GET['MenuDietM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'menudiet-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modMenuDiet->search(),
    'filter' => $modMenuDiet,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectMenuDiet",
                                    "onClick" => "ubahNilaiKolom(\'$data->menudiet_nama\',\'$data->menudiet_id\');
                                                $(\"#dialogDaftarMenuDiet\").dialog(\"close\");    
                                                return false;
                            "))',
        ),

        array(
            'header' => 'Jenis Diet',
            'name' => 'jenisdiet_id',
            'type' => 'raw',
            'value' => '$data->jenisdiet->jenisdiet_nama',
            'filter' => CHtml::activeDropDownList($modMenuDiet, 'jenisdiet_id', CHtml::listData(
                JenisdietM::model()->findAll(array(
                    'condition' => 'jenisdiet_aktif = true',
                    'order' => 'jenisdiet_id'
                )),
                'jenisdiet_id',
                'jenisdiet_nama'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Nama Menu',
            'name' => 'menudiet_nama',
            'type' => 'raw',
            'value' => '$data->menudiet_nama',
        ),
        array(
            'header' => 'Jumlah Porsi',
            'name' => 'jml_porsi',
            'type' => 'raw',
            'value' => '$data->jml_porsi',
            'filter' => Chtml::activeTextField($modMenuDiet, 'jml_porsi', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Ukuran Rumah Tangga',
            'name' => 'ukuranrumahtangga',
            'type' => 'raw',
            'value' => '$data->ukuranrumahtangga',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function(){'
        . '     setNumbersOnly(this);'
        . '});'
        . '}',
));

$this->endWidget();
//========= end menudiet dialog =============================
?>

<?php
//========= Dialog buat cari daftar bahan makanan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDaftarBahanMakanan',
    'options' => array(
        'title' => 'Daftar Bahan Makanan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 500,
        'resizable' => false,
    ),
));

$modBahanMakanan = new BahanmakananM('search');
$modBahanMakanan->unsetAttributes();
if (isset($_GET['BahanmakananM'])) {
    $modBahanMakanan->attributes = $_GET['BahanmakananM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'bahanmakanan-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modBahanMakanan->search(),
    'filter' => $modBahanMakanan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBahanMakanan",
                                    "onClick" => "ubahNilaiKolomBahan(\'$data->namabahanmakanan\',\'$data->bahanmakanan_id\');
                                                    submitMenuDietPasien();
                                                $(\"#dialogDaftarBahanMakanan\").dialog(\"close\");    
                                                return false;
                            "))',
        ),

        array(
            'header' => 'Golongan Bahan Makanan',
            'name' => 'golbahanmakanan_id',
            'type' => 'raw',
            'value' => '$data->golbahanmakanan->golbahanmakanan_nama',
            'filter' => Chtml::dropDownList('BahanmakananM[golbahanmakanan_id]', $modBahanMakanan->golbahanmakanan_id, Chtml::listData(GZGolbahanmakanan::model()->findAll("golbahanmakanan_aktif = TRUE ORDER BY golbahanmakanan_nama ASC"), 'golbahanmakanan_id', 'golbahanmakanan_nama'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Nama Bahan Makanan',
            'name' => 'namabahanmakanan',
            'type' => 'raw',
            'value' => '$data->namabahanmakanan',
        ),
        array(
            'header' => 'Jenis Bahan Makanan',
            'name' => 'jenisbahanmakanan',
            'type' => 'raw',
            'value' => '$data->jenisbahanmakanan',
            'filter' => Chtml::dropDownList('BahanmakananM[jenisbahanmakanan]', $modBahanMakanan->jenisbahanmakanan, LookupM::getItems('jenisbahanmakanan'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Satuan Bahan',
            'name' => 'satuanbahan',
            'type' => 'raw',
            'value' => '$data->satuanbahan',
            'filter' => Chtml::dropDownList('BahanmakananM[satuanbahan]', $modBahanMakanan->satuanbahan, LookupM::getItems('satuanbahanmakanan'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end daftar bahan makanan dialog =============================
?>


<script>
    <?php
    $jeniswaktuId = CHtml::activeId($modAnamnesa, 'jeniswaktuId');

    $urlGetKomposisiMakanan = Yii::app()->createUrl('gizi/anamnesisDiet/getKomposisiMakanan');
    $jeniswaktu_id = CHtml::activeId($modAnamnesa, 'jeniswaktu_id');
    $menudiet_id = CHtml::activeId($modAnamnesa, 'menudiet_id');
    $bahanmakanan_id = CHtml::activeId($modAnamnesa, 'bahanmakanan_id');
    $idMenuDiet = null;
    ?>
    setTimeout(function() {
        setAll();
    }, 1000);

    function setDialog(obj) {

        $("#menudiet-m-grid").find("tr").removeClass("yellow_background");
        $.get('<?php echo Yii::app()->createUrl($this->route, array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)); ?>', {}, function(data) {
            $("#tableDaftarMenuDiet").html(data);
        });
        parent = $(obj).parents(".input-append").find("input").attr("id");
        dialog = "#dialogDaftarMenuDiet";
        $(dialog).attr("parent-dialog", parent);
        $(dialog).dialog("open");
    }

    function setTindakanAuto(idJenisDiet, idMenuDiet) {
        idBahanMakanan = $("#<?php echo CHtml::activeId($modAnamnesa, '[0]bahanmakanan_id'); ?>").val();
        dialog = "#dialogDaftarMenuDiet";
        parent = $(dialog).attr("parent-dialog");
        obj = $("#" + parent);
        $.get('<?php echo Yii::app()->createUrl('ActionAutoComplete/daftarMenuDiet'); ?>', {
            idJenisDiet: idJenisDiet,
            idMenuDiet: idMenuDiet,
            idBahanMakanan: idBahanMakanan
        }, function(data) {
            $(obj).val(data[0].menudiet_nama);
            setTindakan(obj, data[0]);
        }, "json");
        $(dialog).dialog("close");

    }

    function setTindakan(obj, item) {
        $(obj).parents('tr').find('input[name$="[menudietNama]"]').val(item.menudiet_nama);
        $(obj).parents('tr').find('input[name$="[bahanmakananNama]"]').val(item.bahanmakanan.namabahanmakanan);
    }

    function getIdJenisWaktu(jeniswaktuId) {
        location.hash = "jeniswaktuId=" + jeniswaktuId;
    }

    function getHashValue(key) {
        return location.hash.match(new RegExp(key + '=([^&]*)'))[1];
    }

    function ubahNilaiKolom(menudietNama, menudietId) {
        jeniswaktuId = getHashValue('jeniswaktuId');
        $('#AnamesadietT_' + jeniswaktuId + '_menudietNama').val(menudietNama);
        $('#AnamesadietT_' + jeniswaktuId + '_menudiet_id').val(menudietId);
        $('#AnamesadietT_' + jeniswaktuId + '_jeniswaktu_id').val(jeniswaktuId);

    }

    function ubahNilaiKolomBahan(bahanmakananNama, bahanmakananId) {
        jeniswaktuId = getHashValue('jeniswaktuId');
        $('#AnamesadietT_' + jeniswaktuId + '_bahanmakananNama').val(bahanmakananNama);
        $('#AnamesadietT_' + jeniswaktuId + '_bahanmakanan_id').val(bahanmakananId);
        $('#AnamesadietT_' + jeniswaktuId + '_jeniswaktu_id').val(jeniswaktuId);

    }

    function setAll(obj) {
        var totBeratBahan = 0;
        var totProtein = 0;
        var totEnergiKalori = 0;
        var totLemak = 0;
        var totHidratArang = 0;
        var totBdd = 0;
        $('.noUrut').each(function() {

            var beratBahan = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[beratbahan]"]').val()));
            var protein = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[protein]"]').val()));
            var energiKalori = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[energikalori]"]').val()));
            var lemak = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[lemak]"]').val()));
            var hidratArang = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[hidratarang]"]').val()));
            var bdd = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[bdd]"]').val()));

            if (jQuery.isNumeric(beratBahan)) {
                totBeratBahan += parseFloat(beratBahan);
            }
            if (jQuery.isNumeric(protein)) {
                totProtein += parseFloat(protein);
            }
            if (jQuery.isNumeric(energiKalori)) {
                totEnergiKalori += parseFloat(energiKalori);
            }
            if (jQuery.isNumeric(lemak)) {
                totLemak += parseFloat(lemak);
            }
            if (jQuery.isNumeric(hidratArang)) {
                totHidratArang += parseFloat(hidratArang);
            }

        });

        $('#totBeratBahan').val(formatFloat(totBeratBahan));
        $('#totEnergiKalori').val(formatFloat(totEnergiKalori));
        $('#totProtein').val(formatFloat(totProtein));
        $('#totLemak').val(formatFloat(totLemak));
        $('#totHidratArang').val(formatFloat(totHidratArang));
    }

    function setBeratBahan(obj) {

        $('.noUrut').each(function() {

            var beratBahan = parseFloat(unformatNumber(obj.value));
            var protein = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[protein]"]').val()));
            var energiKalori = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[energikalori]"]').val()));
            var energiKalori2 = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[energikalori2]"]').val()));
            var lemak = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[lemak]"]').val()));
            var hidratArang = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[hidratarang]"]').val()));
            var bdd = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[bdd]"]').val()));

            var nilaiProtein = 4;
            var nilaiLemak = 9;
            var nilaiKarbohidrat = 4;

            console.log(beratBahan, protein, energiKalori, energiKalori2, lemak, hidratArang, bdd);

            var F = beratBahan / ((beratBahan) * (protein));

            var nProtein = beratBahan * protein * nilaiProtein;
            var nLemak = beratBahan * lemak * nilaiLemak;
            var nKarbohidrat = beratBahan * hidratArang * nilaiKarbohidrat;

            var kalori = (nProtein + nLemak + nKarbohidrat);

            console.log(F, nProtein, nLemak, nKarbohidrat, kalori);


            $(obj).parents("tr").find('input[name$="[energikalori]"]').val(formatFloat(kalori));

        });


        setAll();
    }

    function setLemak() {


    }

    function setProtein() {


    }

    function setEnergiKalori() {


    }

    function setHidratArang() {


    }

    function submitMenuDietPasien() {
        $("#tblInputAnamnesisDiet tbody .jeniswaktuId").each(function() {
            var jeniswaktu_id = $(this).parents('tr').find('input[name$="[jeniswaktu_id]"]').val();
            var menudiet_id = $(this).parents('tr').find('input[name$="[menudiet_id]"]').val();
            var bahanmakanan_id = $(this).parents('tr').find('input[name$="[bahanmakanan_id]"]').val();
            var idMenu = $('.menudietId').val();
            if (cekList(jeniswaktu_id) == true && jeniswaktu_id != '') {
                $.post('<?php echo Yii::app()->createUrl('gizi/anamnesisDiet/getKomposisiMakanan'); ?>', {
                    jeniswaktu_id: jeniswaktu_id,
                    menudiet_id: menudiet_id,
                    bahanmakanan_id: bahanmakanan_id
                }, function(data) {
                    $('#tblInputKomposisi tbody').append(data.tr);
                    $('#tblInputKomposisi tbody tr:last').find('.numbersOnly').maskMoney({
                        "defaultZero": true,
                        "allowZero": true,
                        "decimal": ",",
                        "thousands": "",
                        "precision": 2,
                        "symbol": null
                    });
                    setAll(this);
                    clear();
                }, 'json');
            }
        });
    }

    function cekList(id) {
        x = true;
        $('.jeniswaktu_id').each(function() {
            if ($(this).val() == id) {
                myAlert('Bahan Makanan Diet telah ada di List');
                clear();
                x = false;
            }
        });
        return x;
    }

    function hapusList(obj) {
        myConfirm("Yakin Akan Membatalkan Komposisi Makanan?", "Perhatian!",
            function(r) {
                if (r) {
                    $(obj).parents('tr').remove();
                    setAll();
                }
            });

    }

    function cekValidasi() {
        if ($("#tblInputKomposisi tbody tr").length == 0) {
            myAlert("Data belum ditambahkan");
            return false;
        }
        return true;
    }
</script>
<?php

$jscript = <<< JS
    
function remove(obj) {
    $(obj).parents('tr').remove();
    setAll();
}

function clear(){
    
    urut = 1;
    $(".noUrut").each(function(){
        
        $(".menudietNama").val("");
        $(".bahanmakananNama").val("");
        $(".jeniswaktuId").val("");
        $(".menudietId").val("");
        $(".bahanmakananId").val("");

        $(this).val(urut);
         urut++;
    });
}

JS;
Yii::app()->clientScript->registerScript('komposisiMakanan', $jscript, CClientScript::POS_HEAD);
?>