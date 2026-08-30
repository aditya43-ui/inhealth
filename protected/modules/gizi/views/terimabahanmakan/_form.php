<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-utensils"></i> Transaksi <b>Penerimaan Bahan Makanan</b>
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
        <?php if (!empty($modPengajuan)) { ?>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="fas fa-file-contract"></i> Data <b>Permintaan Pembelian</b>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="control-group">
                                <?php echo CHtml::activeLabel($modPengajuan, 'nopengajuan', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    echo CHtml::activeTextField($modPengajuan, 'nopengajuan', array('class' => 'span4', 'readonly' => true))
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::activeLabel($modPengajuan, 'tglpengajuanbahan', array('class' => 'control-label', 'label' => 'Tanggal Permintaan')) ?>
                                <div class="controls">
                                    <?php
                                    echo CHtml::activeTextField($modPengajuan, 'tglpengajuanbahan', array('class' => 'span4', 'readonly' => true))
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label('Jenis PPh', '', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->hiddenField($model, 'pajak_id', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    <?php echo $form->textField($model, 'pajak_nama', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="control-group">
                                <?php echo $form->labelEx($model, 'sumberdanabhn', array('class' => 'control-label', 'label' => 'Sumber Dana')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'sumberdanabhn', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($model, 'supplier_id', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->hiddenField($model, 'supplier_id', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    <?php echo $form->textField($model, 'supplier_nama', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-file-contract"></i> Data <b>Penerimaan Bahan Makanan</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <?php echo $form->textFieldRow($model, 'nopenerimaanbahan', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'tglterimabahan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tglterimabahan',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'span4'),
                                ));
                                ?>
                                <?php echo $form->error($model, 'tglterimabahan'); ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($model, 'nosuratjalan', array('placeholder' => 'No. Surat Jalan', 'class' => 'span4 alphanumber', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'tglsurjalan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tglsurjalan',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'span4'),
                                ));
                                ?>
                                <?php echo $form->error($model, 'tglsurjalan'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo Chtml::label("Pegawai Penerima <span style='color:red'>*</span>", 'pegawai_id', array('class' => 'control-label required')); ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'pegawai_id', array('class' => 'required', 'readonly' => true)); ?>
                                <?php echo $form->textField($model, 'pegawai_nama', array('readonly' => true, 'class' => 'span4')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo Chtml::label("Pegawai Mengetahui <span style='color:red'>*</span>", 'mengetahui_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'mengetahui_id', array('class' => 'required', 'readonly' => true)); ?>
                                <?php echo $form->textField($model, 'mengetahui_nama', array('class' => 'span4', 'readonly' => true)); ?>
                            </div>
                        </div>
                        <?php echo $form->textAreaRow($model, 'keterangan_terima_bahan', array('placeholder' => 'Keterangan Penerimaan', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo Chtml::label("Tgl. Pembayaran Uang Muka", '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modUangMuka, 'tgluangmukabeli', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo Chtml::label("Jumlah Uang Muka", '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo (Params::cekHiddenHargaGizi() == true) ? $form->textField($modUangMuka, 'jumlahuang', array('readonly' => true, 'class' => 'span4 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);")) : $form->passwordField($modUangMuka, 'jumlahuang', array('readonly' => true, 'class' => 'span4 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <?php echo (Params::cekHiddenHargaGizi() == true) ? $form->textFieldRow($model, 'totalharganetto', array('readonly' => true, 'class' => 'span4 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);")) : $form->passwordFieldRow($model, 'totalharganetto', array('readonly' => true, 'class' => 'span4 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'totaldiscount', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo Chtml::hiddenField('discountpersen', '', array('class' => 'span1 integer-decimal', 'onkeyup' => 'hitungTotalDiscount();', 'onfocus' => 'hitungTotalDiscount();', 'maxlength' => 3)); ?>
                                <!--% =-->
                                <?php echo (Params::cekHiddenHargaGizi() == true) ? $form->textField($model, 'totaldiscount', array('readonly' => true, 'class' => 'span4 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);")) : $form->passwordField($model, 'totaldiscount', array('readonly' => true, 'class' => 'span4 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->error($model, 'totaldiscount'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Total PPN', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo (Params::cekHiddenHargaGizi() == true) ? $form->textField($model, 'biayapajak', array('class' => 'span4 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)) : $form->passwordField($model, 'biayapajak', array('class' => 'span4 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Total PPh', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo (Params::cekHiddenHargaGizi() == true) ? $form->textField($model, 'biayapajakpph', array('class' => 'span4 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)) : $form->passwordField($model, 'biayapajakpph', array('class' => 'span4 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Total Keseluruhan', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo (Params::cekHiddenHargaGizi() == true) ? $form->textField($model, 'totalkeseluruhan', array('class' => 'span4 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)) : $form->passwordField($model, 'totalkeseluruhan', array('class' => 'span4 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Penerimaan Bahan Makanan</b>
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
                        <?php
                        if (!empty($modDetailPengajuan)) {
                            foreach ($modDetailPengajuan as $i => $baris) {
                                $persediaan = empty($baris->bahanmakanan->jmlpersediaan) ? 0 : $baris->bahanmakanan->jmlpersediaan;
                                /* 
                                         * Jika stok gizi di centang pada konfig sistem maka jumlah pada
                                         * data stok ditampilkan. Jika tidak maka hanya menampilkan data
                                         * jmlpersediaan pada master
                                         */
                                $stokgizi = Yii::app()->user->getState('krngistokgizi');
                                if ($stokgizi) {
                                    $stok = StokbahanmakananT::model()->findAllByAttributes(array(
                                        'bahanmakanan_id' => $baris->bahanmakanan_id,
                                    ));
                                    $tot = 0;
                                    foreach ($stok as $item) {
                                        $tot += $item->qty_current;
                                    }
                                    $persediaan = $tot;
                                }
                                $modDetail = new TerimabahandetailT();
                                $modDetail->persendiscount = (!empty($baris->persendiscount) ? $baris->persendiscount : 0);
                                $modDetail->persenppn = (!empty($baris->persenppn) ? $baris->persenppn : 0);
                                $modDetail->persenpph = (!empty($baris->persenpph) ? $baris->persenpph : 0);
                                $modDetail['satuanbahan'] = $baris->satuanbahan;
                                $subNetto = $baris->qty_pengajuan * $baris->harganettobhn;

                                $baris->harganettobhn = MyFormatter::formatNumberForPrint($baris->harganettobhn,2);
                                $baris->qty_pengajuan = MyFormatter::formatNumberForPrint($baris->qty_pengajuan,2);

                                echo '<tr>
                                                        <td hidden>'
                                    . CHtml::checkBox('checkList[' . $i . ']', true, array('class' => 'cekList', 'onclick' => 'hitungSemua()'))
                                    . CHtml::activeHiddenField($modDetail, '[0]golbahanmakanan_id', array('value' => $baris->golbahanmakanan_id))
                                    . CHtml::activeHiddenField($modDetail, '[0]bahanmakanan_id', array('value' => $baris->bahanmakanan_id))
                                    //. CHtml::activeHiddenField($modDetail, '[0]harganettobhn', array('value' => $baris->harganettobhn))
                                    . CHtml::activeHiddenField($modDetail, '[0]jmlkemasan', array('value' => $baris->jmlkemasan))
                                    . CHtml::activeHiddenField($modDetail, '[0]hargajualbahan', array('value' => $baris->bahanmakanan->hargajualbahan))
                                    . CHtml::activeHiddenField($modDetail, '[0]ukuran_bahanterima', array('value' => $baris->ukuranbahan))
                                    . CHtml::activeHiddenField($modDetail, '[0]pengajuanbahandetail_id', array('value' => $baris->pengajuanbahandetail_id))
                                    . CHtml::activeHiddenField($modDetail, '[0]merk_bahanterima', array('value' => $baris->merkbahan))
                                    . '</td>
                                            <td>' . CHtml::textField('noUrut[]', $i + 1, array('class' => 'noUrut span1', 'readonly' => true, 'style' => 'width:30px;')) . '</td>
                                            <td hidden>' . $baris->golbahanmakanan->golbahanmakanan_nama . '</td>
                                            <td hidden>' . $baris->bahanmakanan->jenisbahanmakanan . '</td>
                                            <td>' . $baris->bahanmakanan->kelbahanmakanan . '</td>
                                            <td>' . $baris->bahanmakanan->namabahanmakanan . '</td>
                                            <td style="text-align: right">' . MyFormatter::formatNumberForUser($persediaan) . " " . $baris->satuanbahan . '</td>
                                            <td hidden>' . CHtml::activeDropDownList($modDetail, '[0]satuanbahan', LookupM::getItems('satuanbahanmakanan'), array('options' => array('' . $baris->satuanbahan . '' => array('selected' => 'selected')), 'class' => 'span4 satuanbahan')) . '</td>
                                            <td hidden>' . CHtml::activeTextField($modDetail, '[0]discount', array('value' => $baris->bahanmakanan->discount, 'class' => 'discount span1 integer2', 'onblur' => 'hitungTotalDiscount();')) . '</td>' .
                                    '<td>' . CHtml::activeTextField($modDetail, '[0]qty_terima', array('value' => $baris->qty_pengajuan, 'class' => 'span1 integer-decimal qty', 'onblur' => 'hitungSemua();', 'readonly' => false)) . " " . $baris->satuanbahan . '</td>' .
                                    '<td>' .
                                    '<div class="input-append">' .
                                    CHtml::activeTextField($modDetail, '[0]tglkadaluarsabahan', array('readonly' => true, 'value' => MyFormatter::formatDateTimeForUser($baris->bahanmakanan->tglkadaluarsabahan), 'class' => 'tanggal', 'style' => 'float:left;width:120px;')) .
                                    '<span class="add-on tgl_tombol" onclick="$(this).parent().find(\'.tanggal\').datepicker(\'show\')"><i class="entypo-calendar"></i></span>' .
                                    '</div>' .
                                    '</td>    
                                            <td>' . ((Params::cekHiddenHargaGizi() == true) ? CHtml::activeTextField($modDetail, '[0]harganettobahan', array('value' => $baris->harganettobhn, 'class' => 'span4 integer-decimal harganettobahan', 'onblur' => 'hitungSemua();', 'readonly' => true, 'style' => 'width:100px;')) : CHtml::activePasswordField($modDetail, '[0]harganettobahan', array('value' => $baris->harganettobhn, 'class' => 'span4 integer-decimal harganettobahan', 'onblur' => 'hitungSemua();', 'readonly' => true, 'style' => 'width:100px;'))) . '</td>
                                            <td>' . CHtml::activeTextField($modDetail, '[0]persendiscount', array('class' => 'span1 float2 persendiscount', 'onblur' => 'hitungSemua();', 'readonly' => true)) . '</td>
                                            <td>' . ((Params::cekHiddenHargaGizi() == true) ? CHtml::activeTextField($modDetail, '[0]jmldiscount', array('value' => 0, 'class' => 'span4 integer-decimal jmldiscount', 'readonly' => true, 'style' => 'width:100px;')) : CHtml::activePasswordField($modDetail, '[0]jmldiscount', array('value' => 0, 'class' => 'span4 integer-decimal jmldiscount', 'readonly' => true, 'style' => 'width:100px;'))) . '</td>
                                            <td>' . CHtml::activeTextField($modDetail, '[0]persenppn', array('class' => 'span1 integer2 persenppn', 'onblur' => 'hitungSemua();', 'readonly' => true)) . '</td>
                                            <td>' . ((Params::cekHiddenHargaGizi() == true) ? CHtml::activeTextField($modDetail, '[0]jmlhargappn', array('value' => 0, 'class' => 'span4 integer-decimal jmlhargappn', 'readonly' => true, 'style' => 'width:100px;')) : CHtml::activePasswordField($modDetail, '[0]jmlhargappn', array('value' => 0, 'class' => 'span4 integer-decimal jmlhargappn', 'readonly' => true, 'style' => 'width:100px;'))) . '</td>
                                            <td>' . CHtml::activeTextField($modDetail, '[0]persenpph', array('class' => 'span1 float2 persenpph', 'onblur' => 'hitungSemua();', 'readonly' => true)) . '</td>
                                            <td>' . ((Params::cekHiddenHargaGizi() == true) ? CHtml::activeTextField($modDetail, '[0]jmlhargapph', array('value' => 0, 'class' => 'span4 integer-decimal jmlhargapph', 'readonly' => true, 'style' => 'width:100px;')) : CHtml::activePasswordField($modDetail, '[0]jmlhargapph', array('value' => 0, 'class' => 'span4 integer-decimal jmlhargapph', 'readonly' => true, 'style' => 'width:100px;'))) . '</td>
                                            <td>' . ((Params::cekHiddenHargaGizi() == true) ? CHtml::TextField('[0]subNetto', MyFormatter::formatNumberForPrint($subNetto), array('value' => MyFormatter::formatNumberForPrint($subNetto), 'class' => 'subNetto span4 integer-decimal', 'readonly' => true, 'style' => 'text-align:right:width:120px;')) : CHtml::PasswordField('[0]subNetto', MyFormatter::formatNumberForPrint($subNetto), array('value' => MyFormatter::formatNumberForPrint($subNetto), 'class' => 'subNetto span4 integer-decimal', 'readonly' => true, 'style' => 'text-align:right:width:120px;'))) . '</td>
                                            <td hidden>' . CHtml::link("<span class='icon-form-silang'>&nbsp;</span>", '', array('href' => '', 'onclick' => 'hapus(this);return false;', 'style' => 'text-decoration:none;', 'class' => 'cancel')) . '</td>
                                            </tr>'; //<td>' . $baris->bahanmakanan->hargajualbahan . '</td>
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="form-actions">
            <?php
            if (isset($_GET['sukses'])) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'disabled' => true));
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
            }
            ?>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index', array('modul_id' => Yii::app()->session['modul_id'])), array(
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index', array('modul_id' => Yii::app()->session['modul_id'])) . '";}); return false;'
            ));
            ?>
            <?php
            if (isset($_GET['sukses'])) {
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printData();", 'disabled' => FALSE));
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true));
            }
            ?>
            <?php
            $content = $this->renderPartial('../tips/transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php
$totalHarga = CHtml::activeId($model, 'totalharganetto');
$urlBahan = $this->createUrl('getBahanMakananDariPenerimaan');
?>
<?php echo $this->renderPartial('_jsFunctions', array('totalHarga' => $totalHarga, 'urlBahan' => $urlBahan, 'model' => $model), true); ?>
<?php
//========= Dialog buat cari Bahan Makanan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogBahanMakanan',
    'options' => array(
        'title' => 'Bahan Makanan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'resizable' => false,
    ),
));
$modBahanMakanan = new GZBahanMakananM('search');
$modBahanMakanan->unsetAttributes();
if (isset($_GET['GZBahanMakananM'])) {
    $modBahanMakanan->attributes = $_GET['GZBahanMakananM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'gzbahanmakanan-m-grid',
    'dataProvider' => $modBahanMakanan->search(),
    'filter' => $modBahanMakanan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                                                "id" => "selectBahan",
                                                                "onClick" => "$(\'#idBahan\').val($data->bahanmakanan_id);
                                                                $(\'#namaBahan\').val(\'$data->jenisbahanmakanan - $data->namabahanmakanan\');
                                                                $(\'#satuanbahan\').val(\'$data->satuanbahan\');
                                                                $(\'#qty\').val(1);
                                                                $(\'#dialogBahanMakanan\').dialog(\'close\');return false;"))',
        ),
        array(
            'name' => 'golbahanmakanan_id',
            'filter' => CHtml::activeDropDownList($modBahanMakanan, 'golbahanmakanan_id', CHtml::listData(GolbahanmakananM::model()->findAll('golbahanmakanan_aktif = true'), 'golbahanmakanan_id', 'golbahanmakanan_nama'), array('empty' => '-- Pilih --')),
            'value' => '$data->golbahanmakanan->golbahanmakanan_nama',
        ),
        array(
            'name' => 'jenisbahanmakanan',
            'filter' => CHtml::activeDropDownList($modBahanMakanan, 'jenisbahanmakanan', LookupM::getItems('jenisbahanmakanan'), array('empty' => '-- Pilih --')),
            'value' => '$data->jenisbahanmakanan',
        ),
        array(
            'name' => 'kelbahanmakanan',
            'filter' => CHtml::activeDropDownList($modBahanMakanan, 'kelbahanmakanan', LookupM::getItems('kelompokbahanmakanan'), array('empty' => '-- Pilih --')),
            'value' => '$data->kelbahanmakanan',
        ),
        'namabahanmakanan',
        array(
            'name' => 'jmlpersediaan',
            'value' => function ($data) {
                /* 
                                 * Jika stok gizi di centang pada konfig sistem maka jumlah pada
                                 * data stok ditampilkan. Jika tidak maka hanya menampilkan data
                                 * jmlpersediaan pada master
                                 */
                $stokgizi = Yii::app()->user->getState('krngistokgizi');
                if ($stokgizi) {
                    $stok = StokbahanmakananT::model()->findAllByAttributes(array(
                        'bahanmakanan_id' => $data->bahanmakanan_id,
                    ));
                    $tot = 0;
                    foreach ($stok as $item) {
                        $tot += $item->qty_current;
                    }
                    return $tot . " " . $data->satuanbahan;
                }
                return $data->jmlpersediaan . " " . $data->satuanbahan;
            },
            'htmlOptions' => array(
                'style' => 'text-align: right;',
            ),
            'filter' => false,
        ),
        array(
            'name' => 'harganettobahan',
            'value' => 'MyFormatter::formatNumberForPrint($data->harganettobahan)',
            'htmlOptions' => array(
                'style' => 'text-align: right;',
            ),
            'filter' => false,
        ),
        array(
            'name' => 'hargajualbahan',
            'value' => 'MyFormatter::formatNumberForPrint($data->hargajualbahan)',
            'htmlOptions' => array(
                'style' => 'text-align: right;',
            ),
            'filter' => false,
        ),
        //'harganettobahan',
        //'hargajualbahan',
        array(
            'name' => 'discount',
            'value' => 'MyFormatter::formatNumberForPrint($data->discount)',
            'htmlOptions' => array(
                'style' => 'text-align: right;',
            ),
            'filter' => false,
        ),
        //'discount',
        array(
            'name' => 'tglkadaluarsabahan',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglkadaluarsabahan);',
            'htmlOptions' => array(
                'style' => 'text-align: right;',
            ),
            'filter' => false,
        ),
        //        'jmlminimal',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
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
$modPegawaiMengetahui = new GZPegawaiM('searchDialog');
$modPegawaiMengetahui->unsetAttributes();
$modPegawaiMengetahui->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['GZPegawaiM'])) {
    $modPegawaiMengetahui->attributes = $_GET['GZPegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimengetahui-grid',
    'dataProvider' => $modPegawaiMengetahui->searchPegawaiRuanganLogin(),
    'filter' => $modPegawaiMengetahui,
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
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'nomorindukpegawai', array('class' => 'numbers-only')),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai', array('class' => 'hurufs-only')),
            'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
        ),
        array(
            'header' => 'Jabatan',
            'filter' =>  CHtml::activeDropDownList($modPegawaiMengetahui, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);
                if (!empty($j)) {
                    return $j->jabatan_nama;
                } else {
                    return '-';
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function(){'
        . ' setNumbersOnly(this);'
        . '});'
        . '$(".hurufs-only").keyup(function(){'
        . ' setHurufsOnly(this);'
        . '});'
        . '}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>