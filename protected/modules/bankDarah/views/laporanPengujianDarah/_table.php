<?php
/**
 * Digunakan sebagai Laporan Pengujian Darah
 * @author  Elham Budianto <elhambudianto1@gmail.com>
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @author  Andyka Putra<andykaputra@.com>
 **/
?>
<div>
   <?php $this->widget('ext.bootstrap.widgets.MergeHeaderGroupGridView',array(
	'id'=>'penilaianiki-indikator-m-grid',
	'dataProvider'=>$model->searchtable(),
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
        'itemsCssClass'=>'table table-bordered table-striped datatable',
        'mergeColumns'=>array('tanggal'),
        'extraRowColumns'=> array('tanggal'),
	'filter'=>$model,
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
        'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
            $("table").find("input[type=text]").each(function(){
                cekForm(this);
            })
            $("table").find("select").each(function(){
                cekForm(this);
            })
        }',
    )); ?>
</div>