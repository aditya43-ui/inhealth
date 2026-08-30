<?php

/**
 * - digunakan untuk menampilkan inputan timeout
 * 
 * @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @website      <piindonesia.co.id>
 * @wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
 * 
 */

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'operasitimeout-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
));
?>

<style>
    .add-on {
        float: right;
        display: block;
        width: auto;
        min-width: 22px;
        height: 30px;
        margin-right: -1px;
        padding: 3.5px;
        font-weight: normal;
        line-height: 18px;
        color: #999999;
        text-align: center;
        text-shadow: 0 1px 0 #ffffff;
        background-color: #f5f5f5;
        border: 1px solid #ccc;
        -webkit-border-radius: 3px 0 0 3px;
        -moz-border-radius: 3px 0 0 3px;
        border-radius: 0 3px 3px 0;
    }

    .hasDatepicker {
        float: left;
    }
</style>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<p><b>Sebelum insisi / tindakan (TIME OUT)</b><br>
    Diisi oleh perawat sirkuler, dokter anestesi & operator</p>

<div style="margin-bottom: 5px;">
    <label style="float: left; ">Pukul</label>
    <div class="controls">
        <?php $this->widget('MyDateTimePicker', array(
            'model' => $model,
            'attribute' => 'timeout_tgl',
            //'name'=>'lahir_tgllahir',
            'mode' => 'datetime',
            'options' => array(
                'dateFormat' => Params::DATE_FORMAT,
                'maxDate' => 'd',
                'line' => true
            ),
            'htmlOptions' => array(
                'readonly' => true,
                'class' => 'span3',
                'onkeypress' => "return $(this).focusNextInputField(event)"
            ),
        )); ?>
    </div>
</div>

<div class="clear" style="margin-bottom: 10px;"></div>

<div style="padding: 5px; border: solid 1px #000;">
    <table class="noborder paddingtext">
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Sudah</td>
            <td>Belum</td>
        </tr>
        <?php

        $i = 0;
        foreach ($loadTimeOut as $timeout) {

            if ($timeout['form_haschecklist']) {
                $modDet->isdipilih = $timeout['value'];
                $modDet->text = $timeout['isian'];
        ?>
                <tr>
                    <td><?php echo $i + 1 ?></td>
                    <td><?php echo $timeout['form_nama'] ?></td>
                    <?php
                    if ($timeout['type'] == Params::INPUTTYPE_CHECK) {
                        echo '<td>' . $form->checkBox($modDet, '[' . $timeout['form_id'] . $timeout['check_id'] . ']isdipilih', array('value' => $timeout['form_id'] . $timeout['check_id'] . 'true', 'form_id' => $timeout['form_id'], 'check_id' => $timeout['check_id'], 'status' => 1, 'onchange' => 'pilihTimeOutIni(this);')) . '</td>';
                        echo '<td>' . $form->checkBox($modDet, '[' . $timeout['form_id'] . $timeout['check_id'] . ']isdipilih', array('value' => $timeout['form_id'] . $timeout['check_id'] . 'false', 'form_id' => $timeout['form_id'], 'check_id' => $timeout['check_id'], 'status' => 0, 'onchange' => 'pilihTimeOutIni(this);')) . '</td>';
                    } elseif ($timeout['type'] == Params::INPUTTYPE_TEXTAREA) {
                        echo '<td colspan="2">' . $form->textArea($modDet, '[' . $timeout['form_id'] . $timeout['check_id'] . ']text', array('form_id' => $timeout['form_id'], 'check_id' => $timeout['check_id'], 'onblur' => 'pilihTimeOutTextIni(this);')) . "</td>";
                    }
                    ?>

                </tr>
                <?php

                foreach ($timeout['checklist'] as $check) {
                    $modDet->isdipilih = $check['value'];
                    $modDet->text = $check['isian'];
                ?>
                    <tr>
                        <td>&nbsp;</td>
                        <td> - <?php echo $check['check_nama']; ?></td>
                        <!--<td><?php //echo $form->checkBox($modDet,'['.$timeout['form_id'].$check['check_id'].']isdipilih',array('value'=>$timeout['form_id'].$check['check_id'].'true', 'form_id'=>$timeout['form_id'], 'check_id'=>$check['check_id'], 'status'=>1, 'onchange'=>'pilihTimeOutIni(this);')); 
                                ?></td>-->
                        <!--<td><?php //echo $form->checkBox($modDet,'['.$timeout['form_id'].$check['check_id'].']isdipilih',array('value'=>$timeout['form_id'].$check['check_id'].'false', 'form_id'=>$timeout['form_id'], 'check_id'=>$check['check_id'], 'status'=>0, 'onchange'=>'pilihTimeOutIni(this);')); 
                                ?></td>-->
                        <?php
                        if ($check['type'] == Params::INPUTTYPE_CHECK) {
                            echo "<td>" . $form->checkBox($modDet, '[' . $timeout['form_id'] . $check['check_id'] . ']isdipilih', array('value' => $timeout['form_id'] . $check['check_id'] . 'true', 'form_id' => $timeout['form_id'], 'check_id' => $check['check_id'], 'status' => 1, 'onchange' => 'pilihTimeOutIni(this);')) . "</td>";
                            echo "<td>" . $form->checkBox($modDet, '[' . $timeout['form_id'] . $check['check_id'] . ']isdipilih', array('value' => $timeout['form_id'] . $check['check_id'] . 'false', 'form_id' => $timeout['form_id'], 'check_id' => $check['check_id'], 'status' => 0, 'onchange' => 'pilihTimeOutIni(this);')) . "</td>";
                        } elseif ($check['type'] == Params::INPUTTYPE_TEXTAREA) {
                            echo '<td colspan="2">' . $form->textArea($modDet, '[' . $timeout['form_id'] . $check['check_id'] . ']text', array('form_id' => $timeout['form_id'], 'check_id' => $check['check_id'], 'onblur' => 'pilihTimeOutTextIni(this);')) . "</td>";
                        }
                        ?>
                    </tr>
                <?php
                }
                echo '<tr>
											<td colspan="4">&nbsp;</td>
										</tr>';
            } else {
                $modDet->isdipilih = $timeout['value'];
                $modDet->text = $timeout['isian'];
                ?>
                <tr>
                    <td><?php echo $i + 1 ?></td>
                    <td><?php echo $timeout['form_nama']; ?></td>
                    <?php
                    if ($timeout['type'] == Params::INPUTTYPE_CHECK) {
                        echo '<td>' . $form->checkBox($modDet, '[' . $timeout['form_id'] . $timeout['check_id'] . ']isdipilih', array('value' => $timeout['form_id'] . $timeout['check_id'] . 'true', 'form_id' => $timeout['form_id'], 'check_id' => $timeout['check_id'], 'status' => 1, 'onchange' => 'pilihTimeOutIni(this);')) . '</td>';
                        echo '<td>' . $form->checkBox($modDet, '[' . $timeout['form_id'] . $timeout['check_id'] . ']isdipilih', array('value' => $timeout['form_id'] . $timeout['check_id'] . 'false', 'form_id' => $timeout['form_id'], 'check_id' => $timeout['check_id'], 'status' => 0, 'onchange' => 'pilihTimeOutIni(this);')) . '</td>';
                    } elseif ($timeout['type'] == Params::INPUTTYPE_TEXTAREA) {
                        echo '<td colspan="2">' . $form->textArea($modDet, '[' . $timeout['form_id'] . $timeout['check_id'] . ']text', array('form_id' => $timeout['form_id'], 'check_id' => $timeout['check_id'], 'onblur' => 'pilihTimeOutTextIni(this);')) . "</td>";
                    }
                    ?>
                </tr>
        <?php
            }

            $i++;
        }
        ?>
    </table>
</div>

<hr>

<table id="tampung-timeout" hidden>
    <tbody>
        <?php
        if (count((array)$getDet) > 0) {
            $i = 0;
            foreach ($getDet as $set) {
                if ($set->checklisttimeout_id == null || $set->checklisttimeout_id == '') {
                    $checklist = 'kosong';
                    $set->checklisttimeout_id = 'kosong';
                } else {
                    $checklist = $set->checklisttimeout_id;
                }

                if ($set->timeoutdet_hasil == false) {
                    $set->timeoutdet_hasil = 0;
                }

                $set->identifier = $set->formtimeout_id . '_' . $checklist;
                echo $this->renderPartial($this->path_view . "timeout._formGetTimeOut", array('modDet' => $set, 'i' => $i), true);
                $i++;
            }
        }
        ?>
    </tbody>
</table>

<div class="row">
    <div class="col-sm-12">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'perawatsirkuler_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php //echo $form->dropDownList($modPasienMasukPenunjang,'perawat_id', CHtml::listData(LBPegawaiM::model()->getTenagaLaboratoriums($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'namaLengkap') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); 
                echo $form->hiddenField($model, 'perawatsirkuler_id', array('readonly' => true, 'class' => 'perawatsirkuler_id'));

                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'perawatsirkuler_nama',
                    'source' => 'js: function(request, response) {
							$.ajax({
							url: "' . $this->createUrl('/ActionAutoComplete/dropPerawatRuangan') . '",
							dataType: "json",
							data: {
								term: request.term,
								ruangan_id: ' . Yii::app()->user->getState('ruangan_id') . '
							},
							success: function (data) {
								response(data);
							}
						})
					}',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 0,
                        'focus' => 'js:function( event, ui ) {
							 $(this).val( ui.item.label);
							 return false;
						 }',
                        'select' => 'js:function( event, ui ) {
							 $("#' . CHtml::ActiveId($model, 'perawatsirkuler_id') . '").val(ui.item.value); 
							 return false;
						 }',
                    ),
                    'htmlOptions' => array('class' => 'span3', 'onblur' => "if ($('.perawatsirkuler_id').val().trim() == '') { $(this).val(''); } ")
                ));

                ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'dokterbedah_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php //echo $form->dropDownList($modPasienMasukPenunjang,'perawat_id', CHtml::listData(LBPegawaiM::model()->getTenagaLaboratoriums($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'namaLengkap') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); 
                echo $form->hiddenField($model, 'dokterbedah_id', array('readonly' => true, 'class' => 'dokterbedah_id'));

                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'dokterbedah_nama',
                    'source' => 'js: function(request, response) {
							$.ajax({
							url: "' . $this->createUrl('/ActionAutoComplete/dropDokterRuangan') . '",
							dataType: "json",
							data: {
								term: request.term,
								ruangan_id: ' . Yii::app()->user->getState('ruangan_id') . '
							},
							success: function (data) {
								response(data);
							}
						})
					}',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 0,
                        'focus' => 'js:function( event, ui ) {
							 $(this).val( ui.item.label);
							 return false;
						 }',
                        'select' => 'js:function( event, ui ) {
							 $("#' . CHtml::ActiveId($model, 'dokterbedah_id') . '").val(ui.item.value); 
							 return false;
						 }',
                    ),
                    'htmlOptions' => array('class' => 'span3', 'onblur' => "if ($('.dokterbedah_id').val().trim() == '') { $(this).val(''); } ")
                ));

                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'dokteranestesi_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php //echo $form->dropDownList($modPasienMasukPenunjang,'pegawai_id', CHtml::listData(LBPendaftaranT::model()->getDokterItems($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'namaLengkap') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); 
                echo $form->hiddenField($model, 'dokteranestesi_id', array('readonly' => true, 'class' => 'required dokteranestesi_id'));

                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'dokteranestesi_nama',
                    'source' => 'js: function(request, response) {
							$.ajax({
							url: "' . $this->createUrl('/ActionAutoComplete/dropDokterRuangan') . '",
							dataType: "json",
							data: {
								term: request.term,
								ruangan_id: ' . Yii::app()->user->getState('ruangan_id') . '
							},
							success: function (data) {
								response(data);
							}
						})
					}',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 0,
                        'focus' => 'js:function( event, ui ) {
							 $(this).val( ui.item.label);
							 return false;
						 }',
                        'select' => 'js:function( event, ui ) {
							 $("#' . CHtml::ActiveId($model, 'dokteranestesi_id') . '").val(ui.item.value); 
							 return false;
						 }',
                    ),
                    'htmlOptions' => array('class' => 'span3 required', 'onblur' => "if ($('.dokteranestesi_id').val().trim() == '') { $(this).val(''); } ")
                ));

                ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php
    if (!isset($_GET['sukses'])) {
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onkeypress' => 'formSubmit(this,event);')
        );
    } else {
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'disabled' => true, 'style' => 'cursor:not-allowed;')
        );
    }
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('index'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    //$content = $this->renderPartial('tips/tipsPendaftaranBedahSentralRujukanRS',array(),true);
    //$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
    ?>
</div>

<?php $this->endWidget(); ?>

<?php echo $this->renderPartial($this->path_view . 'timeout._jsFunctions', array('modDet' => $modDet, 'model' => $model), true); ?>