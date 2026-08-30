<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gzmenudiet-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#MenuDietM_jenisdiet_id',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <div class='control-group'>
            <?php echo CHtml::label('Tipe Diet <span class="required">*</span>', 'tipediet_id', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'tipediet_id', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'tipediet_nama',
                    'sourceUrl' => Yii::app()->createUrl('gizi/MenuDietM/AutoCompleteTipeDiet'),
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                                           $(this).val(ui.item.label);
                                                           return false;
                                                       }',
                        'select' => 'js:function( event, ui ) {
                                                                   $(this).val(ui.item.label);
                                                                   $("#' . CHtml::ActiveId($model, 'tipediet_id') . '").val(ui.item.value);
                                                                       return false;
                                                                 }'
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => 'Nama Jenis Diet',
                        'class' => 'span3',
                        'style' => 'width:100px;',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogTipeDiet',),
                ));
                ?>
            </div>
        </div>
        <div class='control-group'>
            <?php echo $form->labelEx($model, 'jenisdiet_id', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'jenisdiet_id', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'jenisdiet_nama',
                    'sourceUrl' => Yii::app()->createUrl('gizi/MenuDietM/AutoCompleteJenisDiet'),
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                                           $(this).val(ui.item.label);
                                                           return false;
                                                       }',
                        'select' => 'js:function( event, ui ) {
                                                                   $(this).val(ui.item.label);
                                                                   $("#' . CHtml::ActiveId($model, 'jenisdiet_id') . '").val(ui.item.value);
                                                                       return false;
                                                                 }'
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => 'Nama Jenis Diet',
                        'class' => 'span3',
                        'style' => 'width:100px;',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogJenisDiet',),
                ));
                ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'menudiet_nama', array('placeholder' => 'Menu Diet', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event)", 'size' => 60, 'maxlength' => 200)); ?>
        <?php echo $form->textFieldRow($model, 'menudiet_namalain', array('placeholder' => 'Nama Lain Menu', 'onkeypress' => "return $(this).focusNextInputField(event)", 'size' => 60, 'maxlength' => 200)); ?>
        <div class='control-group'>
            <?php echo CHtml::label('Tindakan Menu Diet', 'daftartindakan_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'daftartindakan_id', array('class' => 'span1')); ?>
                <?php
                if (isset($model->daftartindakan_id)) {
                    $modDaftarTindakan = DaftartindakanM::model()->findByPk($model->daftartindakan_id);
                    if (isset($modDaftarTindakan)) {
                        $daftartindakan = $modDaftarTindakan->daftartindakan_nama;
                    } else {
                        $daftartindakan = '';
                    }
                } else {
                    $daftartindakan = '';
                }
                $this->widget('MyJuiAutoComplete', array(
                    'name' => CHtml::activeId($model, 'daftartindakan_nama'),
                    'value' => $daftartindakan,
                    'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/tarifTindakanDiet'),
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                                        $(this).val(ui.item.harga_tariftindakan);
                                                        return false;
                                                    }',
                        'select' => 'js:function( event, ui ) {
                                                                $(this).val(ui.item.harga_tariftindakan);
                                                                $("#MenuDietM").val(ui.item.daftartindakan_id);
                                                                    return false;
                                                              }'
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => 'Uraian Tindakan',
                        'class' => 'span3',
                        'style' => 'width:100px;',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogTarifDiet',),
                ));
                ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'jml_porsi', array('placeholder' => 'Jumlah Porsi', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>

        <div class="control-group">
            <?php echo CHtml::label("Satuan", 'ukuranrumahtangga', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'ukuranrumahtangga', CHtml::listData($model->URTItems, 'lookup_name', 'lookup_value'), array(
                    'class' => 'inputRequire span2', 'style' => "margin-right:150px;", 'onkeypress' => "return $(this).focusNextInputField(event)",
                    'empty' => '-- Pilih --',
                ));
                ?>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Menu Diet</b>
                </div>
            </div>
            <div class="panel-body table-responsive" id="divZatgizi">
                <span class="help-block">Kandungan Menu Diet :</span>
                <?php
                $datas = ZatgiziM::model()->findAll(array(
                    'order' => 'zatgizi_nama',
                ));
                $md = CHtml::listData($modZatMenuDietM, 'zatgizi_id', 'kandunganmenudiet');
                $gid = array();
                foreach ($md as $idx => $val) {
                    array_push($gid, $idx);
                }
                $returnVal = array();
                $tr = '';
                $inputHiddenZatgizi = '<input type="hidden" size="4" name="zatgizi_id[]" readonly="true"/>';
                /* $returnVal = '<table id="tblinputzatgizi" class="table table-condensed table-bordered span3" style="width:500px;"><th> Pilih Semua <br>'.CHtml::checkBox('checkUncheck', false, array('onclick'=>'checkUncheckAll(this);')).'</th>
              <th>Nama Zatgizi</th><th>'.$inputHiddenZatgizi.'Kandungan</th>'; */
                $returnVal = '<table id="tblinputzatgizi" class="table table-condensed table-bordered table-striped span1" style="width:400px; float:left;"><th> Pilih </th>
                                                  <th>Nama Zatgizi</th><th>' . $inputHiddenZatgizi . 'Kandungan</th>';
                foreach ($datas as $data) {
                    $c = false;
                    $v = 0;
                    if (in_array($data->zatgizi_id, $gid)) {
                        $c = true;
                        $v = $md[$data->zatgizi_id];
                    }
                    $tr .= "<tr><td>";
                    $tr .= CHtml::checkBox('zatgizi_id[]', $c, array('value' => $data->getAttribute('zatgizi_id')));
                    $tr .= '</td><td width="100%">' . $data->getAttribute('zatgizi_nama');
                    $tr .= '</td><td nowrap>' . CHtml::textField("kandunganmenudiet[$data->zatgizi_id]", number_format($v, 2, ",", ""), array('size' => 6, 'class' => 'default float2 span2', 'style' => 'text-align: right'));
                    $tr .= ' ' . $data->zatgizi_satuan;
                    $tr .= "</td></tr>";
                }
                $returnVal .= $tr;
                $returnVal .= '</table>';
                echo $returnVal;
                ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'onKeyUp' => 'return formSubmit(this,event)'));
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/menuDietM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Menu Diet', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('menuDietM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    );
    ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit3a', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<?php
//========= Dialog buat cari data Tarif Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogTarifDiet',
    'options' => array(
        'title' => 'Daftar Tarif Diet',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 400,
        'resizable' => true,
    ),
));

$modTarifDiet = new TariftindakanM('search');
$modTarifDiet->unsetAttributes();
$modTarifDiet->komponentarif_id = 6;
if (isset($_GET['TariftindakanM'])) {
    $modTarifDiet->attributes = $_GET['TariftindakanM'];
}
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
    'id' => 'tarifdiet-m-grid',
    'dataProvider' => $modTarifDiet->searchTarifDiet2(),
    'filter' => $modTarifDiet,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
                                    "id" => "selectRekDebit",
                                    "onClick" =>"
                                                $(\"#MenuDietM_daftartindakan_nama\").val(\"".$data->daftartindakan->daftartindakan_nama."\");
                                                $(\"#MenuDietM_daftartindakan_id\").val(\"$data->daftartindakan_id\");
                                                $(\"#dialogTarifDiet\").dialog(\"close\");
                                                return false;
                            "))',
        ),
        array(
            'header' => 'Daftar Tindakan',
            'name' => 'daftartindakan_nama',
            'value' => '$data->daftartindakan->daftartindakan_nama',
        ),
        array(
            'header' => 'Tindakan Medis',
            'name' => 'tindakanmedis_nama',
            'value' => '$data->daftartindakan->tindakanmedis_nama',
        ), /*
      array(
      'header'=>'Kelas Pelayanan',
      'name'=>'kelaspelayanan_nama',
      'value'=>'$data->kelaspelayanan->kelaspelayanan_nama',
      ),
      array(
      'header'=>'Harga Tarif Diet',
      'name'=>'harga_tariftindakan',
      'value'=>'MyFormatter::formatNumberForPrint($data->harga_tariftindakan)',
      ), */
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Tarif Diet dialog =============================
?>

<?php
//========= Dialog buat cari data Jenis diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogJenisDiet',
    'options' => array(
        'title' => 'Jenis Diet',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 400,
        'resizable' => true,
    ),
));

$modJenisDiet = new GZJenisdietM('searchJenisDiet');
$modJenisDiet->unsetAttributes();

if (isset($_GET['GZJenisdietM'])) {
    $modJenisDiet->attributes = $_GET['GZJenisdietM'];
}
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
    'id' => 'jenisdiet-m-grid',
    'dataProvider' => $modJenisDiet->searchJenisDiet(),
    'filter' => $modJenisDiet,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
                                    "id" => "selectJenisDiet",
                                    "onClick" =>"
                                                $(\"#' . CHtml::ActiveId($model, 'jenisdiet_id') . '\").val(\"".$data->jenisdiet_id."\");
                                                $(\"#' . CHtml::ActiveId($model, 'jenisdiet_nama') . '\").val(\"$data->jenisdiet_nama\");
                                                $(\"#dialogJenisDiet\").dialog(\"close\");
                                                return false;
                            "))',
        ),
        array(
            'header' => 'Nama Jenis Diet',
            'name' => 'jenisdiet_nama',
            'value' => '$data->jenisdiet_nama',
        ),
        array(
            'header' => 'Nama Lainnya',
            'name' => 'jenisdiet_namalainnya',
            'value' => '$data->jenisdiet_namalainnya',
        )
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Jenis Diet dialog =============================
?>

<?php
//========= Dialog buat cari data Tipe diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogTipeDiet',
    'options' => array(
        'title' => 'Tipe Diet',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 400,
        'resizable' => true,
    ),
));

$modTipeDiet = new GZTipeDietM('searchDialog');
$modTipeDiet->unsetAttributes();

if (isset($_GET['GZTipeDietM'])) {
    $modTipeDiet->attributes = $_GET['GZTipeDietM'];
    $modTipeDiet->tipediet_aktif = true;
}
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
    'id' => 'tipediet-m-grid',
    'dataProvider' => $modTipeDiet->searchDialog(),
    'filter' => $modTipeDiet,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
                                    "id" => "selectTipeDiet",
                                    "onClick" =>"
                                                $(\"#' . CHtml::ActiveId($model, 'tipediet_id') . '\").val(\"".$data->tipediet_id."\");
                                                $(\"#' . CHtml::ActiveId($model, 'tipediet_nama') . '\").val(\"$data->tipediet_nama\");
                                                $(\"#dialogTipeDiet\").dialog(\"close\");
                                                return false;
                            "))',
        ),
        array(
            'header' => 'Nama Tipe Diet',
            'name' => 'tipediet_nama',
            'value' => '$data->tipediet_nama',
        ),
        array(
            'header' => 'Nama Lainnya',
            'name' => 'tipediet_namalainnya',
            'value' => '$data->tipediet_namalainnya',
        )
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Jenis Diet dialog =============================
?>

<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('MenuDietM_menudiet_namalain').value = nama.value.toUpperCase();
    }
</script>