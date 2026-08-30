<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Pemeriksaan Dosis Radiasi
        </div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'dosis-radiasi-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'onsubmit' => 'return requiredCheck(this);',
                'onKeyPress' => 'return disableKeyPress(event)',
            ),
        ));
        ?>

        <div class="row-fluid">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'petugas_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        echo CHtml::activeHiddenField($model, 'petugas_id');
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'petugas_nama',
                            'source' => 'js: function(request, response) {
                                                   $.ajax({
                                                       url: "' . Yii::app()->createUrl('ActionAutoComplete/pegawaiRuangan') . '",
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
                                                $(this).val(ui.item.label);
                                                return false;
                                            }',
                                'select' => 'js:function( event, ui ) {
                                                $(this).val(ui.item.label); 
                                                $("#' . CHtml::activeId($model, 'petugas_id') . '").val(ui.item.pegawai_id)
                                                return false;
                                            }',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPegawai'),
                            'htmlOptions' => array(
                                'placeholder' => 'Petugas', 'class' => 'all-caps span3', 'rel' => 'tooltip', 'title' => 'Petugas',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                            ),
                        )); ?>
                    </div>
                </diV>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'berat_badan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'berat_badan', array('class' => 'numbers-only span1')); ?>
                        <label>Kg</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'tanggal_pencatatatan', array('class' => 'control-label inline')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tanggal_pencatatatan',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'minDate' => '-1 years',
                                //'minDate' => 'd',
                                //'yearRange' => "-1:+0",
                                //
                            ),
                            'htmlOptions' => array(
                                'class' => 'dtPicker2-5', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>

                    </div>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th width="50">No.</th>
                    <th width="150">Pemeriksaan</th>
                    <th>Dosis Radiasi</th>
                </tr>
            </thead>
            <tbody class="tab_dosis">
                <?php

                $item_list = PemeriksaanalatradM::model()->findAllByAttributes(array(
                    'pemeriksaanalatrad_aktif' => true,
                ), array(
                    'condition' => 'rumusdosis_radiasi is not null'
                ));


                foreach ($periksa as $idx => $item) :

                    $det = null;
                    if (!$model->isNewRecord) {
                        $det = DosisradiasidetT::model()->findByAttributes(array(
                            'dosisradiasi_id'=>$model->dosisradiasi_id,
                            'pemeriksaanrad_id'=>$item->pemeriksaanrad_id,
                        ));

                    }
                    if (empty($det)) {
                        $det = new DosisradiasidetT;
                    } else {
                        $det->dosis_kv = empty($det->dosis_kv) ? null : number_format($det->dosis_kv, 2, ",", "");
                        $det->dosis_mas = empty($det->dosis_mas) ? null : number_format($det->dosis_mas, 2, ",", "");
                        $det->dosis_sigmaimage = empty($det->dosis_sigmaimage) ? null : number_format($det->dosis_sigmaimage, 2, ",", "");
                        $det->dosisradiasi_ctdivol = empty($det->dosisradiasi_ctdivol) ? null : number_format($det->dosisradiasi_ctdivol, 2, ",", "");
                        $det->dosisradiasi_dlp = empty($det->dosisradiasi_dlp) ? null : number_format($det->dosisradiasi_dlp, 2, ",", "");
                        
                        $det->dosis_ma = empty($det->dosis_ma) ? null : number_format($det->dosis_ma, 2, ",", "");
                        $det->dosis_s = empty($det->dosis_s) ? null : number_format($det->dosis_s, 2, ",", "");
                        $det->dosis_fpdcm = empty($det->dosis_fpdcm) ? null : number_format($det->dosis_fpdcm, 2, ",", "");
                        $det->dosis_anoda = empty($det->dosis_anoda) ? null : number_format($det->dosis_anoda, 2, ",", "");
                        $det->dosis_thikness = empty($det->dosis_thikness) ? null : number_format($det->dosis_thikness, 2, ",", "");
                        $det->dosis_compressionforce = empty($det->dosis_compressionforce) ? null : number_format($det->dosis_compressionforce, 2, ",", "");

                        $det->dosisradiasi_dap = empty($det->dosisradiasi_dap) ? null : number_format($det->dosisradiasi_dap, 2, ",", "");
                        $det->dosisradiasi_sigmadap = empty($det->dosisradiasi_sigmadap) ? null : number_format($det->dosisradiasi_sigmadap, 2, ",", "");
                        $det->dosisradiasi_inak = empty($det->dosisradiasi_inak) ? null : number_format($det->dosisradiasi_inak, 2, ",", "");
                        $det->dosisradiasi_esak = empty($det->dosisradiasi_esak) ? null : number_format($det->dosisradiasi_esak, 2, ",", "");
                        $det->dosisradiasi_sigmaesak = empty($det->dosisradiasi_sigmaesak) ? null : number_format($det->dosisradiasi_sigmaesak, 2, ",", "");
                        $det->dosisradiasi_mgd = empty($det->dosisradiasi_mgd) ? null : number_format($det->dosisradiasi_mgd, 2, ",", "");
                        $det->dosisradiasi_sigmamgd = empty($det->dosisradiasi_sigmamgd) ? null : number_format($det->dosisradiasi_sigmamgd, 2, ",", "");
                        
                        // var_dump($det->attributes); die;
                    }
                ?>
                    <tr class="row_periksa" data-id="<?php echo $item->hasilpemeriksaanrad_id; ?>">
                        <td><?php echo $idx + 1; ?></td>
                        <td><?php echo $item->pemeriksaanrad->pemeriksaanrad_nama ?? "-"; ?></td>
                        <td>
                            <?php
                            $id = $item->pemeriksaanrad_id;
                            ?>
                            <div class="control-group">
                                <label class="control-label">Alat yang digunakan</label>
                                <div class="controls">
                                    <?php echo $form->radioButtonList($det, '[' . $id . ']pemeriksaanalatrad_id', CHtml::listData($item_list, 'pemeriksaanalatrad_id', 'pemeriksaanalatrad_nama'), array(
                                        'class' => 'pilih_pemeriksaanalatrad_id',
                                    )); ?>
                                </div>
                            </div>
                            <?php echo $form->textFieldRow($det, '[' . $id . ']dosis_kv', array('class' => 'span3 float2 dosis_kv input_dosis ctscan_philips panoramic generalxray_toshiba mobilexraydr_philips mammografi_siemens')); ?>
                            <?php echo $form->textFieldRow($det, '[' . $id . ']dosis_mas', array('class' => 'span3 float2 input_dosis ctscan_philips mammografi_siemens')); ?>
                            <?php echo $form->textFieldRow($det, '[' . $id . ']dosis_sigmaimage', array('class' => 'span3 float2 input_dosis ctscan_philips panoramic generalxray_toshiba mobilexraydr_philips mammografi_siemens')); ?>
                            <?php echo $form->textFieldRow($det, '[' . $id . ']dosis_ma', array('class' => 'span3 float2 dosis_ma input_dosis panoramic generalxray_toshiba mobilexraydr_philips')); ?>
                            <?php echo $form->textFieldRow($det, '[' . $id . ']dosis_s', array('class' => 'span3 float2 dosis_s input_dosis panoramic generalxray_toshiba mobilexraydr_philips')); ?>
                            <?php echo $form->textFieldRow($det, '[' . $id . ']dosis_fpdcm', array('class' => 'span3 float2 dosis_fpdcm input_dosis generalxray_toshiba mobilexraydr_philips')); ?>
                            <?php echo $form->textFieldRow($det, '[' . $id . ']dosis_anoda', array('class' => 'span3 float2 input_dosis mammografi_siemens')); ?>
                            <?php echo $form->textFieldRow($det, '[' . $id . ']dosis_thikness', array('class' => 'span3 float2 input_dosis mammografi_siemens')); ?>
                            <?php echo $form->textFieldRow($det, '[' . $id . ']dosis_compressionforce', array('class' => 'span3 float2 input_dosis mammografi_siemens')); ?>
                            <br />
                            <strong>Dosis Radiasi</strong>
                            <?php echo $form->textFieldRow($det, '[' . $id . ']dosisradiasi_ctdivol', array('class' => 'span3 float2 input_dosis ctscan_philips')); ?>
                            <?php echo $form->textFieldRow($det, '[' . $id . ']dosisradiasi_dlp', array('class' => 'span3 float2 input_dosis ctscan_philips')); ?>
                            <?php echo $form->textFieldRow($det, '[' . $id . ']dosisradiasi_inak', array('class' => 'span3 float2 dosisradiasi_inak input_dosis generalxray_toshiba mobilexraydr_philips')); ?>
                            <?php echo $form->textFieldRow($det, '[' . $id . ']dosisradiasi_esak', array('class' => 'span3 float2 dosisradiasi_esak input_dosis generalxray_toshiba mobilexraydr_philips')); ?>
                            <?php echo $form->textFieldRow($det, '[' . $id . ']dosisradiasi_sigmaesak', array('class' => 'span3 float2 input_dosis generalxray_toshiba mobilexraydr_philips')); ?>
                            <?php echo $form->textFieldRow($det, '[' . $id . ']dosisradiasi_dap', array('class' => 'span3 float2 input_dosis panoramic mobilexraydr_philips')); ?>
                            <?php echo $form->textFieldRow($det, '[' . $id . ']dosisradiasi_sigmadap', array('class' => 'span3 float2 input_dosis panoramic mobilexraydr_philips')); ?>
                            <?php echo $form->textFieldRow($det, '[' . $id . ']dosisradiasi_mgd', array('class' => 'span3 float2 input_dosis mammografi_siemens')); ?>
                            <?php echo $form->textFieldRow($det, '[' . $id . ']dosisradiasi_sigmamgd', array('class' => 'span3 float2 input_dosis mammografi_siemens')); ?>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class='form-actions'>
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array(
                'class' => 'btn btn-primary', 'type' => 'submit',
                'onKeypress' => 'return formSubmit(this,event)',
                'id' => 'btn_simpan',
            ));
            ?>
            <?php // echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl(''), array('class'=>'btn btn-danger')); 
            ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('index', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger')); ?>
            <?php
            $content = $this->renderPartial('../tips/tips', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Petugas',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 800,
        'minHeight' => 500,
        'resizable' => false,
    ),
));

$modPegawai = new ROPegawaiM();

$modPegawai->unsetAttributes();
if (!empty($_GET['ROPegawaiM'])) {
    $modPegawai->attributes = $_GET['ROPegawaiM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'sapegawai-m-grid',
    'dataProvider' => $modPegawai->searchPegawaiRuangan(Yii::app()->user->getState('ruangan_id')),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => '',

            'value' => 'CHtml::link("<i class=\"icon-form-check\"></i>","#", array("id" => "selectPegawai",
                "onClick"=>"
                                                        $(\"#DosisradiasiT_petugas_id\").val(\"$data->pegawai_id\");
                                                        $(\"#DosisradiasiT_petugas_nama\").val(\"$data->nama_pegawai\");
                                                        $(\"#dialogPegawai\").dialog(\"close\");    
                                                        "
            ))',
        ),
        'nomorindukpegawai',
        array(
            'name'=>'nama_pegawai',
            'value'=>'$data->namaLengkap',
        ),
        'jeniskelamin',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>

<?php $this->endWidget(); ?>



<script>
    <?php
    $data_item = CHtml::listData($item_list, 'pemeriksaanalatrad_id', 'rumusdosis_radiasi');
    ?>

    var data_list = <?php echo CJSON::encode($data_item); ?>


    function hitungDosis() {
        $(".tab_dosis .row_periksa").each(function() {
            var data_pilih = $(this).find(".pilih_pemeriksaanalatrad_id:checked").val();
            var pilihan = "";
            var kv = $(this).find(".dosis_kv").val();
            var ma = $(this).find(".dosis_ma").val();
            var s = $(this).find(".dosis_s").val();
            var fpd = $(this).find(".dosis_fpdcm").val();
            var inak = "";
            var esak = "";
            var total = 0;

            if (data_list[data_pilih] != null) {
                pilihan = data_list[data_pilih];

                if (kv != "" && ma != "" && s != "" && fpd != "") {
                    kv = parseFloat(unformatNumber(kv));
                    ma = parseFloat(unformatNumber(ma));
                    s = parseFloat(unformatNumber(s));
                    fpd = parseFloat(unformatNumber(fpd));

                    if (pilihan == "generalxray_toshiba") {
                        inak = ((1.2326 * kv) - 50.821) * ma * s * Math.pow(100 / fpd, 2);
                    } else if (pilihan == "mobilexraydr_philips") {
                        inak = ((1.1986 * kv) - 49.283) * ma * s * Math.pow(100 / fpd, 2);
                    }

                    if (inak != "") {
                        esak = inak * 1.35 / 1000;
                        $(".dosisradiasi_inak").val(formatFloat2(inak));
                        $(".dosisradiasi_esak").val(formatFloat2(esak));
                    }

                }


            }



        });
    }

    function setInputDosis() {
        $(".tab_dosis .row_periksa").each(function() {
            $(this).find(".input_dosis").prop("disabled", true).parents(".control-group").hide();
            var data_pilih = $(this).find(".pilih_pemeriksaanalatrad_id:checked").val();

            // console.log("PILIH", data_pilih, data_list);

            if (data_list[data_pilih] != null) {
                // console.log($(this).find(".input_dosis." + data_list[data_pilih]));
                $(this).find(".input_dosis." + data_list[data_pilih]).prop("disabled", false).parents(".control-group").show();
            }
        });
        hitungDosis();
    }

    $(document).ready(function() {
        $(".tab_dosis .pilih_pemeriksaanalatrad_id").on("click", setInputDosis);
        $(".tab_dosis .input_dosis").on("blur", hitungDosis);
        setInputDosis();
    });
</script>