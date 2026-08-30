<script>
    function cekData(tipe, id){       
        var pegawai_id = '';
        var pendonor_id = $("#<?php echo CHtml::activeId($modPendonor, 'pendonor_id') ?>").val();
        $('.req').addClass('required');
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('/bankDarah/pendaftaranDonorDarah/cekData'); ?>',
            data: {tipe:tipe,pegawai_id:pegawai_id,pendonor_id:pendonor_id, id},
            dataType: "json",
            success:function(data){
                console.log(data);
                $('.box-seleksidonor').show();
                $("#<?php echo CHtml::activeId($modPendonor, 'jenisidentitas') ?>").val(data.jenisidentitas);
                $("#<?php echo CHtml::activeId($modPendonor, 'pendonor_id') ?>").val(data.pendonor_id);
                $("#<?php echo CHtml::activeId($modPendonor, 'no_identitas') ?>").val(data.no_identitas);
                $("#<?php echo CHtml::activeId($modPendonor, 'nama_lengkap') ?>").val(data.nama_lengkap);
                $("#<?php echo CHtml::activeId($modPendonor, 'tempat_lahir') ?>").val(data.tempat_lahir);
                $("#<?php echo CHtml::activeId($modPendonor, 'tgllahir') ?>").val(data.tgllahir);
                $("#<?php echo CHtml::activeId($modPendonor, 'gol_darah') ?>").val(data.gol_darah);
                $("#<?php echo CHtml::activeId($modPendonor, 'rhesus') ?>").val(data.rhesus);
                if(data.rhesus == 'Positif') {
                    $('#BDPendonorM_rhesus_0').attr('checked', true);
                } else {
                    $('#BDPendonorM_rhesus_1').attr('checked', true);

                }
                $('#dialogPendonor').dialog('close');
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        }); 
    }
</script>