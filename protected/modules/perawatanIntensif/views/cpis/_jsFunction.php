<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<?php

$urlHapusRiwayat = $this->createUrl('hapusCpis');
$urlUlang = $this->createUrl('index',['pendaftaran_id'=>$model->pendaftaran_id,'pasienadmisi_id'=>$model->pasienadmisi_id]);
$urlCetak = $this->createUrl("cetak");

$action = $this->action->id;
$idCpis = isset($_GET['id'])?$_GET['id']:'';


$jscript = <<< JS
        
    const cekNilai = (type, obj) => {
        const tr = $(obj).parents("tr");
        const label = (tr.find("td.cpis-nama").html()).toLowerCase();
        let value = $(obj).val();
        
        let no = 0;
        let skor = 0;                
        
        if (type == 'dropdown'){
            skor = $(obj).find("option:selected").attr("skor");                    
        }else{
            
            if (label == 'suhu'){
                value = unformatNumber(value);
                if (value >= 36.5 && value <= 38.4)
                    skor = 0;
                else if (value >= 38.5 && value <= 38.9)
                    skor = 1;
                else
                    skor = 2;
            }else if (label == 'leukosit'){
                value = unformatNumber(value);
                if (value >= 4000 && value <= 11000)
                    skor = 0;
                else
                    skor = 1;
            }else if (label == 'pa02/fi02'){
                if (isNaN(label)){
                    value = value.toLowerCase();
                    if (value == 'ards'){
                        skor = 0;
                    }else{
                        skor = 2;
                    }
                }
            }
        }
        
        tr.find(".skorpenilaian").val(skor);
        
        totalSkor();
    }   
        
    const totalSkor = () => {
        let total = 0;
        
        $(".skorpenilaian").each(function(){
            total += parseInt($(this).val());
        });
        
        $(".total_skor").val(total);
    }
        
    const hapus = (id) => {                
        window.parent.myConfirm("Apakah Anda yakin ingin menghapus data ini ?","Perhatian!", function(r){
            if (r){
                $.ajax({
                    type: 'POST',
                    url: '${urlHapusRiwayat}',
                    data: {
                        id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.sukses == '1') {
                            window.parent.Notiflix.Report.Success("Data berhasil dihapus","Perhatian!","OK");
                            if ('${action}' == 'detail'){
                                if (id == '${idCpis}'){
                                    location.href = "${urlUlang}";
                                    return false;   
                                }
                            }
                            refreshRiwayat();                                                        
                        }else{
                            window.parent.Notiflix.Report.Failure("Data gagal dihapus","Perhatian!","OK");
                        }                        
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        });
    }
                                    
    const refreshRiwayat = () => {
        $.fn.yiiGridView.update('daftar-riwayat-grid');
    }
                                    
    const cetak = (id) => {   
        window.open("${urlCetak}&id="+id,"cetak-cpis-pasien","width=860,height=480");
    }
                          
JS;

Yii::app()->clientScript->registerScript('permintaan-penelitian-sel-punca-transaksi',$jscript, CClientScript::POS_HEAD);
?>
<script>
    var set_dialog_pasase = (obj) => {
        $(obj).find("tbody > tr").each(function () {
            $(this).find('.add-on').attr('style', 'min-width: 44px');
            $(this).find('.add-on').find('a').find('.icon-list').attr('style', 'display: none');
        });
    };
</script>
