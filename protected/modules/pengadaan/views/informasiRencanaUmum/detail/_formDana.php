<div class="row-fluid">
    <div class="col-md-12">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'ispradpa', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->textField($model, 'ispradpa', array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'value' => ($model->ispradpa == 1) ? 'YA' : 'TIDAK', ));
                ?>
            </div>
        </div>
        
        <?php if($model->ispradpa == TRUE) : ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'nomor_kppuas', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nomor_kppuas', array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <?php endif; ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Sisa Pagu pada DPA', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php 
                $model->dpa_pagu = number_format($model->dpa_pagu,  2, ",", ".");
                echo $form->textField($model, 'dpa_pagu', array('readonly' => true, 'class' => 'span4 integer-decimal', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>

        <div class="control-group" style="overflow-x:scroll;">
            <?php echo $form->labelEx($model, 'Sumber Dana', array('class' => 'control-label')); ?>
            <div class="controls">
                <table class="table table-striped table-bordered table-condensed" id="tabelSumberDana">
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
                        <?php
                            $i = 1;
                            $tr = "";
                            $total = 0;
                            if (count($arrSumberDana)) {
                                foreach ($arrSumberDana as $key => $value) {
                                    $value->pagus = number_format($value->pagu, 2, ",", ".");
                                    $tr .= $this->renderPartial("detail/_rowSumberDana", array('sendiri' => true, 'modSumberDana' => $value, 'form' => $form, 'i'=>$i++), true);
                                    $total+= $value->pagu;
                                }
                                echo $tr;
                            }
                        
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td style="text-align: right" colspan="5">Total</td>
                            <td>
                                <?php 
                                    echo CHtml::textField('totalDana', number_format($total, 2, ",", "."), array('readonly' => true,'class' => 'integer-decimal required','style' => 'width:110px !important')); 
                                ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="penyedia">
            <?php echo $form->textFieldRow($model, 'nomorizin_tahunjamak', array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Izin Tahun Jamak')); ?>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'Jenis Pengadaan', array('class' => 'control-label')); ?>
                <div class="controls">
                    <table class="table table-striped table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Jenis Pengadaan <span class="required">*</span></th>
                                <th>Jumlah Pagu (Rp) <span class="required">*</span></th>
                            </tr>
                        </thead>
                        <tbody id="jenisPengadaan">
                            <?php
                                $tr = "";
                                $total2 = 0;
                                if (count($arrJenis)) {
                                    $i = 1;
                                    foreach ($arrJenis as $key => $value) {
                                        $value->jumlahpagus = number_format($value->jumlahpagu,  2, ",", ".");
                                        $tr .= $this->renderPartial("detail/_rowJenisPengadaan", array('sendiri' => true, 'modJenis' => $value, 'form' => $form, 'i'=>$i++), true);
                                        $total2+= $value->jumlahpagu;
                                    }
                                    echo $tr;
                                }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td style="text-align: right" colspan="2">Total</td>
                                <td>
                                    <?php 
                                    echo CHtml::textField('totalJenisPengadaan', number_format($total2,  2, ",", "."), array('readonly' => true,'class' => 'integer2 required','style' => 'width:160px !important')); 
                                ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Pengadaan Dikecualikan</label>
                <div class="controls">
                    <?php echo CHtml::textField('is_dikecualikan', ($model->isdikecualikan == true) ? 'YA' : 'TIDAK', array('class' => 'span4', 'readonly' => true))?>
                </div>
            </div>
            <?php 
                if ($model->isdikecualikan == false) {
                    echo $form->dropDownListRow($model, 'metodepengadaan_id', CHtml::listData(MetodepengadaanM::model()->findAll('metodepengadaan_aktif IS TRUE ORDER BY metodepengadaan_nama ASC'), 'metodepengadaan_id', 'metodepengadaan_nama'), array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --'));
                }
            ?>
            
        </div>
    </div>
</div>