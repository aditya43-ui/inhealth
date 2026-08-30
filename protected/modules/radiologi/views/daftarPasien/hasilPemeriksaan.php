<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Pencatatan Hasil Pemeriksaan Radiologi
        </div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'hasilpmeriksaan-radiologi-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => false,
            'type' => 'horizontal',
            'focus' => '#kolHasil_0',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
        ?>
        <?php
        $this->widget('bootstrap.widgets.BootAlert');
        $this->renderPartial('../_ringkasDataPasien', array('modPasienMasukPenunjang' => $modPasienMasukPenunjang));
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Riwayat Pasien</div>
            </div>
            <div class="panel-body">
            <fieldset class="box">
            <div class="row">
                <div class="col-sm-4">
                    <?php
                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'riwayat-anamnesa',
                        'content' => array(
                            'content-riwayat-anamnesa' => array(
                                'header' => '<b>Riwayat Anamnesa</b>',
                                'isi' => $this->renderPartial('_riwayat_anamnesa', array('modAnamnesa' => $modAnamnesa), true),
                                'active' => false,
                            ),
                        ),
                    ));
                    ?>
                </div>
                <div class="col-sm-4">
                    <?php
                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'riwayat-pemeriksaan-fisik',
                        'content' => array(
                            'content-riwayat-pemeriksaan-fisik' => array(
                                'header' => '<b>Riwayat Pemeriksaan Fisik</b>',
                                'isi' => $this->renderPartial('_riwayat_pemeriksaan_fisik', array('modPemeriksaan' => $modPemeriksaan), true),
                                'active' => false,
                            ),
                        ),
                    ));
                    ?>
                </div>
                <div class="col-sm-4">
                    <?php
                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'riwayat-diagnosa',
                        'content' => array(
                            'content-riwayat-diagnosa' => array(
                                'header' => '<b>Riwayat Diagnosa</b>',
                                'isi' => $this->renderPartial('_riwayat_diagnosa', array('modPasienMorbiditas' => $modPasienMorbiditas, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang), true),
                                'active' => false,
                            ),
                        ),
                    ));
                    ?>
                </div>
             
            </div>
            <div class="col-sm-12">
            <?php
            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'riwayat-expertise',
                'content' => array(
                    'content-riwayat-expertise' => array(
                        'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan riwayat hasil expertise')) . '<b> Riwayat Hasil Expertise</b>',
                        'isi' => $this->renderPartial('_riwayat_expertise', array('modHasilpemeriksaanRad' => $modHasilpemeriksaanRad, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang), true),
                        'active' => false,
                    ),
                ),
            ));
            ?>  
        </div>
        </div>
        </div>
      
        </fieldset>
    
        <?php
        $no = 0;
        foreach ($modHasilpemeriksaanRad as $i => $hasil):

            $refHasilRad = ROReferensiHasilRadM::model()->findByAttributes(array('pemeriksaanrad_id' => $hasil->pemeriksaanrad_id, 'refhasilrad_banyak' => true));
            $refHasilDet = null;


            if (!empty($refHasilRad)) {
                //$refHasilDet = ROReferensihasildetM::model()->findAllByAttributes(array('refhasilrad_id'=>$refHasilRad->refhasilrad_id, 'refhasildet_aktif'=>true),array('order'=>'refhasildet_urut ASC'));
                $criDet = new CDbCriteria();
                $criDet->select = " t.*"; //hp.hasilpemeriksaanrad_id, pr.hasperiksaraddet_id, pr.hasperiksaraddet_expertise 
                //$criDet->join = " JOIN hasilperiksaraddet_t pr ON pr.refhasildet_id = t.refhasildet_id "
                //			.	" JOIN hasilpemeriksaanrad_t hp ON  hp.hasilpemeriksaanrad_id = pr.hasilpemeriksaanrad_id "
                //			.   "  ";
                $criDet->addCondition(" refhasilrad_id = " . $refHasilRad->refhasilrad_id . " AND  refhasildet_aktif = TRUE ");
                $criDet->addCondition(" t.refhasildet_jk = '" . $hasil->pasien->jeniskelamin . "' OR  t.refhasildet_jk = '' ");
                //$criDet->addCondition(" hp.pasienmasukpenunjang_id = ".$hasil->pasienmasukpenunjang_id."  ");
                $criDet->order = " refhasildet_urut ASC ";
                $refHasilDet = ROReferensihasildetM::model()->findAll($criDet);
            }
            //var_dump(count($refHasilDet));
            if (!empty($refHasilDet)) {
                echo $this->renderPartial('template/_templateHasilDet', array('i' => $i, 'hasil' => $hasil, 'refHasilDet' => $refHasilDet), true);
                //if ( $hasil->pemeriksaanrad_id == Params::PEMERIKSAAN_RAD_UPPER_LOWER_ABDOMEN || $hasil->pemeriksaanrad_id == Params::PEMERIKSAAN_RAD_UPPER_LOWER ){
                //   echo $this->renderPartial('template/_templateUpperLowerAbd',array('i'=>$i,'hasil'=>$hasil),true);
                // }elseif ($hasil->pemeriksaanrad_id == Params::PEMERIKSAAN_RAD_UROLOGI){
                //   echo $this->renderPartial('template/_templateUrologi',array('i'=>$i,'hasil'=>$hasil),true);
                // }elseif ($hasil->pemeriksaanrad_id == Params::PEMERIKSAAN_RAD_THORAX_PA){
                //   echo $this->renderPartial('template/_templateThoraxPa',array('i'=>$i,'hasil'=>$hasil),true);
            } else {
                if (!empty($_GET['baru'])) {
                    ?>
                    <table width="100%"  id="tblFormHasilPemeriksaanRad_<?php echo $no++; ?>" class="table table-bordered table-striped table-condensed">
                        <thead>
                            <tr>
                                <th>
                                    <?php
                                    $criRadioligi = new CDbCriteria();
                                    $criRadioligi->addCondition("pendaftaran_id = :pendaftaran_id AND pasienmasukpenunjang_id = :pasienmasukpenunjang_id");
                                    $criRadioligi->params[':pendaftaran_id'] = $_GET['pendaftaran_id'];
                                    $criRadioligi->params[':pasienmasukpenunjang_id'] = $_GET['pasienmasukpenunjang_id'];
                                    $modpemeriksaanRad = ROHasilpemeriksaanradT::model()->find($criRadioligi);

                                    if (!empty($modpemeriksaanRad) && !empty($modpemeriksaanRad->tglverifikasi_dpjp)) {
                                        ?>
                                        <div style="text-align: center; font-size: 11pt;">
                                            <?php echo CHtml::link("<i class='" . MyIcon::getIcons('cetak') . "'></i> Cetak", 'javascript:;', array('rel' => 'tooltip', 'title' => 'Klik button/ikon ini, jika anda ingin mencetak hasil pemeriksaan ini ', 'data-html' => true, 'onclick' => 'printPemeriksaaRad(' . $hasil->hasilpemeriksaanrad_id . ',\'PRINT\')', 'class' => 'btn btn-info', 'style' => 'color:#fff !important;', 'disabled' => true)); ?>
                                            <?php
                                            echo CHtml::link(Yii::t('mds', '{icon} Second Opinion', array('{icon}' => '<i class="entypo-plus"></i>')), $this->createUrl($this->id . '/hasilPemeriksaan&pendaftaran_id=' . $_GET['pendaftaran_id'] . '&pasien_id=' . $_GET['pasien_id'] . '&pasienmasukpenunjang_id=' . $_GET['pasienmasukpenunjang_id'] . '&baru="baru"'), array('class' => 'btn btn-danger',
                                                'onclick' => 'return tambahbaru(this);',
                                                "rel" => "tooltip",
                                                'disabled' => true,
                                                "title" => "Klik untuk tambah data second opinion", 'style' => 'color:#fff !important'));
                                            ?>
                                        </div>
                                    <?php } else {
                                        ?>
                                        <div style="text-align: center; font-size: 11pt;"> <?php
                                            echo CHtml::link(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-print"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''), array('class' => 'btn btn-info', 'style' => 'color:#fff !important;',
                                                'onclick' => 'myAlert("Hasil Expertise Perlu Verifikasi DPJTM"); return false;'));
                                            ?>
                                        </div>    
                                        <?php
                                    }
                                    ?>


                                </th>
                                <th colspan="5"><div style="text-align: center; font-size: 11pt;">
                                    <a href="javascript:void(0);" onclick="ambilReferensi(<?php echo $hasil->pemeriksaanrad_id; ?>,<?php echo $i; ?>);return false;" rel="tooltip" title="Klik untuk hasil Referensi"><?php echo $hasil->pemeriksaanrad->jenispemeriksaanrad->jenispemeriksaanrad_nama; ?> : <?php echo $hasil->pemeriksaanrad->pemeriksaanrad_nama; ?></a>
                                    <div style="text-align: center; font-size: 11pt; width:15%; float:right;">
                                        <?php echo CHtml::link('Referensi', 'javascript:;', array('rel' => 'tooltip', 'title' => 'Klik untuk hasil Referensi', 'data-html' => true, 'onclick' => "refreshDialog(" . $hasil->pemeriksaanrad_id . "," . $i . ");return false;", 'class' => 'btn btn-info', 'style' => 'color:#fff !important;')); ?>       </tr>
                        </thead>
                        <tr>
                            <td style="font-size:10pt; ">
                                <?php echo CHtml::css('ul.redactor_toolbar{z-index:10;}'); ?>
                                <?php // echo $hasil->pemeriksaanrad->jenispemeriksaanrad->jenispemeriksaanrad_nama; ?> 
                                Hasil Expertise<br/>
                                <b><?php // echo $hasil->pemeriksaanrad->pemeriksaanrad_nama;   ?></b> <br/>
                                <?php echo CHtml::activeHiddenField($hasil, "[$i]hasilpemeriksaanrad_id", array('readonly' => true)); ?>
                                <?php // echo $hasil->tglpemeriksaanrad; ?>
                            </td>
                            <td id="kolHasil_<?php echo $i; ?>" style="text-align:center;">
                                <?php // echo CHtml::activeTextArea($hasil, "[$i]hasilexpertise", array('rows'=>3, 'style'=>'width:750px; font-size:11pt;', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                                <?php
                                
                                
                                
                                //            echo $i;
                                if ($i == 0) {
                                    $this->widget('ext.redactorjs.Redactor', array('model' => $hasil, 'attribute' => '[' . $i . ']hasilexpertise', 'name' => 'ROHasilPemeriksaanRadT_' . $i . '_hasilexpertise', 'toolbar' => 'mini', 'height' => '300px'));
                                } else {
                                    $this->widget('ext.redactorjs.Redactor', array('model' => $hasil, 'attribute' => '[' . $i . ']hasilexpertise', 'name' => 'ROHasilPemeriksaanRadT_' . $i . '_hasilexpertise', 'toolbar' => 'mini', 'height' => '300px'));
                                }
                                ?>
                            </td>
                            <!--<td rowspan="2" style="text-align:center; vertical-align: middle;"><?php //echo CHtml::button('Referensi', array('onclick'=>"ambilReferensi($hasil->pemeriksaanrad_id,$i);return false;",'class'=>'btn btn-info','disabled'=>false, 'onkeypress'=>"return $(this).focusNextInputField(event)"));   ?></td>-->
                        </tr>
                            <tr>
                            <td style="font-size:10pt; ">Kesimpulan</td>
                            <td id="kolKesimpulan_<?php echo $i; ?>" style="text-align:center;">: 
                                <?php // echo CHtml::activeTextArea($hasil, "[$i]kesimpulan_hasilrad", array('rows'=>3, 'style'=>'width:750px; font-size:11pt;', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $hasil, 'attribute' => '[' . $i . ']kesimpulan_hasilrad', 'name' => 'ROHasilPemeriksaanRadT_' . $i . '_kesimpulan_hasilrad', 'toolbar' => 'mini', 'height' => '300px')) ?>
                            </td>
                        </tr>
                    </table>
                    <?php
                } else {
                    ?>
                    <table width="100%"  id="tblFormHasilPemeriksaanRad_<?php echo $no++; ?>" class="table table-bordered table-striped table-condensed">
                        <thead>
                            <tr>
                                <th>
                                    <?php
                                    $criRadioligi = new CDbCriteria();
                                    $criRadioligi->addCondition("pendaftaran_id = :pendaftaran_id AND pasienmasukpenunjang_id = :pasienmasukpenunjang_id");
                                    $criRadioligi->params[':pendaftaran_id'] = $_GET['pendaftaran_id'];
                                    $criRadioligi->params[':pasienmasukpenunjang_id'] = $_GET['pasienmasukpenunjang_id'];
                                    $modpemeriksaanRad = ROHasilpemeriksaanradT::model()->find($criRadioligi);

                                    if (!empty($modpemeriksaanRad) && !empty($modpemeriksaanRad->tglverifikasi_dpjp)) {
                                        ?>
                                        <div style="text-align: center; font-size: 11pt;">
                                            <?php echo CHtml::link("<i class='" . MyIcon::getIcons('cetak') . "'></i> Cetak", 'javascript:;', array('rel' => 'tooltip', 'title' => 'Klik button/ikon ini, jika anda ingin mencetak hasil pemeriksaan ini ', 'data-html' => true, 'onclick' => 'printPemeriksaaRad(' . $hasil->hasilpemeriksaanrad_id . ',\'PRINT\')', 'class' => 'btn btn-info', 'style' => 'color:#fff !important;')); ?>
                                            <?php
                                            $cek = HasilpemeriksaanradR::model()->findAllByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id'], 'pasien_id' => $_GET['pasien_id'], 'pasienmasukpenunjang_id' => $_GET['pasienmasukpenunjang_id']));
                                            if (count($cek) == 2) {
                                                echo '&nbsp;';
                                            } else {
                                                echo CHtml::link(Yii::t('mds', '{icon} Second Opinion', array('{icon}' => '<i class="entypo-plus"></i>')), $this->createUrl($this->id . '/hasilPemeriksaan&pendaftaran_id=' . $_GET['pendaftaran_id'] . '&pasien_id=' . $_GET['pasien_id'] . '&pasienmasukpenunjang_id=' . $_GET['pasienmasukpenunjang_id'] . '&baru="baru"'), array('class' => 'btn btn-danger',
                                                    'onclick' => 'return tambahbaru(this);',
                                                    "rel" => "tooltip",
                                                    "title" => "Klik untuk tambah data second opinion", 'style' => 'color:#fff !important'));
                                            }
                                            ?>
                                        </div>
                                    <?php } else {
                                        ?>
                                        <div style="text-align: center; font-size: 11pt;"> 
                                            <?php
                                            echo CHtml::link(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-print"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''), array('class' => 'btn btn-info', 'style' => 'color:#fff !important;',
                                                'onclick' => 'myAlert("Hasil Expertise Perlu Verifikasi DPJTM"); return false;'));
                                            ?>
                                        </div>    
                                        <?php
                                    }
                                    ?>
                        <?php //echo CHtml::link('<i class="' . MyIcon::getIcons('cetak') . '"></i> Cetak', 'javascript:;', array('rel' => 'tooltip', 'title' => 'Klik button/ikon ini, jika Anda ingin mencetak hasil pemeriksaan ini ', 'data-html' => true, 'onclick' => 'printPemeriksaaRad(' . $hasil->hasilpemeriksaanrad_id . ",'PRINT')", 'class' => 'btn btn-info', 'style' => 'color:#fff !important;')); ?>
                                </div>
                                </th>
                                <th colspan="5">
                                <div style="text-align: center; font-size: 11pt;">
                                    <a href="javascript:void(0);" onclick="ambilReferensi(<?php echo $hasil->pemeriksaanrad_id; ?>,<?php echo $i; ?>);return false;" rel="tooltip" title="Klik untuk hasil Referensi"><?php echo $hasil->pemeriksaanrad->jenispemeriksaanrad->jenispemeriksaanrad_nama; ?> : <?php echo $hasil->pemeriksaanrad->pemeriksaanrad_nama; ?></a>
                                    <div style="text-align: center; font-size: 11pt; width:15%; float:right;">
                                        <?php echo CHtml::link('Referensi', 'javascript:;', array('rel' => 'tooltip', 'title' => 'Klik untuk hasil Referensi', 'data-html' => true, 'onclick' => "refreshDialog(" . $hasil->pemeriksaanrad_id . "," . $i . ");return false;", 'class' => 'btn btn-info', 'style' => 'color:#fff !important;')); ?>
                                    </div>
                                </div>
                            </th> 
                                  </tr>
                        </thead>
                        <tr>
                            <td style="font-size:10pt; ">
                                <?php echo CHtml::css('ul.redactor_toolbar{z-index:10;}'); ?>
                                <?php // echo $hasil->pemeriksaanrad->jenispemeriksaanrad->jenispemeriksaanrad_nama;  ?> 
                                Hasil Expertise<br/>
                                <b><?php // echo $hasil->pemeriksaanrad->pemeriksaanrad_nama;   ?></b> <br/>
                                <?php echo CHtml::activeHiddenField($hasil, "[$i]hasilpemeriksaanrad_id", array('readonly' => true)); ?>
                                <?php // echo $hasil->tglpemeriksaanrad; ?>
                            </td>
                            <td id="kolHasil_<?php echo $i; ?>" style="text-align:center;">
                                <?php // echo CHtml::activeTextArea($hasil, "[$i]hasilexpertise", array('rows'=>3, 'style'=>'width:750px; font-size:11pt;', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                                <?php
                                
                                $refHasilRad = ROReferensiHasilRadM::model()->findByAttributes(array('pemeriksaanrad_id' => $hasil->pemeriksaanrad_id, 'refhasilrad_banyak' => false));
                                                                
                                if (empty(trim($hasil->hasilexpertise))){
                                    if (!empty($refHasilRad)){
                                        $hasil->hasilexpertise = $refHasilRad->refhasilrad_hasil;
                                        $hasil->kesan_hasilrad = $refHasilRad->refhasilrad_kesan;
                                        $hasil->kesimpulan_hasilrad = $refHasilRad->refhasilrad_kesimpulan;
                                    }
                                    
                                }
                                
                                //            echo $i;
                                if ($i == 0) {
                                    $this->widget('ext.redactorjs.Redactor', array('model' => $hasil, 'attribute' => '[' . $i . ']hasilexpertise', 'name' => 'ROHasilPemeriksaanRadT_' . $i . '_hasilexpertise', 'toolbar' => 'mini', 'height' => '300px'));
                                } else {
                                    $this->widget('ext.redactorjs.Redactor', array('model' => $hasil, 'attribute' => '[' . $i . ']hasilexpertise', 'name' => 'ROHasilPemeriksaanRadT_' . $i . '_hasilexpertise', 'toolbar' => 'mini', 'height' => '300px'));
                                }
                                ?>
                            </td>
                            <!--<td rowspan="2" style="text-align:center; vertical-align: middle;"><?php //echo CHtml::button('Referensi', array('onclick'=>"ambilReferensi($hasil->pemeriksaanrad_id,$i);return false;",'class'=>'btn btn-info','disabled'=>false, 'onkeypress'=>"return $(this).focusNextInputField(event)"));  ?></td>-->
                        </tr>
                        <tr>
                            <td style="font-size:10pt; ">Kesimpulan</td>
                            <td id="kolKesimpulan_<?php echo $i; ?>" style="text-align:center;">: 
                                <?php // echo CHtml::activeTextArea($hasil, "[$i]kesimpulan_hasilrad", array('rows'=>3, 'style'=>'width:750px; font-size:11pt;', 'onkeypress'=>"return $(this).focusNextInputField(event)"));  ?>
                                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $hasil, 'attribute' => '[' . $i . ']kesimpulan_hasilrad', 'name' => 'ROHasilPemeriksaanRadT_' . $i . '_kesimpulan_hasilrad', 'toolbar' => 'mini', 'height' => '300px')) ?>
                            </td>
                        </tr>
                    </table>
                <?php
                }
            }
        endforeach;
        ?>
        
        <table width="100%">
            <tr>
                <td>
                    <div class="control-group ">
                            <?php echo $form->labelEx($modHasilpemeriksaanRad[0], 'tglpegambilanhasilrad', array('class' => 'control-label inline')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modHasilpemeriksaanRad[0],
                                'attribute' => '[0]tglpegambilanhasilrad',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'minDate' => 'd',
                                //
                                ),
                                'htmlOptions' => array('class' => 'dtPicker2-5 realtime', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>

                        </div>
                    </div>
                </td>
                <td>
                    <?php if(Yii::app()->user->getState('ruangan_id') !== Params::RUANGAN_ID_USG_GRIU && Yii::app()->user->getState('ruangan_id') !== Params::RUANGAN_ID_XRAY_GRIU){ ?>
                    <div class="control-group">
                        <?php echo CHtml::label('PPDS', 'PPDS', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            echo CHtml::activeHiddenField($modPasienMasukPenunjang, 'ppds_id', array('class' => 'span1'));
                            echo CHtml::dropDownList('ROPasienmasukpenunjangT[ppds_id]', $modPasienMasukPenunjang->ppds_id, CHtml::listData(PpdsM::model()->findAll("ppds_aktif IS TRUE AND verifikasi_status = 'Disetujui'"), 'ppds_id', 'ppds_nama'), array('empty' => '--Pilih--', 'class' => 'span3', 'readonly' => false));
                            //              echo $form->dropDownList($modPasienMasukPenunjang,'pegawai_id',CHtml::listData(DokterV::model()->findAllByAttributes(array('ruangan_id'=>  Yii::app()->user->getState('ruangan_id'))),'pegawai_id','NamaLengkap'),array('empty'=>'--Pilih--','class'=>'span3', 'readonly'=>false));
                            ?>
                        </div>
                    </div>
                    <?php }else{ ?>
                    <div class="control-group">
                        <?php echo CHtml::label("DPJTM", '',array('class'=>'control-label required'))?>                                   
                        <div class="controls">
                            <?php echo $form->dropDownList($modPasienMasukPenunjang,'pegawai_id', CHtml::listData(ROPendaftaranT::model()->getDokterItems($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'namaLengkap') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span4')); ?>
                        </div>
                    </div>
                    <?php } ?>
                </td>
            </tr>
        </table> 
            <?php if (isset($modRujukan->rujukandari_id)) { ?>
            <div class="control-group">
                    <?php echo CHtml::label('Dokter Perujuk', 'Dokter Perujuk', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    //                           echo CHtml::dropDownList('ROPasienKirimKeUnitLainT[pegawai_id]',$modPasienKirimKeUnitLain->pegawai_id,CHtml::listData(DokterV::model()->findAll(),'pegawai_id','nama_pegawai'),array('empty'=>'--Pilih--','style'=>'width:160px;', 'readonly'=>false));
                    echo CHtml::activeHiddenField($modRujukan, 'asalrujukan_id', array('class' => 'span1'));
                    echo CHtml::activeHiddenField($modRujukan, 'rujukandari_id', array('class' => 'span1'));
                    //                           echo CHtml::dropDownList('RORujukanT[rujukandari_id]',$modPasienMasukPenunjang->rujukandari_id,CHtml::listData(RujukandariM::model()->findAllByAttributes(array('asalrujukan_id'=>$modPasienMasukPenunjang->asalrujukan_id)),'rujukandari_id','namaperujuk'),array('empty'=>'--Pilih--','class'=>'span3'));
                    echo $form->dropDownList($modRujukan, 'rujukandari_id', CHtml::listData(RujukandariM::model()->findAll(), 'rujukandari_id', 'namaperujuk'), array('empty' => '--Pilih--', 'class' => 'span3', 'onchange' => 'konfirmUbahDokterPerujuk(this);'));
                    //                           echo CHtml::textField('RORujukanT[rujukandari_id]',$modPasienMasukPenunjang->namaperujuk,array('empty'=>'--Pilih--','class'=>'span3', 'readonly'=>true));
                    ?>
                </div>
            </div>
            <?php } ?>
            <div class='form-actions'>
            <?php
            $criRadioligi = new CDbCriteria();
            $criRadioligi->addCondition("pendaftaran_id = :pendaftaran_id AND pasienmasukpenunjang_id = :pasienmasukpenunjang_id");
                                    $criRadioligi->params[':pendaftaran_id'] = $_GET['pendaftaran_id'];
                                    $criRadioligi->params[':pasienmasukpenunjang_id'] = $_GET['pasienmasukpenunjang_id'];
            $modpemeriksaanRad = ROHasilpemeriksaanradT::model()->find($criRadioligi);

            if (!empty($modpemeriksaanRad) && !empty($modpemeriksaanRad->tglverifikasi_dpjp)) {
                echo CHtml::link(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''), array('class' => 'btn btn-primary', 'id' => 'simpanalert',
                    'onclick' => 'myAlert("Hasil Expertise Sudah di Verifikasi DPJTM, maka data tidak tidak bisa diubah"); return false;'));
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit',
                    'onKeypress' => 'return formSubmit(this,event)',
                    'id' => 'btn_simpan'));
            }

            if (!empty($_GET['baru'])) {
                echo '&nbsp;' . CHtml::htmlButton(Yii::t('mds', '{icon} Simpan Second Opinion', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit',
                    'onKeypress' => 'return formSubmit(this,event)',
                    'id' => 'btn_simpan'));
            }
            ?>

            <?php // echo CHtml::link(Yii::t('mds', '{icon} Batal', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), $this->createUrl(''), array('class'=>'btn btn-danger')); ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl('index', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger')); ?>  
            <?php
            $content = $this->renderPartial('../tips/tips', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
            <?php $this->endWidget(); ?>

            <?php
            $criRadioligi = new CDbCriteria();
            $criRadioligi->addCondition("pendaftaran_id = :pendaftaran_id AND pasienmasukpenunjang_id = :pasienmasukpenunjang_id");
                                    $criRadioligi->params[':pendaftaran_id'] = $_GET['pendaftaran_id'];
                                    $criRadioligi->params[':pasienmasukpenunjang_id'] = $_GET['pasienmasukpenunjang_id'];
            $modpemeriksaanRad = ROHasilpemeriksaanradT::model()->find($criRadioligi);
            $modPasienMasukPenunjang = ROPasienmasukpenunjangT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $_GET['pasienmasukpenunjang_id']));
            $cekDPJTM = PegawaiM::model()->findByPk($modPasienMasukPenunjang->pegawai_id);

            // var_dump($modPasienMasukPenunjang->pegawai_id); die;

            if(!empty($modpemeriksaanRad->tglverifikasi_dpjp)) {
                echo '<button id="black" class="btn btn-black btn-icon" name="yt1" disabled>VERIFIKASI<i class="entypo-check"></i></button>';
            }else{

                if(!empty($cekDPJTM)) {
                if($cekDPJTM->pegawai_id == Yii::app()->user->getState('pegawai_id')){
                    if ($modpemeriksaanRad->statusperiksahasil == Params::STATUSPERIKSAHASIL_SUDAH) {
                        echo '<button id="black" class="btn btn-green btn-icon" name="yt1" onclick="verifikasi('.$_GET['pasienmasukpenunjang_id'] .'); ">VERIFIKASI<i class="entypo-check"></i></button>';
                    } else {
                        echo CHtml::htmlButton('VERIFIKASI <i class="entypo-check"></i>', array(
                            'class' => 'btn btn-green btn-icon',
                            'disabled' => true,
                            "onclick" => "myAlert('Pemeriksaan belum dapat diverifikasi.<br> Silahkan mengisi hasil pemeriksaan terlebih dulu. ')",
                            'rel'=>'tooltip',
                            'title'=>'Klik untuk memverifikasi pemeriksaan',
                        ));
                    }
                }else{
                    echo '<button id="black" class="btn btn-green btn-icon" name="yt1" disabled="true">VERIFIKASI<i class="entypo-check"></i></button>';
                }
            }
        }
            ?>
            <?php
            echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-red', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;'));
            ?>

        </div>

    </div>
</div>



<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id'=>'dialogReferensi',
        'options'=>array(
            'title'=>'Data Referensi',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>960,
            'height'=>480,
            'resizable'=>false,
        ),
    ));
        $modReferensi = new ReferensihasilradM('search');
        $modReferensi->unsetAttributes();
        if(isset($_GET['ReferensihasilradM'])) {
            $modReferensi->attributes = $_GET['ReferensihasilradM'];
        }
        $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'referensi-m-grid',
            'dataProvider'=>$modReferensi->search(),
//            'filter'=>$modReferensi,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPasien",
                                        "onClick" => "
                                            ambilReferensi(\"$data->refhasilrad_id\", $(\"#baris_ke\").val());
                                            $(\"#dialogReferensi\").dialog(\"close\");
                                        "))',
                    ),
                    array(
                        'header'=>'Kode Referensi',
                        'name'=>'refhasilrad_kode',
                        'type'=>'raw',
                        'value'=>'$data->refhasilrad_kode'
                    ),
                    array(
                        'header'=>'Hasil Expertise',
                        'name'=>'refhasilrad_hasil',
                        'type'=>'raw',
                        'value'=>'$data->refhasilrad_hasil'
                    ),
                    array(
                        'header'=>'Kesimpulan',
                        'name'=>'refhasilrad_kesimpulan',
                        'type'=>'raw',
                        'value'=>'$data->refhasilrad_kesimpulan'
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        ));
        $this->endWidget();


        $urlPrintLabel = $this->createUrl('printLabel', array('id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id));



$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogKonfigurasiLabel',
    'options' => array(
        'title' => 'Konfigurasi Cetak Label',
        'autoOpen' => false,
        'modal' => true,
        'width' => 400,
        'height' => 160,
        'resizable' => false,
    ),
));

echo '<div class="form-horizontal" id="konfigurasi-label" style="padding:10px;"></div>';

$this->endWidget();
?>

<script>

function printLabel() {
        window.open('<?php echo $urlPrintLabel; ?>', 'printwin', 'left=100,top=100,width=940,height=400');

    }

    var baris_ke = null;

    function ambilReferensi(idPemeriksaanRad, row, banyak, jeniskelamin) {
        if (banyak) {
            banyak = true;
        } else {
            banyak = false;
        }
        //myAlert(<?php //echo Yii::app()->user->pegawai_id;  
                    ?>);
        $.post("<?php echo $this->createUrl('GetReferensiHasilRad'); ?>", {
                idPemeriksaanRad: idPemeriksaanRad,
                banyak: banyak,
                jeniskelamin: jeniskelamin
            },
            function(data) {
                //menambahkan nilai ke elemen yang di hide oleh widget redactor.js
                if (banyak == false) {
                    $('#ROHasilPemeriksaanRadT_' + baris_ke + '_hasilexpertise').val(data.refhasilrad_hasil);
                    $('#ROHasilPemeriksaanRadT_' + baris_ke + '_kesan_hasilrad').val(data.refhasilrad_kesan);
                    $('#ROHasilPemeriksaanRadT_' + baris_ke + '_kesimpulan_hasilrad').val(data.refhasilrad_kesimpulan);
                    //menambahkan nilai referensi ke masukan hasil pemeriksaan
                    $('#kolHasil_' + baris_ke).find('iframe').contents().find('#page').html(data.refhasilrad_hasil);
                    $('#kolKesan_' + baris_ke).find('iframe').contents().find('#page').html(data.refhasilrad_kesan);
                    $('#kolKesimpulan_' + baris_ke).find('iframe').contents().find('#page').html(data.refhasilrad_kesimpulan);
                } else {
                    $.each(data, function(key, value) {
                        var nama = value.refhasildet_nama;
                        var lower = nama.toLowerCase();
                        var replace = lower.replace(/ /g, "_");

                        $('#ROHasilPemeriksaanRadT_' + baris_ke + '_' + value.refhasildet_id + '_' + replace + '_hasilexpertise').html(value.refhasildet_isian);

                        $('#kolHasil_' + baris_ke + '_' + value.refhasildet_id).find('iframe').contents().find('#page').html(value.refhasildet_isian);
                    });
                }
            }, "json");
    }

    function refreshDialog(idPemeriksaanRad, row){
        baris_ke = row;
        $('#baris_ke').val(row);
        $.fn.yiiGridView.update('referensi-m-grid', {
            data: {
                "ReferensihasilradM[pemeriksaanrad_id]":idPemeriksaanRad,
            }
        });
        
    $('#dialogReferensi').dialog('open');
    //   return false; 
    }



    $(document).ready(function () {
<?php if (!empty($_GET['baru'])) { ?>
            $('#ROHasilPemeriksaanRadT_0_hasilexpertise').val('');
            $('#ROHasilPemeriksaanRadT_0_kesan_hasilrad').val('');
            $('#ROHasilPemeriksaanRadT_0_kesimpulan_hasilrad').val('');
            $("#simpanalert").css("display", "none");
<?php } ?>
//        $("#tblFormHasilPemeriksaanRad_1").css("display", "none");
//        $("#tblFormHasilPemeriksaanRad_2").css("display", "none");
//        $("#tblFormHasilPemeriksaanRad_3").css("display", "none");
    });
    function tambahbaru(obj) {
        window.parent.myConfirm("Apakah Anda ingin menambah data baru?", "Perhatian!", function (r) {
            if (r)
                window.location = $(obj).attr("href");
        });
        return false;
    }





    function konfirmUbahDokterPerujuk(obj) {
        var sblm = $('#RORujukanT_rujukandari_id').val();

        if (sblm != '') {
            myConfirm("Apakah anda yakin akan merubah Dokter Perujuk ?", "Perhatian!", function (r) {
                if (r) {
                    obj.value = sblm;
                }
            });
        }
    }
    function konfirmUbahDokterPemeriksa(obj) {
        var sblm = $('#ROPasienMasukPenunjangV_pegawai_id').val();

        if (sblm != '') {
            myConfirm("Apakah anda yakin akan merubah Dokter Pemeriksa ?", "Perhatian!", function (r) {
                if (r) {
                    obj.value = sblm;
                }
                ;
            });
        }
    }

    function printPemeriksaaRad(id, caraPrint) {
        window.open("<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'printPemeriksaanRad'); ?>&hasilpemeriksaan_id=" + id + "&caraPrint=" + caraPrint, "", 'location=_new, width=900px');
    }

    function printPemeriksaanRadiologi(id, caraPrint) {
        window.open("<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'printPemeriksaanRadiologi'); ?>&riwayathasilpemeriksaan_id=" + id + "&caraPrint=" + caraPrint, "", 'location=_new, width=900px');
    }

    $('#btnsubmit').on('click', function ()
    {
        $(this).val('Please wait ...')
                .attr('disabled', 'disabled');
        $('#btn_simpan').submit();
    });

    function verifikasi(pasienmasukpenunjang_id) {
        document.getElementById("btn_simpan").disabled = true;
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('cekVerifikasi'); ?>',
            data: {pasienmasukpenunjang_id: pasienmasukpenunjang_id},
            dataType: "json",
            success: function (data) {
                if (data.status == true) {
                    $.fn.yiiGridView.update('hasilpmeriksaan-radiologi-form');
                } else {
                    myAlert(data.pesan);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

        
    const konfigurasiLabel = (id) => {
        $.get('<?= $this->createUrl('loadKonfigurasiLabel') ?>', {
            id: id
        },
        function(data) {            
            $("#dialogKonfigurasiLabel").dialog("open");                            
            $("#konfigurasi-label").html(data.html);
        }, "json");    
    }
</script>