<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));
    ?>
    <style>
        #penjamin,
        #ruangan,
        #statusBayar {
            width: 250px;
        }

        #penjamin label.checkbox,
        #ruangan label.checkbox,
        #statusBayar label.checkbox {
            width: 120px;
            display: inline-block;
        }
    </style>
    <div class="row">
        <div class="col-sm-6">
            <?php echo CHtml::hiddenField('type', ''); ?>
            <div class="control-group">
                <?php echo $form->hiddenField($model, 'jns_periode', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'bln_awal', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'bln_akhir', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'thn_awal', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'thn_akhir', array('class' => 'span2')); ?>
                <?php echo CHtml::label("Periode Laporan", 'tgl_rekam', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>

            <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4')); ?>

            <?php
            echo CHtml::hiddenField('filter', 'jenispenjualan', array('disabled' => 'disabled')) .
                '<div class="control-group">
                            ' . CHtml::label('Jenis Penjualan', 'jenispenjualan', array('class' => 'control-label')) . ' 
                            <div class="controls">
                                ' . $form->dropDownList($model, 'jenispenjualan', LookupM::getItems('jenispenjualan'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )) . '
                            </div>
                        </div>';

            echo CHtml::hiddenField('filter', 'statusbayar', array('disabled' => 'disabled')) .
                '<div class="control-group">
                            ' . CHtml::label('Status Bayar', 'statusbayar', array('class' => 'control-label')) . ' 
                            <div class="controls">
                                ' . $form->dropDownList($model, 'statusbayar', array('Sudah Bayar' => 'Sudah Bayar', 'Belum Bayar' => 'Belum Bayar'), array(
                    'class' => 'form-control span3', 'empty' => '-- Pilih --'
                )) . '
                            </div>
                        </div>';
            ?>
        </div>
        <div class="col-sm-6">
            <?php
            echo CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) .
                '<div class="control-group">
                            ' . CHtml::label('Jenis Penjamin', 'carabayar_id', array('class' => 'control-label')) . ' 
                            <div class="controls">
                                ' . $form->dropDownList($model, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAll('carabayar_aktif = true'), 'carabayar_id', 'carabayar_nama'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )) . '
                            </div>
                        </div>
                        <div class="control-group">
                            ' . CHtml::label('Penjamin', 'penjamin_id', array('class' => 'control-label')) . ' 
                            <div class="controls">												 
                                ' . $form->dropDownList(
                    $model,
                    'penjamin_id',
                    CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama'),
                    array('class' => 'form-control', 'multiple' => 'multiple')
                ) . '
                            </div>
                        </div>';

            echo CHtml::hiddenField('filter', 'instalasiasal_nama', array('disabled' => 'disabled')) .
                '<div class="control-group">
                            ' . CHtml::label('Instalasai Asal', 'instalasiasal_nama', array('class' => 'control-label')) . ' 
                            <div class="controls">
                                ' . $form->dropDownList($model, 'instalasiasal_nama', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true'), 'instalasi_nama', 'instalasi_nama'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )) . '
                            </div>
                        </div>
                        <div class="control-group">
                            ' . CHtml::label('Ruangan Asal', 'ruanganasal_nama', array('class' => 'control-label')) . ' 
                            <div class="controls">												 
                                ' . $form->dropDownList(
                    $model,
                    'ruanganasal_nama',
                    array(),
                    array('class' => 'form-control', 'multiple' => 'multiple')
                ) . '
                            </div>
                        </div>';
            ?>
        </div>
    </div>
    <!--<div class="row">
        <div class="col-sm-6">
            <?php
            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'jenispenjualan',
                'slide' => true,
                'content' => array(
                    'content' => array(
                        'multi' => 'multi',
                        'header' => 'Berdasarkan Jenis Penjualan',
                        'isi' => CHtml::hiddenField('filter', 'jenispenjualan', array('disabled' => 'disabled')) .
                            '<div class="control-group">
                                        ' . CHtml::label('Jenis Penjualan', 'jenispenjualan', array('class' => 'control-label')) . ' 
                                        <div class="controls">
                                            ' . $form->dropDownList($model, 'jenispenjualan', LookupM::getItems('jenispenjualan'), array(
                                'class' => 'form-control', 'multiple' => 'multiple'
                            )) . '
                                        </div>
                                    </div>',
                        'active' => true,
                    ),
                ),
                //                                    'htmlOptions'=>array('class'=>'aw',)
            ));
            ?>
        </div>
        <div class="col-sm-6">
            <?php
            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'statusbayar',
                'slide' => true,
                'content' => array(
                    'content3' => array(
                        'multi' => 'multi',
                        'header' => 'Berdasarkan Status Bayar',
                        'isi' => CHtml::hiddenField('filter', 'statusbayar', array('disabled' => 'disabled')) .
                            '<div class="control-group">
                                        ' . CHtml::label('Status Bayar', 'statusbayar', array('class' => 'control-label')) . ' 
                                        <div class="controls">
                                            ' . $form->dropDownList($model, 'statusbayar', array('Sudah Bayar' => 'Sudah Bayar', 'Belum Bayar' => 'Belum Bayar'), array(
                                'class' => 'form-control', 'empty' => '-- Pilih --'
                            )) . '
                                        </div>
                                    </div>',
                        'active' => true,
                    ),
                ),
                //                                    'htmlOptions'=>array('class'=>'aw',)
            ));
            ?>
        </div>
        <div class="col-sm-6">
            <?php
            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'carabayar',
                'slide' => true,
                'content' => array(
                    'content2' => array(
                        'multi' => 'multi',
                        'header' => 'Berdasarkan Jenis Penjamin',
                        'isi' => CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) .
                            '<div class="control-group">
                                        ' . CHtml::label('Jenis Penjamin', 'carabayar_id', array('class' => 'control-label')) . ' 
                                        <div class="controls">
                                            ' . $form->dropDownList($model, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAll('carabayar_aktif = true'), 'carabayar_id', 'carabayar_nama'), array(
                                'class' => 'form-control', 'multiple' => 'multiple'
                            )) . '
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        ' . CHtml::label('Penjamin', 'penjamin_id', array('class' => 'control-label')) . ' 
                                        <div class="controls">												 
                                            ' . $form->dropDownList(
                                $model,
                                'penjamin_id',
                                CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama'),
                                array('class' => 'form-control', 'multiple' => 'multiple')
                            ) . '
                                        </div>
                                    </div>',
                        'active' => true,
                    ),
                ),
            ));
            ?>
        </div>
        <div class="col-sm-6">
            <?php
            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'asal',
                'slide' => true,
                'content' => array(
                    'content4' => array(
                        'multi' => 'multi',
                        'header' => 'Berdasarkan Instalasi Asal',
                        'isi' => CHtml::hiddenField('filter', 'instalasiasal_nama', array('disabled' => 'disabled')) .
                            '<div class="control-group">
                                        ' . CHtml::label('Instalasai Asal', 'instalasiasal_nama', array('class' => 'control-label')) . ' 
                                        <div class="controls">
                                            ' . $form->dropDownList($model, 'instalasiasal_nama', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true'), 'instalasi_nama', 'instalasi_nama'), array(
                                'class' => 'form-control', 'multiple' => 'multiple'
                            )) . '
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        ' . CHtml::label('Ruangan Asal', 'ruanganasal_nama', array('class' => 'control-label')) . ' 
                                        <div class="controls">												 
                                            ' . $form->dropDownList(
                                $model,
                                'ruanganasal_nama',
                                array(),
                                array('class' => 'form-control', 'multiple' => 'multiple')
                            ) . '
                                        </div>
                                    </div>',
                        'active' => true,
                    ),
                ),
            ));
            ?>
        </div>
    </div>-->

    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
        );
        ?>
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            array(
                'title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        ); ?>
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); 
    ?>
</div>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
', CClientScript::POS_READY); ?>

<?php Yii::app()->clientScript->registerScript('reloadPage', '
    function konfirmasi(){
        window.location.href="' . Yii::app()->createUrl($module . '/' . $controller . '/LaporanPenjualanObat', array('modul_id' => Yii::app()->session['modul_id'])) . '";
    }', CClientScript::POS_HEAD); ?>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>