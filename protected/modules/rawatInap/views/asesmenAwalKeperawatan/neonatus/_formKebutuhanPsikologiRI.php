<div class="row-fluid">
     <div class="panel panel-primary panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"><strong>Kebutuhan Psikologi, Sosial Ekonomi</strong></div>
        </div>
         <div class="panel-body">
             <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">Kebutuhan Sosial Ekonomi (Untuk Orang Tua)</div>
                </div>
                 <div class="panel-body">
                   <div class="row">
                       <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model,'neonatus_tinggalbersama', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model,'neonatus_tinggalbersama', LookupM::getItems('asesmen_tinggalbersama'),array('class'=>'span3', 'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event);",'onchange'=>'changeTinggalBersama(this);')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"></label>
                            <div class="controls">
                              <span style="color: black">Nama Pihak Lainnya </span> <br/><?php echo $form->textField($model,'neonatus_tinggalbersamalainnya_nama',array('class'=>'span3 tinggalbersama disabledinputan', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"></label>
                            <div class="controls">
                              <span style="color: black">No. telp Pihak Lainnya</span> <br/><?php echo $form->textField($model,'neonatus_tinggalbersamalainnya_notlp',array('class'=>'span3 tinggalbersama disabledinputan', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>
                            </div>
                        </div>
                       </div>
                       <div class="col-sm-6">
                         <div class="control-group ">
                           <div class="controls">
                             <span style="color:black"><u>Kebiasaan Ibu</u></span>
                           </div>
                         </div>
                         <div class="control-group ">
                  					<?php echo $form->labelEx($model,'statusmerokok', array('class'=>'control-label')) ?>
                  					<div class="controls">
                  						<div class="radio inline">
                  							<div class="form-inline">
                  								<?php echo $form->radioButtonList($model,'statusmerokok',array('0'=>'Tidak','1'=>'Ya'), array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'statusrokok disa','onclick'=>'setJumlahRokokNeunatus(this);','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                  							</div>
                  						</div>
                  					</div>
                  				</div>
                  				<div class="control-group">
                  					<?php echo $form->labelEx($model, 'jmlrokok_btg_hr', array('class' => 'control-label')) ?>
                  					<div class="controls">
                  						<?php echo $form->textField($model, 'jmlrokok_btg_hr', array('class' => 'span1 jmlbtg disabledinputan', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                  						Per Hari
                  					</div>
                  				</div>
                          <div class="control-group ">
                   					<?php echo $form->labelEx($model,'neonatus_kebiasaanortualkohol_status', array('class'=>'control-label')) ?>
                   					<div class="controls">
                   						<div class="radio inline">
                   							<div class="form-inline">
                   								<?php echo $form->radioButtonList($model,'neonatus_kebiasaanortualkohol_status',array('0'=>'Tidak','1'=>'Ya'), array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'neonatus_kebiasaanortualkohol_status','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                   							</div>
                   						</div>
                   					</div>
                   				</div>
                          <div class="control-group">
                              <label class="control-label">Jenis & Jumlah Alkohol yang dikonsumsi</label>
                              <div class="controls">
                                <?php echo $form->textField($model,'neonatus_kebiasaanortualkohol_jenis',array('placeholder'=>'Jenis','class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?> <span style="color: black">/</span>
                                <?php echo $form->textField($model,'neonatus_kebiasaanortualkohol_jml',array('placeholder'=>'Jumlah','class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>
                                <span style="color: black">Per Hari</span>
                              </div>
                          </div>
                          <?php echo $form->textAreaRow($model, 'neonatus_kebiasaanortulainnya', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                          <div class="control-group">
                              <?php echo $form->labelEx($model,'neonatus_agamaortu', array('class'=>'control-label')) ?>
                              <div class="controls">
                                  <?php echo $form->dropDownList($model,'neonatus_agamaortu', LookupM::getItems('agama'),array('class'=>'span3', 'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                              </div>
                          </div>
                          <div class="control-group ">
                            <div class="controls">
                              <span style="color:black"><u>Ekonomi</u></span>
                            </div>
                          </div>
                          <div class="control-group ">
                             <label class="control-label">Pembiayaan Kesehatan</label>
                             <div class="controls">
                                 <?php echo CHtml::textField('carabayar_nama', (isset($modPendaftaran->carabayar)? $modPendaftaran->carabayar->carabayar_nama:""), array('class' => 'span3','readonly'=>true)); ?>
                             </div>
                         </div>
                       </div>
                     </div>

                 </div>
             </div>

         </div>
     </div>
</div>
