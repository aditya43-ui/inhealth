<?php



$modBarang = new MAInvperalatanT;
$modBarang->ruangan_id = $model->ruanganasal_id;
$modBarang->default = 'kosong';

if (isset($_GET['MAInvperalatanT'])){
    $modBarang->attributes = $_GET['MAInvperalatanT'];
    $modBarang->default = isset($_GET['MAInvperalatanT']['default'])?$_GET['MAInvperalatanT']['default']:null;           
    $modBarang->peralatankecuali_id = isset($_GET['MAInvperalatanT']['peralatankecuali_id'])?$_GET['MAInvperalatanT']['peralatankecuali_id']:null;
}



$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftarperalatan-grid',
    'dataProvider' => $modBarang->searchDialogPeralatan(),
    'filter' => $modBarang,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        ////'pegawai_id',
         array(
            'header' => 'Pilih',
            'type' => 'raw',             
            'value' => function($data) {
                $res = CJSON::encode($data->attributes);
    
                return CHtml::Link("<i class='icon-form-check'></i>","#",array("class"=>"btn-small", 
                                "id" => "selectBahan",
                                "onClick" => "
                                    setPeralatan(".$res.",'');
                                    $('#dialogPeralatan').dialog('close');
                                    return false;"));
            },
            'filter'=> CHtml::activeHiddenField($modBarang, 'lokasi_id').CHtml::activeHiddenField($modBarang, 'peralatankecuali_id', array(
                'id'=>'peralatankecuali_id'
            )),
        ),
        array( 
            'header'=>'Nomor Aset',
            'value' => '$data->invperalatan_kode',
            'filter' => CHtml::activeTextField($modBarang, 'invperalatan_kode').
            CHtml::activeHiddenField($modBarang, 'ruangan_id', array('id'=>'barang_ruangan_id')),
        ), 
        array( 
            'header'=>'Nama Aset',
            'value' => '$data->invperalatan_namabrg',
            'filter' => CHtml::activeTextField($modBarang, 'invperalatan_namabrg'),
        ), 
        array( 
            'header'=>'Pemilik Aset',
            'value' => '$data->pemilik->pemilikbarang_nama',
            'filter' => CHtml::activeDropDownList($modBarang, 'pemilikbarang_id', 
                CHtml::listData(PemilikbarangM::model()->findAll('pemilikbarang_aktif = true order by pemilikbarang_nama'), 'pemilikbarang_id', 'pemilikbarang_nama'), array(
                    'empty'=>'-- Pilih --'
                )),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
                
    . '}',
));
        
?>