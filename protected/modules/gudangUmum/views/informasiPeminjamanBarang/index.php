<?php
/**
 * @author Aida Rahmawati <aidarahmawati@.com>
 */
Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#informasipeminjamanbrg-r-search').submit(function(){
            $.fn.yiiGridView.update('informasipeminjamanbrg-r-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title"><i class="entypo-info-circled"></i> Informasi <strong> Peminjaman Barang </strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-credit-card"></i> Tabel <strong> Peminjaman Barang </strong></div>
                    </div>
                    <div class="panel-body overflow-x" >
                        <?php
                       $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'informasipeminjamanbrg-r-grid',
                            'dataProvider' => $model->searchInformasi(),
                            'template' => "{summary}\n{items}\n{pager}",
                            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                            'columns' => array(
                                array(
                                    'header'=>'No.',
                                    'value' => '($this->grid->dataProvider->pagination) ? 
                                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                    : ($row+1)',
                                    'type'=>'raw',
                                    'htmlOptions'=>array('style'=>'text-align:left;'),
                                ),
                                array(
                                    'header' => 'No. dan Tanggal Transaksi',
                                    'value' => function($data){
                                        echo CHtml::link($data->peminjamanbrg_nomor."<br>".MyFormatter::formatDateTimeForUser($data->peminjamanbrg_tanggal),Yii::app()->createUrl('/gudangUmum/InformasiPeminjamanBarang/detail&id='.$data->peminjamanbrg_nomor),
                                        array("rel"=>"tooltip","title"=>"Klik untuk Melihat Detail Peminjaman Barang","target"=>"iframe1", "onclick"=>"$('#dialogPeminjaman').dialog('open');"));
                                    }
                                ),
                                array(
                                    'header' => 'Peminjam',
                                    'value' => function($data){
                                        echo $data->nama_pegawai;
                                    }
                                ),
                                array(
                                    'header' => 'Ruangan Peminjaman',
                                    'value' => function($data){
                                        echo $data->ruangan_nama; 
                                    }
                                ),
                                array(
                                    'header' => 'Tanggal Pengembalian',
                                    'value' => function($data){
                                        if (!empty($data->pengembalian_tanggal)) {
                                            echo MyFormatter::formatDateTimeForUser($data->pengembalian_tanggal);
                                        } else {
                                            echo "  ";
                                        }
                                    }
                                ),
                                array(
                                    'header' => 'Pegawai Pengembalian',
                                    'value' => function($data){
                                        if (!empty($data->pegpengembali_id)) {
                                            echo $data->pegpengembali->nama_pegawai;
                                        } else {
                                            echo " ";
                                        }
                                    }
                                ),
                                array(
                                    'header' => 'Keperluan',
                                    'value' => '$data->peminjamanbrg_keperluan',
                                ),
                                array(
                                    'header' => 'Status Pengembalian',
                                    'value' => function($data){
                                        if (empty($data->status_pengembalian)) {
                                            echo CHtml::link("Pengembalian",Yii::app()->createUrl('/gudangUmum/InformasiPeminjamanBarang/pengembalian&id='.$data->peminjamanbrg_nomor),
                                            array("rel"=>"tooltip","title"=>"Klik untuk Mengembalikan Barang","target"=>"iframe2", "onclick"=>"$('#dialogPengembalian').dialog('open');"));
                                        } else {
                                            echo $data->status_pengembalian;
                                        }
                                    }
                                )
                            ),
                            'afterAjaxUpdate' => 'function(id, data){ubahWarna(); jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}'
                                        . ');'
                                        . ' }',
                        ));
                        
                            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                            $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
                            $url=Yii::app()->createAbsoluteUrl($module.'/'.$controller);
                        ?>
                                        </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="">
                            <?php $this->renderPartial($this->path_view.'_search',array(
                                    'model'=>$model,
                            )); ?>
                        </fieldset>
                    </div>
                </div>	
            </div>
        </div>
    </div>
</div>

<?php
// ===========================Dialog Penelitian=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogPeminjaman',
    // additional javascript options for the dialog plugin
    'options'=>array(
    'title'=>'Detail Peminjaman Barang',
    'autoOpen'=>false,
    'width'=>1100,
    'height'=>650,
    'resizable'=>true,
    'scroll'=>false,
    ),
));
?>
<iframe src="" name="iframe1" width="100%" height="100%">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Work Order================================
?>

<?php
// ===========================Dialog Penelitian=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogPengembalian',
    // additional javascript options for the dialog plugin
    'options'=>array(
    'title'=>'Pengembalian Barang',
    'autoOpen'=>false,
    'width'=>500,
    'height'=>350,
    'resizable'=>true,
    'scroll'=>false,
    'close'=>"js:function(){ $.fn.yiiGridView.update('informasipeminjamanbrg-r-grid'); }",
    ),
));
?>
<iframe src="" name="iframe2" width="100%" height="100%">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Work Order================================
?>