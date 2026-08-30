<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));

    $format = new MyFormatter();
    ?>

    <style>
        #penjamin label.checkbox {
            width: 100px;
            display: inline-block;
        }

        label.checkbox,
        label.radio {
            width: 200px;
            display: inline-block;
        }

        .form-horizontal .radio>label,
        .form-horizontal .checkbox>label {
            float: left !important;
            max-width: 150px;
            margin-left: 5px !important;
            padding: 0 !important;
        }

        .form-horizontal .radio>input,
        .form-horizontal .checkbox>input {
            float: left !important;
            margin-top: 2px !important;
        }
    </style>

    <div class="row-fluid">
        <div class="col-sm-6">
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
            <div class="control-group">
                <label class="control-label">Ruangan</label>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'ruangan_id', CHtml::listData(RuanganM::getRuanganByInstalasi(array(Params::INSTALASI_ID_RI, Params::INSTALASI_ID_PERAWATAN_INTENSIF)), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --')); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="col-sm-12">
            <fieldset>
                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'kunjungan',
                    'slide' => true,
                    'content' => array(
                        'content1' => array(
                            'header' => 'Berdasarkan Jenis Diet',
                            'isi' =>  '  <table><tr></tr></table>
                                            <table class="penjamin">                                            
                                            <tr>
                                                    <td><div class="controls">' .
                                CHtml::checkBox('pilihSemuaJenis', true, array('onclick' => 'pilihSemuaJenisDiet();')) . '<label><b>Pilih Semua</b></label>
                        <div id="cbJenisDiet">
                            ' . $form->checkBoxList($model, 'jenisdiet_id', CHtml::listData(JenisdietM::model()->findAll('jenisdiet_aktif = true'), 'jenisdiet_id', 'jenisdiet_nama'), array('onkeypress' => "return $(this).focusNextInputField(event)")) . '<br>
                        </div>                
                    </div></td>
                                            </tr>
                                            </table>',
                            'active' => true,
                        ),
                    ),
                    //                                    'htmlOptions'=>array('class'=>'aw',)
                )); ?>
            </fieldset>
        </div>
        <!--<div class="col-sm-4">
            <div id='searching'>
                <fieldset>
                    <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'kunjungan',
                        'slide' => true,
                        'content' => array(
                            'content1' => array(
                                'multi' => 'multi',
                                'header' => 'Berdasarkan Ruangan',
                                'isi' =>  '<table><tr></tr></table>
                                            <table class="penjamin">                                            
                                            <tr>
                                                <td>' . $form->dropDownList($model, 'ruangan_id', CHtml::listData(RuanganM::getRuanganByInstalasi(array(Params::INSTALASI_ID_RI, Params::INSTALASI_ID_PERAWATAN_INTENSIF)), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --')) . '</td>
                                            </tr>
                                            </table>',
                                'active' => true,
                            ),
                        ),
                        //                                    'htmlOptions'=>array('class'=>'aw',)
                    )); ?>
                </fieldset>
            </div>
        </div>-->
    </div>

    <!--<div class="control-group">
                        <label class="control-label">Jenis Diet</label>
                        <div class="controls" id="cbJenisDiet">
                            <?php //echo $form->textField($model, 'jenisdiet_nama', array('onkeypress' => "return $(this).focusNextInputField(event)")); 
                            ?>
                        </div>
                    </div>
                    </div>-->

    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'ajax' => array(
                'type' => 'GET',
                'url' => array("/" . $this->route),
                'update' => '#tableLaporan',
                'beforeSend' => 'function(){
                                  $("#tableLaporan").addClass("animation-loading");
                              }',
                'complete' => 'function(){
                                  $("#tableLaporan").removeClass("animation-loading");
                                  changeRuangan();
                              }',
            ))
        );
        ?>
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'konfirmasi()', 'onKeypress' => 'return formSubmit(this,event)')
        ); ?>
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); 
    ?>
</div>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>

<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
',  CClientScript::POS_READY);
?>

<script type="text/javascript">
    function pilihSemuaJenisDiet() {
        if ($("#pilihSemuaJenis").is(':checked')) {
            $("#cbJenisDiet").find("input[type=\'checkbox\']").attr("checked", "checked");
        } else {
            $("#cbJenisDiet").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }
    pilihSemuaJenisDiet();
</script>