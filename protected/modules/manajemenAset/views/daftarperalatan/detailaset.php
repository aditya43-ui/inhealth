
 <?php 
$tglterima = !empty($model->tanggal_perolehan)?MyFormatter::formatDateTimeForUser($model->tanggal_perolehan,'long'):'';
$model->ruangan_nama = !empty($model->ruangan->ruangan_nama)?$model->ruangan->ruangan_nama:'-';
$model->lokasiaset_namalokasi = !empty($model->lokasi->lokasiaset_namalokasi)?$model->lokasi->lokasiaset_namalokasi:'';
$caraperolehan = '';

?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Detail Peralatan
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i>  Peralatan
                </div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-md-6">
                        <div class="control-group ">
                            <div class="col-md-4" style="padding-top:7px">Jenis Peralatan</div>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($model,'invperalatan_namabrg', array('class' => 'span3', 'readonly'=>true)); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <div class="col-md-4" style="padding-top:7px">Nomor Aset</div>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($model,'invperalatan_kode', array('class' => 'span3', 'readonly'=>true)); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <div class="col-md-4" style="padding-top:7px">Pemilik Aset</div>
                            <div class="controls">
                                <?php
                                if(!empty($model->pemilikbarang_id)){
                                    $pemilik = PemilikbarangM::model()->findByPk($model->pemilikbarang_id);
                                    $model->pemilikbarang_id = $pemilik->pemilikbarang_nama;
                                }
                                echo CHtml::activeTextField($model, 'pemilikbarang_id', array('class' => 'span3', 'readonly'=>true)); ?>
                            </div>
                        </div>
                        <div class="control-group ">

                            <div class="col-md-4" style="padding-top:7px">Asal Aset</div>
                            <div class="controls">
                                <?php 
                                if(!empty($model->asalaset_id)){
                                    $asalaset = AsalasetM::model()->findByPk($model->asalaset_id);
                                    $model->asalaset_id = $asalaset->asalaset_nama;
                                }
                                echo CHtml::activeTextField($model,'asalaset_id', array('class' => 'span3', 'readonly'=>true)); ?>
                            </div>
                        </div>
                        <div class="control-group ">

                            <div class="col-md-4" style="padding-top:7px">Ruangan Aset</div>
                            <div class="controls">
                                <?php                                
                                echo CHtml::activeTextField($model,'ruangan_nama', array('class' => 'span3', 'readonly'=>true)); ?>
                            </div>
                        </div>
                        <div class="control-group ">

                            <div class="col-md-4" style="padding-top:7px">Lokasi Aset</div>
                            <div class="controls">
                                <?php                                
                                echo CHtml::activeTextField($model,'lokasiaset_namalokasi', array('class' => 'span3', 'readonly'=>true)); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                               
                            <div class="col-md-4" style="padding-top:7px">Tgl Perolehan</div>
                            <div class="controls">
                                <div class="input-append">
                                    <input disabled="disabled" class="span3 dtPicker3 hasDatepicker" onkeypress="return $(this).focusNextInputField(event)" value="<?php echo $tglterima ?>" type="text">
                                    <span class="add-on">
                                        <i class="icon-calendar"></i>
                                    </span>
                                </div>                            
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="control-group ">
                            <div class="col-md-4" style="padding-top:7px">Merk</div>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($model,'invperalatan_merk', array('class' => 'span3', 'readonly'=>true)); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <div class="col-md-4" style="padding-top:7px">Ukuran</div>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($model,'invperalatan_ukuran', array('class' => 'span3', 'readonly'=>true)); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <div class="col-md-4" style="padding-top:7px">Bahan</div>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($model,'invperalatan_bahan', array('class' => 'span3', 'readonly'=>true)); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <div class="col-md-4" style="padding-top:7px">Cara Perolehan</div>
                            <div class="controls">                                
                                <input class="span3" readonly="readonly" maxlength="100" value="<?php echo $model->cara_perolehan ?>" type="text">
                            </div>
                        </div>
                        <div class="control-group ">
                           <div class="col-md-4" style="padding-top:7px">Sumber Dana</div>
                           <div class="controls">
                                <?php                                 
                                echo CHtml::activeTextField($model,'sumberdana', array('class' => 'span3', 'readonly'=>true)); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <div class="col-md-4" style="padding-top:7px">Kondisi</div>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($model,'invperalatan_keadaan', array('class' => 'span3', 'readonly'=>true)); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <?php
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'tabinformasi',
            'content' => array(
                'content-tabinformasi' => array(
                    'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk menampilkan detail Informasi')) . '<b> Informasi</b>',
                    'isi' => $this->renderPartial('infoPeralatan/index', array(
                        
                            ), true),
                    'active' => false,
                ),
            ),
        ));
        ?>
        <?php
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'tabpemeliharaanaset',
            'content' => array(
                'content-tabpemeliharaanaset' => array(
                    'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk Pemeliharaan Aset')) . '<b> Pemeliharaan Aset</b>',
                    'isi' => $this->renderPartial('pemeliharaanaset/index', array(
                        
                            ), true),
                    'active' => false,
                ),
            ),
        ));
        ?>
        
    </div>
    
</div>