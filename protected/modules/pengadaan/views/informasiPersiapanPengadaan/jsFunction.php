<script>
    function setMenyetujui(id) {
        $('#RiwayatpengadaanR_statusnya').val('DISETUJUI');
        $('#persiapanpengadaan-t-form').submit();

    }

    function setRevisi(id) {
        $('#RiwayatpengadaanR_statusnya').val('DITOLAK');
        $('#persiapanpengadaan-t-form').submit();
    }
    
    function fileLoad(obj){
        $(obj).parents("tr").find('input:file').trigger('click');
    }
    
    function cekFile(obj){       
        
        var cek = $(obj).val();        
        if (cek != ''){
            var type = $(obj).get(0).files[0]['type'];
            var tipeFile = type.split('/');                    
            var ext = '.'+$(obj).val().split('.').pop().toLowerCase();           
            var fileExt = $(obj).attr('accept').split(',');        
                                                
            if($.inArray(ext, fileExt) == -1 && $.inArray(tipeFile[0]+'/*', fileExt) == -1) {
                myAlert('Tipe file yang diupload tidak diizinkan !',"Perhatian!");
                $(obj).val(""); 
                $(".fileinput-exists").trigger('click');
                return false;
            }

            var sizee = $(obj).get(0).files[0].size; //file size in bytes
            sizee = sizee / 1024; //file size in Kb
            sizee = sizee / 1024; //file size in Mb

            if (sizee > 10) {
                myAlert("Ukuran file tidak boleh lebih dari 200kb/2mb","perhatian !");
                $(obj).val("");                 
                $(obj).parents("tr").find('.labelbrowse').html('');
                $(".fileinput-exists").trigger('click');
                return false;
            }else{
                $(obj).parents("tr").find('.labelbrowse').html("<u>"+$(obj).get(0).files[0]['name']+"</u>");
            }
        }
       
    }
</script>
    