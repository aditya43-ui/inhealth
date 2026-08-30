<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Asal Rujukan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Saasal Rujukan Ms' => array('index'),
            'Manage',
        );

        $this->menu = array(
            //        array('label'=>Yii::t('mds','Manage').' Asal Rujukan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
            //	array('label'=>Yii::t('mds','List').' Asal Rujukan', 'icon'=>'list', 'url'=>array('index')),
            //	array('label'=>Yii::t('mds','Create').' Asal Rujukan', 'icon'=>'file', 'url'=>array('create')),
        );

        Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('saasal-rujukan-m-grid', {
data: $(this).serialize()
});
return false;
});
");

        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php
            $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            ));
            ?>
        </div>
        <!--search-form-->

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Asal Rujukan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--<h6>Tabel <b>Asal Rujukan</b></h6>-->
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'saasal-rujukan-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        ////'asalrujukan_id',
                        array(
                            'header' => 'No.',
                            'value' => '$row+1',
                        ),
                        array(
                            'name' => 'asalrujukan_nama',
                            'value' => '$data->asalrujukan_nama',
                            'filter' => CHtml::activeTextField($model, 'asalrujukan_nama'),
                        ),
                        'asalrujukan_institusi',
                        'asalrujukan_namalainnya',
                        //'asalrujukan_aktif',
                        array(
                            'header' => 'Status',
                            'value' => '($data->asalrujukan_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                        //                array(
                        //                        'header'=>'Aktif',
                        //                        'class'=>'CCheckBoxColumn',     
                        //                        'selectableRows'=>0,
                        //                        'id'=>'rows',
                        //                        'checked'=>'$data->asalrujukan_aktif',
                        //                ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Lihat Asal Rujukan'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Ubah',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah Asal Rujukan'),
                                ),
                            ),
                        ),
                        //		array(
                        //                        'header'=>Yii::t('zii','Delete'),
                        //			'class'=>'bootstrap.widgets.BootButtonColumn',
                        //                        'template'=>'{delete}',
                        //		),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->asalrujukan_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->asalrujukan_id)",array("id"=>"$data->asalrujukan_id","rel"=>"tooltip","title"=>"Menonaktifkan Asal Rujukan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->asalrujukan_id)",array("id"=>"$data->asalrujukan_id","rel"=>"tooltip","title"=>"Hapus Asal Rujukan")):CHtml::link("<i class=\'icon-form-check\'></i> ","javascript:addTemporary($data->asalrujukan_id, 1)",array("id"=>"$data->asalrujukan_id","rel"=>"tooltip","title"=>"Mengaktifkan Asal Rujukan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->asalrujukan_id)",array("id"=>"$data->asalrujukan_id","rel"=>"tooltip","title"=>"Hapus Asal Rujukan"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
$("table").find("input[type=text]").each(function(){
cekForm(this);
})            
}',
                ));
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Asal Rujukan', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                array(
                    'class' => 'btn btn-danger',
                    'title' => 'Tambah asal rujukan'
                )
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial($this->path_view . 'tips/tipsAdmin', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            $js = <<< JSCRIPT
function cekForm(obj)
{
$("#saasalaset-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
window.open("${urlPrint}/"+$('#saasalaset-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
            <script type="text/javascript">
                function removeTemporary(id) {
                    var url = '<?php echo $url . "/removeTemporary"; ?>';
                    myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!", function(r) {
                        if (r) {
                            $.post(url, {
                                    id: id
                                },
                                function(data) {
                                    if (data.status == 'proses_form') {
                                        $.fn.yiiGridView.update('saasal-rujukan-m-grid');
                                    } else {
                                        myAlert('Data gagal dinonaktifkan!')
                                    }
                                }, "json");
                        }
                    });
                }

                function addTemporary(id, add) {
                    var url = '<?php echo $url . "/removeTemporary"; ?>';
                    myConfirm("Anda yakin akan mengaktifkan data ini untuk sementara?", "Perhatian!", function(r) {
                        if (r) {
                            $.post(url, {
                                    id: id,
                                    add: add
                                },
                                function(data) {
                                    if (data.status == 'proses_form') {
                                        $.fn.yiiGridView.update('saasal-rujukan-m-grid');
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
                    myConfirm("Yakin Akan Menghapus Data ini?", "Perhatian!", function(r) {
                        if (r) {
                            $.post(url, {
                                    id: id
                                },
                                function(data) {
                                    if (data.status == 'proses_form') {
                                        $.fn.yiiGridView.update('saasal-rujukan-m-grid');
                                    } else {
                                        myAlert('Data gagal dihapus!')
                                    }
                                }, "json");
                        }
                    });
                }
                $('.filters #SAAsalRujukanM_asalrujukan_nama').focus();
            </script>
        </div>
    </div>
</div>