<div class="panel panel-success">
    <div class="panel-body overflow-x">
        <table class="table table-bordered table-striped datatable" id="tableDetailBarang">
            <thead>
                <tr>
                    <th>Nama Aset</th>
                    <th>No. Aset/Register</th>
                    <th>Merk/Ukuran/Bahan</th>
                    <th>Tahun Beli</th>
                    <th>Keadaan Aset</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($model->isNewRecord) {
                    echo $this->renderPartial('ajaxLoadAset', array(), true); 
                } else {
                    foreach ($modDetail as $item) {
                        $inven = InvperalatanT::model()->findByPk($item->invperalatan_id);
                        echo $this->renderPartial('rowAset', array(
                            'inven'=>$inven, 'detail'=>$item
                        ), true);
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


<?php
//========= Dialog buat cari aset peralatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPeralatan',
    'options' => array(
        'title' => 'Aset Peralatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));  


$modBarang = new MAInvperalatanT;

if (isset($_GET['MAInvperalatanT'])){
    $modBarang->attributes = $_GET['MAInvperalatanT'];

    $modBarang->pemilikbarang_id = $_GET['MAInvperalatanT']['pemilikbarang_id'];
    $modBarang->invperalatan_kode = $_GET['MAInvperalatanT']['invperalatan_kode'];
    $modBarang->invperalatan_namabrg = $_GET['MAInvperalatanT']['invperalatan_namabrg'];
    $modBarang->ruangan_id = $_GET['MAInvperalatanT']['ruangan_id'];
}



$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftarperalatan-grid',
    'dataProvider' => $modBarang->searchInformasi(),
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
                                    setPeralatan(".$res.");
                                    $('#dialogPeralatan').dialog('close');
                                    return false;"));
            },
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
        
$this->endWidget();

?>






