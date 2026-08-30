<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPeralatan',
    'options'=>array(
        'title'=>'<span id="namaperalatan_dialog"></span>',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>600,
        'resizable'=>false,
    ),
));
$modBarang = new PeralatansterilisasiM('searchDialog');
$modBarang->unsetAttributes();
$header = '';
if(isset($_GET['PeralatansterilisasiM'])){
    $modBarang->attributes = $_GET['PeralatansterilisasiM'];    
    $modBarang->jenisperalatan = isset($_GET['PeralatansterilisasiM']['jenisperalatan'])?$_GET['PeralatansterilisasiM']['jenisperalatan']:null;
    $modBarang->nama = isset($_GET['PeralatansterilisasiM']['nama'])?$_GET['PeralatansterilisasiM']['nama']:null;
    
    if ($modBarang->jenisperalatan == Params::JENIS_PERALATAN_LINEN){
        $header = 'Linen';
    }elseif ($modBarang->jenisperalatan == Params::JENIS_PERALATAN_BARANG){
        $header = 'Barang';
    }elseif ($modBarang->jenisperalatan == Params::JENIS_PERALATAN_ALATMEDIS){
        $header = 'Alat Medis';
    }
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'peralatan-m-grid',
	'dataProvider'=>$modBarang->searchDialog(),
	'filter'=>$modBarang,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "                                        
                                        $(\'#peralatansterilisasi_id\').val($data->peralatansterilisasi_id);                                        
                                        $(\'#map_id\').val($data->map_id);                                        
                                        $(\'#namaperalatan\').val(\"$data->peralatansterilisasi_nama\");                                        
                                        $(\'#dialogPeralatan\').dialog(\'close\');
                                        return false;"
                                        ))',
                ),
                array(
                    'header'=>'Peralatan Sterilisasi',
                    'name'=>'peralatansterilisasi_nama',
                    'type'=>'raw',
                    'value'=>'$data->peralatansterilisasi_nama',
                    'filter'=>CHtml::activeHiddenField($modBarang, 'jenisperalatan',array('class' => 'dialog_jenisperalatan')).CHtml::activeTextField($modBarang, 'peralatansterilisasi_nama')                   
                ),
                array(
                    'header'=>$header,
                    'name'=>'nama',
                    'type'=>'raw',
                    'value'=>function($data){
                        $cri = new CDbCriteria();
                        $cri->addCondition(" peralatansterilisasi_id = ".$data->peralatansterilisasi_id);
                        
                            
                        $model = null;
                        if ($data->jenisperalatan == Params::JENIS_PERALATAN_LINEN){
                            $cri->select = " l.namalinen as nama, t.jmllinen as jml ";
                            $cri->join = " JOIN linen_m l ON l.linen_id = t.linen_id ";
                            $cri->addCondition(" l.linen_aktif = true ");
                            $cri->order = " namalinen ASC ";
                            $model = MaplinensterilisasiM::model()->findAll($cri);
                        }elseif ($data->jenisperalatan == Params::JENIS_PERALATAN_BARANG){
                            $cri->select = " b.barang_nama as nama, t.jmlbarang as jml ";
                            $cri->join = " JOIN barang_m b ON b.barang_id = t.barang_id ";
                            $cri->addCondition(" b.barang_aktif = true ");
                            $cri->order = " barang_nama ASC ";
                            $model = MapbarangsterilisasiM::model()->findAll($cri);
                        }elseif ($data->jenisperalatan == Params::JENIS_PERALATAN_ALATMEDIS){
                            $cri->select = " o.obatalkes_nama as nama, t.jmlalkes as jml ";
                            $cri->join = " JOIN obatalkes_m o ON o.obatalkes_id = t.obatalkes_id ";
                            $cri->addCondition(" o.obatalkes_aktif = true AND o.jenisobatalkes_id = 1");
                            $cri->order = " obatalkes_nama ASC ";
                            $model = MapalkessterilisasiM::model()->findAll($cri);
                        }
                        
                        if (!empty($model)){
                            echo "<ul>";
                            foreach($model as $det){
                                echo "<li>".$det->nama." (".$det->jml.")</li>";
                            }
                            echo "</ul>";
                        }
                    },   
                ),
               

                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>