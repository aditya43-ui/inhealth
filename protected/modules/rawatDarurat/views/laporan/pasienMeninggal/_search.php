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
    <div class="row">
        <div class="col-sm-12">
            <?php $format = new MyFormatter(); ?>
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
        </div>
        <div class="col-sm-6">
            <?php
            echo CHtml::hiddenField('filter', 'wilayah', array('disabled' => 'disabled')) .
                '<div class="control-group">
                ' . CHtml::label('Provinsi', 'propinsi_id', array('class' => 'control-label')) . ' 
                <div class="controls">
                    ' . $form->dropDownList($model, 'propinsi_id', CHtml::listData($modPasien->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )) . '
                </div>
            </div>
            <div class="control-group">
                ' . CHtml::label('Kabupaten', 'kabupaten_id', array('class' => 'control-label')) . ' 
                <div class="controls">												 
                    ' . $form->dropDownList(
                    $model,
                    'kabupaten_id',
                    array(),
                    array('class' => 'form-control', 'multiple' => 'multiple')
                ) . '
                </div>
            </div>';

            // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            //     'id' => 'kunjungan',
            //     'slide' => true,
            //     'content' => array(
            //         'content2' => array(
            //             'header' => '<i class="entypo-doc-text"></i> Berdasarkan Wilayah',
            //             'isi' => CHtml::hiddenField('filter', 'wilayah', array('disabled' => 'disabled')) .
            //                 '<div class="control-group">
            //                     ' . CHtml::label('Provinsi', 'propinsi_id', array('class' => 'control-label')) . ' 
            //                     <div class="controls">
            //                         ' . $form->dropDownList($model, 'propinsi_id', CHtml::listData($modPasien->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array(
            //                     'class' => 'form-control', 'multiple' => 'multiple'
            //                 )) . '
            //                     </div>
            //                 </div>
            //                 <div class="control-group">
            //                     ' . CHtml::label('Kabupaten', 'kabupaten_id', array('class' => 'control-label')) . ' 
            //                     <div class="controls">												 
            //                         ' . $form->dropDownList(
            //                     $model,
            //                     'kabupaten_id',
            //                     array(),
            //                     array('class' => 'form-control', 'multiple' => 'multiple')
            //                 ) . '
            //                     </div>
            //                 </div>',
            //             'active' => true,
            //         ),
            //     ),
            //     //                                    'htmlOptions'=>array('class'=>'aw',)
            // ));
            ?>
        </div>
        <div class="col-sm-6">
            <?php
            echo CHtml::hiddenField('filter', 'golonganumur', array('disabled' => 'disabled')) .
                '<div class="control-group">
                ' . CHtml::label('Golongan Umur', 'golonganumur_id', array('class' => 'control-label')) . ' 
                <div class="controls">
                    ' . $form->dropDownList($model, 'golonganumur_id', CHtml::listData($model->getGolonganUmur(), 'golonganumur_id', 'golonganumur_nama'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )) . '
                </div>
            </div>';

            // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            //     'id' => 'kunjungan',
            //     'slide' => true,
            //     'content' => array(
            //         'content3' => array(
            //             'header' => '<i class="entypo-doc-text"></i> Berdasarkan Golongan Umur',
            //             'isi' => CHtml::hiddenField('filter', 'golonganumur', array('disabled' => 'disabled')) .
            //                 '<div class="control-group">
            //                     ' . CHtml::label('Golongan Umur', 'golonganumur_id', array('class' => 'control-label')) . ' 
            //                     <div class="controls">
            //                         ' . $form->dropDownList($model, 'golonganumur_id', CHtml::listData($model->getGolonganUmur(), 'golonganumur_id', 'golonganumur_nama'), array(
            //                     'class' => 'form-control', 'multiple' => 'multiple'
            //                 )) . '
            //                     </div>
            //                 </div>',
            //             'active' => true,
            //         ),
            //     ),
            //     //                                    'htmlOptions'=>array('class'=>'aw',)
            // ));
            ?>

            <?php
            echo CHtml::hiddenField('filter', 'kondisipulang') .
                '<div class="control-group">
                ' . CHtml::label('Kondisi Pulang', 'kondisikeluar_id', array('class' => 'control-label')) . ' 
                <div class="controls">
                    ' . $form->dropDownList($model, 'kondisikeluar_id', CHtml::listData(KondisiKeluarM::model()->findAll(" kondisikeluar_aktif = TRUE AND carakeluar_id = '" . Params::CARAKELUAR_ID_MENINGGAL . "' ORDER BY kondisikeluar_nama ASC"), 'kondisikeluar_id', 'kondisikeluar_nama'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )) . '
                </div>
            </div>';

            // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            //     'id' => 'kunjungan',
            //     'slide' => true,
            //     'content' => array(
            //         'content4' => array(
            //             'header' => '<i class="entypo-doc-text"></i> Berdasarkan Kondisi Pulang',
            //             'isi' => CHtml::hiddenField('filter', 'kondisipulang') .
            //                 '<div class="control-group">
            //                     ' . CHtml::label('Kondisi Pulang', 'kondisikeluar_id', array('class' => 'control-label')) . ' 
            //                     <div class="controls">
            //                         ' . $form->dropDownList($model, 'kondisikeluar_id', CHtml::listData(KondisiKeluarM::model()->findAll(" kondisikeluar_aktif = TRUE AND carakeluar_id = '" . Params::CARAKELUAR_ID_MENINGGAL . "' ORDER BY kondisikeluar_nama ASC"), 'kondisikeluar_id', 'kondisikeluar_nama'), array(
            //                     'class' => 'form-control', 'multiple' => 'multiple'
            //                 )) . '
            //                     </div>
            //                 </div>',
            //             'active' => true,
            //         ),
            //     ),
            //     //                                    'htmlOptions'=>array('class'=>'aw',)
            // ));
            ?>
        </div>
    </div>

    <?php //$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
    //                            'id'=>'kunjungan',
    //                            'slide'=>true,
    //                            'content'=>array(
    //                            'content2'=>array(
    //                                'header'=>'Berdasarkan Kondisi Pulang',
    //                                'isi'=>  CHtml::hiddenField('filter', 'kondisipulang').CHtml::checkBox('cek_all', true, array("id"=>"checkSemuaid",'value'=>'cek', "onclick"=>"checkSemua()")).'Pilih Semua <br>                                             
    //                                            <table class="kondisipulang">                                            
    //                                            <tr>
    //                                                    <td>'.
    //                                                           $form->checkBoxList($model, 'kondisikeluar_id', CHtml::listData(KondisiKeluarM::model()->findAll(" kondisikeluar_aktif = TRUE AND carakeluar_id = '".Params::CARAKELUAR_ID_MENINGGAL."' ORDER BY kondisikeluar_nama ASC"), 'kondisikeluar_id', 'kondisikeluar_nama'))
    //                                                    .'</td>
    //                                            </tr>
    //                                            </table>',            
    //                                'active'=>true,
    //                                    ),
    //                            ),
    //        //                                    'htmlOptions'=>array('class'=>'aw',)
    //                            )); 
    ?>

    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array(
                'class' => 'btn btn-danger',
                'type' => 'submit',
                'id' => 'btn_simpan',
                'title' => 'Cari',
                'ajax' => array(
                    'type' => 'GET',
                    'url' => array("/" . $this->route),
                    'update' => '#tableLaporan',
                    'beforeSend' => 'function(){
                                      $("#tableLaporan").addClass("animation-loading");
                                  }',
                    'complete' => 'function(){
                                      $("#tableLaporan").removeClass("animation-loading");
                                  }',
                )
            )
        );
        ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrow-ccw"></i>')),
            Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
            array(
                'class' => 'btn btn-default',
                'title' => 'Ulang',
                'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        ); ?>
    </div>
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
',  CClientScript::POS_READY);
?>
<script type="text/javascript">
    $(document).ready(function() {
        checkSemua();
    });

    /** bersihkan dropdown kecamatan */
    function setClearDropdownKecamatan() {
        $("#<?php echo CHtml::activeId($model, "kecamatan_id"); ?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
    }
    /** bersihkan dropdown kelurahan */
    function setClearDropdownKelurahan() {
        $("#<?php echo CHtml::activeId($model, "kelurahan_id"); ?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
    }

    function checkSemua() {
        if ($("#checkSemuaid").is(":checked")) {
            $('.kondisipulang input[name*="RDLaporanpasienmeninggalV"]').each(function() {
                $(this).attr('checked', true);
            })
        } else {
            $('.kondisipulang input[name*="RDLaporanpasienmeninggalV"]').each(function() {
                $(this).removeAttr('checked');
            })
        }
        //setAll();
    }
</script>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>