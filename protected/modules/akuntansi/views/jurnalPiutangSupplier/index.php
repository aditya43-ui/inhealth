<?php
$this->breadcrumbs = array(
    'Jurnal Utang Supplier',
);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Posting Jurnal Utang Supplier</b>
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
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php
                $this->widget('application.extensions.moneymask.MMask', array(
                    'element' => '.currency',
                    'currency' => 'PHP',
                    'config' => array(
                        'defaultZero' => true,
                        'allowZero' => true,
                        'decimal' => '.',
                        'thousands' => ',',
                        'precision' => 0,
                    )
                )); ?>
                <?php echo $this->renderPartial('_search', array('model' => $model)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Jurnal Rekening</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $form = $this->beginWidget(
                    'ext.bootstrap.widgets.BootActiveForm',
                    array(
                        'id' => 'jurnalpiutangsupplier-form',
                        'enableAjaxValidation' => false,
                        'type' => 'horizontal',
                        'htmlOptions' => array(
                            'onKeyPress' => 'return disableKeyPress(event)',
                            'onSubmit' => 'return unformatSemuaInput();'
                        ),
                        'focus' => '#',
                    )
                );
                ?>
                <div class="block-tabel">
                    <div id="jurnalpiutangsupplier-grid" class="grid-view">
                        <table class="table table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th>Pilih<br><?php
                                                    echo CHtml::checkBox('checkAllRekening', true, array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'checkAllDetail()', 'checked' => 'checked')) ?>
                                    </th>
                                    <th width="10px">No.</th>
                                    <th>Tgl. Faktur/<br>No. Faktur</th>
                                    <th>Supplier</th>
                                    <th width="156px">Kode Akun</th>
                                    <th width="256px">Nama Akun</th>
                                    <th width="64px">Debit</th>
                                    <th width="64px">Kredit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $this->renderPartial('_rowRekening', array('modRekenings' => $modRekenings)); ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan='6' style="text-align:right;font-weight:bold;"> Total </td>
                                    <td><?php echo CHtml::textField('totalDebit', 0, array('class' => 'integer2 span2', 'readonly' => true, 'style' => 'text-align: right;')); ?></td>
                                    <td><?php echo CHtml::textField('totalKredit', 0, array('class' => 'integer2 span2', 'readonly' => true, 'style' => 'text-align: right;')); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Posting Jurnal', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit')); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . "/" . $this->id),
                array('class' => 'btn btn-danger')
            ); ?>
        </div>
    </div>
</div>

<?php $this->renderPartial('_jsFunctions'); ?>
<?php $this->endWidget(); ?>
<?php
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRekDebitKredit',
    'options' => array(
        'title' => 'Daftar Rekening Debit dan Kredit',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 400,
        'resizable' => false,
    ),
));
echo CHtml::hiddenField('row', 0, array('readonly' => true)); //untuk mencatat asal baris di klik
$modRekKredit = new RekeningakuntansiV('searchDialogAccount');
$modRekKredit->unsetAttributes();
if (isset($_GET['RekeningakuntansiV'])) {
    $modRekKredit->attributes = $_GET['RekeningakuntansiV'];
}
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
    'id' => 'rekkreditdebit-m-grid',
    'dataProvider' => $modRekKredit->searchDialogAccount(),
    'filter' => $modRekKredit,
    'template' => "{pager}{summary}\n{items}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    //        JIKA INI DI AKTIFKAN MAKA FILTER AKAN HILANG
    //        'mergeHeaders'=>array(
    //            array(
    //                'name'=>'<p style="margin: 0; text-align: center;">Kode Rekening</p>',
    //                'start'=>1, //indeks kolom 3
    //                'end'=>5, //indeks kolom 4
    //            ),
    //        ),
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
                                    "id" => "selectRekDebitKredit",
                                    "onClick" =>"
                                        var data = {
                                            rincianobyek_id:$data->rekeninglast_id,
                                            obyek_id:$data->rekening4_id,
                                            jenis_id:$data->rekening3_id,
                                            kelompok_id:$data->rekening2_id,
                                            struktur_id:$data->rekening1_id,
                                            nmrincianobyek:\"$data->nmrekeninglast\",
                                            kdstruktur:\"$data->kdrekening1\",
                                            kdkelompok:\"$data->kdrekening2\",
                                            kdjenis:\"$data->kdrekening3\",
                                            kdobyek:\"$data->kdrekening4\",
                                            kdrincianobyek:\"$data->kdrekeninglast\",
                                            saldodebit:\"$data->saldodebit\",
                                            saldokredit:\"$data->saldokredit\",
                                            status:\"debit\"
                                        };
                                        var row = $(\"#dialogRekDebitKredit #row\").val();
                                        editDataRekeningFromGrid(data, row);
                                        $(\"#dialogRekDebitKredit\").dialog(\"close\");
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
            'filter' =>  CHtml::activeDropDownList($modRekKredit, 'rekeninglast_nb', array('D' => 'Debit', 'K' => 'Kredit'), array('empty' => "-- Pilih --")),
        ),


    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>
