<style>
    @media print {
        @page { margin-top: 15px; }
        .ttd {
            page-break-inside:avoid;
        }
    }
    table{
        font-family: "Arial";
        width: 100% !important;
    }
</style>
<?php
$itemCssClass='table table-striped table-bordered table-condensed';
    $table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
    $sort = true;
if (isset($caraPrint)){
    $data = $model->searchPrint();
    $template = "{items}";
    $sort = false;
    
    if ($caraPrint == "EXCEL"){
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    
    if ($caraPrint == "PDF"){
        $itemCssClass = 'table border';
    }
    
    echo "
        <style>
            .border th, .border td{
                border:1px solid #000;
            }
            .table thead:first-child{
                border-top:1px solid #000;        
            }

            thead th{
                background:none;
                color:#333;
            }

            .border {
                box-shadow:none;
                border-spacing:0px;
                padding:0px;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
    $itemCssClass = 'table border';
} else{
    $data = $model->searchPrint();
    $template = "{summary}\n{items}\n{pager}";
}

    $this->widget($table,array(
    'id'=>'sajenis-kelas-m-grid',
    'enableSorting'=>false,
    'dataProvider'=>$data,
    'mergeHeaders'=>array(
        array(
            'name'=>'<center>Gol Darah Awal</center>',
            'start'=>3, 
            'end'=>6, 
        ),
         array(
            'name'=>'<center>Rhesus</center>',
            'start'=>7, 
            'end'=>8, 
        ), 
        array(
            'name'=>'<center>Gol Darah Akhir</center>',
            'start'=>9, 
            'end'=>12, 
        ),
         array(
            'name'=>'<center>Rhesus</center>',
            'start'=>13, 
            'end'=>14, 
        ), 
    ),
    'template'=>$template,
    'enableSorting'=>$sort,
    'mergeColumns'=>array('tanggal'),
    'extraRowColumns'=> array('tanggal'),
    'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
            array(
                'header' => 'No',
                'value' => '$row+1',
            ),
            array(
                'header' => 'Tanggal Pengujian',
                'name'=>'tanggal', 
                'value' => function($data){
                    if(!empty($data->tglpengujian)){
                        return date('d M Y', strtotime($data->tglpengujian));
                    }
                },
                'filter'=>false,  
            ),  
            array(
              'header' => 'No. Kantong Darah',
              'value' => function($data){
                    if(!empty($data->nomorbarcode_sample)){
                        return $data->nomorbarcode_sample;
                    }
              },
            ),

            array(
                'header' => 'A',
                'value' => function($data){
                    if(!empty($data->gol_darah_awal)){

                        if(strtoupper($data->gol_darah_awal)=="A"){
                            echo $data->gol_darah_awal;
                        }
                    }
                },
            ),
            array(
                'header' => 'B',
                'value' => function($data){
                    if(!empty($data->gol_darah_awal)){

                        if(strtoupper($data->gol_darah_awal)=="B"){
                            echo $data->gol_darah_awal;
                        }
                    }
                },
            ),
            array(
                'header' => 'O',
                'value' => function($data){
                    if(!empty($data->gol_darah_awal)){

                        if(strtoupper($data->gol_darah_awal)=="O"){
                            echo $data->gol_darah_awal;
                        }
                    }
                },
            ),
            array(
                'header' => 'AB',
                'value' => function($data){
                    if(!empty($data->gol_darah_awal)){

                        if(strtoupper($data->gol_darah_awal)=="AB"){
                            echo $data->gol_darah_awal;
                        }
                    }
                },
            ),
            array(
                'header' => 'Pos',
                'value' => function($data){
                    if(!empty($data->rhesus_awal)){
                        if(strtoupper($data->rhesus_awal)=="POSITIF" || strtoupper($data->rhesus_awal)=="RH+"){
                            echo "Pos";
                        }
                    }
                },
            ),
            array( 
                'header' => 'Neg',
                'value' => function($data){
                    if(!empty($data->rhesus_awal)){
                        if(strtoupper($data->rhesus_awal)=="NEGATIF" ||  strtoupper($data->rhesus_awal)=="RH-"){
                            echo "Neg";
                        }
                    }
                },
            ),
            array(
                'header' => 'A',
                'value' => function($data){
                    if(!empty($data->gol_darah)){

                        if(strtoupper($data->gol_darah)=="A"){
                            echo $data->gol_darah;
                        }
                    }
                },
            ),
            array(
                'header' => 'B',
                'value' => function($data){
                    if(!empty($data->gol_darah)){

                        if(strtoupper($data->gol_darah)=="B"){
                            echo $data->gol_darah;
                        }
                    }
                },
            ),
            array(
                'header' => 'O',
                'value' => function($data){
                    if(!empty($data->gol_darah)){

                        if(strtoupper($data->gol_darah)=="O"){
                            echo $data->gol_darah;
                        }
                    }
                },
            ),
            array(
                'header' => 'AB',
                'value' => function($data){
                    if(!empty($data->gol_darah)){

                        if(strtoupper($data->gol_darah)=="AB"){
                            echo $data->gol_darah;
                        }
                    }
                },
            ),
            array(
                'header' => 'Pos',
                'value' => function($data){
                    if(!empty($data->rhesus)){
                        if(strtoupper($data->rhesus)=="POSITIF" || strtoupper($data->rhesus)=="RH+"){
                            echo "Pos";
                        }
                    }
                },
            ),
            array( 
                'header' => 'Neg',
                'value' => function($data){
                    if(!empty($data->rhesus)){
                        if(strtoupper($data->rhesus)=="NEGATIF" ||  strtoupper($data->rhesus)=="RH-"){
                            echo "Neg";
                        }
                    }
                },
            ),
            array( 
                'header' => 'Keterangan',
                'value' => function($data){
                    if(!empty($data->hasil_uji)){
                        echo $data->hasil_uji;
                    }
                },
            ),      
	),
    )); 
?>
<?php if ($caraPrint == 'PDF') { ?>
<br>
<div class="ttd">
    <table style="width:100%">
        <tr>
            <td width="50%" style="text-align: left"> Penanggung Jawab<br>Koordinator Pelayanan Donor<br><br><br><br><br><br><br></td>
            <td width="50%" style="text-align: right"> Surabaya, <?php echo date('d ').MyFormatter::getMonthId(date('m')).date(' Y');  ?><br>Petugas Pelaksana<br><br><br><br><br><br><br> </td>
        </tr>
        <tr>
            <td width="50%" style="text-align: left;">Rosa Rusdiana, Amd.Kep</td>
            <td width="50%" style="text-align: right"></td>
        </tr>
        <tr>
            <td width="50%" style="text-align: left;">NIP. 19661219 198903 2 007</td>
            <td width="50%" style="text-align: right"></td>
        </tr>
    </table>
</div>
<?php } ?>