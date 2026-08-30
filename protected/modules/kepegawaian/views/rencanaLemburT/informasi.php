<?php
$this->breadcrumbs = array(
    'Informasi Rencana Lembur',
);
$arrMenu = array();
(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => 'Informasi Rencana Lembur ', 'header' => true, 'itemOptions' => array('class' => 'heading-master'))) :  '';
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Rencana Lembur ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RencanaLemburT', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' RencanaLemburT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
$this->menu = $arrMenu;
$base = $this;
Yii::app()->clientScript->registerScript('search', "
//$('.search-button').click(function(){
//	$('.search-form').toggle();
//	return false;
//});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('rencana-lembur-t-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); 
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Rencana Lembur</b>
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
                <div class="search-form">
                    <?php $this->renderPartial($this->path_view . '_search', array('modRencanaLembur' => $modRencanaLembur,)); ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Rencana Lembur</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'rencana-lembur-t-grid',
                    'dataProvider' => $modRencanaLembur->searchInformasiRencanaLembur(),
                    //'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'replaceUrl' => true,
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        ////'rencanalembur_id',
                        array(
                            'name' => 'no',
                            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                            'header' => 'No.',
                            //                                            'filter'=>false,
                        ),
                        array(
                            'name' => 'tglrencana',
                            'value' => 'date("d M Y",strtotime($data->tglrencana))',
                            //'filter'=>false,
                        ),
                        array(
                            'name' => 'norencana',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<u>".$data->norencana."</u>",Yii::app()->controller->createUrl(Yii::app()->controller->id."/lihatdetail",
                                               array("id"=>$data->rencanalembur_id)),
                                               array("title"=>"Klik untuk Lihat Detail","target"=>"iframeLihatDetail", "onclick"=>"$(\'#dialogLihatDetail\').dialog(\'open\')", "data-toggle"=>"tooltip", "title"=>"Klik untuk melihat detail Rencana Lembur"))', //'CHtml::link("<i class=\'icon-search\'><
                            //'filter'=>false,
                        ),
                        //                                    array(
                        //                                        'name'=>'mengetahui_nama',
                        //                                        'header'=>'Mengetahui',
                        //                                        'value'=>'$data->getPegawaiAttributes($data->mengetahui_id,\'nama_pegawai\')',
                        //                    //                    'value'=>'$data->mengetahui_id',
                        //                                        'filter'=>false,
                        //                                    ),
                        array(
                            'name' => 'menyetujui_nama',
                            'type' => 'raw',
                            'header' => 'Menyetujui',
                            'value' => function ($data) {
                                $dataDialog = 'myAlert("Hanya ' . (isset($data->menyetujui_id) ? $data->getPegawaiAttributes($data->menyetujui_id, 'nama_pegawai') : "-") . ' yang bisa mengakses");';
                                if ($data->menyetujui_id == Yii::app()->user->getState('pegawai_id')) {
                                    $dataDialog = "$('#dialogMenyetujui').dialog('open');";
                                }
                                $html = (isset($data->menyetujui_id) ? $data->getPegawaiAttributes($data->menyetujui_id, 'nama_pegawai') : "-") . (isset($data->tgl_menyetujui) ? "<br>" . MyFormatter::formatDateTimeForUser($data->tgl_menyetujui) : (!isset($data->menyetujui_id) ? "" : (!isset($data->tgl_pemberitugas) ? "" : CHtml::link("<icon class='icon-form-check'></icon> ", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ApproveMenyetujui', array("rencanalembur_id" => $data->rencanalembur_id, "frame" => true)), array("target" => "frameMenyetujui", "rel" => "tooltip", "title" => "Klik untuk Approve Menyetujui", "onclick" => $dataDialog)))));
                                return $html;
                            }
                            //                                        'value'=>'(isset($data->pemberitugas_id)? $data->getPegawaiAttributes($data->menyetujui_id,\'nama_pegawai\') : "-").
                            //                                        (isset($data->tgl_menyetujui) ? "<br>".MyFormatter::formatDateTimeForUser($data->tgl_menyetujui) : 
                            //                                        (!isset($data->menyetujui_id)? "" :
                            //                                        (!isset($data->tgl_pemberitugas) ? "" : CHtml::link("<icon class=\'icon-form-check\'></icon> ", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/ApproveMenyetujui", array("rencanalembur_id"=>$data->rencanalembur_id,"frame"=>true)), array("target"=>"frameMenyetujui","rel"=>"tooltip", "title"=>"Klik untuk Approve Menyetujui", "onclick"=>"$(\'#dialogMenyetujui\').dialog(\'open\');")))
                            //                                        ))',
                            //'value'=>'$data->menyetujui_id',
                            //                                        'filter'=>false,
                        ),
                        array(
                            'name' => 'pemberitugas_nama',
                            'type' => 'raw',
                            'header' => 'Pemberi Tugas',
                            'value' => function ($data) {
                                $dataDialog = 'myAlert("Hanya ' . (isset($data->pemberitugas_id) ? $data->getPegawaiAttributes($data->pemberitugas_id, 'nama_pegawai') : "-") . ' yang bisa mengakses");';
                                if ($data->pemberitugas_id == Yii::app()->user->getState('pegawai_id')) {
                                    $dataDialog = "$('#dialogPemberiTugas').dialog('open');";
                                }
                                $html = (isset($data->pemberitugas_id) ? $data->getPegawaiAttributes($data->pemberitugas_id, 'nama_pegawai') : "-") . (isset($data->tgl_pemberitugas) ? "<br>" . MyFormatter::formatDateTimeForUser($data->tgl_pemberitugas) : (!isset($data->pemberitugas_id) ? "" : (!isset($data->pemberitugas_id) ? "" : "&nbsp;" . CHtml::link("<icon class='icon-form-kontrakkarya'></icon> ", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ApprovePemberiTugas', array("rencanalembur_id" => $data->rencanalembur_id, "frame" => true)), array("target" => "framePemberiTugas", "rel" => "tooltip", "title" => "Klik untuk Approve Pemberi Tugas", "onclick" => $dataDialog)))));
                                return $html;
                            }
                            //                                        'value'=>'(isset($data->pemberitugas_id)? $data->getPegawaiAttributes($data->pemberitugas_id,\'nama_pegawai\') : "-").
                            //                                        (isset($data->tgl_pemberitugas) ? "<br>".MyFormatter::formatDateTimeForUser($data->tgl_pemberitugas) : 
                            //                                        (isset($data->pemberitugas_id) ? CHtml::link("<icon class=\'icon-form-check\'></icon> ", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/ApprovePemberiTugas", array("rencanalembur_id"=>$data->rencanalembur_id,"frame"=>true)), array("target"=>"framePemberiTugas","rel"=>"tooltip", "title"=>"Klik untuk Approve Pemberi Tugas", "onclick"=>"$(\'#dialogPemberiTugas\').dialog(\'open\');")) : "")
                            //                                        )',
                            //'value'=>'$data->pemberitugas_id',
                            //                                        'filter'=>false,
                        ),
                        array(
                            'header' => 'Status Rencana',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $realisasi = KPRealisasiLemburT::model()->findByAttributes(array('rencanalembur_id' => $data->rencanalembur_id));
                                $tgl_menyetujui = isset($data->tgl_menyetujui) ? $data->tgl_menyetujui : "kosong";
                                $tgl_pemberitugas = isset($data->tgl_pemberitugas) ? $data->tgl_pemberitugas : "kosong";
                                $arr = array(
                                    Params::STATUS_RENCANA_LEMBUR_RENCANA => array(
                                        'col' => 'btn-primary',
                                        'sub' => array(
                                            array(
                                                'label' => '<i class="entypo-check"></i>' . Params::STATUS_RENCANA_LEMBUR_DISETUJUI,
                                                'onclick' => 'setDisetujui("' . $tgl_menyetujui . '","' . $tgl_pemberitugas . '",' . $data->rencanalembur_id . ', this, ' . $data->menyetujui_id . '); return false;'
                                            ),
                                            array(
                                                'label' => '<i class="entypo-cancel"></i>' . Params::STATUS_RENCANA_LEMBUR_DITOLAK,
                                                'onclick' => 'setTolak(' . $data->rencanalembur_id . ', this, ' . $data->pemberitugas_id . '); return false;'
                                            ),
                                        ),
                                    ),
                                    Params::STATUS_RENCANA_LEMBUR_DISETUJUI => array(
                                        'col' => 'btn-success',
                                        'sub' => !empty($realisasi) ? null :
                                            array(
                                                array(
                                                    'label' => '<i class="entypo-cancel-circled"></i>' . Params::STATUS_RENCANA_LEMBUR_BATAL,
                                                    'onclick' => 'setBatal(' . $data->rencanalembur_id . ', this, ' . $data->pemberitugas_id . '); return false;'
                                                )
                                            ),
                                    ),
                                    Params::STATUS_RENCANA_LEMBUR_DITOLAK => array(
                                        'col' => 'btn-danger',
                                    ),
                                    Params::STATUS_RENCANA_LEMBUR_BATAL => array(
                                        'col' => 'btn-danger',
                                    ),
                                );
                                $str = "";
                                $btn = CHtml::htmlButton($data->statusrencana, array(
                                    'class' => 'btn ' . $arr[$data->statusrencana]['col'],
                                    'style' => 'width: 100px',
                                ));
                                if (!empty($arr[$data->statusrencana]['sub'])) {
                                    $str .= '<div class="btn-group">';
                                    // $str .= $btn;
                                    $str .= CHtml::htmlButton($data->statusrencana, array(
                                        'class' => 'btn dropdown-toggle ' . $arr[$data->statusrencana]['col'],
                                        'data-toggle' => 'dropdown',
                                        'style' => 'width: 100px;',
                                        'title' => 'Klik untuk mengubah status Rencana.',
                                    ));
                                    $str .= '<ul class="dropdown-menu dropdown-primary" role="menu">';
                                    foreach ($arr[$data->statusrencana]['sub'] as $det) {
                                        $str .= '<li>';
                                        $str .= CHtml::link($det['label'], '#', array(
                                            'onclick' => $det['onclick'],
                                        ));
                                        $str .= '</li>';
                                    }
                                    $str .= '</ul>';
                                    $str .= '</div>';
                                } else {
                                    $str = $btn;
                                }
                                return $str;
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                        ),
                        array(
                            'header' => 'Realisasi Lembur',
                            'type' => 'raw',
                            'value' => function ($data) use ($base) {
                                if ($data->statusrencana != Params::STATUS_RENCANA_LEMBUR_DISETUJUI)
                                    return "-";
                                $realisasi = KPRealisasiLemburT::model()->findByAttributes(array('rencanalembur_id' => $data->rencanalembur_id));
                                if (!empty($realisasi)) {
                                    return CHtml::link("<u>" . $realisasi->norealisasi . "</u>", Yii::app()->controller->createUrl("realisasiLemburT" . $base->modul_sk . "/lihatDetail", array('id' => $realisasi->realisasilembur_id)), array(
                                        'target' => 'iframeRealisasiLembur', 'onclick' => "$('#dialogRealisasiLembur').dialog('open');"
                                    ));
                                }
                                return CHtml::link(
                                    "<i class='icon-form-lembur'></i>",
                                    Yii::app()->controller->createUrl(
                                        "realisasiLemburT" . $base->modul_sk . "/buat",
                                        array("id" => $data->rencanalembur_id, "frame" => 1)
                                    ),
                                    array("title" => "Klik untuk Realisasi Lembur", "target" => "iframeRealisasiLembur", "onclick" => "$('#dialogRealisasiLembur').dialog('open')")
                                );
                            },
                            //'value'=>'', //'CHtml::link("<i class=\'icon-search\'></i>",Yii::app()->controller->createUrl(Yii::app()->controller->id."/update",array("id"=>$data->karyawan_id)),array("title"=>"Klik untuk Pindah Kamar","target"=>"iframeLihatDetail", "onclick"=>"$(\"#dialogLihatDetail\").dialog(\"open\");", "rel"=>"tooltip"))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        'keterangan'
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php
//echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
//echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
//echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class' => 'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
//$this->widget('UserTips',array('type'=>'admin'));
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
$js = <<< JSCRIPT
                function print(caraPrint)
                {
                    window.open("${urlPrint}/"+$('#rencana-lembur-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
                }
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
echo $this->renderPartial($this->path_view . '_jsInformasi', array(), true);
?>
<?php
//============================ Dialog Lihat Detail =============================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogLihatDetail',
    'options' => array(
        'title' => 'Lihat Detail Rencana Lembur',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 900,
        'height' => 500,
        'resizable' => true,
    ),
));
echo '<iframe src="" name="iframeLihatDetail" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget();
//==============================================================================
?>
<?php
//============================ Dialog Lihat Detail =============================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRealisasiLembur',
    'options' => array(
        'title' => 'Realisasi Lembur',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1100,
        'height' => 640,
        'resizable' => true,
    ),
));
echo '<iframe src="" name="iframeRealisasiLembur" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget();
//==============================================================================
?>
<!--/div-->
<!--Dialog untuk Pemberi Tugas-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPemberiTugas',
    'options' => array(
        'title' => 'Approvement Pegawai Pemberi Tugas',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('rencana-lembur-t-grid', {
					data: $(this).serialize()
				}); }",
    ),
));
?>
<iframe name='framePemberiTugas' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<!--Dialog untuk menyetujui-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogMenyetujui',
    'options' => array(
        'title' => 'Approvement Pegawai Menyetujui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('rencana-lembur-t-grid', {
					data: $(this).serialize()
				}); }",
    ),
));
?>
<iframe name='frameMenyetujui' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>