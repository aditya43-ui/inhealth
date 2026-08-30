<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Pengkajian Skor Resiko Jatuh Morse Fall Scale</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-12">
                <?php echo CHtml::activeHiddenField($model,'skalajatuh_jenis',array('class'=>'', 'value'=>'dewasa_morsefallscale')) ?>
                <div style="font-style: italic; color: red;">Bagian dengan tanda * harus diisi.</div>
                <br />
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group ">
                        <?php echo CHtml::label('Tanggal <span style="font-color:red">*</span>', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                                $this->widget('MyDateTimePicker',array(
                                'model'=>$model,
                                'attribute'=>'tanggal_pengkajian',
                                'mode'=>'date',
                                'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT
                                ),
                                'htmlOptions'=>array('readonly'=>true,'class'=>'span3 required','style'=>'width:150px;'),
                            )); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo CHtml::label('Jam <span style="font-color:red">*</span>', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker',array(
                                'model'=>$model,
                                'attribute'=>'jam_pengkajian',
                                    'mode'=>'time',

                                    'options'=> array(
                                            'showOn' => false,
                                    ),
                                    'htmlOptions'=>array(
                                'readonly'=>TRUE,
                                'class'=>'span2 required',
                                'placeholder'=>'00:00:00',
                                'onkeyup'=>"return $(this).focusNextInputField(event),",
                                    ),
                                ));
                            ?>
                        </div>
                    </div>

                </div>
                <div class="col-sm-6">
                    <div class="control-group ">
                        <?php echo CHtml::label('Nama Petugas <br>Pengkaji <span style="font-color:red">*</span>', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model, 'pegawaipengkaji_id', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array('ruangan_id'=>Yii::app()->user->getState("ruangan_id")),array('order'=>'nama_pegawai')), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span3 required')); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo CHtml::label('Waktu Dilakukan Pengkajian <span style="font-color:red">*</span>', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model,'waktupengkajian_resikojatuh', LookupM::getItems('waktupengkajian_resikojatuh'),array('class'=>'span3 required', 'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>

                </div>
            </div>
            <div>
                    <table class="items table table-bordered table-striped table-condensed" id="tblInputResikodewasa">
                        <thead>
                            <tr>
                                <th>Parameter</th>
                                <th>Kriteria</th>
                                <th>Skor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $modHasilOri =  HasilpengkajianresikojatuhT::model()->findAllByAttributes(array('pengkajianresikojatuh_id'=>$model->pengkajianresikojatuh_id));

                                $hasilPenc = array();

                                if(!empty($modHasilOri)){
                                    foreach($modHasilOri as $dataHasil){
                                    if($dataHasil->parameter == 'Usia'){
                                        $hasilPenc[0]['penilaian'] = $dataHasil->penilaian;
                                        $hasilPenc[0]['skor'] = $dataHasil->skor;
                                    }else if($dataHasil->parameter == 'Defisit Sensoris'){
                                        $hasilPenc[1]['penilaian'] = $dataHasil->penilaian;
                                        $hasilPenc[1]['skor'] = $dataHasil->skor;
                                    }else if($dataHasil->parameter == 'Aktivitas'){
                                        $hasilPenc[2]['penilaian'] = $dataHasil->penilaian;
                                        $hasilPenc[2]['skor'] = $dataHasil->skor;
                                    }else if($dataHasil->parameter == 'Riwayat Jatuh'){
                                        $hasilPenc[3]['penilaian'] = $dataHasil->penilaian;
                                        $hasilPenc[3]['skor'] = $dataHasil->skor;
                                    }else if($dataHasil->parameter == 'Kognisi'){
                                        $hasilPenc[4]['penilaian'] = $dataHasil->penilaian;
                                        $hasilPenc[4]['skor'] = $dataHasil->skor;
                                    }else if($dataHasil->parameter == 'Pengobatan'){
                                        $hasilPenc[5]['penilaian'] = $dataHasil->penilaian;
                                        $hasilPenc[5]['skor'] = $dataHasil->skor;
                                    }else if($dataHasil->parameter == 'Mobilitas'){
                                        $hasilPenc[6]['penilaian'] = $dataHasil->penilaian;
                                        $hasilPenc[6]['skor'] = $dataHasil->skor;
                                    }else if($dataHasil->parameter == 'Pola BAB/BAK'){
                                        $hasilPenc[7]['penilaian'] = $dataHasil->penilaian;
                                        $hasilPenc[7]['skor'] = $dataHasil->skor;
                                    }else if($dataHasil->parameter == 'Komorbiditas'){
                                        $hasilPenc[8]['penilaian'] = $dataHasil->penilaian;
                                        $hasilPenc[8]['skor'] = $dataHasil->skor;
                                    }
                                    }
                                }
                            ?>
                            <tr>
                                <th>Usia</th>
                                <th>
                                    <?php echo $form->hiddenField($modHasil, '[0]parameter', array('value'=>'Usia')); ?>
                                    <?php echo $form->hiddenField($modHasil, '[0]penilaian',array('value'=>(!empty($hasilPenc[0]['penilaian']) ? $hasilPenc[0]['penilaian']: null))); ?>
                                    <select id="resikojatuh_usia_dewasa" name="[resikojatuh_usia_dewasa]" class="span3" onkeypress="return $(this).focusNextInputField(event);" onchange="usia_dewasa(this);">
                                        <?php echo LookupM::getDropManual('resikojatuh_usia_dewasa', (!empty($hasilPenc[0]['penilaian']) ? $hasilPenc[0]['penilaian']: null)) ?>
                                    </select>
                                </th>
                                <th><?php echo $form->textField($modHasil, '[0]skor', array('value'=>(!empty($hasilPenc[0]['skor']) ? $hasilPenc[0]['skor']: 0),'class' => 'span1 integer numberOnly skoringdewasa', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                            </tr>
                            <tr>
                                <th>Defisit Sensoris</th>
                                <th>
                                    <?php echo $form->hiddenField($modHasil, '[1]parameter', array('value'=>'Defisit Sensoris')); ?>
                                    <?php echo $form->hiddenField($modHasil, '[1]penilaian',array('value'=>(!empty($hasilPenc[1]['penilaian']) ? $hasilPenc[1]['penilaian']: null))); ?>
                                    <select id="resikojatuh_defisitsensoris_dewasa" name="[resikojatuh_defisitsensoris_dewasa]" class="span3" onkeypress="return $(this).focusNextInputField(event);" onchange="defisit(this);">
                                        <?php echo LookupM::getDropManual('resikojatuh_defisitsensoris_dewasa',(!empty($hasilPenc[1]['penilaian']) ? $hasilPenc[1]['penilaian']: null)) ?>
                                    </select>
                                </th>
                                <th><?php echo $form->textField($modHasil, '[1]skor', array('value'=>(!empty($hasilPenc[1]['skor']) ? $hasilPenc[1]['skor']: 0),'class' => 'span1 integer numberOnly skoringdewasa', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                            </tr>
                            <tr>
                                <th>Aktivitas</th>
                                <th>
                                    <?php echo $form->hiddenField($modHasil, '[2]parameter', array('value'=>'Aktivitas')); ?>
                                    <?php echo $form->hiddenField($modHasil, '[2]penilaian',array('value'=>(!empty($hasilPenc[2]['penilaian']) ? $hasilPenc[2]['penilaian']: null))); ?>
                                    <select id="resikojatuh_akktivitas_dewasa" name="[resikojatuh_akktivitas_dewasa]" class="span3" onkeypress="return $(this).focusNextInputField(event);" onchange="akktivitas(this);">
                                        <?php echo LookupM::getDropManual('resikojatuh_akktivitas_dewasa',(!empty($hasilPenc[2]['penilaian']) ? $hasilPenc[2]['penilaian']: null)) ?>
                                    </select>
                                </th>
                                <th><?php echo $form->textField($modHasil, '[2]skor', array('value'=>(!empty($hasilPenc[2]['skor']) ? $hasilPenc[2]['skor']: 0),'class' => 'span1 integer numberOnly skoringdewasa', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                            </tr>
                            <tr>
                                <th>Riwayat Jatuh</th>
                                <th>
                                    <?php echo $form->hiddenField($modHasil, '[3]parameter', array('value'=>'Riwayat Jatuh')); ?>
                                    <?php echo $form->hiddenField($modHasil, '[3]penilaian',array('value'=>(!empty($hasilPenc[3]['penilaian']) ? $hasilPenc[3]['penilaian']: null))); ?>
                                    <select id="resikojatuh_riwayatjatuh_dewasa" name="[resikojatuh_riwayatjatuh_dewasa]" class="span3" onkeypress="return $(this).focusNextInputField(event);" onchange="riwayatjatuh(this);">
                                        <?php echo LookupM::getDropManual('resikojatuh_riwayatjatuh_dewasa',(!empty($hasilPenc[3]['penilaian']) ? $hasilPenc[3]['penilaian']: null)) ?>
                                    </select>
                                </th>
                                <th><?php echo $form->textField($modHasil, '[3]skor', array('value'=>(!empty($hasilPenc[3]['skor']) ? $hasilPenc[3]['skor']: 0),'class' => 'span1 integer numberOnly skoringdewasa', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                            </tr>
                            <tr>
                                <th>Kognisi</th>
                                <th>
                                    <?php echo $form->hiddenField($modHasil, '[4]parameter', array('value'=>'Kognisi')); ?>
                                    <?php echo $form->hiddenField($modHasil, '[4]penilaian',array('value'=>(!empty($hasilPenc[4]['penilaian']) ? $hasilPenc[4]['penilaian']: null))); ?>
                                    <select id="resikojatuh_kognisi_dewasa" name="[resikojatuh_kognisi_dewasa]" class="span3" onkeypress="return $(this).focusNextInputField(event);" onchange="kognisi(this);">
                                        <?php echo LookupM::getDropManual('resikojatuh_kognisi_dewasa',(!empty($hasilPenc[4]['penilaian']) ? $hasilPenc[4]['penilaian']: null)) ?>
                                    </select>
                                </th>
                                <th><?php echo $form->textField($modHasil, '[4]skor', array('value'=>(!empty($hasilPenc[4]['skor']) ? $hasilPenc[4]['skor']: 0),'class' => 'span1 integer numberOnly skoringdewasa', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                            </tr>
                            <tr>
                                <th>Pengobatan</th>
                                <th>
                                    <?php echo $form->hiddenField($modHasil, '[5]parameter', array('value'=>'Pengobatan')); ?>
                                    <?php echo $form->hiddenField($modHasil, '[5]penilaian',array('value'=>(!empty($hasilPenc[5]['penilaian']) ? $hasilPenc[5]['penilaian']: null))); ?>
                                    <select id="resikojatuh_pengobatan_dewasa" name="[resikojatuh_pengobatan_dewasa]" class="span3" onkeypress="return $(this).focusNextInputField(event);" onchange="pengobatan(this);">
                                        <?php echo LookupM::getDropManual('resikojatuh_pengobatan_dewasa',(!empty($hasilPenc[5]['penilaian']) ? $hasilPenc[5]['penilaian']: null)) ?>
                                    </select>
                                </th>
                                <th><?php echo $form->textField($modHasil, '[5]skor', array('value'=>(!empty($hasilPenc[5]['skor']) ? $hasilPenc[5]['skor']: 0),'class' => 'span1 integer numberOnly skoringdewasa', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                            </tr>
                            <tr>
                                <th>Mobilitas</th>
                                <th>
                                    <?php echo $form->hiddenField($modHasil, '[6]parameter', array('value'=>'Mobilitas')); ?>
                                    <?php echo $form->hiddenField($modHasil, '[6]penilaian',array('value'=>(!empty($hasilPenc[6]['penilaian']) ? $hasilPenc[6]['penilaian']: null))); ?>
                                    <select id="resikojatuh_mobilitas_dewasa" name="[resikojatuh_mobilitas_dewasa]" class="span3" onkeypress="return $(this).focusNextInputField(event);" onchange="mobilitas(this);">
                                        <?php echo LookupM::getDropManual('resikojatuh_mobilitas_dewasa',(!empty($hasilPenc[6]['penilaian']) ? $hasilPenc[6]['penilaian']: null)) ?>
                                    </select>
                                </th>
                                <th><?php echo $form->textField($modHasil, '[6]skor', array('value'=>(!empty($hasilPenc[6]['skor']) ? $hasilPenc[6]['skor']: 0),'class' => 'span1 integer numberOnly skoringdewasa', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                            </tr>
                            <tr>
                                <th>Pola BAB/BAK</th>
                                <th>
                                    <?php echo $form->hiddenField($modHasil, '[7]parameter', array('value'=>'Pola BAB/BAK')); ?>
                                    <?php echo $form->hiddenField($modHasil, '[7]penilaian',array('value'=>(!empty($hasilPenc[7]['penilaian']) ? $hasilPenc[7]['penilaian']: null))); ?>
                                    <select id="resikojatuh_polaeliminasi_dewasa" name="[resikojatuh_polaeliminasi_dewasa]" class="span3" onkeypress="return $(this).focusNextInputField(event);" onchange="polaeliminasi(this);">
                                        <?php echo LookupM::getDropManual('resikojatuh_polaeliminasi_dewasa',(!empty($hasilPenc[7]['penilaian']) ? $hasilPenc[7]['penilaian']: null)) ?>
                                    </select>
                                </th>
                                <th><?php echo $form->textField($modHasil, '[7]skor', array('value'=>(!empty($hasilPenc[7]['skor']) ? $hasilPenc[7]['skor']: 0),'class' => 'span1 integer numberOnly skoringdewasa', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                            </tr>
                            <tr>
                                <th>Komorbiditas</th>
                                <th>
                                    <?php echo $form->hiddenField($modHasil, '[8]parameter', array('value'=>'Komorbiditas')); ?>
                                    <?php echo $form->hiddenField($modHasil, '[8]penilaian',array('value'=>(!empty($hasilPenc[8]['penilaian']) ? $hasilPenc[8]['penilaian']: null))); ?>
                                    <select id="resikojatuh_komorbiditas_dewasa" name="[resikojatuh_komorbiditas_dewasa]" class="span3" onkeypress="return $(this).focusNextInputField(event);" onchange="komorbiditas(this);">
                                        <?php echo LookupM::getDropManual('resikojatuh_komorbiditas_dewasa',(!empty($hasilPenc[8]['penilaian']) ? $hasilPenc[8]['penilaian']: null)) ?>
                                    </select>
                                </th>
                                <th><?php echo $form->textField($modHasil, '[8]skor', array('value'=>(!empty($hasilPenc[8]['skor']) ? $hasilPenc[8]['skor']: 0),'class' => 'span1 integer numberOnly skoringdewasa', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                            </tr>
                            
                            <tr>
                                <th></th>
                                <th>Total Score</th>
                                <th><?php echo $form->TextField($model, 'totalskor',array('class'=>'span1','readonly'=>true)); ?></th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>Hasil Resiko Jatuh</th>
                                <th><?php echo $form->TextField($model, 'keteranganskor_resikojatuh',array('readonly'=>true)); ?></th>
                            </tr>



                        </tbody>
                    </table>

            </div>
        </div>
    </div>
</div> 