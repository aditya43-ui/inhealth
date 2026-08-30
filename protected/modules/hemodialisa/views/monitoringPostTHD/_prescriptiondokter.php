<div class="panel-body">
    <div class="row-fluid">
        <div class="span6">
            <div class="control-group">
                <label class="control-label">Prescription Dokter</label>
                <div class="controls">
                    <?= $form->textField($model,'presdokter', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span4', 'readonly'=>true));?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Time</label>
                <div class="controls">
                    <?= $form->textField($model,'durasi_time', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span1', 'readonly'=>true));?> / 
                    <?= $form->textField($model,'time_satuan', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2', 'readonly'=>true));?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Blook Flow</label>
                <div class="controls">
                    <?= $form->textField($model,'blood_flow', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span4', 'readonly'=>true));?> <label>mL/menit</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Dialysate Flow</label>
                <div class="controls">
                    <?= $form->textField($model,'dialysate_flow', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span4', 'readonly'=>true));?> <label>mL/menit</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Dialysate</label>
                <div class="controls">
                    <?= $form->textField($model,'dialysate', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span4', 'readonly'=>true));?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Dialyser</label>
                <div class="controls">
                    <?= $form->textField($model,'dialyser', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span4', 'readonly'=>true));?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Akses Vaskuler</label>
                <div class="controls">
                    <?php
                        if(!empty($model->akses_vaskular)){
                            $str = substr($model->akses_vaskular,0,-1);
                            $str1 = explode(",", $str);
                            foreach ($str1 as $no=>$row){
                                echo CHtml::textField('akses_vaskular', $row, array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span4', 'style'=>'margin-bottom: 10px;', 'readonly'=>true))."<br>";
                            }
                        }else{
                            echo CHtml::textField('akses_vaskular', '', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span4', 'readonly'=>true));
                        }
                    ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Catatan Lain</label>
                <div class="controls">
                    <?= $form->textArea($model,'catatan_lain', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'', 'style'=>'width: 241px; height: 101px;', 'readonly'=>true));?>
                </div>
            </div>
        </div>
        <div class="span6">
            <div class="control-group">
                <label class="control-label">Dialyser Temperature</label>
                <div class="controls">
                    <?= $form->textField($model,'dialyser_temperatur', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span4', 'readonly'=>true));?> <label>&#8451;</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Ultra Filtration Goal</label>
                <div class="controls">
                    <?= $form->textField($model,'uf_goal', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span4', 'readonly'=>true));?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Heparinisasi</label>
                <div class="controls">
                    <?= $form->textField($model,'heparinisasi', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span4', 'readonly'=>true));?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Selisih BB</label>
                <div class="controls">
                    <?= $form->textField($model,'selisih_bb', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span4', 'readonly'=>true));?> <label>Kg</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Infus</label>
                <div class="controls">
                    <?= $form->textField($model,'infus', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span4', 'readonly'=>true));?> <label>mL</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls">
                    <?php echo $form->checkBox($model,'transfusi_darah', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'checkbox-column', 'readonly'=>true))?> <label>Transfusi Darah</label>
                </div>
            </div>
        </div>
    </div>
</div>




