<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Permintaan Penawaran</b>
                </div>
            </div>
            <div class="panel-body">
                <?php
                $this->breadcrumbs = array(
                    'Permintaan Penawaran',
                );
                if (isset($_GET['sukses'])) {
                    Yii::app()->user->setFlash('success', "Data Permintaan Penawaran berhasil disimpan!");
                }
                ?>
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

                <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'permintaanpenawaran-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
                    'focus' => '#' . CHtml::activeId($modPermintaanPenawaran, 'keteranganpenawaran'),
                )); ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Data <b>Permintaan Penawaran</b>
                        </div>
                    </div>
                    <div class="panel-body" id="form-permintaanpenawaran">
                        <!--fieldset class="box" id="form-permintaanpenawaran"-->
                        <div>
                            <?php isset($_GET['ubah']) ? $modPermintaanPenawaran->permintaanpenawaran_id = '' : ''; ?>
                            <?php $this->renderPartial($this->path_view . '_formPermintaanPenawaran', array('form' => $form, 'format' => $format, 'modPermintaanPenawaran' => $modPermintaanPenawaran, 'modRencanaKebFarmasi' => $modRencanaKebFarmasi)); ?>
                        </div>
                        <!--</fieldset>-->
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class='fas fa-tablets'></i> Obat dan Alkes
                        </div>
                    </div>
                    <div class="panel-body" id="form-tambahobatalkes">
                        <?php if (!isset($modRencanaKebFarmasi->rencanakebfarmasi_id)) { ?>
                            <!--fieldset class="box" id="form-tambahobatalkes"-->
                            <div class="row">
                                <?php $this->renderPartial($this->path_view . '_formObatAlkesPasien', array('form' => $form, 'format' => $format, 'modPermintaanPenawaran' => $modPermintaanPenawaran, 'modRencanaKebFarmasi' => $modRencanaKebFarmasi)); ?>
                            </div>
                            <!--</fieldset>-->
                        <?php } ?>
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <i class="entypo-credit-card"></i> Tabel <b>Permintaan Penawaran</b>
                                </div>
                            </div>
                            <div class="panel-body table-responsive">
                                <div id="table-obatalkespasien">
                                    <table class="items table table-bordered table-striped table-condensed" id="table-obatalkespasien">
                                        <thead>
                                            <tr>
                                                <th>No.Urut</th>
                                                <th>Asal Barang</th>
                                                <th>Nama Obat</th>
                                                <th>Stok</th>
                                                <th>Jumlah Permintaan (Satuan)</th>
                                                <th>Satuan Kecil/Besar</th>
                                                <th>Minimal Stok</th>
                                                <th>Harga Satuan (Rp)</th>
                                                <th>Sub Total (Rp)</th>
                                                <?php echo ((!isset($_GET['sukses'])) ? "<th>Batal</th>" : ""); ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (count((array)$modDetails) > 0) {
                                                foreach ($modDetails as $i => $modPenawaranDetail) {
                                                    echo $this->renderPartial($this->path_view . '_rowObatAlkesPasien', array('modPermintaanPenawaran' => $modPermintaanPenawaran, 'modPenawaranDetail' => $modPenawaranDetail, 'modObatAlkes' => $modObatAlkes));
                                                }
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="8">Total</td>
                                                <td><?php echo CHtml::textField('total', '', array('class' => 'span2 integer2', 'style' => 'width:90px;')); ?></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
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
                                    <?php echo Chtml::label("Pegawai Mengetahui <span style='color:red'>*</span>", 'pegawaimengetahui_id', array('class' => 'control-label')); ?>
                                    <div class="controls">
                                        <?php echo $form->hiddenField($modPermintaanPenawaran, 'pegawaimengetahui_id', array('readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                                        <?php
                                        $this->widget('MyJuiAutoComplete', array(
                                            'model' => $modPermintaanPenawaran,
                                            'attribute' => 'pegawaimengetahui_nama',
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
														$("#' . Chtml::activeId($modPermintaanPenawaran, 'pegawaimengetahui_id') . '").val(ui.item.pegawai_id); 
														return false;
													}',
                                            ),
                                            'htmlOptions' => array(
                                                'class' => 'pegawaimengetahui_nama  hurufs-only required',
                                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                                'onblur' => 'if(this.value === "") $("#' . CHtml::activeId($modPermintaanPenawaran, 'pegawaimengetahui_id') . '").val(""); ',
                                                'placeholder' => 'Pegawai Mengetahui'
                                            ),
                                            'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="control-group">
                                    <?php echo Chtml::label("Pegawai Menyetujui <span style='color:red'>*</span>", 'pegawaimenyetujui_id', array('class' => 'control-label')); ?>
                                    <div class="controls">
                                        <?php echo $form->hiddenField($modPermintaanPenawaran, 'pegawaimenyetujui_id', array('readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                                        <?php
                                        $this->widget('MyJuiAutoComplete', array(
                                            'model' => $modPermintaanPenawaran,
                                            'attribute' => 'pegawaimenyetujui_nama',
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
														$("#' . Chtml::activeId($modPermintaanPenawaran, 'pegawaimenyetujui_id') . '").val(ui.item.pegawai_id); 
														return false;
													}',
                                            ),
                                            'htmlOptions' => array(
                                                'class' => 'pegawaimenyetujui_nama hurufs-only required',
                                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                                'onblur' => 'if(this.value === "") $("#' . CHtml::activeId($modPermintaanPenawaran, 'pegawaimenyetujui_id') . '").val(""); ',
                                                'placeholder' => 'Pegawai Menyetujui'
                                            ),
                                            'tombolDialog' => array('idDialog' => 'dialogPegawaiMenyetujui'),
                                        ));
                                        ?>
                                    </div>
                                </div>
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
                            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);')
                        );
                    } else {
                        echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true)
                        );
                    }
                    if (!isset($_GET['frame'])) {
                        echo CHtml::link(
                            Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
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
                        //                        echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),'javascript:void(0);',array('class'=>'btn btn-info', 'disabled'=>'true'));  /**RND-4044*/
                    } else {
                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')"));
                        //                        echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')"));  /**RND-4044*/
                    }

                    $content = $this->renderPartial($this->path_view . 'tips/tipsRencanaKebutuhan', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>

                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('modPermintaanPenawaran' => $modPermintaanPenawaran, 'modRencanaKebFarmasi' => $modRencanaKebFarmasi)); ?>