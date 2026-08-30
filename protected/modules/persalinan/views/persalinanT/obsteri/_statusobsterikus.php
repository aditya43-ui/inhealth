<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo Chtml::label('Fundus Uteri', 'fundus obs_fundusufen', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField($modPemeriksaan, 'obs_fundusufen', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                ?> <div class='additional-text'><label>cm</label></div>
                <?php echo $form->error($modPemeriksaan, 'obs_fundusufen'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modPemeriksaan, 'ketuban', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField($modPemeriksaan, 'ketuban_genitalia', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                ?>
                <?php echo $form->error($modPemeriksaan, 'ketuban_genitalia'); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($modPemeriksaan, 'warna ketuban', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField($modPemeriksaan, 'obs_warnaketuban', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                ?>
                <?php echo $form->error($modPemeriksaan, 'obs_warnaketuban'); ?>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="col-sm-12">
        <div style="margin-top: 20px !important;" class="panel panel-darkk">
            <span class="group-title">
              Pemeriksaan Dalam
            </span>
            <div class="panel-body" style="padding-top:5px !important;">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($modPemeriksaan, 'obs_periksadalam', array('class' => 'control-label','label'=>'Waktu Pemeriksaan')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modPemeriksaan,
                                    'attribute' => 'obs_periksadalam',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                                <?php echo $form->error($modPemeriksaan, 'obs_periksadalam'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Petugas Pemeriksaan", 'obs_pemeriksa', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $modPemeriksaan,
                                    'attribute' => 'obs_pemeriksa',
                                    'source' => 'js: function(request, response) {
                                                    $.ajax({
                                                        url: "' . $this->createUrl('AutocompleteObsPemeriksaan') . '",
                                                        dataType: "json",
                                                        data: {
                                                            term: request.term,
                                                        },
                                                        success: function (data) {
                                                                response(data);
                                                        }
                                                    })
                                                    }',
                                    'options' => array(
                                        'showAnim' => 'fold',
                                        'minLength' => 3,
                                        'focus' => 'js:function( event, ui ) {
                                            $(this).val( ui.item.label);
                                            return false;
                                        }',
                                        'select' => 'js:function( event, ui ) {
                                            
                                            return false;
                                        }',
                                    ),
                                    'htmlOptions' => array(
                                        'placeholder'=>'Ketikan nama pegawai',
                                        'class' => 'span3',
                                        'onkeyup' => "return $(this).focusNextInputField(event)"
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogPetugasPemeriksaan_obs'),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                        <?php echo CHtml::label("PPDS", 'obs_ppds_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($modPemeriksaan,'obs_ppds_id') ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modPemeriksaan,
                    'attribute' => 'obs_ppds_nama',
                    'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . $this->createUrl('/anestesi/rencanaAnestesi/ppds') . '",
                                        dataType: "json",
                                        data: {
                                            term: request.term,
                                        },
                                        success: function (data) {
                                                response(data);
                                        }
                                    })
                                    }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                            $(this).val( ui.item.label);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            $("#' . Chtml::activeId($modPemeriksaan, 'obs_ppds_id') . '").val(ui.item.ppds_id); 
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'placeholder'=>'Ketikan nama ppds',
                        'class' => 'span3',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modPemeriksaan, 'obs_ppds_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPPDS_obsterikus'),
                ));
                ?>
            </div>
        </div>
      
                        <div class="control-group">
                            <?php echo $form->labelEx($modPemeriksaan, 'portio_genitalia', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->textField($modPemeriksaan, 'portio_genitalia', array('class' => 'span3 angkahuruf-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                ?>
                                <?php echo $form->error($modPemeriksaan, 'portio_genitalia'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPemeriksaan, 'konsistensi', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->textField($modPemeriksaan, 'obs_konsistensigenitalia', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                ?>
                                <?php echo $form->error($modPemeriksaan, 'obs_konsistensigenitalia'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPemeriksaan, 'arah', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->textField($modPemeriksaan, 'obs_arah', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                ?>
                                <?php echo $form->error($modPemeriksaan, 'obs_arah'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPemeriksaan, 'pemeriksaan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                    echo $form->textArea($modPemeriksaan, 'obs_pemeriksaan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                ?>
                            </div>
                        </div>  

                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($modPemeriksaan, 'bagian terendah', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->textField($modPemeriksaan, 'penurunan_genitalia', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                ?>
                                <?php echo $form->error($modPemeriksaan, 'penurunan_genitalia'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPemeriksaan, 'hodge', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->textField($modPemeriksaan, 'obs_hodge', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                ?>
                                <?php echo $form->error($modPemeriksaan, 'obs_hodge'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Ukuran Panggul', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->radioButtonList($modPemeriksaan,'panggul_ukuran', array('N'=>'N','PSR'=>'PSR','PSA'=>'PSA'), array('class'=>'panggul_ukuran','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>  
                        <div class="control-group">
                            <?php echo CHtml::label('Posisi Pengukuran Panggul', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->radioButtonList($modPemeriksaan,'panggul_posisipengukuran', array('BAP'=>'BAP','BTP'=>'BTP','PBP'=>'PBP'), array('class'=>'panggul_posisipengukuran','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>         
                        <div class="control-group">
                            <?php echo $form->labelEx($modPemeriksaan, 'presentasi', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->textField($modPemeriksaan, 'presentasi_genitalia', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                ?>
                                <?php echo $form->error($modPemeriksaan, 'presentasi_genitalia'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top: 20px !important; width: 70% !important;" class="panel panel-darkk">
            <span class="group-title">
              Janin
            </span>
            <div class="panel-body" style="padding-top:5px !important;">
                <table width="100%" id="tbljanin_obs">
                    <thead>
                        <tr>
                            <td width="30%" style="text-align: center; color: #001F3E">
                                Frekuensi DJJ
                            </td>
                            <td width="30%" style="text-align: center; color: #001F3E">
                                DJJ                                
                            </td>
                            <td width="30%" style="text-align: center; color: #001F3E">
                                Letak
                            </td>
                            <td style="width: 10%; text-align: center">
                                <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array('class' => 'btn btn-primary', 'onclick' => 'tambahJaninObs();')); ?>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            if(!empty($modPemeriksaan->frek_auskultasi)){
                                $frekJson = json_decode($modPemeriksaan->frek_auskultasi);
                                $denyutjaninJson = array();
                                if(!empty($modPemeriksaan->denyutjantung_janin)){
                                    $denyutjaninJson = json_decode($modPemeriksaan->denyutjantung_janin);
                                }
                                $posisijaninJson = array(); 
                                if(!empty($model->posisijanin)){
                                    $posisijaninJson = json_decode($model->posisijanin);
                                }   
                                

                                if(!empty($frekJson)){
                                    foreach ($frekJson as $i => $dataFrek){
                                        $valueFrekuensi = $dataFrek;
                                        $valueDjj = (!empty($denyutjaninJson[$i])?$denyutjaninJson[$i]:null);
                                        $valueLetak = (!empty($posisijaninJson[$i])?$posisijaninJson[$i]:null);

                                        echo $this->renderPartial($this->path_view.'obsteri/_rowJanin',array('valuefrekuensi'=>$valueFrekuensi, 'valuedjj'=>$valueDjj, 'valueletak'=>$valueLetak),true);
                                    }
                                }
                            }
                        ?>
                    </tbody>         
                </table>
            </div>
        </div>

    </div>

</div>