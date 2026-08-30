<!--div class="white-container"-->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-layer-group"></i> Pengaturan <b>Warna Nomor</b>
                </div>
            </div>
            <div class="panel-body">
                <?php //$this->renderPartial('_tabMenu',array()); 
                ?>
                <!--<div class="biru">
                <div class="white">-->
                <?php
                $this->breadcrumbs = array(
                    'Rmwarna Nomors' => array('index'),
                    'Manage',
                );

                $arrMenu = array();
                //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Warna Nomor ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
                //array_push($arrMenu,array('label'=>Yii::t('mds','List').' RKWarnaNomor', 'icon'=>'list', 'url'=>array('index'))) ;
                //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Warna Nomor', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

                $this->menu = $arrMenu;

                Yii::app()->clientScript->registerScript('search', "
                $('.search-button').click(function(){
                        $('.search-form').toggle();
                    $('#RKWarnaNomor_warnanomorrm_angka').focus();
                        return false;
                });
                $('.search-form form').submit(function(){
                        $.fn.yiiGridView.update('rmwarna-nomor-grid', {
                                data: $(this).serialize()
                        });
                        return false;
                });
                ");

                $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
                <div class="cari-lanjut3 search-form" style="display:none; padding: 10px; border: 1px solid; ">
                    <?php $this->renderPartial('_search', array(
                        'model' => $model,
                    )); ?>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Warna Nomor</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'rmwarna-nomor-grid',
                            'dataProvider' => $model->search(),
                            'filter' => $model,
                            'template' => "{summary}\n{items}\n{pager}",
                            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                            'columns' => array(
                                ////'warnanomorrm_id',
                                array(
                                    'name' => 'warnanomorrm_id',
                                    'value' => '$data->warnanomorrm_id',
                                    'filter' => false,
                                ),
                                'warnanomorrm_angka',
                                'warnanomorrm_warna',
                                'warnanomorrm_kodewarna',
                                array(
                                    'header' => 'Status',
                                    'value' => '($data->warnanomorrm_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                                    'htmlOptions' => array('style' => 'text-align:center;'),
                                ),
                                //		array(
                                //                        'header'=>'Aktif',
                                //                        'class'=>'CCheckBoxColumn',     
                                //                        'selectableRows'=>0,
                                //                        'id'=>'rows',
                                //                        'checked'=>'$data->warnanomorrm_aktif',
                                //                ),
                                array(
                                    'header' => Yii::t('zii', 'View'),
                                    'class' => 'bootstrap.widgets.BootButtonColumn',
                                    'template' => '{view}',
                                    'buttons' => array(
                                        'view' => array(
                                            'options' => array('rel' => 'tooltip', 'title' => 'Lihat warna nomor'),
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
                                            'options' => array('rel' => 'tooltip', 'title' => 'Ubah warna nomor'),
                                        ),
                                    ),
                                ),
                                array(
                                    'header' => 'Hapus',
                                    'type' => 'raw',
                                    'value' => '($data->warnanomorrm_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->warnanomorrm_id)",array("id"=>"$data->warnanomorrm_id","rel"=>"tooltip","title"=>"Menonaktifkan warna nomor"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->warnanomorrm_id)",array("id"=>"$data->warnanomorrm_id","rel"=>"tooltip","title"=>"Hapus warna nomor")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->warnanomorrm_id)",array("id"=>"$data->warnanomorrm_id","rel"=>"tooltip","title"=>"Hapus warna nomor"));',
                                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
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
                <?php
                echo CHtml::link(Yii::t('mds', '{icon} Tambah Warna Nomor', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('warnaNomor/create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
                $content = $this->renderPartial('../tips/master', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
                $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);

                $js = <<< JSCRIPT
                function cekForm(obj){
                    $("#rmwarna-nomor-search :input[name='"+ obj.name +"']").val(obj.value);
                }
                function print(caraPrint)  {
                    window.open("${urlPrint}/"+$('#rmwarna-nomor-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
                }
JSCRIPT;
                Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
                ?>
            </div>
        </div>
    </div>
</div>

<!--<h6>Tabel <b>Warna Nomor</b></h6>-->
<!--</div>-->
<!--</div>
</div>-->
<!--/div-->
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
                            $.fn.yiiGridView.update('rmwarna-nomor-grid');
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
                            $.fn.yiiGridView.update('rmwarna-nomor-grid');
                        } else {
                            myAlert('Data gagal dihapus!')
                        }
                    }, "json");
            }
        });
    }

    $(document).ready(function() {
        $("input[name='RKWarnaNomor[warnanomorrm_angka]']").focus();
    });
</script>