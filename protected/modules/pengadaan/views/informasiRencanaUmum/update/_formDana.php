<div class="row-fluid">
    <div class="col-md-12">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'ispradpa', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php 
                if($model->ispradpa == 1){
                    echo $form->checkBox($model,'ispradpa',array('value'=>1,'uncheckValue'=>0, 'onclick'=>'cekDipaDpa(this);'));
                }else{
                    echo $form->checkBox($model,'ispradpa',array('value'=>0,'uncheckValue'=>1, 'onclick'=>'cekDipaDpa(this);'));
                }
                ?>
            </div>
        </div>
        <div class="control-group kppuas">
            <?php echo $form->labelEx($model, 'nomor_kppuas', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nomor_kppuas', array('readonly' => false, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <span id="totalnya">
        <div class="control-group">
            <?php echo $form->labelEx($model,'Sisa Pagu pada DPA',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php
                    $model->dpa_pagu = number_format((float)$model->dpa_pagu,2,",",".");
                    echo $form->textField($model,'dpa_pagu',array('readonly'=>true,'class'=>'span4 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'placeholder'=>'Pagu pada DPA')); 
                    echo $form->hiddenField($model,'dpa_pagu_temp',array('readonly'=>true,'class'=>'span4 integer-decimal', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'placeholder'=>'Pagu pada DPA')); ?>
            </div>
        </div>
        </span>
        <div class="control-group" style="overflow-x: scroll;">
            <?php echo $form->labelEx($model, 'Sumber Dana', array('class' => 'control-label')); ?>
            <div class="controls" >
                <table class="table table-striped table-bordered table-condensed" id="tabel-sumberdana">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Sumber Dana <span class="required">*</span></th>
                            <th>Asal Dana</th>
                            <th>MAK <span class="required">*</span></th>
                            <th>Komponen/Kegiatan</th>
                            <th>Pagu (Rp) <span class="required">*</span></th>
                        </tr>
                    </thead>
                    <tbody id="sumberDana">

                    </tbody>
                    <tfoot>
                        <tr>
                            <td style="text-align: right" colspan="5">Total</td>
                            <td>
                                <?= CHtml::textField('totalDana', 0, array('class'=>'span2 integer-decimal', 'style'=>"width: 110px;text-align:right",'readonly'=>true)); ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <table class="hide" id="tabel-hapussumberdana">
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="penyedia">
            <?php echo $form->textFieldRow($model, 'nomorizin_tahunjamak', array('readonly' => false, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Izin Tahun Jamak')); ?>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'Jenis Pengadaan', array('class' => 'control-label')); ?>
                <div class="controls">
                    <table class="table table-striped table-bordered table-condensed" id="tabelJenis">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Jenis Pengadaan <span class="required">*</span></th>
                                <th>Jumlah Pagu (Rp) <span class="required">*</span></th>
                            </tr>
                        </thead>
                        <tbody id="jenisPengadaan">

                        </tbody>
                        <tfoot>
                            <tr>
                                <td style="text-align: right" colspan="2">Total</td>
                                <td>
                                    <?= CHtml::textField('totalJenisPengadaan', 0, array('class'=>'span2 integer-decimal', 'style'=>"width: 160px;text-align:right",'readonly'=>true)); ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <table id="form-hapusjenispengadaan" class="hide">
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
           
            <div class="control-group" >
                <label class="control-label">Pengadaan Dikecualikan</label>
                <div class="controls">
                    <?php echo $form->radioButtonList($model, 'isdikecualikan', array('1' => "YA", '0' => 'TIDAK'), array('class' => 'span1', 'value' => '', 'inline' => true, 'onkeypress' => "return $(this).focusNextInputField(event)", 'onchange' => 'cekMetode(this);')) ?>
                </div>
            </div>
            
            <?php                    
                $display = "block;";
                $req = 'required';
                if ($model->isdikecualikan === '1'){
                    $display = "none;";
                    $req = '';
                }
            ?>
            <div class="control-group" style="display:<?php echo $display; ?>">
                <label class="control-label">Rencana Metode Pengadaan</label>
                <div class="controls">
                    <?php
                        echo $form->hiddenField($model, 'metodepengadaan_id_awal');
                        echo $form->dropDownList($model, 'metodepengadaan_id', CHtml::listData(MetodepengadaanM::model()->findAll('metodepengadaan_aktif IS TRUE ORDER BY metodepengadaan_nama ASC'), 'metodepengadaan_id', 'metodepengadaan_nama'), array('class' => 'span4 '.$req, 'onchange' => 'setDokumen(this)', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --'));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>