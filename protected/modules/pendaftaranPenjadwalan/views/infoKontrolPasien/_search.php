<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'id' => 'formSearch',
            'type' => 'horizontal',
            'focus' => '#' . CHtml::activeId($model, 'no_rekam_medik'),
        ));
        ?>
        <style>
            #ruangan label {
                width: 200px;
                display: inline-block;
            }
        </style>
        <div class="row">
            <div class="col-sm-6">
                <?php /*
        <div class="control-group">
                <label for="namaPasien" class="control-label">
                        Tanggal Rencana Kontrol
              </label>
                <div class="controls">
                        <?php $model->tgl_awalrenkon = $format->formatDateTimeForUser($model->tgl_awalrenkon); ?>
                        <?php   $format = new MyFormatter;
                                        $this->widget('MyDateTimePicker',array(
                                                                        'model'=>$model,
                                                                        'attribute'=>'tgl_awalrenkon',
                                                                        'mode'=>'date',
                                                                        'options'=> array(
                                                                                'dateFormat'=>Params::DATE_FORMAT,
                                                                                //'maxDate' => 'd',
                                                                        ),
                                                                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                        ));?> 
                </div>
        </div>
        <div class="control-group">
                <label for="namaPasien" class="control-label">
                   Sampai dengan
                </label>
                <div class="controls">
                        <?php $model->tgl_akhirrenkon = $format->formatDateTimeForUser($model->tgl_akhirrenkon); ?>
                                  <?php   $this->widget('MyDateTimePicker',array(
                                                                        'model'=>$model,
                                                                        'attribute'=>'tgl_akhirrenkon',
                                                                        'mode'=>'date',
                                                                        'options'=> array(
                                                                                'dateFormat'=>Params::DATE_FORMAT,
                                                                                //'maxDate' => 'd',
                                                                        ),
                                                                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                        )); ?>
                </div>
        </div>
        <?php */ //echo  $form->textFieldRow($model,'tgl_pendaftaran'); 
                ?>
                <div class="control-group">
                    <?php echo CHtml::label("Tgl. Rencana Kontrol", 'tgl_awalrenkon', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awalrenkon)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhirrenkon)) ?>">
                            <i class="entypo-calendar"></i>
                            <span><?php echo date('d M Y', strtotime($model->tgl_awalrenkon)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhirrenkon)) ?></span>
                            <?php echo $form->hiddenField($model, 'tgl_awalrenkon', array('class' => 'start')) ?>
                            <?php echo $form->hiddenField($model, 'tgl_akhirrenkon', array('class' => 'end')) ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label for="namaPasien" class="control-label">
                        <?php echo CHtml::activecheckBox($model, 'ceklis', array('uncheckValue' => 0, 'id' => 'cektanggal', 'rel' => 'tooltip', 'onClick' => 'cekTanggal()', 'data-original-title' => 'Cek untuk pencarian berdasarkan tanggal')); ?>
                        <label for="cektanggal">Tanggal Pendaftaran</label>
                    </label>
                    <?php //echo CHtml::label("Tgl. Pendaftaran",'tgl_rekam', array('class' => 'control-label')) 
                    ?>
                    <div class="controls">
                        <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                            <i class="entypo-calendar"></i>
                            <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                            <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                            <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                        </div>
                    </div>
                </div>
                <?php /*
		<div class="control-group">
				<label for="namaPasien" class="control-label">
						<?php echo CHtml::activecheckBox($model, 'ceklis', array('uncheckValue'=>0,'rel'=>'tooltip' ,'onClick'=>'cekTanggal()','data-original-title'=>'Cek untuk pencarian berdasarkan tanggal')); ?>
						Tanggal Pendaftaran
				</label>
				<?php // echo CHtml::activeLabel($model, 'tgl_pendaftaran', array('class' => 'control-label')) ?>
				<div class="controls">
						<?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
						<?php
						$this->widget('MyDateTimePicker', array(
								'model' => $model,
								'attribute' => 'tgl_awal',
								'mode' => 'date',
								'options' => array(
										'dateFormat' => Params::DATE_FORMAT,
										'maxDate' => 'd',
								),
								'htmlOptions' => array('readonly' => true, 
								'class' => 'span3 dtPicker3'),
						));
						?>
						<?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
				</div>
		</div>
		<div class="control-group">
				<label class='control-label'>Sampai dengan</label>
				<div class="controls">
						<?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
						<?php
						$this->widget('MyDateTimePicker', array(
								'model' => $model,
								'attribute' => 'tgl_akhir',
								'mode' => 'date',
								'options' => array(
										'dateFormat' => Params::DATE_FORMAT,
										'maxDate' => 'd',
								),
								'htmlOptions' => array('readonly' => true,
								'class' => 'span3 dtPicker3'),
						));
						?>
						<?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
				</div>
                            </div>
		 * 
		 */ ?>
                <div class="control-group">
                    <?php echo Chtml::label("No. Pendaftaran", 'no_pendaftaran', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'prefix_pendaftaran', PendaftaranT::model()->getColumn(), array('empty' => '-- Pilih --', 'class' => 'numbers-only span2')); ?>
                        <?php echo $form->textField($model, 'no_pendaftaran', array('class' => 'span2 numbers-only', 'maxlength' => 10, 'placeholder' => 'No. Pendaftaran')); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4 numbers-only', 'maxlength' => 6)); ?>
                <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4 hurufs-only', 'maxlength' => 50)); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->textAreaRow($model, 'alamat_pasien', array('placeholder' => 'Alamat Pasien', 'class' => 'autogrow span4 custom-only', 'rows' => 2, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <?php
                $carabayar = CarabayarM::model()->findAll(array(
                    'condition' => 'carabayar_aktif = true',
                    'order' => 'carabayar_nourut',
                ));
                $penjamin = PenjaminpasienM::model()->findAll(array(
                    'condition' => 'penjamin_aktif = true',
                    'order' => 'penjamin_nama',
                ));
                foreach ($carabayar as $idx => $item) {
                    $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                        'carabayar_id' => $item->carabayar_id,
                        'penjamin_aktif' => true,
                    ));
                    if (empty($penjamins)) unset($carabayar[$idx]);
                }
                echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                    'empty' => '-- Pilih --',
                    'class' => 'span4',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/actionDynamic/getPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
                        'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data); }',
                    ),
                ));
                echo $form->dropDownListRow($model, 'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 50));
                ?>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'instalasi_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('GetRuanganDariInstalasi', array('encode' => false, 'namaModel' => '' . get_class($model) . '')),
                            'update' => '#PPPendaftaranT_ruangan_id',  //selector to update
                        ),)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'ruangan_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'ruangan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true ORDER BY ruangan_nama ASC'), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'title' => 'Cari')); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index'),
                array(
                    'class' => 'btn btn-default',
                    'title' => 'Ulang',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('index') . '";} ); return false;'
                )
            ); ?>
            <?php
            $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasiRencanaControl', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
        </div>
        <?php $this->endWidget(); ?>
        <script>
            document.getElementById('PPPendaftaranT_tgl_awal_date').setAttribute("style", "display:none;");
            document.getElementById('PPPendaftaranT_tgl_akhir_date').setAttribute("style", "display:none;");

            function cekTanggal() {
                var checklist = $('#PPPendaftaranT_ceklis');
                var pilih = checklist.attr('checked');
                if (pilih) {
                    document.getElementById('PPPendaftaranT_tgl_awal_date').setAttribute("style", "display:block;");
                    document.getElementById('PPPendaftaranT_tgl_akhir_date').setAttribute("style", "display:block;");
                } else {
                    document.getElementById('PPPendaftaranT_tgl_awal_date').setAttribute("style", "display:none;");
                    document.getElementById('PPPendaftaranT_tgl_akhir_date').setAttribute("style", "display:none;");
                }
            }
        </script>
    </div>
</div>