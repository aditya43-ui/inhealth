<style>
    .btn_poli {
        width: 250px;
        height: 100px;
        text-align: center;
        color: white;
        background-color: darkgreen;
        margin: 10px;
        float: left;
        padding-top: 10px;
    }

    .btn_poli.pilih {
        background-color: greenyellow;
        color: black;
    }

    .btn_poli .btn_poli_judul {
        font-weight: bold;
    }
</style>

<h4 style="text-align: center">Pilih Poliklinik Tujuan</h4>


<?php echo $form->hiddenField($model, 'ruangan_id', array('class'=>'form_ruangan_id')); ?>

<div id="panel_load_poli" style="text-align: center;">
    
</div>

<div id="form-karcis" style="display: none;">

</div>

<script>
    function loadPoli() {
        $.post('<?php echo $this->createUrl('loadPoli'); ?>', {}, function(data) {
            $("#panel_load_poli").html(data);
        });
        renderPoli();
    }

    function pilihPoli(id, buka) {
        if (buka == 0) {
            return false;
        }
        $(".form_ruangan_id").val(id);
        renderPoli();
        setKarcis();

        resetDokter();
        loadDokter();
    }

    function renderPoli() {
        var id = $(".form_ruangan_id").val();
        $(".btn_poli").removeClass("pilih");
        $(".btn_poli#btn_poli_" + id).addClass("pilih");
    }

    function setKarcis()
    {
        var kelaspelayanan_id=<?php echo Params::KELASPELAYANAN_ID_TANPA_KELAS; ?>;
        var ruangan_id=$(".form_ruangan_id").val();
        var penjamin_id=<?php echo Params::PENJAMIN_ID_UMUM; ?>;
        var pasien_id=$("#<?php echo CHtml::activeId($modPasien,"pasien_id");?>").val();

        //alert(kelaspelayanan_id);

        // console.log(no_rekam_medik);

        if(kelaspelayanan_id !== "" && ruangan_id !== "" && penjamin_id !== "") {
            $("#form-karcis").addClass("animation-loading");
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('SetKarcis'); ?>',
                data: {
                    kelaspelayanan_id:kelaspelayanan_id,
                    ruangan_id : ruangan_id,
                    penjamin_id:penjamin_id,
                    pasien_id:pasien_id,
                    no_rekam_medik: null,
                },//
                dataType: "json",
                success:function(data){
                    $("#form-karcis").html(data.listKarcis);
                    $("#form-karcis").removeClass("animation-loading");
                    $("form").find('.integer-decimal').each(function(){
                        $(this).val(formatThousandDecimal($(this).val()));
                    });
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        }else{
            $("#content-karcis-html").html("");
        }

    }

    $(document).ready(function() {
        loadPoli();
    });
</script>