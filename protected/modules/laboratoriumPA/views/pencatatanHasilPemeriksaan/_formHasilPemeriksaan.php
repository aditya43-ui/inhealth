<div id='form-hasilpemeriksaanlab'>
    <!--fieldset class="box"-->
        <div class="row-fluid">
            <div class="col-sm-6">
                <?php echo $form->hiddenField($modHasilPemeriksaan, 'hasilpemeriksaanlab_id',array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event);"));?>
                <div class="control-group">
                    <?php echo $form->labelEx($modHasilPemeriksaan, 'nohasilperiksalab', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modHasilPemeriksaan, 'nohasilperiksalab',array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event);"));?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modHasilPemeriksaan, 'statusperiksahasil', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modHasilPemeriksaan, 'statusperiksahasil',array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event);"));?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">    
                <div class="control-group">
                    <?php echo $form->labelEx($modHasilPemeriksaan, 'tglhasilpemeriksaanlab', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php   
                            $modHasilPemeriksaan->tglhasilpemeriksaanlab = (!empty($modHasilPemeriksaan->tglhasilpemeriksaanlab) ? date("d/m/Y H:i:s",strtotime($modHasilPemeriksaan->tglhasilpemeriksaanlab)) : null);
                            $this->widget('MyDateTimePicker',array(
                                'model'=>$modHasilPemeriksaan,
                                'attribute'=>'tglhasilpemeriksaanlab',
                                'mode'=>'datetime',
                                'options'=> array(
    //                                'dateFormat'=>Params::DATE_FORMAT,
                                    'showOn' => false,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions'=>array('class'=>'dtPicker3 datetimemask realtime','onkeyup'=>"return $(this).focusNextInputField(event)",),
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modHasilPemeriksaan, 'tglpengambilanhasil', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php   
                            $modHasilPemeriksaan->tglpengambilanhasil = (!empty($modHasilPemeriksaan->tglpengambilanhasil) ? date("d/m/Y H:i:s",strtotime($modHasilPemeriksaan->tglpengambilanhasil)) : null);
                            $this->widget('MyDateTimePicker',array(
                                'model'=>$modHasilPemeriksaan,
                                'attribute'=>'tglpengambilanhasil',
                                'mode'=>'datetime',
                                'options'=> array(
    //                                'dateFormat'=>Params::DATE_FORMAT,
                                    'showOn' => false,
    //                                    'maxDate' => 'd',
                                ),
                                'htmlOptions'=>array('class'=>'dtPicker3 datetimemask realtime','onkeyup'=>"return $(this).focusNextInputField(event)",),
                        )); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid"> 
            <table class="table table-bordered table-condensed table-bordered">
                <thead>
                    <th>No.</th>
                    <th>Kelompok Pemeriksaan</th>
                    <th width="30%">Detail Pemeriksaan</th>
                    <th>Hasil Pemeriksaan</th>
                    <th>Nilai Rujukan</th>
                    <th>Satuan</th>
                    <th>Metode</th>
                    <th>Keterangan</th>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="row-fluid">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($modHasilPemeriksaan, 'catatanlabklinik', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php $this->widget('ext.redactorjs.Redactor',array(
							'model'=>$modHasilPemeriksaan,
							'attribute'=>'catatanlabklinik',
							'toolbar'=>'mini','height'=>'150px'));?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($modHasilPemeriksaan, 'kesimpulan', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php $this->widget('ext.redactorjs.Redactor',array(
							'model'=>$modHasilPemeriksaan,
							'attribute'=>'kesimpulan',
							'toolbar'=>'mini','height'=>'150px'));?>
                    </div>
                </div>
            </div>
			<div class="clear"></div>
			
			<?php /*
			<div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($modHasilPemeriksaan, 'diagnosaket_klinik', array('class'=>'control-label','style'=>'width:200px;')) ?>
                    <div class="controls">
                        <?php $this->widget('ext.redactorjs.Redactor',array(
							'model'=>$modHasilPemeriksaan,
							'attribute'=>'diagnosaket_klinik',
							'toolbar'=>'mini','height'=>'150px'));?>
                    </div>
                </div>
            </div>
			
			*/ ?>
        </div>
    <!--/fieldset-->
</div>