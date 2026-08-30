<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Informasi <b>Inventarisasi Peralatan dan Mesin</b></div>
    </div>
        <div class="panel-body">
    <?php
    $this->breadcrumbs=array(
            'Guinvperalatan Ts'=>array('index'),
            'Manage',
        );
        $arrMenu = array();
        // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Inventarisasi Peralatan dan Mesin ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' MAInvperalatanT', 'icon'=>'list', 'url'=>array('index'))) ;
        //(Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Inventarisasi Peralatan dan Mesin', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        $this->menu = $arrMenu;
        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('guinvperalatan-t-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <div class="search-form">
                    <?php $this->renderPartial('_search', array('model' => $model,)); ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Tabel <b>Inventarisasi Peralatan dan Mesin</b></div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'guinvperalatan-t-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'columns' => array(
                        ////'invperalatan_id',
                        array(
                            'header' => 'No.',
                            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:right;'),
                        ),
                        array(
                            'name' => 'pemilikbarang_id',
                            'filter' => Chtml::activeDropDownList($model, 'pemilikbarang_id', CHtml::listData($model->PemilikItems, 'pemilikbarang_id', 'pemilikbarang_nama'), array('empty' => '-- Pilih --')),
                            'value' => '$data->pemilik->pemilikbarang_nama',
                        ),
                        array(
                            'name' => 'barang_id',
                            //                            'filter'=>  CHtml::listData($model->BarangItems, 'barang_id', 'barang_nama'),
                            'filter' => Chtml::activeDropDownList($model, 'barang_id', CHtml::listData($model->BarangItems, 'barang_id', 'barang_nama'), array('empty' => '-- Pilih --')),
                            'value' => '$data->barang->barang_nama',
                        ),
                        array(
                            'name' => 'asalaset_id',
                            //                            'filter'=>  CHtml::listData($model->AsalAsetItems, 'asalaset_id', 'asalaset_nama'),
                            'filter' => Chtml::activeDropDownList($model, 'asalaset_id', CHtml::listData($model->AsalAsetItems, 'asalaset_id', 'asalaset_nama'), array('empty' => '-- Pilih --')),
                            'value' => 'isset($data->asalaset_id)?$data->asal->asalaset_nama:" - "',
                        ),
                        array(
                            'name' => 'lokasi_id',
                            //                            'filter'=>  CHtml::listData($model->LokasiAsetItems, 'lokasi_id', 'lokasiaset_namalokasi'),
                            'filter' => Chtml::activeDropDownList($model, 'lokasi_id', CHtml::listData($model->LokasiAsetItems, 'lokasi_id', 'lokasiaset_namalokasi'), array('empty' => '-- Pilih --')),
                            'value' => 'isset($data->lokasi_id)?$data->lokasi->lokasiaset_namalokasi:" - "',
                        ),
                        'invperalatan_kode',
                        //'invperalatan_noregister',
                        'invperalatan_namabrg',
                        //'invperalatan_merk',
                        //'invperalatan_ukuran',
                        //'invperalatan_bahan',
                        'invperalatan_thnpembelian',
                        //'invperalatan_tglguna',
                        //'invperalatan_nopabrik',
                        'invperalatan_norangka',
                        'invperalatan_nomesin',
                        'invperalatan_nopolisi',
                        'invperalatan_nobpkb',
                        //'invperalatan_harga',
                        //'invperalatan_akumsusut',
                        //'invperalatan_ket',
                        //'invperalatan_kapasitasrata',
                        //'invperalatan_ijinoperasional',
                        //'invperalatan_serftkkalibrasi',
                        //'invperalatan_umurekonomis',
                        //'invperalatan_keadaan',
                        //'create_time',
                        //'update_time',
                        //'create_loginpemakai_id',
                        //'update_loginpemakai_id',
                        //'create_ruangan',
                        array(
                            'header' => Yii::t('zii', 'View'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Lihat inventarisasi peralatan dan mesin'),
                                ),
                            ),
                        ),
                        array(
                            'header' => Yii::t('zii', 'Update'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah inventarisasi peralatan dan mesin'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Batal Register',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{delete}',
                            'buttons' => array(
                                'delete' => array(
                                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                    'options' => array('rel' => 'tooltip', 'title' => 'Hapus inventarisasi peralatan dan mesin'),
                                ),
                            )
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    </div>
    </div>
        <div class="panel panel-primary panel-success">
        <div class="panel-heading">
            <div class="panel-title">Pencarian</div>
        </div>
    </div>
</div>
<?php
//         echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
//         echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
//         echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
// $content = $this->renderPartial('../tips/master',array(),true);
// $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#guinvperalatan-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<script>
    $(document).ready(function(){
        $("input[name='MAInvperalatanT[invperalatan_kode]']").focus();
    });
</script>