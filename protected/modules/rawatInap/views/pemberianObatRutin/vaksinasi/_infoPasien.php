<!-- <div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Informasi Data Pasien</div>
    </div> -->
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-6">
                <div class="control-group">
                    <label class="control-label">Tanggal Pemberian</label>
                    <div class="controls">
                        <?php
                            $this->widget('MyDateTimePicker',array(
                                'model'=>$model,
                                'attribute'=>'tanggal_pemberian',
                                'mode'=>'date',
                                'options'=> array(
                                    'dateFormat'=>Params::DATE_FORMATV3,
                                    // 'format' => date('Y-m-d')
                                ),
                                'htmlOptions'=>array('readonly'=>true,
                                        'onkeypress'=>"return $(this).focusNextInputField(event)",
                                        'class'=>'dtPicker3',
                                ),
                            ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Waktu Pemberian</label>
                    <div class="controls">
                        <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'jam_pemberian',
                                'mode' => 'time',
                                'options' => array(
                                    'dateFormat' => Params::TIME_FORMAT,
                                    // 'format' => date('H:i:s')
                                ),
                                'htmlOptions' => array('readonly' => true, 
                                    'onclick' => "return $(this).focusNextInputField(event)",
                                    'class' => '',
                                ),
                            ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Petugas Pemberian</label>
                    <div class="controls">
                        <?php
                            $peg = PegawaiM::model()->findByPk(array('pegawai_id' => $model->pemberian_peg));
                            echo $form->textField($peg, 'nama_pegawai', array('readonly'=>true, 'class'=>''));
                            ?>
                        <?php 
                            echo $form->hiddenField($model, 'initial', array('readonly'=>true, 'class'=>'')); 
                            echo $form->hiddenField($model, 'pemberian_peg', array('readonly'=>true, 'class'=>''));
                        ?>
                        
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Status</label>
                    <div class="controls">
                        <?php 
                        // echo $form->textField($model, 'tanda', array('readonly'=>false, 'class'=>''));
                        echo $form->dropDownList($model, 'tanda', LookupM::getItems('statuspemberianobat'), array('class' => '', 'empty' => '-- Pilih --')); 
                        ?>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
<!-- </div> -->