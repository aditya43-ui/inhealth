<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<?php
$url_load_inv = $this->createUrl('loadInv');
$set_url_kode_internal = $this->createUrl('/actionAjax/loadLokasiAset');

$jscript = <<< JS
        
        var cekForm = () => {
            
            var cek_detail = $(".inv_invperalatan_id").val();
        
            if (typeof cek_detail === 'undefined'){
                toastr.warning("Detail Aset belum di load","Perhatian!");
                return false;
            }
        
            if (requiredCheck($("#penerimaan-alat-t"))){
                $("#penerimaan-alat-t").submit();
                disableOnSubmit($("#btn_submit"));
            }
        
            return false;
        }
        
        
        
        var refreshInv = () => {
            var def = 'kosong';
            var periodeasetopname_id = $(".periodeasetopname_id").val();
        
            if (periodeasetopname_id != ''){                
                def = '';
            }
                   
        
            $.fn.yiiGridView.update('mesinpengemasan-m-grid', {
                data:{
                    'InvperalatanT[default]':def,
                    'InvperalatanT[periodeasetopname_id]':periodeasetopname_id
                }
            });
        }
        
        var gen_ext = () => {
            jQuery('.tanggal_perolehan').datepicker(
                jQuery.extend(
                    {
                        showMonthAfterYear:false
                    }, 
                    jQuery.datepicker.regional['id'],
                    {
                        'dateFormat':'dd M yy',
                        'showSecond':false,
                        'timeOnlyTitle':'Pilih Waktu',                        
                        'changeYear':true,
                        'changeMonth':true,
                        'showAnim':'fold',
                        'yearRange':'-80y:+20y',
                    }
                )
            );
        }
        
        var loadInv = (obj) => {
            var lokasi_id = $(".lokasi_id").val();            
            var inv_id = $(".invperalatan_id").val();                                
        
            if (lokasi_id == null){
                lokasi_id = '';
                toastr.warning("Lokasi Aset belum dipilih","Perhatian!");
                return false;
            }
        
            if (inv_id == ''){
                toastr.warning("Nomor Aset belum dipilih","Perhatian!");
                return false;
            }
        
            $.ajax({
                type:'POST',
                url:'${url_load_inv}',
                data: {
                    lokasi_id:lokasi_id,                    
                    inv_id:inv_id,                    
                },
                dataType: "json",
                success:function(data){
                    if (data.sukses == 1){
                        if (data.st_lokasi == 'beda'){
                            myConfirm(data.pesan,"Perhatian",function(r){
                                if (r){
                                    $(".form-detail-aset").html(data.html);
                                    gen_ext();
                                }else{
                                    location.reload(); 
                                }
                            });                            
                        }else{
                            $(".form-detail-aset").html(data.html);
                            gen_ext();
                        }                        
                    }else{
                        toastr.error(data.pesan,"Perhatian!");
                    }                                       
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        } 
        
        var setDialog = (dialog) => {
           
            $("#"+dialog).dialog('open');
        }                
        
        var setMesin = (data) => {
                     
            $(".invperalatan_id").val(data.invperalatan_id);
            $(".invperalatan_kode").val(data.barang_dan_kode);                        
        
            $("#dialogMesin").dialog('close');
        }
                        
                     
JS;

Yii::app()->clientScript->registerScript('aset-opname',$jscript, CClientScript::POS_HEAD);


$js = <<< JS
    
    var resetAset = () => {
        var lok_id = $(".lokasi_id").val();
        $(".invperalatan_id").val("");
        $(".invperalatan_kode").val("");

        $.post('${set_url_kode_internal}', {
            id: lok_id
        }, function(data) {
            $(".kode_internal").val(data.kode_internal);
        }, "json");
    }
        
    resetAset();
JS;
Yii::app()->clientScript->registerScript('aset-opname-end',$js, CClientScript::POS_READY);
?>
