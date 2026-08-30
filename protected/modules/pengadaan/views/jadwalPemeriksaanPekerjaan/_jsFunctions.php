<?php
/** 
 * view ini digunakan untuk menampung fungsi - fungsi javascript
 * 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */

?>
<script type='text/javascript'>
    
    function setJadwal(data){
        var suratperjanjiankerja_id = data.suratperjanjiankerja_id;
        
        var def = '';
        if (suratperjanjiankerja_id == ''){
            var def = 'ada';
        }
        
        $("#<?php echo CHtml::activeId($model, 'suratperjanjiankerja_id') ?>").val(data.suratperjanjiankerja_id);
        $("#<?php echo CHtml::activeId($model, 'nosuratperjanjiankerja') ?>").val(data.nosuratperjanjiankerja);
        $("#<?php echo CHtml::activeId($model, 'nama_pekerjaan') ?>").val(data.namapekerjaan);
        $("#<?php echo CHtml::activeId($model, 'supplier_id') ?>").val(data.supplier_id);
        
        
        $.fn.yiiGridView.update('riwayat-intensivis-grid', {
            data: {
                "ADPengadaanjadwalpemeriksaanT[suratperjanjiankerja_id]":suratperjanjiankerja_id,                
                "ADPengadaanjadwalpemeriksaanT[default]":def,                
            }
        });  
        
    }
    
     function tambahBaris(){
        var row = '<?php echo CJSON::encode($this->renderPartial($this->path_view.'form/_rowPemeriksa',array('model'=>$det, 'i'=>1,),true));?>';               
        
        $(".form-pegpemeriksa").append(row);
                
        renameInput($(".form-pegpemeriksa"),'tbody > tr');
        genExt();
    }
    
    function hapusBaris(obj){
        myConfirm("Apakah Anda yakin, ingin menghapus data ini ?","Perhatian !",function(r){
            if (r){
                $(obj).parents("tr").remove();
                renameInput($(".form-pegpemeriksa"),'tbody > tr');
            }
        });
    }
    
    function setRow(obj){
        var no = $(obj).parents("tr").attr('row-data');
        
        $("#norow").val(no);
    }
    
    function renameInput(obj_table,find_attr){
        var row = 0;
        var count = $(obj_table).find(find_attr).length;
        
        $(obj_table).find(find_attr).each(function(){
            $(this).find('.no_urut').html(row+1);
            $(this).attr('row-data',row);                        
            
            $(this).find('input,select,textarea').each(function(){ //element <input>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 3){
                    $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                    $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
                }
                
                if(old_name_arr.length == 4){
                    $(this).attr("id",old_name_arr[0]+"_"+old_name_arr[1]+"_"+row+"_"+old_name_arr[3]);
                    $(this).attr("name",old_name_arr[0]+"["+old_name_arr[1]+"]["+row+"]["+old_name_arr[3]+"]");
                }
            });
            
            if (count == 1){
                $(this).find('.btntambah').removeClass('hide');
                $(this).find('.btnhapus').addClass('hide');
            }else{       
                if (count == (row+1)){
                    $(this).find('.btntambah').removeClass('hide');
                    $(this).find('.btnhapus').removeClass('hide');
                }else{
                    $(this).find('.btnhapus').removeClass('hide');
                    $(this).find('.btntambah').addClass('hide');                        
                }
            }
            
            row++;
        });

       
        
        jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip();
    }
    
    function genExt(){
        $('.pegpemeriksa_nama').autocomplete({
            'showAnim':'fold',
            'minLength':3,
            'focus':function(event, ui )
            {
                $(this).val( ui.item.label);
                return false;
            },
            'select':function( event, ui )
            {
                setPegPemeriksa(ui.item,this);
                return false;
            },
            'source':function(request, response)
            {
                $.ajax({
                    url: "<?php echo $this->createUrl('/actionAutoComplete/GetPejabatPengadaan');?>",
                    dataType: "json",
                    data:{
                        term: request.term,                                                     
                        jabatan_pengadaan:'<?php echo Params::JABATAN_PENGADAAN_TIM_TEKNIS; ?>'
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            }
        });
    }
    
    function clearPegPemeriksa(obj){
        $(obj).parents("tr").find('.pegpemeriksa_id').val('');
        $(obj).parents("tr").find('.pegpemeriksa_nama').val('');
    }
    
    function clearSPK(obj){
        var data = <?php echo json_encode(array('supplier_id'=>'','suratperjanjiankerja_id'=>'','nosuratperjanjiankerja'=>'','namapekerjaan'=>'')); ?>
        
        setJadwal(data);
    }
    
    function setPegPemeriksa(data,obj){        
        if (typeof $(obj).parents("tr").attr("row-data") === 'undefined'){
            var no = $("#norow").val();
        }else{
            var no = $(obj).parents("tr").attr("row-data");
        }
        
        var cek = 0;
        
        $(".form-pegpemeriksa > tbody > tr").each(function(){
            if ($(this).find('.pegpemeriksa_id').val() == data.pegawai_id){
                cek++;
            }
        });
        
        if (cek > 0){
            toastr.error("Maaf, Pegawai ini sudah dipilih","Perhatian!");
            $('.form-pegpemeriksa > tbody > tr[row-data="'+no+'"]').find('.pegpemeriksa_id').val('');
            $('.form-pegpemeriksa > tbody > tr[row-data="'+no+'"]').find('.pegpemeriksa_nama').val('');
            return false;
        }
        
        $('.form-pegpemeriksa > tbody > tr[row-data="'+no+'"]').find('.pegpemeriksa_id').val(data.pegawai_id);
        $('.form-pegpemeriksa > tbody > tr[row-data="'+no+'"]').find('.pegpemeriksa_nama').val(data.namaLengkap);
        
        
        $("#<?php echo CHtml::activeId($model, 'nosuratperjanjiankerja') ?>").blur();
    }
    
    function cekForm(){
        if (requiredCheck($("#jadwalpemeriksaanpekerjaan-t-form"))){            
            $("#jadwalpemeriksaanpekerjaan-t-form").submit();
            disableOnSubmit($("#jadwalpemeriksaanpekerjaan-t-form"));
        }
        return false;
    }
                      
</script>
