<?php $linkHalaman = CustomFunction::getUrlByMenuID(402); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pemesanan Barang</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Informasi Pemesanan Barang',
        );
        //
        //$arrMenu = array();
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' GUPesanbarangT ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' GUPesanbarangT', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' GUPesanbarangT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                
        //$this->menu=$arrMenu;
        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('gupesanbarang-t-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $this->renderPartial('gudangUmum.views.pesanbarangT._searchGudang', array('model' => $model,'format' => $format,)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pemesanan Barang</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'gupesanbarang-t-grid',
                    'dataProvider' => $model->searchInformasiGudang(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'replaceUrl' => true,
                    'columns' => array(
                        array(
                            'header' => 'Tgl. Pemesan',
                            'name' => 'tglpesanbarang',
                            'value' => '$data->tglpesanbarang',
                        ),
                        array(
                            'header' => 'No. Pemesan',
                            'type' => 'raw',
                            'name' => 'nopemesanan',
                            'value' => function ($data) {
                                return CHtml::link('<u>' . $data->nopemesanan . '</u>', Yii::app()->controller->createUrl("/gudangUmum/PesanbarangT/detailPesanBarang", array('id' => $data->pesanbarang_id)), array(
                                    "id" => $data->pesanbarang_id, "target" => "frameDetail", "rel" => "tooltip", "title" => "Klik untuk Detail Pemesanan Barang", "onclick" => "window.parent.$('#dialogDetail').dialog('open');"
                                ));
                            },
                        ),
                        array(
                            'header' => 'Ruangan/<br>Pegawai Pemesan',
                            'value' => '$data->ruanganpemesan->ruangan_nama." \ ".$data->pegawaipemesan->nama_pegawai'
                        ),
                        'keterangan_pesan',
                        array(
                            'header' => 'Tgl. Kirim',
                            'value' => '$data->tglmintadikirim',
                        ),
                        array(
                            'header' => 'Pegawai Pengirim',
                            'value' => function ($data) use (&$mutasi) {
                                $mutasi = MutasibrgT::model()->findAllByAttributes(array(
                                    'pesanbarang_id' => $data->pesanbarang_id
                                ));
                                if (empty($data->mutasibrg_id)) {
                                    return '-';
                                } else {
                                    $p = GUMutasibrgT::model()->findByPk($data->mutasibrg_id);
                                    return $p->pegawaipengirim->nama_pegawai;
                                }
                            }
                        ),
                        array(
                            'header' => 'Mutasi<br>Barang',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:center;'),
                            'value' => function ($data) use (&$mutasi) {
                                $str = "";
                                if (empty($data->mutasibrg_id)) {
                                    return CHtml::link("<i class='icon-form-mutasi'></i> ", Yii::app()->controller->createUrl("/gudangUmum/MutasibrgT/index", array("id" => $data->pesanbarang_id)), array("rel" => "tooltip", "title" => "Klik untuk Melanjutkan ke Mutasi"));
                                }
                                foreach ($mutasi as $item) {
                                    $str .= CHtml::link('<u>' . $item->nomutasibrg . '</u>', Yii::app()->controller->createUrl('mutasibrgT/detailMutasiBarang', array(
                                        'id' => $item->mutasibrg_id
                                    )), array(
                                        'target' => 'frameDetailMutasi',
                                        'onclick' => '$("#dialogDetailMutasi").dialog("open");'
                                    )) . '<br>';
                                }
                                $det = PesanbarangdetailT::model()->findAllByAttributes(array(
                                    'pesanbarang_id' => $data->pesanbarang_id
                                ));
                                foreach ($det as $item) {
                                    if ($item->qty_mutasi < $item->qty_pesan) {
                                        return $str . CHtml::link("<i class='icon-form-mutasi'></i> ", Yii::app()->controller->createUrl("/gudangUmum/MutasibrgT/index", array("id" => $data->pesanbarang_id)), array("rel" => "tooltip", "title" => "Klik untuk Melanjutkan ke Mutasi"));
                                    }
                                }
                                return $str;
                                // return (empty($data->mutasibrg_id))?  : "Telah Dimutasi";
                            },
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
        <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); 
        ?>
        <!--search-form-->
    </div>
    <?php
    //        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    //        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    //        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class' => 'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    //        $this->widget('UserTips',array('type'=>'admin'));
    //        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    //        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    //        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    //$js = <<< JSCRIPT
    //function print(caraPrint)
    //{
    //    window.open("${urlPrint}/"+$('#gupesanbarang-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
    //}
    //JSCRIPT;
    //Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
    <?php
    //========= Dialog untuk Melihat detail Pengajuan Bahan Makanan =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogDetail',
        'options' => array(
            'title' => 'Detail Pemesanan Barang',
            'autoOpen' => false,
            'modal' => true,
            'zIndex' => 1002,
            'width' => 750,
            'height' => 500,
            'resizable' => false,
        ),
    ));
    echo '<iframe src="" name="frameDetail" style="width: 100%; height: 98%;"></iframe>';
    $this->endWidget();
    ?>
    <?php
    //========= Dialog untuk Melihat detail Pengajuan Bahan Makanan =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogDetailMutasi',
        'options' => array(
            'title' => 'Detail Mutasi Barang',
            'autoOpen' => false,
            'modal' => true,
            'zIndex' => 1002,
            'width' => 750,
            'height' => 500,
            'resizable' => false,
        ),
    ));
    echo '<iframe src="" name="frameDetailMutasi" style="width: 100%; height: 98%;"></iframe>';
    $this->endWidget();
    ?>
</div>