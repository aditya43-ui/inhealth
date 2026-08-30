<?php

/**
 * - digunakan untuk menampilkan inputan sign in
 * 
 * @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @website      <piindonesia.co.id>
 * @wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
 * 
 */

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'operasisignin-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
));
?>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

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

<table style="width: 100%;">
    <tr>
        <th>
            <h4 style="color: #000;">CHECK LIST KESELAMATAN PASIEN OPERASI</h4>
        </th>
    </tr>
    <tr>
        <td>
            <table class="noborder paddingtext" width="100%">
                <tr>
                    <td>Sebelum induksi anestersi (SIGN IN)</td>
                </tr>
                <tr>
                    <td>
                        <div style="margin-bottom: 5px;">
                            <label style="float: left; ">Pukul</label>
                            <div class="controls">
                                <?php $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'signin_tgl',
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
                    </td>
                </tr>
                <tr>
                    <td>Diagnosa Pre-Op : <?php echo $form->textField($model, 'signin_diagnosapreop', array('placeholder' => 'Diagnosa Pre-Op', 'style' => 'width: 100%')) ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <div style="padding: 5px; border: solid 1px #000;">
                <table class="noborder">
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>Sudah</td>
                        <td>Belum</td>
                    </tr>
                    <?php

                    $i = 0;
                    foreach ($loadSignIn as $signin) {

                        if ($signin['form_haschecklist']) {
                    ?>
                            <tr>
                                <td><?php echo $i + 1 ?></td>
                                <td><?php echo $signin['form_nama'] ?></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <?php

                            foreach ($signin['checklist'] as $check) {
                                $modDet->isdipilih = $check['value'];
                            ?>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td> - <?php echo $check['check_nama']; ?></td>
                                    <td><?php echo $form->checkBox($modDet, '[' . $signin['form_id'] . $check['check_id'] . ']isdipilih', array('value' => $signin['form_id'] . $check['check_id'] . 'true', 'form_id' => $signin['form_id'], 'check_id' => $check['check_id'], 'status' => 1, 'onchange' => 'pilihSignInIni(this);')); ?></td>
                                    <td><?php echo $form->checkBox($modDet, '[' . $signin['form_id'] . $check['check_id'] . ']isdipilih', array('value' => $signin['form_id'] . $check['check_id'] . 'false', 'form_id' => $signin['form_id'], 'check_id' => $check['check_id'], 'status' => 0, 'onchange' => 'pilihSignInIni(this);')); ?></td>
                                </tr>
                            <?php
                            }
                            echo '<tr>
											<td colspan="4">&nbsp;</td>
										</tr>';
                        } else {
                            $modDet->isdipilih = $signin['value'];
                            ?>
                            <tr>
                                <td><?php echo $i + 1 ?></td>
                                <td><?php echo $signin['form_nama']; ?></td>
                                <td><?php echo $form->checkBox($modDet, '[' . $signin['form_id'] . $signin['check_id'] . ']isdipilih', array('value' => $signin['form_id'] . $signin['check_id'] . 'true', 'form_id' => $signin['form_id'], 'check_id' => $signin['check_id'], 'status' => 1, 'onchange' => 'pilihSignInIni(this);')); ?></td>
                                <td><?php echo $form->checkBox($modDet, '[' . $signin['form_id'] . $signin['check_id'] . ']isdipilih', array('value' => $signin['form_id'] . $signin['check_id'] . 'false', 'form_id' => $signin['form_id'], 'check_id' => $signin['check_id'], 'status' => 0, 'onchange' => 'pilihSignInIni(this);')); ?></td>
                            </tr>
                        <?php
                        }
                        ?>

                        <?php
                        if ($i == 2) {
                        ?>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>Ya</td>
                                <td>Tidak</td>
                            </tr>
                    <?php
                        }

                        $i++;
                    }
                    ?>
                </table>
            </div>
        </td>
    </tr>
</table>

<hr>

<table id="tampung-signin" hidden>
    <tbody>
        <?php
        if (count((array)$getDet) > 0) {
            $i = 0;
            foreach ($getDet as $set) {
                if ($set->checklistsignin_id == null || $set->checklistsignin_id == '') {
                    $checklist = 'kosong';
                    $set->checklistsignin_id = 'kosong';
                } else {
                    $checklist = $set->checklistsignin_id;
                }

                if ($set->signindet_hasil == false) {
                    $set->signindet_hasil = 0;
                }

                $set->identifier = $set->formsignin_id . '_' . $checklist;
                echo $this->renderPartial($this->path_view_rujuk . "signin._formGetSignIn", array('modDet' => $set, 'i' => $i), true);
                $i++;
            }
        }
        ?>
    </tbody>
</table>

<div class="antirow">
    <div class="row">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->labelEx($model, 'perawatsirkuler_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php //echo $form->dropDownList($modPasienMasukPenunjang,'perawat_id', CHtml::listData(LBPegawaiM::model()->getTenagaLaboratoriums($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'namaLengkap') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); 
                    echo $form->hiddenField($model, 'perawatsirkuler_id', array('readonly' => true));

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
                        'htmlOptions' => array('class' => 'span3')
                    ));

                    ?>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->labelEx($model, 'dokteranestesi_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php //echo $form->dropDownList($modPasienMasukPenunjang,'pegawai_id', CHtml::listData(LBPendaftaranT::model()->getDokterItems($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'namaLengkap') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); 
                    echo $form->hiddenField($model, 'dokteranestesi_id', array('readonly' => true, 'class' => 'required'));

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
                        'htmlOptions' => array('class' => 'span3 required')
                    ));

                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php

    $signin = BSOperasisigninT::model()->findByAttributes(array('dokteranestesi_id' => $model->dokteranestesi_id));
    if (empty($signin)) {
        if (!isset($_GET['sukses'])) {
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('class' => 'btn btn-danger', 'type' => 'submit', 'onkeypress' => 'formSubmit(this,event);')
            );
        } else {
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('class' => 'btn btn-danger', 'type' => 'button', 'disabled' => true, 'style' => 'cursor:not-allowed;')
            );
        }
        echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl('index'),
            array(
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        );
    } else {
        //$content = $this->renderPartial('tips/tipsPendaftaranBedahSentralRujukanRS',array(),true);
        //$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    }
    ?>
</div>

<?php $this->endWidget(); ?>

<?php echo $this->renderPartial($this->path_view_rujuk . 'signin._jsFunctions', array('modDet' => $modDet, 'model' => $model), true); ?>