<div class="panel panel-success" style="margin-top: 17px;">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Form <b>Setoran Bendahara</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->label($model, 'tglsetoranbdhara', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglsetoranbdhara',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                //                                                    'minDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'class' => 'dtPicker3 span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        )); ?>

                    </div>
                </div>

                <?php // echo $form->textFieldRow($model, 'tglsetoranbdhara', array('class'=>'span3 realtime', 'readonly'=>true)); 
                ?>
                <?php echo $form->textFieldRow($model, 'nosetoranbdhara', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
            <div class="col-sm-6">

                <?php echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true)); ?>
                <?php echo $form->hiddenField($model, 'pegawai_nama', array('readonly' => true)); ?>
                <?php echo $form->textFieldRow($model, 'pegawai_nama', array('class' => 'span3', 'readonly' => true)); ?>

                <div class="control-group">
                    <?php echo $form->labelEx($model, 'mengetahui_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'mengetahui_id', array('readonly' => true)); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'mengetahui_nama',
                            'source' => 'js: function(request, response) {
                                       $.ajax({
                                           url: "' . $this->createUrl('AutocompletePegawaiSetoran') . '",
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
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                            $(this).val( ui.item.label);
                            return false;
                        }',
                                'select' => 'js:function( event, ui ) {
                            $("#' . CHtml::activeId($model, 'mengetahui_id') . '").val(ui.item.mengetahui_id); 
                            return false;
                        }',
                            ),
                            'htmlOptions' => array(
                                'placeholder' => 'Pegawai Mengetahui',
                                'class' => 'span3',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "") $("#' . CHtml::activeId($model, 'mengetahui_id') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                        ));
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <?php echo $form->textFieldRow($setorbank, 'norekening', array('placeholder' => 'No. Rekening', 'class' => 'span3')); ?>
                <?php
                $bankMod = BankM::model()->findAll('bank_aktif = true order by namabank');
                $bankData = CHtml::listData($bankMod, 'namabank', 'namabank');
                $bankOption = array();

                foreach ($bankMod as $item) {
                    $rekening5_id = null;
                    $nmrekening5 = null;

                    $rekening = BankrekM::model()->findByAttributes(array(
                        'bank_id' => $item->bank_id,
                        'debitkredit' => 'D',
                    ));

                    if (!empty($rekening)) {
                        $rek5 = Rekening5M::model()->findByPk($rekening->rekening5_id);
                        $rekening5_id = $rekening->rekening5_id;

                        if (!empty($rek5)) {
                            $nmrekening5 = $rek5->nmrekening5;
                        }
                    }

                    $bankOption[$item->namabank] = array(
                        'data-norekening' => $item->norekening,
                        'data-atasnama' => $item->bank_atasnama,
                        'data-rekening5_id' => $rekening5_id,
                        'data-nmrekening5' => $nmrekening5,
                    );
                }

                echo $form->dropDownListRow($setorbank, 'namabank', $bankData, array(
                    'empty' => '-- Pilih --',
                    'class' => 'span3',
                    'onchange' => 'setInputBank(this);',
                    'options' => $bankOption,
                )); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($setorbank, 'nostruksetor', array('placeholder' => 'No. Struk Setor', 'class' => 'span3')); ?>
                <?php echo $form->textFieldRow($setorbank, 'atasnama', array('placeholder' => 'Atas Nama', 'class' => 'span3')); ?>
            </div>
        </div>
    </div>
</div>

<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Pencarian Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawai = new PegawairuanganV();
$modPegawai->unsetAttributes();
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');

if (isset($_GET['PegawairuanganV'])) {
    $modPegawai->attributes = $_GET['PegawairuanganV'];
}
$prov = $modPegawai->search();
$prov->sort->defaultOrder = 'nama_pegawai';

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-grid',
    'dataProvider' => $prov,
    'filter' => $modPegawai,
    //'template'=>"{items}\n{pager}",
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#' . CHtml::activeId($model, 'pegawai_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#' . CHtml::activeId($model, 'pegawai_nama') . '\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawai\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'filter' =>  CHtml::activeTextField($modPegawai, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ), /*
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ), */
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawai, 'nama_pegawai'),
            'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
        ), /*
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ), */
        array(
            'header' => 'Alamat Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawai, 'alamat_pegawai'),
            'value' => '$data->alamat_pegawai',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>

<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiMengetahui',
    'options' => array(
        'title' => 'Pencarian Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawai = new PegawairuanganV();
$modPegawai->unsetAttributes();
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
$modPegawai->pegawai_aktif = true;

if (isset($_GET['PegawairuanganV'])) {
    $modPegawai->attributes = $_GET['PegawairuanganV'];
}

$prov = $modPegawai->search();
$prov->criteria->addCondition("nama_pegawai is not null and trim(nama_pegawai) <> ''");
$prov->sort->defaultOrder = 'nama_pegawai';

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimengetahui-grid',
    'dataProvider' => $prov,
    'filter' => $modPegawai,
    //'template'=>"{items}\n{pager}",
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#' . CHtml::activeId($model, 'mengetahui_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#' . CHtml::activeId($model, 'mengetahui_nama') . '\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'filter' =>  CHtml::activeTextField($modPegawai, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ), /*
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ), */
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawai, 'nama_pegawai'),
            'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
        ), /*
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ), */
        array(
            'header' => 'Alamat Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawai, 'alamat_pegawai'),
            'value' => '$data->alamat_pegawai',
        ),
        array(
            'header' => 'Jabatan',
            'filter' =>  CHtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'name' => 'jabatan_id',
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                } else {
                    return '-';
                }
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>