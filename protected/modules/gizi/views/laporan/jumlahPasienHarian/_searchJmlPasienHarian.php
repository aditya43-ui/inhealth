<div class="panel panel-success">
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

        <div class="row">
            <div class="col-sm-6">
                <?php //$format = new MyFormatter(); 
                ?>
                <?php echo CHtml::hiddenField('type', ''); ?>
                <div class="control-group">
                    <?php echo $form->hiddenField($model, 'pilihan_tab'); ?>
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
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div id='searching'>
                    <fieldset>
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'kunjungan',
                            'slide' => true,
                            'content' => array(
                                'content2' => array(
                                    'header' => 'Berdasarkan Jenis Diet',
                                    'isi' => '  <table><tr></tr></table>
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
                        ));
                        ?>
                    </fieldset>
                </div>
            </div>

            <div class="col-sm-6">
                <div id='searching'>
                    <fieldset>
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'kunjungan',
                            'slide' => true,
                            'content' => array(
                                'content3' => array(
                                    'header' => 'Berdasarkan Waktu',
                                    'isi' => '  <table><tr></tr></table>
                                            <table class="penjamin">                                            
                                            <tr>
                                                    <td><div class="controls">' .
                                        CHtml::checkBox('pilihSemuaWaktu', true, array('onclick' => 'pilihSemuaJenisWaktu();')) . '<label><b>Pilih Semua</b></label>
                        <div id="cbWaktu">
                            ' . $form->checkBoxList($model, 'jeniswaktu_id', CHtml::listData(JeniswaktuM::model()->findAll('jeniswaktu_aktif = true'), 'jeniswaktu_id', 'jeniswaktu_nama'), array('onkeypress' => "return $(this).focusNextInputField(event)")) . '<br>
                        </div>                
                    </div></td>
                                            </tr>
                                            </table>',
                                    'active' => true,
                                ),
                            ),
                            //                                    'htmlOptions'=>array('class'=>'aw',)
                        ));
                        ?>
                    </fieldset>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <div style="float:left;margin-right:6px;">
                <?php // echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit')); 
                ?>
                <?php
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                    array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'ajax' => array(
                        'type' => 'GET',
                        'url' => array("/" . $this->route),
                        'update' => '#tables',
                        'beforeSend' => 'function(){
                                  $("#tables").addClass("animation-loading");
                              }',
                        'complete' => 'function(){
                                  $("#tables").removeClass("animation-loading");
                              }',
                    ))
                );
                ?>
                <?php echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset', 'onClick' => 'onReset()')
                ); ?>
            </div>

        </div>
        <div style="clear:both;"></div>
    </div>
</div>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
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

    function pilihSemuaJenisWaktu() {
        if ($("#pilihSemuaWaktu").is(':checked')) {
            $("#cbWaktu").find("input[type=\'checkbox\']").attr("checked", "checked");
        } else {
            $("#cbWaktu").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }
    pilihSemuaJenisWaktu();
</script>