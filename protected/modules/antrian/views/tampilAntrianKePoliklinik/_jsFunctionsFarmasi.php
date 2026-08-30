<script>
function setAntriansFarmasi(antrianfarmasi_id){
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('/antrian/tampilAntrianKeFarmasi/GetAntrians2'); ?>',
        data: {antrianfarmasi_id:antrianfarmasi_id, modelantrian_id: <?php echo $modelantrian_id; ?>},
        dataType: "json",
        success:function(data){
            var class_racikan = '';
            if (data != null) {
                if (data.ruangan != null) {
                    
                    if (data.antrian.racikan_id == 1) {
                        class_racikan = '.panel_antrian_racikan';
                    } else if (data.antrian.racikan_id == 2) {
                        class_racikan = '.panel_antrian_nonracikan';
                    }
                    
                    $(class_racikan + " .ruangan_farmasi span").html(data.ruangan.ruangan_nama);
                    $(class_racikan + " .pasien-deskripsi_farmasi span").html(data.pasien + " - " + data.penjualan.noresep);
                    $(class_racikan + " .no-antrian_farmasi").html(data.loket.racikan_singkatan + "-" + data.antrian.noantrian);
                }
                $(".tab_racikan table tbody").html(data.tabel.racikan);
                $(".tab_nonracikan table tbody").html(data.tabel.nonracikan);
                setSuaraPanggilanFarmasi(data.loket.racikan_singkatan,data.antrian.noantrian);
                
                
            }
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function setSuaraPanggilanFarmasi(kodeantrians,noantrians){
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('/antrian/tampilAntrianKeFarmasi/suaraPanggilan'); ?>',
        data: {kodeantrians:kodeantrians,noantrians:noantrians},
        dataType: "json",
        success:function(data){
            $("#suarapanggilan").html(data.suarapanggilan);
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
</script>