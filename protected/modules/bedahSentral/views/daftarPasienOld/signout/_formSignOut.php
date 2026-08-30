<?php

/**
 * - digunakan untuk menampilkan inputan signout
 * 
 * @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @website      <piindonesia.co.id>
 * @wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
 * 
 */

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'operasisignout-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
));
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"></div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <table class="table border paddingtext2">
            <tr>
                <td>
                    <table class="table noborder">
                        <tr>
                            <td>
                                <b>Pavilyun
                            </td>
                            <td>
                                :
                            </td>
                            <td>
                                <?php echo !empty($modAdmisi->pasienadmisi_id) ? $modAdmisi->kamarruangan->kamarruangan_nokamar . ' - ' . $modAdmisi->kamarruangan->kamarruangan_nobed : null; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Kelas</b>
                            </td>
                            <td>
                                :
                            </td>
                            <td>
                                <?php echo $modPenunjang->kelaspelayanan->kelaspelayanan_nama; ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: middle;">
                                <b>Tindakan</b>
                            </td>
                            <td style="vertical-align: middle;">
                                :
                            </td>
                            <td>
                                <?php echo $form->textField($model, 'signout_tindakan'); ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table class="table noborder">
                        <tr>
                            <td><b>Sebelum TUTUP KULIT Pasien meninggalkan Ruang Operasi (SIGN OUT)</b></td>
                        </tr>
                        <tr>
                            <td>Pukul : <?php $this->widget('MyDateTimePicker', array(
                                            'model' => $model,
                                            'attribute' => 'signout_tgl',
                                            //'name'=>'lahir_tgllahir',
                                            'mode' => 'datetime',
                                            'options' => array(
                                                'dateFormat' => Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                                'line' => true
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
                                                'onkeypress' => "return $(this).focusNextInputField(event)"
                                            ),
                                        )); ?></td>
                        </tr>
                        <tr>
                            <td>
                                Diagnosa Post-Op <?php echo $form->textField($model, 'signout_diagnosapostop'); ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table class="table noborder paddingtext">
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>Sudah</td>
                            <td>Belum</td>
                        </tr>
                        <?php

                        $i = 0;
                        foreach ($loadSignOut as $signout) {

                            if ($signout['form_haschecklist']) {
                                $modDet->isdipilih = $signout['value'];
                                $modDet->text = $signout['isian'];
                        ?>
                                <tr>
                                    <td><?php echo $i + 1 ?></td>
                                    <td><?php echo $signout['form_nama'] ?></td>
                                    <?php
                                    if ($signout['type'] == Params::INPUTTYPE_CHECK) {
                                        echo '<td>' . $form->checkBox($modDet, '[' . $signout['form_id'] . $signout['check_id'] . ']isdipilih', array('value' => $signout['form_id'] . $signout['check_id'] . 'true', 'form_id' => $signout['form_id'], 'check_id' => $signout['check_id'], 'status' => 1, 'onchange' => 'pilihSignOutIni(this);')) . '</td>';
                                        echo '<td>' . $form->checkBox($modDet, '[' . $signout['form_id'] . $signout['check_id'] . ']isdipilih', array('value' => $signout['form_id'] . $signout['check_id'] . 'false', 'form_id' => $signout['form_id'], 'check_id' => $signout['check_id'], 'status' => 0, 'onchange' => 'pilihSignOutIni(this);')) . '</td>';
                                    } elseif ($signout['type'] == Params::INPUTTYPE_TEXTAREA) {
                                        echo '<td colspan="2">' . $form->textArea($modDet, '[' . $signout['form_id'] . $signout['check_id'] . ']text', array('form_id' => $signout['form_id'], 'check_id' => $signout['check_id'], 'onblur' => 'pilihSignOutTextIni(this);')) . "</td>";
                                    }
                                    ?>

                                </tr>
                                <?php

                                foreach ($signout['checklist'] as $check) {
                                    $modDet->isdipilih = $check['value'];
                                    $modDet->text = $check['isian'];
                                ?>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td> - <?php echo $check['check_nama']; ?></td>
                                        <!--<td><?php //echo $form->checkBox($modDet,'['.$signout['form_id'].$check['check_id'].']isdipilih',array('value'=>$signout['form_id'].$check['check_id'].'true', 'form_id'=>$signout['form_id'], 'check_id'=>$check['check_id'], 'status'=>1, 'onchange'=>'pilihSignOutIni(this);')); 
                                                ?></td>-->
                                        <!--<td><?php //echo $form->checkBox($modDet,'['.$signout['form_id'].$check['check_id'].']isdipilih',array('value'=>$signout['form_id'].$check['check_id'].'false', 'form_id'=>$signout['form_id'], 'check_id'=>$check['check_id'], 'status'=>0, 'onchange'=>'pilihSignOutIni(this);')); 
                                                ?></td>-->
                                        <?php
                                        if ($check['type'] == Params::INPUTTYPE_CHECK) {
                                            echo "<td>" . $form->checkBox($modDet, '[' . $signout['form_id'] . $check['check_id'] . ']isdipilih', array('value' => $signout['form_id'] . $check['check_id'] . 'true', 'form_id' => $signout['form_id'], 'check_id' => $check['check_id'], 'status' => 1, 'onchange' => 'pilihSignOutIni(this);')) . "</td>";
                                            echo "<td>" . $form->checkBox($modDet, '[' . $signout['form_id'] . $check['check_id'] . ']isdipilih', array('value' => $signout['form_id'] . $check['check_id'] . 'false', 'form_id' => $signout['form_id'], 'check_id' => $check['check_id'], 'status' => 0, 'onchange' => 'pilihSignOutIni(this);')) . "</td>";
                                        } elseif ($check['type'] == Params::INPUTTYPE_TEXTAREA) {
                                            echo '<td colspan="2">' . $form->textArea($modDet, '[' . $signout['form_id'] . $check['check_id'] . ']text', array('form_id' => $signout['form_id'], 'check_id' => $check['check_id'], 'onblur' => 'pilihSignOutTextIni(this);')) . "</td>";
                                        }
                                        ?>
                                    </tr>
                                <?php
                                }
                                echo '<tr>
											<td colspan="4">&nbsp;</td>
										</tr>';
                            } else {
                                $modDet->isdipilih = $signout['value'];
                                $modDet->text = $signout['isian'];
                                ?>
                                <tr>
                                    <td><?php echo $i + 1 ?></td>
                                    <td><?php echo $signout['form_nama']; ?></td>
                                    <?php
                                    if ($signout['type'] == Params::INPUTTYPE_CHECK) {
                                        echo '<td>' . $form->checkBox($modDet, '[' . $signout['form_id'] . $signout['check_id'] . ']isdipilih', array('value' => $signout['form_id'] . $signout['check_id'] . 'true', 'form_id' => $signout['form_id'], 'check_id' => $signout['check_id'], 'status' => 1, 'onchange' => 'pilihSignOutIni(this);')) . '</td>';
                                        echo '<td>' . $form->checkBox($modDet, '[' . $signout['form_id'] . $signout['check_id'] . ']isdipilih', array('value' => $signout['form_id'] . $signout['check_id'] . 'false', 'form_id' => $signout['form_id'], 'check_id' => $signout['check_id'], 'status' => 0, 'onchange' => 'pilihSignOutIni(this);')) . '</td>';
                                    } elseif ($signout['type'] == Params::INPUTTYPE_TEXTAREA) {
                                        echo '<td colspan="2">' . $form->textArea($modDet, '[' . $signout['form_id'] . $signout['check_id'] . ']text', array('form_id' => $signout['form_id'], 'check_id' => $signout['check_id'], 'onblur' => 'pilihSignOutTextIni(this);')) . "</td>";
                                    }
                                    ?>
                                </tr>
                            <?php
                            }
                            ?>

                        <?php


                            $i++;
                        }
                        ?>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</div>

<table id="tampung-signout" hidden>
    <tbody>
        <?php
        if (count((array)$getDet) > 0) {
            $i = 0;
            foreach ($getDet as $set) {
                if ($set->checklistsignout_id == null || $set->checklistsignout_id == '') {
                    $checklist = 'kosong';
                    $set->checklistsignout_id = 'kosong';
                } else {
                    $checklist = $set->checklistsignout_id;
                }

                if ($set->signoutdet_hasil == false) {
                    $set->signoutdet_hasil = 0;
                }

                $set->identifier = $set->formsignout_id . '_' . $checklist;
                echo $this->renderPartial($this->path_view . "signout._formGetSignOut", array('modDet' => $set, 'i' => $i), true);
                $i++;
            }
        }
        ?>
    </tbody>
</table>

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

        <div class="control-group">
            <?php echo $form->labelEx($model, 'dokterbedah_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php //echo $form->dropDownList($modPasienMasukPenunjang,'perawat_id', CHtml::listData(LBPegawaiM::model()->getTenagaLaboratoriums($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'namaLengkap') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); 
                echo $form->hiddenField($model, 'dokterbedah_id', array('readonly' => true));

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
                    'htmlOptions' => array('class' => 'span3')
                ));

                ?>
            </div>
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

<?php echo $this->renderPartial($this->path_view . 'signout._jsFunctions', array('modDet' => $modDet, 'model' => $model), true); ?>