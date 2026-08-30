<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Kasus Penyakit Obat</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Pengaturan Kasus Penyakit Obat',
        );

        $arrMenu = array();
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kasus Penyakit Obat ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
        //array_push($arrMenu,array('label'=>Yii::t('mds','List').' SANapzaM', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kasus Penyakit Obat', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
                    $('.search-button').click(function(){
                            $('.search-form').toggle();
                        $('#KasuspenyakitobatM_jeniskasuspenyakit_id').focus();
                            return false;
                    });
                    $('.search-form form').submit(function(){
                            $.fn.yiiGridView.update('rjkasuspenyakitobat-m-grid', {
                                    data: $(this).serialize()
                            });
                            return false;
                    });
                    ");
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial('_search', array('model' => $model)); ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Kasus Penyakit Obat</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGroupGridView', array(
                    'id' => 'rjkasuspenyakitobat-m-grid',
                    'dataProvider' => $model->searchKasusPenyakit(),
                    'enableSorting' => true,
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'mergeColumns' => 'jeniskasuspenyakit_nama',
                    'columns' => array(
                        array(
                            'name' => 'jeniskasuspenyakit_nama',
                            'header' => 'Jenis Kasus Penyakit',
                            'value' => '$data->jeniskasuspenyakit_nama',
                            //'filter'=>  CHtml::listData($model->JeniskasuspenyakitItems, 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'),
                            'filter' => CHtml::activeDropDownList($model, 'jeniskasuspenyakit_id', CHtml::listData(JeniskasuspenyakitM::model()->findAll('jeniskasuspenyakit_aktif=TRUE ORDER BY jeniskasuspenyakit_nama'), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'), array('empty' => '-- Pilih --')),
                            //'filter'=>CHtml::listData($model->getJeniskasuspenyakitItems(), 'jeniskasuspenyakit_id','jeniskasuspenyakit_nama'),
                        ),
                        array(
                            'name' => 'obatalkes_kode',
                            'header' => 'Kode Obat Alkes',
                            'value' => '$data->obatalkes_kode',
                            'htmlOptions' => array(
                                'style' => 'border-left:solid 1px #DDDDDD',
                            ),
                        ),
                        array(
                            'name' => 'obatalkes_nama',
                            'header' => 'Nama Obat Alkes',
                            'value' => '$data->obatalkes_nama',
                        ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'ext.bootstrap.widgets.BootButtonColumn',
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/View",array("id"=>"$data->jeniskasuspenyakit_id"))',
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Ubah',
                            'class' => 'ext.bootsrap.widgets.BootButtonColumn',
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/Update",array("id"=>"$data->jeniskasuspenyakit_id"))',
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'class' => 'ext.bootstrap.widgets.BootButtonColumn',
                            'template' => '{delete}',
                            'buttons' => array(
                                'delete' => array(
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/Delete",array("id"=>"$data->jeniskasuspenyakit_id","obatalkes"=>"$data->obatalkes_id"))',
                                ),
                            ),
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
                Yii::t('mds', '{icon} Tambah Kasus Penyakit Obat', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('kasuspenyakitobatM/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah Kasus Penyakit Obat', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('../tips/master2', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');

            $js = <<< JSCRIPT
                    function cekForm(obj){
                        $("#fakasuspenyakitobat-m-search :input[name='"+obj.name+"']").val(obj.value);
                    }
                    function print(caraPrint){
                        window.open("${urlPrint}/"+$('#fakasuspenyakitobat-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
                    }
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>