<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Pengkajian Skor Resiko Jatuh Humpty Dumpty</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-12">
                <?php echo CHtml::activeHiddenField($model,'skalajatuh_jenis',array('class'=>'', 'value'=>'anak_humptydumpty')) ?>
                <div style="font-style: italic; color: red;">Bagian dengan tanda * harus diisi.</div>
                <br />
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group ">
                        <?php echo CHtml::label('Tanggal <span style="color:red">*</span>', '', array('class' => 'control-label')) ?>
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
                        <?php echo CHtml::label('Jam <span style="color:red">*</span>', '', array('class' => 'control-label')) ?>
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
                        <?php echo CHtml::label('Nama Petugas <br>Pengkaji <span style="color:red">*</span>', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model, 'pegawaipengkaji_id', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array('ruangan_id'=>Yii::app()->user->getState("ruangan_id")),array('order'=>'nama_pegawai')), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span3 required')); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo CHtml::label('Waktu Dilakukan Pengkajian <span style="color:red"">*</span>', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model,'waktupengkajian_resikojatuh', LookupM::getItems('waktupengkajian_resikojatuh'),array('class'=>'span3 required', 'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>

                </div>
            </div>
            <div>
                    <table class="items table table-bordered table-striped table-condensed" id="tblInputResikoAnak">
                        <thead>
                            <tr>
                                <th>Parameter</th>
                                <th>Kriteria</th>
                                <th>Skor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Usia</th>
                                <th>
                                    <?php echo $form->hiddenField($modHasil, '[0]parameter', array('value'=>'Usia')); ?>
                                    <?php echo $form->hiddenField($modHasil, '[0]penilaian'); ?>
                                    <select id="resikojatuh_usia_anak_kriteria" name="[resikojatuh_usia_anak_kriteria]" class="span3" onkeypress="return $(this).focusNextInputField(event);" onchange="usia_anak(this);">
                                        <?php echo LookupM::getDropManual('resikojatuh_usia_anak',$modHasil->resikojatuh_usia_anak) ?>
                                    </select>
                                </th>
                                <th><?php echo $form->textField($modHasil, '[0]skor', array('class' => 'span1 integer numberOnly skoringanak', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <th>
                                    <?php echo $form->hiddenField($modHasil, '[1]parameter', array('value'=>'Jenis Kelamin')); ?>
                                    <?php echo $form->hiddenField($modHasil, '[1]penilaian'); ?>
                                    <select id="jeniskelamin_skrining_kriteria" name="[jeniskelamin_skrining_kriteria]" class="span3" onkeypress="return $(this).focusNextInputField(event);" onchange="jeniskelamin_skrining_anak(this);">
                                        <?php echo LookupM::getDropManual('jeniskelamin_skrining',$modHasil->jeniskelamin_skrining_kriteria) ?>
                                    </select>
                                </th>
                                <th><?php echo $form->textField($modHasil, '[1]skor', array('class' => 'span1 integer numberOnly skoringanak', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                            </tr>
                            <tr>
                                <th>Diagnose</th>
                                <th>
                                    <?php echo $form->hiddenField($modHasil, '[2]parameter', array('value'=>'Diagnose')); ?>
                                    <?php echo $form->hiddenField($modHasil, '[2]penilaian'); ?>
                                    <select id="resikojatuh_diagnose_anak_kriteria" name="[resikojatuh_diagnose_anak_kriteria]" class="span3" onkeypress="return $(this).focusNextInputField(event);" onchange="diagnose_anak(this);">
                                        <?php echo LookupM::getDropManual('resikojatuh_diagnose_anak',$modHasil->resikojatuh_diagnose_anak_kriteria) ?>
                                    </select>
                                </th>
                                <th><?php echo $form->textField($modHasil, '[2]skor', array('class' => 'span1 integer numberOnly skoringanak', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                            </tr>
                            <tr>
                                <th>Gangguan Kognitif</th>
                                <th>
                                    <?php echo $form->hiddenField($modHasil, '[3]parameter', array('value'=>'Gangguan Kognitif')); ?>
                                    <?php echo $form->hiddenField($modHasil, '[3]penilaian'); ?>
                                    <select id="resikojatuh_gangguan_kognitif_anak_kriteria" name="[resikojatuh_gangguan_kognitif_anak_kriteria]" class="span3" onkeypress="return $(this).focusNextInputField(event);" onchange="kognitif_anak(this);">
                                        <?php echo LookupM::getDropManual('resikojatuh_gangguan_kognitif_anak',$modHasil->resikojatuh_gangguan_kognitif_anak_kriteria) ?>
                                    </select>
                                </th>
                                <th><?php echo $form->textField($modHasil, '[3]skor', array('class' => 'span1 integer numberOnly skoringanak', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                            </tr>
                            <tr>
                                <th>Faktor Lingkungan</th>
                                <th>
                                    <?php echo $form->hiddenField($modHasil, '[4]parameter', array('value'=>'Faktor Lingkungan')); ?>
                                    <?php echo $form->hiddenField($modHasil, '[4]penilaian'); ?>
                                    <select id="resikojatuh_faktor_lingkungan_anak_kriteria" name="[resikojatuh_faktor_lingkungan_anak_kriteria]" class="span3" onkeypress="return $(this).focusNextInputField(event);" onchange="faktor_lingkungan_anak(this);">
                                        <?php echo LookupM::getDropManual('resikojatuh_faktor_lingkungan_anak',$modHasil->resikojatuh_faktor_lingkungan_anak_kriteria) ?>
                                    </select>
                                    
                                </th>
                                <th><?php echo $form->textField($modHasil, '[4]skor', array('class' => 'span1 integer numberOnly skoringanak', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                            </tr>
                            <tr>
                                <th>Respon Terhadap: Pembedahan, sedasi, anastesi</th>
                                <th>
                                    <?php echo $form->hiddenField($modHasil, '[5]parameter', array('value'=>'Respon Terhadap: Pembedahan, sedasi, anastesi')); ?>
                                    <?php echo $form->hiddenField($modHasil, '[5]penilaian'); ?>
                                    <select id="resikojatuh_responterhadap_pembedahan_anak_kriteria" name="[resikojatuh_responterhadap_pembedahan_anak_kriteria]" class="span3" onkeypress="return $(this).focusNextInputField(event);" onchange="respon_terhadap_anak(this);">
                                        <?php echo LookupM::getDropManual('resikojatuh_responterhadap_pembedahan_anak',$modHasil->resikojatuh_responterhadap_pembedahan_anak_kriteria) ?>
                                    </select>
                                    
                                </th>
                                <th><?php echo $form->textField($modHasil, '[5]skor', array('class' => 'span1 integer numberOnly skoringanak', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
                            </tr>
                            <tr>
                                <th>Penggunaan Medikamentosa</th>
                                <th>
                                    <?php echo $form->hiddenField($modHasil, '[6]parameter', array('value'=>'Penggunaan Medikamentosa')); ?>
                                    <?php echo $form->hiddenField($modHasil, '[6]penilaian'); ?>
                                    <select id="resikojatuh_pembedahan_medikamentosa_anak_kriteria" name="[resikojatuh_pembedahan_medikamentosa_anak_kriteria]" class="span3" onkeypress="return $(this).focusNextInputField(event);" onchange="pembedahan_medikamentosa_anak(this);">
                                        <?php echo LookupM::getDropManual('resikojatuh_pembedahan_medikamentosa_anak',$modHasil->resikojatuh_pembedahan_medikamentosa_anak_kriteria) ?>
                                    </select>
                                    
                                </th>
                                <th><?php echo $form->textField($modHasil, '[6]skor', array('class' => 'span1 integer numberOnly skoringanak', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)) . ' '; ?> </th>
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