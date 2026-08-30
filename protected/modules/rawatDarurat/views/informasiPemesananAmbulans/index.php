<?php
$this->breadcrumbs = array(
    'Informasi Pemesanan Ambulans'
);
Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('#pesanambulans-t-search').submit(function(){
        $.fn.yiiGridView.update('pesanambulans-t-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
?>
<div class="row">
    <div class="col-sm-12">
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
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-search"></i> Pencarian
                        </div>
                    </div>
                    <div class="panel-body">
                        <!--fieldset class="box"-->
                        <?php $this->renderPartial($this->path_view . '_searchPemesanan', array('modPemesanan' => $modPemesanan, 'format' => $format)) ?>
                        <!--</fieldset>-->
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Pemesanan Ambulans</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <!--div class="block-tabel"-->
                        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'pesanambulans-t-grid',
                            'dataProvider' => $modPemesanan->search(),
                            //'filter'=>$modPemesanan,
                            'template' => "{summary}\n{items}\n{pager}",
                            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                            'columns' => array(
                                ////'pesanambulans_t',
                                //'pendaftaran_id',
                                //'mobilambulans_id',
                                //'pemakaianambulans_id',
                                //'pasien_id',
                                array(
                                    'header' => 'Tanggal Pemesanan',
                                    'name' => 'tglpemesananambulans',
                                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglpemesananambulans)'
                                ),
                                'pesanambulans_no',
                                'norekammedis',
                                array(
                                    'header' => 'Nama Pasien',
                                    'name' => 'nama_pasien',
                                    'value' => '(isset($data->pasien)? $data->pasien->namadepan ." ".$data->pasien->nama_pasien:"")'
                                ),
                                'tempattujuan',
                                'alamattujuan',
                                array(
                                    'header' => 'Tanggal Pemakaian',
                                    'name' => 'tglpemakaianambulans',
                                    'value' => '
                                        !empty($data->tglpemakaianambulans) ? MyFormatter::formatDateTimeForUser($data->tglpemakaianambulans):"-"'
                                ),
                                'untukkeperluan',
                                'ruanganpemesan.ruangan_nama',
                                array(
                                    'header' => 'Nama Pemakai',
                                    'name' => 'create_login_pemakai',
                                    'value' => '!empty($data->userpemesan->nama_pemakai)?$data->userpemesan->nama_pemakai:"-"'
                                ),
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
                        <!--/div-->
                    </div>
                </div>
            </div>
        </div>
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
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/Print');
?>