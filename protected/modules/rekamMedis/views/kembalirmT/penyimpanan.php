<?php
$this->breadcrumbs = array(
    'Transaksi Penyimpanan Dokumen Rekam Medis Baru'
);
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Penyimpanan Dokumen Rekam Medis Baru</b>
        </div>
    </div>
    <div class="panel-body">
        <?php Yii::app()->clientScript->registerScript('search', "
                $('.search-button').click(function(){
                    $('.search-form').toggle();
                    return false;
                });
                $('.search-form form').submit(function(){
                    $.fn.yiiGridView.update('ppdokumenpasienrmbaru-v-grid', {
                        data: $(this).serialize()
                    });
                    return false;
                });
                ");

        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class='hide'>
            <?php
            $warnadokrm_id = 1;
            $this->widget(
                'ext.colorpicker.ColorPicker',
                array(
                    'name' => 'Dokumen[warnadokrm_id][]',
                    'value' => WarnadokrmM::model()->getKodeWarnaId($warnadokrm_id), // string hexa decimal contoh 000000 atau 0000ff
                    'height' => '30px', // tinggi
                    'width' => '83px',
                    //'swatch'=>true, // default false jika ingin swatch
                    'colors' =>  WarnadokrmM::model()->getKodeWarna(), //warna dalam bentuk array contoh array('0000ff','00ff00')
                    'colorOptions' => array(
                        'transparency' => true,
                    ),
                )
            );
            ?>
        </div>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="search-form cari-lanjut">
            <?php
            $this->renderPartial('_searchPenyimpanan', array(
                'model' => $model,
            )); ?>
        </div>
        <!--search-form-->
        <hr>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Penyimpanan Dokumen Rekam Medis Baru</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
                <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'ppdokrekammedis-m-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
                    'focus' => '#',
                )); ?>
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'ppdokumenpasienrmbaru-v-grid',
                    'dataProvider' => $model->searchPenyimpanan(),
                    //'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'Pilih',
                            'type' => 'raw',
                            'value' => '
                                        CHtml::hiddenField(\'Dokumen[dokrekammedis_id][]\', $data->dokrekammedis_id).
                                        CHtml::checkBox(\'cekList[]\', \'\', array(\'onclick\'=>\'setUrutan()\', \'class\'=>\'cekList\'));
                                        ',
                        ),
                        array(
                            'header' => 'Lokasi Rak',
                            'type' => 'raw',
                            'value' => '
                                        CHtml::dropDownList(\'Dokumen[lokasirak_id][]\',\'\',Chtml::listData(LokasirakM::model()->findAll(\'lokasirak_aktif=true ORDER BY lokasirak_nama ASC\'), \'lokasirak_id\', \'lokasirak_nama\'), array(\'empty\'=>\'-- Pilih --\',\'class\'=>\'span2 lokasiRak\'));'
                        ),
                        array(
                            'header' => 'Sub Rak',
                            'type' => 'raw',
                            'value' => '
                                        CHtml::dropDownList(\'Dokumen[subrak_id][]\',\'\',Chtml::listData(SubrakM::model()->findAll(\'subrak_aktif=true ORDER BY subrak_nama ASC\'), \'subrak_id\', \'subrak_nama\'), array(\'empty\'=>\'-- Pilih --\', \'class\'=>\'span2 subRak\'));'
                        ),
                        //'lokasirak_id',
                        //'subrak_id',
                        //'warnadokrm_id',
                        //        array(
                        //            'header'=>'Warna Dokumen RK',
                        //            'type'=>'raw',
                        //            'value'=>"$ex",
                        //        ),
                        array(
                            'header' => 'Warna Dokumen RK',
                            'type' => 'raw',
                            'value' => '$this->grid->getOwner()->renderPartial(\'_warnaDokumen\', array(\'warnadokrm_id\'=>$data->dokrekammedis->warnadokrm_id), true)',
                        ),
                        //'pasien_id',
                        'pasien.no_rekam_medik',
                        array(
                            'name' => 'pendaftaran.tgl_pendaftaran',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->pendaftaran->tgl_pendaftaran)'
                        ),

                        'pendaftaran.no_pendaftaran',
                        'pasien.nama_pasien',
                        array(
                            'name' => 'pasien.tanggal_lahir',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->pasien->tanggal_lahir)'
                        ),

                        'pasien.jeniskelamin',
                        //'alamat_pasien',
                        //'instalasi_nama',
                        'pendaftaran.instalasi.instalasi_nama',
                        'pendaftaran.ruangan.ruangan_nama',
                        //'tgl_rekam_medik',
                        //'nama_pasien',
                        //        'nama_bin',
                        //        'jeniskelamin',
                        /*

                                'alamat_pasien',
                                'tempat_lahir',
                                'ruangan_id',
                                'ruangan_nama',

                                ////'pendaftaran_id',
                                array(
                                                'name'=>'pendaftaran_id',
                                                'value'=>'$data->pendaftaran_id',
                                                'filter'=>false,
                                        ),

                                'no_urutantri',
                                'instalasi_id',
                                'instalasi_nama',
                                'statuspasien',
                                */
                        //        array(
                        //                        'header'=>Yii::t('zii','View'),
                        //            'class'=>'bootstrap.widgets.BootButtonColumn',
                        //                        'template'=>'{view}',
                        //        ),
                        //        array(
                        //                        'header'=>Yii::t('zii','Update'),
                        //            'class'=>'bootstrap.widgets.BootButtonColumn',
                        //                        'template'=>'{update}',
                        //                        'buttons'=>array(
                        //                            'update' => array (
                        //                                          'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                        //                                        ),
                        //                         ),
                        //        ),
                        //        array(
                        //                        'header'=>Yii::t('zii','Delete'),
                        //            'class'=>'bootstrap.widgets.BootButtonColumn',
                        //                        'template'=>'{remove} {delete}',
                        //                        'buttons'=>array(
                        //                                        'remove' => array (
                        //                                                'label'=>"<i class='icon-form-silang'></i>",
                        //                                                'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                        //                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->pendaftaran_id"))',
                        //                                                //'visible'=>'($data->kabupaten_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
                        //                                                'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
                        //                                        ),
                        //                                        'delete'=> array(
                        //                                                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                        //                                        ),
                        //                        )
                        //        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
                                                var colors = jQuery(\'input[rel="colorPicker"]\').attr(\'colors\').split(\',\');
                                                jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                                                jQuery(\'input[rel="colorPicker"]\').colorPicker({colors:colors});
                                        }',
                )); ?>
                <?php echo $form->errorSummary($modDokRekamMedis); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                $modDokRekamMedis->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
            ); ?>

            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/Penyimpanan'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('Penyimpanan') . '";} ); return false;'
                )
            ); ?>
            <?php
            $content = $this->renderPartial('../tips/transaksiPenyimpananDokumenRM', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<script>
    function setUrutan() {
        noUrut = 0;
        $('.cekList').each(function() {
            $(this).attr('name', 'cekList[' + noUrut + ']');
            noUrut++;
        });
    }

    $(document).ready(function() {
        $('form#ppdokrekammedis-m-form').submit(function() {
            var jumlah = 0;
            var lokasiRak = 0;
            var subRak = 0;
            $('.cekList').each(function() {
                if ($(this).is(':checked')) {
                    jumlah++;
                }
                if ($(this).parents('tr').find('.lokasiRak').val() != '') {
                    lokasiRak++;
                }
                if ($(this).parents('tr').find('.subRak').val() != '') {
                    subRak++;
                }
            });
            if (jumlah < 1) {
                myAlert('Silakan pilih Dokumen yang akan dikirim!');
                return false;
            } else if (lokasiRak < 1) {
                myAlert('Isi Lokasi Rak pada dokumen yang dipilih!');
                return false;
            } else if (subRak < 1) {
                myAlert('Isi Sub Rak pada dokumen yang dipilih!');
                return false;
            }
        });
    });
</script>