<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title"><strong>Pendaftaran Labolatorium Rujukan Rumah Sakit</strong></div>
            </div>
            <div class="panel-body">
                
                <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB ?>
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                
                <?php
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'pendaftaran-rujukanrs-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
                    'focus' => '#no_pendaftaran',
                ));
                ?>
                
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><span class='judul'><b>Data Rujukan</b></span></div>
                    </div>
                    <div class="panel-body" id="form-datakunjungan">
                        <div class="row-fluid">
                            <?php $this->renderPartial($this->path_view_spesimen.'_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan, 'modPpds' => $modPpds)); ?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><span class='judul'><b>Data Pemeriksaan Labolatorium</b></span></div>
                    </div>
                    <div class="panel-body" id="form-pemeriksaan">
                        <div class="row-fluid">
                            <?php $this->renderPartial($this->path_view_spesimen.'_formPemeriksaan', array('form' => $form, 'modKunjungan' => $modKunjungan, 'modPenilaian' => $modPenilaian, 'dataKirimSpesimen'=>$dataKirimSpesimen, 'modSpesimen2' => $modSpesimen2)); ?>
                        </div>
                        <div class="panel panel-success panel-shadow">
                            <div class="panel-heading">
                                <div class="panel-title"><span class='judul'><b>Tabel Pemeriksaan</b></span></div>
                            </div>
                            <div class="panel-body" id="tabel-pemeriksaan">
                                <div style="">
                                    <table  class="table table-bordered table-striped table-condensed">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center">No.</th>
                                                <th style="text-align: center">Jenis Spesimen <span class="required">*</span></th>
                                                <th style="text-align: center">Jenis/Nama Pemeriksaan <span class="required">*</span></th>
                                                <th style="text-align: center">Status</th>
                                                <th style="text-align: center">Kualitas Spesimen <span class="required">*</span></th>
                                                <th style="text-align: center">Alasan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            if(!empty($dataSpesimen)){
                                                $dataKirimSpesimen = $dataSpesimen;
                                            }
                                            if(!empty($dataKirimSpesimen)){
                                                $i = 1;
                                                foreach ($dataKirimSpesimen as $key => $value) {
                                                    if (empty($value)) {
                                                        continue;
                                                    }
                                                    $modSpesimen->attributes = $value->attributes;
                                                    $modSampleLab = SamplelabM::model()->findByPk($value->samplelab_id);
                                                    $modSpesimen->samplelab_id = $modSampleLab->samplelab_id;
                                                    $modSpesimen->samplelab_nama = $modSampleLab->samplelab_nama;
                                                    $modSpesimen->spesimen_id = isset($value->spesimen_id)? $value->spesimen_id : null;
                                                    if(isset($value->pemeriksaanlab_id)){
                                                        $modPeriksaLab = PemeriksaanlabM::model()->findByPk($value->pemeriksaanlab_id);
                                                        $modSpesimen->pemeriksaanlab_id = $modPeriksaLab->pemeriksaanlab_id;
                                                        $modSpesimen->pemeriksaanlab_nama = $modPeriksaLab->pemeriksaanlab_nama;
                                                    }
                                                    
                                                    $modPermintaan = PermintaankepenunjangT::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $modPenilaian->pasienkirimkeunitlain_id, 'pemeriksaanlab_id' => $value->pemeriksaanlab_id));
                                                    $this->renderPartial('_rowPermintaanKePenunjang', array('modSpesimen' => $modSpesimen, 'modTindakan' => $modTindakan, 'modPermintaan' => $modPermintaan, 'i' => $i));
                                            ?>
                                            <?php
                                                $i++;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <div class="form-actions">
                    <?php
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'disabled' => (isset($_GET['sukses'])) ? true : false));
                    ?>
                    <?php
                    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/index', array('pasienkirimkeunitlain_id' => $modKunjungan->pasienkirimkeunitlain_id)), array('class' => 'btn btn-danger',
                        'onclick' => 'return refreshForm(this);', 'disabled' => (isset($_GET['sukses'])) ? true : false))."&nbsp;";
                    echo "&nbsp;";
                    echo CHtml::link(Yii::t('mds', '{icon} Cetak Job List', array('{icon}' => '<i class="' . MyIcon::getIcons("cetak") . '"></i>')), 'javascript:void(0);', array('disabled' => (isset($_GET['sukses'])) ? false : true,'class' => 'btn btn-info', 'onclick' => "printAntrianFoto('$modKunjungan->pasienkirimkeunitlain_id','$modKunjungan->pasienmasukpenunjang_id');return false"))."&nbsp;";
                    //echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "myAlert('Comming Soon');return false", 'disabled' => FALSE))."&nbsp;";
                    echo CHtml::link(Yii::t('mds', '{icon} Print Bukti Pengambilan Hasil', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "myAlert('Comming Soon');return false", 'disabled' => FALSE))."&nbsp;";
                    echo CHtml::link(Yii::t('mds', '{icon} Kembali', array('{icon}' => '<i class="icon-arrow-left icon-white"></i>')), $this->createUrl('RujukanPenunjang/index', array()), array('class' => 'btn btn-danger'))."&nbsp;";
                    ?>
                </div>
                
                <?php $this->endWidget(); ?>
                <?php $this->renderPartial('_jsFunction', array('modKunjungan' => $modKunjungan, 'modTindakan' => $modTindakan, 'modSpesimen' => $modSpesimen, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang)); ?>
            </div>
        </div>
    </div>
</div>