<?php
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'kpinfohukumanpoinpeg-v-grid',
    'dataProvider' => $model->searchInformasi(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'No.',
            'filter' => false,
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
            'headerHtmlOptions' => array('style' => 'text-align:center')
        ),
        array(
            'header' => 'Tanggal Penilaian',
            'name' => 'tglpenilaian',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpenilaian)'
        ),
        array(
            'header' => 'Periode Penilaian',
            'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($data->periodepenilaian)))." s/d ".MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($data->sampaidengan)))'
        ),
        array(
            'header' => 'Nama Pegawai',
            'value' => '$data->namaLengkap'
        ),
        array(
            'header' => 'Jabatan',
            'value' => '$data->jabatan_nama'
        ),
        array(
            'header' => 'Unit',
            'value' => '$data->namaunitkerja'
        ),
        array(
            'header' => 'Status',
            'value' => '$data->kategoripegawai'
        ),
        array(
            'header' => 'Aspek Penilaian',
            'type' => 'raw',
            'value' => function ($data) {
                $pn = PenilaianpegawaiT::model()->findByPk($data->penilaianpegawai_id);

                return $pn->getAspekPenilaian($data->penilaianpegawai_id);
            }
        ),
        array(
            'header' => 'Nilai',
            'value' => '$data->jumlahpenilaian'
        ),
        array(
            'header' => 'Rata - Rata',
            'value' => '$data->nilairatapenilaian'
        ),
        array(
            'header' => 'Penilai',
            'type' => 'raw',
            'value' => function ($data) {
                $namapegdata = "";
                if (!empty(Yii::app()->user->getState('pegawai_id'))) {
                    $modpegData = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                    if (isset($modpegData)) {
                        $namapegdata = $modpegData->namaLengkap;
                    }
                }
                $dataDialog = 'myAlert("Hanya ' . $data->penilainama . ' yang bisa mengakses");';
                if (trim($data->penilainama) == trim($namapegdata)) {
                    $dataDialog = "$('#dialogPenilai').dialog('open');";
                }
                $html = (isset($data->penilainama) ? $data->penilainama : "-") . (isset($data->tanggal_approvepenilai) ? "<br>" . MyFormatter::formatDateTimeForUser($data->tanggal_approvepenilai) : (isset($data->penilainama) ? "&nbsp;" . CHtml::link("<icon class='icon-form-kontrakkarya'></icon> ", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ApprovePenilai', array("penilaianpegawai_id" => $data->penilaianpegawai_id, "frame" => true)), array("target" => "framePenilai", "rel" => "tooltip", "title" => "Klik untuk Approve Penilai", "onclick" => $dataDialog)) : ""));
                return $html;
            }
            //            'value' => '$data->penilainama',
            //            'value'=>'(isset($data->penilainama)? $data->penilainama : "-").
            //                (isset($data->tanggal_approvepenilai) ? "<br>".MyFormatter::formatDateTimeForUser($data->tanggal_approvepenilai) : 
            //                (isset($data->penilainama) ? CHtml::link("<icon class=\'icon-form-check\'></icon> ", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/ApprovePenilai", array("penilaianpegawai_id"=>$data->penilaianpegawai_id,"frame"=>true)), array("target"=>"framePenilai","rel"=>"tooltip", "title"=>"Klik untuk Approve Penilai", "onclick"=>"checkPenilai($data->penilainama)")) : "")
            //                )',
        ),
        array(
            'header' => 'Atasan Penilai',
            'type' => 'raw',
            'value' => function ($data) {
                $namapegdata = "";
                if (!empty(Yii::app()->user->getState('pegawai_id'))) {
                    $modpegData = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                    if (isset($modpegData)) {
                        $namapegdata = $modpegData->namaLengkap;
                    }
                }
                $dataDialog = 'myAlert("Hanya ' . $data->pimpinannama . ' yang bisa mengakses");';
                if (trim($data->pimpinannama) == trim($namapegdata)) {
                    $dataDialog = "$('#dialogPemimpin').dialog('open');";
                }
                $html = (isset($data->pimpinannama) ? $data->pimpinannama : "-") . (isset($data->tanggal_approvepemimpin) ? "<br>" . MyFormatter::formatDateTimeForUser($data->tanggal_approvepemimpin) : (!isset($data->pimpinannama) ? "" : (!isset($data->tanggal_approvepenilai) ? "" : CHtml::link("<icon class='icon-form-kontrakkarya'></icon> ", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ApprovePemimpin', array("penilaianpegawai_id" => $data->penilaianpegawai_id, "frame" => true)), array("target" => "framePemimpin", "rel" => "tooltip", "title" => "Klik untuk Approve Pemimpin", "onclick" => $dataDialog)))));
                return $html;
            }
            //            'value' => '$data->pimpinannama'
            //            'value'=>'(isset($data->pimpinannama)? $data->pimpinannama : "-").
            //            (isset($data->tanggal_approvepemimpin) ? "<br>".MyFormatter::formatDateTimeForUser($data->tanggal_approvepemimpin) : 
            //            (!isset($data->pimpinannama)? "" :
            //            (!isset($data->tanggal_approvepenilai) ? "" : CHtml::link("<icon class=\'icon-form-check\'></icon> ", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/ApprovePemimpin", array("penilaianpegawai_id"=>$data->penilaianpegawai_id,"frame"=>true)), array("target"=>"framePemimpin","rel"=>"tooltip", "title"=>"Klik untuk Approve Pemimpin", "onclick"=>"$(\'#dialogPemimpin\').dialog(\'open\');")))
            //            ))',
        ),
        array(
            'header' => 'Detail',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::link("<i class='icon-form-detail'>", Yii::app()->controller->createUrl('/' . Yii::app()->controller->module->id . "/" . Yii::app()->controller->id . "/detail", array("id" => $data->penilaianpegawai_id)), array('rel' => 'tooltip', 'title' => 'Klik ikon ini, jika Anda ingin menampilkan <b>detail data penilaian pegawai</b>', 'data-html' => true, "id" => "$data->penilaianpegawai_id", "target" => "frameDetail", "onclick" => "window.parent.$('#dialogDetail').dialog('open');"));
            }
        ),
    ),

    'afterAjaxUpdate' => 'function(id, data){
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
        $("table").find("input[type=text]").each(function(){
            cekForm(this);
        })
    }',
)); ?>

<!--Dialog untuk Pemimpin-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPemimpin',
    'options' => array(
        'title' => 'Approvement Pemimpin',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('kpinfohukumanpoinpeg-v-grid', {
					data: $(this).serialize()
				}); }",
    ),
));
?>
<iframe name='framePemimpin' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<!--Dialog end untuk Pemimpin-->

<!--Dialog untuk Penilai-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPenilai',
    'options' => array(
        'title' => 'Approvement Penilai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('kpinfohukumanpoinpeg-v-grid', {
					data: $(this).serialize()
				}); }",
    ),
));
?>
<iframe name='framePenilai' style="overflow-x:scroll" style="width:100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<!--Dialog  end untuk Penilai-->