<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   menampung semua fungsi javascript
* RSST-1640
*/
?>
<script>
    function pilih(id){
        $("#idPilih").val(id);        
        $("#dialogPegawai").dialog("open");
    }
    
    function setPegawai(data,auto){
        var id = $("#idPilih").val();
        if (auto == 'auto'){
            var peg = data;
        }else{
            var peg = data.peg;
        }
                        
        if (id == 1){            
            $("#<?php echo CHtml::activeId($model, 'pegmengetahui_id') ?>").val(peg.pegawai_id);
            $("#<?php echo CHtml::activeId($model, 'pegmengetahui_nama') ?>").val(peg.namaLengkap);            
        }else if (id == 2){            
            $("#<?php echo CHtml::activeId($model, 'pegmenyetujui_id') ?>").val(peg.pegawai_id);
            $("#<?php echo CHtml::activeId($model, 'pegmenyetujui_nama') ?>").val(peg.namaLengkap);            
                        
        }
        
        $("#dialogPegawai").dialog("close");
        $("#<?php echo CHtml::activeId($model, 'pegmengetahui_id') ?>").blur();
    }
    
    function refreshTable(){
        $.fn.yiiGridView.update('penghapusanaset-t-grid', {
            data: $('#caripengeluaran-search-form').serialize()
        });                
    }
    
    function cekSemua(obj){        
        
        if ($(obj).prop("checked") == true){
            $("#penghapusanaset-t-grid > table > tbody > tr").each(function(){
               $(this).find('.ceklis').prop('checked',true);               
            });
        }else{
            $("#penghapusanaset-t-grid > table > tbody > tr").each(function(){
               $(this).find('.ceklis').prop('checked',false);               
            });
        }
        
        $("#<?php echo CHtml::activeId($model, 'pegmengetahui_id') ?>").blur();
    }
    
    function pilihData(obj){
        $("#<?php echo CHtml::activeId($model, 'pegmengetahui_id') ?>").blur();
    }
    
    /**
     * @author  M Iqbal Laksana
     * @version 2.0.0
     * - digunakan untuk memanggil fungsi untuk date range picker, nama fungsi iniharus setIndikator()
     */
    function setIndikator(){
        refreshTable();
    }
        
    
    $(document).ready(function(){                
                
        setValidasiCekDisabled($("#penghapusanaset-t-form"), function() {
            if ($("#penghapusanaset-t-grid > table > tbody > tr").find('.ceklis:checked').length == 0){
                return false;
            }

            return true;
         });
    });
</script>

