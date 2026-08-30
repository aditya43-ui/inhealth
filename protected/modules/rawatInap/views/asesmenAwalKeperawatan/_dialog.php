<?php
//========= Dialog buat Pencarian Diagnosa Penyakit Keluarga =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDiagnosa',
    'options' => array(
        'title' => 'Pencarian Diagnosa Penyakit Keluarga',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 440,
        'resizable' => false,
    ),
));

$this->renderPartial($this->path_view.'/grid/_daftarDiagnosa',[]);

$this->endWidget();

?>

<script type="text/javascript">
    function setDiagnosa(data){
        const formDiagnosa = $("#formDiagnosa").val();
        let inputField = "textarea[name$='[riwayatpenyakitkeluarga]']";        
                
        if (formDiagnosa == 'formGeriatriPenyakitTerdahulu'){
            inputField = "textarea[name$='[riwayatpenyakitterdahulu]']";
        }else if (formDiagnosa == 'formNeonatusIbuAnak'){
            inputField = "textarea[name$='[neonatus_penyakitibu_lainnyaket]']";
        }
        
        let dataSebelumnya = $("."+formDiagnosa).find(inputField).val();
        
        if (dataSebelumnya != ''){
            $("."+formDiagnosa).find(inputField).val(dataSebelumnya+", "+data.diagnosa_nama);
        }else{
            $("."+formDiagnosa).find(inputField).val(data.diagnosa_nama);
        }        
        
        
        
        $("#dialogDiagnosa").dialog("close");
    }  
    
    function refreshGridDiagnosa(){
        $.fn.yiiGridView.update('list-diagnosa-m-grid',{
            data:{
                'RIDiagnosaM[default]':''
            }
        });
    }
</script>