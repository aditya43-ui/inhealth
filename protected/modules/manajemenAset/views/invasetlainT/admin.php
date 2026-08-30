<!--<div class="white-container">-->
    <?php
    $this->breadcrumbs=array(
            'Guinvasetlain Ts'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Aset Tetap Lainnya ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
                    //array_push($arrMenu,array('label'=>Yii::t('mds','List').' MAInvasetlainT', 'icon'=>'list', 'url'=>array('index'))) ;
                    //(Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Aset Tetap Lainnya', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    //$this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('guinvasetlain-t-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"><i class="entypo-info-circled"></i> Informasi <b>Inventarisasi Aset Tetap Lainnya</b></div>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_search', array('model' => $model,)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Inventarisasi Aset Tetap Lainnya</b>
                </div>
            </div>
            <div class="panel-body table-responsive">

            <div class="block-tabel">
                <div class="panel panel-primary panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-credit-card"></i> Tabel <b>Inventarisasi Aset Tetap Lainnya</b></div>
                    </div>
                    <div class="panel-body" style="overflow-y: auto;">

                <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                    'id'=>'guinvasetlain-t-grid',
                    'dataProvider'=>$model->search(),
                    'filter'=>$model,
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-condensed',
                    'columns'=>array(
                            ////'invasetlain_id',
                            array(
                                'header'=>'No',
                                'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                                'type'=>'raw',
                                'htmlOptions'=>array('style'=>'text-align:right;'),
                            ),
                            array(
                                    'name'=>'pemilikbarang_id',
                                    'filter'=> Chtml::activeDropDownList($model, 'pemilikbarang_id', CHtml::listData($model->PemilikItems, 'pemilikbarang_id', 'pemilikbarang_nama'), array('empty' => '-- Pilih --')),
                                    'value'=>'$data->pemilik->pemilikbarang_nama',
                            ),
                                            array(
                                    'name'=>'barang_id',
        //                            'filter'=>  CHtml::listData($model->BarangItems, 'barang_id', 'barang_nama'),
                                    'filter'=> Chtml::activeDropDownList($model, 'barang_id', CHtml::listData($model->BarangItems, 'barang_id', 'barang_nama'), array('empty' => '-- Pilih --')),
                                    'value'=>'$data->barang->barang_nama',

                            ),
                                            array(
                                    'name'=>'asalaset_id',
        //                            'filter'=>  CHtml::listData($model->AsalAsetItems, 'asalaset_id', 'asalaset_nama'),
                                    'filter'=> Chtml::activeDropDownList($model, 'asalaset_id', CHtml::listData($model->AsalAsetItems, 'asalaset_id', 'asalaset_nama'), array('empty' => '-- Pilih --')),            
                                    'value'=>'isset($data->asalaset_id)?$data->asal->asalaset_nama:" - "',
                            ),
                                            array(
                                    'name'=>'lokasi_id',
        //                            'filter'=>  CHtml::listData($model->LokasiAsetItems, 'lokasi_id', 'lokasiaset_namalokasi'),
                                    'filter'=> Chtml::activeDropDownList($model, 'lokasi_id', CHtml::listData($model->LokasiAsetItems, 'lokasi_id', 'lokasiaset_namalokasi'), array('empty' => '-- Pilih --')),            
                                    'value'=>'isset($data->lokasi_id)?$data->lokasi->lokasiaset_namalokasi:" - "',
                            ),
                            'invasetlain_kode',

                            //'invasetlain_noregister',
                            'invasetlain_namabrg',
                            'invasetlain_judulbuku',
                            //'invasetlain_spesifikasibuku',
                            'invasetlain_asalkesenian',
                            'invasetlain_jumlah',
                            'invasetlain_thncetak',
                            'invasetlain_harga',
                            //'invasetlain_tglguna',
                            'invasetlain_akumsusut',
                            'invasetlain_ket',
                            //'invasetlain_penciptakesenian',
                            //'invasetlain_bahankesenian',
                            //'invasetlain_jenishewan_tum',
                            //'invasetlain_ukuranhewan_tum',
                            //'create_time',
                            //'update_time',
                            //'create_loginpemakai_id',
                            //'update_loginpemakai_id',
                            //'create_ruangan',

                            array(
                                    'header'=>Yii::t('zii','View'),
                                    'class'=>'bootstrap.widgets.BootButtonColumn',
                                    'template'=>'{view}',
                                    'buttons'=>array(
                                        'view' => array (
                                                      'options'=>array('rel' => 'tooltip' , 'title'=> 'Lihat Inventarisasi Aset Tetap' ),
                                                    ),
                                     ),
                            ),
                            array(
                                    'header'=>Yii::t('zii','Update'),
                                    'class'=>'bootstrap.widgets.BootButtonColumn',
                                    'template'=>'{update}',
                                    'buttons'=>array(
                                        'update' => array (
                                                      'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                                      'options'=>array('rel' => 'tooltip' , 'title'=> 'Ubah Inventarisasi Aset Tetap' ),
                                                    ),
                                     ),
                            ),
                            array(
                                    'header'=>'Batal Register',
                                    'class'=>'bootstrap.widgets.BootButtonColumn',
                                    'template'=>'{delete}',
                                    'buttons'=>array(
                                                     'delete'=> array(
                                                            'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                                                                                                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                                            'options'=>array('rel' => 'tooltip' , 'title'=> 'Hapus Inventarisasi Aset Tetap' ),
                                                    ),
                                    )
                            ),
                    ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                )); ?>
            </div>
        </div>
    </div>
<script>
$(document).ready(function(){
        $("input[name='MAInvasetlainT[invasetlain_kode]']").focus();
    });
</script>