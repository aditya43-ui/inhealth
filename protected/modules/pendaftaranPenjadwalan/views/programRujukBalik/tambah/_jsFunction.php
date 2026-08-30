<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<?php
$urlTambahObat = $this->createUrl('tambahObat');
$jscript = <<< JS
      
        const cekForm = () => {
            const cekobat = $("#tabel-list-obat > tbody > tr").length;
        
            if (cekobat == 0){
                myAlert("Obat belum ditambahkan","Perhatian!");
                return false;
            }
        
            $("#form-tambah-obat").find("input,select").attr("disabled", true);
            if (requiredCheck($("#prb-form"))){
                $("#prb-form").submit();
                disableOnSubmit($("#btn_submit"));
            }else{
                $("#form-tambah-obat").find("input,select").removeAttr("disabled");
            }
        }
        
        const hapusObat = (obj) => {
            myConfirm("Apakah Anda yakin ingin menghapus data ini ?","Perhatian!", function(r){
                if (r){
                    $(obj).parents(".baris").detach();
                }
            });
        }
        
        const tambahObat = () => {
            if (requiredCheck($("#form-tambah-obat"))){
                var jumlah = (($("#form-tambah-obat").find(".qty_obat").val()));
                
                if (jumlah > 0){
                    $.ajax({
                        type: 'POST',
                        url: '${urlTambahObat}',
                        data: {
                            formdata:$("#form-tambah-obat").find('input, select').serialize()
                        },
                        dataType: "json",
                        success: function (data) {                      
                            if (data.sukses == 1){
                                $("#tabel-list-obat > tbody").append(data.row);
                                $("#form-tambah-obat").find("input, select").val("");
                                renameInputRow($("#tabel-list-obat"));     
                                    
                                $("#tabel-list-obat > tbody > tr:last").find(".qty_obat").keyup(function () {
                                    setNumbersOnly(this);
                                });
                            }else{
                                myAlert("Master obat prb belum di set ke master obat alkes","Perhatian!");
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {                                    
                        }
                    });
                }else{
                    myAlert("Jumlah tidak boleh 0","Perhatian!");
                    $("#form-tambah-obat").find(".qty_obat").val(formatFloat(parseFloat(jumlah)));
                }
            }
        }
        
        var cekData = (jenis) => {
            let message  = '';        
            if (jenis == 'diagnosa'){
                message = $("#daftar-diagnosa-prb-grid").find(".message-bpjs").data('message');
            }else if (jenis == 'dokter'){
                message = $("#daftar-dokter-dpjp-grid").find(".message-bpjs").data('message');                                                        
            }else if (jenis == 'obat'){
                message = $("#daftar-obat-prb-grid").find(".message-bpjs").data('message');        
            }

            if (message != ''){            
                myAlert(message,"Perhatian!");
            }
        }
                                                                        
        var setNo = (obj) => {                        
            $("#no_row").val($(obj).parents(".baris").attr("row-data"));
        }
        
        var setDialog = (jenis, dialog, obj) => {                                
            $("#jenis_dialog").val(jenis);
            
            $("#"+dialog).dialog('open');
        }
        
        var renameInputRow = (obj_table, jenis) => {
            var row = 0;
            var count = $(obj_table).find(".baris").length;
                
            $(obj_table).find(".baris").each(function(){     
                
                $(this).find('.no-label').addClass('hide');
                if (row == 0){
                    $(this).find('.no-label').removeClass('hide');
                }
                        
                $(this).find(".nomor").html(row+1);
                $(this).attr("row-data",row);
                $(this).find('input,select,textarea').each(function(){ //element <input>
                    if (typeof $(this).attr("name") !== 'undefined'){
                        var old_name = $(this).attr("name").replace(/]/g,"");
                        var old_name_arr = old_name.split("[");
                        var attr_id = $(this).data("attr");
                        if(old_name_arr.length == 3){
                            if (attr_id != '' && typeof attr_id !== 'undefined'){
                                $(this).attr("id",old_name_arr[0]+"_"+attr_id+"_"+row+"_"+old_name_arr[2]);
                            }else{
                                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                            }
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
                                   
        });
                                                            
                          
JS;

Yii::app()->clientScript->registerScript('program-rujuk-balik-head',$jscript, CClientScript::POS_HEAD);
?>
