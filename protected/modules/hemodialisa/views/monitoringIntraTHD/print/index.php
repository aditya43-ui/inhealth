<style>     
    table.prinout{    
        border-collapse: collapse;
        table-layout: auto !important;
        margin-bottom: 10px;
    }
    
    table.prinout td, table.prinout th {
        padding: 2px 5px 2px 5px;       
        font-size:8.5pt;
        line-height: 1;
    }
    
    .prinout{        
        font-size: 10px !important;
    }
    
    .green{
        background: #afdc7e  !important;
        box-shadow:  inset -200px -200px 0px 200px rgba(175, 220, 126) !important;
    }
</style>
<?php
function ceklis($st){
    $icon = '<span  style="font-family:FontAwesome;" >&#xf096;</span>';
    if ($st){
        $icon = '<span  style="font-family:FontAwesome;" >&#xf046;</span>';
    }
    
    return $icon;
}
?>
<?= $this->renderPartial('hemodialisa.views.monitoringIntraTHD.print/page/_hal_1',[
    'model'=>$model,
    'modPres'=>$modPres,
    'modJadwal'=>$modJadwal,
    'modPost'=>$modPost,
    'data'=>$data], true) ?>