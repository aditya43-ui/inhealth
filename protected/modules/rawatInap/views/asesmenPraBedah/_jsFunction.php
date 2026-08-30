<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<?php
$urlhapus = $this->createUrl('hapus');
$urlcetak = $this->createUrl('cetak');

$detail = !empty($detail)?$detail:0;
$daftarId = $model->pendaftaran_id;

$scala = $model->skalanyeri;

$paramSkala0 = Params::SKALA_NYERI_0;
$paramSkala1_2 = Params::SKALA_NYERI_1_2;
$paramSkala3_4 = Params::SKALA_NYERI_3_4;
$paramSkala5_6 = Params::SKALA_NYERI_5_6;
$paramSkala7_8 = Params::SKALA_NYERI_7_8;
$paramSkala9_10 = Params::SKALA_NYERI_9_10;
$jscript = <<< JS
        
        const cekRujuk = () => {
            const cek = $("#is_rujuk").prop("checked");
        
            if (!cek){
                $(".rujukke_id").val("");
            }
        }
        
        const loadPermintaan = () => {
            const id = $(".pasienkirimkeunitlain_id").val();
            let def = 'kosong';
        
            if (id != ''){
                def = '';
            }
        
            $.fn.yiiGridView.update('riwayat-morbiditas-grid',{
                data:{
                    'AsesmenprabedahT[default]':def,
                    'AsesmenprabedahT[pendaftaran_id]':${daftarId},
                }
            });
        
            $.fn.yiiGridView.update('riwayat-permintaan-grid',{
                data:{
                    'AsesmenprabedahT[default]':def,
                    'AsesmenprabedahT[pasienkirimkeunitlain_id]':id,
                }
            });
            
        }
        
        const hapus = (id) => {
            window.parent.myConfirm("Apakah Anda yakin ingin menghapus data ini ?","Perhatian!", function(r){
                if (r){
                    $.ajax({
                        type: 'POST',
                        url: '${urlhapus}',
                        data: {id:id},
                        dataType: "json",
                        success: function (data) {                                                            
                            window.parent.myAlert("data berhasil dihapus","Perhatian!");
                            location.href = data;
                        },
                        error: function (jqXHR, textStatus, errorThrown) {                                    
                            $("#form-proses").removeClass("animation-loading");
                        }
                    });
                }
            });            
        }
        
        const pilihScala = (skor) => {
            var keterangan;
            if (skor == 0){
                keterangan = '${paramSkala0}';
            }else if (skor >= 1 && skor <= 2){
                keterangan = '${paramSkala1_2}';
            }else if (skor >= 3 && skor <= 4){
                keterangan = '${paramSkala3_4}';
            }else if (skor >= 5 && skor <= 6){
                keterangan = '${paramSkala5_6}';
            }else if (skor >= 7 && skor <= 8){
                keterangan = '${paramSkala7_8}';
            }else if (skor >= 9 && skor <= 10){
                keterangan = '${paramSkala9_10}';
            }
            
            $(".skalanyeri").val(skor);
            $(".skalanyeri_ket").val(keterangan);            

            $(".nyeri-nomor").css("border", "none");
            $(".nyeri-nomor").css("border-radius", "5px");
            $("#nyerinomor_" + skor).css("border", "1px solid black");
        }
        
        const cetak = (id) => {
            window.open('${urlcetak}&id='+id,'printwin','left=100,top=100,width=1000,height=640');
        }        
                                                                        
        var setDialog = (jenis, dialog, obj) => {                                
            $("#jnsDialog").val(jenis);
                
            if (jenis == 'dpjp'){
                $(".judul-petugas-ruangan").html("DPJP");
            }else if (jenis == 'perawat'){
                $(".judul-petugas-ruangan").html("Perawat/Bidan");
            }else if (jenis == 'mpp'){
                $(".judul-petugas-ruangan").html("MPP");
            }
                
            $("#"+dialog).dialog('open');
        }

                                            
        $(document).ready(function(){     
            
            $(".form-ceklis").find("input:radio").click(function(){
                set_dis($(this),true)
            });
            
            $(".form-ceklis").find("input:radio").each(function(){
                set_dis($(this),true)
            });                      
                  
                
            if ('${detail}' == 1){
                $("form").find("input, select, textarea").attr("disabled", true);
                $("form").find(".add-on, .btn-ulang, .btn-hide").hide();
            }
            
            pilihScala('${scala}')
            
        });
        
                                                            
                          
JS;

Yii::app()->clientScript->registerScript('lembar-perencanaan-pulang-js',$jscript, CClientScript::POS_HEAD);
?>
