<?php

/**
 * view utama yang menampilkan form - form inputan risiko jatuh
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0 
 * @link    <http://piindonesia.co.id>
 */
$visibility = isset($_GET['lihat']) ? 'hidden' : '';
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Asesment Ulang Skoring Resiko Jatuh
        </div>
    </div>
    <div class="panel-body" style="padding-top: 0;">
        <?php
        $this->widget('bootstrap.widgets.BootAlert');

        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'resikojatuh-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
        ?>
        <fieldset>
            <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'form-riwayat',
                'content' => array(
                    'content-detailpasien' => array(
                        'header' => '<b>Riwayat Pasien</b>',
                        'isi' => $this->renderPartial($this->path_view . '/_riwayatJatuh', array('modResikoJatuh' => $modResikoJatuh, 'modPendaftaran' => $modPendaftaran), true),
                        'active' => false,
                    ),
                ),
            )); ?>
        </fieldset>
            
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Skoring Resiko Jatuh <span id="label_is_anak"></span>
                </div>
            </div>

            <div class="panel-body">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'tgl_skoring', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_skoring',
                            'value' => null,
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'class' => 'span3 htpd required',
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'pegawaiskoring_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        echo $form->hiddenField($model, 'pegawaiskoring_id', array(
                            'id' => 'pegawaiskoring_id',
                        ));

                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'pegawaiskoring_nama',
                            'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . $this->createUrl('/ActionAutoComplete/pegawaiRuangan') . '",
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
                                        //$("#triase_id").val(ui.item.triase_id); 
                                        setPetugas(ui.item.namaLengkap,ui.item.pegawai_id);
                                        return false;
                                    }',
                            ),
                            'htmlOptions' => array('placeholder' => 'Pegawai Skoring', 'class' => 'required span3', 'onblur' => 'if(this.value == ""){$("#pegawaiskoring_id").val("")}', 'id' => 'pegawaiskoring_nama'),
                            'tombolDialog' => array('idDialog' => 'dialogPegawaiSkoring'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-primary panel-success" id="panelresikojatuh_anak">
            <div class="panel-heading">
                <div class="panel-title"><?php echo $form->radioButton($model, 'isresikojatuh', array('onclick' => 'choiseResikoJatuh(this)', 'value' => 1, 'class'=>'pilih_resikoJatuh', 'uncheckValue'=>null)); ?> <strong>Skoring Resiko Jatuh Anak</strong></div>
            </div>
            <div class="panel-body">
                <div id="resikojatuhanak">
                    <?php echo $form->hiddenField($model, 'jenisresikojatuh', array('value'=>'anak')); ?>

                    <div class="table-responsive" style="overflow-x:auto;">
                        <div class='block-tabel'>
                            <table class="items table table-bordered table-striped table-condensed" id="tblResikojatuhAnak">
                                <thead>
                                    <tr>
                                        <th>Parameter</th>
                                        <th>Kriteria</th>
                                        <th>Skor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Usia</th>
                                        <th>
                                            <?php echo $form->hiddenField($model, 'anak_usia_keterangan'); ?>
                                            <?php echo $form->dropDownList($model, 'anak_usia_text', LookupM::getItems('resikojatuh_usia_anak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'resikojatuhanak_usia(this)')); ?>
                                        </th>
                                        <th><?php echo $form->textField($model, 'anak_usia_skor', array('class' => 'span1 integer numberOnly resikojatuhanak_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?> </th>
                                    </tr>
                                    <tr>
                                        <th>Jenis Kelamin</th>
                                        <th>
                                            <?php echo $form->hiddenField($model, 'anak_jeniskelamin_keterangan'); ?>
                                            <?php echo $form->dropDownList($model,'anak_jeniskelamin_text',LookupM::getItems('jeniskelamin_skrining'), array('empty' => '-- Pilih --', 'class' => 'jeniskelaminAnak span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange'=>'resikojatuhanak_jeniskelamin(this)'));?>
                                        </th>
                                        <th><?php echo $form->textField($model, 'anak_jeniskelamin_skor', array('class' => 'span1 integer numbersOnly resikojatuhanak_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?> </th>
                                    </tr>
                                    <tr>
                                        <th>Diagnose</th>
                                        <th>
                                            <?php echo $form->hiddenField($model, 'anak_diagnosis_keterangan'); ?>
                                            <?php echo $form->dropDownList($model, 'anak_diagnosis_text', LookupM::getItems('resikojatuh_diagnose_anak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'resikojatuhanak_diagnosa(this)')); ?>
                                        </th>
                                        <th><?php echo $form->textField($model, 'anak_diagnosis_skor', array('class' => 'span1 integer numbersOnly resikojatuhanak_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                                    </tr>
                                    <tr>
                                        <th>Gangguan Kognitif</th>
                                        <th>
                                            <?php echo $form->hiddenField($model, 'anak_gangguankognitif_keterangan'); ?>
                                            <?php echo $form->dropDownList($model, 'anak_gangguankognitif_text', LookupM::getItems('resikojatuh_gangguan_kognitif_anak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'resikojatuhanak_gangguan(this)')); ?>
                                        </th>
                                        <th><?php echo $form->textField($model, 'anak_gangguankognitif_skor', array('class' => 'span1 integer numbersOnly resikojatuhanak_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                                    </tr>
                                    <tr>
                                        <th>Faktor Lingkungan</th>
                                        <th>
                                            <?php echo $form->hiddenField($model, 'anak_faktorlingkungan_keterangan'); ?>
                                            <?php echo $form->dropDownList($model, 'anak_faktorlingkungan_text', LookupM::getItems('resikojatuh_faktor_lingkungan_anak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'resikojatuhanak_faktor(this)')); ?>
                                        </th>
                                        <th><?php echo $form->textField($model, 'anak_faktorlingkungan_skor', array('class' => 'span1 integer numbersOnly resikojatuhanak_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                                    </tr>
                                    <tr>
                                        <th>Respon Terhadap: Pembedahan, sedasi, anestesi</th>
                                        <th>
                                            <?php echo $form->hiddenField($model, 'anak_pembedahan_keterangan'); ?>
                                            <?php echo $form->dropDownList($model, 'anak_pembedahan_text', LookupM::getItems('resikojatuh_responterhadap_pembedahan_anak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'resikojatuhanak_respon(this)')); ?>
                                        </th>
                                        <th><?php echo $form->textField($model, 'anak_pembedahan_skor', array('class' => 'span1 integer numbersOnly resikojatuhanak_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                                    </tr>
                                    <tr>
                                        <th>Penggunaan Medikamentosa</th>
                                        <th>
                                            <?php echo $form->hiddenField($model, 'anak_medikamentosa_keterangan'); ?>
                                            <?php echo $form->dropDownList($model, 'anak_medikamentosa_text', LookupM::getItems('resikojatuh_pembedahan_medikamentosa_anak'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'resikojatuhanak_bedah(this)')); ?>
                                        </th>
                                        <th><?php echo $form->textField($model, 'anak_medikamentosa_skor', array('class' => 'span1 integer numbersOnly resikojatuhanak_skor', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th>Total Score</th>
                                        <th> <?php echo  $form->textField($model,'totalskor_anak', array('class'=>'span1 integer numberOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);",'maxlength'=>10,'readonly'=>true)).''; ?> </th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th>Hasil Resiko Jatuh</th>
                                        <th> <?php echo $form->textField($model,'totalskor_keterangan_anak', array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true,)).''; ?> </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-primary panel-success" id="panelresikojatuh_dewasa">
            <div class="panel-heading">
                <div class="panel-title"><?php echo $form->radioButton($model, 'isresikojatuh', array('onclick' => 'choiseResikoJatuh(this)', 'value' => 2, 'class'=>'pilih_resikoJatuh', 'uncheckValue'=>null)); ?> <strong>Skoring Resiko Jatuh Dewasa</strong></div>
            </div>
            <div class="panel-body">
                <div id="resikojatuhdewasa">
                    <?php echo $form->hiddenField($model, 'jenisresikojatuh', array('value'=>'dewasa')); ?>
                    <?php
                        /*echo $this->renderPartial($this->path_view.'_dataPasien', array(
                            'modPendaftaran'=>$modPendaftaran,
                            'modPasien'=>$modPasien,
                            'modResikoJatuh' => $modResikoJatuh
                        ), true);*/

                         echo $this->renderPartial($this->path_view . '_skoringResiko', array(
                            'form' => $form,
                            'model' => $model,
                            'modPasien' => $modPasien,
                            'modPendaftaran' => $modPendaftaran,
                        ), true);

                        // echo $this->renderPartial($this->path_view . '_implementasiResikoTinggi', array(
                        //     'form' => $form,
                        //     'model' => $model,
                        // ), true);

                        // echo $this->renderPartial($this->path_view . '_implementasiResikoRendah', array(
                        //     'form' => $form,
                        //     'model' => $model,
                        // ), true);

                    ?>
                </div>
            </div>
        </div>

        

        <div class="form-actions" <?= $visibility ?>>
            <?php
            if ($model->isNewRecord) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan'));
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => 'true', 'style' => 'cursor:not-allowed;'));
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'onclick' => "", 'disabled' => 'disabled')); //RND-8620
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), '#', array('class' => 'btn btn-succes', 'onclick' => 'print();'));
            }
            ?>
            <?php
            $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
            $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
            ?>
        </div>

        <?php
        $this->endWidget();

        echo $this->renderPartial($this->path_view . '_jsFunction', array('model' => $model, 'modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran), true);

        ?>

    </div>
</div>


<?php
//=============================== Dialog DPJP =======================================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogPegawaiSkoring',
        'options' => array(
            'title' => 'Petugas Skoring',
            'autoOpen' => false,
            'width' => 840,
            'height' => 460,
            'resizable' => true,
        ),
    )
);

$format = new MyFormatter();
$modDPJP = new PegawairuanganV('search');
$modDPJP->unsetAttributes();
$modDPJP->ruangan_id = Yii::app()->user->getState('ruangan_id');
$modDPJP->pegawai_aktif = true;

if (isset($_GET['PegawairuanganV'])) {
    $modDPJP->attributes = $_GET['PegawairuanganV'];
}


$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialog-dpjp-m-grid',
    'dataProvider' => $modDPJP->searchPetugasSkoring(),
    'filter' => $modDPJP,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::Link('<i class="icon-form-check"></i>', "#", array(
                    "class" => "btn-small",
                    "onclick" => " setPetugas('" . $data->namaLengkap . "'," . $data->pegawai_id . ");$('#dialogPegawaiSkoring').dialog('close'); return false; "
                ));
            },
        ),
        array(
            'header' => 'NIP',
            'value' => '$data->nomorindukpegawai'
        ),
        array(
            'name' => 'nama_pegawai',
            // 'filter'=>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'type' => 'raw',
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                }
            },
            'filter' => CHtml::activeDropDownList($modDPJP, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll(" jabatan_aktif = TRUE ORDER BY jabatan_nama ASC "), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
//=============================== END DPJP =======================================
?>