<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Pembayaran</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <?php
                $modPenUmum->kelompoktransaksi = 'KAS';
                echo $form->hiddenField($modPenUmum, 'kelompoktransaksi', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php // echo $form->dropDownListRow($modPenUmum,'kelompoktransaksi',LookupM::getItems('kelompoktransaksi'),array('class'=>'span3 reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); 
                ?>
                <?php
                $modPenUmum->jenispenerimaan_id = 22;
                echo $form->hiddenField($modPenUmum, 'jenispenerimaan_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <!--<div class="control-group">-->
                <?php // echo $form->labelEx($modPenUmum,'jenispenerimaan_id', array('class'=>'control-label')) 
                ?>
                <!--<div class="controls">-->
                <?php
                //                            $this->widget('MyJuiAutoComplete', array(
                //                            'model'=>$modPenUmum,
                //                            'attribute'=>'jenisKodeNama',
                //                            'source'=>'js: function(request, response) {
                //                                           $.ajax({
                //                                               url: "'.$this->createUrl('autocompleteJenisPenerimaan').'",
                //                                               dataType: "json",
                //                                               data: {
                //                                                   term: request.term,
                //                                               },
                //                                               success: function (data) {
                //                                                       response(data);
                //                                               }
                //                                           })
                //                                        }',
                //                             'options'=>array(
                //                                   'showAnim'=>'fold',
                //                                   'minLength' => 2,
                //                                   'focus'=> 'js:function( event, ui ) {
                //                                       $(this).val(ui.item.value);
                //                                        return false;
                //                                    }',
                //                                   'select'=>'js:function( event, ui ) {
                //                                        $("#KUPenerimaanUmumT_jenispenerimaan_id").val(ui.item.jenispenerimaan_id);
                //                                        getDataRekening(ui.item.jenispenerimaan_id);
                //                                        return false;
                //                                    }',
                //                            ),
                //                            'htmlOptions'=>array('placeholder'=>'Kode/Nama Jenis Penerimaan','class'=>'span3 reqForm'),
                //                            'tombolDialog' => array('idDialog' => 'dialogJenisPenerimaan',),
                //                            )); 
                ?>
                <!--</div>-->
                <!--</div>-->
                <hr>
                <?php echo $this->renderPartial($this->path_view . 'terimaKas/_rowListRekening', array(), true); ?>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($modTandabukti, 'tglbuktibayar', array('class' => 'control-label inline')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modTandabukti, 'tglbuktibayar', array('class' => 'realtime span3'));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modTandabukti, 'nobuktibayar', array('class' => 'control-label inline', 'readonly' => true, 'label' => 'No. Penerimaan')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modTandabukti, 'nobuktibayar', array('class' => 'span3', 'readonly' => true));
                        ?>
                    </div>
                </div>
                <?php // echo $form->dropDownListRow($modTandabukti,'carapembayaran',  LookupM::getItems('carapembayaran'),array('onchange'=>'ubahCaraPembayaran(this)','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); 
                ?>
                <div class="control-group">
                    <?php echo CHtml::label('Total Penerimaan', 'totTagihan', array('class' => 'control-label inline')) ?>
                    <div class="controls">
                        <?php

                        echo CHtml::textField('totTagihan', $modBayarSupplier->totaltagihan, array('readonly' => true, 'class' => 'inputFormTabel integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                    </div>
                    <!--total taginan-->
                </div>
                <?php // echo $form->textFieldRow($modTandabukti,'jmlpembulatan',array('readonly'=>true,'class'=>'inputFormTabel integer2 span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                ?>
                <?php echo $form->textFieldRow($modTandabukti, 'biayaadministrasi', array('readonly' => true, 'onkeyup' => 'hitungJmlBayar();', 'class' => 'inputFormTabel integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modTandabukti, 'biayamaterai', array('readonly' => true, 'onkeyup' => 'hitungJmlBayar();', 'class' => 'inputFormTabel integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <div class="control-group">
                    <?php echo CHtml::label('Jumlah Penerimaan', 'jmlpembayaran', array('class' => 'control-label inline')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modTandabukti, 'jmlpembayaran', array('onkeyup' => 'hitungKembalian();', 'readonly' => true, 'class' => 'inputFormTabel integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($modTandabukti, 'uangditerima', array('readonly' => true, 'onkeyup' => 'hitungKembalian();', 'class' => 'inputFormTabel integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modTandabukti, 'uangkembalian', array('readonly' => true, 'class' => 'inputFormTabel integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

                <div class="control-group">
                    <?php echo $form->labelEx($modTandabukti, 'carapembayaran', array('class' => 'control-label', 'style' => 'font-weight:bold;')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modTandabukti, 'carapembayaran', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>

                <?php // echo $form->hiddenField($modTandabukti,'ispakekartu',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
                ?>
                <div class="control-group">
                    <?php echo CHtml::label('Menggunakan Kartu', 'pakeKartu', array('class' => 'control-label inline')) ?>
                    <div class="controls">
                        <?php echo $form->checkBox($modTandabukti, 'ispakekartu', array('onchange' => "formCarabayar();", 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                    </div>
                </div>

                <div id="divCaraBayarTransfer">
                    <div class="control-group">
                        <?php echo CHtml::label("Nama Bank Penerima", 'bank_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $modBank = BankM::model()->findAll('bank_aktif = true ORDER BY namabank ASC');
                            echo $form->dropDownList($modTandabukti, 'bank_id', CHtml::listData($modBank, 'bank_id', 'namabank'), array(
                                'class' => 'span3', 'empty' => '-- Pilih --', 'onchange' => 'setNamaBank(this);',
                                'onkeyup' => "return $(this).focusNextInputField(event);"
                            ));
                            ?>
                        </div>
                    </div>
                    <?php // echo CHtml::activeHiddenField($modTandabukti, 'melalubank',array('readonly'=>true, 'class'=>'span3')); 
                    ?>
                    <?php echo $form->textFieldRow($modTandabukti, 'denganrekening', array(
                        'class' => 'span3',
                        'placeholder' => 'Dengan Rekening',
                        'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100
                    )); ?>
                    <?php echo $form->textFieldRow($modTandabukti, 'bank_nama', array(
                        'class' => 'span3',
                        'placeholder' => 'Nama Bank',
                        'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100
                    )); ?>
                </div>
                <?php echo $form->textAreaRow($modTandabukti, 'darinama_bkm', array('Placeholder' => 'Nama Lengkap Pembayar', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textAreaRow($modTandabukti, 'alamat_bkm', array('Placeholder' => 'Alamat Lengkap Pembayar', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textAreaRow($modTandabukti, 'sebagaipembayaran_bkm', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
</div>