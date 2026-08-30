<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END);
?>
<style>
  .integer-decimal{
    text-align: right;
  }
</style>

<?php
							$this->breadcrumbs = array(
								'Pembatalan Uang Muka',
							);
						?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-gradient">
			<div class="panel-heading">
				<div class="panel-title">Transaksi Pembatalan <strong>Uang Muka</strong></div>
			</div>
			<div class="panel-body">
                            <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                            <?php
							$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
								array(
									'id'=>'pembayaran-form',
									'enableAjaxValidation'=>false,
									'type'=>'horizontal',
									'htmlOptions'=>array(
										'onKeyPress'=>'return disableKeyPress(event);',
										// 'onsubmit'=>'return ',
									),
								)
							);
						?>
				<div class="panel panel-success">
					<div class="panel-heading">
						<div class="panel-title">Data Pasien</div>
					</div>
					<div class="panel-body">


						<?php
							$this->renderPartial(
								'_ringkasDataPasien',
								array(
									'modPendaftaran'=>$modPendaftaran,
									'modPasien'=>$modPasien
								)
							);
						?>
					</div>
				</div>
        <div class="panel panel-success">
          <div class="panel-heading">
            <div class="panel-title">Data Pembatalan</div>
          </div>
          <div class="panel-body">
            <div class="row">
							<div class="col-sm-6">
                <div class="control-group ">
									<?php $modBatal->tglpembatalan = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBatal->tglpembatalan, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
									<?php echo $form->labelEx($modBatal,'tglpembatalan', array('class'=>'control-label')); ?>
									<div class="controls">
										<?php
												$this->widget('MyDateTimePicker',
													array(
														'model'=>$modBatal,
														'attribute'=>'tglpembatalan',
														'mode'=>'datetime',
														'options'=> array(
															'dateFormat'=>Params::DATE_FORMAT,
															'maxDate' => 'd',
														),
														'htmlOptions'=>array(
															'class'=>'span3',
															'onkeypress'=>"return $(this).focusNextInputField(event)"
														),
													)
												);
										?>
									</div>
								</div>
              </div>
              <div class="col-sm-6">
                <?php
									echo $form->textAreaRow($modBatal,'keterangan_batal',
										array(
											'class'=>'span3 req',
											'onkeypress'=>"return $(this).focusNextInputField(event);"
										)
									);
								?>
              </div>
            </div>

          </div>
        </div>

				<div class="panel panel-success">
					<div class="panel-heading">
						<div class="panel-title">Data Pengeluaran Kas</div>
					</div>
					<div class="panel-body">
						<div class="row-fluid">
							<div class="col-sm-6">
								<?php echo $this->renderPartial('_rowListRekening', array(
                                    'form'=>$form,
                                    'modUraian'=>null,
                                    'modPengUmum'=>$modPengUmum,
                                )); ?>
							</div>
							<div class="col-sm-6">
                <?php echo CHtml::activeHiddenField($modBatal,'bayaruangmuka_id', array('readonly'=>true,'class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event);",'value'=>isset($_GET['idBayarUangMuka']) ? $_GET['idBayarUangMuka'] :null)); ?>
								<?php echo CHtml::activeHiddenField($modBatal,'tandabuktibayar_id',	array('readonly'=>true,'class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event);")); 	?>

                <div class="control-group ">
                    <?php $modBuktiKeluar->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBuktiKeluar->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                    <?php echo $form->labelEx($modBuktiKeluar, 'tglkaskeluar', array('class' => 'control-label inline')) ?>
                    <div class="controls">
                    <?php
                        $this->widget('MyDateTimePicker', array(
                                'model'			 => $modBuktiKeluar,
                                'attribute'		 => 'tglkaskeluar',
                                'mode'			 => 'datetime',
                                'options'		 => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate'	 => 'd',
                                ),
                                'htmlOptions'=> array('readonly'=>true, 'class'=>'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                        ));
                      ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($modBuktiKeluar, 'nokaskeluar', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,'readonly' => true)); ?>
                <?php echo $form->textFieldRow($modBatal,'total_uangmuka',array('class'=>'span3 integer-decimal req','onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true,)); ?>
								<?php echo $form->textFieldRow($modBuktiKeluar,'jmlkaskeluar',array('class'=>'span3 integer-decimal req','onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true));?>
                <div class="control-group">
                    <?php echo CHtml::label('Cara Pembayaran <span class="required">*</span>', '', array('class' => 'control-label required')) ?>
                    <div class="controls">
                         <?php echo $form->dropDownList($modBuktiKeluar, 'carabayarkeluar', LookupM::getItems('carabayarkeluar'), array(
                    'onchange' => 'formCarabayar(this.value)', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",
                    'maxlength' => 50)); ?>
                    </div>
                </div>
                <div id="divCaraBayarTransfer">
                    <div class="control-group">
                        <?php echo CHtml::activeLabel($modBuktiKeluar, 'bank_id', array('class' => 'control-label', 'required' => true, 'label'=>'Bank Pengirim')); ?>
                            <div class="controls">
                            <?php
                                $bank_data = BankM::model()->findAll('bank_aktif = true and ispenerimaan = true order by namabank');

                                $list_bank = CHtml::listData($bank_data, 'bank_id', 'bankNoRekening');
                                $option_bank = array();

                                foreach ($bank_data as $item) {
                                    $rekening = BankrekM::model()->findByAttributes(array(
                                        'bank_id'=>$item->bank_id,
                                        'saldonormal'=>'D',
                                    ));

                                    $option_bank[$item->bank_id] = array(
                                        'data-rekening'=>'',
                                    );

                                    if (!empty($rekening)) {
                                        $rek5 = Rekening5M::model()->findByPk($rekening->rekening5_id);
                                        $option_bank[$item->bank_id]['data-rekening'] = $rek5->kdrekening5." - ".$rek5->nmrekening5;
                                        $option_bank[$item->bank_id]['data-norek'] = $item->norekening;
                                    }


                                }

                                echo $form->dropDownList($modBuktiKeluar, 'bank_id', $list_bank,
                                    array('required' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);",
                                        'onchange'=>'setKodeAkunBank()','empty' => '-- Pilih Bank--',
                                        'options'=>$option_bank)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Kode Akun", '', array('class' => 'control-label', 'required' => true, 'label'=>'Nominal')); ?>
                                <div class="controls">
                                <?php echo CHtml::textField('kode_akun_bank', '', array(
                                    'id'=>'kode_akun_bank', 'class'=>'span3', 'readonly'=>true,
                                )); ?>
                                </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("No Rekening", '', array('class' => 'control-label', 'required' => true)); ?>
                                <div class="controls">
                                 <?php echo $form->textField($modBuktiKeluar, 'denganrekening', array('class' => 'span3',
                                    'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                </div>
                        </div>
                    <div class="control-group">
                        <?php echo CHtml::label("No. Bukti Transfer", '', array('class' => 'control-label', 'required' => true)); ?>
                            <div class="controls">
                             <?php echo $form->textField($modBuktiKeluar, 'nobukti_transfer', array('class' => 'span3',
                        'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            </div>
                    </div>


                    <div class="control-group">
                        <?php echo CHtml::activeLabel($modBuktiKeluar, 'melalubank', array('class' => 'control-label', 'required' => true, 'label'=>'Bank Penerima')); ?>
                        <div class="controls">
                        <?php
                        echo $form->dropDownList($modBuktiKeluar, 'melalubank', LookupM::getItems('bank'), array('required' => true, 'class' => 'span3', 'empty' => '-- Pilih Bank--', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                        ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('No Rekening Penerima', '', array('class' => 'control-label', 'required' => true,)) ?>
                        <div class="controls">
                            <?php echo $form->textField($modBuktiKeluar, 'norekpenerima', array('class' => 'span3',
                                'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Nama Penerima <span class="required">*</span>', '', array('class' => 'control-label required')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modBuktiKeluar, 'namapenerima', array('class' => 'span3',
                        'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    </div>
                </div>
                <?php echo CHtml::activeHiddenField($modBatal,'alamatpenerima', array(
					'readonly'=>true,
					'class'=>'span3',
					'onkeypress'=>"return $(this).focusNextInputField(event);",
					'value'=>isset($modBuktiKeluar->alamatpenerima) ? $modBuktiKeluar->alamatpenerima :'-')); ?>
                <!-- <div class="control-group">
                    <?php //echo CHtml::label('Alamat Penerima <span class="required">*</span>', '', array('class' => 'control-label required')) ?>
                    <div class="controls">
                       <?php //echo $form->textArea($modBuktiKeluar, 'alamatpenerima', array('class' => 'span3',
                        // 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div> -->
                <div class="control-group">
                    <?php echo CHtml::label('Untuk Pembayaran <span class="required">*</span>', '', array('class' => 'control-label required')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modBuktiKeluar, 'untukpembayaran', array('class' => 'span3',
                        'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    </div>
                </div>

							</div>
						</div>
					</div>
				</div>

				<div class="form-actions">
					<?php
            $disabledSimpan = (isset($_GET['sukses'])? true:false);

            echo CHtml::htmlButton(
							Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
							array('class'=>'btn btn-primary',	'type'=>'button', 'onKeypress'=>'return cekValidasi();',
                'disabled'=>$disabledSimpan,'onClick'=>'return cekValidasi();'
							)
						);

              echo "&nbsp;";
              echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
								$this->createUrl($this->id.'/index'),
								array('class'=>'btn btn-danger',
									  'onclick'=>'return refreshForm(this);'));

              echo "&nbsp;";
              echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array(
                      'class' => 'btn btn-info', 'onclick' => "printPembatalan();return false", 'disabled' => (($disabledSimpan==true)?false:true)));
					?>
					<?php
					$content = $this->renderPartial('tips/transaksi',array(),true);
					$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
					?>
				</div>
				<?php $this->renderPartial('_jsFunctions',array('modBuktiKeluar'=>$modBuktiKeluar,'modBatal'=>$modBatal)); ?>

				<?php
					$this->beginWidget('zii.widgets.jui.CJuiDialog',
						array(
							'id'=>'dlgConfirmasi',
							'options'=>array(
								'title'=>'Konfirmasi Pembatalan',
								'autoOpen'=>false,
								'modal'=>true,
								'width'=>900,
								'height'=>400,
								'resizable'=>false,
							),
						)
					);
				?>
				<div id="detail_confirmasi">
					<div id="content_confirm">
						<fieldset>
							<legend class="rim">Info Pasien</legend>
							<table id="info_pasien_temp" class="table table-bordered table-condensed">
								<tr>
									<td width="150">No. Pendaftaran</td>
									<td width="250" tag="no_pendaftaran"></td>
									<td width="150">Nama</td>
									<td tag="nama_pasien"></td>
								</tr>
								<tr>
									<td>Instalasi</td>
									<td tag="instalasi_nama"></td>
									<td>No. Rekam Medis</td>
									<td tag="no_rekam_medik"></td>
								</tr>
								<tr>
									<td>Ruangan</td>
									<td tag="ruangan_nama"></td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
							</table>
						</fieldset>
						<fieldset>
							<legend class="rim">Detail Pembatalan</legend>
							<table id="info_pembayaran" class="table table-bordered table-condensed">
								<tr>
									<td width="150">Nama Penerima</td>
									<td width="250" tag="namapenerima"></td>
									<td width="150">No. Kas</td>
									<td tag="nokaskeluar"></td>
								</tr>
								<tr>
									<td>Untuk Pembayaran</td>
									<td tag="untukpembayaran"></td>
									<td>Keterangan</td>
									<td tag="keterangan_batal"></td>
								</tr>
								<tr>
									<td>Jumlah Kas</td>
									<td tag="jmlkaskeluar"></td>
									<td>Biaya Administrasi</td>
									<td tag="biayaadministrasi">&nbsp;</td>
								</tr>
							</table>
						</fieldset>
					</div>
					<div class="form-actions">
							<?php
								echo CHtml::link(
									'Teruskan',
									'#',
									array(
										'class'=>'btn btn-primary',
										'onClick'=>'simpanProses();return false;'

									)
								);
							?>
							<?php
								echo CHtml::link(
									'Kembali',
									'#',
									array(
										'class'=>'btn btn-danger',
										'onClick'=>'$("#dlgConfirmasi").dialog("close");$("#pembayaran-form").find("input[name$=\'[biayaadministrasi]\']").focus();return false;'
									)
								);
							?>
					</div>
				</div>
				<?php
					$this->endWidget();
				?>
                            <?php $this->endWidget(); ?>
			</div>
		</div>
	</div>
</div>
