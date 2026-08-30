<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pasien Penunjang</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Informasi Pasien Penunjang',
        );
        Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                $('.search-form').toggle();
                return false;
            });
            $('#search').submit(function(){
                $.fn.yiiGridView.update('informasiPenunjang-grid', {
                    data: $(this).serialize()
                });
                return false;
            });
        ");
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body form-search">
                <?php
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'action' => Yii::app()->createUrl($this->route),
                    'method' => 'get',
                    'id' => 'search',
                    'type' => 'horizontal',
                ));
                ?>
                <?php //echo $form->textFieldRow($modPenunjang,'no_pendaftaran',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50));  
                ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php
                            echo CHtml::label("Tgl. Pendaftaran", 'tgl_rekam', array('class' => 'control-label'))
                            ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($modPenunjang->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($modPenunjang->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span>
                                        <?php
                                        echo date('d M Y', strtotime($modPenunjang->tgl_awal))
                                        ?> -
                                        <?php
                                        echo date('d M Y', strtotime($modPenunjang->tgl_akhir))
                                        ?>
                                    </span>
                                    <?php
                                    echo $form->hiddenField($modPenunjang, 'tgl_awal', array('class' => 'start'))
                                    ?>
                                    <?php
                                    echo $form->hiddenField($modPenunjang, 'tgl_akhir', array('class' => 'end'))
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        echo $form->textFieldRow(
                            $modPenunjang,
                            'nama_pasien',
                            array('placeholder' => 'Nama Pasien', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)
                        );
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <?php
                        echo $form->textFieldRow(
                            $modPenunjang,
                            'no_rekam_medik',
                            array('placeholder' => 'No. Rekam Medik', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)
                        );
                        ?>
                        <?php
                        echo $form->textFieldRow(
                            $modPenunjang,
                            'no_pendaftaran',
                            array('placeholder' => 'No. Pendaftaran', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'autofocus' => TRUE)
                        );
                        ?>
                    </div>
                </div>
                <div class="form-actions">
                    <?php
                    echo CHtml::htmlButton(
                        Yii::t(
                            'mds',
                            '{icon} Search',
                            array('{icon}' => '<i class="entypo-search"></i>')
                        ),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
                    );
                    ?>
                    <?php
                    echo CHtml::htmlButton(
                        Yii::t(
                            'mds',
                            '{icon} Reset',
                            array('{icon}' => '<i class="entypo-arrows-ccw"></i>')
                        ),
                        array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
                    );
                    ?>
                    <?php
                    $content = $this->renderPartial('informasi.views.tips.informasi', array(), true);
                    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
                    ?>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Penunjang</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasiPenunjang-grid',
                    'dataProvider' => $modPenunjang->searchPenunjang(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'columns' => array(
                        array(
                            'name' => 'pendaftaran.tgl_pendaftaran',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->pendaftaran->tgl_pendaftaran)',
                        ),
                        array(
                            'header' => 'No. Pendaftaran',
                            'name' => 'pendaftaran.no_pendaftaran',
                            'type' => 'raw',
                            'value' => '$data->pendaftaran->no_pendaftaran',
                            'htmlOptions' => array('style' => 'width:120px')
                        ),
                        array(
                            'header' => 'No. Rekam Medik',
                            'type' => 'raw',
                            'value' => '$data->pasien->no_rekam_medik',
                            'htmlOptions' => array('style' => 'width:120px')
                        ),
                        array(
                            'header' => 'Nama Pasien',
                            'type' => 'raw',
                            'value' => '$data->pasien->nama_pasien',
                        ),
                        array(
                            'header' => 'Ruangan Penunjang',
                            'type' => 'raw',
                            'value' => '$data->ruangan->ruangan_nama',
                        ),
                        array(
                            'header' => 'Ruangan Asal',
                            'type' => 'raw',
                            'value' => '$data->ruanganasal->ruangan_nama',
                        ),
                        array(
                            'header' => 'No. Masuk Penunjang',
                            'type' => 'raw',
                            'value' => '$data->no_masukpenunjang',
                        ),
                        array(
                            'header' => 'Tanggal Masuk Penunjang',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang)',
                        ),
                        array(
                            'header' => 'Kelas Pelayanan',
                            'type' => 'raw',
                            'value' => '$data->kelaspelayanan->kelaspelayanan_nama',
                        ),
                        array(
                            'header' => 'Jenis Kasus Penyakit',
                            'type' => 'raw',
                            'value' => '$data->jeniskasuspenyakit->jeniskasuspenyakit_nama',
                            'htmlOptions' => array('style' => 'text-align: left; width: 75px;')
                        ),
                        array(
                            'header' => 'Keterangan Pendaftaran',
                            'name' => 'pendaftaran.keterangan_pendaftaran',
                            'type' => 'raw',
                            'value' => '$data->pendaftaran->keterangan_pendaftaran',
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>