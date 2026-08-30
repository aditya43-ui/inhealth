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
                myAlert("Ukuran file tidak boleh lebih dari 5mb","perhatian !");
                $(obj).val("");                 
                $(obj).parents(".controls").find('.labelbrowse').html('');                
                return false;
            }else{
                $(obj).parents(".controls").find('.labelbrowse').html("<u>"+$(obj).get(0).files[0]['name']+"</u>");
                $(obj).parents(".controls").find(".buttonupload").removeClass('hide');
            }
        }       
    }

    function fileLoad(obj, jenis){        
        if (typeof jenis !== 'undefined'){
            var fileBaru = $("#fileBaru").val();
            var jenisSuara = $("#jenisSuara").val();
                                    
            if (fileBaru == '' || jenisSuara == ''){
                toastr.warning("Nama File Baru","Perhatian!");
                return false;
            }
        }
        $(obj).parents(".controls").find('input:file').trigger('click');
        
    }
    
    function tambahSuara(obj){
        var nama = $(obj).val();
        
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('tambahSuara'); ?>',
            data: {nama:nama},           
            dataType: "json",                    
            success: function (data) {
                if (data.sukses == 1){  
                    
                }else{
                    toastr.warning(data.pesan,"Perhatian!");
                }               
            },
            error: function (jqXHR, textStatus, errorThrown) {
                //console.log(errorThrown);
            }
        });
    }

    function simpanSuara(obj, jenis){          
        var formData = new FormData();
        
        if (typeof jenis !== 'undefined'){
            var nama = $("#fileBaru").val();
            var jeniskelamin = $("#jenisSuara").val();
        }else{
            var nama = $(obj).attr('panggil');
            var jeniskelamin = $(obj).attr('jeniskelamin');
        }
        
        var ext = $("#extFile").val();                
        
        formData.append('file', $(obj).parents(".controls").find('#suara')[0].files[0]);
        formData.append('nama', nama);
        formData.append('jeniskelamin', jeniskelamin);
        formData.append('ext', ext);

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('simpanFile'); ?>',
            data: formData,           
            dataType: "json",        
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.sukses == 1){                      
                    $(obj).parents(".controls").find(".buttonupload").addClass('hide');
                    $(obj).parents(".controls").find("#suara").val("");
                    $(obj).parents(".controls").find(".labelbrowse").html("");
                    toastr.success(data.pesan,"Perhatian!");
                    
                    if (typeof jenis !== 'undefined'){
                        $("#namaFile").val(nama);
                        $("#fileBaru").val('');
                    }
                    
                    refreshFile();
                }else{
                    toastr.warning(data.pesan,"Perhatian!");
                }               
            },
            error: function (jqXHR, textStatus, errorThrown) {
                //console.log(errorThrown);
            }
        });


    }
    
    function refreshFile(obj){                                  
        var ext = $("#extFile").val();
        var nama = $("#namaFile").val();

        $("#suarapanggilan").attr("src","");


        if (ext == 'mp3'){
            $(".btn-tambah-suara").attr('accept','.mp3,audio/mp3');
        }else if (ext == 'ogg'){
            $(".btn-tambah-suara").attr('accept','.ogg,audio/ogg');
        }

        $("#form-antrian").addClass('animation-loading');
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('refreshFile'); ?>',
            data: {
                ext:ext,
                nama:nama
            },           
            dataType: "json",                    
            success: function (data) {
                if (data.sukses == 1){  
                    $("#form-antrian").html(data.html);
                    jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip();
                }else{
                    toastr.warning(data.pesan,"Perhatian!");
                }               
                $("#form-antrian").removeClass('animation-loading');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                
            }
        });


    }
    
    function panggilSuara(obj){
        var jeniskelamin = $(obj).attr('jeniskelamin');
        var panggil = $(obj).attr('panggil');
        var ext = $("#extFile").val();
        
//        $.ajax({
//            type: 'POST',
//            url: '<?php //echo $this->createUrl('panggilanSuara'); ?>',
//            data: {
//                jeniskelamin:jeniskelamin,
//                ext:ext,
//                nama:panggil
//            },           
//            dataType: "json",                    
//            success: function (data) {                
                //$(".form-suara-panggilan").html(data.suarapanggilan);
                $("#suarapanggilan").attr("src","<?php echo $this->createUrl('panggilIframe'); ?>&jeniskelamin="+jeniskelamin+"&ext="+ext+"&panggil="+panggil);
//            },
//            error: function (jqXHR, textStatus, errorThrown) {
//                
//            }
//        });
    }
    
    $(document).ready(function(){
        refreshFile();
    });
</script>