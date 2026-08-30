<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<?php

$urlHapusRiwayat = $this->createUrl('hapusEkstubasi');
$urlUlang = $this->createUrl('index',['pendaftaran_id'=>$_GET['pendaftaran_id'],'pasienadmisi_id'=>isset($_GET['pasienadmisi_id'])?$_GET['pasienadmisi_id']:null]);
$urlCetak = $this->createUrl("cetak");
$urlDetail = $this->createUrl("detail");

$action = $this->action->id;
$idCpis = isset($_GET['id'])?$_GET['id']:'';


$jscript = <<< JS
        
    const setDialog = (idDialog, jenis) => {
        $("#jns_dialog").val(jenis);
        
        $("#"+idDialog).dialog("open");
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
                                    
    const cetak = (id, jenis) => {   
        if (typeof jenis === 'undefined'){
            window.open("${urlCetak}&id="+id,"cetak-cpis-pasien","width=860,height=480");
        }else{
            window.open("${urlDetail}&id="+id,"cetak-cpis-pasien","width=860,height=480");
        }
    }
                          
JS;

Yii::app()->clientScript->registerScript('perispana-ekstubasi-transaksi',$jscript, CClientScript::POS_HEAD);
?>
