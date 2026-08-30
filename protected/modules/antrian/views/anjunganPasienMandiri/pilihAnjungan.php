<h3 id="judul_form" style="text-align: center;"></h3>
<div class="menu_pilih" id="pilih_menu">
    <?php echo $this->renderPartial('_pilihMenu', array(), true); ?>
</div>
<div class="menu_pilih" id="form_carabayar">
    <?php echo $this->renderPartial('_caraBayar', array(), true); ?>
</div>
<div class="menu_pilih" id="form_cari_kartu_bpjs">
    <?php echo $this->renderPartial('_cariPasienBpjs', array('modPasien'=>$modPasien), true); ?>
</div>
<div class="menu_pilih" id="form_cari_pasien">
    <?php echo $this->renderPartial('_cariPasien', array('modPasien'=>$modPasien), true); ?>
</div>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pppendaftaran-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('class' => 'form_pendaftaran', 'onKeyPress' => 'return disableKeyPress(event);'), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
    'focus' => '#' . CHtml::activeId($modPasien, 'no_rekam_medik'),
));

echo $form->hiddenField($model, 'carabayar_id', array('class'=>'form_carabayar_id'));

?>

<div class="menu_pilih" id="form_pasien" style="display: none">
    <?php echo $this->renderPartial('_formPasien', array(
        'form'=>$form,
        'modPasien'=>$modPasien,
        'model'=>$model,
    ), true); ?>
    <?php echo $this->renderPartial('_tombolWizard', array(
        'next_id'=>'form_poliklinik',
        'next_label'=>'Berikutnya >>'
    )); ?>
</div>

<div class="menu_pilih" id="form_bpjs" style="display: none">
    <?php echo $this->renderPartial('_formBpjs', array(
        'form'=>$form,
        'modPasien'=>$modPasien,
        'model'=>$model,
        'modSep'=>$modSep,
        'modAsuransiPasien'=>$modAsuransiPasienBpjs,
        'modRujukanBpjs'=>$modRujukanBpjs,
    ), true); ?>
    <?php echo $this->renderPartial('_tombolWizard', array(
        'next_id'=>'form_poliklinik',
        'next_label'=>'Berikutnya >>'
    )); ?>
</div>

<div class="menu_pilih" id="form_poliklinik" style="display: none">
    <?php echo $this->renderPartial('_poliklinik', array(
        'form'=>$form,
        'model'=>$model,
        'modPasien'=>$modPasien,
    ), true); ?>
    <?php echo $this->renderPartial('_tombolWizard', array(
        'prev_id'=>'form_pasien',
        'prev_label'=>'<< Sebelumnya',
        'next_id'=>'form_dokter',
        'next_label'=>'Berikutnya >>',
    )); ?>
</div>
<div class="menu_pilih" id="form_dokter" style="display: none">
    <?php echo $this->renderPartial('_dokter', array(
        'form'=>$form,
        'model'=>$model,
    ), true); ?>
    <?php echo $this->renderPartial('_tombolWizard', array(
        'prev_id'=>'form_poliklinik',
        'prev_label'=>'<< Sebelumnya',
        'next_id'=>'form_hak',
        'next_label'=>'Berikutnya >>',
    )); ?>
</div>
<div class="menu_pilih" id="form_hak" style="display: none">
    <?php echo $this->renderPartial('_hakPasien', array(
        'form'=>$form,
        'model'=>$model,
    ), true); ?>
    <?php echo $this->renderPartial('_tombolWizard', array(
        'prev_id'=>'form_dokter',
        'prev_label'=>'<< Sebelumnya',
        'next_id'=>'submit',
        'next_label'=>'Simpan',
    )); ?>
</div>
<div class="menu_pilih" id="form_verifikasi" style="display: none">
    <?php echo $this->renderPartial('_formVerifikasi', array(), true); ?>
    <div class="row-fluid" style="text-align: center;">
        <?php echo CHtml::htmlButton('Simpan', array(
            'class'=>'btn btn-primary',
            'onclick'=>'$(this).addClass("animation-loading"); $("#pppendaftaran-t-form").submit()',
        )); ?>
        <?php echo CHtml::htmlButton('<< Kembali', array(
            'class'=>'btn btn-success',
            'onclick'=>"setFormPanel('form_hak');",
        )); ?>
    </div>
</div>
<?php $this->endWidget(); ?>

<script>

    var prev_menu = null;

    function setFormPanel(id, tipe) {

        var carabayar_id = $(".form_carabayar_id").val();

        if (typeof tipe == "undefined") {
            tipe = null;
        }

        if (carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS; ?>) {
            if (prev_menu == "form_pasien" 
                    && id == "form_poliklinik" 
                    && tipe == "next" 
            ) {
                setFormPanel("form_bpjs");
                return false;
            } else if (prev_menu == "form_poliklinik" && id == "form_pasien" && tipe == "prev") {
                setFormPanel("form_bpjs");
                return false;
            }
        }


        $(".menu_pilih").hide();
        $("#" + id).show();
        prev_menu = id;


    }

    function pilihTipe(tipe) {
        if (tipe == 'pasien_baru') {
            $("#judul_form").html("PENDAFTARAN PASIEN BARU - UMUM");
            setFormPanel('form_pasien');
        } else if (tipe == 'pasien_lama') {
            $("#judul_form").html("PENDAFTARAN PASIEN LAMA");
            setFormPanel('form_carabayar');
        }
    }

    function kembaliKeHalamanAwal() {
        $("#judul_form").html("");
        $(".form_carabayar_id").val("");
        $("#pppendaftaran-t-form").trigger("reset");
        $(".input_lama").hide();
        setFormPanel('pilih_menu');
    }

    function cekVerifikasi() {
        $(".nik").removeClass('error');
        $(".nik").parents(".control-group").removeClass('error');
        $(".nik_pj").removeClass('error');
        $(".nik_pj").parents(".control-group").removeClass('error');
        $(".nama_ibu").removeClass('error');
        $(".nama_ibu").parents(".control-group").removeClass('error');


        if ($(".form_ruangan_id").val() == "") {
            myAlert("Ruangan harus dipilih");
        }

        if ($(".form_dokter_id").val() == "") {
            myAlert("Dokter harus dipilih");
        }

        if(requiredCheck($(".form_pendaftaran"))){

            if (!cekNoIdentitas()) return false;
            //if (!cekNoIdentitasPJ()) return false;
            if (!cekIbu()) return false;
            //if (!cekNoAsuransiBpjs()) return false;

            $(".form_view_verifikasi").html("").addClass("animation-loading");
            setFormPanel("form_verifikasi");


            $.post('<?php echo $this->createUrl('validasiPasien'); ?>', $("form").serialize(), function(data) {
                if (data.ok == 1) {
                //$(".form_pendaftaran").find('.integer-decimal, .float').each(function(){
                //    $(this).val(unformatNumber($(this).val()));
                //    console.log($(this).val())
                //});
                    //$('#dialog-verifikasi').dialog("open");
                    $.ajax({
                    type:'POST',
                    url:'<?php echo $this->createUrl('verifikasi'); ?>',
                    data: $("form").serialize(),
                    dataType: "json",
                    success:function(data){
                            if (data.ok == 1){
                                $('.form_view_verifikasi').html(data.content).removeClass("animation-loading");
                            }else{
                                alert(data.msg);
                                setFormPanel("form_hak");
                            }
                    },
                        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); }
                    });
                    //untuk verifikasi hilangkan srbac loading
                    //$(".animation-loading").removeClass("animation-loading");
                    //$(".form_pendaftaran").find('.float').each(function(){
                    //    $(this).val(formatFloat($(this).val()));
                    //});
                    // $("form").find('.integer').each(function(){
                    //     $(this).val(unformatNumber($(this).val()));
                    // });
                    //$(".form_pendaftaran").find('.integer-decimal').each(function(){
                    //    $(this).val(formatThousandDecimal($(this).val()));
                    //});
                } else {
                    myAlert(data.msg);
                }
            }, 'json');
        }

        return false;
    }

    function cekNoIdentitas() {

        var jenis = null;
        var nomor = null;
        var umur = 1;

        $(".jenisidentitas").removeClass('error');
        $(".jenisidentitas").parents(".control-group").removeClass('error');

        if ($(".jenisidentitas").val() == "") {

            <?php
            // rawat darurat tidak mandatory
            if (strtolower($this->id) == 'pendaftaranrawatdarurat'): ?>

            console.log("RD");
            return true;

            <?php else: ?>

            console.log("RJ");

            $(".jenisidentitas").addClass('error');
            $(".jenisidentitas").parents(".control-group").addClass('error');
            $(".jenisidentitas")[0].focus();
            myAlert("Masukkan Jenis Identitas");
            return false;

            <?php endif; ?>
        }

        jenis = $(".jenisidentitas").val();
        nomor = $(".nik").val().trim();

        // set umut
        if ($(".umur").val().trim() != null) {
            umur = $(".umur").val();
            umur = umur.split(" ");
            umur = umur[0];
        }

        console.log("KTP", umur, nomor);

        if (jenis.trim() == "KTP" && umur > 16) {

            if (nomor == "") {
                $(".nik").addClass('error');
                $(".nik").parents(".control-group").addClass('error');
                $(".nik")[0].focus();
                myAlert("Nomor KTP Harus Diisi.");
                return false;

            }

            if (nomor.length != 16) {
                $(".nik").addClass('error');
                $(".nik").parents(".control-group").addClass('error');
                $(".nik")[0].focus();
                myAlert("Nomor KTP harus diinput 16 digit.");
                return false;
            }
            /*
            if (!cekRendundansiNomor(nomor)) {
                $(".nik").addClass('error');
                $(".nik").parents(".control-group").addClass('error');
                $(".nik")[0].focus();
                myAlert("No KTP yang anda masukan tidak sesuai. 4 digit diawal tidak boleh sama.");
                return false;
            }
            */
        }

        return true;
    }

    /**
     * Validasi input Nama Ibu nermama 'IBU'
     *
     * @returns {Boolean} true jika selain bernama 'IBU', false jika sebaliknya. */
    function cekIbu() {

        var nama_ibu = $(".nama_ibu").val().trim().toLowerCase();

        if (nama_ibu == 'ibu') {
            $(".nama_ibu").addClass('error');
            $(".nama_ibu").parents(".control-group").addClass('error');
            $(".nama_ibu")[0].focus();
            myAlert("Nama Ibu Tidak boleh diisi dengan nama 'IBU'");
            return false;
        }

        return true;
    }



    $(document).ready(function() {
        setFormPanel("pilih_menu");
    });
</script>