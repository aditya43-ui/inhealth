<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian <i class="entypo-search"></i>
        </div>
    </div>
    <div class="panel-body">
        <div class="search-form">
            <?php
            $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'action' => Yii::app()->createUrl($this->route),
                'method' => 'get',
                'type' => 'horizontal',
                'id' => 'searchInfoKunjungan',
                'focus' => '#' . CHtml::activeId($modPPInfoKunjunganV, 'instalasi_id'),
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
            <!--<legend>Kunjungan</legend>-->


            <div class="row">
                <div class="col-sm-6">
                    <?php echo CHtml::hiddenField('type', ''); ?>
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
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $criIns = new CDbCriteria();
                            $criIns->addInCondition(" instalasi_id ", Params::getArrayInstalasiPelayanan());
                            $criIns->addCondition(" instalasi_aktif = TRUE ");
                            $criIns->order = " instalasi_nama ASC ";

                            echo $form->dropDownList($modPPInfoKunjunganV, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll($criIns), 'instalasi_id', 'instalasi_nama'), array(
                                'class' => 'form-control', 'multiple' => 'multiple'
                            )); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Spesialis', 'spesialis_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $modJenis = new PPPendaftaranT();
                            echo $form->dropDownList($modPPInfoKunjunganV, 'spesialis_id', CHtml::listData($modJenis->getJenisKasusPenyakitItems(), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'), array(
                                'class' => 'form-control', 'multiple' => 'multiple'
                            )); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList(
                                $modPPInfoKunjunganV,
                                'ruangan_id',
                                array(),
                                array('class' => 'form-control', 'multiple' => 'multiple')
                            ); ?>
                        </div>
                    </div>
                    <div class="control-group">
                       <?php echo CHtml::label('Pegawai Loket', 'create_loginpemakai_id', array('class' => 'control-label')); ?>
                       <div class="controls">
                           <?php
                        //    $pencarianpegawai = $modPPInfoKunjunganV->searchTableLaporan2()->data;
                        //    $pegawai = array();
             
                        //    if(!empty($pencarianpegawai)){
                        //        foreach($pencarianpegawai as $i => $cari){
                        //            $dataPegawai = LoginpemakaiK::model()->findByPk($cari->create_loginpemakai_id);
                        //            if(!empty($dataPegawai)){
                        //                 $pegawai[$i]['pegawai_id'] = $dataPegawai->pegawai_id;
                        //                 $pegawai[$i]['pegawai_nama'] = $dataPegawai->nama_pegawai;
                        //            }
                                   
                        //        }
                        //    }
                           echo $form->dropDownList($modPPInfoKunjunganV, 'create_loginpemakai_id', CHtml::listData(PPLaporankarcispasien::model()->findAll(), 'create_loginpemakai_id', 'petugas_loket'), array(
                            'class' => 'form-control', 'multiple' => 'multiple',
                           )); ?>
                       </div>
                   </div>
                    <?php /*$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
					'id'=>'big',							
//                                    'disabled'=>true,
					'content'=>array(
						'content12'=>array(
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
        </div>


        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
            );
            ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>
        </div>
        <?php //$this->widget('UserTips', array('type' => 'create')); 
        ?>
    </div>
</div>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php
$urlAjax = $this->createUrl('GetRuanganDariInstalasi', array('encode' => false, 'namaModel' => get_class($modPPInfoKunjunganV)));
Yii::app()->clientScript->registerScript(
    'numbers',
    '
    $("#' . CHtml::activeId($modPPInfoKunjunganV, 'instalasi_id') . '").change(function(){
        $.ajax({
            type:"POST",
            data:$("#searchInfoKunjungan").serialize(),
            url:"' . $urlAjax . '",
            success:function(data){
                $("#' . CHtml::activeId($modPPInfoKunjunganV, 'ruangan_id') . '").html("<option value>-- Pilih --</pilih>"+data)
            }
        });
    })
',
    CClientScript::POS_READY
); ?>

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