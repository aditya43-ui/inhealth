<script type='text/javascript'>
    /**
 * set form kunjungan
 * @param {type} pasienanastesi_id, pendaftaran_id, pasienmasukpenunjang_id
 * @returns {undefined}
 */
function setKunjungan(pasienanastesi_id,pendaftaran_id,pasienmasukpenunjang_id){
    $("#form-datakunjungan > .panel-body").addClass("animation-loading");
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('GetDataKunjungan'); ?>',
            data: {pasienanastesi_id:pasienanastesi_id,pendaftaran_id:pendaftaran_id,pasienmasukpenunjang_id:pasienmasukpenunjang_id},
            dataType: "json",
            success:function(data){
                if(data.pesan != ""){
                    myAlert(data.pesan);
                    setKunjunganReset();
                }else{
                    $("#<?php echo CHtml::activeId($model,'pasienanastesi_id'); ?>").val(data.pasienanastesi_id);                    
                    $("#<?php echo CHtml::activeId($model,'pendaftaran_id'); ?>").val(data.pendaftaran_id);
                    $("#<?php echo CHtml::activeId($model,'pasien_id'); ?>").val(data.pasien_id);
                    $("#<?php echo CHtml::activeId($modKunjungan,'pasienmasukpenunjang_id'); ?>").val(data.pasienmasukpenunjang_id);
                    $("#<?php echo CHtml::activeId($modKunjungan,'noanestesi'); ?>").val(data.noanestesi);
                    $("#<?php echo CHtml::activeId($modKunjungan,'tglanastesi'); ?>").val(data.tglanastesi);
                    $("#<?php echo CHtml::activeId($modKunjungan,'umur'); ?>").val(data.umur);
                    $("#<?php echo CHtml::activeId($modKunjungan,'jeniskasuspenyakit_id'); ?>").val(data.jeniskasuspenyakit_id);
                    $("#<?php echo CHtml::activeId($modKunjungan,'jeniskasuspenyakit_nama'); ?>").val(data.jeniskasuspenyakit_nama);
                    $("#<?php echo CHtml::activeId($modKunjungan,'pegawai_id'); ?>").val(data.nama_pegawai);
                    $("#<?php echo CHtml::activeId($modKunjungan,'no_rekam_medik'); ?>").val(data.no_rekam_medik);
                    $("#<?php echo CHtml::activeId($modKunjungan,'nama_pasien'); ?>").val(data.nama_pasien);
                    $("#<?php echo CHtml::activeId($modKunjungan,'jeniskelamin'); ?>").val(data.jeniskelamin);
                    $("#<?php echo CHtml::activeId($modKunjungan,'pekerjaan_id'); ?>").val(data.pekerjaan_id);
                    $("#<?php echo CHtml::activeId($modKunjungan,'pekerjaan_nama'); ?>").val(data.pekerjaan_nama);
                    $("#<?php echo CHtml::activeId($modKunjungan,'kelaspelayanan_id'); ?>").val(data.kelaspelayanan_id);
                    $("#<?php echo CHtml::activeId($modKunjungan,'kelaspelayanan_nama'); ?>").val(data.kelaspelayanan_nama);
                    $("#<?php echo CHtml::activeId($modKunjungan,'alamat_pasien'); ?>").val(data.alamat_pasien);

                    if(data.photopasien === null || data.photopasien === "" || data.photopasien === undefined){ //set photo
                        $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
                    }else{
                        $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_"?>'+data.photopasien);
                    }
                    
                    if(data.noanestesi == '' || data.noanestesi == null){
                            var noanestesi = data.no_masukpenunjang;
                    }else{
                            var noanestesi = data.noanestesi;
                    }

                    $("#form-datakunjungan > .panel-heading").find('.judul').html('Data Pasien '+noanestesi);
                    $("#form-datakunjungan > .panel-heading").find('.tombol').attr('style','display:true;');                    
                }
                $("#form-datakunjungan > .panel-body").removeClass("animation-loading");
                $("#<?php echo CHtml::activeId($modKunjungan,'noanestesi'); ?>").focus();
            },
            error: function (jqXHR, textStatus, errorThrown) { 
                myAlert("Data kunjungan tidak ditemukan !"); 
                console.log(errorThrown);
                setKunjunganReset();
                $("#form-datakunjungan > div").removeClass("animation-loading");
                $("#<?php echo CHtml::activeId($modKunjungan,'noanestesi'); ?>").focus();
            }
        });

    }
    
    /**
     * untuk mereset form kunjungan
     * @returns {undefined} */
    function setKunjunganReset(){
        $("#form-datakunjungan input,textarea").each(function(){
            $(this).val("");
        });
        $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
        $("#form-datakunjungan > .panel-heading").find('.judul').html('Data Pasien');
        $("#form-datakunjungan > .panel-heading").find('.tombol').attr('style','display:none;');
        
    }

    function hitungMAP(){
        var sistolik = $("#<?php echo CHtml::activeId($model, 'tekanandarah_sistolik') ?>").val();
        var diastolik =  $("#<?php echo CHtml::activeId($model, 'tekanandarah_diastolik') ?>").val();
        
        var map = '';
        
        if (sistolik != 0 && diastolik != 0 && sistolik != '' && diastolik != ''){
            map = Math.round((parseInt(sistolik) + (2 * parseInt(diastolik))) / 3);
        }
               
        $("#<?php echo CHtml::activeId($model, 'mean_arterial_press') ?>").val(map);
    }    
    
    function cekPagerWizard(obj){
        
        var tipe = $(obj).parents('li').attr('class');
        
        if (tipe == 'next'){
            var cek =  $("#wizard-progress > li.active").next().find('a').attr('no-urut');
        }else{
            var cek =  $("#wizard-progress > li.active").prev().find('a').attr('no-urut');
        }
            
        if (cek >= 10){
            $(".menit-ke").hide();
        }else{
            $(".menit-ke").show();
        }            
    }
    
    function tambahBaris(obj, jenis, tipe){
        var row = $(obj).parents(".control-group").html();        
            
        
        if (tipe != 'kantongdarah'){
            $("#"+jenis).append('<div class="control-group lookup">'+row+'</div>');    
            
            $("#"+jenis).find('.control-group:last > label').html('');
            $("#"+jenis).find('.control-group:last > .controls > .nama_input').val('');                        
        }else{
            $("#"+jenis).append('<div class="control-group komponendarah">'+row+'</div>');  
            $("#"+jenis).find('.control-group:last > label').html('');
            
        }
                        
        
        renameInputRow($("#form-input-anestesi"));
    }
    
    function hapusBaris(obj){
        myConfirm("Apakah Anda yakin akan menghapus data ini ? ","Perhatian",function(r){
            if (r){
                $(obj).parents(".control-group").remove();        
                renameInputRow($("#form-input-anestesi"));
            }
        });
        
    }
    
    function renameInputRow(obj){
        var parent = 0;  
        var row = 0;
        
        $(obj).find('.parent').each(function(){     
            var kom = $(this);
            $(this).find('.lookup').each(function(){
                $(this).find('input,select,textarea').each(function(){ //element <input>
                    var old_name = $(this).attr("name").replace(/]/g,"");
                    var old_name_arr = old_name.split("[");
                    if(old_name_arr.length == 4){
                        $(this).attr("id",old_name_arr[0]+"_"+old_name_arr[1]+"_"+parent+"_"+old_name_arr[3]);
                        $(this).attr("name",old_name_arr[0]+"["+old_name_arr[1]+"]["+parent+"]["+old_name_arr[3]+"]");                                                
                    }
                });      
                
                var cek = $(this).find('.controls').html();                
                if (cek.trim() != ''){                    
                    parent++;
                }else{                      
                    kom.find('.komponendarah').each(function(){                                                
                        $(this).find('input,select,textarea').each(function(){ //element <input>                            
                            var old_name = $(this).attr("name").replace(/]/g,"");
                            var old_name_arr = old_name.split("[");                            
                            if(old_name_arr.length == 6){                                
                                $(this).attr("id",old_name_arr[0]+"_"+old_name_arr[1]+"_"+parent+"_"+old_name_arr[3]+"_"+row+"_"+old_name_arr[5]);
                                $(this).attr("name",old_name_arr[0]+"["+old_name_arr[1]+"]["+parent+"]["+old_name_arr[3]+"]["+row+"]["+old_name_arr[5]+"]");
                            }                                                        
                        });  
                        row++;
                    });     
                }
            });                         
        });  
                        
        
        $(obj).find('.parent').each(function(){
            var row = 0;
            $(this).find('.control-group').each(function(){
                if (row == 0){
                    $(this).find('.buttontambah').removeClass('hide');
                    $(this).find('.buttonhapus').addClass('hide');
                }else if(row >= 1){
                    $(this).find('.buttontambah').addClass('hide');
                    $(this).find('.buttonhapus').removeClass('hide');
                }                
                row++;
            });
            
            
        });                
    }
    
    
    //JS untuk tambah_form
    function tambahBaris2(obj, jenis, tipe){
        var row = $(obj).parents(".control-group").html();        
            
//        alert(obj+","+jenis+","+tipe);
        if (tipe != 'kantongdarah'){
            $("#"+jenis).append('<div class="control-group lookup">'+row+'</div>');    
            
            $("#"+jenis).find('.control-group:last > label').html('');
            $("#"+jenis).find('.control-group:last > .controls > .nama_input').val('');                        
        }else{
            $("#"+jenis).append('<div class="control-group komponendarah">'+row+'</div>');                            
            
        }
                        
        
        renameInputRow2($("#form-input-anestesi"));
    }
    
    function hapusBaris2(obj){
        myConfirm("Apakah Anda yakin akan menghapus data ini ? ","Perhatian",function(r){
            if (r){
                $(obj).parents(".control-group").remove();        
                renameInputRow2($("#form-input-anestesi"));
            }
        });
        
    }
    
    function renameInputRow2(obj){
        var parent = 0;  
        var row = 0;
        
        $(obj).find('.parent').each(function(){     
            var kom = $(this);
            $(this).find('.lookup').each(function(){
                $(this).find('input,select,textarea').each(function(){ //element <input>
                    var old_name = $(this).attr("name").replace(/]/g,"");
                    var old_name_arr = old_name.split("[");
                    if(old_name_arr.length == 4){
                        $(this).attr("id",old_name_arr[0]+"_"+old_name_arr[1]+"_"+parent+"_"+old_name_arr[3]);
                        $(this).attr("name",old_name_arr[0]+"["+old_name_arr[1]+"]["+parent+"]["+old_name_arr[3]+"]");                                                
                    }
                });      
                
                var cek = $(this).find('.controls').html();                
                if (cek.trim() != ''){                    
                    parent++;
                }else{                      
                    kom.find('.komponendarah').each(function(){                                                
                        $(this).find('input,select,textarea').each(function(){ //element <input>
                            var old_name = $(this).attr("name").replace(/]/g,"");
                            var old_name_arr = old_name.split("[");
                            if(old_name_arr.length == 4){
                                $(this).attr("id",old_name_arr[0]+"_"+old_name_arr[1]+"_"+parent+"_"+old_name_arr[3]);
                                $(this).attr("name",old_name_arr[0]+"["+old_name_arr[1]+"]["+parent+"]["+old_name_arr[3]+"]");                                                
                            }
                        });   
                        row++;
                    });     
                }
            });                         
        });  
                        
        
        $(obj).find('.parent').each(function(){
            var row = 0;
            $(this).find('.control-group').each(function(){
                if (row == 0){
                    $(this).find('.buttontambah').removeClass('hide');
                    $(this).find('.buttonhapus').addClass('hide');
                }else if(row >= 1){
                    $(this).find('.buttontambah').addClass('hide');
                    $(this).find('.buttonhapus').removeClass('hide');
                }                
                row++;
            });
            
            
        });                
    }
    
    function cekForm(){
        if (requiredCheck($("#rootwizard"))){
            $('#rootwizard').submit();
        }

       return false;
    }
    
    $(document).ready(function(){
        <?php if (isset($_GET['sukses'])){ ?>
                $("#rootwizard").find('input,select,textarea').each(function(){
                    $(this).attr('disabled',true);
                });
                
                $(".add-on").hide();
                $(".buttontambah").hide();
                $(".buttonhapus").hide();
                $(".rowbutton").attr("style","display:none;");
        <?php } ?>
            
        $("#wizard-progress > li > a").click(function(){           
            if ($(this).attr('href') == '#tab10' || $(this).attr('href') == '#tab11'){
                $(".menit-ke").hide();
            }else{
                $(".menit-ke").show();
            }
        });    
        
        $(".pager-wizard > li > a").on('click',function() {
            cekPagerWizard(this);            
        });
    });
</script>
