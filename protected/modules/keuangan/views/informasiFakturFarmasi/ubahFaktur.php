<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<style>
    .integerfloat {
        text-align: right;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Faktur Pembelian Farmasi</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', '<b>Berhasil!</b> Data berhasil disimpan.');
        }
        $this->breadcrumbs = array(
            'Ubah Faktur Pembelian Farmasi',
        );
        ?>
        <?php
        //					$this->widget('application.extensions.moneymask.MMask',array(
        //						'element'=>'.currency',
        //						'currency'=>'PHP',
        //						'config'=>array(
        //							'symbol'=>'Rp ',
        //							'defaultZero'=>true,
        //							'allowZero'=>true,
        //							'precision'=>0,
        //						)
        //					));
        //					$this->widget('application.extensions.moneymask.MMask',array(
        //						'element'=>'.integerfloat',
        //						'currency'=>'PHP',
        //						'config'=>array(
        //							'defaultZero'=>true,
        //							'allowZero'=>true,
        //							'precision'=>2,
        //                            'decimal'=>',',
        //                            'thousands'=>'.',
        //						)
        //					));
        ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'fakturpembelian-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event)' //, 'onsubmit'=>'return requiredCheck(this);'
            ),
        ));
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Ubah Faktur <strong>Pembelian Farmasi</strong></div>
            </div>
            <div class="panel-body">
				<?php

                                if(isset($_GET['sukses'])){
                                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                                }

				 	$this->breadcrumbs=array(
				            'Ubah Faktur Pembelian Farmasi',
				        );
					 ?>
				<?php
//					$this->widget('application.extensions.moneymask.MMask',array(
//						'element'=>'.currency',
//						'currency'=>'PHP',
//						'config'=>array(
//							'symbol'=>'Rp. ',
//							'defaultZero'=>true,
//							'allowZero'=>true,
//							'precision'=>0,
//						)
//					));
//					$this->widget('application.extensions.moneymask.MMask',array(
//						'element'=>'.integerfloat',
//						'currency'=>'PHP',
//						'config'=>array(
//							'defaultZero'=>true,
//							'allowZero'=>true,
//							'precision'=>2,
//                            'decimal'=>',',
//                            'thousands'=>'.',
//						)
//					));
				?>
				<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
					'id'=>'fakturpembelian-form',
					'enableAjaxValidation'=>false,
					'type'=>'horizontal',
					'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)' //, 'onsubmit'=>'return requiredCheck(this);'
                        ),
				));
                                $this->widget('bootstrap.widgets.BootAlert');
                                ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><span class='judul'>Data Penerimaan</span></div>
                    </div>
                    <div class="panel-body" id="form-rencanakebutuhan">
                        <div class ="row-fluid">
                        <div class="col-sm-6">
                            <?php echo CHtml::hiddenField('fakturpembelian_id',$modFakturPembelian->fakturpembelian_id, array('class'=>'span3 isRequired','readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)")) ?>
                            <?php echo CHtml::activehiddenField($modPenerimaanBarang,'penerimaanbarang_id',array('readonly'=>TRUE));?>
                            <div class="control-group ">
                                <?php echo CHtml::label("No Permintaan","",array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                        echo $form->hiddenField($modPenerimaanBarang,'permintaanpembelian_id',array('readonly'=>true));
                                        echo $form->textField($modPenerimaanBarang,'nopermintaan',array('readonly' => true, 'class'=>'span3'));
                                    ?>
                                </div>
                            </div>
                            <div class="control-group ">
                                    <?php echo $form->labelEx($modPenerimaanBarang,'noterima', array('class'=>'control-label')); ?>
                                    <div class="controls">
                                        <?php echo $form->textField($modPenerimaanBarang,'noterima', array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'readonly'=>true)) ?>
                                    </div>
                            </div>
                            <div class="control-group ">
                                <?php echo $form->labelEx($modPenerimaanBarang,'tglterima', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($modPenerimaanBarang,'tglterima', array('class'=>'span3','readonly'=>false, 'onkeypress'=>"return $(this).focusNextInputField(event)",'readonly'=>true)) ?>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Pegawai Penerima", "", array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->textField($modPenerimaanBarang, 'pegawai_nama', array('readonly' => true, 'class' => 'span3'));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Pegawai Mengetahui", "", array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->hiddenField($modPenerimaanBarang, 'pegawaimengetahui_id', array('readonly' => true));
                                echo $form->textField($modPenerimaanBarang, 'mengetahui_nama', array('readonly' => true, 'class' => 'span3'));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Status Penerimaan", "", array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->textField($modPenerimaanBarang, 'statuspenerimaan', array('readonly' => true, 'class' => 'span3'));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Keterangan", "", array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->textField($modPenerimaanBarang, 'keteranganterima', array('readonly' => true, 'class' => 'span3'));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label("Supplier", '', array('class' => 'control-label')) ?>
                            <?php echo CHtml::activehiddenField($modPenerimaanBarang, 'supplier_id', array('readonly' => TRUE)); ?>
                            <div class="controls">
                                <?php echo $form->textField($modPenerimaanBarang, 'supplier_nama', array('class' => 'span3', 'readonly' => false, 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Total Harga Bruto", "", array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo CHtml::textField('totneto', number_format($modPenerimaanBarang->harganetto, 2, ",", "."), array('readonly' => true, 'class' => 'span3 integer-decimal', 'style' => 'text-align:right;'));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Total Keringanan", "", array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo CHtml::textField('totdiskon', number_format($modPenerimaanBarang->jmldiscount, 2, ",", "."), array('readonly' => true, 'class' => 'span3 integer-decimal', 'style' => 'text-align:right;'));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Total PPN", "", array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo CHtml::textField('totppn', number_format($modPenerimaanBarang->totalpajakppn, 2, ",", "."), array('readonly' => true, 'class' => 'span3 integer-decimal', 'style' => 'text-align:right;'));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Total Harga Netto", "", array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo CHtml::textField('tothargabruto', number_format($modPenerimaanBarang->totalharga, 2, ",", "."), array('readonly' => true, 'class' => 'span3 integer-decimal', 'style' => 'text-align:right;'));
                                ?>
                            </div>
                        </div>
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
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Faktur Obat dan Alkes</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="block-tabel">
                    <table class="items table table-bordered table-striped table-condensed" id="table-obatalkespasien">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Kode</th>
                                <th>Nama Obat dan Alkes</th>
                                <th>Jml Terima</th>
                                <th>Harga Satuan (Rp)</th>
                                <th width="50px;">Keringanan (%)</th>
                                <th>Keringanan (Rp)</th>
                                <th width="50px;">PPN (%)</th>
                                <th>PPN (Rp)</th>
                                <th width="50px;">PPh (%)</th>
                                <th>PPh (Rp)</th>
                                <th>HPP</th>
                                <th>Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (count((array)$modDetails) > 0) {
                                $no = 1;
                                foreach ($modDetails as $i => $modFakturDetail) {
                                    $modFakturDetail->jmlterima = number_format($modFakturDetail->jmlterima, 2, ",", ".");
                                    echo $this->renderPartial('_rowObatPenerimaanBarang', array('modFakturDetail' => $modFakturDetail, 'modFakturPembelian' => $modFakturPembelian, 'format' => $format, 'key' => $i, 'no' => $no));
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> <b>Faktur Pembelian</b>
                </div>
            </div>
            <div class="panel-body" id="form-rencanakebutuhan">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <i class="entypo-info-circled"></i> Informasi <b>Faktur</b>
                                </div>
                            </div>
                            <div class="panel-body">
                                <?php echo $form->textFieldRow($modFakturPembelian, 'nofaktur', array('placeholder' => 'No. Faktur', 'class' => 'span3 alphanumber', 'onkeyup' => "return $(this).focusNextInputField(event)")) ?>
                                <div class="control-group">
                                    <?php echo $form->labelEx($modFakturPembelian, 'tglfaktur', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php
                                        $modFakturPembelian->tglfaktur = (!empty($modFakturPembelian->tglfaktur) ? date("d/m/Y H:i:s", strtotime($modFakturPembelian->tglfaktur)) : null);
                                        $this->widget('MyDateTimePicker', array(
                                            'model' => $modFakturPembelian,
                                            'attribute' => 'tglfaktur',
                                            'mode' => 'datetime',
                                            'options' => array(
                                                'showOn' => false,
                                                'maxDate' => 'd',
                                                'yearRange' => "-150:+0",
                                            ),
                                            'htmlOptions' => array(
                                                'placeholder' => '00/00/0000 00:00:00', 'class' => 'span3 dtPicker2 datetimemask', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'loadJatuhTempo();'
                                            ),
                                        )); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo $form->labelEx($modFakturPembelian, 'tgljatuhtempo', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php  echo $form->textField($modUangmuka, 'nopembayaran', array('readonly'=>true,'class'=>'span3')); ?>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <?php echo CHtml::label('Tanggal Pembayaran <span class="required">*</span>', 'tgluangmukabeli', array('class' => 'control-label')); ?>
                                    <div class="controls">
                                        <?php  echo $form->textField($modUangmuka, 'tgluangmukabeli', array('readonly'=>true,'class'=>'span3')); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="control-group ">
                                    <?php echo CHtml::label('Jumlah Uang Muka <span class="required">*</span>', 'jumlahuang', array('class' => 'control-label')); ?>
                                    <div class="controls">
                                        <?php  echo $form->textField($modUangmuka, 'jumlahuang', array('readonly'=>true,'class'=>'integer-decimal span3')); ?>
                                    </div>
                                </div>
                                <?php echo $form->textAreaRow($modFakturPembelian, 'keteranganfaktur', array('placeholder' => 'Ket. Terima Langsung Faktur', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")) ?>
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
                                <?php echo $form->textFieldRow($modFakturPembelian, 'totharganetto', array('class' => 'text-right span3 integer-decimal', 'readonly' => TRUE, 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                                <div class="control-group">
                                    <label class='control-label'>
                                        Total Keringanan
                                    </label>
                                    <div class="controls">
                                        <?php echo  $form->textField($modFakturPembelian, 'jmldiscount', array('class' => 'text-right span3 integer-decimal', 'readonly' => true, 'onblur' => 'setPersenDisFaktur(this);hitungTotalFaktur()')); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("Jenis PPh","pajak_id",array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php echo $form->hiddenField($modFakturPembelian, 'pajak_id', array('readonly'=>true,'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                        <?php echo $form->textField($modFakturPembelian,'pajak_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("Syarat Bayar <span class='required'>*</span>","syaratbayar_id",array('class' => 'control-label required')) ?>
                                    <div class="controls">
                                        <?php echo $form->dropDownList($modFakturPembelian,'syaratbayar_id',
                                                CHtml::listData(SyaratbayarM::model()->findAll("syaratbayar_aktif=TRUE ORDER BY syaratbayar_nama"), 'syaratbayar_id', 'syaratbayar_nama'),
                                                array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)",
                                                'empty'=>'-- Pilih --',)); ?>
                                    </div>
                                </div>
                                <?php echo $form->textFieldRow($modFakturPembelian, 'totalhargabruto', array('class' => 'span3 integer-decimal text-right', 'readonly' => TRUE, 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                                <div class="control-group">
                                    <?php echo CHtml::label('Jumlah Uang Muka', '', array('class' => 'control-label inline')) ?>
                                    <div class="controls">
                                        <?php echo $form->textField($modFakturPembelian, 'jmluangmukabeli', array('class' => 'span3 integer-decimal text-right', 'readonly' => TRUE, 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                                    </div>
                                </div>
                        </div>

                        <div class="control-group ">
                                <label class='control-label'>
                                        Total PPN
                                </label>
                                <div class="controls">
                                </div>
                                <div class="controls">
                                        <?php echo $form->textField($modFakturPembelian,'totalpajakppn', array('class'=>'text-right span3 integer-decimal','readonly'=>true, 'onkeyup'=>"return $(this).focusNextInputField(event)", 'onblur' => 'hitungTotalFaktur()')) ?>
                                </div>
                        </div>
                        <div class="control-group ">
                                <?php echo CHtml::label('Total PPh','jmlpph_22', array('class'=>'control-label inline')) ?>
                                <div class="controls">
                                        <?php // echo $form->hiddenField($modFakturPembelian,'persenpph_22',array('readonly'=>false, 'onblur'=>'hitungTotalFaktur();', 'class'=>'inputFormTabel float2 span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                        <?php echo $form->textField($modFakturPembelian,'totalpajakpph',array('readonly'=>true,'class'=>'text-right inputFormTabel integer-decimal span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                </div>
                        </div>

                <?php echo $form->textFieldRow($modFakturPembelian,'totalhargabruto', array('class'=>'span3 integer-decimal text-right','readonly'=>TRUE,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>

                <div class="control-group ">
                        <?php echo CHtml::label('Jumlah Uang Muka','', array('class'=>'control-label inline')) ?>
                        <div class="controls">
                                <?php echo $form->textField($modFakturPembelian,'jmluangmukabeli', array('class'=>'span3 integer-decimal text-right','readonly'=>TRUE,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                        </div>
                </div>
                 <div class="control-group ">
                        <?php echo CHtml::label('Total Harga Netto','', array('class'=>'control-label inline')) ?>
                        <div class="controls">
                                <?php echo $form->textField($modFakturPembelian,'totalhutangusaha', array('class'=>'span3 integer-decimal text-right','readonly'=>TRUE,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                        </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php
            if (!isset($_GET['sukses'])) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'tombolSimpan();', 'onkeypress' => 'tombolSimpan();')
                );
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'disabled' => true)
                );
            }
            if (!isset($_GET['frame'])) {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'return refreshForm(this);'
                    )
                );
            }
            if (!isset($_GET['sukses'])) {
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => 'true'));
                // echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),'javascript:void(0);',array('class'=>'btn btn-info', 'disabled'=>'true'));
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')"));
                // echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')"));
            }
            $content = $this->renderPartial('tips', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<script type="text/javascript">
    function roundToTwo(num) {
        return +(Math.round(num + "e+2") + "e-2");
    }
    //function unformatNumberSemuaAll(){
    //    $(".integer2").each(function(){
    //        $(this).val(parseInt(unformatNumber($(this).val())));
    //    });
    //     $(".float2").each(function(){
    //        $(this).val(parseFloat(unformatNumber($(this).val())));
    //    });
    //    $(".integerfloat").each(function(){
    //        $(this).val(parseFloat(unformatNumber($(this).val())));
    //    });
    //}
    ///**
    // * class integer di format kembali
    // * @returns {undefined}
    // */
    //function formatNumberSemuaAll(){
    //    $(".float2").each(function(){
    //        $(this).val(formatFloat($(this).val()));
    //    });
    //    $(".integerfloat").each(function(){
    //        $(this).val(formatThousandDecimal($(this).val()));
    //    });
    //    $(".integer2").each(function(){
    //        $(this).val(formatNumber($(this).val()));
    //    });
    //}
    function hitungTotal() {
        unformatNumberSemua();
        var totnetto = 0;
        var totdisc = 0;
        var totbruto = 0;
        var totppn = 0;
        var totpph = 0;
        $('#table-obatalkespasien tbody tr').each(function() {
            var jmlterima = parseFloat($(this).find('input[name$="[jmlterima]"]').val());
            var harganetto = parseFloat($(this).find('input[name$="[harganettofaktur]"]').val());
            var persendis = parseFloat($(this).find('input[name$="[persendiscount]"]').val());
            //        var jmldis  = parseFloat($(this).find('input[name$="[jmldiscount]"]').val());
            var persen_ppn = parseInt($(this).find('input[name$="[persenppnfaktur]"]').val());
            var persen_pph = parseFloat($(this).find('input[name$="[persenpphfaktur]"]').val());
            //        var hpp  = parseFloat(unformatNumber($(this).find('input[name$="[hargasatuanper]"]').val()));
            var kemasanbesar = parseInt($(this).find('input[name$="[kemasanbesar]"]').val());
            if ((typeof kemasanbesar === "undefined") || isNaN(kemasanbesar)) {
                kemasanbesar = 0;
            }
            if (kemasanbesar > 0) {
                jmlterima = (jmlterima * kemasanbesar);
            }
            //Rumus Baru
            var JumlahNetto = (harganetto * jmlterima);
            if (JumlahNetto > 0) {
                JumlahNetto = parseFloat(JumlahNetto.toFixed(2));
            }
            //diskon
            var jmlDiskon = (JumlahNetto * (persendis / 100));
            if (jmlDiskon > 0) {
                jmlDiskon = parseFloat(jmlDiskon.toFixed(2));
            }
            // ppn
            var jmlPPn = ((JumlahNetto - jmlDiskon) * (persen_ppn / 100));
            if (jmlPPn > 0) {
                jmlPPn = parseFloat(jmlPPn.toFixed(2));
            }
            //pph
            var jmlPPh = ((JumlahNetto - jmlDiskon) * (persen_pph / 100));
            if (jmlPPh > 0) {
                jmlPPh = parseFloat(jmlPPh.toFixed(2));
            }
            var subtotal = (JumlahNetto - jmlDiskon + jmlPPn - jmlPPh);
            if (subtotal > 0) {
                subtotal = parseFloat(subtotal.toFixed(2));
            }
            totdisc += jmlDiskon;
            totppn += jmlPPn;
            totpph += jmlPPh;
            totbruto += subtotal;
            totnetto += JumlahNetto;
            $(this).find('input[name$="[subtotal]"]').val(subtotal);
            $(this).find('input[name$="[jmldiscount]"]').val(jmlDiskon);
            $(this).find('input[name$="[jmlppn]"]').val(jmlPPn);
            $(this).find('input[name$="[jmlpph]"]').val(jmlPPh);
            $(this).find('input[name$="[hargasatuanper]"]').val(subtotal);
        });
        $('#<?php echo CHtml::activeId($modFakturPembelian, 'jmldiscount'); ?>').val(totdisc);
        $('#<?php echo CHtml::activeId($modFakturPembelian, 'totharganetto'); ?>').val(totnetto);
        $('#<?php echo CHtml::activeId($modFakturPembelian, 'totalpajakppn'); ?>').val(totppn);
        $('#<?php echo CHtml::activeId($modFakturPembelian, 'totalpajakpph'); ?>').val(totpph);
        $('#<?php echo CHtml::activeId($modFakturPembelian, 'totalhargabruto'); ?>').val(totbruto);
        var jmluangmukabeli = parseFloat($('#<?php echo CHtml::activeId($modFakturPembelian, 'jmluangmukabeli'); ?>').val());
        var totalusaha = (totbruto - jmluangmukabeli);
        $('#<?php echo CHtml::activeId($modFakturPembelian, 'totalhutangusaha'); ?>').val(totalusaha);
        formatNumberSemua();
    }

         totdisc += jmlDiskon;
         totppn += jmlPPn;
         totpph += jmlPPh;
         totbruto += subtotal;
         totnetto += JumlahNetto;
        $(this).find('input[name$="[subtotal]"]').val(subtotal);
        $(this).find('input[name$="[jmldiscount]"]').val(jmlDiskon);
        $(this).find('input[name$="[jmlppn]"]').val(jmlPPn);
        $(this).find('input[name$="[jmlpph]"]').val(jmlPPh);
        $(this).find('input[name$="[hargasatuanper]"]').val(subtotal);
    });

    $('#<?php echo CHtml::activeId($modFakturPembelian,'jmldiscount'); ?>').val(totdisc);
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totharganetto'); ?>').val(totnetto);
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').val(totppn);
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').val(totpph);
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totalhargabruto'); ?>').val(totbruto);

    var jmluangmukabeli  = parseFloat($('#<?php echo CHtml::activeId($modFakturPembelian,'jmluangmukabeli'); ?>').val());
    var totalusaha = (totbruto - jmluangmukabeli);

    $('#<?php echo CHtml::activeId($modFakturPembelian,'totalhutangusaha'); ?>').val(totalusaha);
    formatNumberSemua();
}

function setNettoUbah(obj){
    var netto = parseFloat(unformatNumber($(obj).parents("tr").find('input[name$="[harganettofaktur]"]').val()));
    $(obj).parents("tr").find('input[name$="[harganettoubah]"]').val(formatThousandDecimal(netto));
}

function renameInputRowObatAlkes(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find('span').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
            }
        });
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            }
        });
        row++;
    });
    $('#obatalkes_id').val('');
    $('#obatalkes_nama').val('');
    $('#qty_input').val(1);
}

function print(caraPrint)
{
    var fakturpembelian_id = $('#fakturpembelian_id').val();
    window.open('<?php echo $this->createUrl('/keuangan/FakturPembelianKU/print'); ?>&fakturpembelian_id='+fakturpembelian_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

function tombolSimpan(){
    if(requiredCheck($("form"))){
        $(".animation-loading").removeClass("animation-loading");
            var index = 0;
            var pesanharga = "";
            var kecilHpp = 0;
            var cekpph = 0;
            $('#table-obatalkespasien tbody tr').each(function() {
                unformatNumberSemua();
                var hargaLama = parseFloat($(this).find('input[name$="[harganettopermaster]"]').val());
                var hargabaru = parseFloat($(this).find('input[name$="[harganettofaktur]"]').val());
                var namaBahan = $(this).find('input[name$="[namaobatmaster]"]').val();
                var persenpph = $(this).find('input[name$="[persenpph]"]').val();
                if (hargaLama != hargabaru) {
                    kecilHpp += 1;
                    if (index > 0) {
                        pesanharga += ",";
                    }
                    pesanharga += namaBahan + " (" + hargabaru + ")";
                    index++;
                } else {
                    if (kecilHpp > 1) {
                        kecilHpp -= 1;
                    }
                }
                if (persenpph > 0) {
                    cekpph += 1;
                }else{
                    if(cekpph > 1){
                        cekpph -= 1;
                    }
                }
               $(this).find('input[name$="[hppcheck]"]').val(0);
               formatNumberSemua();
            });
            if (cekpph > 0) {
                if ($('#<?php echo CHtml::activeId($modFakturPembelian, 'pajak_id'); ?>').val() === '') {
                    myAlert("Jenis Pajak harus diisi ");
                    return false;
                }
            }
            if (kecilHpp > 0) {
                $.alerts.okButton = "Ya";
                $.alerts.cancelButton = "Tidak";
                myConfirm("Harga Netto '"+pesanharga+"' berbeda dengan yang ada di master. Apakah anda ingin melakukan update harga otomatis?","Perhatian!",function(r) {
                if (r){
                    $('#table-obatalkespasien tbody tr').each(function () {
                        $(this).find('input[name$="[hppcheck]"]').val(1);
                    });
                     $('.integer-decimal, .float2, .integer2').each(function(){
                        $(this).val(unformatNumber($(this).val()));
                    });
                     $('#fakturpembelian-form').submit();
               }else{
                   $('#table-obatalkespasien tbody tr').each(function () {
                        $(this).find('input[name$="[hppcheck]"]').val(0);
                    });
                     $('.integer-decimal, .float2, .integer2').each(function(){
                        $(this).val(unformatNumber($(this).val()));
                    });
                   $('#fakturpembelian-form').submit();
               }
           });
            }else{
               $('#table-obatalkespasien tbody tr').each(function () {
                   $(this).find('input[name$="[hppcheck]"]').val(1);
               });
                $('.integer-decimal, .float2, .integer2').each(function(){
                        $(this).val(unformatNumber($(this).val()));
                    });
               $('#fakturpembelian-form').submit();
            }
        }
        return false;
    }

    function loadJatuhTempo() {
        var tanggalfaktur = $('#<?php echo CHtml::activeId($modFakturPembelian, 'tglfaktur'); ?>').val();
        var supplierid = $('#<?php echo CHtml::activeId($modPenerimaanBarang, 'supplier_id'); ?>').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('loadJatuhTempo'); ?>',
            data: {
                tgl_faktur: tanggalfaktur,
                supplier_id: supplierid
            },
            dataType: "json",
            success: function(data) {
                $('#<?php echo CHtml::activeId($modFakturPembelian, 'tgljatuhtempo'); ?>').val(data.value);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    $(document).ready(function() {
        hitungTotal();
        loadJatuhTempo();
        <?php if (!empty($modUangmuka->uangmukabeli_id)) { ?>
            $('#divuangmukabeli').show();
        <?php } else { ?>
            $('#divuangmukabeli').hide();
        <?php } ?>
    });
}
$(document).ready(function(){
    hitungTotal();
    loadJatuhTempo();

    <?php if(!empty($modUangmuka->uangmukabeli_id)){ ?>
        $('#divuangmukabeli').show();
    <?php }else{ ?>
        $('#divuangmukabeli').hide();
    <?php } ?>
});

</script>
