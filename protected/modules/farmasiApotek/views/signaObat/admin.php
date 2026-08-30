<?php
$this->breadcrumbs = array(
    'Signa Obat Ms' => array('index'),
    'Manage',
);

$arrMenu = array();
(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Signa Obat ', 'header' => true, 'itemOptions' => array('class' => 'heading-master'))) :  '';
//array_push($arrMenu,array('label'=>Yii::t('mds','List').' FALookupM', 'icon'=>'list', 'url'=>array('index'))) ;
(Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Create') . ' Signa Obat', 'icon' => 'file', 'url' => array('create'))) :  '';

//$this->menu=$arrMenu;

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
            $('#" . CHtml::activeId($model, 'lookup_name') . "').focus();
            return false;
        });
        $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('signaobat-m-gird', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Signa Obat
        </div>
    </div>
    <div class="panel-body">


        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            )); ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Signa Obat</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'signaobat-m-gird',
                    'dataProvider' => $model->search(Params::LOOKUPTYPE_SIGNA_OA),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'Signa Obat',
                            'name' => 'lookup_name',
                            'value' => '$data->lookup_name',
                        ),
                        array(
                            'header' => 'Aktif',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => '($data->lookup_aktif == true ? \'Aktif\': \'Tidak Aktif\')'
                        ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{view}',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Lihat Signa Obat'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Ubah',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{update}',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'buttons' => array(
                                'update' => array(
                                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah Signa Obat'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->lookup_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->lookup_id)",array("id"=>"$data->lookup_id","rel"=>"tooltip","title"=>"Menonaktifkan Signa Obat"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->lookup_id)",array("id"=>"$data->lookup_id","rel"=>"tooltip","title"=>"Hapus Signa Obat")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->lookup_id)",array("id"=>"$data->lookup_id","rel"=>"tooltip","title"=>"Hapus Signa Obat"));',
                            'htmlOptions' => array('style' => 'text-align: center; width:100px'),
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
                Yii::t('mds', '{icon} Tambah Signa Obat', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah signa obat', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));

            $content = $this->renderPartial($this->path_view . 'tips/tipsAdmin', array(), true);
            $this->widget('UserTips', array('content' => $content));

            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            $js = <<< JSCRIPT
    function cekForm(obj){
        $("#sediaanobatracikan-m-search :input[name='"+ obj.name +"']").val(obj.value);
    }
    function print(caraPrint){
        window.open("${urlPrint}/"+$('#sediaanobatracikan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>

<!--search-form-->
<!--<h6>Tabel <b>Signa Obat</b></h6>-->

<!--</div>-->

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
                            $.fn.yiiGridView.update('signaobat-m-gird');
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
                            $.fn.yiiGridView.update('signaobat-m-gird');
                        } else {
                            myAlert('Data gagal dihapus!')
                        }
                    }, "json");
            }
        });
    }

    $(document).ready(function() {
        $("input[name='FALookupM[lookup_name]']").focus();
    });
</script>