<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-cogs"></i> Pengaturan <b>Peran Pemakai</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Saperanpengguna Ks' => array('index'),
            'Manage',
        );

        Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('saperanpengguna-k-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form" style="display:none;border: 1px solid #bdedbc;">
            <?php $this->renderPartial('_search', array(
                'model' => $model,
            )); ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Peran Pemakai</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--<legend class="rim">Tabel Peran Pemakai</legend>-->

                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'saperanpengguna-k-grid',
                    'dataProvider' => $model->search(),
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
                        ////'peranpengguna_id',
                        // array(
                        //                       'name'=>'peranpengguna_id',
                        //                       'value'=>'$data->peranpengguna_id',
                        //                       'filter'=>false,
                        //               ),
                        'peranpenggunanama',
                        'peranpenggunanamalain',
                        // 'peranpengguna_aktif',
                        array(
                            'name' => 'peranpengguna_aktif',
                            'value' => '($data->peranpengguna_aktif) ? "Ya" : "Tidak"',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            'filter' => false,
                        ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(),
                            ),
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Ubah',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(),
                            ),
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Hapus',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{delete}',
                            'buttons' => array(
                                'delete' => array(),
                            ),
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Klon',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-copy\'></i>",  Yii::app()->controller->createUrl("/sistemAdministrator/PeranPengguna/klon",array("id"=>$data->peranpengguna_id)) , array("title"=>"Klik untuk klon / menggandakan","target"=>"grid-frame", "onclick"=>"$(\"#grid-dialog\").dialog(\"open\");", "rel"=>"tooltip"))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Peran Pemakai', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl($this->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah peran pemakai', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('../tips/master7', array(), true);
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
    window.open("${urlPrint}/"+$('#saperanpengguna-k-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>

        <script type="text/javascript">
            function clearFrameSrc() {
                $('#grid-frame').attr('src', '');
            }

            function dialog_kertas() {
                $('#grid-klon').dialog('open');
            }
        </script>

        <?php
        /** Dialog Widget Start With IFrame **/
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'grid-dialog',
            'options' => array(
                'title' => 'Klon Peran Pemakai',
                'autoOpen' => false,
                'modal' => true,
                'width' => 400,
                'height' => 450,
                'close' => "js:function(){ 
			clearFrameSrc(); 
			$.fn.yiiGridView.update('saperanpengguna-k-grid');
		}",
            ),
        ));
        ?>
        <iframe src="" name="grid-frame" style="width:100%; height: 98%;"></iframe>
        <?php
        $this->endWidget();
        /** Dialog Widget End **/
        ?>

    </div>
</div>