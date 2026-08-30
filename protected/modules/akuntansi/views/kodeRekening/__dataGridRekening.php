<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Kode Rekening</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->widget(
            'ext.bootstrap.widgets.BootGridView',
            array(
                'id' => 'AKRekeningakuntansi-v',
                'dataProvider' => $model->searchKodeRekening(),
                'filter' => $model,
                'overflowx' => true,
                'template' => "{summary}\n{items}\n{pager}",
                'itemsCssClass' => 'table table-bordered datatable',
                'columns' => array(

                    array(
                        'header' => 'Kode Akun',
                        'name' => 'kode',
                        'type' => 'raw',
                        'htmlOptions' => array('style' => 'width:80px'),
                        'filter' =>  /* CHtml::activeDropDownList($model, 'akun', array(
                               1 => 'Komponen',
                               2 => 'Unsur',
                               3 => 'Kelompok Pos',
                               4 => 'Pos',
                               5 => 'Akun',
                           ), array ('empty'=>'-- Pilih --')).*/    CHtml::activeTextField($model, 'kode'),
                    ),

                    /*

                        array(
                           'name'=>'nmrekening2',
                           'type'=>'raw',
                           'value'=>'isset($data->namakelrekening) ? CHtml::Link($data->nmrekening2, Yii::app()->controller->createUrl("KodeRekening/editKelompokRekening",array("id"=>$data->rekening2_id)),array("style"=>"color:blue","target"=>"frameEditKelompokRek", "onclick"=>"$(\"#dialogEditKelompokRek\").dialog(\"open\");","rel"=>"tooltip", "title"=>"Klik Untuk<br>Edit Kelompok Rekening",)) : "-"',
                           'htmlOptions'=>array('style'=>'width:80px')
                        ),
                        array(
                           'name'=>'nmrekening3',
                           'type'=>'raw',
                           'value'=>'isset($data->nmrekening3) ? CHtml::Link($data->nmrekening3, Yii::app()->controller->createUrl("KodeRekening/editJenisRekening",array("id"=>$data->rekening3_id)),array("style"=>"color:blue","target"=>"frameEditKelompokRek", "onclick"=>"$(\"#dialogEditKelompokRek\").dialog(\"open\");","rel"=>"tooltip", "title"=>"Klik untuk Edit<br>Jenis Rekening",)) : "-"',
                           'htmlOptions'=>array('style'=>'width:80px')
                        ),
                        array(
                           'name'=>'nmrekening4',
                           'type'=>'raw',
                           'value'=>'isset($data->nmrekening4) ? CHtml::Link($data->nmrekening4, Yii::app()->controller->createUrl("KodeRekening/editObyekRekening",array("id"=>$data->rekening4_id)),array("style"=>"color:blue","target"=>"frameEditObyekRek", "onclick"=>"$(\"#dialogEditObyekRek\").dialog(\"open\");","rel"=>"tooltip", "title"=>"Klik untuk Edit<br>Obyek Rekening",)) : "-"',
                        ), */
                    array(
                        'header' => 'Nama Akun',
                        'name' => 'nama',
                        'type' => 'raw',
                        'value' => function ($data) {
                            $nama = $data['nama'];
                            $pad = 0;
                            $res = "";
                            switch ($data['levelrek']) {
                                case 1:
                                    $res = CHtml::Link("[1] - " . $data['nama'], Yii::app()->controller->createUrl("KodeRekening/editRincianObyekRek", array("id" => $data['id'])), array("style" => "color:blue", "target" => "frameEditRincianObyekRek", "onclick" => '$("#dialogEditRincianObyekRek").dialog("open");', "rel" => "tooltip", "title" => "Klik untuk Edit<br>Kode Akun",));
                                    break;
                                case 2:
                                    $res = "&emsp;" . CHtml::Link("[2] - " . $data['nama'], Yii::app()->controller->createUrl("KodeRekening/editRincianObyekRek", array("id" => $data['id'])), array("style" => "color:blue", "target" => "frameEditRincianObyekRek", "onclick" => '$("#dialogEditRincianObyekRek").dialog("open");', "rel" => "tooltip", "title" => "Klik Untuk Edit<br>Kode Akun",));
                                    break;
                                case 3:
                                    $res = "&emsp;" . "&emsp;" . CHtml::Link("[3] - " . $data['nama'], Yii::app()->controller->createUrl("KodeRekening/editRincianObyekRek", array("id" => $data['id'])), array("style" => "color:blue", "target" => "frameEditRincianObyekRek", "onclick" => '$("#dialogEditRincianObyekRek").dialog("open");', "rel" => "tooltip", "title" => "Klik untuk Edit<br>Kode Akun",));
                                    break;
                                case 4:
                                    $res = "&emsp;" . "&emsp;" . "&emsp;" . CHtml::Link("[4] - " . $data['nama'], Yii::app()->controller->createUrl("KodeRekening/editRincianObyekRek", array("id" => $data['id'])), array("style" => "color:blue", "target" => "frameEditRincianObyekRek", "onclick" => '$("#dialogEditRincianObyekRek").dialog("open");', "rel" => "tooltip", "title" => "Klik untuk Edit<br>Kode Akun",));
                                    break;
                                case 5:
                                    $res = "&emsp;" . "&emsp;" . "&emsp;" . "&emsp;" . CHtml::Link("[5] - " . $data['nama'], Yii::app()->controller->createUrl("KodeRekening/editRincianObyekRek", array("id" => $data['id'])), array("style" => "color:blue", "target" => "frameEditRincianObyekRek", "onclick" => '$("#dialogEditRincianObyekRek").dialog("open");', "rel" => "tooltip", "title" => "Klik untuk Edit<br>Kode Akun",));
                                    break;
                                case 6:
                                    $res = "&emsp;" . "&emsp;" . "&emsp;" . "&emsp;" . "&emsp;" . CHtml::Link("[6] - " . $data['nama'], Yii::app()->controller->createUrl("KodeRekening/editRincianObyekRek", array("id" => $data['id'])), array("style" => "color:blue", "target" => "frameEditRincianObyekRek", "onclick" => '$("#dialogEditRincianObyekRek").dialog("open");', "rel" => "tooltip", "title" => "Klik untuk Edit<br>Kode Akun",));
                                    break;
                                case 7:
                                    $res = "&emsp;" . "&emsp;" . "&emsp;" . "&emsp;" . "&emsp;" . "&emsp;" . CHtml::Link("[7] - " . $data['nama'], Yii::app()->controller->createUrl("KodeRekening/editRincianObyekRek", array("id" => $data['id'])), array("style" => "color:blue", "target" => "frameEditRincianObyekRek", "onclick" => '$("#dialogEditRincianObyekRek").dialog("open");', "rel" => "tooltip", "title" => "Klik untuk Edit<br>Kode Akun",));
                                    break;
                                case 8:
                                    $res = "&emsp;" . "&emsp;" . "&emsp;" . "&emsp;" . "&emsp;" . "&emsp;" . "&emsp;" . CHtml::Link("[8] - " . $data['nama'], Yii::app()->controller->createUrl("KodeRekening/editRincianObyekRek", array("id" => $data['id'])), array("style" => "color:blue", "target" => "frameEditRincianObyekRek", "onclick" => '$("#dialogEditRincianObyekRek").dialog("open");', "rel" => "tooltip", "title" => "Klik untuk Edit<br>Kode Akun",));
                                    break;
                                case 9:
                                    $res = "&emsp;" . "&emsp;" . "&emsp;" . "&emsp;" . "&emsp;" . "&emsp;" . "&emsp;" . "&emsp;" . CHtml::Link("[9] - " . $data['nama'], Yii::app()->controller->createUrl("KodeRekening/editRincianObyekRek", array("id" => $data['id'])), array("style" => "color:blue", "target" => "frameEditRincianObyekRek", "onclick" => '$("#dialogEditRincianObyekRek").dialog("open");', "rel" => "tooltip", "title" => "Klik untuk Edit<br>Kode Akun",));
                                    break;
                                case 10:
                                    $res = "&emsp;" . "&emsp;" . "&emsp;" . "&emsp;" . "&emsp;" . "&emsp;" . "&emsp;" . "&emsp;" . "&emsp;" . CHtml::Link("[10] - " . $data['nama'], Yii::app()->controller->createUrl("KodeRekening/editRincianObyekRek", array("id" => $data['id'])), array("style" => "color:blue", "target" => "frameEditRincianObyekRek", "onclick" => '$("#dialogEditRincianObyekRek").dialog("open");', "rel" => "tooltip", "title" => "Klik untuk Edit<br>Kode Akun",));
                                    break;
                            }
                            return $res;
                        }, //'isset($data->nmrekening5) ? CHtml::Link($data->nmrekening5, Yii::app()->controller->createUrl("KodeRekening/editRincianObyekRek",array("id"=>$data->rekening5_id)),array("style"=>"color:blue","target"=>"frameEditRincianObyekRek", "onclick"=>"$(\"#dialogEditRincianObyekRek\").dialog(\"open\");","rel"=>"tooltip", "title"=>"Klik untuk Edit<br>Rincian Obyek Rekening",)) : "-"',
                    ),
                    array(
                        'header' => 'Saldo Normal',
                        'name' => 'saldo_normal',
                        'type' => 'raw',
                        'value' => '($data["saldo_normal"] == null ? "-" : ($data["saldo_normal"] == "D" ? "Debit" : "Kredit"))',
                        'filter' => CHtml::activeDropDownList($model, 'saldo_normal', array(
                            'D' => 'Debit',
                            'K' => 'Kredit',
                        ), array('empty' => '-- Pilih --')),
                    ),
                    array(
                        'header' => 'Tipe Rekening',
                        'name' => 'tiperekening_id',
                        'type' => 'raw',
                        'value' => function ($data) {
                            if (empty($data['tiperekening_id'])) {
                                return "-";
                            }

                            $rek = TiperekeningM::model()->findByPk($data['tiperekening_id']);

                            if (empty($rek)) {
                                return "-";
                            }

                            return $rek->tiperekening;
                        },
                        'filter' => CHtml::activeDropDownList(
                            $model,
                            'tiperekening_id',
                            CHtml::listData(
                                TiperekeningM::model()->findAll('tiperekening_aktif = true order by tiperekening'),
                                'tiperekening_id',
                                'tiperekening'
                            ),
                            array('empty' => '-- Pilih --')
                        ),
                        'htmlOptions' => array('style' => 'width:80px')
                    ),
                    array(
                        'name' => 'keterangan',
                        'type' => 'raw',
                        'value' => '((empty($data["keterangan"]) || $data["keterangan"] == null) ? "-" : $data["keterangan"])',
                    ),
                ),
                'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
            )
        );
        ?>
    </div>
</div>

<?php
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

// echo CHtml::htmlButton(
//     Yii::t('mds', '{icon} Export CSV', array('{icon}' => '<i class="entypo-newspaper"></i>')),
//     array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'CSV\')')
// );
?>
<?php
$content = $this->renderPartial('../tips/master3', array(), true);
$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
$urlEksportCsv =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/eksportCSV');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#AKRekeningakuntansi-v :input').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}

JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>
<?php
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogEditStruktur',
        'options' => array(
            'title' => 'Edit Komponen',
            'autoOpen' => false,
            'modal' => true,
            'width' => 550,
            'height' => 300,
            'resizable' => false,
            'close' => 'js:function(){getTreeMenu();$.fn.yiiGridView.update(\'AKRekeningakuntansi-v\', {});}'
        ),
    )
);
?>
<iframe name='frameEditStruktur' style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>

<?php
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogEditKelompokRek',
        'options' => array(
            'title' => 'Edit Unsur',
            'autoOpen' => false,
            'modal' => true,
            'width' => 550,
            'height' => 300,
            'resizable' => false,
            'close' => 'js:function(){getTreeMenu();$.fn.yiiGridView.update(\'AKRekeningakuntansi-v\', {});}'
        ),
    )
);
?>
<iframe name='frameEditKelompokRek' style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>

<?php
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogEditJenisRek',
        'options' => array(
            'title' => 'Edit Kelompok Pos',
            'autoOpen' => false,
            'modal' => true,
            'width' => 550,
            'height' => 300,
            'resizable' => false,
            'close' => 'js:function(){getTreeMenu();$.fn.yiiGridView.update(\'AKRekeningakuntansi-v\', {});}'
        ),
    )
);
?>
<iframe name='frameEditJenisRek' style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>

<?php
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogEditObyekRek',
        'options' => array(
            'title' => 'Edit Pos',
            'autoOpen' => false,
            'modal' => true,
            'width' => 550,
            'height' => 300,
            'resizable' => false,
            'close' => 'js:function(){getTreeMenu();$.fn.yiiGridView.update(\'AKRekeningakuntansi-v\', {});}'
        ),
    )
);
?>
<iframe name='frameEditObyekRek' style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>

<?php
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogEditRincianObyekRek',
        'options' => array(
            'title' => 'Edit Akun',
            'autoOpen' => false,
            'modal' => true,
            'width' => 550,
            'height' => 450,
            'resizable' => false,
            'close' => 'js:function(){getTreeMenu();$.fn.yiiGridView.update(\'AKRekeningakuntansi-v\', {});}'
        ),
    )
);
?>
<iframe name='frameEditRincianObyekRek' style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>

<script type="text/javascript">

</script>