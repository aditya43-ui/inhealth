<?php
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.currency',
    'currency' => 'PHP',
    'config' => array(
        'symbol' => 'Rp ',
        'defaultZero' => true,
        'allowZero' => true,
        'precision' => 0,
    )
));
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'penjaminpasien-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
));
?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->
    <?php echo $form->errorSummary($modSumber); ?>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->textFieldRow($modSumber, 'sumberdana_nama', array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true));
            ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class='control-group'>
            <?php echo $form->labelEx($modSumber, 'rekening_debit', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                //$modSupplier->rekening_debit = $modSumberd->rekening5_id;
                echo $form->hiddenField($modSumber, 'rekening_debit', array('class' => 'span3', 'maxlength' => 50)); ?>
                <?php
                //var_dump($modSumber["D"]->rekeningdebit->nmrekening5); die;
                //    if (!empty($modSumberd->rekening5_id)) $modSumber->rekDebit = $modSumberd->rekening5->nmrekening5;
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modSumber,
                    'attribute' => 'rekDebit',
                    'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi'),
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                $(this).val(ui.item.nmrekening1);
                                return false;
                            }',
                        'select' => 'js:function( event, ui ) {
                                $(this).val(ui.item.nmrekening5);
                                $("#' . CHtml::activeId($modSumber, 'rekening_debit') . '").val(ui.item.rekening5_id);
                                return false;
                            }'
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => 'Nama Rekening',
                        'class' => 'span2',
                        'style' => 'width:50px;',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogRekDebit', 'idTombol' => 'tombolDebitRek'),
                ));
                ?>
            </div>

            <div class="controls">
                <?php echo CHtml::htmlButton(
                    '<i class="icon-plus icon-white"></i>',
                    array(
                        'onclick' => 'tambahRekening("D");return false;',
                        'class' => 'btn btn-danger',
                        'onkeypress' => "tambahRekening('D');return false;",
                        'rel' => "tooltip",
                        'title' => "Klik untuk menambahkan",
                    )
                ); ?>
            </div>
        </div>

        <div class='control-group'>
            <?php echo $form->labelEx($modSumber, 'rekeningKredit', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                //$modSupplier->rekening_kredit = $modSumberk->rekening5_id;
                //if (!empty($modSumberk->rekening5_id)) $modSupplier->rekKredit = $modSumberk->rekening5->nmrekening5;
                echo $form->hiddenField($modSumber, 'rekening_kredit', array('class' => 'span3', 'maxlength' => 50)); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modSumber,
                    'attribute' => 'rekKredit',
                    'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi'),
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                $(this).val(ui.item.nmrekening1);
                                return false;
                            }',
                        'select' => 'js:function( event, ui ) {
                                $(this).val(ui.item.nmrekening5);
                                $("#' . CHtml::activeId($modSumber, 'rekening_debit') . '").val(ui.item.rekening5_id);
                                return false;
                            }'
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => 'Nama Rekening',
                        'class' => 'span2',
                        'style' => 'width:100px;',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogRekKredit', 'idTombol' => 'tombolKreditRek'),
                ));
                ?>
            </div>

            <div class="controls">
                <?php echo CHtml::htmlButton(
                    '<i class="icon-plus icon-white"></i>',
                    array(
                        'onclick' => 'tambahRekening("K");return false;',
                        'class' => 'btn btn-danger',
                        'onkeypress' => "tambahRekeningt('K');return false;",
                        'rel' => "tooltip",
                        'title' => "Klik untuk menambahkan",
                    )
                ); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')); ?>

        </div>
    </div>
</div>
<?php
$rd = AKSumberdanaRekM::model()->findAllByAttributes(array(
    'debitkredit' => 'D',
    'sumberdana_id' => $modSumber->sumberdana_id,
), array('order' => 'rekening5_id ASC'));
$rk = AKSumberdanaRekM::model()->findAllByAttributes(array(
    'debitkredit' => 'K',
    'sumberdana_id' => $modSumber->sumberdana_id,
), array('order' => 'rekening5_id ASC'));
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Rekening Debit</b></div>
    </div>
    <div class="panel-body table-responsive">
        <table class="table table-bordered datatable" id="tab_rekening_debit">
            <thead>
                <tr>
                    <th>Rekening Debit</th>
                    <th width="50px">Batal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($rd as $item) {
                    $r = Rekening5M::model()->findByPk($item->rekening5_id);
                    echo $this->renderPartial('_rowRekeningSumberDana', array('item' => $item, 'r' => $r, 'dk' => 'D'), true);
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Rekening Kredit</b></div>
    </div>
    <div class="panel-body table-responsive">
        <table class="table table-bordered datatable" id="tab_rekening_kredit">
            <thead>
                <tr>
                    <th>Rekening Kredit</th>
                    <th width="50px">Batal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($rk as $item) {
                    $r = Rekening5M::model()->findByPk($item->rekening5_id);
                    echo $this->renderPartial('_rowRekeningSumberDana', array('item' => $item, 'r' => $r, 'dk' => 'K'), true);
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<table id="hapusrekening-supplier">
    <tbody>

    </tbody>
</table>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    );
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/jurnalRekPenjamin/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Jurnal Rekening Sumber Dana', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('akuntansi.views.tips.tipsaddedit3a', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari data Rek Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRekDebit',
    'options' => array(
        'title' => 'Daftar Rekening Debit',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));
//$account = 'D';

$modRekDebit = new RekeningakuntansiV('searchAccounts');
$modRekDebit->unsetAttributes();
//$modRekDebit->rincianobyek_nb = $account;
$modRekDebit->rekening5_aktif = true;
if (isset($_GET['RekeningakuntansiV'])) {
    $modRekDebit->attributes = $_GET['RekeningakuntansiV'];
    // $modRekDebit->rincianobyek_nb = $account;
}

$c2 = new CDbCriteria();
$c3 = new CDbCriteria();
$c4 = new CDbCriteria();

$c2->compare('rekening1_id', $modRekDebit->rekening1_id);
$c2->addCondition('rekening2_aktif = true');
$c2->order = 'kdrekening2';

$r2 = Rekening2M::model()->findAll($c2);

$c3->compare('rekening2_id', $modRekDebit->rekening2_id);
$c3->addCondition('rekening3_aktif = true');
$c3->order = 'kdrekening3';

$r3 = Rekening3M::model()->findAll($c3);

$c4->compare('rekening3_id', $modRekDebit->rekening3_id);
$c4->addCondition('rekening4_aktif = true');
$c4->order = 'kdrekening4';

$r4 = Rekening4M::model()->findAll($c4);

$this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
    'id' => 'rekdebit-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modRekDebit->searchAccounts(),
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
                                                $(\"#' . CHtml::activeId($modSumber, 'rekening_debit') . '\").val(\"$data->rekening5_id\");
                                                $(\"#' . CHtml::activeId($modSumber, 'rekDebit') . '\").val(\"$data->nmrekening5\");                                                
                                                $(\"#dialogRekDebit\").dialog(\"close\");    
                                                return false;
                            "))',
        ),
        array(
            'header' => 'Kode Akun',
            'name' => 'kdrekening5',
            'value' => '$data->kdrekening5',
        ),
        array(
            'header' => 'Kelompok Akun',
            'type' => 'raw',
            'value' => function ($data) {
                $rek1 = Rekening1M::model()->findByPk($data->rekening1_id);
                $rek2 = KelrekeningM::model()->findByPk($rek1->kelrekening_id);
                return $rek2->namakelrekening;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'kelrekening_id', CHtml::listData(
                KelrekeningM::model()->findAll(array(
                    'condition' => 'kelrekening_aktif = true',
                    'order' => 'koderekeningkel',
                )),
                'kelrekening_id',
                'namakelrekening'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Komponen',
            'name' => 'rekening1_id',
            'value' => '$data->nmrekening1',
            'filter' =>  CHtml::activeDropDownList(
                $modRekDebit,
                'rekening1_id',
                CHtml::listData(Rekening1M::model()->findAll(array(
                    'condition' => 'rekening1_aktif = true',
                    'order' => 'kdrekening1 asc',
                )), 'rekening1_id', 'nmrekening1'),
                array('empty' => '-- Pilih --')
            ),
        ),
        array(
            'header' => 'Unsur',
            'name' => 'rekening2_id',
            'value' => '$data->nmrekening2',
            'filter' =>  CHtml::activeDropDownList(
                $modRekDebit,
                'rekening2_id',
                CHtml::listData($r2, 'rekening2_id', 'nmrekening2'),
                array('empty' => '-- Pilih --')
            ),
        ),
        array(
            'header' => 'Kelompok Pos',
            'name' => 'rekening3_id',
            'value' => '$data->nmrekening3',
            'filter' =>  CHtml::activeDropDownList(
                $modRekDebit,
                'rekening3_id',
                CHtml::listData($r3, 'rekening3_id', 'nmrekening3'),
                array('empty' => '-- Pilih --')
            ),
        ),
        array(
            'header' => 'Pos',
            'name' => 'rekening4_id',
            'value' => '$data->nmrekening4',
            'filter' =>  CHtml::activeDropDownList(
                $modRekDebit,
                'rekening4_id',
                CHtml::listData($r4, 'rekening4_id', 'nmrekening4'),
                array('empty' => '-- Pilih --')
            ),
        ),
        array(
            'header' => 'Akun',
            'name' => 'nmrekening5',
            'value' => '$data->nmrekening5',
        ),
        array(
            'header' => 'Saldo Normal',
            'name' => 'rekening5_nb',
            'filter' => false,
            'value' => '($data->rekening5_nb == "D") ? "Debit" : "Kredit"',
            'filter' =>  CHtml::activeDropDownList($modRekDebit, 'rekening5_nb', array('D' => 'Debit', 'K' => 'Kredit'), array('empty' => "-- Pilih --")),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Rek Debit dialog =============================
?>

<?php
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRekKredit',
    'options' => array(
        'title' => 'Daftar Rekening Kredit',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));
//$account = 'K';
$modRekKredit = new RekeningakuntansiV('searchAccounts');
$modRekKredit->unsetAttributes();
//$modRekKredit->rincianobyek_nb = $account;
$modRekKredit->rekening5_aktif = true;

if (isset($_GET['RekeningakuntansiV'])) {
    $modRekKredit->attributes = $_GET['RekeningakuntansiV'];
    // $modRekKredit->rincianobyek_nb = $account;
}

$c2 = new CDbCriteria();
$c3 = new CDbCriteria();
$c4 = new CDbCriteria();

$c2->compare('rekening1_id', $modRekKredit->rekening1_id);
$c2->addCondition('rekening2_aktif = true');
$c2->order = 'kdrekening2';

$r2 = Rekening2M::model()->findAll($c2);

$c3->compare('rekening2_id', $modRekKredit->rekening2_id);
$c3->addCondition('rekening3_aktif = true');
$c3->order = 'kdrekening3';

$r3 = Rekening3M::model()->findAll($c3);

$c4->compare('rekening3_id', $modRekKredit->rekening3_id);
$c4->addCondition('rekening4_aktif = true');
$c4->order = 'kdrekening4';

$r4 = Rekening4M::model()->findAll($c4);

$this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
    'id' => 'rekkredit-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modRekKredit->search(),
    'filter' => $modRekKredit,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectRekKredit",
                                    "onClick" =>"
                                                $(\"#' . CHtml::activeId($modSumber, 'rekening_kredit') . '\").val(\"$data->rekening5_id\");
                                                $(\"#' . CHtml::activeId($modSumber, 'rekKredit') . '\").val(\"$data->nmrekening5\");                                                
                                                $(\"#dialogRekKredit\").dialog(\"close\");    
                                                return false;
                            "))',
        ),
        array(
            'header' => 'Kode Akun',
            'name' => 'kdrekening5',
            'value' => '$data->kdrekening5',
        ),
        array(
            'header' => 'Kelompok Akun',
            'type' => 'raw',
            'value' => function ($data) {
                $rek1 = Rekening1M::model()->findByPk($data->rekening1_id);
                $rek2 = KelrekeningM::model()->findByPk($rek1->kelrekening_id);
                return $rek2->namakelrekening;
            },
            'filter' => CHtml::activeDropDownList($modRekKredit, 'kelrekening_id', CHtml::listData(
                KelrekeningM::model()->findAll(array(
                    'condition' => 'kelrekening_aktif = true',
                    'order' => 'koderekeningkel',
                )),
                'kelrekening_id',
                'namakelrekening'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Komponen',
            'name' => 'rekening1_id',
            'value' => '$data->nmrekening1',
            'filter' =>  CHtml::activeDropDownList(
                $modRekKredit,
                'rekening1_id',
                CHtml::listData(Rekening1M::model()->findAll(array(
                    'condition' => 'rekening1_aktif = true',
                    'order' => 'kdrekening1 asc',
                )), 'rekening1_id', 'nmrekening1'),
                array('empty' => '-- Pilih --')
            ),
        ),
        array(
            'header' => 'Unsur',
            'name' => 'rekening2_id',
            'value' => '$data->nmrekening2',
            'filter' =>  CHtml::activeDropDownList(
                $modRekKredit,
                'rekening2_id',
                CHtml::listData($r2, 'rekening2_id', 'nmrekening2'),
                array('empty' => '-- Pilih --')
            ),
        ),
        array(
            'header' => 'Kelompok Pos',
            'name' => 'rekening3_id',
            'value' => '$data->nmrekening3',
            'filter' =>  CHtml::activeDropDownList(
                $modRekKredit,
                'rekening3_id',
                CHtml::listData($r3, 'rekening3_id', 'nmrekening3'),
                array('empty' => '-- Pilih --')
            ),
        ),
        array(
            'header' => 'Pos',
            'name' => 'rekening4_id',
            'value' => '$data->nmrekening4',
            'filter' =>  CHtml::activeDropDownList(
                $modRekKredit,
                'rekening4_id',
                CHtml::listData($r4, 'rekening4_id', 'nmrekening4'),
                array('empty' => '-- Pilih --')
            ),
        ),
        array(
            'header' => 'Akun',
            'name' => 'nmrekening5',
            'value' => '$data->nmrekening5',
        ),
        array(
            'header' => 'Saldo Normal',
            'name' => 'rekening5_nb',
            'filter' => false,
            'value' => '($data->rekening5_nb == "D") ? "Debit" : "Kredit"',
            'filter' =>  CHtml::activeDropDownList($modRekKredit, 'rekening5_nb', array('D' => 'Debit', 'K' => 'Kredit'), array('empty' => "-- Pilih --")),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>

<script type="text/javascript">
    function changeSize() {
        window.parent.document.getElementById('frame').style = 'overflow-y:scroll;height:600px;';
    }

    $('#tombolKreditRek, #tombolDebitRek').click(function() {
        changeSize();
    });

    function batalRekening(obj) {
        myConfirm("Apakah Anda yakin ingin menghapus rekening ini?", "Perhatian!",
            function(r) {
                if (r) {
                    $("#hapusrekening-supplier > tbody").append("<tr><td><input type='hidden' value='" + $(obj).parents("tr").find(".sumberdanarek_id").val() + "' name='delete[sumberdanarek_id][]'></td></tr>");
                    $(obj).parents("tr").remove();
                }
            });
    }

    function tambahRekening(st) {
        var idK = $("#<?php echo CHtml::activeId($modSumber, 'rekening_kredit') ?>").val();
        var idD = $("#<?php echo CHtml::activeId($modSumber, 'rekening_debit') ?>").val();
        var id = '';
        var tipe = '';

        if (idK.trim() == "" && st == 'K') {
            myAlert("Rekening Kredit Belum Dipilih");
            return false;
        }

        if (idD.trim() == "" && st == 'D') {
            myAlert("Rekening Debit Belum Dipilih");
            return false;
        }

        if (st == 'D') {
            id = idD;
        } else if (st == 'K') {
            id = idK;
        }

        $.post('<?php echo $this->createUrl('formRekening'); ?>', {
            id: id,
            debitkredit: st,
            tipe: tipe
        }, function(data) {
            if (st == 'K') {
                $("#<?php echo CHtml::activeId($modSumber, 'rekKredit') ?>").val("");
                $("#<?php echo CHtml::activeId($modSumber, 'rekening_kredit') ?>").val("");

                $("#tab_rekening_kredit tbody").append(data.dat);
            } else if (st == 'D') {
                $("#<?php echo CHtml::activeId($modSumber, 'rekDebit') ?>").val("");
                $("#<?php echo CHtml::activeId($modSumber, 'rekening_debit') ?>").val("");

                $("#tab_rekening_debit tbody").append(data.dat);
            }
        }, 'json');
    }
</script>