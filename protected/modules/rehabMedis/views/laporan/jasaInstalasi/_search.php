<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
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
                .form-horizontal .radio>label,
                .form-horizontal .checkbox>label {
                    float: left !important;
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

                    <div class="control-group">
                        <label class="control-label">Status Bayar</label>
                        <div class="controls">
                            <?php echo $form->checkBoxList($model, 'tindakansudahbayar_id', CustomFunction::getStatusBayar(), array('value' => 'pengunjung', 'inline' => true, 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>


                    <!--<div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="glyphicon glyphicon-file"></i> Berdasarkan Status Bayar
                            </div>
                        </div>
                        <div class="panel-body">
                            <?php echo '<table>
                        <tr>
                            <td>
                                <div class="penjamin">' .
                                $form->checkBoxList($model, 'tindakansudahbayar_id', CustomFunction::getStatusBayar(), array('value' => 'pengunjung', 'inline' => true, 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")) . '
                                </div>
                            </td>
                        </tr>
                    </table>'; ?>
                            </fieldset>
                        </div>
                    </div>-->
                </div>

                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')); ?>
                        <label class="control-label">Jenis Penjamin</label>
                        <div class="controls">
                            <?php echo $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                                'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => Yii::app()->createUrl('ActionDynamic/GetPenjaminPasienForCheckBox', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                                    'update' => '#penjamin',  //selector to update
                                ),
                            )); ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Penjamin</label>
                        <div class="controls">
                            <?php echo '<label>Data tidak ditemukan.</label>'; ?>
                        </div>
                    </div>

                    <!--<div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="glyphicon glyphicon-file"></i> Berdasarkan Jenis Penjamin
                            </div>
                        </div>
                        <div class="panel-body">
                            <?php echo '<table>
                        <tr>
                            <td>' . CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) . '<label>Cara&nbsp;Bayar</label></td>
                            <td>' . $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                                'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => Yii::app()->createUrl('ActionDynamic/GetPenjaminPasienForCheckBox', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                                    'update' => '#penjamin',  //selector to update
                                ),
                            )) . '
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Penjamin</label>
                            </td>
                            <td>
                                <div id="penjamin">' .
                                //                                                                $form->checkBoxList($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems2(), 'penjamin_id', 'penjamin_nama'), array('value'=>'pengunjung',  'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")).
                                ' <label>Data tidak ditemukan.</label>
                                </div>
                            </td>
                        </tr>
                     </table>'; ?>
                        </div>
                    </div>-->
                </div>
            </div>

            <div class="form-actions">
                <?php
                echo CHtml::htmlButton(
                    Yii::t(
                        'mds',
                        '{icon} Search',
                        array('{icon}'  => '<i class="entypo-search"></i>')
                    ),
                    array(
                        'title' => 'Cari',
                        'class'   => 'btn btn-danger',
                        'type'  => 'submit',
                        'id'    => 'btn_simpan'
                    )
                );
                ?>
                <?php
                echo CHtml::link(
                    Yii::t(
                        'mds',
                        '{icon} Ulang',
                        array('{icon}' => '<i class="entypo-arrows-ccw"></i>')
                    ),
                    Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                    )
                );
                ?>
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
',  CClientScript::POS_READY);
        ?>
        <?php
        //$urlGetPenjamin = Yii::app()->createUrl('ActionDynamic/GetPenjaminPasienForCheckBox', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().''));
        //Yii::app()->clientScript->registerScript('ajax','
        //    $("#'.CHtml::activeId($model, 'carabayar_id').'").change(function(){
        //        id = $(this).val();
        //        $.post("'.$urlGetPenjamin.'", {id:id},function(data){
        //            
        //        });
        //    });
        //',CClientScript::POS_READY); 
        ?>

        <?php //Yii::app()->clientScript->registerScript('onclickButton','
        //  var tampilGrafik = "<div class=\"tampilGrafik\" style=\"display:inline-block\"> <i class=\"icon-arrow-right icon-white\"></i> Grafik</div>";
        //  $(".accordion-heading a.accordion-toggle").click(function(){
        //            $(this).parents(".accordion").find("div.tampilGrafik").remove();
        //            $(this).parents(".accordion-group").has(".accordion-body.in").length ? "" : $(this).append(tampilGrafik);
        //            
        //            
        //  });
        //',  CClientScript::POS_READY);
        ?>
    </div>
</div>