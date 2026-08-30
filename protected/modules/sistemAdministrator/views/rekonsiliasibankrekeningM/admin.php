<!--<div class='white-container'>-->
<!--<legend class='rim2'>Pengaturan <b>Rekening Rekonsiliasi Bank</b></legend>-->

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Rekening Rekonsiliasi Bank
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Jenis Penjamin Alkes Ms' => array('index'),
            'Manage',
        );

        $arrMenu = array();
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jurnal Rekening Penjamin ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jurnal Rekening Penjamin ', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
                    $('.search-button').click(function(){
                        $('.search-form').toggle();
                    $('#SARekonsiliasibankrekeningM_jenisrekonsiliasibank_nama').focus();
                        return false;
                    });
                    $('.search-form form').submit(function(){
                        $.fn.yiiGridView.update('rekonsiliasibankrek-m-grid', {
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
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Rekening Rekonsiliasi Bank</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'rekonsiliasibankrek-m-grid',
                    'dataProvider' => $model->searchRekonsiliasi(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
                        ),
                        array(
                            'header' => 'Jenis Rekonsiliasi',
                            'name' => 'jenisrekonsiliasibank_nama',
                            //                    'filter'=>CHtml::listData(CarabayarM::model()->findAll(),'carabayar_id','carabayar_nama'),
                            'value' => '$data->jenisrekonsiliasibank->jenisrekonsiliasibank_nama',
                        ),
                        array(
                            'header' => 'Rekening Debit',
                            'name' => 'rekening_debit',
                            'type' => 'raw',
                            'value' => '$this->grid->owner->renderPartial("sistemAdministrator.views.rekonsiliasibankrekeningM/_rekRekonBankD",array("saldonormal"=>"D","jenisrekonsiliasibank_id"=>$data->jenisrekonsiliasibank_id),true)',
                        ),
                        array(
                            'header' => 'Rekening Kredit',
                            'name' => 'rekeningKredit',
                            'type' => 'raw',
                            'value' => '$this->grid->owner->renderPartial("sistemAdministrator.views.rekonsiliasibankrekeningM/_rekRekonBankK",array("saldonormal"=>"K","jenisrekonsiliasibank_id"=>$data->jenisrekonsiliasibank_id),true)',
                        ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'label' => "<i class='icon-view'></i>",
                                    'options' => array('title' => Yii::t('mds', 'View')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/view",array("id"=>"$data->jenisrekonsiliasibank_id"))',
                                    //'visible'=>'($data->kabupaten_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
                                    //                                               
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{delete}',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'buttons' => array(
                                'delete' => array(
                                    'label' => "<i class='icon-delete'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Delete')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/delete",array("id"=>"$data->jenisrekonsiliasibank_id"))',
                                ),
                            )
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Rekening Rekonsiliasi Bank', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl(Yii::app()->controller->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah rekening rekonsiliasi bank', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            ?>
            <?php
            $content = $this->renderPartial('sistemAdministrator.views.tips/master2', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            //$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $urlPrint = $this->createUrl('print');

            /*$js = <<< JSCRIPT
            function print(caraPrint)
            {
                window.open("${urlPrint}/"+$('#search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
            }*/
            $js = <<< JSCRIPT
                    function print(caraPrint)
                    {
                        window.open("${urlPrint}/"+$('#jenisrekonsiliasi-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
                    }
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>

        <?php
        // Dialog buat lihat penjualan resep =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialogUbahRekeningDebitKredit',
            'options' => array(
                'title' => 'Ubah Data Rekening',
                'autoOpen' => false,
                'modal' => true,
                'minWidth' => 600,
                'height' => 400,
                'resizable' => false,
                'close' => 'js:function(){$.fn.yiiGridView.update(\'rekonsiliasibankrek-m-grid\', {})}'
            ),
        ));
        ?>
        <iframe src="" name="iframeEditRekeningDebitKredit" width="100%" height="300"></iframe>
        <?php $this->endWidget(); ?>
    </div>
</div>

<!--<h6>Tabel Jurnal <b>Rekening Penjamin</b></h6>-->

<!--</div>-->