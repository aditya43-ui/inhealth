<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-cogs"></i> Pengaturan <b>Tugas Pemakai</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Satugaspengguna Ks' => array('index'),
            'Manage',
        );

        Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('satugaspengguna-k-grid', {
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
                    <i class="entypo-credit-card"></i> Tabel <b>Tugas Pemakai</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--<legend class="rim">Pengaturan Tugas Pemakai</legend>-->
                <?php $this->widget('ext.bootstrap.widgets.BootGroupGridView', array(
                    'id' => 'satugaspengguna-k-grid',
                    'mergeColumns' => array('peranpengguna.peranpenggunanama', 'tugas_nama', 'tugas_namalainnya', 'controller_nama'),
                    'dataProvider' => $model->searchTugasPengguna(),
                    // 'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped datatable',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
                                ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                : ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        ////             'tugaspengguna_id',
                        //               array(
                        //               'name'=>'tugaspengguna_id',
                        //               'value'=>'$data->tugaspengguna_id',
                        //               'filter'=>false,
                        //               ),
                        array(
                            'name' => 'peranpengguna.peranpenggunanama',
                            'value' => '$data->peranpengguna->peranpenggunanama',
                            'filter' => false,
                        ),
                        'tugas_nama',
                        // 'tugas_namalainnya',

                        array(
                            'name' => 'modul_id',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $dat = TugaspenggunaK::model()->findAllByAttributes(array('tugas_nama' => $data->tugas_nama), array(
                                    'group' => 'modul_id', 'select' => 'modul_id',
                                ));
                                $str = "<ul>";
                                foreach ($dat as $item) {
                                    $str .= "<li>" . $item->modul->modul_nama . "</li>";
                                }
                                $str .= "</ul>";

                                return $str;
                                //$data->modul->modul_nama;
                            },
                            //'filter'=>CHtml::listData($model->getNamaModul(), 'modul_id', 'modul_nama')
                        ),
                        //'controller_nama',
                        //'action_nama',
                        /*
                'keterangan_tugas',
                'tugaspengguna_aktif',
                'modul_id',
                */
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{view}',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('title' => Yii::t('mds', 'View')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/view",array("id"=>"$data->tugas_nama"))',
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Ubah',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'type' => 'raw',
                            'value' => function ($data) {
                                $mod = ModulK::model()->findAll(array('condition' => 'modul_aktif = true', 'order' => 'modul_nama asc'));
                                return CHtml::dropDownList('update_modul', null, CHtml::listData($mod, 'modul_id', 'modul_nama'), array(
                                    'empty' => '-- Update --',
                                    'data-tugas' => $data->tugas_nama,
                                    'onchange' => "redirectTugas('" . $data->tugas_nama . "', this);"
                                ));
                            }
                            /*
                'class'=>'bootstrap.widgets.BootButtonColumn',
                'template'=>'{update}',
                'buttons'=>array(
                        'update' => array(
                                'options'=>array('title'=>Yii::t('mds','Ubah')),
                                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/update",array("id"=>$data->tugas_nama, "modul_id"=>$data->modul_id))',					
                                ),
                        ),
                     * 
                     */
                        ), /*
                array(
                'header'=>Yii::t('zii','Delete'),
                'class'=>'bootstrap.widgets.BootButtonColumn',
                'template'=>'{delete}',
                'buttons'=>array(
//                        'remove' => array (
//                            'label'=>"<i class='icon-form-silang-circled'></i>",
//                            'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
//                            'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>"$data->tugaspengguna_id"))',
//                            'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
//                            ),
                                                        'delete'=> array(
                                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/delete",array("id"=>"$data->tugaspengguna_id"))',
                                                        ),
                        )
        ),
                 * 
                 */
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Tugas Pemakai', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl($this->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah tugas pemakai', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('../tips/master6', array(), true);
            $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
            ?>

            <?php
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $Url = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/klon');

            $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#satugaspengguna-k-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>

        <?php $urlUpdate = Yii::app()->controller->createUrl('update'); ?>
        <script>
            function redirectTugas(tugas, id) {
                window.location.replace("<?php echo $urlUpdate; ?>&id=" + tugas + "&moduluser_id=" + $(id).val());
            }
        </script>

    </div>
</div>