<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'luluskomponendarah-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>
<?php //echo $form->errorSummary($model); 
?>
<div class="row">
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"> <b> Pembuatan Komponen Darah </b> </div>
        </div>
        <div class="panel-body">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="glyphicon glyphicon-file"></i> Data <b>Kantong Darah</b>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label("Nomor Barcode", 'no_kantongdarah', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modKantong, 'nomorbarcode', array('readonly' => true, 'class' => 'span3')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Jenis Kantong Darah", 'nama_jenis', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modKantong, 'nama_jenis', array('readonly' => true, 'class' => 'span3')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Tgl. Penerimaan Kantong", 'tglpencatatan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $modKantong->tglpencatatan = MyFormatter::formatDateTimeForUser($modKantong->tglpencatatan);
                                echo $form->textField($modKantong, 'nama_jenis', array('readonly' => true, 'class' => 'span3')) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label("Golongan Darah", 'gol_darah', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modKantong, 'gol_darah', array('readonly' => true, 'class' => 'span3')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Rhesus", 'rhesus', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modKantong, 'rhesus', array('readonly' => true, 'class' => 'span3')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Ruangan Asal", 'ruangandaftar_nama', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modKantong, 'ruangandaftar_nama', array('readonly' => true, 'class' => 'span3')) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        Pembuatan <b>Komponen Darah</b>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-sm-12">
                        <div class="control-group">
                            <?php
                            if (!empty($modKantong->komponendarah_id)) {
                                if ($modKantong->komponendarah_id == 7) {
                            ?>
                                    <?php
                                    echo CHtml::label("WB <i style='color: red'> * </i>", "", array(
                                        'class' => 'control-label'
                                    ));
                                    ?>
                                    <div class="controls komponen">
                                        <?php echo CHtml::activeRadioButtonList($model, 'komponen_wb', array('BERHASIL' => 'BERHASIL', 'GAGAL PRODUKSI' => 'GAGAL PRODUKSI'), array('disabled' => true), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>
                                    </div>
                                <?php
                                } else if ($modKantong->komponendarah_id == 8 || $modKantong->komponendarah_id == 10) {
                                ?>
                                    <?php
                                    echo CHtml::label("PRC <i style='color: red'> * </i>", "", array(
                                        'class' => 'control-label'
                                    ));
                                    ?>
                                    <div class="controls komponen">
                                        <?php echo CHtml::activeRadioButtonList($model, 'komponen_prc', array('BERHASIL' => 'BERHASIL', 'GAGAL PRODUKSI' => 'GAGAL PRODUKSI'), array('disabled' => true), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>
                                    </div>
                                <?php
                                } else if ($modKantong->komponendarah_id == 9 || $modKantong->komponendarah_id == 11 || $modKantong->komponendarah_id == 13) {
                                ?>
                                    <?php
                                    echo CHtml::label("FFP <i style='color: red'> * </i>", "", array(
                                        'class' => 'control-label'
                                    ));
                                    ?>
                                    <div class="controls komponen">
                                        <?php echo CHtml::activeRadioButtonList($model, 'komponen_ffp', array('BERHASIL' => 'BERHASIL', 'GAGAL PRODUKSI' => 'GAGAL PRODUKSI'), array('disabled' => true), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>
                                    </div>
                                <?php
                                } else if ($modKantong->komponendarah_id == 14 || $modKantong->komponendarah_id == 12) {
                                ?>
                                    <?php
                                    echo CHtml::label("TC <i style='color: red'> * </i>", "", array(
                                        'class' => 'control-label'
                                    ));
                                    ?>
                                    <div class="controls komponen">
                                        <?php echo CHtml::activeRadioButtonList($model, 'komponen_tc', array('BERHASIL' => 'BERHASIL', 'GAGAL PRODUKSI' => 'GAGAL PRODUKSI'), array('disabled' => true), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>
                                    </div>
                                <?php
                                } else if ($modKantong->komponendarah_id == 15) {
                                    echo CHtml::label("PCR <i style='color: red'> * </i>", "", array(
                                        'class' => 'control-label'
                                    )); ?>
                                    <div class="controls komponen">
                                        <?php echo CHtml::activeRadioButtonList($model, 'komponen_pcr', array('BERHASIL' => 'BERHASIL', 'GAGAL PRODUKSI' => 'GAGAL PRODUKSI'), array('disabled' => true), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>
                                    </div>
                                <?php } elseif ($modKantong->singkatan_komp == Params::KOMPONEN_DARAH_CRY) {
                                    echo CHtml::label(Params::KOMPONEN_DARAH_CRY . " <i style='color: red'> * </i>", "", array(
                                        'class' => 'control-label'
                                    )); ?>
                                    <div class="controls komponen">
                                        <?php echo CHtml::activeRadioButtonList($model, 'komponen_cry', array('BERHASIL' => 'BERHASIL', 'GAGAL PRODUKSI' => 'GAGAL PRODUKSI'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>
                                    </div>
                                <?php }
                            } else {
                                ?>
                                <?php echo CHtml::activeHiddenField($modelKantongDetail, 'kantongdarah_id', array('readonly' => 'true')); ?>
                                <?php
                                echo CHtml::label("WB <i style='color: red'> * </i>", "", array(
                                    'class' => 'control-label komp komponen_wb'
                                ));
                                ?>
                                <div class="controls komp komponen_wb">
                                    <?php echo CHtml::activeRadioButtonList($model, 'komponen_wb', array('BERHASIL' => 'BERHASIL', 'GAGAL PRODUKSI' => 'GAGAL PRODUKSI'), array('disabled' => true), array('class' => 'komponen_wb komp', 'labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>
                                </div>
                                <?php
                                echo CHtml::label("PRC <i style='color: red'> * </i>", "", array(
                                    'class' => 'control-label komp komponen_prc'
                                ));
                                ?>
                                <div class="controls komp komponen_prc">
                                    <?php echo CHtml::activeRadioButtonList($model, 'komponen_prc', array('BERHASIL' => 'BERHASIL', 'GAGAL PRODUKSI' => 'GAGAL PRODUKSI'), array('disabled' => true), array('class' => 'komponen_prc komp', 'labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>
                                </div>
                                <?php
                                echo CHtml::label("FFP <i style='color: red'> * </i>", "", array(
                                    'class' => 'control-label komp komponen_ffp'
                                ));
                                ?>
                                <div class="controls komp komponen_ffp">
                                    <?php echo CHtml::activeRadioButtonList($model, 'komponen_ffp', array('BERHASIL' => 'BERHASIL', 'GAGAL PRODUKSI' => 'GAGAL PRODUKSI'), array('disabled' => true), array('class' => 'komponen_ffp komp', 'labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>
                                </div>
                                <?php
                                echo CHtml::label("TC <i style='color: red'> * </i>", "", array(
                                    'class' => 'control-label komp komponen_tc'
                                ));
                                ?>
                                <div class="controls komp komponen_tc">
                                    <?php echo CHtml::activeRadioButtonList($model, 'komponen_tc', array('BERHASIL' => 'BERHASIL', 'GAGAL PRODUKSI' => 'GAGAL PRODUKSI'), array('disabled' => true), array('class' => 'komponen_tc komp', 'labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>
                                </div>
                                <?php
                                echo CHtml::label("PCR <i style='color: red'> * </i>", "", array(
                                    'class' => 'control-label komp komponen_pcr'
                                ));
                                ?>
                                <div class="controls komp komponen_pcr">
                                    <?php echo CHtml::activeRadioButtonList($model, 'komponen_pcr', array('BERHASIL' => 'BERHASIL', 'GAGAL PRODUKSI' => 'GAGAL PRODUKSI'), array('disabled' => true), array('class' => 'komponen_pcr komp', 'labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>
                                </div>
                                <?php
                                echo CHtml::label(Params::KOMPONEN_DARAH_CRY . " <i style='color: red'>* </i>", "", array(
                                    'class' => 'control-label komp komponen_cry'
                                ));
                                ?>
                                <div class="controls komp komponen_cry">
                                    <?php echo CHtml::activeRadioButtonList($model, 'komponen_cry', array('BERHASIL' => 'BERHASIL', 'GAGAL PRODUKSI' => 'GAGAL PRODUKSI'), array('class' => 'komponen_cry komp', 'labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php
                            echo CHtml::label("Keterangan <i style='color: red'> * </i>", "", array(
                                'class' => 'control-label'
                            ));
                            ?>
                            <div class="controls komponen">
                                <?php echo $form->textArea($model, 'periksakomp_ket', array('disabled' => true, 'class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Keterangan')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php
                            echo CHtml::label("Tgl. Kedaluwarsa <i style='color: red'> * </i>", "", array(
                                'class' => 'control-label'
                            ));
                            ?>
                            <div class="controls komponen">
                                <?php
                                $model->tglkadaluarsa = (!empty($model->tglkadaluarsa) ? date("d M Y H:i:s", strtotime($model->tglkadaluarsa)) : null);

                                echo $form->textField($model, 'tglkadaluarsa', array('disabled' => true, 'class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Keterangan')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php
                    echo CHtml::label("Waktu Pembuatan Komponen <i style='color: red'> * </i> ", "", array(
                        'class' => 'control-label'
                    ));
                    ?>
                    <?php
                    $model->tglperiksakompdarah = (!empty($model->tglperiksakompdarah) ? date("d M Y H:i:s", strtotime($model->tglperiksakompdarah)) : null);

                    echo $form->textField($model, 'tglkadaluarsa', array('disabled' => true, 'class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Keterangan'));
                    ?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php
                    echo CHtml::label("Petugas Komponen <i style='color: red'> * </i>", "", array(
                        'class' => 'control-label'
                    ));
                    ?>
                    <div class="controls komponen">
                        <?php echo $form->hiddenField($model, 'petugasperiksakomp_id', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $model->petugasperiksakomp_nama = !empty($model->petugasperiksakomp_id) ? $model->pegawai->nama_pegawai : " ";
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'petugasperiksakomp_nama',
                            'sourceUrl' => $this->createUrl('AutoCompletePegawai'),
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 3,
                                'select' => 'js:function( event, ui ) {
                                                    $("#PeriksakomponendarahT_petugasperiksakomp_id").val( ui.item.pegawai_id );
                                                    setDataPegawai(ui.item.pegawai_id);
                                                    return false;
                                        }',
                            ),
                            'htmlOptions' => array('disabled' => true, 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'placeholder' => 'NIP / Nama Pegawai'),
                            'tombolDialog' => array('idDialog' => 'dialogPetugas', 'idTombol' => 'tombolPegawaiPelaksana'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>