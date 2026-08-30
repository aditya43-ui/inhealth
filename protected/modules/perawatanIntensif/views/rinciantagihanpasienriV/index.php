<?php
$this->breadcrumbs = array(
    'Informasi Rincian Tagihan Pasien',
);
?>

<!--div class="white-container"-->
<?php
$arrMenu = array();
$this->menu = $arrMenu;

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $('#rjrinciantagihanpasien-v-grid').addClass('animation-loading');
        $.fn.yiiGridView.update('rjrinciantagihanpasien-v-grid', {
            data: $(this).serialize()
        });
        return false;
    });
    ");

$this->widget('bootstrap.widgets.BootAlert');
?>

<?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); 
?>

<?php
//    $data[] = array(
//'rowid' => 1,
//'id' => 2,
//'name' =>3,
//'qty' => 4,
//'price' => 5,
//'subtotal' => 6
//);
//    echo print_r($data[0]['price']);
?>

<?php
$module  = $this->module->name;
$controller = $this->id;
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Rincian Tagihan Pasien</b>
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
                <!--fieldset class="box search-form"-->
                <?php $this->renderPartial('_search', array('model' => $model, 'format' => $format)); ?>
                <!--</fieldset>-->
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Rincian Tagihan Pasien</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--div class="block-tabel"-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'rjrinciantagihanpasien-v-grid',
                    'dataProvider' => $model->searchRincianTagihan(),
                    //	'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'Tanggal Pendaftaran/ <br>No. Pendaftaran',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/ <br>".$data->no_pendaftaran',
                        ),
                        array(
                            'name' => 'caramasuk_nama',
                            'type' => 'raw',
                            'value' => '$data->caramasuk_nama',
                        ),
                        array(
                            'header' => 'No. Rekam Medik',
                            'type' => 'raw',
                            'value' => '$data->no_rekam_medik',
                        ),
                        array(
                            //                    'header'=>'Nama Pasien',
                            //                    'type'=>'raw',
                            //                    'value'=>'$data->nama_pasien.\'<br>\'.$data->nama_bin',
                            'header' => 'Nama Pasien',
                            'value' => '$data->namadepan." ".$data->nama_pasien'
                        ),
                        array(
                            'header' => 'Jenis Kelamin/ <br>Umur',
                            'type' => 'raw',
                            'value' => '$data->jeniskelamin."/ <br>".$data->umur',
                        ),
                        array(
                            'header' => 'Jenis Penjamin<br>Penjamin',
                            'type' => 'raw',
                            'value' => '$data->CaraBayarPenjamin',
                        ),
                        array(
                            'name' => 'Dokter',
                            'type' => 'raw',
                            'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
                        ),
                        array(
                            'name' => 'kelaspelayanan_nama',
                            'type' => 'raw',
                            'value' => '$data->kelaspelayanan_nama',
                        ),
                        array(
                            'name' => 'jeniskasuspenyakit_nama',
                            'type' => 'raw',
                            'value' => '$data->jeniskasuspenyakit_nama',
                        ),
                        //                'nama_pegawai',
                        //                'jeniskasuspenyakit_nama',
                        /*
                                    array(
                                        'header'=>'Total Tagihan',
                                        'type'=>'raw',
                                        'value'=>'number_format($data->totaltagihan,0,\',\',\'.\')',  
                                        'htmlOptions'=>array('style'=>'text-align:right;'),
                                    ),
                                     * 
                                     */
                        array(
                            'header' => 'Status Bayar',
                            'type' => 'raw',
                            'value' => '(empty($data->pendaftaran->pembayaranpelayanan_id)) ? "Belum Lunas" : "Lunas"',
                        ),
                        array(
                            'header' => 'Rincian Tagihan',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<icon class=\'icon-form-detail\'></idcon>", Yii::app()->createUrl("billingKasir/PembayaranTagihanPasien/PrintRincianBelumBayar", array("instalasi_id"=>Yii::app()->user->getState(\'instalasi_id\'), "pendaftaran_id"=>$data->pendaftaran_id, "pasienadmisi_id"=>$data->pasienadmisi_id, "frame"=>1)), array("rel"=>"tooltip","title"=>"Lihat Rincian","target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))', 'htmlOptions' => array('style' => 'text-align:left; width:40px')
                        ),
                        // array(
                        //     'header'=>'Rincian',
                        //     'type'=>'raw',
                        //     'value'=>'CHtml::link("<icon class=\'icon-list\'></idcon>", Yii::app()->createUrl("'.$module.'/'.$controller.'/rincian", array("id"=>$data->pendaftaran_id)), array("target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))',
                        // ),		
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
                <!--/div-->
            </div>
        </div>
    </div>
</div>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRincian',
    'options' => array(
        'title' => 'Rincian Tagihan Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 550,
        'resizable' => false,
    ),
));
?>
<iframe name='frameRincian' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<!--/div-->