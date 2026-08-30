<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Menu Diet</b>
        </div>
    </div>
    <div class="panel-body">
        <?php //$this->renderPartial('_tabMenu',array()); 
        ?>
        <!--<div class="biru">
        <div class="white">-->
        <?php
        $this->breadcrumbs = array(
            'Gzmenudiet Ms' => array('index'),
            'Manage',
        );
        $arrMenu = array();
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Menu Diet ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Menu Diet', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Menu Diet', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                    $('.search-form').toggle();
                $('#MenuDietM_jenisdiet_id').focus();
                    return false;
            });
            $('.search-form form').submit(function(){
                    $.fn.yiiGridView.update('menu-diet-m-grid', {
                            data: $(this).serialize()
                    });
                    return false;
            });
            ");

        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial('_search', array(
                'model' => $model,
            )); ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Menu Diet</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'menu-diet-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'template' => "{summary}\n{items}{pager}",
                    'columns' => array(
                        array(
                            'header' => 'ID',
                            'value' => '$data->menudiet_id',
                        ),
                        array(
                            'name' => 'jenisdiet_id',
                            'filter' => CHtml::dropDownList('MenuDietM[jenisdiet_id]', $model->jenisdiet_id, CHtml::listData($model->getJenisdietItems(), 'jenisdiet_id', 'jenisdiet_nama'), array('empty' => '-- Pilih --')),
                            'value' => '$data->jenisdiet->jenisdiet_nama',
                        ),
                        'menudiet_nama',
                        'menudiet_namalain',
                        'jml_porsi',
                        'ukuranrumahtangga',
                        array(
                            'header' => 'Tindakan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (isset($data->daftartindakan_id)) {
                                    $modTindakan = DaftartindakanM::model()->findByPk($data->daftartindakan_id);
                                    if (isset($modTindakan)) {
                                        return $modTindakan->daftartindakan_nama;
                                    } else {
                                        return '';
                                    }
                                } else {
                                    return '';
                                }
                            }
                        ),
                        /*
                            array(
                                'header'=>'Kelas Pelayanan',
                                'value'=>'(empty($data->kelaspelayanan_nama) ? "Tidak diset" : $data->kelaspelayanan_nama)',
                            ),
                            array(
                                'header'=>'Tarif Diet',
                                'value'=>'(empty($data->harga_tariftindakan) ? "0" : $data->harga_tariftindakan)',
                            ),
                         * 
                         */
                        array(
                            'header' => Yii::t('mds', 'View'),
                            'class' => 'ext.bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Lihat menu diet'),
                                ),
                            ),
                        ),
                        array(
                            'header' => Yii::t('mds', 'Update'),
                            'class' => 'ext.bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah menu diet'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->menudiet_id)",array("id"=>"$data->menudiet_id","rel"=>"tooltip","title"=>"Hapus menu diet"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
                        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                        $("table").find("input[type=text]").each(function(){
                            cekForm(this);
                        })
                        $("table").find("select").each(function(){
                            cekForm(this);
                        })
                    }',
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Menu Diet', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('menuDietM/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah menu diet', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('../tips/master2', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print'); //
            $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            //JSCRIPT;
            //Yii::app()->clientScript->registerScript('alert',$js,CClientScript::POS_BEGIN);

            $js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#gzmenudiat-m-search :input[name='"+ obj.name +"']").val(obj.value);
}        
function print(obj)
    {
    window.open("${urlPrint}/"+$('#gzmenudiat-m-search').serialize()+"&caraPrint="+obj,"",'location=_new, width=900px');
        
    
    }
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
            <!--</div>-->
            <script type="text/javascript">
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
                                            $.fn.yiiGridView.update('menu-diet-m-grid');
                                        } else {
                                            myAlert('Data gagal dihapus karena data digunakan oleh Master Zat Menu Diet atau Master Bahan Menu Diet atau Master Jadwal Makan atau Menu Anamesa Diet.');
                                        }
                                    }, "json");
                            }
                        });
                }
                $(document).ready(function() {
                    $("input[name='MenuDietM[menudiet_nama]']").focus();
                });
            </script>
        </div>
    </div>
</div>