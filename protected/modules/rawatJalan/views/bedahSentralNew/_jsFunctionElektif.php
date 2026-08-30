<script type="text/javascript">
    let kirimId = '';
    
    const resetVerifikasi = () => {
        $("#dialogVerifikasi").find("input").val("");
        $("#dialogVerifikasi").dialog("close");
    }
    
    const setVerifikasi = (obj) => {
        kirimId = $(obj).attr("kirim-id");        
        $("#dialogVerifikasi").dialog("open");
    }
    
    const setTglRencana = () => {        
        if (requiredCheck($("#dialogVerifikasi"))){        
            $.post('<?php echo $this->createUrl('setPendaftaran') ?>', {
                kirimId: kirimId,
                pendaftaran_id: <?= $modPendaftaran->pendaftaran_id ?>,
                tglrencana:$("#settglrencanaoperasi").val()
            }, function(data) {
                if (data.sukses == 1){
                    Notiflix.Report.Success("Perhatian!","Data berhasil di update",'ok');
                    resetVerifikasi(); 
                    
                    location.href = '<?= $this->createUrl('index',['pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'pasienadmisi_id'=>!empty($modAdmisi)?$modAdmisi->pasienadmisi_id:'']) ?>';
                }else{
                    Notiflix.Report.Failure("Perhatian!","Data gagal di update",'ok');
                }                     
                kirimId = '';
            }, 'json');
        }
    }
</script>