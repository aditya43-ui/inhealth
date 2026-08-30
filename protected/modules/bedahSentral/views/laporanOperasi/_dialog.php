<?php
// dialog diagnosa x
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDiagnosaX',
    'options' => array(
        'title' => 'Daftar ID Lab',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));
$this->renderPartial($this->path_view.'grid/_daftar_diagnosa_x', []);
$this->endWidget();

$barisDiagnosa = json_encode($this->renderPartial($this->path_view . 'diagnosa-x/row/_baris_diagnosax', array('model' => $model,'i'=>0), true));
$hariini = date('Y-m-d');
$jscript = <<< JS
           
    const hapusDiagnosa = (obj) => {
        window.parent.myConfirm("Apakah Anda yakin ingin menghapus data ini ?","Perhatian!", function(r){
            if (r){
                $(obj).parents("tr").detach();
            }
        });
    }
        
    const setDiagnosa = (obj, data) => {
        var trUraian = new String(${barisDiagnosa});
        const kasusdiagnosa = $(obj).parents("tr").find(".kasusdiagnosa").val();
        let formbody = $("#tbl_diagnosax > tbody");
        formbody.append(trUraian);
                
        formbody = formbody.find("tr:last");
        formbody.find("input[name='[tglmorbiditas]']").val('${hariini}');
        formbody.find(".diagnosa_id").val(data.diagnosa_id);
        formbody.find(".diagnosa_kode").val(data.diagnosa_kode);
        formbody.find(".diagnosa_nama").val(data.diagnosa_nama);
        formbody.find(".diagnosa_namalainnya").val(data.diagnosa_namalainnya);               
        formbody.find(".kasusdiagnosa").val(kasusdiagnosa); 
        
        renameInputRow($("#tbl_diagnosax"));
        
        formbody.find("input[name*='[tglmorbiditas]']").datepicker(
            jQuery.extend({
                    showMonthAfterYear: false
                },
                jQuery.datepicker.regional['id'], {
                    'dateFormat': 'dd M yy',
                    'maxDate': 'd',                    
                    'showSecond': true,                    
                    'changeYear': true,
                    'changeMonth': true,
                    'showAnim': 'fold',
                    'yearRange': '-80y:+20y'
                }
            )
        );
    }
        
    const refreshGridDiagnosaX = () => {
        $.fn.yiiGridView.update('daftar-diagnosa-x-grid', {
            data: {
                'DiagnosaM[default]':''
            }
        });
    }            
        
    const refreshGridPetugas = () => {
        $.fn.yiiGridView.update('daftar-petugas-grid', {
            data: {
                'PegawaiV[default]':''
            }
        });
    }
        
JS;

Yii::app()->clientScript->registerScript('cryopreservasi-dialog',$jscript, CClientScript::POS_HEAD);
?>


