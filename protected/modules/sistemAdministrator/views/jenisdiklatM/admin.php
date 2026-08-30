<?php
$this->breadcrumbs = array(
    'Pengaturan Jenis Diklat',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('kpjenisdiklat-m-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Jenis Diklat</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            )); ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Jenis Diklat</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'kpjenisdiklat-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
                                        ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                        : ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        'jenisdiklat_nama',
                        'jenisdiklat_deskripsi',
                        array(
                            'name' => 'jenisdiklat_aktif',
                            'type' => 'raw',
                            'filter' => false,
                            'value' => '(($data->jenisdiklat_aktif)?"Aktif":"Tidak Aktif")',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(),
                            ),
                        ),
                        array(
                            'header' => 'Ubah',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(),
                            ),
                        ),
                        //			array(
                        //			   'header'=>Yii::t('zii','Delete'),
                        //                            'class'=>'bootstrap.widgets.BootButtonColumn',
                        //				'template'=>'{remove} {delete}',
                        //                            'buttons'=>array(
                        //                                    'remove' => array (
                        //                                                    'label'=>"<i class='icon-form-silang'></i>",
                        //							'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                        //                                                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->jenisdiklat_id))',
                        //                                                    'click'=>'function(){nonActive(this);return false;}',
                        //                                    ),
                        //                                    'delete'=> array(),
                        //                            )
                        //			),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->jenisdiklat_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->jenisdiklat_id)",array("id"=>"$data->jenisdiklat_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->jenisdiklat_id)",array("id"=>"$data->jenisdiklat_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->jenisdiklat_id)",array("id"=>"$data->jenisdiklat_id","rel"=>"tooltip","title"=>"Hapus"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
                                jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                                $("table").find("input[type=text]").each(function(){
                                    cekForm(this);
                                })
                            }',
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Jenis Diklat', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah jenis diklat', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial($this->path_view . 'tips/master', array(), true);
            $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);
            $js = <<< JSCRIPT
                function print(caraPrint){
                    window.open("${urlPrint}/"+$('#kpjenisdiklat-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
                }
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>

<!--<h6 class="rim2">Tabel Jenis Diklat</h6>-->
<!--</div>-->
<!--/div-->
<script type="text/javascript">
    function cekForm(obj) {
        $("#kpjenisdiklat-m-search :input[name='" + obj.name + "']").val(obj.value);
    }

    function removeTemporary(id) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';

        myConfirm('Yakin akan menonaktifkan data ini untuk sementara?', 'Perhatian!',
            function(r) {
                if (r) {
                    $.post(url, {
                            id: id
                        },
                        function(data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('kpjenisdiklat-m-grid');
                            } else {
                                myAlert('Data gagal dinonaktifkan!')
                            }
                        }, "json");
                }
            });
    }

    function deleteRecord(id) {
        var id = id;
        var url = '<?php echo $url . "/delete"; ?>';
        myConfirm('Yakin Akan Menghapus Data ini?', 'Perhatian!',
            function(r) {
                if (r) {
                    $.post(url, {
                            id: id
                        },
                        function(data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('kpjenisdiklat-m-grid');
                            } else {
                                myAlert('Data gagal dihapus!')
                            }
                        }, "json");
                }
            });
    }
</script>