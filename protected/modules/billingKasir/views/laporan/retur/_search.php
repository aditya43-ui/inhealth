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
        td label.checkbox {
            width: 150px;
            display: inline-block;

        }

        .checkbox.inline+.checkbox.inline {
            margin-left: 0;
        }
    </style>
    <div class="row">
        <div class="col-sm-12">
            <?php //$format = new MyFormatter(); 
            ?>
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
            echo CHtml::hiddenField('filter', 'instalasi', array('disabled' => 'disabled')) .
                '<div class="control-group">
                        ' . CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')) . ' 
                        <div class="controls">
                            ' . $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll(array(
                    'condition' => '(instalasi_id in (2,3,4) or (instalasirujukaninternal = true and revenuecenter = true and instalasi_id <> 7)) and instalasi_aktif = true',
                    'order' => 'instalasi_id'
                )), 'instalasi_id', 'instalasi_nama'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )) . '
                        </div>
                    </div>';
            ?>
        </div>
        <div class="col-sm-6">
            <?php
            echo '<div class="control-group">
            ' . CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')) . ' 
            <div class="controls">												 
                ' . $form->dropDownList(
                $model,
                'ruangan_id',
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
            <div class="control-group">
                <?php
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'kunjungan',
                    'slide' => true,
                    'content' => array(
                        'content2' => array(
                            'multi' => 'multi',
                            'header' => 'Berdasarkan Insatalasi dan Ruangan',
                            'isi' => CHtml::hiddenField('filter', 'instalasi', array('disabled' => 'disabled')) .
                                '<div class="control-group">
											' . CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')) . ' 
											<div class="controls">
												' . $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll(array(
                                    'condition' => '(instalasi_id in (2,3,4) or (instalasirujukaninternal = true and revenuecenter = true and instalasi_id <> 7)) and instalasi_aktif = true',
                                    'order' => 'instalasi_id'
                                )), 'instalasi_id', 'instalasi_nama'), array(
                                    'class' => 'form-control', 'multiple' => 'multiple'
                                )) . '
											</div>
										</div>
										<div class="control-group">
											' . CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')) . ' 
											<div class="controls">												 
												' . $form->dropDownList(
                                    $model,
                                    'ruangan_id',
                                    array(),
                                    array('class' => 'form-control', 'multiple' => 'multiple')
                                ) . '
											</div>
										</div>',
                            'active' => true,
                        ),
                    ),
                    //                                    'htmlOptions'=>array('class'=>'aw',)
                ));
                ?>
            </div>
        </div>
    </div>-->

    <!--table width="100%" border="0">
        <tr>
            <td>
                <div id='searching'>
                    <fieldset>
                        <?php //$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                        //                                    'id'=>'big',
                        //                                    'slide' => true,
                        //                                    'content'=>array(
                        //                                        'content2'=>array(
                        //                                        'header'=>'Berdasarkan Instalasi dan Ruangan',
                        //                                        'isi'=>'<table>
                        //                                                    <tr>
                        //                                                        <td>'.CHtml::hiddenField('filter', 'instalasi', array('disabled'=>'disabled')).'<label>Instalasi</label></td>
                        //                                                        <td>'.$form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll(array(
                        //                                                            'condition'=>'(instalasi_id in (2,3,4) or (instalasirujukaninternal = true and revenuecenter = true and instalasi_id <> 7)) and instalasi_aktif = true',
                        //                                                            'order'=>'instalasi_id'
                        //                                                        )), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                        //                                                            'ajax' => array('type' => 'POST',
                        //                                                                'url' => Yii::app()->createUrl('ActionDynamic/GetRuanganForCheckBox', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().'')),
                        //                                                                'update' => '#ruangan',  //selector to update
                        //                                                            ),
                        //                                                        )).'
                        //                                                        </td>
                        //                                                    </tr>
                        //                                                    <tr>
                        //                                                        <td>
                        //                                                            <label>Ruangan</label>
                        //                                                        </td>
                        //                                                        <td>
                        //                                                            <div id="ruangan">
                        //                                                                <label>Data tidak ditemukan.</label>
                        //                                                            </div>
                        //                                                        </td>
                        //                                                    </tr>
                        //                                                 </table>',
                        //                                         'active'=>true
                        //                                        ),
                        //                                    ),
                        ////                                    'htmlOptions'=>array('class'=>'aw',)
                        // )); 
                        ?>
                    </fieldset>
                </div>
            </td>            
        </tr>
    </table-->
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
        );
        ?>
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
        ); ?>
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

<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
',  CClientScript::POS_READY);
?>

<script type="text/javascript">
    function checkAll() {
        if ($("#checkAllRuangan").is(':checked')) {
            $("#ruangan").find("input[type=\'checkbox\']").attr("checked", "checked");
        } else {
            $("#ruangan").find("input[type=\'checkbox\']").attr("checked", false);
        }

    }
</script>

<?php
//========= Dialog buat cari data pemeriksa =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDokter1',
    'options' => array(
        'title' => 'Dokter Pemeriksa',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<?php

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end pemeriksa dialog =============================
?>

<?php
//========= Dialog buat cari data pendaftaran =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDokter',
    'options' => array(
        'title' => 'Pencarian Data Dokter',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 540,
        'resizable' => false,
    ),
));
$pegawai = new DokterpegawaiV('searchByDokter');
if (isset($_GET['DokterpegawaiV'])) {
    $pegawai->attributes = $_GET['DokterpegawaiV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pendaftaran-t-grid',
    'dataProvider' => $pegawai->searchByDokter(),
    'filter' => $pegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPendaftaran",
                                        "onClick" => "
                                            $(\"#dialogDokter\").dialog(\"close\");
                                            $(\"#BKLaporanpembebasantarifV_pegawai_id\").val(\"$data->pegawai_id\");
                                            $(\"#BKLaporanpembebasantarifV_nama_pegawai\").val(\"$data->nama_pegawai\");

                                        "))',
        ),
        'gelardepan',
        array(
            'name' => 'nama_pegawai',
            'header' => 'Nama Dokter',
        ),
        'gelarbelakang_nama',
        'jeniskelamin',
        'agama',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
////======= end pendaftaran dialog =============
?>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>