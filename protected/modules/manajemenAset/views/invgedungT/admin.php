<!--<div class="white-container">-->
    <?php
    $this->breadcrumbs=array(
            'Guinvgedung Ts'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Inventarisasi Gedung dan Bangunan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('guinvgedung-t-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"><i class="entypo-info-circled"></i> Informasi <b>Inventarisasi Gedung dan Bangunan</b></div>
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
                    <i class="entypo-credit-card"></i> Tabel <b>Inventarisasi Gedung dan Bangunan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">

                <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                    'id'=>'guinvgedung-t-grid',
                    'dataProvider'=>$model->search(),
                    'filter'=>$model,
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-condensed',
                    'columns'=>array(
                            array(
                                'header'=>'No',
                                'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                                'type'=>'raw',
                                'htmlOptions'=>array('style'=>'text-align:right;'),
                            ),
                            array(
                                    'name'=>'pemilikbarang_id',
                                    'filter'=> Chtml::activeDropDownList($model, 'pemilikbarang_id', CHtml::listData($model->PemilikItems, 'pemilikbarang_id', 'pemilikbarang_nama'), array('empty' => '-- Pilih --')),
                                    'value'=>'$data->pemilikbarang->pemilikbarang_nama',
                            ),
                                            array(
                                    'name'=>'barang_id',
                                    'filter'=> Chtml::activeDropDownList($model, 'barang_id', CHtml::listData($model->BarangItems, 'barang_id', 'barang_nama'), array('empty' => '-- Pilih --')),
                                    'value'=>'$data->barang->barang_nama',

                            ),
                                            array(
                                    'name'=>'asalaset_id',
                                    'filter'=> Chtml::activeDropDownList($model, 'asalaset_id', CHtml::listData($model->AsalAsetItems, 'asalaset_id', 'asalaset_nama'), array('empty' => '-- Pilih --')),            
                                    'value'=>'isset($data->asalaset_id)?$data->asalaset->asalaset_nama:" - "',
                            ),
                                            array(
                                    'name'=>'lokasi_id',
                                    'filter'=> Chtml::activeDropDownList($model, 'lokasi_id', CHtml::listData($model->LokasiAsetItems, 'lokasi_id', 'lokasiaset_namalokasi'), array('empty' => '-- Pilih --')),            
                                    'value'=>'isset($data->lokasi_id)?$data->lokasi->lokasiaset_namalokasi:" - "',
                            ),
                            'invgedung_kode',
                            'invgedung_namabrg',
                            'invgedung_kontruksi',
                            'invgedung_luaslantai',
                            'invgedung_alamat',
                            'invgedung_nodokumen',
                            'invgedung_harga',
                            array(
                                    'header'=>Yii::t('zii','View'),
                                    'class'=>'bootstrap.widgets.BootButtonColumn',
                                    'template'=>'{view}',
                                    'buttons'=>array(
                                       'view' => array(
                                                     'options'=>array('rel' => 'tooltip' , 'title'=> 'Lihat inventarisasi gedung dan bangunan' ),
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
                                                      'options'=>array('rel' => 'tooltip' , 'title'=> 'Ubah inventarisasi gedung dan bangunan' ),
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
                                                            'options'=>array('rel' => 'tooltip' , 'title'=> 'Hapus inventarisasi gedung dan bangunan' ),
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
        $("input[name='MAInvgedungT[invgedung_kode]']").focus();
    });
</script>