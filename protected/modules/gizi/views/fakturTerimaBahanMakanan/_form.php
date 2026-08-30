<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Faktur Pembelian Bahan Makanan</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', '<b>Berhasil!</b> Data berhasil disimpan.');
        }
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'gzterimabahanmakan-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#',
        ));
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <?php echo $form->errorSummary($model); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Form <b>Pembelian Bahan Makanan</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo Chtml::label("No Permintaan", 'No Permintaan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'nopengajuan', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo Chtml::label("No Penerimaan Bahan", 'temp_no', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'terimabahanmakan_id'); ?>
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $model,
                                    'attribute' => 'nopenerimaanbahan',
                                    'source' => 'js: function(request, response) {
                                                                           $.ajax({
                                                                               url: "' . $this->createUrl('autocompleteTerimaBahanMakanan') . '",
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
                                                                        $(this).val( ui.item.label);
                                                                        return false;
                                                                    }',
                                        'select' => 'js:function( event, ui ) {
                                                                        setTerimaBahanMakan(ui.item.value);
                                                                        return false;
                                                                    }',
                                    ),
                                    'htmlOptions' => array(
                                        'class' => 'span3',
                                        'placeholder' => 'No Penerimaan Bahan',
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogBahanMakanan'),
                                ));
                                ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($model, 'sumberdanabhn', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'tglterimabahan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'tglterimabahan', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->hiddenField($model, 'supplier_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textFieldRow($model, 'supplier_nama', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'tglsurjalan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->textField($model, 'tglsurjalan', array('readonly' => true, 'class' => 'span3'));
                                ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($model, 'nosuratjalan', array('class' => 'span3 alphanumber', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => true)); ?>
                        <?php echo $form->textAreaRow($model, 'keterangan_terima_bahan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success" style="display: none;" id="divuangmukabeli">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pembayaran Uang Muka</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('No. Pembayaran <span class="required">*</span>', 'nopembayaran', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modUangmuka, 'nopembayaran', array('readonly' => true, 'class' => 'span3')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Tgl. Pembayaran <span class="required">*</span>', 'tgluangmukabeli', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modUangmuka, 'tgluangmukabeli', array('readonly' => true, 'class' => 'span3')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('Jumlah Uang Muka <span class="required">*</span>', 'jumlahuang', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modUangmuka, 'jumlahuang', array('readonly' => true, 'class' => 'integer-decimal span3')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Faktur Bahan Makanan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <table class="table table-striped table-condensed table-bordered" id="tableBahanMakanan">
                    <thead>
                        <tr>
                            <th hidden><input type="checkbox" id="checkListUtama" name="checkListUtama" value="1" checked="checked" onclick="checkAll('cekList',this);hitungSemua();"></th>
                            <th>No.</th>
                            <th>Kelompok</th>
                            <th>Nama</th>
                            <th>Jumlah Persediaan</th>
                            <th>Jumlah Terima</th>
                            <th>Tanggal Kedaluwarsa</th>
                            <th>Harga Netto (Rp)</th>
                            <th>Keringanan (%)</th>
                            <th>Keringanan (Rp)</th>
                            <th>PPN (%)</th>
                            <th>PPN (Rp)</th>
                            <th>PPh (%)</th>
                            <th>PPh (Rp)</th>
                            <th>Subtotal (Rp)</th>
                            <th hidden>Batal</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan='13'>
                                <div class='pull-right'>Total Harga</div>
                            </td>
                            <td><?php echo CHtml::textField('tothargabruto', '', array('style' => 'text-align:right; width:120px;', 'readonly' => TRUE, 'class' => 'span2 integer-decimal total_semua')); // echo $form->textField($model, 'totalharganetto', array('readonly' => true, 'class' => 'span2 integer2 total_semua', 'onkeypress' => "return $(this).focusNextInputField(event);",'style'=>'width:120px;')); 
                                ?></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="row" style="margin-top: 17px;">
            <div class="col-sm-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Faktur <b>Pembelian Bahan Makanan</b>
                        </div>
                    </div>
                    <div class="panel-body" style="min-height: 303px;">
                        <div class="control-group">
                            <?php echo CHtml::label('No. Faktur <span class="required">*</span>', '', array('class' => 'control-label required')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'nofaktur', array('placeholder' => 'No. Faktur', 'class' => 'span3 alphanumber', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'tglfaktur', array('class' => 'control-label required', 'label' => 'Tanggal Faktur <span class="required">*</span>')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tglfaktur',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'span3', 'onchange' => 'loadJatuhTempo();'),
                                ));
                                ?>
                                <?php echo $form->error($model, 'tglfaktur'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'tgljatuhtempo', array('class' => 'control-label required', 'label' => 'Tanggal Jatuh Tempo')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tgljatuhtempo',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        //                                                            'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'span3'),
                                ));
                                ?>
                                <?php echo $form->error($model, 'tgljatuhtempo'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Jenis PPh", "pajak_id", array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'pajak_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->textField($model, 'pajak_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                                <?php // echo $form->dropDownList($model,'pajak_id',
                                //                                            CHtml::listData(PajakM::model()->findAll('pajak_aktif = true AND ispajakpegawai = false ORDER BY pajak_nama ASC'), 'pajak_id', 'pajak_nama'),
                                //                                            array('class'=>'span2', 'onkeyup'=>"return $(this).focusNextInputField(event)",
                                //                                            'empty'=>'-- Psilih --',)); 
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Syarat Bayar <span class='required'>*</span>", "syaratbayar_id", array('class' => 'control-label required')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList(
                                    $model,
                                    'syaratbayar_id',
                                    CHtml::listData(SyaratbayarM::model()->findAll('syaratbayar_aktif = true ORDER BY syaratbayar_nama ASC'), 'syaratbayar_id', 'syaratbayar_nama'),
                                    array(
                                        'class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                        'empty' => '-- Pilih --',
                                    )
                                ); ?>
                            </div>
                        </div>
                        <?php echo $form->textAreaRow($model, 'keteranganfaktur', array('placeholder' => 'Keterangan', 'class' => 'span3', 'rows' => 3, 'onkeyup' => "return $(this).focusNextInputField(event)")) ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-info-circled"></i> Informasi <b>Harga</b>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="control-group">
                            <?php echo CHtml::label('Total Harga', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'totalharganetto', array('class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'style' => 'text-align: right;')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Total Keringanan', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo Chtml::hiddenField('discountpersen', '0', array('class' => 'span1 float2', 'onblur' => 'setTotalHarga();', 'style' => 'text-align: right;')); ?>
                                <?php echo $form->textField($model, 'totaldiscount', array('readonly' => true, 'class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right;')); ?>
                                <?php echo $form->error($model, 'totaldiscount'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo Chtml::label("Total PPN", 'pajakppn', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo Chtml::hiddenField('ppnpersen', '10', array('class' => 'span1 float2', 'style' => 'text-align: right;')); ?>
                                <?php echo $form->textField($model, 'pajakppn', array('class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right;', 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Total PPh', 'pajakpph', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'persenpph_22', array('readonly' => false, 'onblur' => 'setTotalHarga(); hitungSemua();', 'class' => 'inputFormTabel float2 span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->textField($model, 'pajakpph', array('readonly' => true, 'class' => 'inputFormTabel integer-decimal span3 text-right', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo Chtml::label("Total Keseluruhan", 'totalkeseluruhan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'totalkeseluruhan', array('class' => 'span3 integer-decimal text-right', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo Chtml::label("Jumlah Uang Muka", 'jmluangmukabeli', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'jmluangmukabeli', array('class' => 'span3 integer-decimal text-right', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo Chtml::label("Total Harga Netto", 'totalhutangusaha', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'totalhutangusaha', array('class' => 'span3 integer-decimal text-right', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readonly' => true)); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php
            if ($model->isNewRecord) {
                echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'setVerifikasiHpp();', 'onKeypress' => 'return formSubmit(this,event)'));
            } else {
                echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true));
            }
            ?>
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index', array('modul_id' => Yii::app()->session['modul_id'])),
                array(
                    'class' => 'btn btn-default',
                    'title' => 'Ulang',
                    'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index', array('modul_id' => Yii::app()->session['modul_id'])) . '";}); return false;'
                )
            );
            ?>
            <?php
            if ($model->isNewRecord) {
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => TRUE));
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printData();return false", 'disabled' => FALSE));
            }
            ?>
            <?php
            $content = $this->renderPartial('gizi.views.tips.transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
        </div>
        <?php $this->endWidget(); ?>
        <?php
        $totalHarga = CHtml::activeId($model, 'totalharganetto');
        $urlBahan = $this->createUrl('getBahanMakananDariPenerimaan');
        ?>
        <?php
        //========= Dialog buat cari Bahan Makanan =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogBahanMakanan',
            'options' => array(
                'title' => 'Terima Bahan Makanan',
                'autoOpen' => false,
                'modal' => true,
                'width' => 1000,
                'height' => 500,
                'resizable' => false,
            ),
        ));
        $modelTerima = new GZTerimabahanmakan('search');
        //		$model->unsetAttributes();  // clear any default values
        if (isset($_GET['GZTerimabahanmakan'])) {
            $model->attributes = $_GET['GZTerimabahanmakan'];
            $format = new MyFormatter();
        }
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'gzbahanmakanan-m-grid',
            'dataProvider' => $modelTerima->searchInformasiUntukFaktur(),
            'filter' => $modelTerima,
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'Pilih',
                    'type' => 'raw',
                    'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
										"id" => "selectBahan",
										"onClick" => "setTerimaBahanMakan(".$data->terimabahanmakan_id."); 
                                            $(\"#dialogBahanMakanan\").dialog(\"close\");
                                            return false;"
                                        ))',
                ),
                array(
                    'header' => 'No. Penerimaan',
                    'value' => '$data->nopenerimaanbahan',
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                ),
                array(
                    'header' => 'Tanggal Terima',
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                    'value' => '$data->tglterimabahan',
                ),
                array(
                    'header' => 'Supplier',
                    'name' => 'supplier_id',
                    'type' => 'raw',
                    'value' => function ($data) {
                        if (empty($data->supplier_id)) {
                            return "-";
                        }
                        $supplier = SupplierM::model()->findByPk($data->supplier_id);
                        if (empty($supplier)) {
                            return "-";
                        }
                        return $supplier->supplier_nama;
                    },
                    'filter' => CHtml::activeDropDownList($modelTerima, 'supplier_id', CHtml::listData($modelTerima->Supplier, 'supplier_id', 'supplier_nama'), array(
                        'empty' => '-- Pilih --',
                    )),
                ),
                array(
                    'header' => 'Total Harga Netto (Rp)',
                    'name' => 'totalharganetto',
                    'value' => 'MyFormatter::formatNumberForPrint($data->totalharganetto)',
                    'filter' => false,
                    'htmlOptions' => array(
                        'style' => 'text-align: right;',
                    ),
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                ),
                array(
                    'name' => 'totaldiscount',
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                    'value' => 'MyFormatter::formatNumberForPrint($data->totaldiscount)',
                    'filter' => false,
                    'htmlOptions' => array(
                        'style' => 'text-align: right;',
                    ),
                ),
                //                array(
                //                    'name'=>'biayapengiriman',
                //                    'value'=>'"Rp".MyFormatter::formatNumberForPrint($data->biayapengiriman)',
                //                    'filter'=>false,
                //                    'htmlOptions'=>array(
                //                        'style'=>'text-align: right',
                //                    )
                //                ),
                //                array(
                //                    'name'=>'biayatransportasi',
                //                    'value'=>'"Rp".MyFormatter::formatNumberForPrint($data->biayatransportasi)',
                //                    'filter'=>false,
                //                    'htmlOptions'=>array(
                //                        'style'=>'text-align: right',
                //                    )
                //                ),
                array(
                    'header' => 'Total PPN (Rp)',
                    //                    'name'=>'biayapajak',
                    'value' => 'MyFormatter::formatNumberForPrint($data->biayapajak)',
                    'filter' => false,
                    'htmlOptions' => array(
                        'style' => 'text-align: right;',
                    )
                ),
                array(
                    'name' => 'keterangan_terima_bahan',
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                ),
                //        'jmlminimal',
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        $this->endWidget();
        ?>
        <?php echo $this->renderPartial($this->path_view . '_jsFunctions', array('totalHarga' => $totalHarga, 'urlBahan' => $urlBahan, 'model' => $model, 'modUangmuka' => $modUangmuka), true); ?>
    </div>
</div>