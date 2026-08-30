<script type="text/javascript">
    const loadJadwal = () => {
        
        const subjenis_id = $(".subjenis_id").val();
        const signaoa = $(".signaoa").val();
        
        $.ajax({
            type:'GET',
            url:'<?php echo $this->createUrl('loadJadwal'); ?>',
            data: {
                signaoa,
                subjenis_id
            },
            dataType: "json",
            success:function(data){
                $('#table-list-jadwal > tbody').html(data);
                
                renameInputRow($("#table-list-jadwal"));                                    
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        })
    }
    
    const set_action = (obj,jenis) => {
        const id_attr = $(obj).parents(".form-utama").attr('id');
        const set_obj = $("#"+id_attr);             

        if (jenis == 'tambah'){                    

            tambah_data_baris($(obj));                                 

            renameInputRow(set_obj);

            $("#"+id_attr+" > tbody > tr.baris:last").find('input,select').val("");
            $("#"+id_attr+" > tbody > tr.baris:last").find('span.lbl').html("");


        }else if (jenis == 'hapus'){
            hapus_data_baris($(obj),function(){
                    renameInputRow(set_obj);
            });
        }                                                
    }
   
    const renameInputRow = (obj_table) => {
        var row = 0;
        var count = $(obj_table).find("tbody > tr").length;

        $(obj_table).find("tbody > tr").each(function(){                
            $(this).find(".nourut").html(row+1);
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
    
    $(document).ready(function(){
        setTimeout(function(){
            loadJadwal();
        }, 1000);        
    });
</script>