<script>
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
                return false;
            }

            var sizee = $(obj).get(0).files[0].size; //file size in bytes
            sizee = sizee / 1024; //file size in Kb
            sizee = sizee / 1024; //file size in Mb

            if (sizee > 5) {
                window.parent.toastr.warning("Ukuran file tidak boleh lebih dari 5mb","perhatian !");
                $(obj).val("");                 
                $(obj).parents(".control-group").find('.labelbrowse').html('');                
                return false;
            }else{
                $(obj).parents(".control-group").find('.labelbrowse').html("<u>"+$(obj).get(0).files[0]['name']+"</u>");
            }
        }       
    }
    
    function fileLoad(obj){
        $(obj).parents(".control-group").find('input:file').trigger('click');
    }
</script>