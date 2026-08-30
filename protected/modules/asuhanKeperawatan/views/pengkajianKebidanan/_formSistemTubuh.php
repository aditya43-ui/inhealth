<div class="row">
    <div class="col-sm-4">
        <div class="row">
            <fieldset class="box">
                <legend class="rim">Pernapasan</legend>
                <div class="control-group">
                    <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_bunyinafas', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                    <div class="controls">
                        <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_bunyinafas', array('Ronchi' => 'Ronchi', 'Wheezing' => 'Wheezing', 'Vesikuler' => 'Vesikuler')); ?>
                        <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_bunyinafas', array('value' => 'Ronchi')); 
                                ?> Ronchi
						<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_bunyinafas', array('value' => 'Wheezing')); 
                        ?> Wheezing
						<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_bunyinafas', array('value' => 'Vesikuler')); 
                        ?> Vesikuler-->
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_jalannafas', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                    <div class="controls">
                        <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_jalannafas', array('Bersih' => 'Bersih', 'Sumbatan' => 'Sumbatan')); ?>
                        <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_jalannafas', array('value' => 'Bersih')); 
                                ?> Bersih
						<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_jalannafas', array('value' => 'Sumbatan')); 
                        ?> Sumbatan-->
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_sesaknafas', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                    <div class="controls">
                        <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_sesaknafas', array('Ya' => 'Ya', 'Tidak' => 'Tidak')); ?>
                        <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_sesaknafas', array('value' => 'Ya')); 
                                ?> Ya <br>
						<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_sesaknafas', array('value' => 'Tidak')); 
                        ?> Tidak-->
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_sesaknafasdengan', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                    <div class="controls">
                        <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_sesaknafasdengan', array('Aktifitas' => 'Aktifitas', 'Tanpa Aktifitas' => 'Tanpa Aktifitas')); ?>
                        <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_sesaknafasdengan', array('value' => 'Aktifitas')); 
                                ?> Aktifitas <br>
						<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_sesaknafasdengan', array('value' => 'Tanpa Aktifitas')); 
                        ?> Tanpa Aktifitas-->
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_alatbantu', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                    <div class="controls">
                        <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_alatbantu', array('Ya' => 'Ya', 'Tidak' => 'Tidak')); ?>
                        <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_alatbantu', array('value' => 'Ya')); 
                                ?> Ya
						<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_alatbantu', array('value' => 'Tidak')); 
                        ?> Tidak-->
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_irama', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                    <div class="controls">
                        <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_irama', array('Teratur' => 'Teratur', 'Tidak Teratur' => 'Tidak Teratur')); ?>
                        <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_irama', array('value' => 'Teratur')); 
                                ?> Teratur
						<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_irama', array('value' => 'Tidak Teratur')); 
                        ?> Tidak Teratur-->
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_kedalaman', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                    <div class="controls">
                        <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_kedalaman', array('Dangkal' => 'Dangkal', 'Dalam' => 'Dalam')); ?>
                        <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_kedalaman', array('value' => 'Dangkal')); 
                                ?> Dangkal
						<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_kedalaman', array('value' => 'Dalam')); 
                        ?> Dalam-->
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_perdarahan', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                    <div class="controls">
                        <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_perdarahan', array('Ya' => 'Ya', 'Tidak' => 'Tidak')); ?>
                        <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_perdarahan', array('value' => 'Ya')); 
                                ?> Ya
						<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_perdarahan', array('value' => 'Tidak')); 
                        ?> Tidak-->
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPengkajian, 'pengkajianaskep_kelnafas', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modPengkajian, 'pengkajianaskep_kelnafas', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="row">
            <fieldset class="box">
                <legend class="rim">Muskuloskeletal</legend>
                <div class="control-group">
                    <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_ototatas', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                    <div class="controls">
                        <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_ototatas', array('Ya' => 'Ya', 'Tidak' => 'Tidak')); ?>
                        <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_ototatas', array('value' => 'Ya')); 
                                ?> Ya
						<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_ototatas', array('value' => 'Tidak')); 
                        ?> Tidak-->
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_ototbawah', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                    <div class="controls">
                        <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_ototbawah', array('Ya' => 'Ya', 'Tidak' => 'Tidak')); ?>
                        <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_ototbawah', array('value' => 'Ya')); 
                                ?> Ya
						<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_ototbawah', array('value' => 'Tidak')); 
                        ?> Tidak-->
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_sakitsendi', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                    <div class="controls">
                        <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_sakitsendi', array('Ya' => 'Ya', 'Tidak' => 'Tidak')); ?>
                        <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_sakitsendi', array('value' => 'Ya')); 
                                ?> Ya
						<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_sakitsendi', array('value' => 'Tidak')); 
                        ?> Tidak-->
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPengkajian, 'pengkajianaskep_kelmuskulos', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modPengkajian, 'pengkajianaskep_kelmuskulos', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="row">
            <fieldset class="box">
                <legend class="rim">Perkemihan</legend>
                <div class="control-group">
                    <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_bak', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                    <div class="controls">
                        <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_bak', array('Terkontrol' => 'Terkontrol', 'Tidak Terkontrol' => 'Tidak Terkontrol')); ?>
                        <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_bak', array('value' => 'Terkontrol')); 
                                ?> Terkontrol
						<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_bak', array('value' => 'Tidak Terkontrol')); 
                        ?> Tidak Terkontrol-->
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_warna', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                    <div class="controls">
                        <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_warna', array('Kuning Jernih' => 'Kuning Jernih', 'Kuning Kental/Coklat' => 'Kuning Kental/Coklat', 'Merah' => 'Merah')); ?>
                        <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_warna', array('value' => 'Kuning Jernih')); 
                                ?> Kuning Jernih <br>
						<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_warna', array('value' => 'Kuning Kental/Coklat')); 
                        ?> Kuning Kental/Coklat <br>
						<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_warna', array('value' => 'Merah')); 
                        ?> Merah-->
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_sakitbak', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                    <div class="controls">
                        <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_sakitbak', array('Ya' => 'Ya', 'Tidak' => 'Tidak')); ?>
                        <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_sakitbak', array('value' => 'Ya')); 
                                ?> Ya
						<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_sakitbak', array('value' => 'Tidak')); 
                        ?> Tidak-->
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_kandkemih', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                    <div class="controls">
                        <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_kandkemih', array('Ya' => 'Ya', 'Tidak' => 'Tidak')); ?>
                        <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_kandkemih', array('value' => 'Ya')); 
                                ?> Ya
						<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_kandkemih', array('value' => 'Tidak')); 
                        ?> Tidak-->
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_sakitpinggang', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                    <div class="controls">
                        <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_sakitpinggang', array('Ya' => 'Ya', 'Tidak' => 'Tidak')); ?>
                        <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_sakitpinggang', array('value' => 'Ya')); 
                                ?> Ya
						<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_sakitpinggang', array('value' => 'Tidak')); 
                        ?> Tidak-->
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPengkajian, 'pengkajianaskep_kelkemih', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modPengkajian, 'pengkajianaskep_kelkemih', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
    <div class="span8">
        <div class="row">
            <div class="col-sm-6">
                <fieldset class="box">
                    <legend class="rim">Persarafan</legend>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_refbisep', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                        <div class="controls">
                            <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_refbisep', array('Positif' => 'Positif', 'Negatif' => 'Negatif')); ?>
                            <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_refbisep', array('value' => 'Positif')); 
                                    ?> Positif
							<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_refbisep', array('value' => 'Negatif')); 
                            ?> Negatif-->
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_reftrisep', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                        <div class="controls">
                            <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_reftrisep', array('Positif' => 'Positif', 'Negatif' => 'Negatif')); ?>
                            <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_reftrisep', array('value' => 'Positif')); 
                                    ?> Positif
							<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_reftrisep', array('value' => 'Negatif')); 
                            ?> Negatif-->
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_refpatela', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                        <div class="controls">
                            <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_refpatela', array('Positif' => 'Positif', 'Negatif' => 'Negatif')); ?>
                            <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_refpatela', array('value' => 'Positif')); 
                                    ?> Positif
							<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_refpatela', array('value' => 'Negatif')); 
                            ?> Negatif-->
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_refbabinski', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                        <div class="controls">
                            <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_refbabinski', array('Positif' => 'Positif', 'Negatif' => 'Negatif')); ?>
                            <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_refbabinski', array('value' => 'Positif')); 
                                    ?> Positif
							<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_refbabinski', array('value' => 'Negatif')); 
                            ?> Negatif-->
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_refprimitif', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                        <div class="controls">
                            <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_refprimitif', array('Positif' => 'Positif', 'Negatif' => 'Negatif')); ?>
                            <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_refprimitif', array('value' => 'Positif')); 
                                    ?> Positif
							<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_refprimitif', array('value' => 'Negatif')); 
                            ?> Negatif-->
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::activeLabel($modPengkajian, 'pengkajianaskep_kelsaraf', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textArea($modPengkajian, 'pengkajianaskep_kelsaraf', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-sm-6">
                <fieldset class="box">
                    <legend class="rim">Kardiovaskuler</legend>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_nadiperifer', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                        <div class="controls">
                            <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_nadiperifer', array('Baik' => 'Baik', 'Lemah' => 'Lemah', 'Tak Teraba' => 'Tak Teraba')); ?>
                            <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_nadiperifer', array('value' => 'Baik')); 
                                    ?> Baik
							<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_nadiperifer', array('value' => 'Lemah')); 
                            ?> Lemah
							<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_nadiperifer', array('value' => 'Tak Teraba')); 
                            ?> Tak Teraba-->
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_capilary', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                        <div class="controls">
                            <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_capilary', array('< 3 Detik' => '< 3 Detik', '> 3 Detik' => '> 3 Detik')); ?>
                            <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_capilary', array('value' => '< 3 Detik')); 
                                    ?> < 3 Detik
							<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_capilary', array('value' => '> 3 Detik')); 
                            ?> > 3 Detik-->
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_bunyijantung', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                        <div class="controls">
                            <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_bunyijantung', array('Normal' => 'Normal', 'Murmur' => 'Murmur', 'Gallops' => 'Gallops')); ?>
                            <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_bunyijantung', array('value' => 'Normal')); 
                                    ?> Normal
							<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_bunyijantung', array('value' => 'Murmur')); 
                            ?> Murmur
							<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_bunyijantung', array('value' => 'Gallops')); 
                            ?> Gallops-->
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_iramakardio', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                        <div class="controls">
                            <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_iramakardio', array('Teratur' => 'Teratur', 'Tidak Teratur' => 'Tidak Teratur')); ?>
                            <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_iramakardio', array('value' => 'Teratur')); 
                                    ?> Teratur
							<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_iramakardio', array('value' => 'Tidak Teratur')); 
                            ?> Tidak Teratur-->
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::activeLabel($modPengkajian, 'pengkajianaskep_kelkardio', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textArea($modPengkajian, 'pengkajianaskep_kelkardio', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <fieldset class="box">
                    <legend class="rim">Gastrointestinal</legend>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_perusus', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                        <div class="controls">
                            <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_perusus', array('Ada' => 'Ada', 'Tidak' => 'Tidak')); ?>
                            <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_perusus', array('value' => 'Ada')); 
                                    ?> Ada
							<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_perusus', array('value' => 'Tidak')); 
                            ?> Tidak-->
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_distensi', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                        <div class="controls">
                            <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_distensi', array('Ya' => 'Ya', 'Tidak' => 'Tidak')); ?>
                            <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_distensi', array('value' => 'Ya')); 
                                    ?> Ya
							<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_distensi', array('value' => 'Tidak')); 
                            ?> Tidak-->
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_nyeritekan', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                        <div class="controls">
                            <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_nyeritekan', array('Ya' => 'Ya', 'Tidak' => 'Tidak')); ?>
                            <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_nyeritekan', array('value' => 'Ya')); 
                                    ?> Ya
							<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_nyeritekan', array('value' => 'Tidak')); 
                            ?> Tidak-->
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_nyerilepas', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                        <div class="controls">
                            <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_nyerilepas', array('Ya' => 'Ya', 'Tidak' => 'Tidak')); ?>
                            <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_nyerilepas', array('value' => 'Ya')); 
                                    ?> Ya
							<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_nyerilepas', array('value' => 'Tidak')); 
                            ?> Tidak-->
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_bibir', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                        <div class="controls">
                            <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_bibir', array('Normal' => 'Normal', 'Pecah-pecah' => 'Pecah-pecah', 'Stomatitis' => 'Stomatitis')); ?>
                            <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_bibir', array('value' => 'Normal')); 
                                    ?> Normal
							<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_bibir', array('value' => 'Pecah-pecah')); 
                            ?> Pecah-pecah <br>
							<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_bibir', array('value' => 'Stomatitis')); 
                            ?> Stomatitis-->
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::activeLabel($modPengkajian, 'pengkajianaskep_kelgastro', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textArea($modPengkajian, 'pengkajianaskep_kelgastro', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-sm-6">
                <fieldset class="box">
                    <legend class="rim">Integumen</legend>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_turgorkulit', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                        <div class="controls">
                            <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_turgorkulit', array('Baik' => 'Baik', 'Kurang' => 'Kurang', 'Jelek' => 'Jelek')); ?>
                            <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_turgorkulit', array('value' => 'Baik')); 
                                    ?> Baik
							<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_turgorkulit', array('value' => 'Kurang')); 
                            ?> Kurang
							<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_turgorkulit', array('value' => 'Jelek')); 
                            ?> Jelek-->
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_keadaankulit', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                        <div class="controls">
                            <!--<div class="row">-->
                            <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_keadaankulit', array('Baik' => 'Baik', 'Luka/Lesi' => 'Luka/Lesi', 'Bercak-bercak' => 'Bercak-bercak', 'Merah' => 'Merah', 'Pteki' => 'Pteki', 'Gatal-gatal' => 'Gatal-gatal', 'Dekubitus' => 'Dekubitus', 'Memar' => 'Memar', 'Insisi Operasi' => 'Insisi Operasi')); ?>
                            <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_keadaankulit', array('value' => 'Baik')); 
                                    ?> Baik
								<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_keadaankulit', array('value' => 'Luka/Lesi')); 
                                ?> Luka/Lesi-->
                            <!--</div>-->
                            <!--							<div class="row">
								<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_keadaankulit', array('value' => 'Bercak-bercak')); 
                                ?> Bercak-bercak
								<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_keadaankulit', array('value' => 'Merah')); 
                                ?> Merah
							</div>
							<div class="row">
								<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_keadaankulit', array('value' => 'Pteki')); 
                                ?> Pteki
								<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_keadaankulit', array('value' => 'Gatal-gatal')); 
                                ?> Gatal-gatal
							</div>
							<div class="row">
								<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_keadaankulit', array('value' => 'Dekubitus')); 
                                ?> Dekubitus
								<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_keadaankulit', array('value' => 'Memar')); 
                                ?> Memar
							</div>
							<div class="row">
								<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_keadaankulit', false, array('value' => 'Insisi Operasi')); 
                                ?> Insisi Operasi
							</div>-->
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::activeLabel($modPengkajian, 'pengkajianaskep_kelintegumen', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textArea($modPengkajian, 'pengkajianaskep_kelintegumen', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="row">
            <fieldset class="box">
                <legend class="rim">Pengindraan</legend>
                <div class="row">
                    <div class="col-sm-6">
                        <fieldset class="box">
                            <legend class="rim">Mata</legend>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_bentukmata', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                                <div class="controls">
                                    <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_bentukmata', array('Simetris' => 'Simetris', 'Tidak' => 'Tidak')); ?>
                                    <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_bentukmata', array('value' => 'Simetris')); 
                                            ?> Simetris
									<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_bentukmata', array('value' => 'Tidak')); 
                                    ?> Tidak-->
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_edema', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                                <div class="controls">
                                    <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_edema', array('Ya' => 'Ya', 'Tidak' => 'Tidak')); ?>
                                    <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_edema', array('value' => 'Ya')); 
                                            ?> Ya
									<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_edema', array('value' => 'Tidak')); 
                                    ?> Tidak-->
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_konjungtiva', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                                <div class="controls">
                                    <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_konjungtiva', array('Anemis' => 'Anemis', 'Tidak' => 'Tidak')); ?>
                                    <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_konjungtiva', array('value' => 'Anemis')); 
                                            ?> Anemis
									<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_konjungtiva', array('value' => 'Tidak')); 
                                    ?> Tidak-->
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_funglihat', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                                <div class="controls">
                                    <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_funglihat', array('Baik' => 'Baik', 'Tidak' => 'Tidak')); ?>
                                    <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_funglihat', array('value' => 'Baik')); 
                                            ?> Baik
									<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_funglihat', array('value' => 'Tidak')); 
                                    ?> Tidak-->
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::activeLabel($modPengkajian, 'pengkajianaskep_kelmata', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textArea($modPengkajian, 'pengkajianaskep_kelmata', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div class="col-sm-6">
                        <fieldset class="box">
                            <legend class="rim">Hidung</legend>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_bentukhid', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                                <div class="controls">
                                    <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_bentukhid', array('Simetris' => 'Simetris', 'Tidak' => 'Tidak')); ?>
                                    <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_bentukhid', array('value' => 'Simetris')); 
                                            ?> Simetris
									<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_bentukhid', array('value' => 'Tidak')); 
                                    ?> Tidak-->
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_perdarahanhid', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                                <div class="controls">
                                    <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_perdarahanhid', array('Ada' => 'Ada', 'Tidak' => 'Tidak')); ?>
                                    <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_perdarahanhid', array('value' => 'Ada')); 
                                            ?> Ada
									<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_perdarahanhid', array('value' => 'Tidak')); 
                                    ?> Tidak-->
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_fungpenciuman', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                                <div class="controls">
                                    <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_fungpenciuman', array('Baik' => 'Baik', 'Tidak' => 'Tidak')); ?>
                                    <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_fungpenciuman', array('value' => 'Baik')); 
                                            ?> Baik
									<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_fungpenciuman', array('value' => 'Tidak')); 
                                    ?> Tidak-->
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::activeLabel($modPengkajian, 'pengkajianaskep_kelhidung', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textArea($modPengkajian, 'pengkajianaskep_kelhidung', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="box">
                            <legend class="rim">Telinga</legend>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_bentuktelinga', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                                <div class="controls">
                                    <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_bentuktelinga', array('Simetris' => 'Simetris', 'Tidak' => 'Tidak')); ?>
                                    <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_bentuktelinga', array('value' => 'Simetris')); 
                                            ?> Simetris
									<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_bentuktelinga', array('value' => 'Tidak')); 
                                    ?> Tidak-->
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_lesi', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                                <div class="controls">
                                    <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_lesi', array('Ada' => 'Ada', 'Tidak' => 'Tidak')); ?>
                                    <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_lesi', array('value' => 'Ada')); 
                                            ?> Ada
									<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_lesi', array('value' => 'Tidak')); 
                                    ?> Tidak-->
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_fungdengar', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

                                <div class="controls">
                                    <?php echo CHtml::activeRadioButtonList($modPengkajian, 'pengkajianaskep_fungdengar', array('Baik' => 'Baik', 'Tidak' => 'Tidak')); ?>
                                    <!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_fungdengar', array('value' => 'Baik')); 
                                            ?> Baik
									<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_fungdengar', array('value' => 'Tidak')); 
                                    ?> Tidak-->
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::activeLabel($modPengkajian, 'pengkajianaskep_keltelinga', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textArea($modPengkajian, 'pengkajianaskep_keltelinga', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</div>