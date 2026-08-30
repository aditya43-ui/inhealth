<div class="panel panel-success search-form">
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
            'type' => 'horizontal',
            'id' => 'searchInfoKunjungan',
            'focus' => '#' . CHtml::activeId($modPPInfoKunjunganV, 'kabupaten_id'),
            'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
        ));
        ?>
        <style>
            table {
                margin-bottom: 0;
            }

            .form-actions {
                padding: 4px;
                margin-top: 5px;
            }

            .nav-tabs>li>a {
                display: block;
                cursor: pointer;
            }

            .nav-tabs>.active a:hover {
                cursor: pointer;
            }
        </style>

        <div class="row">
            <div class="col-sm-6">
                <?php echo CHtml::hiddenField('type', ''); ?>
                <?php //echo CHtml::label('Periode Laporan', 'tglmasukpenunjang', array('class' => 'control-label')) 
                ?>
                <!--<div class="controls">
            <?php //echo $form->dropDownList($modPPInfoKunjunganV, 'jns_periode', array('hari' => 'Hari', 'bulan' => 'Bulan', 'tahun' => 'Tahun'), array('class' => 'span2', 'onchange' => 'ubahJnsPeriode();')); 
            ?>
        </div>-->
                <div class="control-group">
                    <?php echo $form->hiddenField($modPPInfoKunjunganV, 'jns_periode', array('class' => 'span2')); ?>
                    <?php echo $form->hiddenField($modPPInfoKunjunganV, 'bln_awal', array('class' => 'span2')); ?>
                    <?php echo $form->hiddenField($modPPInfoKunjunganV, 'bln_akhir', array('class' => 'span2')); ?>
                    <?php echo $form->hiddenField($modPPInfoKunjunganV, 'thn_awal', array('class' => 'span2')); ?>
                    <?php echo $form->hiddenField($modPPInfoKunjunganV, 'thn_akhir', array('class' => 'span2')); ?>
                    <?php echo CHtml::label("Periode Laporan", 'tgl_rekam', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($modPPInfoKunjunganV->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($modPPInfoKunjunganV->tgl_akhir)) ?>">
                            <i class="entypo-calendar"></i>
                            <span><?php echo date('d M Y', strtotime($modPPInfoKunjunganV->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($modPPInfoKunjunganV->tgl_akhir)) ?></span>
                            <?php echo $form->hiddenField($modPPInfoKunjunganV, 'tgl_awal', array('class' => 'start')) ?>
                            <?php echo $form->hiddenField($modPPInfoKunjunganV, 'tgl_akhir', array('class' => 'end')) ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Jenis Penjamin', 'carabayar_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($modPPInfoKunjunganV, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAll('carabayar_aktif = true ORDER BY carabayar_nama ASC'), 'carabayar_id', 'carabayar_nama'), array(
                            'class' => 'form-control', 'multiple' => 'multiple'
                        )) ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Penjamin', 'penjamin_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList(
                            $modPPInfoKunjunganV,
                            'penjamin_id',
                            array(),
                            array('class' => 'form-control', 'multiple' => 'multiple')
                        ) ?>
                    </div>
                </div>
                <?php
                /*$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'big',
//                                    'disabled'=>true,
                        'content' => array(
                            'content1' => array(
								'multi' => 'multi',
                                'header' => 'Berdasarkan Wilayah',
                                'isi' => CHtml::hiddenField('filter', 'wilayah').
											'<div class="control-group">
												'.CHtml::label('Provinsi','carabayar_id', array('class' => 'control-label')).' 
												<div class="controls">
													'.$form->dropDownList($modPPInfoKunjunganV,'propinsi_id',CHtml::listData(PropinsiM::model()->findAll('propinsi_aktif = true ORDER BY propinsi_nama  ASC'), 'propinsi_id', 'propinsi_nama'),array(
													'class'=>'form-control', 'multiple'=>'multiple')).'											
												</div>
											</div>
											<div class="control-group">
												'.CHtml::label('Kabupaten','penjamin_id', array('class' => 'control-label')).' 
												<div class="controls">												 
													'.$form->dropDownList($modPPInfoKunjunganV,'kabupaten_id',
															array(),
															array('class'=>'form-control', 'multiple'=>'multiple')).' 													
												</div>
											</div>',
                                'active' => true,
                            ),),
//                                    'htmlOptions'=>array('class'=>'aw',)
                    ));
<div class="control-group">
			<?php echo CHtml::label('Provinsi','carabayar_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->dropDownList($modPPInfoKunjunganV,'propinsi_id',CHtml::listData(PropinsiM::model()->findAll('propinsi_aktif = true ORDER BY propinsi_nama  ASC'), 'propinsi_id', 'propinsi_nama'),array(
				'class'=>'form-control', 'multiple'=>'multiple')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Kabupaten','penjamin_id', array('class' => 'control-label')); ?>
			<div class="controls">												 
				<?php 
					echo $form->dropDownList($modPPInfoKunjunganV,'kabupaten_id',
						array(),
						array('class'=>'form-control', 'multiple'=>'multiple')) 
				?>
			</div>
		</div>
					 * 
					 * 					 */
                ?>

            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $insDrop = new CDbCriteria();
                        $insDrop->addCondition(" instalasi_aktif = TRUE ");
                        $insDrop->addInCondition(" instalasi_id ", Params::getArrayInstalasiPelayanan());
                        $insDrop->order = " instalasi_nama ASC ";

                        echo $form->dropDownList($modPPInfoKunjunganV, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll($insDrop), 'instalasi_id', 'instalasi_nama'), array(
                            'class' => 'form-control', 'multiple' => 'multiple'
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList(
                            $modPPInfoKunjunganV,
                            'ruangan_id',
                            array(),
                            array('class' => 'form-control', 'multiple' => 'multiple')
                        ); ?>
                    </div>
                </div>
                <?php
                /*$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'kunjungan',
                    'slide' => true,
                    'content' => array(
                        'content2' => array(
							'multi' => 'multi',
                            'header' => 'Berdasarkan Jenis Penjamin',
                            'isi' => CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) . 
									'<div class="control-group">
												'.CHtml::label('Jenis Penjamin','carabayar_id', array('class' => 'control-label')).' 
												<div class="controls">
													'.$form->dropDownList($modPPInfoKunjunganV,'carabayar_id',CHtml::listData(CarabayarM::model()->findAll('carabayar_aktif = true ORDER BY carabayar_nama ASC'), 'carabayar_id', 'carabayar_nama'),array(
													'class'=>'form-control', 'multiple'=>'multiple')).'											
												</div>
											</div>
											<div class="control-group">
												'.CHtml::label('Penjamin','penjamin_id', array('class' => 'control-label')).' 
												<div class="controls">												 
													'.$form->dropDownList($modPPInfoKunjunganV,'penjamin_id',
															array(),
															array('class'=>'form-control', 'multiple'=>'multiple')).' 													
												</div>
											</div>',
                            'active' => true,
                        ),
                    ),
//                                    'htmlOptions'=>array('class'=>'aw',)
                ));*/

                ?>

                <div class="control-group">
                    <?php echo CHtml::label('Dokter', 'ruangan_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList(
                            $modPPInfoKunjunganV,
                            'pegawai_id',
                            DokterV::model()->getDropDokterResep(),
                            array('class' => 'form-control', 'multiple' => 'multiple')
                        ); ?>
                    </div>
                </div>
                <?php /*$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                            'id'=>'instalasi',							
//                                    'disabled'=>true,
                            'content'=>array(
                                'content3'=>array(
									'multi' => 'multi',
                                    'header'=>'Berdasarkan Instalasi/Ruangan',
                                    'isi'=>'<div class="control-group">
												'.CHtml::label('Instalasi','instalasi_id', array('class' => 'control-label')).' 
												<div class="controls">
													'.$form->dropDownList($modPPInfoKunjunganV,'instalasi_id',CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'),array(
													'class'=>'form-control', 'multiple'=>'multiple')).'											
												</div>
											</div>
											<div class="control-group">
												'.CHtml::label('Ruangan','ruangan_id', array('class' => 'control-label')).' 
												<div class="controls">												 
													'.$form->dropDownList($modPPInfoKunjunganV,'ruangan_id',
															array(),
															array('class'=>'form-control', 'multiple'=>'multiple')).' 													
												</div>
											</div>',
//                                                       
                                    'active'=>true,
                                    ),   ),
//                                    'htmlOptions'=>array('class'=>'aw',)
                    ));*/ ?>

            </div>
        </div>



        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
            );
            ?>
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            );
            ?>
        </div>
    </div>
</div>
<?php //$this->widget('UserTips', array('type' => 'create')); 
?>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>


<?php
$urlPeriode = $this->createUrl('GantiPeriode');
$js = <<< JSCRIPT

function setPeriode(){
    namaPeriode = $('#PeriodeName').val();
    
        $.post('${urlPeriode}',{namaPeriode:namaPeriode},function(data){
            $('#PPBukuregisterpasienV_tgl_awal').val(data.periodeawal);
            $('#PPBukuregisterpasienV_tgl_akhir').val(data.periodeakhir);
            $('#PPRuanganM_tgl_awal').val(data.periodeawal);
            $('#PPRuanganM_tgl_akhir').val(data.periodeakhir);
//            if(data.namaPeriode == 1 ){
//                myAlert("Pencarian Berdasarkan : "+data.namaPeriode);
//            }
        },'json');
}

JSCRIPT;
Yii::app()->clientScript->registerScript('setPeriode', $js, CClientScript::POS_HEAD);
?>
<script>
    function checkPilihan(event) {
        var namaPeriode = $('#PeriodeName').val();

        if (namaPeriode == '') {
            myAlert('Silakan pilih kategori pencarian!');
            event.preventDefault();
            $('#dtPicker3').datepicker("hide");
            return true;;
        }
    }
</script>
<script>
    function checkAll() {
        if ($('#checkAllRuangan').is(':checked')) {
            $('#searchInfoKunjungan input[name*="ruangan_id"]').each(function() {
                $(this).attr('checked', true);
            });
        } else {
            $('#searchInfoKunjungan input[name*="ruangan_id"]').each(function() {
                $(this).removeAttr('checked');
            });
        }
    }
</script>