<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Rekening Pelayanan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Rekening Pelayanan' => Yii::app()->request->getUrlReferrer(),
            'Ubah',
        );

        $arrMenu = array();
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data Rekening Pelayanan telah berhasil disimpan!");
        }
        //$this->menu=$arrMenu;
        $this->widget('bootstrap.widgets.BootAlert');

        $cssKredit = '';
        $cssDebit = '';
        if ($model->debitkredit == 'D') {
            $cssKredit = 'display:none;';
        } else {
            $cssDebit = 'display:none;';
        }

        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'tindakanruangan-m-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#' . CHtml::activeId($model, 'instalasi_id'),
        ));
        ?>
        <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <?php echo $form->errorSummary($model); ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($model, "daftartindakan_id", array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'daftartindakan_id'); ?>
                        <?php echo $form->hiddenField($model, 'ruangan_id'); ?>
                        <?php echo $form->hiddenField($model, 'komponentarif_id'); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'daftartindakan_nama',
                            'source' => 'js: function(request, response) {
                                    $.ajax({
					url: "' . $this->createUrl('AutocompleteTindakan') . '",
					dataType: "json",
					data: {
                                            term: request.term,
					},
					success: function (data) {
                                            response(data);
					}
                                    })
				}',
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
					$(this).val( ui.item.value);
					return false;
					}',
                                'select' => 'js:function( event, ui ) {
					$("#' . CHtml::activeId($model, 'daftartindakan_id') . '").val(ui.item.daftartindakan_id);
					return false;
					}',
                            ),
                            'htmlOptions' => array(
                                'placeholder' => 'Kode / Uraian Tindakan',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'readonly' => true,
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogTindakan'),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, "Komponen Tarif", array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, "komponentarif_nama", array('readonly' => true, 'span' => 'span3')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, "Ruangan", array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, "ruangan_nama", array('readonly' => true, 'span' => 'span3')); ?>
                    </div>
                </div>
                <div class="control-group" style="<?php echo $cssDebit; ?>">
                    <?php echo $form->labelEx($model, 'Akun Debit', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'rekening5_id_d'); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'nmrekening5_d',
                            'source' => 'js: function(request, response) {
                                    $.ajax({
					url: "' . $this->createUrl('AutocompleteRekDebit') . '",
					dataType: "json",
					data: {
                                            term: request.term,
					},
					success: function (data) {
                                            response(data);
					}
                                    })
				}',
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
					$(this).val( ui.item.value);
					return false;
					}',
                                'select' => 'js:function( event, ui ) {
					$("#' . CHtml::activeId($model, 'rekening5_id_d') . '").val(ui.item.rekening5_id);
					return false;
					}',
                            ),
                            'htmlOptions' => array(
                                'placeholder' => 'Kode / Nama Akun',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'readonly' => true,
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogRekDebit'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group" style="<?php echo $cssKredit; ?>">
                    <?php echo $form->labelEx($model, 'Akun Kredit', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'rekening5_id_k'); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'nmrekening5_k',
                            'source' => 'js: function(request, response) {
                                    $.ajax({
					url: "' . $this->createUrl('AutocompleteRekDebit') . '",
					dataType: "json",
					data: {
                                            term: request.term,
					},
					success: function (data) {
                                            response(data);
					}
                                    })
				}',
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
					$(this).val( ui.item.value);
					return false;
					}',
                                'select' => 'js:function( event, ui ) {
					$("#' . CHtml::activeId($model, 'rekening5_id_k') . '").val(ui.item.rekening5_id);
					return false;
					}',
                            ),
                            'htmlOptions' => array(
                                'placeholder' => 'Kode / Nama Akun',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'readonly' => true,
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogRekKredit'),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'jnspelayanan', array('class' => 'control-label')); ?>

                    <div class="controls">
                        <?php
                        $model->jnspelayanan = "TM";
                        echo $form->hiddenField($model, 'jnspelayanan', array('class' => 'span3', 'readonly' => true));
                        echo CHtml::textField('jnspelayanan_nama', 'Tindakan Medis (TM)', array('class' => 'span3', 'readonly' => true)); ?>
                        <?php
                        // echo $form->dropDownList($model, 'jnspelayanan', CHtml::listData(SALookupM::getItemsList(), 'lookup_value', 'lookup_name'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        //));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                        <?php echo $form->checkBox($model, 'ispelayanan', array('uncheckValue' => false)); ?>
                        <label for="AKPelayananRekM_ispelayanan">Pelayanan</label>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                        <?php echo $form->checkBox($model, 'ispembayaran', array('uncheckValue' => false)); ?>
                        <label for="AKPelayananRekM_ispembayaran">Pembayaran</label>
                    </div>
                </div>

                <div class="control-group">

                    <div class="controls">
                        <!--<?php // echo  $form->checkBox($model, 'isretur', array('uncheckValue'=>false)); 
                            ?> <label>Retur</label>-->
                    </div>
                </div>

                <div class="control-group">

                    <div class="controls">
                        <!--<?php // echo $form->checkBox($model, 'ishutang', array('uncheckValue'=>false)); 
                            ?> <label>Hutang</label>-->
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
            );
            ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Akun Pelayanan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php
            $content = $this->renderPartial($this->path_view . 'tips.tipsaddedit3', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>

        <?php
        //========= Dialog buat cari data Daftar Tindakan =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogTindakan',
            'options' => array(
                'title' => 'Daftar Tindakan',
                'autoOpen' => false,
                'modal' => true,
                'width' => 1000,
                'height' => 500,
                'resizable' => false,
            ),
        ));

        $modDaftarTindakan = new SATariftindakanruangandetailV('search');
        $modDaftarTindakan->unsetAttributes();
        if (isset($_GET['SATariftindakanruangandetailV'])) {
            $modDaftarTindakan->attributes = $_GET['SATariftindakanruangandetailV'];
            $modDaftarTindakan->komponenunit_id = $_GET['SATariftindakanruangandetailV']['komponenunit_id'];
        } else {
            //$modDaftarTindakan->ruangan_id = Yii::app()->user->getState('ruangan_id');
        }

        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'daftartindakan-m-grid',
            'dataProvider' => $modDaftarTindakan->search(),
            'filter' => $modDaftarTindakan,
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-condensed table-bordered',
            'columns' => array(
                array(
                    'header' => 'Pilih',
                    'type' => 'raw',
                    'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small",
                                    "id" => "selectTindakan",
                                    "onClick" => "
                                    $(\"#' . CHtml::activeId($model, 'daftartindakan_id') . '\").val(\'$data->daftartindakan_id\');
                                    $(\"#' . CHtml::activeId($model, 'daftartindakan_nama') . '\").val(\'$data->daftartindakan_nama\');
                                    $(\"#' . CHtml::activeId($model, 'ruangan_id') . '\").val(\'$data->ruangan_id\');
                                    $(\"#' . CHtml::activeId($model, 'komponentarif_id') . '\").val(\'$data->komponentarif_id\');
                                    $(\"#' . CHtml::activeId($model, 'komponentarif_nama') . '\").val(\'".$data->komponentarif_nama."\');
				    $(\"#' . CHtml::activeId($model, 'ruangan_nama') . '\").val(\'".$data->ruangan_nama."\');
                                    $(\'#dialogTindakan\').dialog(\'close\');
                                    return false;"))'
                ),
                array(
                    'header' => 'Kelompok Tindakan',
                    'name' => 'kelompoktindakan_nama',
                    'value' => 'isset($data->kelompoktindakan_nama)?$data->kelompoktindakan_nama:" - "',
                    'filter' => CHtml::activeDropDownList($modDaftarTindakan, 'kelompoktindakan_id', CHtml::listData(SAKelompokTindakanM::getItems(), 'kelompoktindakan_id', 'kelompoktindakan_nama'), array('empty' => '-- Pilih --')),
                ),
                array(
                    'name' => 'komponenunit_id',
                    'header' => 'Komponen Unit',
                    'value' => function ($data) {
                        $ku = KomponenunitM::model()->findByPk($data->komponenunit_id);
                        return $ku->komponenunit_nama;
                    },
                    'filter' => CHtml::activeDropDownList($modDaftarTindakan, 'komponenunit_id', CHtml::listData(SAKomponenUnitM::getItems(), 'komponenunit_id', 'komponenunit_nama'), array('empty' => '-- Pilih --')),
                ),
                array(
                    'header' => 'Kategori Tindakan',
                    'name' => 'kategoritindakan_nama',
                    'filter' => CHtml::activeDropDownList($modDaftarTindakan, 'kategoritindakan_id', CHtml::listData(SAKategoriTindakanM::getItems(), 'kategoritindakan_id', 'kategoritindakan_nama'), array('empty' => '-- Pilih --')),
                ),
                array(
                    'header' => 'Ruangan',
                    'name' => 'ruangan_nama',
                    'filter' => CHtml::activeDropDownList($modDaftarTindakan, 'ruangan_id', CHtml::listData(SARuanganM::getItemsList(), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --')),
                ),
                array(
                    'header' => 'Kode Tindakan',
                    'name' => 'daftartindakan_kode',
                    'value' => 'isset($data->daftartindakan_kode)?$data->daftartindakan_kode:" - "',
                ),
                array(
                    'header' => 'Uraian Tindakan',
                    'name' => 'daftartindakan_nama',
                    'value' => 'isset($data->daftartindakan_nama)?$data->daftartindakan_nama:" - "',
                ),
                array(
                    'header' => 'Komponen Tarif',
                    'name' => 'komponentarif_nama',
                    'filter' => CHtml::activeDropDownList($modDaftarTindakan, 'komponentarif_id', CHtml::listData(SAKomponentarifM::getItemsList(), 'komponentarif_id', 'komponentarif_nama'), array('empty' => '-- Pilih --')),
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));

        $this->endWidget();
        ?>

        
<?php
//========= Dialog buat cari data Rek Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRekDebit',
    'options' => array(
        'title' => 'Daftar Rekening Debit',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 400,
        'resizable' => false,
    ),
));

$modRekDebit = new Rekeningakuntansi5V('searchDialogAccount');
$modRekDebit->unsetAttributes();
$modRekDebit->rekeninglast_nb = "D";
$account = "";
if (isset($_GET['Rekeningakuntansi5V'])) {
    $modRekDebit->attributes = $_GET['Rekeningakuntansi5V'];
    $modRekDebit->rekening5_id = (!empty($_GET['Rekeningakuntansi5V']['rekening5_id']) ? $_GET['Rekeningakuntansi5V']['rekening5_id']: null);
    $modRekDebit->rekening6_id = (!empty($_GET['Rekeningakuntansi5V']['rekening6_id']) ? $_GET['Rekeningakuntansi5V']['rekening6_id']: null);
    $modRekDebit->rekening7_id = (!empty($_GET['Rekeningakuntansi5V']['rekening7_id']) ? $_GET['Rekeningakuntansi5V']['rekening7_id']: null);
}

//$this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
$this->widget('ext.bootstrap.widgets.BootGridView', array(
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
                    $(\"#' . CHtml::activeId($model, 'rekening5_id_d') . '\").val(\'$data->rekening5_id\');
                    $(\"#' . CHtml::activeId($model, 'nmrekening5_d') . '\").val(\'$data->namarekeninglast\');
                    $(\'#dialogRekDebit\').dialog(\'close\');    
					return false;
			"))',
        ),
        array(
            'header' => 'Kode Akun',
            'type' => 'raw',
            'value' => '$data->koderekeninglast',
            'filter' => Chtml::activeTextField($modRekDebit, 'koderekeninglast', array('class' => 'numbers-only', 'maxlength' => 12))
        ),
        array(
            'header' => 'Kelompok Akun',
            'type' => 'raw',
            'value' => function ($data) {
                $kel = KelrekeningM::model()->findByPk($data->kelompokrekeninglast_id);
                return $kel ? $kel->namakelrekening : "-";
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'kelompokrekeninglast_id', CHtml::listData(
                KelrekeningM::model()->findAll(array(
                    'condition' => 'kelrekening_aktif = true',
                    'order' => 'koderekeningkel',
                )),
                'kelrekening_id',
                'namakelrekening'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 1',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening1;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening1_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening1_id is not null',
                    'order' => 'namarekening1 ASC',
                )),
                'rekening1_id',
                'namarekening1'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 2',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening2;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening2_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening2_id is not null',
                    'order' => 'namarekening2 ASC',
                )),
                'rekening2_id',
                'namarekening2'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 3',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening3;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening3_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening3_id is not null',
                    'order' => 'namarekening3 ASC',
                )),
                'rekening3_id',
                'namarekening3'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 4',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening4;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening4_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening4_id is not null',
                    'order' => 'namarekening4 ASC',
                )),
                'rekening4_id',
                'namarekening4'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 5',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening5;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening5_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening5_id is not null',
                    'order' => 'namarekening5 ASC',
                )),
                'rekening5_id',
                'namarekening5'
            ), array('empty' => '-- Pilih --')),
            'visible' => ((Yii::app()->user->getState("levelrekeninglast") >= 6) ? true: false)
        ),
        array(
            'header' => 'Rekening Level 6',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening6;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening6_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening6_id is not null',
                    'order' => 'namarekening6 ASC',
                )),
                'rekening6_id',
                'namarekening6'
            ), array('empty' => '-- Pilih --')),
            'visible' => ((Yii::app()->user->getState("levelrekeninglast") >= 7) ? true: false)
        ),
        array(
            'header' => 'Rekening Level 7',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening7;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening7_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening7_id is not null',
                    'order' => 'namarekening7 ASC',
                )),
                'rekening7_id',
                'namarekening7'
            ), array('empty' => '-- Pilih --')),
            'visible' => ((Yii::app()->user->getState("levelrekeninglast") >= 8) ? true: false)
        ),
        array(
            'header' => 'Nama Rekening Terakhir',
            'type' => 'raw',
            'value' => '$data->namarekeninglast',
            'filter' => Chtml::activeTextField($modRekDebit, 'namarekeninglast', array('class' => 'custom-only'))
        ),
        array(
            'header' => 'Saldo Normal',
            'type' => 'raw',
            'value' => '($data->rekeninglast_nb == "D") ? "Debit" : "Kredit"',
            'filter' =>  CHtml::activeDropDownList($modRekDebit, 'rekeninglast_nb', array('D' => 'Debit', 'K' => 'Kredit'), array('empty' => "-- Pilih --")),
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function() {
            setNumbersOnly(this);
            });
            $(".custom-only").keyup(function() {
            setCustomOnly(this);
            });'
        . '}',
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
        'width' => 1000,
        'height' => 400,
        'resizable' => false,
    ),
));

$modRekKredit = new Rekeningakuntansi5V('searchDialogAccount');
$modRekKredit->unsetAttributes();
$modRekKredit->rekeninglast_nb = "K";
$account = "";
if (isset($_GET['Rekeningakuntansi5V'])) {
    $modRekKredit->attributes = $_GET['Rekeningakuntansi5V'];
    $modRekKredit->rekening5_id = (!empty($_GET['Rekeningakuntansi5V']['rekening5_id']) ? $_GET['Rekeningakuntansi5V']['rekening5_id']: null);
    $modRekKredit->rekening6_id = (!empty($_GET['Rekeningakuntansi5V']['rekening6_id']) ? $_GET['Rekeningakuntansi5V']['rekening6_id']: null);
    $modRekKredit->rekening7_id = (!empty($_GET['Rekeningakuntansi5V']['rekening7_id']) ? $_GET['Rekeningakuntansi5V']['rekening7_id']: null);
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rekkredit-m-grid',
    'dataProvider' => $modRekKredit->searchDialogAccount(),
    'filter' => $modRekKredit,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
				"id" => "selectRekDebit",
				"onClick" =>"
                $(\"#' . CHtml::activeId($model, 'rekening5_id_k') . '\").val(\'$data->rekening5_id\');
                $(\"#' . CHtml::activeId($model, 'nmrekening5_k') . '\").val(\'$data->namarekeninglast\');
                $(\'#dialogRekKredit\').dialog(\'close\');  
					return false;
			"))',
        ),
        array(
            'header' => 'Kode Akun',
            'type' => 'raw',
            'value' => '$data->koderekeninglast',
            'filter' => Chtml::activeTextField($modRekKredit, 'koderekeninglast', array('class' => 'numbers-only', 'maxlength' => 12))
        ),
        array(
            'header' => 'Kelompok Akun',
            'type' => 'raw',
            'value' => function ($data) {
                $kel = KelrekeningM::model()->findByPk($data->kelompokrekeninglast_id);
                return $kel ? $kel->namakelrekening : "-";
            },
            'filter' => CHtml::activeDropDownList($modRekKredit, 'kelompokrekeninglast_id', CHtml::listData(
                KelrekeningM::model()->findAll(array(
                    'condition' => 'kelrekening_aktif = true',
                    'order' => 'koderekeningkel',
                )),
                'kelrekening_id',
                'namakelrekening'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 1',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening1;
            },
            'filter' => CHtml::activeDropDownList($modRekKredit, 'rekening1_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening1_id is not null',
                    'order' => 'namarekening1 ASC',
                )),
                'rekening1_id',
                'namarekening1'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 2',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening2;
            },
            'filter' => CHtml::activeDropDownList($modRekKredit, 'rekening2_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening2_id is not null',
                    'order' => 'namarekening2 ASC',
                )),
                'rekening2_id',
                'namarekening2'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 3',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening3;
            },
            'filter' => CHtml::activeDropDownList($modRekKredit, 'rekening3_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening3_id is not null',
                    'order' => 'namarekening3 ASC',
                )),
                'rekening3_id',
                'namarekening3'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 4',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening4;
            },
            'filter' => CHtml::activeDropDownList($modRekKredit, 'rekening4_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening4_id is not null',
                    'order' => 'namarekening4 ASC',
                )),
                'rekening4_id',
                'namarekening4'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 5',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening5;
            },
            'filter' => CHtml::activeDropDownList($modRekKredit, 'rekening5_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening5_id is not null',
                    'order' => 'namarekening5 ASC',
                )),
                'rekening5_id',
                'namarekening5'
            ), array('empty' => '-- Pilih --')),
            'visible' => ((Yii::app()->user->getState("levelrekeninglast") >= 6) ? true: false)
        ),
        array(
            'header' => 'Rekening Level 6',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening6;
            },
            'filter' => CHtml::activeDropDownList($modRekKredit, 'rekening6_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening6_id is not null',
                    'order' => 'namarekening6 ASC',
                )),
                'rekening6_id',
                'namarekening6'
            ), array('empty' => '-- Pilih --')),
            'visible' => ((Yii::app()->user->getState("levelrekeninglast") >= 7) ? true: false)
        ),
        array(
            'header' => 'Rekening Level 7',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening7;
            },
            'filter' => CHtml::activeDropDownList($modRekKredit, 'rekening7_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening7_id is not null',
                    'order' => 'namarekening7 ASC',
                )),
                'rekening7_id',
                'namarekening7'
            ), array('empty' => '-- Pilih --')),
            'visible' => ((Yii::app()->user->getState("levelrekeninglast") >= 8) ? true: false)
        ),
        array(
            'header' => 'Nama Rekening Terakhir',
            'type' => 'raw',
            'value' => '$data->namarekeninglast',
            'filter' => Chtml::activeTextField($modRekKredit, 'namarekeninglast', array('class' => 'custom-only'))
        ),
        array(
            'header' => 'Saldo Normal',
            'type' => 'raw',
            'value' => '($data->rekeninglast_nb == "D") ? "Debit" : "Kredit"',
            'filter' =>  CHtml::activeDropDownList($modRekKredit, 'rekeninglast_nb', array('D' => 'Debit', 'K' => 'Kredit'), array('empty' => "-- Pilih --")),
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function() {
            setNumbersOnly(this);
            });
            $(".custom-only").keyup(function() {
            setCustomOnly(this);
            });'
        . '}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>


    </div>
</div>
<?php echo $this->renderPartial("sistemAdministrator.views.rekeningPelayanan._jsFunctions", array('model' => $model), true); ?>