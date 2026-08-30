<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php 
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); 
?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'bahasilpemeriksaan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"> 
            Detail <b> Berita Acara Hasil Pemeriksaan Pekerjaan</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-6">

                <?php echo $form->textFieldRow($model, 'bahasilpemeriksaanpekerjaan_nomor', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'nomor_beritaacara', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Nomor BA')); ?>
                <div class="control-group">
                    <?php echo CHtml::label('Termin <span class="required">*</span>', 'nomor_beritaacara', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'termin_terminjumlah', array('readonly' => true, 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <label> dari</label>
                        <?php echo $form->textField($model, 'termin_termintotal', array('readonly' => true, 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->hiddenField($model, 'terminke', array('readonly' => true, 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->hiddenField($model, 'termin_persen', array('readonly' => true, 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">

                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'bahasilpemeriksaanpekerjaan_tanggal', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'bahasilpemeriksaanpekerjaan_tanggal',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'span4 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                        ));
                        ?>
                        <?php echo $form->error($model, 'bahasilpemeriksaanpekerjaan_tanggal'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'bapemeriksaanpekerjaan_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPeriksaKerja, 'bapemeriksaanpekerjaan_nomor', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'dokumen_pendukung', array('class' => 'control-label')) ?>
                    <div class="controls" style="padding-top:6px">
                        <?php
                        if (!empty($model->dokumen_pendukung)) {
                            echo CHtml::link("$model->dokumen_pendukung", $this->createUrl('Unduh', array('id' => $model->bahasilpemeriksaanpekerjaan_id)), array('title' => 'Unduh dokumen pendukung', 'rel' => 'tooltip', 'style' => 'color:blue;'));
                        }
                        ?> 
                    </div>
                </div>

            </div>
            <div class="clear"></div>
            <hr>
            <div class="col-sm-6">

                <p><h4><b>PIHAK KESATU</b></h4></p>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'pegpihakkesatu_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'pegpihakkesatu_id'); ?>
                        <?php
                        echo $form->textField($model, 'pegpihakkesatu_nama', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true));
                        ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'NIP', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'pegpihakkesatu_nip', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'placeholder' => 'NIP Pihak Kesatu')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'Alamat', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textArea($model, 'pegpihakkesatu_alamat', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'placeholder' => 'Alamat Pihak Kesatu')); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'jabatan_pihakkesatu', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'placeholder' => 'Jabatan Pihak Kesatu')); ?>

            </div>
            <div class="col-sm-6">

                <p><h4><b>PIHAK KEDUA</b></h4></p>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'Penyedia', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::textField('penyedia', isset($modPeriksaKerja->supplier->supplier_nama) ? $modPeriksaKerja->supplier->supplier_nama : "", array('class' => 'span4', 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'Direktur', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::textField('direktur', isset($modPeriksaKerja->supplier->direktursupplier) ? $modPeriksaKerja->supplier->direktursupplier : "", array('class' => 'span4', 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'Alamat', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::textField('alamat', isset($modPeriksaKerja->supplier->supplier_alamat) ? $modPeriksaKerja->supplier->supplier_alamat : "", array('class' => 'span4', 'readonly' => true)); ?>
                    </div>
                    <?php echo $form->hiddenField($model, 'total_pembayaran', array('class' => 'span3 integer-decimal', 'readonly' => true)); ?>
                    <?php echo $form->hiddenField($model, 'total_dibulatkan', array('class' => 'span3', 'readonly' => true)); ?>
                    <?php echo $form->hiddenField($model, 'total_harga', array('class' => 'span3 integer-decimal', 'readonly' => true)); ?>
                    <?php echo $form->hiddenField($model, 'jumlah_pajak', array('class' => 'span3 integer-decimal', 'readonly' => true)); ?>
                    <?php echo $form->hiddenField($model, 'jumlah_harga', array('class' => 'span3 integer-decimal', 'readonly' => true)); ?>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="col-sm-12">
                <table class="table table-striped table-bordered tabelLampiran">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Item yang Diperiksa</th>
                            <th>Volume dan Spesifikasi</th>
                            <th>Hasil Pemeriksaan</th>
                            <th>Satuan </th>
                            <th>Volume</th>
                            <th>Harga Satuan</th>
                            <th>Jumlah Harga </th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody  id="tabel_lampiran">
                        <?php
                        if (count($modelDetail) > 0) {

                            foreach ($modelDetail as $key => $value) {
                                $hasilPemeriksaan = isset($value->hasil_pemeriksaan) ? "<i class=\"fa fa-check-square-o\"></i>" : "<i class=\"fa fa-square-o\"></i>";
                                echo "
                        <tr>
                            <td>" . ($key + 1) . "</td>
                            <td>" . $value->nama_barang . "</td>
                            <td>" . $value->jumlah_barang . " " . $value->satuan_barang . "</td>
                            <td>" . $hasilPemeriksaan . "</td>
                            <td>" . $value->satuan_barang . "</td>
                            <td>" . $value->jumlah_barang . "</td>
                            <td style='text-align: right;'>" . number_format((float)$value->harga_satuan,2,",",".") . "</td>
                            <td style='text-align: right;'>" . number_format((float)$value->jumlah_harga,2,",",".") . "</td>
                            <td>" . $value->keterangan_pemeriksaan . "</td>
                        </tr>
                        ";
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7" style="text-align: right"> <b> Jumlah Harga </b></td>
                            <td style="text-align: right;"> Rp. <?php echo number_format((float)$modSPK->jumlah_harga,2,",",".") ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="7" style="text-align: right"> <b> Jumlah Pajak </b></td>
                            <td style="text-align: right;"> Rp. <?php echo number_format((float)$modSPK->jumlah_pajak,2,",",".") ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="7" style="text-align: right"> <b> Total Harga </b></td>
                            <?php
                            $harga = ($modSPK->total_harga != 0) ? $modSPK->total_harga : $modSPK->jumlah_harga + $modSPK->jumlah_pajak;
                            ?>
                            <td style="text-align:right;"> Rp. <?php echo number_format((float)$harga,2,",",".") ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="7" style="text-align: right"> <b> Dibulatkan </b></td>
                            <td style="text-align:right;"> Rp. <?php echo number_format((float)$modSPK->total_pembulatan,2,",",".") ?></td>
                            <td> </td>
                        </tr>
                        <?php if (!empty($_GET['bahasilpemeriksaanpekerjaan_id']) && $model->termin_persen != 100) { ?>
                            <tr>
                                <td colspan="7" style="text-align: right; font-weight: bold"> Termin <?php echo $model->terminke . " (" . $model->termin_persen . "%)" ?></td>
                                <td style="text-align: right;;"> Rp. <?php echo number_format((float)$model->total_pembayaran,2,",",".") ?></td>
                                <td> </td>
                            </tr>
                        <?php } ?>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<script>
    $(document).ready(function(){
        $('.integer-decimal').each(function(){
           $(this).val(formatThousandDecimal(parseFloat($(this).val())));
       }); 
    });
    </script>