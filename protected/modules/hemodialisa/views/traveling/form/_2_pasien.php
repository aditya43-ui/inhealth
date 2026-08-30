<div class="panel panel-success">    
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label"><u>Nama Pasien</u><br><i>Patient Name</i></label>
                <div class="controls">
                    <?= $form->textField($model, 'nama_pasien', []) ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label"><u>Umur</u><br><i>Age</i></label>
                <div class="controls">
                    <?= $form->textField($model, 'umur_pasien', ['class'=>'numbers-only']) ?>
                </div>
            </div>                     
           
            <div class="control-group">
                <label class="control-label"><u>Diagnosa</u><br><i>Diagnosis</i></label>
                <div class="controls">
                    <?= $form->textField($model, 'diagnosa_nama', []) ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label"><u>Hemodialisa pertama</u><br><i>First Dialysis</i></label>
                <div class="controls">
                    <?php 
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'hd_pertama',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                                'yearRange' => "-60:+0",
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                    ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label"><u>Hemodialisa terakhir</u><br><i>Last Dialysis</i></label>
                <div class="controls">
                    <?php 
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'hd_terakhir',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                                'yearRange' => "-60:+0",
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                    ?>
                </div>
            </div>
        </div>
        
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label"><u>Jenis Kelamin</u><br><i>Gender</i></label>
                <div class="controls">
                    <?= $form->checkBox($model,'jk_lk',['id'=>'jk_lk']) ?> <label for="jk_lk">Pria</label>
                </div>
                <div class="controls">
                    <?= $form->checkBox($model,'jk_pr',['id'=>'jk_pr']) ?> <label for="jk_pr">Wanita</label>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label"><u>Alamat</u><br><i>address</i></label>
                <div class="controls">
                    <?= $form->textArea($model, 'alamat_pasien', ['rows'=>7]) ?>
                </div>
            </div>
        </div>
               
    </div>
</div>