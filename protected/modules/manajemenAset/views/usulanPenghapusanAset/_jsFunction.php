<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<?php

$url_daftar_aset = $this->createUrl('/actionAutoComplete/DropInventarisasiAset');

$jscript = <<< JS
        
        var refreshAset = () => {
            var lokasi_id = $(".lokasi_id").val();
            var def = 'kosong';
        
            if (lokasi_id != ''){
                def = '';
            }
        
            $.fn.yiiGridView.update('aset-grid', {
                data: {
                    'InvperalatanT[lokasi_id]': lokasi_id,
                    'InvperalatanT[default]': def
                }
            });
        } 
        
        var gen_ext_aset = (obj) => {            
                
            $(obj).find('.invperalatan_namabrg').autocomplete({
                'showAnim': 'fold',
                'minLength': 3,
                'focus': function (event, ui)
                {
                    $(this).val(ui.item.label);
                    return false;
                },
                'select': function (event, ui)
                {
                    setAset(ui.item, this);
                    return false;
                },
                'source': function (request, response)
                {
                    $.ajax({
                        url: "${url_daftar_aset}",
                        dataType: "json",
                        data: {
                            term: request.term,   
                            lokasi_id : $(".lokasi_id").val()
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                }
            });
        }      
                        
        var set_action = (obj,jenis) => {
            var id_attr = $(obj).parents(".form-utama").attr('id');
            var set_obj = $("#"+id_attr);             
                            
            if (jenis == 'tambah'){                    
                        
                tambah_data_baris($(obj));                                                                         
                        
                renameInputRow(set_obj);
                        
                $("#"+id_attr+" > tbody > tr.baris:last").find('input,select').val("");
                $("#"+id_attr+" > tbody > tr.baris:last").find('span.lbl').html("");
                                
                gen_ext_aset($("#"+id_attr+" > tbody"));                
                        
            }else if (jenis == 'hapus'){
                hapus_data_baris($(obj),function(){
                        renameInputRow(set_obj);
                });
            }                                                
        }
                                                                        
        
        var setNo = (obj) => {                        
            $("#no_row").val($(obj).parents("tr").attr("row-data"));
        }
        
        var setDialog = (jenis, dialog) => {            
            $("#jenis_dialog").val(jenis);
            $("#"+dialog).dialog('open');
        }                        
              
        var setAset = (data, obj) => {
            
            if (obj == ''){   
                var no = $("#no_row").val();
            }else{
                var no = $(obj).parents('.baris').attr("row-data");
            }
                                                  
            $("#tabel-daftar-aset > tbody > tr[row-data='"+no+"']").find(".invperalatan_id").val(data.invperalatan_id);              
            $("#tabel-daftar-aset > tbody > tr[row-data='"+no+"']").find(".invperalatan_namabrg").val(data.invperalatan_namabrg);
            $("#tabel-daftar-aset > tbody > tr[row-data='"+no+"']").find(".kondisi").val(data.invperalatan_keadaan);
            $("#tabel-daftar-aset > tbody > tr[row-data='"+no+"']").find(".label-kode").html(data.invperalatan_kode);
            $("#tabel-daftar-aset > tbody > tr[row-data='"+no+"']").find(".label-merk").html(data.invperalatan_merk);
            $("#tabel-daftar-aset > tbody > tr[row-data='"+no+"']").find(".label-keadaan").html(data.invperalatan_keadaan);
            $("#tabel-daftar-aset > tbody > tr[row-data='"+no+"']").find(".label-tanggal-perolehan").html(data.tanggal_perolehan);
                        
                        
            $("#dialogAset").dialog('close');            
        }      
        
        /**
        digunakan untuk mereset detail aset, menjadi kosong, jika sudah terisi akan muncul warning
        */
        var resetDataAset = (obj) => {
                        
//            var cek = $("#tabel-daftar-aset > tbody > tr").length;
//            if (cek > 0){
//                myConfirm("Apakah Anda yakin ingin mereset data aset, sesuai lokasi baru ini ?","Perhatian!", function(r){
//                            if (r){
            var a = 1;
            $("#tabel-daftar-aset > tbody > tr").each(function(){
                if (a != 1){
                    $(this).remove();
                }else{            
                    $(this).find('input,select,textarea').val("");
                    $(this).find('.lbl').html("");
                }
                a++;
            })
//                            }
//                });
//                return false;
//            }
            
        }
           
        /**
        digunakan untuk mambatalkan aset yang sudah dipilih, agar data yang ditampilkan kembali kosong
        */
        var resetAset = (obj) => {            
                                    
            var form_obj = $(obj).parents(".baris");

            form_obj.find('input,select,textarea').val("");            
            form_obj.find('.lbl').html("");            
        }
                
        var renameInputRow = (obj_table) => {
            var row = 0;
            var count = $(obj_table).find("tbody > tr").length;
                
            $(obj_table).find("tbody > tr").each(function(){                
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
                                                            
        setTimeout(function(){
            renameInputRow($("#tabel-daftar-aset"));            
        },500)
JS;

Yii::app()->clientScript->registerScript('usulan-penghapusan-aset-functions',$jscript, CClientScript::POS_HEAD);
?>
