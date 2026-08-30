<div class="col-sm-6">
    <?php
        echo $form->hiddenField($modPenjualan,'penjualanresep_id',array('readonly'=>true));
    ?>
    <div class="control-group ">
        <?php echo $form->labelEx($modPenjualan,'tglresep', array('class'=>'control-label')) ?>
        <div class="controls">
        <?php                       
                                    $modPenjualan->tglpenjualan = MyFormatter::formatDateTimeForUser($modPenjualan->tglpenjualan);
                                    $modPenjualan->tglresep = MyFormatter::formatDateTimeForUser($modPenjualan->tglresep);

                                    if($this->ada_penjualan){
                                            echo $form->textField($modPenjualan,'tglresep',array('readonly'=>true, 'style'=>'width:170px;'));
                                    }else{
                                            $this->widget('MyDateTimePicker',array(
                                                                            'model'=>$modPenjualan,
                                                                            'attribute'=>'tglresep',
                                                                            'mode'=>'datetime',
                                                                            'options'=> array(
                                                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                                                    'maxDate' => 'd',
                                                                                    'yearRange'=> "-60:+0",
                                                                            ),
                                                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'style'=>'width:128px;','onkeypress'=>"return $(this).focusNextInputField(event)"
                                                                            ),
                                            )); 
                                    }
                                    ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('No. Penjualan','noresep', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($modPenjualan,'noresep',array('readonly'=>true, 'style'=>'width:170px;')); ?><br>
        </div>
    </div>
    <div class="control-group">  
        <?php echo $form->labelEx($modPenjualan,'pegawai_id', array('class'=>'control-label')); ?> 
        <div class="controls">
            <?php echo CHtml::activeHiddenField($modPenjualan,'pegawai_id'); ?>
            <?php echo $form->textField($modReseptur,'pegawai_id',array('readonly'=>true, 'class'=>'span4','value'=>$modReseptur->pegawai2->namaLengkap)); ?><br>
                                <!--<div style="float:left;">-->
                                    <?php
        //								echo $modReseptur->pegawai_id;exit;
        //                                $modReseptur->dokter = isset($_GET['idPenjualan'])?$modPenjualan->pegawai->nama_pegawai:null;
        //                                $this->widget('MyJuiAutoComplete',array(
        //                                    'model'=>$modReseptur,
        //                                    'attribute'=>'dokter',
        //                                    'sourceUrl'=>  Yii::app()->createUrl('ActionAutoComplete/ListDokter'),
        //                                    'options'=>array(
        //                                        'showAnim'=>'fold',
        //                                        'minLength'=>2,
        //                                        'select'=>'js:function( event, ui ) {
        //                                                $("#'.CHtml::activeId($modPenjualan,'pegawai_id').'").val(ui.item.pegawai_id);
        //                                                    }',
        //                                    ),
        //                                    'tombolDialog'=>array('idDialog'=>'dialogDokter'),
        //                                    'htmlOptions'=>array("rel"=>"tooltip","title"=>"Pencarian Data Dokter",'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3','style'=>'float:left;')
        //                                ));
                                    ?>
                                <!--</div>-->
        </div>          
    </div>
    <div class="control-group ">
        <?php echo $form->labelEx($modPenjualan,'keterangan', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->textArea($modPenjualan,'keterangan',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </div> 
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Penelahaan Resep','Penelahaan Resep', array('class'=>'control-label')) ?>
            <div class="controls">
                <div>
                    <?php
                            echo CHtml::checkBox('kie_pilih_semua', false, array(
                                'class'=>'kie_pilih_semua', 'onclick'=>'set_kie_pilih_semua();'
                            )).CHtml::label('Pilih Semua', 'kie_pilih_semua', array());
                            ?></div>
                <?php echo $form->checkBoxList(
                                $modPenjualan,
                                'kiepenyerahan',
                                LookupM::getItemsUrutan('telaah_resep'),
                                array(
                                    'template' => '<div>{input}{label}</div>',
                                    'readonly' => false, 
                                    'class' => 'kie_item required',
                                    'onkeypress' => "return $(this).focusNextInputField(event);")
                            ); ?>
            </div>
        </div>
</div>
<div class="col-sm-6">
    <div class="control-group ">
        <?php echo $form->labelEx($modPenjualan,'lamapelayanan', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($modPenjualan,'lamapelayanan',array('class'=>'inputFormTabel span1 integer2','readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?> Detik
        </div> 
    </div>
    <div class="control-group ">
        <?php echo $form->labelEx($modPenjualan,'tglpenjualan', array('class'=>'control-label')) ?>
        <div class="controls">
        <?php   
                                    if($this->ada_penjualan){
                                            echo $form->textField($modPenjualan,'tglpenjualan',array('readonly'=>true, 'style'=>'width:170px;'));
                                    }else{
                                            $this->widget('MyDateTimePicker',array(
                                                                            'model'=>$modPenjualan,
                                                                            'attribute'=>'tglpenjualan',
                                                                            'mode'=>'datetime',
                                                                            'options'=> array(
                                                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                                                    'maxDate' => 'd',
                                                                                    'yearRange'=> "-60:+0",
                                                                            ),
                                                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3 realtime', 'style'=>'width:128px;', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                                            ),
                                    ));
                                    }
             ?>
        </div>
    </div>
    <?php //echo $form->textFieldRow($modPenjualan,'jenispenjualan',array('readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
    <div class='control-group'>
        <?php echo $form->labelEx($modPenjualan,'isresepperawatan', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->checkBox($modPenjualan,'isresepperawatan', array('onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>$this->ada_penjualan)); ?>
        </div>
    </div> 
    <div class='control-group'>
        <?php echo $form->labelEx($modPenjualan,'is_cito', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->checkBox($modPenjualan,'is_cito', array('onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>$this->ada_penjualan)); ?>
        </div>
    </div> 
    <div class="control-group hide">
        <label class="control-label" for="iter">Iter</label>
        <div class="controls">
            <?php echo CHtml::activeTextField($modPenjualan, 'iter', array('readonly'=>true,'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span1 numbers-only')) ?>
        </div>
    </div>
    <div class="control-group ">
        <label class="control-label" for="iter">Petugas</label>
    <?php 
        $modPetugas = new PetugasApi();
  
        $arrayPetugas = [];
        foreach($modPetugas->searchPetugas()->data as $dataPetugas) {
            $arrayPetugas[$dataPetugas['Kode']] = $dataPetugas['Nama'];
        }

    ?>
        <div class="controls">
            <?php echo CHtml::activedropDownList($modPenjualan, 'kodepetugas_inv', $arrayPetugas, array('readonly'=>true,'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3', 'id' => 'kodepetugas', 'empty' => '-- Pilih --')) ?>
        </div>
    </div>
    <?php 

    $this->getAPITempatLayananMain();
    $kode_inv = $modPenjualan->tempatlayanan_inv ?? Yii::app()->user->getState('kodedepo_inventory');
    $kode_jenis = null;

    if (!empty($this->list_tempat_layanan_api)) {
        foreach ($this->list_tempat_layanan_api as $item) {
            // var_dump($item);
            if ($kode_inv == $item['Kode']) {
                $kode_jenis = $modPenjualan->jenislayanan_inv = $item['KodeJL'];
            }
        }
    }

    if (empty($kode_jenis)) {
        $modPenjualan->tempatlayanan_inv = $kode_inv = null;
    }

    // vaR_dump($kode_inv, $kode_jenis); die;

    echo $form->dropDownListRow($modPenjualan, 'jenislayanan_inv', $this->getAPIJenisLayanan(), array(
        'class'=>'span3 jenislayanan_inv', 'empty'=>'-- Pilih --',
    )); 
    echo $form->dropDownListRow($modPenjualan, 'tempatlayanan_inv', $this->getAPITempatLayanan($kode_jenis), array(
        'class'=>'span3 tempatlayanan_inv', 'empty'=>'-- Pilih --',
    ));
    echo $form->dropDownListRow($modPenjualan, 'kodedokter_inventory', $this->getAPIDokterFarmasi(), array(
        'class'=>'span3 kodedokter_inventory', 'empty'=>'-- Pilih --',
    )); ?>


    
</div>