<script type="text/javascript">
    
    var is_checked = {};
    
    function isEmpty(obj) {
        for(var key in obj) {
            if(obj.hasOwnProperty(key))
                return false;
        }
        return true;
    }
        
    function setKantong(obj){
        //var nomor = $(obj).attr('no_penggunaan_coolbox');
        var nomor = $(obj).attr('nomorbarcode_utama');
        
        if ($(obj).prop("checked") == true){
            is_checked[nomor] = nomor;
        }else{
            is_checked[nomor] = 0;
        }
    }
    
    function setSemuaKantong(obj){
        if ($(obj).prop("checked") == true){
            $("input:checkbox.pilih").each(function(){                   
                $(this).prop("checked",true).change();
            });
        }else{
            $("input:checkbox.pilih").each(function(){                       
                $(this).prop("checked",false).change();
            });
        }
        
    }
    
    function refreshDialog(){
        var coolboxdarah_id = $("#<?php echo CHtml::activeId($modKirimKantong, 'coolboxdarah_id') ?>").val();
        var coolboxdarah_nama = $("#<?php echo CHtml::activeId($modKirimKantong, 'coolboxdarah_id') ?> option:selected").text();
        
        $(".dialog_coolboxdarah_id").val(coolboxdarah_id);
        $.fn.yiiGridView.update('barang-m-grid', {
            data:{
                'InfokantongdarahV[coolboxdarah_id]' : coolboxdarah_id
            }
        });
    }
    
    function setCeklisKantong(){                                          
        $("input:checkbox.pilih").each(function(){                                   
            var nomor = $(this);            
            nomor.prop("checked",false);
            nomor.removeAttr("disabled");            
            //$("#table-detailbarang > tbody > tr").find(".no_penggunaan_coolbox").each(function(){                                                             
              //  if (nomor.attr('no_penggunaan_coolbox') == $(this).val()){                    
            $("#table-detailbarang > tbody > tr").find(".nomorbarcode_utama").each(function(){                                                             
                if (nomor.attr('nomorbarcode_utama') == $(this).val()){                    
                    nomor.prop("checked", true);
                    nomor.attr("disabled", true);
                }
            });                       
        });        
    }
    
    function cekSudahAda(nomor,obj){
        var x = true;
        
        //$('.no_penggunaan_coolbox').each(function(){
        $('.nomorbarcode_utama').each(function(){        
            if ($(this).val() == nomor){                
                x = false;
                $('#table-detailbarang').removeClass("animation-loading");                
            }else{
                
            }
	});
        
        if (x == false){
            myAlert('Kantong telah ada d List');
            $(obj).val('');
        }else{
            tambahKantong(nomor);
            $(obj).val('');
        }
    }
    
   function tambahKantong(nomor) {   
       
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('getKantong'); ?>',
            //data: {no_penggunaan_coolbox:nomor},
            data: {nomorbarcode_utama:nomor},    
            dataType: "json",
            success:function(data){
                if (data.ditemukan == 1){
                    $('#table-detailbarang > tbody').append(data.tr);
                    $('#table-detailbarang').removeClass("animation-loading");
                    renameInputRowBarang($("#table-detailbarang"));
                    is_checked = {};            
                    $("#nomorbarcode").focus();
                }else{
                    if (nomor != ''){
                        myAlert("No. Barcode Kantong <b>"+nomor+"</b> Utama tidak ditemukan");
                        $("#nomorbarcode").focus();
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }

    function pilihsemua(obj, classnya) {
        $('#table-detailbarang tbody tr').each(function(){
            if($(obj).is(':checked')) {
                $(this).find('.' + classnya).prop("checked",true).change();
            } else {
                $(this).find('.' + classnya).prop("checked",false).change();
            }
        });
    }
    
    function inputKantong(){
//        var no_penggunaan_coolbox = is_checked;
//        
//	if (isEmpty(no_penggunaan_coolbox)){
//            myAlert('no penggunaan coolbox yang akan dikirimkan belum dipilih');
//            return false;
//	}else{
//            $('#table-detailbarang').addClass("animation-loading");
//            cekList(no_penggunaan_coolbox);                
//	}        
        
        var nomorbarcode_utama = is_checked;
        
	if (isEmpty(nomorbarcode_utama)){
            myAlert('no kantong darah utama yang akan dikirimkan belum dipilih');
            return false;
	}else{
            $('#table-detailbarang').addClass("animation-loading");
            cekList(nomorbarcode_utama);                
	}  
    }
    
    function cekList(id){
	x = true;
	/*$('.nomorbarcode_utama').each(function(){
            if ($(this).val() == id){
                myAlert('Kantong  telah ada d List');
                x = false;
                $('#table-detailbarang').removeClass("animation-loading");                
            }else{

            }
	});*/

	if(x==true){
            tambahKantong(is_checked);
            $("#dialogKantongDarah").dialog("close");
            return x;
        }
        return false;
    }   
    function renameInputRowBarang(obj_table){
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
        $(this).find('.detail-komponen').each(function(){ //element <input>
            $(this).find('input,select,textarea').each(function(){
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 5){
                    $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]+"_"+a+"_"+old_name_arr[4]);
                    $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]["+a+"]["+old_name_arr[4]+"]");
                }                         
            });            
            a++;
        });
        row++;        
    });
    }
    
    function batal(obj){
        var id = $(obj).attr('id-data');
    
        myConfirm("Apakah Anda yakin ingin membatalkan kantong darah utama ini ?","Perhatian !", function(r){
            if (r){
                $(obj).parents('tbody').find('tr[id-data="'+id+'"]').detach();                                
                renameInputRowBarang($("#table-detailbarang"));
            }else{
                return false;
            }
        });    
    }
</script>

