<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sakonfigfarmasi-k-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return cekValidasi(this);'),
    'focus' => '#',
)); ?>
<?php echo $form->errorSummary($model); ?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <div class="col-sm-6">
        <?php // echo $form->textFieldRow($model,'tglberlaku',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <div class="control-group">
            <?php echo CHtml::label('Tgl. Berlaku', 'tgl_awal', array('class' => 'control-label', 'style' => 'width: 200px')); ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglberlaku',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Penanggungjawab Apoteker", '', array('class' => 'control-label', 'style' => 'width: 200px')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'penanggungjawab_apoterker_id', array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php
                $pegawai_nama = "";
                if (isset($model->penanggungjawab_apoterker_id)) {
                    $modPegRuangan = PegawaiM::model()->findByPk($model->penanggungjawab_apoterker_id);
                    $pegawai_nama = isset($modPegRuangan) ?  $modPegRuangan->nama_pegawai : "";
                }
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'penanggungjawab_apoterker_nama',
                    'value' => $pegawai_nama,
                    'source' => 'js: function(request, response) {
                                       $.ajax({
                                           url: "' . $this->createUrl('AutocompletePenanggungjawabApoteker') . '",
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
                                    $(this).val("");
                                    return false;
                                }',
                        'select' => 'js:function( event, ui ) {
                                    $("#' . CHtml::activeId($model, 'penanggungjawab_apoterker_id') . '").val(ui.item.value)
                                    $("#penanggungjawab_apoterker_nama").val(ui.item.label);
                                    return false;
                                }',
                    ),
                    'htmlOptions' => array(
                        'class' => 'custom-only span3',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "")  $("#' . CHtml::activeId($model, 'penanggungjawab_apoterker_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPenanggungJawabApoteker'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <?php echo $form->checkBox($model, 'bayarlangsung', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?> <label>Bayar Langsung Penjualan Obat</label>
            </div>
        </div>
        <div class="panel panel-success" style="margin-top: 17px;">
            <div class="panel-heading">
                <div class="panel-title">
                    Stok
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="control-group">
                    <div class="controls">
                        <?php echo $form->checkBox($model, 'isstokfarmasiminus', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?> <label>Stok Farmasi Minus</label>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <?php echo $form->checkBox($model, 'isstokminimalfarmasi', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?> <label>Stok Minimal Sesuai Master Obat Alkes</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success" style="margin-top: 17px;">
            <div class="panel-heading">
                <div class="panel-title">
                    Pajak Pembelian
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php echo $form->textFieldRow($model, 'persenppn', array('class' => 'span3 integer-decimal validasiPersen', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'persenpph', array('class' => 'span3 integer-decimal validasiPersen', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="panel panel-success" style="margin-top: 17px;">
            <div class="panel-heading">
                <div class="panel-title">
                    PPN Penjualan
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php echo $form->textFieldRow($model, 'ri_persjualppn', array('class' => 'span3 integer-decimal validasiPersen', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'rd_persjualppn', array('class' => 'span3 integer-decimal validasiPersen', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'rj_persjualppn', array('class' => 'span3 integer-decimal validasiPersen', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="panel panel-success" style="margin-top: 17px;">
            <div class="panel-heading">
                <div class="panel-title">
                    Keringanan
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="control-group">
                    <?php echo CHtml::label("Diskon Penjualan Pasien (%) <span class='required'>*</span>", '', array('class' => 'control-label required', 'style' => 'width: 200px')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'persdiskpasien', array('class' => 'span3 integer-decimal validasiPersen', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 3)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Diskon Penjualan Pegawai (%) <span class='required'>*</span>", '', array('class' => 'control-label required', 'style' => 'width: 200px')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'discountkaryawan', array('class' => 'span3 integer-decimal validasiPersen', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Diskon Penjualan Dokter (%) <span class='required'>*</span>", '', array('class' => 'control-label required', 'style' => 'width: 200px')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'discountdokter', array('class' => 'span3 integer-decimal validasiPersen', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 3)); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success" style="margin-top: 17px;">
            <div class="panel-heading">
                <div class="panel-title">
                    Pemberian Obat
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="control-group">
                    <?php echo CHtml::label("Metode Pemberian Obat", '', array('class' => 'control-label required', 'style' => 'width: 250px')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'metode_pemberian', LookupM::getItems('metodepemberianobat'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php //echo $form->textFieldRow($model, 'formulajasadokter', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); 
        ?>
        <?php //echo $form->textFieldRow($model, 'formulajasaparamedis', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); 
        ?>
        <div class="control-group" style="margin-top:17px;">
					<?php echo $form->labelEx($model,'ishargajualhet', array('class' => 'control-label','label'=>'Harga Jual Tidak Melebihi HET')) 
                    ?>
					<div class="controls">
						<div class="make-switch">
							<?php  echo $form->checkBox($model, 'ishargajualhet', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => 'Harga Jual Tidak Melebihi HET')); 
                            ?>
						</div>
					</div>
				</div>
        <?php echo $form->textFieldRow($model,'persensubsidirspegawai',array('class'=>'span3 float2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php echo $form->textFieldRow($model, 'pembulatanharga', array('class' => 'span3 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); 
        ?>
        <?php  //echo $form->textFieldRow($model,'pembulatanretail',array('class'=>'span3 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php  echo $form->textFieldRow($model,'admracikan',array('class'=>'span3 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-success" style="margin-top: 17px;">
            <div class="panel-heading">
                <div class="panel-title">
                    Konfig Harga Jual
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="control-group ">
                    <div class="controls">
                        <?php echo $form->radioButton($model, 'ishargaperpenjamin', array('class' => 'ishargaperpenjamin', 'value' => 0, 'uncheckValue' => null, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Harga Jual Berdasarkan Master Obat Alkes</label>
                    </div>
                </div>
                <div class="control-group ">
                    <div class="controls">
                        <?php echo $form->radioButton($model, 'ishargaperpenjamin', array('class' => 'ishargaperpenjamin', 'value' => 1, 'uncheckValue' => null, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Harga Jual Berdasarkan Per Penjamin</label>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo $form->label($model, 'marginpenjualanlangsung', array('class' => 'control-label', 'style' => 'width: 210px')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'marginpenjualanlangsung', array('class' => 'span1 integer-decimal validasiPersen', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->label($model, 'marginpenjualanresepumum', array('class' => 'control-label', 'style' => 'width: 210px')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'marginpenjualanresepumum', array('class' => 'span1 integer-decimal validasiPersen', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->label($model, 'marginpenjualandokter', array('class' => 'control-label', 'style' => 'width: 210px')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'marginpenjualandokter', array('class' => 'span1 integer-decimal validasiPersen', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->label($model, 'marginpenjualankaryawan', array('class' => 'control-label', 'style' => 'width: 210px')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'marginpenjualankaryawan', array('class' => 'span1 integer-decimal validasiPersen', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success" style="margin-top: 17px;">
            <div class="panel-heading">
                <div class="panel-title">
                    Harga Jual
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php echo $form->dropDownListRow($model, 'hargaygdigunakan', LookupM::getItems('hargaygdigunakan'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <div class="control-group">
                    <div class="controls">
                        <?php echo $form->checkBox($model, 'ishargajualhet', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?> <label>Harga Jual Tidak Melebihi HET</label>
                    </div>
                </div>
                <div class="panel panel-darkk" style="margin-top: 17px;">
                    <span class="group-title" style="padding: 5px !important;">
                        Harga Jual Global
                    </span>
                    <div class="panel-body">
                        <div class="control-group">
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'hargajualglobal', array('class' => '', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?> <label>Harga Jual Global</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Margin (%) <span class='required'>*</span>", '', array('class' => 'control-label required', 'style' => 'width: 200px')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'persenmargin', array('class' => 'span3 integer-decimal validasiPersen', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 6)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Margin Resep (%) <span class='required'>*</span>", '', array('class' => 'control-label required', 'style' => 'width: 200px')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'marginresep', array('class' => 'span3 integer-decimal validasiPersen', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Margin Non Resep (%) <span class='required'>*</span>", '', array('class' => 'control-label required', 'style' => 'width: 200px')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'marginnonresep', array('class' => 'span3 integer-decimal validasiPersen', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Biaya Administrasi Racikan (Rp) <span class='required'>*</span>", '', array('class' => 'control-label required', 'style' => 'width: 200px')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'admracikan', array('class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Biaya Administrasi (Rp) <span class='required'>*</span>", '', array('class' => 'control-label required', 'style' => 'width: 200px')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'administrasi', array('class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Persentase Harga Jual Bebas (%) <span class='required'>*</span>", '', array('class' => 'control-label required', 'style' => 'width: 200px')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'persjualbebas', array('class' => 'span3 integer-decimal validasiPersen', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success" style="margin-top: 17px;">
            <div class="panel-heading">
                <div class="panel-title">
                    Pesan
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php echo $form->textAreaRow($model, 'pesandistruk', array('rows' => 6, 'cols' => 50, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textAreaRow($model, 'pesandifaktur', array('rows' => 6, 'cols' => 50, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        
        <div class="control-group" style="margin-top: 17px;">
        <?php  echo $form->dropDownListRow($model,'metodeantrian', LookupM::getItems('metodeantrian'),array('class'=>'span3', 'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); 
        ?>
        
        <?php echo $form->textFieldRow($model, 'persehargajual', array('class' => 'span3 float2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 3)); 
        ?>
        <?php echo $form->textFieldRow($model, 'totalpersenhargajual', array('class' => 'span3 float2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 3)); 
        ?>
        </div>

        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')) 
            ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'otomatismargin', array('onkeyup' => "return $(this).focusNextInputField(event);")); 
                ?> <label>Margin Otomatis</label>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')) 
            ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'konfigfarmasi_aktif', array('onkeypress' => "return $(this).focusNextInputField(event);")); 
                ?> <label>Aktif</label>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-success" style="margin-top: 17px;">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Tanggungan Jenis Penjualan Obat Alkes</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table width="100%" class="table table-bordered" id="tabTanggungan">
            <thead>
                <tr>
                    <th>Jenis Penjualan Obat Alkes</th>
                    <th>Tanggungan Asuransi</th>
                    <th>Tanggungan Pemerintah</th>
                    <th>Tanggungan Rumah Sakit</th>
                    <th>Tambah</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $tg = TanggunganpenjualanM::model()->findAll();
                if (count((array)$tg) == 0) :
                ?>
                    <tr>
                        <td><?php echo CHtml::dropDownList('tanggungan[jenis][]', null, LookupM::getItems('jenispenjualan'), array('empty' => '-- Pilih --', 'class' => 'span2 jenis')); ?></td>
                        <td><?php echo CHtml::textField('tanggungan[asuransi][]', 0, array('class' => 'span2 integer-decimal asuransi')); ?></td>
                        <td><?php echo CHtml::textField('tanggungan[pemerintah][]', 0, array('class' => 'span2 integer-decimal pemerintah')); ?></td>
                        <td><?php echo CHtml::textField('tanggungan[rs][]', 0, array('class' => 'span2 integer-decimal rs')); ?></td>
                        <td><?php
                            echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array(
                                'class' => 'btn btn-primary adds',
                                'onclick' => 'tambahItemTanggungan(this)',
                            )) . " " . CHtml::htmlButton('<i class="icon-minus icon-white"></i>', array(
                                'class' => 'btn btn-danger removes',
                                'onclick' => 'hapusItem(this)',
                                'style' => 'display: none;',
                            ));
                            ?>
                        </td>
                    </tr>
                <?php else : ?>
                    <?php
                    $cnt = 0;
                    foreach ($tg as $item) : ?>
                        <tr>
                            <td><?php echo CHtml::dropDownList('tanggungan[jenis][]', $item->lookup_name, LookupM::getItems('jenispenjualan'), array('empty' => '-- Pilih --', 'class' => 'span2 jenis')); ?></td>
                            <td><?php echo CHtml::textField('tanggungan[asuransi][]', str_replace(".", ",", $item->subsidiasuransi), array('class' => 'span2 integer-decimal asuransi')); ?></td>
                            <td><?php echo CHtml::textField('tanggungan[pemerintah][]', str_replace(".", ",", $item->subsidipemerintah), array('class' => 'span2 integer-decimal pemerintah')); ?></td>
                            <td><?php echo CHtml::textField('tanggungan[rs][]', str_replace(".", ",", $item->subsidirs), array('class' => 'span2 integer-decimal rs')); ?></td>
                            <td><?php
                                echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array(
                                    'class' => 'btn btn-primary adds',
                                    'onclick' => 'tambahItemTanggungan(this)',
                                )) . " " . CHtml::htmlButton('<i class="icon-minus icon-white"></i>', array(
                                    'class' => 'btn btn-danger removes',
                                    'onclick' => 'hapusItem(this)',
                                    'style' => ($cnt == 0 ? 'display: none;' : null),
                                )); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php echo $this->renderPartial('_formJasaFarmasi', array('model' => $model, 'jasaFarmasi' => $jasaFarmasi), true); ?>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
                    //    echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Konfigurasi Farmasi', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
    $content = $this->renderPartial('../tips/tipsaddedit4b', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>
<?php Yii::app()->clientScript->registerScript('angka', "
$(document).ready(function () {
        $('.numbersOnly').keypress(function(event) {
                var charCode = (event.which) ? event.which : event.keyCode
                if ((charCode >= 48 && charCode <= 57)
                        || charCode == 46
                        || charCode == 44)
                        return true;
                return false;
        });
        formatNumberSemua();
        $('.validasiPersen').on('blur',function(event){
            unformatNumberSemua();
            if(parseFloat($(this).val()) > 100){
                myAlert('Nilai tidak boleh lebih dari 100');
                $(this).val(0);
            }
            formatNumberSemua();
        });
});
", CClientScript::POS_HEAD); ?>
<script>
    function tambahItemTanggungan() {
        $("#tabTanggungan tbody tr:first-child").clone().appendTo($("#tabTanggungan tbody"));
        $("#tabTanggungan tbody tr:last-child .float2").val('0,00').maskMoney({
            "symbol": "",
            "defaultZero": true,
            "allowZero": true,
            "decimal": ",",
            "thousands": "",
            "precision": 2
        });
        $("#tabTanggungan tbody tr:last-child select").val(null);
        $("#tabTanggungan tbody tr:last-child .removes").show();
    }

    function hapusItem(obj) {
        $(obj).parents("tr").remove();
    }

    function cekValidasi(obj) {
        var ada_jasa_input = true;
        $(".jasa_input").each(function() {
            if ($(this).val().trim() == "") {
                ada_jasa_input = false;
            }
        });
        if (!ada_jasa_input) {
            myAlert("Jasa farmasi harus terisi semua.");
            return false;
        }
        if (requiredCheck(obj)) {
            $(".integer2, .float2, .integer-decimal").each(function(){
                $(this).val(unformatNumber($(this).val()));
            });
        }
        return true;
    }
</script>
<?php
/**
 * Dialog untuk nama Pegawai
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPenanggungJawabApoteker',
    'options' => array(
        'title' => 'Daftar Pegawai Farmasi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
$modPegawai = new GFPegawaiM();
$modPegawai->unsetAttributes();
$modPegawai->pegawai_aktif = true;
if (isset($_GET['GFPegawaiM']))
    $modPegawai->attributes = $_GET['GFPegawaiM'];
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaifarmasi-m-grid',
    'dataProvider' => $modPegawai->searchKonfigSystemFarmasi(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small",
                    "id" => "selectPegawai",
                    "href"=>"",
                    "onClick" => "
                      $(\"#penanggungjawab_apoterker_nama\").val(\"$data->nama_pegawai\");
                      $(\"#' . CHtml::activeId($model, 'penanggungjawab_apoterker_id') . '\").val(\"$data->pegawai_id\");
                      $(\"#dialogPenanggungJawabApoteker\").dialog(\"close\");
                      return false;
                    "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => CHtml::activeTextField($modPegawai, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => CHtml::activeTextField($modPegawai, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => CHtml::activeDropDownList($modPegawai, 'jeniskelamin', LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
            'filter' => Chtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '}',
));
$this->endWidget();
?>