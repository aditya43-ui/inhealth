<?php
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
?>
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
    
    var setNo = (obj) => {
        var no = $(obj).parents(".baris").attr("row-data");        
        $("#no_row").val(no);
    }
    
    var setPegawai = (data, obj) => {
        
        var no = $(obj).parents(".baris").attr("row-data");
        if (obj == ''){
            no = $("#no_row").val();
        }
        
        $("#form-pelaksana > .baris[row-data='"+no+"']").find(".pegawai_id").val(data.pegawai_id);
        $("#form-pelaksana > .baris[row-data='"+no+"']").find(".nama_pegawai").val(data.namaLengkap);
        
        $("#dialogPegawai").dialog("close");
    }
    
    var set_action = (obj,jenis) => {
        var id_attr = $(obj).parents(".form-utama").attr('id');
        var set_obj = $("#"+id_attr);             

        if (jenis == 'tambah'){                    

            tambah_data_baris($(obj));                                 
                        
            $("#"+id_attr+" > .baris:last").find('input,select').val("");            
            
                renameInputRow(set_obj);
            
        }else if (jenis == 'hapus'){
            hapus_data_baris($(obj),function(){
                    renameInputRow(set_obj);
            });
        }                                                
    }
    
    var renameInputRow = (obj_table) => {
            var row = 0;
            var form_body = $(obj_table).find(".pengelompokkan")
            var count = form_body.length;                 
            
                
            form_body.each(function(){       
                if (row == 0){
                    $(this).find('.no-label').show();
                }else{
                    $(this).find('.no-label').hide();
                }
                $(this).find(".nomor").html(row+1);
                $(this).attr("row-data",row);
                $(this).find('input,select,textarea').each(function(){ //element <input>
                    if (typeof $(this).attr("name") !== 'undefined'){
                        var old_name = $(this).attr("name").replace(/]/g,"");
                        var old_name_arr = old_name.split("[");

                        if(old_name_arr.length == 3){
                            $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                            $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
                        }
                    }
                });
                
                $(this).find('.btn-tambah').removeClass('hide');
                $(this).find('.btn-hapus').removeClass('hide');
                if (row == 0) {
                    if (count == 1){                
                        $(this).find('.btn-hapus').addClass('hide');                    
                    }else{
                        $(this).find('.btn-tambah').addClass('hide');
                    }
                }else{                
                    if (count != (row+1)){
                        $(this).find('.btn-tambah').addClass('hide');  
                    }
                }
                
                row++;
            });

    }
    
    
        renameInputRow($("#form-pelaksana"));                
    
    
    /**
     * 
     * @author Yusuf Putra Anugrah<yusufputra@.com>
     * @param {type} id
     * @returns {send and get ajax json}
     * - digunakan untuk merespon fungsi hapus, agar menampilkan warning sebelum ada aksi selanjutnya
     */
    function deleteRecord(id){
        var id = id;    
        var url = '<?php echo $url."/delete"; ?>';
        myConfirm('Yakin Akan Menghapus Data ini ?','Perhatian!',function(r){
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'sukses'){
                                $.fn.yiiGridView.update('data-m-grid');
                            }else{
                                myAlert('Data Gagal di Hapus');
                            }
                },"json");
           }
    });
}

function setRiwayat() {
    invperalatan_id = $('#MAInvkalibarasiT_invperalatan_id').val();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('getInvPeralatan'); ?>',
        data: {invperalatan_id:invperalatan_id},
        dataType: "json",
        success:function(data){
            $('#table-detailbarang > tbody').html(data);
            $('#table-detailbarang').removeClass("animation-loading");
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
    
}
function renameInputRowBarang(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find('span').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
            }
        });
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            }
        });
        row++;
    });       
    
}
</script>