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
    <table style="width: 100%; border: none;">
        <tr>
            <td>
                <div class="col-sm-6">
                    <?php echo CHtml::hiddenField('type', ''); ?>
                    <div class="control-group">
                        <?php echo $form->hiddenField($model, 'jns_periode', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($model, 'bln_awal', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($model, 'bln_akhir', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($model, 'thn_awal', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($model, 'thn_akhir', array('class' => 'span2')); ?>
                        <?php echo CHtml::label("Periode Laporan", '', array('class' => 'control-label')) ?>
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
                    <div id='searching'>
                        <fieldset>
                            <?php
                            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                                'id' => 'form-2',
                                'content' => array(
                                    'content2' => array(
                                        'header' => 'Berdasarkan Jenis Penjamin',
                                        'isi' => '<table><tr>
                                                                                                                        <td>' . CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) . '<label>Jenis Penjamin</label></td>
                                                                                                                        <td>' . $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                                            'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                            'ajax' => array(
                                                'type' => 'POST',
                                                'url' => $this->createUrl('SetDropdownPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
                                                'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data);}',
                                            ),
                                            'class' => 'span3',
                                        )) . '</td>
                                                                                                                                </tr><tr>
                                                                                                                        <td><label>Penjamin</label></td><td>' .
                                            $form->dropDownList($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')) . '</td></tr></table>',
                                        'active' => true,
                                    ),
                                ),
                            ));
                            ?>
                        </fieldset>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="col-sm-6">
                    <div id='searching'>
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <i class="fas fa-chart-bar"></i> Grafik pengunjung/kunjungan
                                </div>
                            </div>
                            <div class="panel-body">
                                <?php echo '<table>
                                                            <tr>
                                                            <td>' .
                                    $form->radioButtonList($model, 'pilihanx', $model::berdasarkanStatus(), array('value' => 'pengunjung', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td></tr></table>';
                                ?>
                            </div>
                            </fieldset>
                        </div>
                    </div>
            </td>
        </tr>
    </table>

    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'ajax' => array(
            'type' => 'GET',
            'url' => array("/" . $this->route),
            'update' => '#tableLaporan',
            'beforeSend' => 'function(){
								 $("#tableLaporan").addClass("animation-loading");
							 }',
            'complete' => 'function(){
								 $("#tableLaporan").removeClass("animation-loading");
							 }',
        )));
        ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''), array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        ));
        ?>
    </div>
</div>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>