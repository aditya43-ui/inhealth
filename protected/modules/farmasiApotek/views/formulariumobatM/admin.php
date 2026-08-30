<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Master Formularium Obat</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Pengaturan Master Formularium Obat',
        );

        $arrMenu = array();
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Master Formularium Obat ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
        //array_push($arrMenu,array('label'=>Yii::t('mds','List').' SANapzaM', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Master Formularium Obat', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                $('.search-form').toggle();
                $('#FormulariumobatM_formulariumobat_id').focus();
                    return false;
            });
            $('.search-form form').submit(function(){
                $.fn.yiiGridView.update('formularium-m-grid', {
                        data: $(this).serialize()
                });
                return false;
            });
        ");
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial($this->path_view . '_search', array('model' => $model)); ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Master Master Formularium Obat</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'formularium-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'template' => "{summary}\n{items}\n{pager}",
                    'columns' => array(
                        array(
                            'name' => 'obatalkes_id',
                            'header' => 'Nama Obat dan Alkes',
                            'value' => '$data->obatalkes->obatalkes_nama',
                            'filter' => CHtml::activeDropDownList($model, 'obatalkes_id', CHtml::listData(ObatalkesM::model()->findAll('obatalkes_aktif = TRUE ORDER BY obatalkes_nama ASC'), 'obatalkes_id', 'obatalkes_nama'), array('empty' => '-- Pilih --')),
                        ),
                        'jenisformularium',
                        array(
                            'name' => 'carabayar_id',
                            'header' => 'Jenis Penjamin',
                            'value' => '$data->carabayar->carabayar_nama',
                            'filter' => CHtml::activeDropDownList($model, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAll('carabayar_aktif = TRUE ORDER BY carabayar_nama ASC'), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --')),
                        ),
                        array(
                            'name' => 'penjamin_id',
                            'header' => 'Penjamin',
                            'value' => '$data->penjamin->penjamin_nama',
                            'filter' => CHtml::activeDropDownList($model, 'penjamin_id', CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif = TRUE ORDER BY penjamin_nama ASC'), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --')),
                        ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Lihat diet'),
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
                                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah diet'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{delete}',
                            'buttons' => array(
                                'delete' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Hapus diet'),
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
                ));
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Master Formularium Obat', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('FormulariumobatM/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah Master Formularium Obat', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial($this->path_tips . 'master2', array(), true);
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