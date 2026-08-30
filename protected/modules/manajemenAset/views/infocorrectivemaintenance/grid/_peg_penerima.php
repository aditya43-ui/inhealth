

<?php

$modPegawai = new PegawaiV('search');
$modPegawai->is_peg_teknisipeliharaaset = true;  


if (isset($_GET['PegawaiV'])) {
    $modPegawai->attributes = $_GET['PegawaiV'];          
    $modPegawai->jabatan_nama = isset($_GET['PegawaiV']['jabatan_nama'])?$_GET['PegawaiV']['jabatan_nama']:null;    
    $modPegawai->is_peg_teknisipeliharaaset = true;  
}


$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'teknisi-grid',
    'dataProvider' => $modPegawai->searchAllPegawai(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        ////'pegawai_id',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) use ($model) {
    
                $dt['namaLengkap'] = $data->namaLengkap;
                $dt['pegawai_id'] = $data->pegawai_id;
                $res  = json_encode($dt);
    
                return CHtml::Link('<i class="icon-form-check"></i>',"#",array("class"=>"btn-small", 
                                "id" => "selectBahan",
                                "onClick" => "
                                    setPegawai(".$res.");                                   
                                    return false;"));
            },            
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',            
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',            
        ),   
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_nama',
            'value' => function($data){
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)){
                    return $j->jabatan_nama;
                }else{
                    return '-';
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
                   
                . '}',
));


?>
