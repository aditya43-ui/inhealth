<script type="text/javascript">
    const setDialog = (dialog, jenis)     => {
        $("#jenis_dialog").val(jenis);
        
        if (jenis == 'dpjp'){
            $(".judul-petugas").html("Dokter DPJP");
        }else if (jenis == 'perawat1'){
            $(".judul-petugas").html("Perawat 1");
        }else if (jenis == 'perawat2'){
            $(".judul-petugas").html("Perawat 2");
        }
        
        $("#"+dialog).dialog("open");
    }
    
    const cetakSurat = () => {
        window.open('<?php echo $this->createUrl('cetakSurat', array('id' => $model->travellinghd_id)); ?>', 'travellinghd', 'left=100,top=100,width=860,height=480');
    }
</script>