<?php
$this->breadcrumbs = array(
    'Konfirmasi Janji Poliklinik',
); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fa fa-check-circle"></i> Konfirmasi <b>Janji Poliklinik</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pppendaftaran-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);'), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
            'focus' => '#' . CHtml::activeId($modJanjipoli, 'no_buatjanji2'),
        )); ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan!");
        }
        if (!empty($model->pendaftaran_id)) {
            $this->flashBpjs($model->pendaftaran_id);
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $form->errorSummary($model); ?>
        <?php echo $form->errorSummary($modPasien); ?>
        <?php if (!isset($_GET['id'])) : ?>
            <?php $autoopen = Yii::app()->user->getState('isantrian');
            ?>

        <?php endif; ?>
        <div class="panel panel-success" id="form-pasien">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-user"></i> Data <b>Pasien</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php $this->renderPartial($this->path_view_booking . '_formPasien', array(
                        'form' => $form,
                        'model' => $model,
                        'modPasien' => $modPasien,
                        'modPegawai' => $modPegawai,
                        'modJanjipoli' => $modJanjipoli,
                    )); ?>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Kunjungan</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php echo $this->renderPartial($this->path_view_booking . '_formPendaftaran', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modRujukan' => $modRujukan, 'modRujukanBpjs' => $modRujukanBpjs, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs, 'modSep' => $modSep, 'modAsuransiPasienBadak' => $modAsuransiPasienBadak, 'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen, 'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja, 'modPegawai' => $modPegawai)); ?>
                    <div class="col-sm-6">
                        <?php /* echo $form->hiddenField($model,'is_adakarcis', array('readonly'=>true,'class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
						<?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
								'id'=>'form-karcis',
								'content'=>array(
									'content-karcis'=>array(
										'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan karcis')).'<b>Karcis</b>',
										'isi'=>'<div id="content-karcis-html">'
												.$this->renderPartial($this->path_view.'_formKarcis',array(
													'form'=>$form,
													'model'=>$model,
													'modTindakan'=>$modTindakan,
													'modKarcisV'=>$modKarcisV
													),true)
												.'</div>',
										'active'=>$model->is_adakarcis,
									),   
								),
						)); ?>
						
						<?php echo $form->hiddenField($model,'is_pasienrujukan', array('readonly'=>true,'class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
						<?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
								'id'=>'form-rujukan',
								'content'=>array(
									'content-rujukan'=>array(
										'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan rujukan')).'<b>Rujukan</b>',
										'isi'=>$this->renderPartial($this->path_view.'_formRujukan',array(
												'form'=>$form,
												'model'=>$model,
												'modRujukan'=>$modRujukan,
												),true),
										'active'=>$model->is_pasienrujukan,
									),   
								),
								'htmlOptions'=>array('style'=>(($model->is_bpjs)?'display:none':'')),
						)); */ ?>
                        <?php /*
						if(Yii::app()->user->getState('issmsgateway')){
							$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
								'id'=>'form-smsgateway',
								'content'=>array(
									'content-smsgateway'=>array(
										'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan Kirim SMS')).'<b>Kirim SMS</b>',
										'isi'=> $this->renderPartial($this->path_view.'_formSms', array('form'=>$form,'modSmsgateway'=>$modSmsgateway), true),
										'active'=>true,
									),   
								),
							));
						} */
                        ?>

                        <?php /* $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
								'id'=>'form-asuransi',
								'content'=>array(
									'content-asuransi'=>array(
										'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk Tampilkan Asuransi')).'<b><span class="judulasuransi">Asuransi Baru</span> </b> &nbsp &nbsp <span class="refreshasuransi" style="display:none;">'
												 .CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>',array('class'=>'btn btn-danger btn-mini pull-center','onclick'=>'setAsuransiBaru("badak");','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk input asuransi baru')).'</span>',
										'isi'=>$this->renderPartial($this->path_view.'_formAsuransi',array(
												'form'=>$form,
												'model'=>$model,
												'modPasien'=>$modPasien,
												'modAsuransiPasien'=>$modAsuransiPasien,
												),true),
										'active'=>false,
									),   
								),
								'htmlOptions'=>array('style'=>(($model->is_bpjs)?'display:none':'')),
						)); ?>
						<?php echo $form->hiddenField($model,'is_bpjs', array('readonly'=>true,'class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
						<?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
								'id'=>'form-bpjs',
								'content'=>array(
									'content-bpjs'=>array(
										'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk Tampilkan Asuransi',)).'<b>BPJS '.CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'resetFormBpjs();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang form bpjs.')).'</b>',
										'isi'=>$this->renderPartial($this->path_view.'_formAsuransiBpjs',array(
												'form'=>$form,
												'model'=>$model,
												'modPasien'=>$modPasien,
												'modRujukanBpjs'=>$modRujukanBpjs,
												'modAsuransiPasien'=>$modAsuransiPasienBpjs,
												'modSep'=>$modSep,
												),true),
										'active'=>$model->is_bpjs,
									),   
								),
								'htmlOptions'=>array('style'=>(($model->is_bpjs)?'':'display:none')),
						)); ?>
						<?php 
						$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
								'id'=>'form-asubadak',
								'content'=>array(
									'content-asubadak'=>array(
										'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk Tampilkan Form')).'<b><span class="judulasuransi">Asuransi PT. Badak LNG </span> </b> &nbsp &nbsp <span class="refreshasuransi">'
												 .CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>',array('class'=>'btn btn-danger btn-mini pull-center','onclick'=>'setAsuransiBadakReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk membersihkan field')).'</span>',
										'isi'=>$this->renderPartial($this->path_view.'_formAsuransiBadak',array(
												'form'=>$form,
												'model'=>$model,
												'modPasien'=>$modPasien,
												'modAsuransiPasienBadak'=>$modAsuransiPasienBadak,
												),true),
										'active'=>$model->is_asubadak,
									),   
								),
								'htmlOptions'=>array('style'=>(($model->is_asubadak)?'':'display:none')),
						)); 
						?>
						<?php 
						$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
								'id'=>'form-asudepartemen',
								'content'=>array(
									'content-asudepartemen'=>array(
										'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk Tampilkan Form')).'<b><span class="judulasuransi">Asuransi Departemen </span> </b> &nbsp &nbsp <span class="refreshasuransi">'
												 .CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>',array('class'=>'btn btn-danger btn-mini pull-center','onclick'=>'setAsuransiBadakReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk membersihkan field')).'</span>',
										'isi'=>
										$this->renderPartial($this->path_view.'_formAsuransiDepartemen',array(
												'form'=>$form,
												'model'=>$model,
												'modPasien'=>$modPasien,
												'modAsuransiPasienDepartemen'=>$modAsuransiPasienDepartemen,
												),true),
										'active'=>$model->is_asudepartemen,
									),   
								),
								'htmlOptions'=>array('style'=>(($model->is_asudepartemen)?'':'display:none')),
						)); 
						?>
						<?php 
						$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
								'id'=>'form-asupekerja',
								'content'=>array(
									'content-asupekerja'=>array(
										'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk Tampilkan Form')).'<b><span class="judulasuransi">Asuransi Pekerja PT. Badak LNG </span> </b> &nbsp &nbsp <span class="refreshasuransi">'
												 .CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>',array('class'=>'btn btn-danger btn-mini pull-center','onclick'=>'setAsuransiBadakReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk membersihkan field')).'</span>',
										'isi'=>
										$this->renderPartial($this->path_view.'_formAsuransiPekerja',array(
												'form'=>$form,
												'model'=>$model,
												'modPasien'=>$modPasien,
												'modAsuransiPasienPekerja'=>$modAsuransiPasienPekerja,
												'modPegawai'=>$modPegawai,
												),true),
										'active'=>$model->is_asupekerja,
									),   
								),
								'htmlOptions'=>array('style'=>(($model->is_asupekerja)?'':'display:none')),
						)); */
                        ?>

                        <?php /* $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
								'id'=>'form-riwayatpasien',
								'content'=>array(
									'content-riwayatpasien'=>array(
										'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan riwayat kunjungan pasien')).'<b>Riwayat Kunjungan Pasien</b>',
										'isi'=>$this->renderPartial($this->path_view.'_tableRiwayatPasien',array(
												'form'=>$form,
												'modPasien'=>$modPasien,
												),true),
										'active'=>true,
									),   
								),
						)); */ ?>

                    </div>

                </div>
            </div>
        </div>

        <div class="form-actions">
            <?php //JIKA TANPA VERIFIKASI >> echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onkeypress'=>'formSubmit(this,event)')); 
            ?>
            <?php
            if ($model->isNewRecord) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'if (!cekJamPoli()) return false; setVerifikasiJanjiPoli();', 'onkeypress' => 'if (!cekJamPoli()) return false; setVerifikasiJanjiPoli();')
                ); //formSubmit(this,event)
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'return false', 'onkeypress' => 'return false', 'disabled' => true, 'style' => 'cursor:not-allowed;')
                );
            }
            ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index'),
                array(
                    'class' => 'btn btn-default',
                    'onclick' => 'return refreshForm(this);'
                )
            ); ?>

            <?php
            $content = $this->renderPartial($this->path_view_booking . 'tips/tipsPendaftaranRawatJalan', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

            if (isset($model->pendaftaran_id)) {
                if (empty($model->pasien->nofingerprint)) {
                    //echo CHtml::htmlButton("Pendaftaran Sidik Jari",array('id'=>'regisFP','onclick' => "setRegisFP('".$model->pasien->no_rekam_medik."');", 'class'=>'btn btn-primary', 'style' => 'background:#ff0909;border:1px solid #ff0909;'));                    
                    //echo '<div id = "regisLoading" style = "width:50px;height:50px;"></div>';
                    //echo '<div id = "pesanRegis"></div>';
                }
            }
            ?>
        </div>

        <?php $this->endWidget(); ?>
        <?php // $this->renderPartial('_tablePendaftaranTerakhir', array()); 
        ?>


        <?php
        /*
    $autoopen = Yii::app()->user->getState('isantrian');
    if(!empty($model->pendaftaran_id)){
        $autoopen = false;
    }
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialog-panggilantrian',
        'options'=>array(
            'title'=>'No. Antrian',
            'autoOpen'=>$autoopen,
            'width'=>180,
            'resizable'=>false,
            'position'=>array("right",140),
        ),
    ));
    ?>
    <div class="dialog-content">
        <?php echo $this->renderPartial($this->path_view.'_formPanggilAntrian', array('modAntrian'=>$modAntrian)); ?>
    </div>

    <div style="text-align: center;">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-backward icon-white"></i>')),array('title'=>'Klik untuk menampilkan antrian sebelumnya','rel'=>'tooltip','class'=>'btn  btn-mini btn-danger','onclick'=>'setFormAntrian("prev");','style'=>'font-size:10px; width:24px; height:24px;')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-forward icon-white"></i>')),array('title'=>'Klik untuk menampilkan antrian berikutnya','rel'=>'tooltip','class'=>'btn  btn-mini btn-danger','onclick'=>'setFormAntrian("next");','style'=>'font-size:10px; width:24px; height:24px;')); ?>
            <?php //RND-1956 >>> echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-volume-down icon-white"></i>')),array('title'=>'Klik untuk membatalkan pemanggilan antrian ini','rel'=>'tooltip','class'=>'btn  btn-mini btn-danger', 'onclick'=>'if(requiredCheck(this)){ panggilAntrian("batal");}','style'=>'font-size:10px; width:24px; height:24px;')); ?>
            <?php // echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('title'=>'Klik untuk mengulang antrian','rel'=>'tooltip','class'=>'btn btn-mini btn-danger','onclick'=>'if(confirm("Apakah akan mengulang antrian ?")){setFormAntrian("reset");}','style'=>'font-size:10px; width:24px; height:24px;')); ?>
        <br>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Panggil',array('id'=>'btn-panggilantrian','{icon}'=>'<i class="icon-volume-up icon-white"></i>')),array('title'=>'Klik untuk memanggil antrian ini','rel'=>'tooltip','class'=>'btn  btn-mini btn-primary', 'onclick'=>'if(requiredCheck(this)){ panggilAntrian();}','style'=>'font-size:10px; width:128px; height:24px;')); ?>
    </div>
    <?php $this->endWidget(); */ ?>

        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialog-verifikasi',
            'options' => array(
                'title' => 'Verifikasi Pendaftaran',
                'autoOpen' => false,
                'modal' => true,
                'minWidth' => 960,
                'height' => 480,
                'resizable' => false,
            ),
        ));

        echo '<div class="dialog-content"></div>';
        ?>

        <div class="col-sm-12 clear">
            <div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Lanjutkan', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Lanjutkan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'disableOnSubmit(this); $("#pppendaftaran-t-form").submit();')); ?>
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')), array('title' => 'Batal', 'class' => 'btn btn-default', 'type' => 'button', 'onclick' => 'batalDialog("dialog-verifikasi");')); ?>
            </div>
        </div>

        <?php $this->endWidget(); ?>

        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogDiagnosa',
            'options' => array(
                'title' => 'Pencarian Diagnosa Rujukan',
                'autoOpen' => false,
                'modal' => true,
                'width' => 960,
                'height' => 480,
                'resizable' => false,
            ),
        ));
        $modDiagnosa = new PPDiagnosaM('search');
        $modDiagnosa->unsetAttributes();
        if (isset($_GET['PPDiagnosaM'])) {
            $modDiagnosa->attributes = $_GET['PPDiagnosaM'];
        }
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'diagnosa-m-grid',
            'dataProvider' => $modDiagnosa->search(),
            'filter' => $modDiagnosa,
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'Pilih',
                    'type' => 'raw',
                    'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                            "id" => "selectPasien",
                                            "onClick" => "
                                                if($(\"#content-bpjs\").hasClass(\"in\")){
                                                    setDiagnosaBpjs(\"$data->diagnosa_kode\",\"$data->diagnosa_nama\");
                                                }else{
                                                    setDiagnosa(\"$data->diagnosa_kode\",\"$data->diagnosa_nama\");
                                                }

                                                $(\"#dialogDiagnosa\").dialog(\"close\");
                                            "))',
                ),
                'diagnosa_kode',
                //'diagnosa_nama',
                array(
                    'header' => 'Nama',
                    'name' => 'diagnosa_namalainnya',
                ),

            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        $this->endWidget();
        ?>

        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogAsuransi',
            'options' => array(
                'title' => 'Pencarian Asuransi Pasien',
                'autoOpen' => false,
                'modal' => true,
                'width' => 960,
                'height' => 480,
                'resizable' => false,
            ),
        ));
        $modCariAsuransiPasien = new PPAsuransipasienM('search');
        $modCariAsuransiPasien->unsetAttributes();
        if (isset($_GET['PPAsuransipasienM'])) {
            $modCariAsuransiPasien->attributes = $_GET['PPAsuransipasienM'];
            isset($_GET['PPAsuransipasienM']['pasien_id']) ? $modCariAsuransiPasien->pasien_id = $_GET['PPAsuransipasienM']['pasien_id'] : '';
            isset($_GET['PPAsuransipasienM']['penjamin_id']) ? $modCariAsuransiPasien->penjamin_id = $_GET['PPAsuransipasienM']['penjamin_id'] : '';
        }
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'asuransi-m-grid',
            'dataProvider' => $modCariAsuransiPasien->searchDialog(),
            'filter' => $modCariAsuransiPasien,
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'Pilih',
                    'type' => 'raw',
                    'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                            "id" => "selectAsuransi",
                                            "onClick" => "
                                                $(\"#' . CHtml::activeId($modAsuransiPasien, 'asuransipasien_id') . '\").val($data->asuransipasien_id);
                                                $(\"#' . CHtml::activeId($modAsuransiPasien, 'nopeserta') . '\").val(\"$data->nopeserta\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasien, 'nokartuasuransi') . '\").val(\"$data->nokartuasuransi\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasien, 'namapemilikasuransi') . '\").val(\"$data->namapemilikasuransi\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasien, 'jenispeserta_id') . '\").val(\"$data->jenispeserta_id\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasien, 'nomorpokokperusahaan') . '\").val(\"$data->nomorpokokperusahaan\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasien, 'namaperusahaan') . '\").val(\"$data->namaperusahaan\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasien, 'kelastanggunganasuransi_id') . '\").val(\"$data->kelastanggunganasuransi_id\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasien, 'nominal_tanggungan') . '\").val(formatNumber(\"$data->nominal_tanggungan\"));
                                                setAsuransiLama()
                                                $(\"#dialogAsuransi\").dialog(\"close\");
                                            "))',
                ),
                'nokartuasuransi',
                'nopeserta',
                array(
                    'header' => 'Nama Pemilik Asuransi',
                    'value' => '$data->namapemilikasuransi',
                    'filter' => CHtml::activeHiddenField($modCariAsuransiPasien, 'pasien_id', array('readonly' => true)) . "" . CHtml::activeHiddenField($modCariAsuransiPasien, 'penjamin_id', array('readonly' => true)) . "" . CHtml::activeTextField($modCariAsuransiPasien, 'namapemilikasuransi', array()),
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                'namaperusahaan',
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        $this->endWidget();
        ?>

        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogAsuransiBpjs',
            'options' => array(
                'title' => 'Pencarian Asuransi Pasien BPJS',
                'autoOpen' => false,
                'modal' => true,
                'width' => 960,
                'height' => 480,
                'resizable' => false,
            ),
        ));
        $modCariAsuransiPasienBpjs = new PPAsuransipasienbpjsM('search');
        $modCariAsuransiPasienBpjs->unsetAttributes();
        if (isset($_GET['PPAsuransipasienbpjsM'])) {
            $modCariAsuransiPasienBpjs->attributes = $_GET['PPAsuransipasienbpjsM'];
            isset($_GET['PPAsuransipasienbpjsM']['pasien_id']) ? $modCariAsuransiPasienBpjs->pasien_id = $_GET['PPAsuransipasienbpjsM']['pasien_id'] : '';
            isset($_GET['PPAsuransipasienbpjsM']['penjamin_id']) ? $modCariAsuransiPasienBpjs->penjamin_id = $_GET['PPAsuransipasienbpjsM']['penjamin_id'] : '';
        }
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'asuransibpjs-m-grid',
            'dataProvider' => $modCariAsuransiPasienBpjs->searchDialog(),
            'filter' => $modCariAsuransiPasienBpjs,
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'Pilih',
                    'type' => 'raw',
                    'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                            "id" => "selectAsuransi",
                                            "onClick" => "
                                                $(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'asuransipasien_id') . '\").val($data->asuransipasien_id);
                                                $(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'nopeserta') . '\").val(\"$data->nopeserta\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'nokartuasuransi') . '\").val(\"$data->nokartuasuransi\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'namapemilikasuransi') . '\").val(\"$data->namapemilikasuransi\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'jenispeserta_id') . '\").val(\"$data->jenispeserta_id\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'nomorpokokperusahaan') . '\").val(\"$data->nomorpokokperusahaan\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'namaperusahaan') . '\").val(\"$data->namaperusahaan\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'kelastanggunganasuransi_id') . '\").val(\"$data->kelastanggunganasuransi_id\");
                                                getAsuransiNoKartu(\'$data->nopeserta\');
                                                setAsuransiLama()
                                                $(\"#dialogAsuransiBpjs\").dialog(\"close\");
                                            "))',
                ),
                'nokartuasuransi',
                'nopeserta',
                array(
                    'header' => 'Nama Pemilik Asuransi',
                    'value' => '$data->namapemilikasuransi',
                    'filter' => CHtml::activeHiddenField($modCariAsuransiPasienBpjs, 'pasien_id', array('readonly' => true)) . "" . CHtml::activeHiddenField($modCariAsuransiPasienBpjs, 'penjamin_id', array('readonly' => true)) . "" . CHtml::activeTextField($modCariAsuransiPasienBpjs, 'namapemilikasuransi', array()),
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                'namaperusahaan',
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        $this->endWidget();
        ?>
        <?php echo $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai, 'modPenanggungJawab' => $modPenanggungJawab, 'modRujukan' => $modRujukan, 'modRujukanBpjs' => $modRujukanBpjs, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs, 'modSep' => $modSep, 'modAsuransiPasienBadak' => $modAsuransiPasienBadak, 'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen, 'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja, 'ruangan' => $ruangan)); ?>
        <?php echo $this->renderPartial($this->path_view_booking . '_jsFunctions', array('model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai, 'modPenanggungJawab' => $modPenanggungJawab, 'modRujukan' => $modRujukan, 'modRujukanBpjs' => $modRujukanBpjs, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs, 'modSep' => $modSep, 'modAsuransiPasienBadak' => $modAsuransiPasienBadak, 'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen, 'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja, 'ruangan' => $ruangan)); ?>

    </div>
</div>