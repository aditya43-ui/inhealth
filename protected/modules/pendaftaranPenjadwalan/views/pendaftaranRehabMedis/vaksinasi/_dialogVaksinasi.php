<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogJenisVaksinasi',
    'options' => array(
        'title' => 'Tambah Jenis Vaksinasi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 380,
        'resizable' => false,
    ),
));

$model = new JenisvaksinM();
$model->isadakelompok_vaksin = 0;

?>

<div style="padding: 10px;">
<form class="form-horizontal" id="form-jenis-vaksinasi">
    
    
    <div class="control-group">
        <?php echo CHtml::activeLabel($model, 'jenisvaksin_nama', array('class'=>'control-label required', 'label'=>'Nama Jenis Vaksin <span class="required">*</span>')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($model, 'jenisvaksin_nama', array('class'=>'span3')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($model, 'jenisvaksin_namalainnya', array('class'=>'control-label required', 'label'=>'Nama Lain Jenis Vaksin <span class="required">*</span>')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($model, 'jenisvaksin_namalainnya', array('class'=>'span3')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($model, 'isadakelompok_vaksin', array('class'=>'control-label required', 'label'=>'Ada Kelompok Jenis Vaksin? <span class="required">*</span>')); ?>
        <div class="controls">
            <?php echo CHtml::activeRadioButtonList($model, 'isadakelompok_vaksin', array(
                1=>"Ya", 0=>"Tidak",
            ), array(
                'uncheckValue'=>null,
                'template'=>'<div class="radio inline">{input}{label} </div>',
                'class'=>'isadakelompok_vaksin'
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($model, 'jenisvaksinkelompok_id', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeDropDownList($model, 'jenisvaksinkelompok_id', 
                    CHtml::listData(JenisvaksinM::model()->findAll('jenisvaksin_aktif = true order by jenisvaksin_nama asc'), 'jenisvaksin_id', 'jenisvaksin_nama'),
                    array('empty'=>'-- Pilih --', 'class'=>'span3 form_jenisvaksin_jenisvaksin list_jenisvaksin', 'disabled'=>true)); ?>
        </div>
    </div>
    
    <div class="form-action">
        <?php echo CHtml::htmlButton('Simpan', array('class'=>'btn btn-success submit_jenisvaksinasi', 'onclick'=>'simpanJenisVaksin();')); ?>
        <input type="reset" value="Reset" class="btn btn-danger" id="reset_jenisvaksin" />
    </div>
        
    
</form>
</div>

<?php $this->endWidget(); ?>


<?php // ================================================================================================ ?>


<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogVaksin',
    'options' => array(
        'title' => 'Tambah Program Vaksinasi/Imunisasi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 450,
        'resizable' => false,
    ),
));

$modelVak = new VaksinM();

?>


<div style="padding: 10px;">
    <form class="form-horizontal" id="form-program-vaksinasi">
        <div class="control-group">
            <?php echo CHtml::activeLabel($modelVak, 'jenisvaksin_id', array('class'=>'control-label required', 'label'=>'Jenis Vaksin <span class="required">*</span>')); ?>
            <div class="controls">
                <?php echo CHtml::activeDropDownList($modelVak, 'jenisvaksin_id', 
                        CHtml::listData(JenisvaksinM::model()->findAll('jenisvaksin_aktif = true order by jenisvaksin_nama asc'), 'jenisvaksin_id', 'jenisvaksin_nama'),
                        array('empty'=>'-- Pilih --', 'class'=>'span3 list_jenisvaksin vaksin_list_jenisvaksin')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modelVak, 'imunisasi_kategori', array('class'=>'control-label required', 'label'=>'Kategori Vaksinasi/Imunisasi <span class="required">*</span>')); ?>
            <div class="controls">
                <?php echo CHtml::activeDropDownList($modelVak, 'imunisasi_kategori', 
                        LookupM::getItemsUrutan('imunisasi_kategori'),
                        array('empty'=>'-- Pilih --', 'class'=>'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modelVak, 'imunisasi_frekuensi', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeDropDownList($modelVak, 'imunisasi_frekuensi', 
                        LookupM::getItemsUrutan('imunisasi_frekuensi'),
                        array('empty'=>'-- Pilih --', 'class'=>'span3',)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modelVak, 'imunisasi_level', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeDropDownList($modelVak, 'imunisasi_level', 
                        LookupM::getItemsUrutan('imunisasi_level'),
                        array('empty'=>'-- Pilih --', 'class'=>'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modelVak, 'imunisasi_program', array('class'=>'control-label required', 'label'=>'Nama Program Vaksinasi/Imunisasi <span class="required">*</span>')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modelVak, 'imunisasi_program', array('class'=>'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modelVak, 'kategori_pasien', array('class'=>'control-label required', 'label'=>'Kategori Pasien <span class="required">*</span>')); ?>
            <div class="controls">
                <?php echo CHtml::activeDropDownList($modelVak, 'kategori_pasien', 
                        LookupM::getItemsUrutan('imunisasi_kategoripasien'),
                        array('empty'=>'-- Pilih --', 'class'=>'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modelVak, 'imunisasi_sumberdana', array('class'=>'control-label required', 'label'=>'Sumber Dana <span class="required">*</span>')); ?>
            <div class="controls">
                <?php echo CHtml::activeDropDownList($modelVak, 'imunisasi_sumberdana', 
                        LookupM::getItemsUrutan('imunisasi_sumberdana'),
                        array('empty'=>'-- Pilih --', 'class'=>'span3')); ?>
            </div>
        </div>
        
        
        <div class="form-action">
            <?php echo CHtml::htmlButton('Simpan', array('class'=>'btn btn-success submit_vaksinasi', 'onclick'=>'simpanVaksin();')); ?>
            <input type="reset" value="Reset" class="btn btn-danger" id="reset_vaksin" />
        </div>
    </form>
</div>



<?php $this->endWidget(); ?>


<?php // ================================================================================================ ?>


<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDaftarVaksin',
    'options' => array(
        'title' => 'Tambah Nama Vaksinasi/Imunisasi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 300,
        'resizable' => false,
    ),
));

$modelDaftar = new DaftarvaksinM();

?>


<div style="padding: 10px;">
    <form class="form-horizontal" id="form-daftar-vaksinasi">
        <div class="control-group">
            <?php echo CHtml::activeLabel($modelDaftar, 'jenisvaksin_id', array('class'=>'control-label required', 'label'=>'Jenis Vaksin <span class="required">*</span>')); ?>
            <div class="controls">
                <?php echo CHtml::activeDropDownList($modelDaftar, 'jenisvaksin_id', 
                        CHtml::listData(JenisvaksinM::model()->findAll('jenisvaksin_aktif = true order by jenisvaksin_nama asc'), 'jenisvaksin_id', 'jenisvaksin_nama'),
                        array('empty'=>'-- Pilih --', 'class'=>'span3 list_jenisvaksin daftar_list_jenisvaksin', 'onchange'=>'setListVaksinDariDaftar();')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modelDaftar, 'vaksin_id', array('class'=>'control-label required', 'label'=>'Program Vaksinasi/Imunisasi <span class="required">*</span>')); ?>
            <div class="controls">
                <?php echo CHtml::activeDropDownList($modelDaftar, 'vaksin_id', 
                        array(),
                        array('empty'=>'-- Pilih --', 'class'=>'span3 list_jenisvaksin daftar_vaksin_id')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modelDaftar, 'daftarvaksin_nama', array('class'=>'control-label required', 'label'=>'Nama Vaksinasi/Imunisasi <span class="required">*</span>')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modelDaftar, 'daftarvaksin_nama', array('class'=>'span3')); ?>
            </div>
        </div>
        
        <div class="form-action">
            <?php echo CHtml::htmlButton('Simpan', array('class'=>'btn btn-success submit_daftarvaksinasi', 'onclick'=>'simpanDaftarVaksin();')); ?>
            <input type="reset" value="Reset" class="btn btn-danger" id="reset_daftar_vaksin" />
        </div>
    </form>
</div>


<?php $this->endWidget(); ?>


<script>
    
    function tambahMasterJenisVaksin() {
        $("#dialogJenisVaksinasi").dialog("open");
    }
    
    function cekCeklisKelompokJenisVaksin() {
        var nilai = $(".isadakelompok_vaksin:checked").val();
        if (nilai > 0) {
            $(".form_jenisvaksin_jenisvaksin").attr("disabled", false);
        } else {
            $(".form_jenisvaksin_jenisvaksin").attr("disabled", true);
            $(".form_jenisvaksin_jenisvaksin").val(null);
        }
    }
    
    function simpanJenisVaksin() {
        
        if (!requiredCheckUntukAjax($("#form-jenis-vaksinasi"))) {
            return false;
        }
        
        $(".submit_jenisvaksinasi").attr("disabled", true);
        $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/simpanJenisVaksin'); ?>', $("#form-jenis-vaksinasi").serialize(), function(data) {
            if (data.ok == 1) {
                myAlert(data.msg);
                $("#dialogJenisVaksinasi").dialog("close");
                $("#reset_jenisvaksin").click();
                cekCeklisKelompokJenisVaksin();
                setLoadJenisVaksinasi();
            } else {
                myAlert(data.msg);
            }
            $(".submit_jenisvaksinasi").attr("disabled", false);
        }, 'json');
        
    }
    
    
    // =========================================================================
    
    
    function tambahMasterProgramImunisasi() {
        $("#dialogVaksin").dialog("open");
    }
    
    
    function simpanVaksin() {
        
        if (!requiredCheckUntukAjax($("#form-program-vaksinasi"))) {
            return false;
        }
        
        $(".submit_vaksinasi").attr("disabled", true);
        $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/simpanVaksin'); ?>', $("#form-program-vaksinasi").serialize(), function(data) {
            
            var jenisvaksin_id = $(".vaksin_list_jenisvaksin").val();
            
            if (data.ok == 1) {
                myAlert(data.msg);
                $("#dialogVaksin").dialog("close");
                $("#reset_vaksin").click();
                setLoadProgramVaksinasi(jenisvaksin_id);
            } else {
                myAlert(data.msg);
            }
            $(".submit_vaksinasi").attr("disabled", false);
        }, 'json');
        
    }
    
    
    
    // =========================================================================
    
    function tambahMasterVaksin() {
        $("#dialogDaftarVaksin").dialog("open");
    }
    
    function setListVaksinDariDaftar() {
        var jenisvaksin_id = $(".daftar_list_jenisvaksin").val();
        var input_vaksin = $(".daftar_vaksin_id");
        
        $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/ajaxListVaksin'); ?>', {jenisvaksin_id: jenisvaksin_id}, function(data) {
            $(input_vaksin).html(data.html);
        }, 'json');
    }
    
    
    function simpanDaftarVaksin() {
        
        if (!requiredCheckUntukAjax($("#form-daftar-vaksinasi"))) {
            return false;
        }
        
        $(".submit_daftarvaksinasi").attr("disabled", true);
        $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/simpanDaftarVaksin'); ?>', $("#form-daftar-vaksinasi").serialize(), function(data) {
            
            var vaksin_id = $(".daftar_vaksin_id").val();
            
            if (data.ok == 1) {
                myAlert(data.msg);
                $("#dialogDaftarVaksin").dialog("close");
                $("#reset_daftar_vaksin").click();
                setLoadDaftarVaksinasi(vaksin_id);
            } else {
                myAlert(data.msg);
            }
            $(".submit_daftarvaksinasi").attr("disabled", false);
        }, 'json');
        
    }
    
    
    // =========================================================================
    

    $(document).ready(function() {
        $(".isadakelompok_vaksin").on("click", cekCeklisKelompokJenisVaksin);
        cekCeklisKelompokJenisVaksin();
    });

    $('#reset_jenisvaksin').on('click', function(){
        $(".form_jenisvaksin_jenisvaksin").attr("disabled", true);
    })
</script>