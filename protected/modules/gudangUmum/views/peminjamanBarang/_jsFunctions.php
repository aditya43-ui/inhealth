<?php
/** 
 * view ini digunakan untuk menampung fungsi - fungsi javascript
 * 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
$det = new GUPeminjamanbrgT;
?>
<script type='text/javascript'>
     function tambahBaris(){
        var row = '<?php echo CJSON::encode($this->renderPartial($this->path_view.'form/_rowDetailPinjam',array('model'=>$det, 'i'=>1,),true));?>';
        $('#id-detail > tbody').append(row);        
        renameInput($("#id-detail"));        
        generatePicker();                       
    }
    
    function hapusBaris(obj){
        myConfirm("Apakah Anda yakin, ingin menghapus data ini ?","Perhatian !",function(r){
            if (r){
                $(obj).parents("tr").remove();
                renameInput($("#id-detail"));        
                generatePicker();                
            }
        });
    }
    
    function renameInput(obj_table){
        var row = 0;
        $(obj_table).find("tbody > tr").each(function(){
            $(this).find('.no_urut').html(row+1);
            $(this).attr('data-row',row);
            $(this).find('.add-on').each(function(){ //element <input>
                var old_name = $(this).attr("id");
                if (typeof old_name !== 'undefined'){
                    var old_name_arr = old_name.split("_");

                    if(old_name_arr.length == 4){
                        $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]+"_"+old_name_arr[3]);

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
            row++;
        });

        row = 0;
        $(obj_table).find('tbody > tr').each(function(){
            if (row == 0){
                $(this).find('.tambah').attr('style','display:block;border-radius:100%;padding:0px;');
                $(this).find('.hapus').attr('style','display:none;border-radius:100%;padding:0px;');
            }else if(row >= 1){
                $(this).find('.tambah').attr('style','display:block;border-radius:100%;padding:0px;');
                $(this).find('.hapus').attr('style','display:block;border-radius:100%;padding:0px;');
            }
            row++;
        })
    }
    
    function generatePicker(){        
        $("#id-detail > tbody > tr").find('input[name$="[invperalatan_namabrg]"]').each(function(){                                                    
            $(this).autocomplete(
                {
                    'showAnim':'fold',
                    'minLength':3,
                    'focus':function(event, ui )
                    {
                        $(this).val("");
                        return false;
                    },
                    'select':function( event, ui )
                    {                                                
                        setAset(ui.item,this);
                        return false;
                    },
                    'source':function(request, response)
                    {                                                                                                                                  
                        $.ajax({
                            url: "<?php echo $this->createUrl('/actionAutoComplete/dropInventarisasiAset');?>",
                            dataType: "json",
                            data:{
                                term: request.term,                                
                                invperalatan_id: $("#tampung_id").val(),
                                custom:'not_invperalatan_id'
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    },
                }
            );
        });
        
        jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip();
    }
    
    function setDialog(jenis,obj){        
        var no = $(obj).parents("tr").data('row');                
        $("#no_row").val(parseInt(no));                
        
        if (jenis == 'peminjam'){
            $("#dialogPegawai").dialog("open");
        }else if (jenis == 'ruangan'){
            $("#dialogRuangan").dialog("open");
        }else if (jenis == 'aset'){
            
            var selected = [];		            
            
            $("#id-detail > tbody > tr").each(function(){
                if ($(this).find('.aset_id').val() != ''){
                    selected.push($(this).find('.aset_id').val());                    
                }
            });                        
            
            $.fn.yiiGridView.update('aset-m-grid2', {
                data: {
                    "InvperalatanT[invperalatan_id]":selected,
                    "InvperalatanT[custom]":'not_invperalatan_id',
                }
            });
            
            $("#dialogAset").dialog("open");
            
            
        }        
    }        
    
    function setPeminjam(data){
        $("#<?php echo CHtml::activeId($model, 'pegpeminjam_id') ?>").val(data.pegawai_id);
        $("#<?php echo CHtml::activeId($model, 'pegpeminjam_nama') ?>").val(data.namaLengkap);
        $("#<?php echo CHtml::activeId($model, 'jabatan_nama') ?>").val(data.jabatan_nama);
        $("#<?php echo CHtml::activeId($model, 'nip') ?>").val(data.nomorindukpegawai);
        $("#<?php echo CHtml::activeId($model, 'namaunitkerja') ?>").val(data.namaunitkerja);
        
        $("#dialogPegawai").dialog("close");
    }
    
    function setRuangan(data){
        $("#<?php echo CHtml::activeId($model, 'ruangan_id') ?>").val(data.ruangan_id);
        $("#<?php echo CHtml::activeId($model, 'ruangan_nama') ?>").val(data.ruangan_nama);
        
        $("#dialogRuangan").dialog("close");
    }
    
    function setAset(data,obj){
        if (typeof obj === 'undefined'){                                                                           
            var row = $("#no_row").val();                       
        }else{            
            var row = $(obj).parents("tr").attr('data-row');                       
            $("#no_row").val(row);
        }
        
        var tampung = '';
        var selected = [];
        
        $('#id-detail > tbody > tr').each(function(){                   
            if (typeof obj === 'undefined'){                               
                var get = $(this); 
            }else{
                var get = $(obj).parents("tr");                
            }
            
            if ($(this).attr('data-row') == row){                                                
                get.find('.aset_nama').val(data.invperalatan_namabrg);
                get.find('.aset_id').val(data.invperalatan_id);
                get.find('.noaset').html(data.invperalatan_kode);
                get.find('.merk').html(data.invperalatan_merk);
                get.find('.ukuran').html(data.invperalatan_ukuran);
                get.find('.keadaan').html(data.invperalatan_keadaan);
            }
                        
            if ($(this).find('.aset_id') != ''){                
                tampung += ','+$(this).find('.aset_id').val();
                selected.push($(this).find('.aset_id').val());       
                
            }
        });                    
                        
            
        $("#tampung_id").val(selected);
        
        $("#dialogAset").dialog("close");
    }
    
    function cekForm(){
        var ok = 1;
        if (requiredCheck($("#peminjamanbrg-t-form"))){
            $('#peminjamanbrg-t-form').submit();
            ok = 1;
        }
        if (ok == 1) {
            $('#peminjamanbrg-t-form').submit();
            disableOnSubmit($("#btn_submit"), 'no_unformat');
        }

       return false;
    }
            
    $(document).ready(function(){
        <?php if (isset($_GET['sukses'])){ ?>
                $("#peminjamanbrg-t-form").find('input,select,textarea').each(function(){
                    $(this).attr('disabled',true);
                });
                
                $(".add-on").hide();
                $(".rowbutton").attr("style","display:none;");
        <?php } ?>
    });
</script>
