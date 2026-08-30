<?php
$cri = new CDbCriteria();
$cri->addCondition(" pegawai_aktif = TRUE ");
$cri->addCondition(" unitkerja_id IN (SELECT lookup_value::int FROM lookup_m where lookup_type = 'teknisicm') ");
$cri->order = " nama_pegawai ASC ";
$look = CHtml::listData(PegawaiV::model()->findAll($cri),'pegawai_id','namaLengkap');
if (!empty($modDet)){
    foreach($modDet as $i => $det){
        $this->renderPartial($this->path_view.'setTeknisi/_row',['model'=>$det,'i'=>0,'look'=>$look]);
    }
}else{
    $this->renderPartial($this->path_view.'setTeknisi/_row',['model'=>$model,'i'=>0,'look'=>$look]);
}

?>


<script>
    
    var cekTeknisi = () => {
                       
        if (requiredCheck($("#form-set-teknisi"))){
            $(".form-set-teknisi-btn").addClass('animation-loading');
            $(".form-set-teknisi-btn").find('button,a').hide();
            $.ajax({
                type:'POST',
                url:'<?= $this->createUrl('setTeknisi') ?>',
                data: {
                    formdata:$("#form-set-teknisi").find('input,select').serialize(),
                    id:'<?= $model->korektifmainten_id ?>',
                    setdata:$("#form-set-teknisi-hapus").find('input,select').serialize()
                },
                dataType: "json",
                success:function(data){
                    if (data.sukses == 1){
                        toastr.success(data.pesan,'Perhatian!');
                        $("#dialogSetTeknisi").dialog("close");
                        $("#form-set-teknisi-hapus").remove();
                    }else{
                        $(".form-set-teknisi-btn").removeClass('animation-loading');
                        $(".form-set-teknisi-btn").find('button,a').show();

                        toastr.error(data.pesan,'Perhatian!');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) { 
                    console.log(errorThrown);
                    $(".form-set-teknisi-btn").removeClass('animation-loading');
                    $(".form-set-teknisi-btn").find('button,a').show();
                }
            }); 
        }
        return false;
    }
    
    var setNamaTeknisi = (obj) => {        
        var nama_teknisi = $(obj).select2('data');            
        $(obj).parents(".baris").find('.nama_teknisi').val(nama_teknisi.text);  
    }
    
    var set_action = (obj,jenis) => {
        var id_attr = $(obj).parents(".form-utama").attr('id');
        var set_obj = $("#"+id_attr);             

        if (jenis == 'tambah'){                    

            tambah_data_baris($(obj));                                 
                        
            $("#"+id_attr+" > .baris:last").find('.select2-container').remove();
            $("#"+id_attr+" > .baris:last").find('.pegawai_id').removeClass('select2-offscreen');
            $("#"+id_attr+" > .baris:last").find('.pegawai_id').removeAttr('tabindex');           
                        
            $("#"+id_attr+" > .baris:last").find('input,select').val("");            
            
            renameInputRow(set_obj);
            
            $("#"+id_attr+" > .baris:last").find('.pegawai_id').select2({
                allowClear:true,                    
                placeholder:'-- Pilih --',  
                width:'200px'
            });
            
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
    
    
    $(".form-set-teknisi-btn").removeClass('animation-loading');
    $(".form-set-teknisi-btn").find('button,a').show();
    renameInputRow($("#form-set-teknisi"));
    
    
    
    <?php if ($modKor->korektifmainten_status == ParamsConst::STATUSDOKUMENFINISH || $modKor->korektifmainten_status == 'Closed' || $modKor->korektifmainten_status == ParamsConst::STATUSDOKUMENCLOSE){ ?>
        $("#dialogSetTeknisi").find('input,select').attr("disabled",true);
        $("#dialogSetTeknisi").find('button,a').hide();
    <?php }else{ ?>
        $('.pegawai_id').select2({
            allowClear:true,
            width:'200px',
            placeholder:'-- Pilih --'
        }); 
    <?php } ?>
    
    
</script>