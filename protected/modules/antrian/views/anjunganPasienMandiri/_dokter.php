<style>
    .btn_dokter {
        width: 250px;
        height: 100px;
        text-align: center;
        color: white;
        background-color: darkgreen;
        margin: 10px;
        float: left;
        padding-top: 10px;
    }

    .btn_dokter.pilih {
        background-color: greenyellow;
        color: black;
    }

    .btn_dokter .btn_dokter_judul {
        font-weight: bold;
    }
</style>

<h4 style="text-align: center">Pilih Dokter Tujuan</h4>

<?php echo $form->hiddenField($model, 'pegawai_id', array('class'=>'form_dokter_id')); ?>

<div id="panel_load_dokter" style="text-align: center;">
    
</div>

<script>
    function loadDokter() {

        console.log("Kick");

        var ruangan_id = $(".form_ruangan_id").val();

        if (ruangan_id == "") {
            return false;
        }

        $.post('<?php echo $this->createUrl('loadDokter'); ?>', {ruangan_id: ruangan_id}, function(data) {
            $("#panel_load_dokter").html(data);
        });
        renderDokter();
    }

    function pilihDokter(id, buka) {
        if (buka == 0) {
            return false;
        }
        $(".form_dokter_id").val(id);
        console.log("Kicker");
        renderDokter();
    }

    function resetDokter() {
        $(".form_dokter_id").val("");
        $("#panel_load_dokter").html("");
    }

    function renderDokter() {
        var id = $(".form_dokter_id").val();
        $(".btn_dokter").removeClass("pilih");
        $(".btn_dokter#btn_dokter_" + id).addClass("pilih");
    }

</script>