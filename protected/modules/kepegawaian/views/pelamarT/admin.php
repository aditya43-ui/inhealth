<?php $linkHalaman = CustomFunction::getUrlByMenuID(942); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Pelamar',
);
$arrMenu = array();
(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'List') . ' Data Pelamar ', 'header' => true, 'itemOptions' => array('class' => 'heading-master'))) :  '';
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' PelamarT', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' PelamarT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
$this->menu = $arrMenu;
Yii::app()->clientScript->registerScript('search', "
    //$('.search-button').click(function(){
    //	$('.search-form').toggle();
    //	return false;
    //});
    $('#pelamar-t-search').submit(function(){
            $.fn.yiiGridView.update('pelamar-t-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); 
?>
<!--<div class="cari-lanjut search-form">-->
<!--</div> search-form-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pelamar</b>
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
                <?php $this->renderPartial('_search', array('model' => $model,)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pelamar</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'pelamar-t-grid',
                    'dataProvider' => $model->searchInfoPelamar(),
                    //	'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        ////'pelamar_id',
                        array(
                            'header' => 'No.',
                            'value' => '$row+1',
                            // 'value' => '$data->pelamar_id',
                            //                        'filter'=>false,
                        ),
                        array(
                            'header' => 'Tanggal Lowongan',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tgllowongan)'
                        ),
                        array(
                            'header' => 'Tanggal Lamaran Masuk',
                            'value' => function ($data) {
                                $data->tglmelamar = MyFormatter::formatDateTimeForDb($data->tglmelamar);
                                return (!empty($data->tglmelamar) ? MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($data->tglmelamar))) : "-");
                            }
                        ),
                        array(
                            'header' => 'Sumber Informasi Lowongan',
                            'value' => '$data->asalpelamar'
                        ),
                        'nama_pelamar',
                        array(
                            'header' => 'Tempat dan Tanggal Lahir',
                            'value' => '$data->tempatlahir_pelamar.", ".MyFormatter::formatDateTimeForUser($data->tgl_lahirpelamar)'
                        ),
                        'jeniskelamin',
                        'alamat_pelamar',
                        array(
                            'header' => 'No. Telepon / No HP',
                            'value' => '$data->nokontakpelamar',
                        ),
                        'alamatemail',
                        array(
                            'header' => 'Status Perkawinan/ Jml Anak',
                            'value' => '$data->statuskawin',
                        ),
                        array(
                            'header' => 'Jenis Tenaga Kerja',
                            'value' => '$data->minatpekerjaan',
                        ),
                        array(
                            'header' => 'Pendidikan',
                            'value' => '$data->pendidikannama',
                        ),
                        // array(
                        //     'header' => 'Status Penilaian',
                        //     'type' => 'raw',
                        //     'value' => function ($data) {
                        //         if (!empty($data->statuspenilaian)) {
                        //             return $data->statuspenilaian;
                        //         } else {
                        //             echo CHtml::dropDownList('statuspenilaian[' . $data->pelamar_id . ']', '', CHtml::listData(KPPelamarT::model()->getStatusPenilaian(), 'lookup_name', 'lookup_name'), array('class' => 'span2', 'onchange' => 'setStatusNilai(' . $data->pelamar_id . ', this.value);', 'empty' => '-- Pilih --'));
                        //         }
                        //     },
                        //     'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        // ),
                        // array(
                        //     'header' => 'Tanggal Penilaian',
                        //     'value' => '!empty($data->tanggalpenilaian) ? MyFormatter::formatDateTimeForUser($data->tanggalpenilaian) : "-"'
                        // ),
                        //		array(
                        //                        'header'=>Yii::t('zii','View'),
                        //			'class'=>'bootstrap.widgets.BootButtonColumn',
                        //                        'template'=>'{view}',
                        //		),
                        array(
                            'header' => 'Pegawai Mengetahui',
                            'type' => 'raw',
                            'value' => '(!empty($data->pegawaiMengetahui) ? $data->pegawaiMengetahui->NamaLengkap : "-").
                                                    (isset($data->mengetahui_tgl) ? "<br>".MyFormatter::formatDateTimeForUser($data->mengetahui_tgl) : 
                                                    (!isset($data->mengetahui_id)? "" :
                                                    (!isset($data->menyetujui_tgl) ? "" : CHtml::link("<icon class=\'icon-form-kontrakkarya\'></icon> ", Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ApproveMengetahui", array("pelamar_id"=>$data->pelamar_id,"frame"=>true)), array("target"=>"frameMengetahui","rel"=>"tooltip", "title"=>"Klik untuk Approve mengetahui", "onclick"=>"$(\'#dialogMengetahui\').dialog(\'open\');")))
                                                ))',
                        ),
                        array(
                            'header' => 'Pegawai Menyetujui',
                            'type' => 'raw',
                            'value' => '(!empty($data->pegawaiMenyetujui) ? $data->pegawaiMenyetujui->NamaLengkap : "-").
                                                    (isset($data->menyetujui_tgl) ? "<br>".MyFormatter::formatDateTimeForUser($data->menyetujui_tgl) : 
                                                    (isset($data->menyetujui_id) ? CHtml::link("<icon class=\'icon-form-kontrakkarya\'></icon> ", Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ApproveMenyetujui", array("pelamar_id"=>$data->pelamar_id,"frame"=>true)), array("target"=>"frameMenyetujui","rel"=>"tooltip", "title"=>"Klik untuk Approve menyetujui", "onclick"=>"$(\'#dialogMenyetujui\').dialog(\'open\');")) : "")
                                                )',
                        ),
                        array(
                            'header' => 'Detail',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-detail\'></i> ",Yii::app()->controller->createUrl("' . Yii::app()->controller->id . '/View",array("id"=>$data->pelamar_id)) ,array("title"=>"Klik untuk Lihat Detail Pelamar", "target"=>"iframe", "onclick"=>"$(\"#dialogDetailPelamar\").dialog(\"open\");", ))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Status Seleksi',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $html = "";
                                if (!empty($data->statusseleksi)) {
                                    if ($data->statusseleksi == 'Proses Seleksi') {
                                        $html = '<a class="btn btn-blue nohover">' . $data->statusseleksi . '</a>';
                                    } else if ($data->statusseleksi == 'Tidak Diterima') {
                                        $html = '<a class="btn btn-danger nohover">' . $data->statusseleksi . '</a>';
                                    } else if ($data->statusseleksi == 'Diterima') {
                                        $html = '<a class="btn btn-green nohover">' . $data->statusseleksi . '</a>';
                                        $html .= "<br/> " . CHtml::link("<i class='icon-form-kontrakkarya'></i> ", 'javascript:void(0)', array("title" => "Klik untuk Kontrak Pelamar", 'onclick' => 'myAlert("Belum Berfungsi")'));
                                    }
                                }
                                return $html;
                            },
                            'htmlOptions' => array('style' => 'text-align: center;'),
                        ),
                        array(
                            'header' => 'Status Pengangkatan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return $data->statuspengangkatan;
                            },
                            'htmlOptions' => array('style' => 'text-align: center;'),
                        ),
                        array(
                            'header' => 'Berita Acara',
                            'type' => 'raw',
                            'value' => function ($data) {
                                echo CHtml::link("<i class='icon-form-detail'></i> ", 'javascript:void(0)', array("title" => "Klik untuk Kontrak Pelamar", 'onclick' => 'myAlert("Belum Berfungsi")'));
                            },
                            'htmlOptions' => array('style' => 'text-align: center;'),
                        ),
                        // array(
                        //     'header' => 'Kontrak',
                        //     'type' => 'raw',
                        //     'value' => function ($data) {
                        //         // $cek = KPKontrakKaryawanR::model()->find("pegawai_id = '$data->pegawai_id' ");
                        //         if (isset($data->tglditerima)) {
                        //             return "PEGAWAI SUDAH DIKONTRAK";
                        //         } else {
                        //             if (!empty($data->mengetahui_tgl)) {
                        //                 echo CHtml::link("<i class='icon-form-kontrakkarya'></i> ", Yii::app()->controller->createUrl(Yii::app()->controller->id . '/KontrakPelamar', array("idPelamar" => $data->pelamar_id)), array("title" => "Klik untuk Kontrak Pelamar"));
                        //             } else {
                        //                 echo 'Menunggu Approve';
                        //             }
                        //         }
                        //     },
                        //     'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        // ),
                        //		array(
                        //                        'header'=>'Kontrak Menjadi Pegawai',
                        //			'class'=>'bootstrap.widgets.BootButtonColumn',
                        //                        'template'=>'{update}',
                        //                        'buttons'=>array(
                        //                            'update' => array (
                        //                                          'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                        //                                        ),
                        //                         ),
                        //		),
                        //		array(
                        //                        'header'=>Yii::t('zii','Delete'),
                        //			'class'=>'bootstrap.widgets.BootButtonColumn',
                        //                        'template'=>'{remove} {delete}',
                        //                        'buttons'=>array(
                        //                                        'remove' => array (
                        //                                                'label'=>"<i class='icon-form-silang'></i>",
                        //                                                'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                        //                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->pelamar_id"))',
                        //                                                //'visible'=>'($data->kabupaten_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
                        //                                                'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
                        //                                        ),
                        //                                        'delete'=> array(
                        //                                                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                        //                                        ),
                        //                        )
                        //		),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<!--/div-->
<?php
//        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class' => 'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
//        $this->widget('UserTips',array('type'=>'admin'));
//        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
//        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
//        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
//
//$js = <<< JSCRIPT
//function print(caraPrint)
//{
//    window.open("${urlPrint}/"+$('#pelamar-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
//}
//JSCRIPT;
//Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<?php
// ===========================Dialog Detail Pelamar=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailPelamar',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Pelamar',
        'autoOpen' => false,
        'zIndex' => 1003,
        'width' => 1000,
        'height' => 500,
        'resizable' => false,
        'scroll' => true
    ),
));
?>
<iframe src="" name="iframe" style="width:100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Detail Pelamar================================
?>
<!--Dialog untuk mengetahui-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogMengetahui',
    'options' => array(
        'title' => 'Approvement Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1003,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('pelamar-t-grid', {
					data: $(this).serialize()
				}); }",
    ),
));
?>
<iframe name='frameMengetahui' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<!--Dialog untuk menyetujui-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogMenyetujui',
    'options' => array(
        'title' => 'Approvement Pegawai Menyetujui',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1003,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('pelamar-t-grid', {
					data: $(this).serialize()
				}); }",
    ),
));
?>
<iframe name='frameMenyetujui' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    function setStatusNilai(id, obj) {
        if (obj != '') {
            myConfirm('apakah status penilaian ' + obj + '?', 'Perhatian!',
                function(r) {
                    if (r) {
                        $.ajax({
                            url: "<?php echo $this->createUrl('SetStatusNilai'); ?>",
                            type: "POST",
                            dataType: "json",
                            data: {
                                id: id,
                                statuspenilaian: obj
                            },
                            success: function(data) {
                                if (data.status == 'ok') {
                                    $.fn.yiiGridView.update('pelamar-t-grid');
                                } else {
                                    myAlert('Data Gagal di Update');
                                }
                            }
                        });
                    }
                });
        }
    }
</script>