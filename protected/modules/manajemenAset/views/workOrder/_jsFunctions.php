<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - untuk menampung data javascript
* RSST-1584
*/
?>

<script>
    
    
    
    var refreshTabel = (id) => {
        
        var is_peg_pjasset = '';
        var is_peg_internalaset = '';
        var lokasi_id = '';
        
        if (id == 3){
            is_peg_internalaset = true;
        }else if(id == 1){
            is_peg_pjasset = true;
            lokasi_id = '<?= $model->lokasi_id ?>';
        }
        
        $.fn.yiiGridView.update('dialog-pengirim-m-grid', {
            data: {
                'PegawaiV[is_peg_pjasset]':is_peg_pjasset,
                'PegawaiV[is_peg_internalaset]':is_peg_internalaset,
                'PegawaiV[lokasi_id]':lokasi_id,
            }
	});
        
    }
    
    function pilih(id){
        $("#idPilih").val(id);        
        if (id == 3 || id == 1){
            refreshTabel(id);
        }
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
            $("#<?php echo CHtml::activeId($model, 'pj_pemeliharaan_id') ?>").val(peg.pegawai_id);
            $("#<?php echo CHtml::activeId($model, 'pj_pemeliharaan_nama') ?>").val(peg.namaLengkap);
            $("#<?php echo CHtml::activeId($model, 'pj_jabatan_nama') ?>").val(peg.jabatan_nama);
            $("#<?php echo CHtml::activeId($model, 'pj_unitkerja_nama') ?>").val(peg.namaunitkerja);
            $("#<?php echo CHtml::activeId($model, 'pj_nip') ?>").val(peg.nomorindukpegawai);
        }else if (id == 2){            
            
        }else if (id == 3){            
            $("#<?php echo CHtml::activeId($model, 'teknisiint_id') ?>").val(peg.pegawai_id);
            $("#<?php echo CHtml::activeId($model, 'teknisiint_nama') ?>").val(peg.namaLengkap);            
                        
        }
        
        $("#dialogPegawai").dialog("close");
    }
    
    function setTeknisi(data,auto){        
        if (auto == 'auto'){
            var peg = data;
        }else{
            var peg = data.peg;
        }
                
                              
        $("#<?php echo CHtml::activeId($model, 'teknisiperalatan_id') ?>").val(peg.teknisiperalatan_id);
        $("#<?php echo CHtml::activeId($model, 'teknisiperalatan_nama') ?>").val(peg.namateknisi);            
                
        $("#dialogTeknisi").dialog("close");
    }
    
    function cekTeknisi(obj){
        $("#<?php echo CHtml::activeId($model, 'teknisiperalatan_id') ?>").removeClass('required');
        $("#<?php echo CHtml::activeId($model, 'teknisiperalatan_nama') ?>").removeClass('required');
        $("#<?php echo CHtml::activeId($model, 'teknisiint_id') ?>").removeClass('required');
        $("#<?php echo CHtml::activeId($model, 'teknisiint_nama') ?>").removeClass('required');
        
        if ($(obj).prop("checked") == true ){
            $("#internal").show();
            $("#<?php echo CHtml::activeId($model, 'teknisiint_id') ?>").addClass('required');
            $("#<?php echo CHtml::activeId($model, 'teknisiint_nama') ?>").addClass('required');
                        
            $("#eksternal").hide();
        }else{
            $("#internal").hide();
            $("#eksternal").show();
            
            $("#<?php echo CHtml::activeId($model, 'teknisiperalatan_id') ?>").addClass('required');
            $("#<?php echo CHtml::activeId($model, 'teknisiperalatan_nama') ?>").addClass('required');                        
        }
        
        $("#<?php echo CHtml::activeId($model, 'teknisiperalatan_id') ?>").val('');
        $("#<?php echo CHtml::activeId($model, 'teknisiperalatan_nama') ?>").val(''); 
        $("#<?php echo CHtml::activeId($model, 'teknisiint_id') ?>").val('');
        $("#<?php echo CHtml::activeId($model, 'teknisiint_nama') ?>").val('');            
    }
    
    $(document).ready(function(){                
        jQuery("#<?php echo CHtml::activeId($model, 'wo_supplier_id') ?>").multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '220px',
            onChange: function(element, checked) {	
                    $("#<?php echo CHtml::activeId($model, 'teknisiperalatan_nama') ?>").addClass("animation-loading-1");
                    setTimeout(function(){                                
                            $("#<?php echo CHtml::activeId($model, 'teknisiperalatan_nama') ?>").removeClass("animation-loading-1");
                            $("#<?php echo CHtml::activeId($model, 'teknisiperalatan_id') ?>").val('');
                            $("#<?php echo CHtml::activeId($model, 'teknisiperalatan_nama') ?>").val('');
                            var supplier_id = element.val();                                   
                           
                            $(".dialog_supplier_id").val(supplier_id);
                            if (supplier_id != ''){
                                $("#judul-teknisi").html("("+element.text()+")");
                            }else{
                                $("#judul-teknisi").html("");
                            }
                           
                            $.fn.yiiGridView.update('dialog-teknisi-m-grid', {
                                    data: {
                                            "TeknisiperalatanM[supplier_id]":supplier_id,			
                                    }
                            });
                    },500);

                },
            enableCaseInsensitiveFiltering: true
        }).hide();      
    });
</script>