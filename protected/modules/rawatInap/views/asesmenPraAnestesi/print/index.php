
<style>
    table.grid th, table.grid td, table.no-grid th, table.no-grid td {         
        font-size: 9pt;
    } 
    
    table.grid tr td table.no-grid tr td {         
        font-size: 7pt;
    }
    
    b,span{
        font-size: 8pt !important;
    }
</style>

<?php
    $this->renderPartial('print/page/1',[
        'model'=>$model,
        'judul_print'=>$judul_print,
        'alias'=>$alias,
        'modPasien'=>$modPasien
    ]);
?>