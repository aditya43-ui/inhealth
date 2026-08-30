<?php $linkHalaman = CustomFunction::getUrlByMenuID(2825); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Pemesanan Ambulans',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pemesanan Ambulans</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function(){
        $.fn.yiiGridView.update('pesanambulans-t-grid', {
            data: $(this).serialize()
        });
        return false;
    });
    ");
        ?>
        <?php $this->renderPartial('_searchPemesanan', array('modPemesanan' => $modPemesanan, 'format' => $format)) ?>
        <div class="panel panel-success">
            <?php $this->renderPartial('_searchPemesanan', array('modPemesanan' => $modPemesanan, 'format' => $format)) ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pemesanan Ambulans</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'pesanambulans-t-grid',
                    'dataProvider' => $modPemesanan->search(),
                    //'filter'=>$modPemesanan,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'columns' => array(
                        ////'pesanambulans_t',
                        //'pendaftaran_id',
                        //'mobilambulans_id',
                        //'pemakaianambulans_id',
                        //'pasien_id',
                        'pesanambulans_no',
                        'norekammedis',
                        'namapasien',
                        'tempattujuan',
                        'alamattujuan',
                        'tglpemakaianambulans',
                        'untukkeperluan',
                        'ruanganpemesan.ruangan_nama',
                        'userpemesan.nama_pemakai',
                        /*
                'tglpemesananambulans',
                'kelurahan_nama',
                'rt_rw',
                'nomobile',
                'notelepon',
                'keteranganpesan',
                'create_time',
                'update_time',
                'update_loginpemakai_id',
                'create_ruangan',
                */
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
        <?php
        //     $this->widget('bootstrap.widgets.BootButtonGroup', array(
        //                
        //                'buttons'=>array(
        //                    array('label'=>'Print', 'icon'=>'entypo-print', 'url'=>'#', 'htmlOptions'=>array('onclick'=>'print(\'PRINT\')')),
        //                    array('label'=>'', 'items'=>array(
        //                        array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'PDF\')')),
        //                        array('label'=>'EXCEL','icon'=>'icon-pdf', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'EXCEL\')')),
        //                        array('label'=>'PRINT','icon'=>'entypo-print', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'PRINT\')')),
        //                    )),       
        //                ),
        //        //        'htmlOptions'=>array('class'=>'btn')
        //            )); 
        ?>
    </div>
        <?php
    //     $this->widget('bootstrap.widgets.BootButtonGroup', array(
    //                'type'=>'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    //                'buttons'=>array(
    //                    array('label'=>'Print', 'icon'=>'icon-print icon-white', 'url'=>'#', 'htmlOptions'=>array('onclick'=>'print(\'PRINT\')')),
    //                    array('label'=>'', 'items'=>array(
    //                        array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'PDF\')')),
    //                        array('label'=>'EXCEL','icon'=>'icon-pdf', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'EXCEL\')')),
    //                        array('label'=>'PRINT','icon'=>'icon-print', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'PRINT\')')),
    //                    )),       
    //                ),
    //        //        'htmlOptions'=>array('class'=>'btn')
    //            )); 
    ?>
</div> 
</div>