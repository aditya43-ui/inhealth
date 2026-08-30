<script type='text/javascript'>
    
    function cekForm(){
        
        if (requiredCheck($("#penerimaansisa-t-form"))){
            var cek = $("#tabel-terima > tbody > tr").length;
            
            if (cek == 0){
                toastr.warning("Maaf tidak ada data kantong yang diterima","Perhatian!");
                return false;
            }
            
            $("#penerimaansisa-t-form").submit();
            disableOnSubmit($("#btn_submit"));
        }
            
        return false;
    }
      
    
    function loadKantongDarah(obj){
        var nomor_barcode = $(obj).val();
        
        if (nomor_barcode == ''){
            setTimeout(function(){
                $("#nokantongutama").focus();
            },100);
            
            return false;
        }
        
        if (!cekList(nomor_barcode)){
            toastr.warning("Data sudah ditambahkan pada list","Perhatian!");
            $("#nokantongutama").val('');
            $("#nokantongutama").focus();                    
            return false;
        }
        
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('loadKantongDarah'); ?>',
            data: {
                nomor_barcode: nomor_barcode,
            },
            dataType: "json",
            success: function (data) {
                if (data.sukses == 1){                        
                    $("#tabel-terima > tbody ").append(data.tr);
                    $("#nokantongutama").val('');
                    $("#nokantongutama").focus();
                    renameInputRow($("#tabel-terima"));
                }else{
                    toastr.warning(data.pesan,"Perhatian!");
                    $("#nokantongutama").val('');
                    $("#nokantongutama").focus();                    
                }               
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    
    function cekList(nomorbarcode){
        var count = 0;
        $("#tabel-terima > tbody > tr ").each(function(){                        
            if ($(this).find('.nomorbarcode').html() == nomorbarcode ||$(this).find('.nomorbarcode_sample').val() == nomorbarcode){
                count++;
            }
        });
        
        if (count > 0){
            return false;
        }else{        
            return true;
        }
    }
    
    function renameInputRow(obj_table){
        var row = 0;
        var no = 1
        $(obj_table).find("tbody > tr").each(function(){
            if (typeof $(this).find("#no_urut").val() != 'undefined'){
                $(this).find("#no_urut").val(no);
                no++;
            }

            $(this).find('span').each(function(){ //element <input>
                if (typeof $(this).attr("name") != 'undefined'){
                    var old_name = $(this).attr("name").replace(/]/g,"");
                    var old_name_arr = old_name.split("[");
                    if(old_name_arr.length == 3){
                        $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
                    }
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

            var a = 0;
            $(this).find('.banyak-komponen').each(function(){ //element <input>
                $(this).find('input,select,textarea').each(function(){
                    var old_name = $(this).attr("name").replace(/]/g,"");
                    var old_name_arr = old_name.split("[");
                    if(old_name_arr.length == 5){
                        $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]+"_"+a+"_"+old_name_arr[4]);
                        $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]["+a+"]["+old_name_arr[4]+"]");
                    }                         
                    a++;
                });                            
            });
            row++;        
        });
    }
   
</script>
