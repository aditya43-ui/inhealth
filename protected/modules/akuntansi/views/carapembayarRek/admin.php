<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Pengaturan <b>Jurnal Rekening Cara Pembayaran</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Jurnal Rekening Cara Pembayaran' => array('admin'),
            'Pengaturan',
        );

        $arrMenu = array();
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jurnal Rekening Cara Pembayaran ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jurnal Rekening Cara Pembayaran ', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        $('#AKCarapembayarRekM_carapembayaran').focus();
        return false;
    });
    $('.search-form form').submit(function(){
        $.fn.yiiGridView.update('carabayarrek-m-grid', {
            data: $(this).serialize()
        });
        return false;
    });
    ");

        $this->widget('bootstrap.widgets.BootAlert');
        // $this->renderPartial('_tabMenuCaraPembayaran',array());
        ?>
        <!--<div class="biru">
        <div class="white">-->
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial('_search', array(
                'model' => $model,
            )); ?>
        </div>
        <!--search-form-->
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Jurnal Rekening Cara Pembayaran</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'carabayarrek-m-grid',
                    'dataProvider' => $model->searchCaraPembayaran(),
                    //'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered datatable',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'value' => '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
                        ),
                        array(
                            'header' => 'Cara Pembayaran',
                            'name' => 'lookup_name',
                            //'filter'=>CHtml::listData(CarabayarM::model()->findAll(),'carabayar_id','carabayar_nama'),
                            'value' => '$data->lookup_name',
                        ),

                        array(
                            'header' => 'Rekening Debit',
                            'type' => 'raw',
                            //'name'=>'rekDebit',
                            'value' => function ($data) {
                                $de = AKCarapembayarRekM::model()->findAllByAttributes(array(
                                    'carapembayaran' => $data->lookup_value,
                                    'debitkredit' => 'D'
                                ));

                                if (empty($de)) return "-";

                                echo "<ul>";
                                foreach ($de as $d) {
                                    echo "<li>" . $d->rekening5->kdrekening5 . ' ' . $d->rekening5->nmrekening5 . "</li>";
                                }
                                echo "</ul>";
                                //return !empty($de->rekening5->nmrekening5)?$de->rekening5->nmrekening5:"-";
                            }, //'$this->grid->owner->renderPartial("_rek_debet",array("rekening5_nb"=>"D","carapembayaran"=>$data->carapembayaran),true)',
                        ),

                        array(
                            'header' => 'Rekening Kredit',
                            'type' => 'raw',
                            //'name'=>'rekKredit',
                            'value' => function ($data) {
                                $de = AKCarapembayarRekM::model()->findAllByAttributes(array(
                                    'carapembayaran' => $data->lookup_value,
                                    'debitkredit' => 'K'
                                ));

                                if (empty($de)) return "-";

                                echo "<ul>";
                                foreach ($de as $k) {
                                    echo "<li>" . $k->rekening5->kdrekening5 . ' ' . $k->rekening5->nmrekening5 . "</li>";
                                }
                                echo "</ul>";

                                //return !empty($de->rekening5->nmrekening5)?$de->rekening5->nmrekening5:"-";
                            }, //'$this->grid->owner->renderPartial("_rek_kredit",array("rekening5_nb"=>"K","carapembayaran"=>$data->carapembayaran),true)',
                        ),

                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'label' => "<i class='" .  MyIcon::getIcons('lihat') . "'></i>",
                                    'options' => array('title' => Yii::t('mds', 'View')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/view",array("id"=>"$data->lookup_name","tab"=>"' . (isset($_GET['tab']) ? $_GET['tab'] : '') . '"))',
                                    //'visible'=>'($data->kabupaten_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
                                    //                                               
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
                                    'label' => "<i class='" .  MyIcon::getIcons('ubah') . "'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Update')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/update",array("id"=>"$data->lookup_name","tab"=>"' . (isset($_GET['tab']) ? $_GET['tab'] : '') . '"))',
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{delete}',
                            'buttons' => array(
                                /* 'remove' => array (
                                                        'label'=>"<i class='icon-form-silang'></i>",
                                                        'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                                                        'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->lookup_name"))',
                                                        'visible'=>'($data->carabayar_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
                                                        'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
                                                ),*/
                                'delete' => array(
                                    'label' => "<i class='" .  MyIcon::getIcons('hapus') . "'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Delete')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/delete",array("id"=>"$data->lookup_name"))',
                                ),
                            )
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
                            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                            $("table").find("input[type=text]").each(function(){
                                cekForm(this);
                            });
                            $("table").find("select").each(function(){
                                cekForm(this);
                            });
                        }',
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Jurnal Rekening Cara Pembayaran', array('{icon}' => '<i class="' . MyIcon::getIcons('tambah-baris') . '"></i>')),
                $this->createUrl(Yii::app()->controller->id . '/create', array('modul_id' => Yii::app()->session['modul_id'], 'tab' => isset($_GET['tab']) ? $_GET['tab'] : '')),
                array('title' => 'Tambah jurnal rekening cara pembayaran', 'class' => 'btn btn-danger',)
            );

            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
                array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')
            );

            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')),
                array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')')
            );

            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')),
                array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')
            );
            ?>
            <?php
            $content = $this->renderPartial('../tips/master2', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');

            $js = <<< JSCRIPT
function cekForm(obj)
{
    $("#search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#carabayarrek-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>

    <?php
    // Dialog buat lihat penjualan resep =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogUbahRekeningDebitKredit',
        'options' => array(
            'title' => 'Ubah Data Rekening',
            'autoOpen' => false,
            'modal' => true,
            'minWidth' => 1000,
            'height' => 700,
            'resizable' => false,
            'close' => 'js:function(){
            $.fn.yiiGridView.update(\'carabayarrek-m-grid\',{})
        }',
        ),
    ));
    ?>
    <iframe src="" name="iframeEditRekeningDebitKredit" width="100%" height="650">
    </iframe>
    <?php $this->endWidget(); ?>
</div>