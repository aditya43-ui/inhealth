<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Diagnosa Obat</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Pengaturan Diagnosa Obat',
        );

        $arrMenu = array();
        //                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Diagnosa Obat ','header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) : '';
        //                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Diagnosa Obat ','icon'=>'file','url'=>array('create'))) : '';

        $this->menu = $arrMenu;
        Yii::app()->clientScript->registerScript('search', "
                        $('.search-button').click(function(){
                            $('.search-form').toggle();
                            $('#FADiagnosaobatM_diagnosa_id').focus();
                            return false;
                        });
                        $('.search-form form').submit(function(){        
                            $.fn.yiiGridView.update('fadiagnosaobat-m-grid', {
                                data: $(this).serialize()
                            });
                            return false;
                         });
                    ");

        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial('_search', array('model' => $model,)); ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Diagnosa Obat</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGroupGridView', array(
                    'id' => 'fadiagnosaobat-m-grid',
                    'dataProvider' => $model->searchTabel(),
                    'filter' => $model,
                    'mergeColumns' => array('diagnosa_kode', 'diagnosa_id'),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'name' => 'diagnosa_kode',
                            'header' => 'Kode Diagnosa',
                            'value' => '$data->diagnosa->diagnosa_kode',
                        ),
                        array(
                            'name' => 'diagnosa_id',
                            'header' => 'Diagnosa',
                            'value' => '$data->diagnosa->diagnosa_nama',
                            'filter' => Chtml::activeTextField($model, 'diagnosa_nama', array('class' => '')),
                        ),
                        array(
                            'name' => 'obatalkes_id',
                            'header' => 'Obat Alkes',
                            'value' => '$data->obatalkes->obatalkes_nama',
                            'filter' => Chtml::activeTextField($model, 'obatalkes_nama', array('class' => '')),
                            'htmlOptions' => array(
                                'style' => 'border-left:1px solid #CCCCCC',
                            ),
                        ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'ext.bootstrap.widgets.BootButtonColumn',
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/View",array("id"=>"$data->diagnosa_id"))',
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Ubah',
                            'class' => 'ext.bootsrap.widgets.BootButtonColumn',
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/Update",array("id"=>"$data->diagnosa_id"))',
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'class' => 'ext.bootstrap.widgets.BootButtonColumn',
                            'template' => '{delete}',
                            'buttons' => array(
                                'delete' => array(
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/Delete",array("id"=>"$data->diagnosa_id","obatalkes"=>"$data->obatalkes_id"))',
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
                Yii::t('mds', '{icon} Tambah Diagnosa Obat', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('diagnosaobatM/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah Diagnosa Obat', 'class' => 'btn btn-danger',)
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
                        $("#fadiagnosaobat-m-search :input[name='"+ obj.name +"']").val(obj.value);
                    }
                    function print(caraPrint){
                        window.open("${urlPrint}/"+$('#fadiagnosaobat-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
                    }
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>