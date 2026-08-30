<?php
$this->breadcrumbs = array(
    'Jnspembayar Ms' => array('index'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('jnspembayar-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Pengaturan <b>Jenis Pembayaran</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            )); ?>
        </div>
        <!--search-form-->
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Jenis Pembayaran</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'jnspembayar-m-grid',
                    'dataProvider' => $model->search(),
                    // 'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ?
            						($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
            						: ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        //'jnspembayar_id',
                        'jnspembayar_nama',
                        //'jnspembayar_namalain',
                        array(
                            'header' => 'Bank',
                            'name' => 'bank_id',
                            'type' => 'raw',
                            'value' => function ($data) use (&$bank_list) {

                                $bank_list = JnspembayarbankM::model()->findAllByAttributes(array(
                                    'jnspembayar_id' => $data->jnspembayar_id,
                                ));

                                if (count((array)$bank_list) == 0) {
                                    return "";
                                }

                                $str = "<ul>";
                                foreach ($bank_list as $item) {
                                    $bank = BankM::model()->findByPk($item->bank_id);
                                    if (empty($bank)) {
                                        continue;
                                    }

                                    $str .= "<li>" . $bank->bankDanAtasNama . "</li>";
                                }

                                $str .= "</ul>";

                                return $str;
                            },
                        ),
                        array(
                            'name' => 'jatuhtempo',
                            'value' => 'empty($data->jatuhtempo) ? "-" : ($data->jatuhtempo." Hari")'
                        ),
                        'jnspembayar_cp',
                        'jnspembayar_nomobile',
                        array(
                            'header' => 'Rekening Debit',
                            'type' => 'raw',
                            'value' => function ($data) use (&$bank_list) {

                                $str = "";

                                foreach ($bank_list as $item) {

                                    $bank = BankM::model()->findByPk($item->bank_id);

                                    if (empty($bank)) {
                                        continue;
                                    }

                                    $str .= '<b>' . $bank->bankDanAtasNama . '</b>';

                                    $reks = JnspembrekM::model()->findByAttributes(array(
                                        'jnspembayar_id' => $data->jnspembayar_id,
                                        'debitkredit' => 'D',
                                        'bank_id' => $item->bank_id
                                    ));

                                    $str .= "<ul>";

                                    if (empty($reks)) {
                                        $str .= "<li>-</li>";
                                    } else {
                                        $rek = Rekening5M::model()->findByPk($reks->rekening5_id);

                                        if (empty($rek)) {
                                            $str .= "<li>-</li>";
                                        } else {
                                            $str .= "<li>" . $rek->kdrekening5 . " - " . $rek->nmrekening5 . "</li>";
                                        }
                                    }

                                    $str .= "</ul>";
                                }

                                // unlisted
                                $reks = JnspembrekM::model()->findByAttributes(array(
                                    'jnspembayar_id' => $data->jnspembayar_id,
                                    'debitkredit' => 'D'
                                ), array(
                                    'condition' => 'bank_id is null'
                                ));

                                if (!empty($reks)) {
                                    $str .= "<b>Tidak di-set</b>";
                                    $str .= "<ul>";

                                    if (empty($reks)) {
                                        $str .= "<li>-</li>";
                                    } else {
                                        $rek = Rekening5M::model()->findByPk($reks->rekening5_id);

                                        if (empty($rek)) {
                                            $str .= "<li>-</li>";
                                        } else {
                                            $str .= "<li>" . $rek->kdrekening5 . " - " . $rek->nmrekening5 . "</li>";
                                        }
                                    }

                                    $str .= "</ul>";
                                }

                                return $str;
                            }
                        ),
                        array(
                            'header' => 'Rekening Kredit',
                            'type' => 'raw',
                            'value' => function ($data) use (&$bank_list) {

                                $str = "";

                                foreach ($bank_list as $item) {

                                    $bank = BankM::model()->findByPk($item->bank_id);

                                    if (empty($bank)) {
                                        continue;
                                    }

                                    $str .= '<b>' . $bank->bankDanAtasNama . '</b>';

                                    $reks = JnspembrekM::model()->findByAttributes(array(
                                        'jnspembayar_id' => $data->jnspembayar_id,
                                        'debitkredit' => 'K',
                                        'bank_id' => $item->bank_id
                                    ));

                                    $str .= "<ul>";

                                    if (empty($reks)) {
                                        $str .= "<li>-</li>";
                                    } else {
                                        $rek = Rekening5M::model()->findByPk($reks->rekening5_id);

                                        if (empty($rek)) {
                                            $str .= "<li>-</li>";
                                        } else {
                                            $str .= "<li>" . $rek->kdrekening5 . " - " . $rek->nmrekening5 . "</li>";
                                        }
                                    }

                                    $str .= "</ul>";
                                }

                                // unlisted
                                $reks = JnspembrekM::model()->findByAttributes(array(
                                    'jnspembayar_id' => $data->jnspembayar_id,
                                    'debitkredit' => 'K'
                                ), array(
                                    'condition' => 'bank_id is null'
                                ));

                                if (!empty($reks)) {
                                    $str .= "<b>Tidak di-set</b>";
                                    $str .= "<ul>";

                                    if (empty($reks)) {
                                        $str .= "<li>-</li>";
                                    } else {
                                        $rek = Rekening5M::model()->findByPk($reks->rekening5_id);

                                        if (empty($rek)) {
                                            $str .= "<li>-</li>";
                                        } else {
                                            $str .= "<li>" . $rek->kdrekening5 . " - " . $rek->nmrekening5 . "</li>";
                                        }
                                    }

                                    $str .= "</ul>";
                                }

                                return $str;
                            }
                        ),

                        array(
                            'name' => 'jnspembayar_aktif',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            'value' => function ($data) {
                                return $data->jnspembayar_aktif ? "Aktif" : "Tidak Aktif";
                            }
                        ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/view",array("id"=>"$data->jnspembayar_id","tab"=>"' . (isset($_GET['tab']) ? $_GET['tab'] : '') . '"))',
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
                                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/update",array("id"=>"$data->jnspembayar_id","tab"=>"' . (isset($_GET['tab']) ? $_GET['tab'] : '') . '"))',
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            'template' => '{remove} {delete}',
                            'buttons' => array(
                                'remove' => array(
                                    'label' => "<i class='icon-form-silang'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/nonActive",array("id"=>$data->jnspembayar_id))',
                                    'click' => 'function(){nonActive(this);return false;}',
                                    //'visible'=>'Yii::app()->controller->checkAccess(array("action"=>"nonActive"))',
                                ),
                                'delete' => array(
                                    //'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                ),
                            )
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Jenis Pembayaran', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'], 'tab' => isset($_GET['tab']) ? $_GET['tab'] : '')),
                array('title' => 'Tambah jenis pembayaran', 'class' => 'btn btn-danger')
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $this->widget('UserTips', array('content' => ''));
            $urlPrint = $this->createUrl('print');

            $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#jnspembayar-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    function nonActive(obj) {
        myConfirm("Apakah Anda akan menonaktifkan jenis pembayaran ini?", "Perhatian!",
            function(r) {
                if (r) {
                    $.ajax({
                        type: 'GET',
                        url: obj.href,
                        data: {}, //
                        dataType: "json",
                        success: function(data) {
                            $.fn.yiiGridView.update('jnspembayar-m-grid');
                            if (data.sukses > 0) {} else {
                                myAlert('Data gagal dinonaktifkan!');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            myAlert('Data gagal dinonaktifkan!');
                            console.log(errorThrown);
                        }
                    });
                }
            }
        );
        return false;
    }
</script>