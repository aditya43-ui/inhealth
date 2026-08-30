<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-multiselect/js/bootstrap-multiselect.js', CClientScript::POS_END); ?>

<style>
    .clsOdd {
        background-color: #f9f9f9 !important;
    }

    .clsOdd>td {
        background-color: #f9f9f9 !important;
    }

    .clsEven {
        background-color: #ffffff !important;
    }

    .clsEven>td {
        background-color: #ffffff !important;
    }
</style>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php $this->renderPartial($this->path_view . '_formSearch', array('model' => $model)); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'jurnalpiutangpasien-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'
    ),
)); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Jurnal Piutang</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table id="table-piutangpasien" class="table table-striped table-bordered ">
            <thead>
                <tr>
                    <th rowspan="2">Pilih <br> <?php echo CHtml::checkbox('chekboxall', false, array('class' => 'checkboxAll', 'onclick' => 'changePilihAll(this);')) ?></th>
                    <th rowspan="2">Jenis Jurnal</th>
                    <th rowspan="2">Instalasi/<br>Ruangan</th>
                    <th rowspan="2">Tgl. Pelayanan</th>
                    <th rowspan="2">No. Pendaftaran/<br>No. Rekam Medis</th>
                    <th rowspan="2">Nama Pasien</th>
                    <th rowspan="2">Kode Tindakan/<br>Obat Alkes</th>
                    <th rowspan="2">Uraian Tindakan/<br>Obat Alkes</th>
                    <th rowspan="2">Tgl. Bukti Jurnal</th>
                    <th rowspan="2">No. Bukti Jurnal</th>
                    <th rowspan="2">Kode Jurnal</th>
                    <th rowspan="2">No. Referensi</th>
                    <th rowspan="2">Uraian Jurnal</th>
                    <th rowspan="2">Kode Rekening</th>
                    <th rowspan="2">Nama Rekening</th>
                    <th colspan="2" style="text-align:center;">Saldo</th>
                </tr>
                </tr>
                <th>Debit</th>
                <th>Kredit</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
                <tr>
                    <td style="text-align: right" colspan="15">Total</td>
                    <td>
                        <?php echo CHtml::textField('totalDebit', 0, array('class' => 'span2 integer-decimal', 'readonly' => true)); ?>
                    </td>
                    <td>
                        <?php echo CHtml::textField('totalKredit', 0, array('class' => 'span2 integer-decimal', 'readonly' => true)); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<div class="form-actions">
    <?php
    $disabled = ((isset($_GET['sukses'])) ? true : false);
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array(
        'class' => 'btn btn-danger', 'type' => 'button', 'onKeypress' => 'simpanJurnalRek();', 'onclick' => 'simpanJurnalRek();',
        'disabled' => $disabled
    ));
    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-default', 'onclick' => 'return refreshForm(this);'));
    ?>
    <?php
    $content = $this->renderPartial('akuntansi.views/tips/transaksi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model)); ?>

<?php
//========= Dialog buat cari data Rek Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRek',
    'options' => array(
        'title' => 'Daftar Rekening',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'resizable' => false,
    ),
));

$modRekDebit = new RekeningakuntansiV('searchDialogAccount');
$modRekDebit->unsetAttributes();
if (isset($_GET['RekeningakuntansiV'])) {
    $modRekDebit->attributes = $_GET['RekeningakuntansiV'];
}

$this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
    'id' => 'rekdebit-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modRekDebit->searchDialogAccount(),
    'filter' => $modRekDebit,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
                                    "id" => "selectRekDebit",
                                    "onClick" =>"
												pilihDialogRekening(".CJSON::encode($data->attributes).");
                                                $(\"#dialogRek\").dialog(\"close\");
                                                return false;
                            "))',
        ),
        array(
            'header' => 'Kode Akun',
            'name' => 'kdrekeninglast',
            'value' => '$data->kdrekeninglast',
        ),
        array(
            'header' => 'Level 1',
            'name' => 'nmrekening1',
            'value' => '$data->nmrekening1',
        ),
        array(
            'header' => 'Level 2',
            'name' => 'nmrekening2',
            'value' => '$data->nmrekening2',
        ),
        array(
            'header' => 'Level 3',
            'name' => 'nmrekening3',
            'value' => '$data->nmrekening3',
        ),
        array(
            'header' => 'Level 4',
            'name' => 'nmrekening4',
            'value' => '$data->nmrekening4',
        ),
        array(
            'header' => 'Level 5',
            'name' => 'nmrekening5',
            'value' => '$data->nmrekening5',
        ),
        array(
            'header' => 'Level 6',
            'name' => 'kdrekening6',
            'value' => '$data->nmrekening6',
        ),
        array(
            'header' => 'Level 7',
            'name' => 'nmrekening7',
            'value' => '$data->nmrekening7',
        ),
        array(
            'header' => 'Level 8',
            'name' => 'nmrekening8',
            'value' => '$data->nmrekening8',
        ),
        array(
            'header' => 'Level 9',
            'name' => 'nmrekening9',
            'value' => '$data->nmrekening9',
        ),
        array(
            'header' => 'Level 10',
            'name' => 'nmrekening10',
            'value' => '$data->nmrekening10',
        ),
        array(
            'header' => 'Saldo Normal',
            'name' => 'rekeninglast_nb',
            'value' => '($data->rekeninglast_nb == "D") ? "Debit" : "Kredit"',
            'filter' =>  CHtml::activeDropDownList($modRekDebit, 'rekeninglast_nb', array('D' => 'Debit', 'K' => 'Kredit'), array('empty' => "-- Pilih --")),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Rek Debit dialog =============================
?>