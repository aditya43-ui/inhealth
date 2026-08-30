<?php
$this->breadcrumbs = array(
    'Informasi Pengajuan Jasa',
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('gjpembayaranjasa-t-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
$this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pengajuan Jasa</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial($this->path_view . '_search', array('model' => $model,)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pengajuan Jasa</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="block-tabel">
                    <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); 
                    ?>
                    <!--search-form-->
                    <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'gjpembayaranjasa-t-grid',
                        'dataProvider' => $model->searchInformasi(),
                        //'filter'=>$model,
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                        'columns' => array(
                            array(
                                'header' => 'Tgl. Pengajuan/<br>No. Pengajuan',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    return CHtml::Link(
                                        "<u>" . MyFormatter::formatDateTimeForUser($data->tglbayarjasa) . '/<br>' . $data->nobayarjasa . "</u>",
                                        Yii::app()->controller->createUrl(Yii::app()->controller->id . "/lihatDetail", array("id" => $data->pembayaranjasa_id)),
                                        array(
                                            "class" => "",
                                            "target" => "iframeDetail",
                                            "onclick" => "$('#dialogDetail').dialog('open');",
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk melihat Rincian Transaksi",
                                        )
                                    );
                                }
                            ),
                            array(
                                'header' => 'Periode Jasa/<br>Sampai Dengan',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    return MyFormatter::formatDateTimeForUser($data->periodejasa) . '/<br>' . MyFormatter::formatDateTimeForUser($data->sampaidgn);
                                }
                            ),
                            array(
                                'header' => 'Jenis Jasa',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    if (empty($data->pegawai_id) && empty($data->rujukan_id)) {
                                        $cri = new CDbCriteria();
                                        $cri->select = " t.pilihjasa ";
                                        $cri->join = " JOIN pegawai_m p ON p.pegawai_id = t.pegawai_id "
                                            .     " LEFT JOIN lookup_m l ON l.lookup_value = t.pilihjasa ";
                                        $cri->addCondition(" pembayaranjasa_id = '" . $data->pembayaranjasa_id . "' ");
                                        $cri->order = " p.nama_pegawai ASC ";
                                        $peg = PembjasaperawatT::model()->findAll($cri);
                                        $res = array();
                                        $jenis = Params::getJenisJasa();
                                        foreach ($peg as $item) {
                                            $res[] = isset($jenis[$item->pilihjasa]) ? $jenis[$item->pilihjasa] : '-';
                                        }
                                        $str = "<ul>";
                                        foreach ($res as $item) {
                                            $str .= '<li>' . $item . '</li>';
                                        }
                                        $str .= '</ul>';
                                        return $str;
                                    }
                                    return empty($data->rujukandari_id) ? $data->pegawai->kelompokpegawai->kelompokpegawai_nama : '';
                                }
                            ),
                            array(
                                'header' => 'Kelompok Pegawai',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    if (empty($data->pegawai_id) && empty($data->rujukan_id)) {
                                        $cri = new CDbCriteria();
                                        $cri->select = " kp.kelompokpegawai_nama ";
                                        $cri->join = " JOIN pegawai_m p ON p.pegawai_id = t.pegawai_id "
                                            .     " LEFT JOIN kelompokpegawai_m kp ON kp.kelompokpegawai_id = p.kelompokpegawai_id ";
                                        $cri->addCondition(" pembayaranjasa_id = '" . $data->pembayaranjasa_id . "' ");
                                        $cri->order = " p.nama_pegawai ASC ";
                                        $peg = PembjasaperawatT::model()->findAll($cri);
                                        $res = array();
                                        foreach ($peg as $item) {
                                            $res[] = $item->kelompokpegawai_nama;
                                        }
                                        $str = "<ul>";
                                        foreach ($res as $item) {
                                            $str .= '<li>' . $item . '</li>';
                                        }
                                        $str .= '</ul>';
                                        return $str;
                                    }
                                    return empty($data->rujukandari_id) ? $data->pegawai->kelompokpegawai->kelompokpegawai_nama : '';
                                }
                            ),
                            array(
                                'header' => 'Jabatan',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    if (empty($data->pegawai_id) && empty($data->rujukan_id)) {
                                        $cri = new CDbCriteria();
                                        $cri->select = " kp.jabatan_nama ";
                                        $cri->join = " JOIN pegawai_m p ON p.pegawai_id = t.pegawai_id "
                                            .     " LEFT JOIN jabatan_m kp ON kp.jabatan_id = p.jabatan_id ";
                                        $cri->addCondition(" pembayaranjasa_id = '" . $data->pembayaranjasa_id . "' ");
                                        $cri->order = " p.nama_pegawai ASC ";
                                        $peg = PembjasaperawatT::model()->findAll($cri);
                                        $res = array();
                                        foreach ($peg as $item) {
                                            $res[] = $item->jabatan_nama;
                                        }
                                        $str = "<ul>";
                                        foreach ($res as $item) {
                                            $str .= '<li>' . $item . '</li>';
                                        }
                                        $str .= '</ul>';
                                        return $str;
                                    }
                                    return empty($data->rujukandari_id) ? $data->pegawai->jabatan->jabatan_nama : $data->rujukandari->spesialis;
                                }
                            ),
                            array(
                                'header' => 'Nama Pegawai Medis',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    if (empty($data->pegawai_id) && empty($data->rujukan_id)) {
                                        $cri = new CDbCriteria();
                                        $cri->select = " p.nama_pegawai ";
                                        $cri->join = " JOIN pegawai_m p ON p.pegawai_id = t.pegawai_id ";
                                        $cri->addCondition(" pembayaranjasa_id = '" . $data->pembayaranjasa_id . "' ");
                                        $cri->order = " p.nama_pegawai ASC ";
                                        $peg = PembjasaperawatT::model()->findAll($cri);
                                        $res = array();
                                        foreach ($peg as $item) {
                                            $res[] = $item->nama_pegawai;
                                        }
                                        $str = "<ul>";
                                        foreach ($res as $item) {
                                            $str .= '<li>' . $item . '</li>';
                                        }
                                        $str .= '</ul>';
                                        return $str;
                                    }
                                    return empty($data->rujukandari_id) ? $data->pegawai->NamaLengkap : $data->rujukandari->namaperujuk;
                                },
                            ),
                            array(
                                'name' => 'totaljasa',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatNumberForPrint($data->totaljasa)',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;',
                                )
                            ),
                            array(
                                'name' => 'totalbayarjasa',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatNumberForPrint($data->totalbayarjasa)',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;',
                                )
                            ),
                            array(
                                'name' => 'totaltarif',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatNumberForPrint($data->totaltarif)',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;',
                                )
                            ),
                            array(
                                'name' => 'totalsisajasa',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatNumberForPrint($data->totalsisajasa)',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;',
                                )
                            ),
                            array(
                                'header' => 'Operator',
                                'value' => function ($data) {
                                    $l = LoginpemakaiK::model()->findByPk($data->create_loginpemakai_id);
                                    if (empty($l->pegawai_id)) {
                                        return $l->nama_pemakai;
                                    } else {
                                        return $l->pegawai->namaLengkap;
                                    }
                                }
                            ),
                            /*array(
										'header'=>'Detail',
										'type'=>'raw',
										'value'=>'',          
										'htmlOptions'=>array('style'=>'text-align: center; width:40px')
									),*/
                        ),
                        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                    )); ?>
                </div>
            </div>
        </div>
        <!--fieldset class="box"-->
        <!--</fieldset>-->
    </div>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Rincian Pengajuan Jasa',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 840,
        'minHeight' => 400,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeDetail" width="100%" height="550"></iframe>
<?php
$this->endWidget();
?>