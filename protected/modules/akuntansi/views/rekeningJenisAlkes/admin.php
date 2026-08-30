<?php

/**
 * - digunakan sebagai Admin jenis obat alkes
 * @author : Elham Budianto
 * @email : elhambudianto1@gmail.com
 * @wiki : ..
 **/
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Pengaturan <b>Jurnal Rekening Jenis Obat Alkes</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Jurnal Rekening Jenis Obat Alkes' => array('admin'),
            'Pengaturan',
        );

        $arrMenu = array();
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
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Jurnal Rekening Jenis Obat Alkes</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'carabayarrek-m-grid',
                    'dataProvider' => $model->search(),
                    //'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered datatable',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
                        ),
                        array(
                            'header' => 'Rekening',
                            'name' => 'rekening5_id',
                            //'filter'=>CHtml::listData(CarabayarM::model()->findAll(),'carabayar_id','carabayar_nama'),
                            'value' => '$data->rekening5->nmrekening5',
                        ),
                        array(
                            'header' => 'Saldo Normal',
                            'name' => 'debitkredit',
                            //'filter'=>CHtml::listData(CarabayarM::model()->findAll(),'carabayar_id','carabayar_nama'),
                            'value' => function ($data) {
                                if ($data->debitkredit == 'K') {
                                    return 'Kredit';
                                } else {
                                    return 'Debit';
                                }
                            },
                        ),
                        array(
                            'header' => 'Jenis Obat Alkes',
                            'name' => 'jenisobatalkes_id',
                            //'filter'=>CHtml::listData(CarabayarM::model()->findAll(),'carabayar_id','carabayar_nama'),
                            'value' => '$data->jenisobatalkes->jenisobatalkes_nama',
                        ),
                        array(
                            'header' => 'Ruangan',
                            'name' => 'ruangan_id',
                            //'filter'=>CHtml::listData(CarabayarM::model()->findAll(),'carabayar_id','carabayar_nama'),
                            'value' => function ($data) {
                                $ruanganNama = RuanganM::model()->findByPk($data->ruangan_id);
                                return $ruanganNama['ruangan_nama'];
                            },
                        ),
                        array(
                            'header' => 'Jenis Transaksi',
                            //'name'=>'ruangan_id',
                            //'filter'=>CHtml::listData(CarabayarM::model()->findAll(),'carabayar_id','carabayar_nama'),
                            'value' => function ($data) {
                                if ($data->ispenerimaanoa == TRUE) {
                                    return 'Penerimaan Faktur';
                                } else if ($data->isreturpembelian == TRUE) {
                                    return 'Retur Penerimaan Faktur';
                                } else if ($data->ispenjualanresep == TRUE) {
                                    return 'Penjualan Resep';
                                } else if ($data->isreturoa == TRUE) {
                                    return 'Retur Penjualan Resep';
                                } else if ($data->isstokberkurangoa == TRUE) {
                                    return 'Pengurangan Stok Ruangan';
                                } else if ($data->isstokopnameoaberkurang == TRUE) {
                                    return 'Stok Opname Penyesuaian Berkurang';
                                } else if ($data->isstokopnameoabertambah == TRUE) {
                                    return 'Stok Opname Penyesuaian Bertambah';
                                } else if ($data->ismutasioa == TRUE) {
                                    return 'Mutasi Ruangan';
                                } else if ($data->ispemakaianruangan == TRUE) {
                                    return 'Pemakaian Ruangan';
                                } else if ($data->ispemusnahan == TRUE) {
                                    return 'Pemusnahan';
                                } else if ($data->isbahanproduksi == TRUE) {
                                    return 'Bahan Produksi';
                                } else if ($data->ishasilproduksi == TRUE) {
                                    return 'Hasil Produksi';
                                } else {
                                    return '-';
                                }
                            },
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
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/view",array("id"=>"$data->jnsobatalkesrek_id","tab"=>"' . (isset($_GET['tab']) ? $_GET['tab'] : '') . '"))',
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
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/update",array("id"=>"$data->jnsobatalkesrek_id","tab"=>"' . (isset($_GET['tab']) ? $_GET['tab'] : '') . '"))',
                                    //     'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/update",array("id"=>"$data->lookup_name","tab"=>"'.(isset($_GET['tab'])?$_GET['tab']:'').'"))',
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
                                    'label' => "<i class='" .  MyIcon::getIcons('hapus') . "'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Delete')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/delete",array("id"=>"$data->jnsobatalkesrek_id"))',
                                    //    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/delete",array("id"=>"$data->lookup_name"))',
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
                Yii::t('mds', '{icon} Tambah Jurnal Rekening Jenis Obat Alkes', array('{icon}' => '<i class="' . MyIcon::getIcons('tambah-baris') . '"></i>')),
                $this->createUrl(Yii::app()->controller->id . '/create', array('modul_id' => Yii::app()->session['modul_id'], 'tab' => isset($_GET['tab']) ? $_GET['tab'] : '')),
                array('title' => 'Tambah jurnal rekening jenis obat alkes', 'class' => 'btn btn-danger')
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
    window.open("${urlPrint}/"+$('#search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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