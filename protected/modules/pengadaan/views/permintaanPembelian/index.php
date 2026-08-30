<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-shopping-cart"></i> Permintaan <b>Pembelian</b>
                </div>
            </div>
            <div class="panel-body">
                <?php
                if (isset($_GET['sukses'])) {
                    Yii::app()->user->setFlash('success', "Data Permintaan Pembelian berhasil disimpan!");
                }
                ?>
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'permintaanpembelian-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
                    'focus' => '#' . CHtml::activeId($modPermintaanPembelian, 'keteranganpermintaan'),
                ));
                ?>

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Data <b>Permintaan Pembelian</b>
                        </div>
                    </div>
                    <div class="panel-body" id="form-permintaanpembelian">
                        <!--fieldset class="box" id="form-permintaanpembelian"-->
                        <div>
                            <?php $this->renderPartial($this->path_view . '_formPermintaanPembelian', array('form' => $form, 'format' => $format, 'modPermintaanPembelian' => $modPermintaanPembelian, 'modRencanaKebFarmasi' => $modRencanaKebFarmasi, 'modPermintaanPenawaran' => $modPermintaanPenawaran)); ?>
                        </div>
                        <!--</fieldset>-->
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="fas fa-first-aid"></i> Obat dan Alkes
                        </div>
                    </div>
                    <div class="panel-body" id="form-tambahobatalkes">
                        <?php if (!isset($_GET['sukses'])) { ?>
                            <!--fieldset class="box" id="form-tambahobatalkes"-->
                            <div class="row">
                                <?php $this->renderPartial($this->path_view . '_formObatPermintaanPembelian', array('modPermintaanPembelian' => $modPermintaanPembelian)); ?>
                            </div>
                            <!--</fieldset>-->
                        <?php } ?>
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <i class="entypo-credit-card"></i> Tabel <b>Permintaan Pembelian</b>
                                </div>
                            </div>
                            <div class="panel-body table-responsive">
                                <table class="items table table-bordered table-striped table-condensed" id="table-obatalkespasien">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Asal Barang</th>
                                            <th>Kategori / Nama Obat</th>
                                            <th>Satuan</th>
                                            <th>Jumlah Pembelian</th>
                                            <th>Harga Satuan (Rp)</th>
                                            <th>Stok Akhir</th>
                                            <th>PPN (%)</th>
                                            <th>PPh (%)</th>
                                            <th>Keringanan (%)</th>
                                            <th>Keringanan Total (Rp)</th>
                                            <th>Minimal Stok</th>
                                            <th>Sub Total (Rp)</th>
                                            <th>Batal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (count((array)$modDetails) > 0) {
                                            foreach ($modDetails as $i => $modPermintaanPembelianDetail) {
                                                echo $this->renderPartial($this->path_view . '_rowObatPermintaanPembelian', array('modPermintaanPembelian' => $modPermintaanPembelian, 'modPermintaanPembelianDetail' => $modPermintaanPembelianDetail));
                                            }
                                        }
                                        ?>
                                    <tfoot>
                                        <tr>
                                            <td colspan="12">Total</td>
                                            <td><?php echo CHtml::textField('total', '', array('class' => 'span2 integer2', 'style' => 'width:90px;')) ?></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                    </tbody>
                                </table>
                                <?php isset($_GET['ubah']) ? $modPermintaanPembelian->permintaanpembelian_id = '' : ''; ?>
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
                                    <?php echo CHtml::label("Pegawai Mengetahui <span style = 'color:red'>*</span>", 'pegawaimengetahui_id', array('class' => 'control-label')); ?>
                                    <div class="controls">
                                        <?php echo $form->hiddenField($modPermintaanPembelian, 'pegawaimengetahui_id', array('readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                                        <?php
                                        $this->widget('MyJuiAutoComplete', array(
                                            'model' => $modPermintaanPembelian,
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
                                                                    $("#' . Chtml::activeId($modPermintaanPembelian, 'pegawaimengetahui_id') . '").val(ui.item.pegawai_id); 
                                                                    return false;
                                                            }',
                                            ),
                                            'htmlOptions' => array(
                                                'class' => 'span3 pegawaimengetahui_nama required angkahuruf-only',
                                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                                'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modPermintaanPembelian, 'pegawaimengetahui_id') . '").val(""); '
                                            ),
                                            'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="control-group">
                                    <?php echo Chtml::label("Pegawai Menyetujui <span style = 'color:red'>*</span>", 'pegawaimenyetujui_id', array('class' => 'control-label')); ?>
                                    <div class="controls">
                                        <?php echo $form->hiddenField($modPermintaanPembelian, 'pegawaimenyetujui_id', array('readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                                        <?php
                                        $this->widget('MyJuiAutoComplete', array(
                                            'model' => $modPermintaanPembelian,
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
                                                                        $("#' . Chtml::activeId($modPermintaanPembelian, 'pegawaimenyetujui_id') . '").val(ui.item.pegawai_id); 
                                                                        return false;
                                                                }',
                                            ),
                                            'htmlOptions' => array(
                                                'class' => 'span3 pegawaimenyetujui_nama required angkahuruf-only',
                                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                                'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modPermintaanPembelian, 'pegawaimenyetujui_id') . '").val(""); '
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
                    //                if(!isset($_GET['sukses'])){
                    //                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'disabled'=>'true'));
                    //    //                echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),'javascript:void(0);',array('class'=>'btn btn-info', 'disabled'=>'true'));  /**RND-4045*
                    //                }else{
                    //                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
                    //    //                echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); /**RND-4045*
                    //                }

                    $content = $this->renderPartial($this->path_view . 'tips/tipsPermintaanPembelian', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>

                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('modPermintaanPembelian' => $modPermintaanPembelian, 'modRencanaKebFarmasi' => $modRencanaKebFarmasi, 'modPermintaanPenawaran' => $modPermintaanPenawaran)); ?>