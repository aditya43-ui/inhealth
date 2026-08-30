<?php
$this->breadcrumbs = array(
    'Transaksi Rencana Kebutuhan',
); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Rencana Kebutuhan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'rencanakebutuhan-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);'), //dimatikan karena pakai cekObat >> ,'onsubmit'=>'return requiredCheck(this);'
        )); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Rencana Kebutuhan</b>
                </div>
            </div>
            <div class="panel-body" id="form-rencanakebutuhan">
                <!--fieldset class="box" id="form-rencanakebutuhan"-->
                <div>
                    <?php $this->renderPartial($this->path_view . '_formRencanaKebutuhan', array('form' => $form, 'format' => $format, 'modRencanaKebBarang' => $modRencanaKebBarang)); ?>
                </div>
                <!--</fieldset>-->
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Recomended Order (RO)
                </div>
            </div>
            <div class="panel-body" id="form-recomendedorder">
                <!--fieldset class="box"-->
                <div>
                    <?php $this->renderPartial($this->path_view . '_formRecomendedBarang', array('form' => $form, 'format' => $format, 'modRencanaKebBarang' => $modRencanaKebBarang)); ?>
                </div>
                <!--</fieldset>-->
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="far fa-plus-square"></i> Tambah <b>Bahan Makanan</b>
                </div>
            </div>
            <div class="panel-body" id="form-tambahobatalkes">
                <?php if (!isset($_GET['sukses'])) { ?>
                    <?php $this->renderPartial($this->path_view . '_formBarangRencanaKebutuhan', array('modRencanaKebBarang' => $modRencanaKebBarang)); ?>
                <?php } ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Rencana Kebutuhan</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="items table table-bordered table-striped table-condensed" id="table-barang">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Golongan</th>
                                    <th>Jenis</th>
                                    <th>Kelompok</th>
                                    <th>Nama Bahan Makanan</th>
                                    <th>Stok Akhir</th>
                                    <th>Min Stok</th>
                                    <th>Jumlah Kebutuhan</th>
                                    <th>Harga Netto</th>
                                    <th>PPN (%)</th>
                                    <th>PPN (Rp)</th>
                                    <th>Sub Total (Rp)</th>
                                    <th>Batal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (count((array)$modDetails) > 0) {
                                    foreach ($modDetails as $i => $modRencanaDetailKebBarang) {
                                        $modRencanaDetailKebBarang->jmlpermintaandet = number_format($modRencanaDetailKebBarang->jmlpermintaandet, 2, ",", ".");
                                        echo $this->renderPartial($this->path_view . '_rowBarangRencanaKebutuhan', array('modRencanaDetailKebBarang' => $modRencanaDetailKebBarang, 'modRencanaKebBarang' => $modRencanaKebBarang));
                                    }
                                }
                                ?>
                            <tfoot>
                                <tr>
                                    <td colspan="11" style="text-align:right;">Total</td>
                                    <td><?php echo  CHtml::textField('total', '', array('class' => 'span2 integer-decimal', 'style' => 'width:90px; text-align:right;', 'readonly' => true)); ?></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                            </tbody>
                        </table>

                        <?php isset($_GET['ubah']) ? $modRencanaKebBarang->renkebbahanmakanan_id = '' : ''; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Pegawai Berwenang
                </div>
            </div>
            <div class="panel-body">
                <!--fieldset class="box"-->
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo Chtml::label("Pegawai Gizi <span style='color:red;'>*</span>", 'pegmengetahui_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($modRencanaKebBarang, 'pegmengetahui_id', array('readonly' => true)); ?>
                                <?php echo $form->textField($modRencanaKebBarang, 'pegmengetahui_nama', array('readonly' => true, 'class' => 'required')); ?>
                                <?php
                                /*$this->widget('MyJuiAutoComplete', array(
												'model'=>$modRencanaKebBarang,
												'attribute' => 'pegmengetahui_nama',
												'source' => 'js: function(request, response) {
																   $.ajax({
																	   url: "' . $this->createUrl('AutocompletePegawaiMengetahui') . '",
																	   dataType: "json",
																	   data: {
																		   term: request.term,
																	   },
																	   success: function (data) {
																			   response(data);
																	   }
																   })
																}',
												'options' => array(
													'showAnim' => 'fold',
													'minLength' => 3,
													'focus' => 'js:function( event, ui ) {
														$(this).val( ui.item.label);
														return false;
													}',
													'select' => 'js:function( event, ui ) {
														$("#'.Chtml::activeId($modRencanaKebBarang, 'pegmengetahui_id') . '").val(ui.item.pegawai_id); 
														return false;
													}',
												),
												'htmlOptions' => array(
													'class'=>'pegawaimengetahui_nama',
													'onkeyup'=>"return $(this).focusNextInputField(event)",
													'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modRencanaKebBarang, 'pegmengetahui_id') . '").val(""); '
												),
												'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
											));*/
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo Chtml::label("Kepala Instalasi Gizi <span style='color:red;'>*</span>", 'pegmengetahui_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($modRencanaKebBarang, 'pegmenyetujui_id', array('readonly' => true)); ?>
                                <?php echo $form->textField($modRencanaKebBarang, 'pegmenyetujui_nama', array('readonly' => true, 'class' => 'required')); ?>
                            </div>
                        </div>
                        <?php /*
									<div class="control-group">
										<?php echo Chtml::label("Kepala Instalasi Gizi <span style='color:red;'>*</span>", 'pegmenyetujui_id', array('class' => 'control-label')); ?>
										<div class="controls">
											<?php echo $form->hiddenField($modRencanaKebBarang, 'pegmenyetujui_id',array('readonly'=>true)); ?>
											<?php
											$this->widget('MyJuiAutoComplete', array(
												'model'=>$modRencanaKebBarang,
												'attribute' => 'pegmenyetujui_nama',
												'source' => 'js: function(request, response) {
													$.ajax({
														url: "' . $this->createUrl('AutocompletePegawaiMenyetujui') . '",
														dataType: "json",
														data: {
															term: request.term,
														},
														success: function (data) {
															response(data);
														}
													})
												}',
												'options' => array(
													'showAnim' => 'fold',
													'minLength' => 3,
													'focus' => 'js:function( event, ui ) {
														$(this).val( ui.item.label);
														return false;
													}',
													'select' => 'js:function( event, ui ) {
														$("#'.Chtml::activeId($modRencanaKebBarang, 'pegmenyetujui_id') . '").val(ui.item.pegawai_id); 
														return false;
													}',
												),
												'htmlOptions' => array(
													'class'=>'pegawaimenyetujui_nama required hurufs-only',
													'onkeyup'=>"return $(this).focusNextInputField(event)",
													'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modRencanaKebBarang, 'pegmenyetujui_id') . '").val(""); '
												),
												'tombolDialog' => array('idDialog' => 'dialogPegawaiMenyetujui'),
											));
											?>
										</div>
									</div>
                                     * 
                                     */ ?>
                    </div>
                </div>
                <!--</fieldset>-->
            </div>
        </div>

        <div class="form-actions">
            <?php
            if (!isset($_GET['sukses'])) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'cekBarang();', 'onkeypress' => 'cekBarang();')
                ); //formSubmit(this,event)
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true)
                );
            }
            if (!isset($_GET['frame'])) {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'return refreshForm(this);'
                    )
                );
            }
            if (!isset($_GET['sukses'])) {
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => 'true'));
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')"));
            }

            $content = $this->renderPartial($this->path_view . 'tips/tipsRencanaKebutuhan', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('modRencanaKebBarang' => $modRencanaKebBarang)); ?>