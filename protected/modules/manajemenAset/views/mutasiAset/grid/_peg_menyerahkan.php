
<?php

$modPegawai = new PegawaiV('search');
$modPegawai->unsetAttributes();    


if (isset($_GET['PegawaiV'])) {
    $modPegawai->attributes = $_GET['PegawaiV'];
    $modPegawai->jabatan_nama = isset($_GET['PegawaiV']['jabatan_nama'])?$_GET['PegawaiV']['jabatan_nama']:null;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaiserah-grid',
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
                return CHtml::Link('<i class="icon-form-check"></i>',"#",array("class"=>"btn-small", 
                                "id" => "selectBahan",
                                "onClick" => "
                                    $('#" . Chtml::activeId($model, 'pegmenyerahkan_nama') . "').val('".$data->nama_pegawai."');
                                    $('#" . Chtml::activeId($model, 'pegmenyerahkan_id') . "').val(".$data->pegawai_id.");
                                    $('#pegawaikecuali_menyerahkan').val(".$data->pegawai_id.");
                                    $.fn.yiiGridView.update('pegawaiterima-grid', {data: $('#pegawaiterima-grid :input').serialize()});
                                    $('#dialogPegawaiMenyerahkan').dialog('close');
                                    $('#MutasiasetT_pegmenyerahkan_nama').blur();
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
                . '$(".numbers-only").keyup(function(){'
                . 'setNumbersOnly(this);'
                . '});'
                . '$(".hurufs-only").keyup(function(){'
                . 'setHurufsOnly(this);'
                . '});'                    
                . '}',
));

?>
      

