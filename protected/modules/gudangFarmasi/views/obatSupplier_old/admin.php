<div class="white-container">
    <legend class="rim2">Pengaturan <b>Obat Supplier</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Gfsupplier Ms'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Obat Supplier ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Supplier', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Obat Supplier', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            $('#GFObatSupplierM_supplier_kode').focus();    
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('gfsupplier-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut search-form">
        <?php $this->renderPartial('_search',array(
                'model'=>$model,
        )); ?>
    </div><!--search-form-->
    <!--<div class='block-tabel'>-->
<!--<h6>Tabel <b>Obat Supplier</b></h6>-->
        <?php $this->widget('ext.bootstrap.widgets.BootGroupGridView',array(
            'id'=>'gfsupplier-m-grid',
            'dataProvider'=>$model->searchObatSupplierGF(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    //        'mergeColumns' => array('supplier_nama','supplier_kode','supplier_alamat'),
            'columns'=>array(
                    array(
                        'header' => 'No.',
                        'value'=>'$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
                    ),
                    array(
                        'header'=>'Kode Supplier',
                        'type'=>'raw',
                        'name'=>'supplier_kode',
                        'filter'=>  CHtml::activeTextField($model,'supplier_kode'),
                        'value'=>'(isset($data->supplier->supplier_kode) ? $data->supplier->supplier_kode : "")',
                    ),
                    array(
                        'header'=>'Nama Supplier',
                        'type'=>'raw',
                        'name'=>'supplier_nama',
                        'value'=>'(isset($data->supplier->supplier_id) ? $data->supplier->supplier_nama : "")',
                    ),
                    array(
                        'header'=>'Alamat Supplier',
                        'type'=>'raw',
                        'name'=>'supplier_alamat',
                        'value'=>'(isset($data->supplier->supplier_alamat) ? $data->supplier->supplier_alamat : "")',
                    ),
                    array(
                        'header'=>'Nama Obat Alkes',
                        'type'=>'raw',
                        'name'=>'obatalkes_nama',
                        'value'=>'(isset($data->obatalkes->obatalkes_nama) ? $data->obatalkes->obatalkes_nama : "Tidak Diset")',
                    ),
                    array(
                        'header'=>'Satuan Kecil',
                        'type'=>'raw',
                        'name'=>'satuankecil_id',
                        'value'=>'(isset($data->satuankecil->satuankecil_nama) ? $data->satuankecil->satuankecil_nama : "Tidak Diset")',
                    ),
                    array(
                        'header'=>'Satuan Besar',
                        'type'=>'raw',
                        'name'=>'satuanbesar_id',
                        'value'=>'(isset($data->satuanbesar->satuanbesar_nama) ? $data->satuanbesar->satuanbesar_nama : "Tidak Diset")',
                    ),
                    array(
                        'header'=>'Harga Beli <br> Satuan Besar',
                        'type'=>'raw',
                        'name'=>'hargabelibesar',
                        'value'=>'(isset($data->hargabelibesar) ? $data->hargabelibesar : "Tidak Diset" )',
                    ),
                    array(
                        'header'=>'Harga Beli <br> Satuan Kecil',
                        'type'=>'raw',
                        'name'=>'hargabelikecil',
                        'value'=>'(isset($data->hargabelikecil) ? $data->hargabelikecil : "Tidak Diset")', 
                    ),
                    array(
                        'header'=>'Keringanan(%)',
                        'type'=>'raw',
                        'name'=>'diskon_persen',
                        'value'=>'(isset($data->diskon_persen) ? $data->diskon_persen : "Tidak Diset")',
                    ),
                    array(
                        'header'=>'Ppn(%)',
                        'type'=>'raw',
                        'name'=>'ppn_persen',
                        'value'=>'(isset($data->ppn_persen) ? $data->ppn_persen : "Tidak Diset")',
                    ),

    //                array(
    //                     'name'=>'obatalkes_nama',
    //                     'type'=>'raw',
    ////                     'filter'=>
    //                     'value'=>'$this->grid->getOwner()->renderPartial(\'_obatSupplier\',array(\'supplier_id\'=>$data[supplier_id],\'obatalkes_id\'=>$data[obatalkes_id]),true)',
    //                ),
                    // array(
                    //     'header' => 'Status',
                    //     'value'=>'($data->supplier->supplier_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                    //     'htmlOptions'=>array('style'=>'text-align:center;'),
                    // ),
                    array(
                            'header'=>Yii::t('zii','View'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{view}',
                            'buttons'=>array(
                                    'view' => array (
                                            'label'=>"<i class='icon-view'></i>",
                                            'options'=>array('rel'=>'tooltip','title'=>'Lihat Obat Supplier'),
                                            'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/view",array("id"=>"$data->supplier_id"))',
                                            //'visible'=>'($data->supplier->supplier_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
    //                                               
                                    ),
                            ),
                    ),
                    array(
                            'header'=>Yii::t('zii','Update'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{update}',
                            'buttons'=>array(
                                'update' => array (
                                            'options'=>array('rel'=>'tooltip','title'=>'Ubah Obat Supplier'),
    //                                          'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                            ),
                             ),
                    ),
                    array(
                            'header'=>Yii::t('zii','Delete'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{delete}',
                            'buttons'=>array(
                                            'delete'=> array(
                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Delete",array("obatalkes_id"=>"$data->obatalkes_id","supplier_id"=>"$data->supplier_id"))',
                                                'options'=>array('rel'=>'tooltip','title'=>'Hapus Obat Supplier'),
    //                                                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                            ),
                            )
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){
                jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                $("table").find("input[type=text]").each(function(){
                    cekForm(this);
                })
            }',
        )); ?>
    <!--</div>-->
    <?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Obat Supplier', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl($controller.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    $content = $this->renderPartial('../tips/master',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
function cekForm(obj)
{
    if(obj.name == 'GFSupplierM[supplier_alamat]')
    {
        $("textarea[name='"+ obj.name +"']").val(obj.value);
    }else{
        $("#gfsupplier-m-search :input[name='"+ obj.name +"']").val(obj.value);
    }
}
function print(caraPrint)
{

    window.open("${urlPrint}/"+$('#gfsupplier-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>
<script>
$('.filters #GFObatSupplierM_supplier_kode').focus();    
</script>