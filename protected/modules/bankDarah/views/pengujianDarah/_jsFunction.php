<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - digunakan sebagai menampung semua js yang ada pada form asesmen awal kebidanan, untuk masing - masing tabulasi emenggunakan file _jsFunctions masing - masing
* RSST-1515
*/
?>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$baseUrl = Yii::app()->createUrl("/");
?>
<script>  
     function setPetugas(nama, id){             
        $("#<?php echo CHtml::activeId($model, 'petugaspengujian_id') ?>").val(id);
        $("#<?php echo CHtml::activeId($model, 'petugaspengujian_nama') ?>").val(nama);        
        $("#dialogPetugas").dialog('close');        
        
        $("#<?php echo CHtml::activeId($model, 'petugaspengujian_nama') ?>").blur();
    }       
    
    function cekHasil(obj){
        var hasil_goldarah = $(obj).parents("#pilih-pengujiankonfirmasi").find(".golDarah").val();
        var hasil_rhesus = $(obj).parents("#pilih-pengujiankonfirmasi").find(".rhesus").val();        
        var temphasil_goldarah = $(obj).parents("#pilih-pengujiankonfirmasi").find("#hasilUjiGol").val();
        var temphasil_rhesus = $(obj).parents("#pilih-pengujiankonfirmasi").find("#hasilUjiRhesus").val();        
        var jumlah_pengujian = $("#BDPengujiandarahT_pengujian_ke").val();
        
        
        if (hasil_rhesus == '<?php echo Params::RHESUS_POSITIF ?>'){
             hasil_rhesus = '<?php echo Params::PENGUJIAN_GOLDARAH_POSITIF; ?>';
        }else if(hasil_rhesus == '<?php echo Params::RHESUS_NEGATIF ?>'){
            hasil_rhesus = '<?php echo Params::PENGUJIAN_GOLDARAH_NEGATIF; ?>';
        }else{
            hasil_rhesus = '';
        }
        
        temphasil_rhesus = temphasil_rhesus.toUpperCase();
                
        
        var kantong_goldarah = $("#<?php echo CHtml::activeId($modTerima, 'gol_darah') ?>").val();
        var kantong_rhesus = $("#<?php echo CHtml::activeId($modTerima, 'rhesus') ?>").val();
        
        //Kantong dan rhesus pengujian pertama
        var kantong_goldarah1 = $("#<?php echo CHtml::activeId($model, 'goldar1') ?>").val();
        var kantong_rhesus1 = $("#<?php echo CHtml::activeId($model, 'rhesus1') ?>").val();
                   
        kantong_rhesus = kantong_rhesus.toUpperCase();
        kantong_rhesus1 = kantong_rhesus1.toUpperCase();
                        
        var keterangan = '';                                
        var pesan = '';
        
        //if ($(obj).parents("#pengujianke-").find("#jumlah-pengujian").html() == 1){
        if(jumlah_pengujian == 1){
            
            if (hasil_goldarah == kantong_goldarah && hasil_rhesus == kantong_rhesus){
                $(obj).parents("#pilih-pengujiankonfirmasi").find(".dataTidakCocok").prop("checked",false);
                $(obj).parents("#pilih-pengujiankonfirmasi").find(".dataCocok").prop("checked",true);
                keterangan = 'Hasil pengujian konfirmasi golongan darah '+hasil_goldarah+' dengan rhesus '+hasil_rhesus+' cocok dengan golongan darah pada kantong darah';
                
                var count = 0;
                $("#pengujianke- > #pilih-pengujiankonfirmasi").each(function(){                    
                    if ( $(this).attr('id-data') == 2) {
                        
                        count = $(this).find('input:radio:checked').length;
                        
                        $(this).find('select').each(function(){
                            if ($(this).val() != ''){
                                count++;
                            }
                        });
                    }                                                                                        
                });
                
                if (count > 0){
                    myConfirm("Pengujian Konfirmasi Golongan Darah Ke - 2 sudah terisi, apakah anda yakin ingin membatalkannya ?", "Perhatian",function(r){
                        if (r){
                            $("#banyakpengujian").html('');
                                                        
                            var data = {ket:keterangan, pesan:pesan, goldarah:hasil_goldarah, rhesus:hasil_rhesus};

                            setData(obj,data);
                        }else{
                            hasil_goldarah = temphasil_goldarah;
                            hasil_rhesus = temphasil_rhesus;                            
                            
                           var data = {ket:keterangan, pesan:pesan, goldarah:hasil_goldarah, rhesus:hasil_rhesus};

                            setData(obj,data);
                        }
                    });
                }else{                    
                    $("#banyakpengujian").html('');                    
                    var data = {ket:keterangan, pesan:pesan, goldarah:hasil_goldarah, rhesus:hasil_rhesus};
                    
                    setData(obj,data);
                }
                
                
            }else{
                if (hasil_goldarah != '' && hasil_rhesus != ''){                
                    $(obj).parents("#pilih-pengujiankonfirmasi").find(".dataCocok").prop("checked",false);
                    $(obj).parents("#pilih-pengujiankonfirmasi").find(".dataTidakCocok").prop("checked",true);
                
                    keterangan = 'Hasil pengujian konfirmasi golongan darah '+hasil_goldarah+' dengan rhesus '+hasil_rhesus+' tidak cocok dengan golongan darah pada kantong darah';

                    var pengujian_ke = <?php echo CJSON::encode($this->renderPartial($this->path_view.'form._formPengujian',array('model'=>$model,'form'=>$form),true));?>;

                    var count = 0;
                    $("#pengujianke- > #pilih-pengujiankonfirmasi").each(function(){                    
                        if ( $(this).attr('id-data') == 2) {

                            count = $(this).find('input:radio:checked').length;

                            $(this).find('select').each(function(){
                                if ($(this).val() != ''){
                                    count++;
                                }
                            });
                        }                                                                                        
                    });

                    if (count > 0){
                        myConfirm("Pengujian Konfirmasi Golongan Darah Ke - 2 sudah terisi, apakah anda yakin ingin membatalkannya ?", "Perhatian",function(r){
                            if (r){                                
                                $("#banyakpengujian").html(pengujian_ke);
                                
                                var data = {ket:keterangan, pesan:pesan, goldarah:hasil_goldarah, rhesus:hasil_rhesus};

                                setData(obj,data);
                                
                                //renamePengujian($("#pengujianke- > #pilih-pengujiankonfirmasi")); 
                            }else{
                                hasil_goldarah = temphasil_goldarah;
                                hasil_rhesus = temphasil_rhesus;                                
                                var data = {ket:keterangan, pesan:pesan, goldarah:hasil_goldarah, rhesus:hasil_rhesus};

                                setData(obj,data);
                            }
                        });
                    }else{
                        //$("#banyakpengujian").html(pengujian_ke);
                        
                        var data = {ket:keterangan, pesan:pesan, goldarah:hasil_goldarah, rhesus:hasil_rhesus};

                        setData(obj,data);
                    }
                    

                    //renamePengujian($("#pengujianke- > #pilih-pengujiankonfirmasi"));                                                                
                }else{
                    $(obj).parents("#pilih-pengujiankonfirmasi").find(".dataTidakCocok").prop("checked",false);
                    $(obj).parents("#pilih-pengujiankonfirmasi").find(".dataCocok").prop("checked",false);

                    $("#banyakpengujian").html('');
                    
                    var data = {ket:keterangan, pesan:pesan, goldarah:hasil_goldarah, rhesus:hasil_rhesus};

                    setData(obj,data);
                }                        
            }
        }else{
            if (hasil_goldarah == kantong_goldarah1 && hasil_rhesus == kantong_rhesus1){
                $(obj).parents("#pilih-pengujiankonfirmasi").find(".dataTidakCocok").prop("checked",false);
                $(obj).parents("#pilih-pengujiankonfirmasi").find(".dataCocok").prop("checked",true);
                keterangan = 'Hasil pengujian konfirmasi golongan darah '+hasil_goldarah+' dengan rhesus '+hasil_rhesus+' cocok dengan golongan darah pada kantong darah';
                       
                if (hasil_goldarah != golDarahKe1 && hasil_rhesus != golRhesus1){
                    pesan = '<span class="required">Hasil pengujian golongan darah dan rhesus ke - 2 sama dengan pengujian ke - 1</span>';
                }else{
                    pesan = '';
                }

               var data = {ket:keterangan, pesan:pesan, goldarah:hasil_goldarah, rhesus:hasil_rhesus};

                setData(obj,data);
            }else{
                if (hasil_goldarah != '' && hasil_rhesus != ''){                
                    $(obj).parents("#pilih-pengujiankonfirmasi").find(".dataCocok").prop("checked",false);
                    $(obj).parents("#pilih-pengujiankonfirmasi").find(".dataTidakCocok").prop("checked",true);
                    keterangan = 'Hasil pengujian konfirmasi golongan darah '+hasil_goldarah+' dengan rhesus '+hasil_rhesus+' tidak cocok dengan golongan darah pada kantong darah';
                    
                    var golDarahKe1 = '';
                    var golRhesus1 = '';                    
                    $("#pengujianke-").find("#pilih-pengujiankonfirmasi").each(function(){
                        if ( $(this).attr('id-data') == 1) {
                            golDarahKe1 = $(this).find('.golDarah').val();
                            golRhesus1 = $(this).find('.rhesus').val();
                            
                            if (golRhesus1 == '<?php echo Params::RHESUS_POSITIF ?>'){
                                golRhesus1 = '<?php echo Params::PENGUJIAN_GOLDARAH_POSITIF; ?>';
                            }else if(golRhesus1 == '<?php echo Params::RHESUS_NEGATIF ?>'){
                                golRhesus1 = '<?php echo Params::PENGUJIAN_GOLDARAH_NEGATIF; ?>';
                            }else{
                                golRhesus1 = '';
                            }
                        }                                                
                    });                    
                  
                    if (hasil_goldarah == golDarahKe1 && hasil_rhesus == golRhesus1){
                        pesan = '<span class="required">Hasil pengujian golongan darah dan rhesus ke - 2 tidak sama dengan pengujian ke - 1</span>';
                    }else{
                        pesan = '';
                    }
                    
                   var data = {ket:keterangan, pesan:pesan, goldarah:hasil_goldarah, rhesus:hasil_rhesus};

                    setData(obj,data);
                }else{
                    $(obj).parents("#pilih-pengujiankonfirmasi").find(".dataTidakCocok").prop("checked",false);
                    $(obj).parents("#pilih-pengujiankonfirmasi").find(".dataCocok").prop("checked",false);   
                    
                    var data = {ket:keterangan, pesan:pesan, goldarah:hasil_goldarah, rhesus:hasil_rhesus};

                    setData(obj,data);
                }                        
            }
        }     
                                        
        $("#<?php echo CHtml::activeId($model, 'petugaspengujian_nama') ?>").blur();                                
    }
    
    function setData(obj,arr){                        
        
        $(obj).parents("#pilih-pengujiankonfirmasi").find(".ket").val(arr.ket);
               
        $(obj).parents("#pilih-pengujiankonfirmasi").find("#pesan-ket").html(arr.pesan);
        
        if (arr.pesan == ''){
            $("#<?php echo CHtml::activeId($modTerima, 'berubahdata') ?>").val('tidak');                                
        }else{
            $("#<?php echo CHtml::activeId($modTerima, 'berubahdata') ?>").val('ya');                                
        }
                                
        $(obj).parents("#pilih-pengujiankonfirmasi").find("#hasilUjiGol").val(arr.goldarah);
        $(obj).parents("#pilih-pengujiankonfirmasi").find("#hasilUjiRhesus").val(arr.rhesus);
        
        if (arr.rhesus.toLowerCase() == '<?php echo strtolower(Params::PENGUJIAN_GOLDARAH_POSITIF); ?>'){
             arr.rhesus = '<?php echo Params::RHESUS_POSITIF; ?>';
        }else if(arr.rhesus.toLowerCase() == '<?php echo strtolower(Params::PENGUJIAN_GOLDARAH_NEGATIF); ?>'){
             arr.rhesus = '<?php echo Params::RHESUS_NEGATIF; ?>';
        }else{
            arr.rhesus = '';
        }
        
        $(obj).parents("#pilih-pengujiankonfirmasi").find(".golDarah").val(arr.goldarah);
        $(obj).parents("#pilih-pengujiankonfirmasi").find(".rhesus").val(arr.rhesus);
    }
    
    /**
    * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
    * @version     2.0.0
    * @digunakan   untuk mengenerate form yang sama, dengan perbedaan atribute id nomornya (agar data dianggap berbeda dan bisa submit menjadi lebih dari 1 data)
    * RSST-1515
    */
    function renamePengujian(obj){
        var row = 0;        
        
        $(obj).each(function(){       
            $(this).parents("#pengujianke-").find("#jumlah-pengujian").html(row+1);    
            $(this).attr("id-data",row+1);
            $(this).find('input,select,textarea').each(function(){ 
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");                
                if(old_name_arr.length == 4){                    
                    $(this).attr("id",old_name_arr[0]+"_"+old_name_arr[1]+"_"+row+"_"+old_name_arr[3]);
                    $(this).attr("name",old_name_arr[0]+"["+old_name_arr[1]+"]["+row+"]["+old_name_arr[3]+']');
                }
            });          
            row++;
        });      
    }
    
    function hasilKesimpulan(obj){
        var anti_a = $(obj).parents(".pilih-pengujiankonfirmasi").find(".anti-a").find("input:radio:checked").attr('value');        
        var anti_b = $(obj).parents(".pilih-pengujiankonfirmasi").find(".anti-b").find("input:radio:checked").attr('value');
        var anti_ab = $(obj).parents(".pilih-pengujiankonfirmasi").find(".anti-ab").find("input:radio:checked").attr('value');
        var anti_d = $(obj).parents(".pilih-pengujiankonfirmasi").find(".anti-d").find("input:radio:checked").attr('value');
        
        var sel_a = $(obj).parents(".pilih-pengujiankonfirmasi").find(".sel-a").find("input:radio:checked").attr('value');
        var sel_b = $(obj).parents(".pilih-pengujiankonfirmasi").find(".sel-b").find("input:radio:checked").attr('value');
        var sel_o = $(obj).parents(".pilih-pengujiankonfirmasi").find(".sel-o").find("input:radio:checked").attr('value');
        
        if (anti_a != '' && anti_b != '' && anti_d != '' && anti_ab != '' && sel_a != '' && sel_b != '' && sel_o != ''){
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('konfirmasiHasilUji'); ?>',
                data: {anti_a:anti_a,anti_b:anti_b,anti_d:anti_d,anti_ab:anti_ab,sel_a:sel_a,sel_b:sel_b,sel_o:sel_o},
                dataType: "json",
                success:function(data){
                    if (data.sukses == 1){
                        $(obj).parents(".pilih-pengujiankonfirmasi").find(".golDarah").val(data.gol_darah);
                        $(obj).parents(".pilih-pengujiankonfirmasi").find(".rhesus").val(data.rhesus);
                        
                        
                        setTimeout(cekHasil($(obj).parents(".pilih-pengujiankonfirmasi").find(".golDarah")),1000);                        
                    }else{
                        myAlert(data.pesan);
                    }                    
                                        
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            }); 
        }                
    }
       
       
    $(document).ready(function(){
         setValidasiCekDisabled($("#pengujiankantongdarah-form"), function() {      
                var count = $("#pemeriksaankonfirmasi").find('input:radio.pilihData:checked').length;                
                var totCount = parseInt($("#pemeriksaankonfirmasi").find('input:radio.pilihData').length)-(7*parseInt($(".pengujianke-").length));                
                            
                if (totCount != count){
                    return false;
                }                    
                                
                return true;
         });                                                                           
                
    });
</script>