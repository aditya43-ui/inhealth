<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'waktu_operasi', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField(
                    $model,
                    'waktu_operasi',
                    array('class' => 'span3', 'rows' => 3, 'readonly' => true,)
                );
                // $this->widget('MyDateTimePicker', array(
                //     'model' => $model,
                //     'attribute' => 'waktu_operasi',
                //     'value' => $tblRencanaOperasi->tglrencanaoperasi,
                //     'mode' => 'datetime',
                //     'options' => array(
                //         'dateFormat' => Params::DATE_FORMAT,
                //     ),
                //     'htmlOptions' => array(
                //         'readonly' => true,
                //         'onkeypress' => "return $(this).focusNextInputField(event)",
                //         'class' => 'span3 htpd',
                //         'placeholder' => date('d M Y H:i:s'),
                //     ),
                // ));
                ?>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'kamar_ruangan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField(
                    $model,
                    'kamar_ruangan',
                    array('class' => 'span3', 'rows' => 3, 'readonly' => true)
                );
                ?>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group ">
            <label class="control-label"><b>Kru Bedah</b></label>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'operator', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField(
                    $model,
                    'operator',
                    array('class' => '', 'rows' => 3, 'disabled' => true)
                );
                ?>
            </div>
        </div>
        <?php
            if (isset($model->setKruBedah[Params::KRUBEDAH_OPERATOR]['det'])){
                foreach($model->setKruBedah[Params::KRUBEDAH_OPERATOR]['det'] as $key => $val){
                    $this->renderPartial('kru-bedah/_rowKru',['model'=>$val]);
                }
            }
        ?>
    </div>
</div>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'asisten_operator', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField(
                    $model,
                    'asisten_operator',
                    array('class' => '', 'rows' => 3, 'disabled' => true)
                );
                ?>
            </div>
        </div>
        <?php
            if (isset($model->setKruBedah[Params::KRUBEDAH_ASISTEN_OPERATOR]['det'])){
                foreach($model->setKruBedah[Params::KRUBEDAH_ASISTEN_OPERATOR]['det'] as $key => $val){
                    $this->renderPartial('kru-bedah/_rowKru',['model'=>$val]);
                }
            }
        ?>
    </div>
</div>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'dokter_anestesi', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField(
                    $model,
                    'dokter_anestesi',
                    array('class' => '', 'rows' => 3, 'disabled' => true)
                );
                ?>
            </div>
        </div>
        <?php
            if (isset($model->setKruBedah[Params::KRUBEDAH_DOKTER_ANESTESI]['det'])){
                foreach($model->setKruBedah[Params::KRUBEDAH_DOKTER_ANESTESI]['det'] as $key => $val){
                    $this->renderPartial('kru-bedah/_rowKru',['model'=>$val]);
                }
            }
        ?>
    </div>
</div>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'perawat_anestesi', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField(
                    $model,
                    'perawat_anestesi',
                    array('class' => '', 'rows' => 3, 'disabled' => true)
                );
                ?>
            </div>
        </div>
        <?php
            if (isset($model->setKruBedah[Params::KRUBEDAH_PERAWAT_ANESTESI]['det'])){
                foreach($model->setKruBedah[Params::KRUBEDAH_PERAWAT_ANESTESI]['det'] as $key => $val){
                    $this->renderPartial('kru-bedah/_rowKru',['model'=>$val]);
                }
            }
        ?>
    </div>
</div>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'perawat_sirkuler', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField(
                    $model,
                    'perawat_sirkuler',
                    array('class' => '', 'rows' => 3, 'disabled' => true)
                );
                ?>
            </div>
        </div>
        <?php
            if (isset($model->setKruBedah[Params::KRUBEDAH_PERAWAT_SIRKULER]['det'])){
                foreach($model->setKruBedah[Params::KRUBEDAH_PERAWAT_SIRKULER]['det'] as $key => $val){
                    $this->renderPartial('kru-bedah/_rowKru',['model'=>$val]);
                }
            }
        ?>
    </div>
</div>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'posisi', array('class' => 'control-label')) ?>
            <div class="row-fluid">
                <div class="col-sm-3">
                    <?php echo $form->radioButton($model, 'posisi', array('value' => 'tengkurap', 'disabled' => $jenis == 'lihat', 'id' => 'tengkurap','uncheckValue'=>null)); ?>
                    <label for="tengkurap">Tengkurap</label>
                </div>
                <div class="col-sm-3">
                    <?php echo $form->radioButton($model, 'posisi', array('value' => 'telentang', 'disabled' => $jenis == 'lihat', 'id' => 'telentang','uncheckValue'=>null)); ?>
                    <label for="telentang">Telentang</label>
                </div>
                <div class="col-sm-3">
                    <?php echo $form->radioButton($model, 'posisi', array('value' => 'litotomi', 'disabled' => $jenis == 'lihat', 'id' => 'litotomi','uncheckValue'=>null)); ?>
                    <label for="litotomi">Litotomi</label>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">&nbsp;</label>
            <div class="row-fluid">
                <div class="col-sm-3">
                    <?php echo $form->radioButton($model, 'posisi', array('value' => 'miring kiri', 'disabled' => $jenis == 'lihat', 'id' => 'miring_kiri','uncheckValue'=>null)); ?>
                    <label for="miring_kiri">Miring Kiri</label>
                </div>
                <div class="col-sm-3">                    
                    <?php echo $form->radioButton($model, 'posisi', array('value' => 'miring kanan', 'disabled' => $jenis == 'lihat', 'id' => 'miring_kanan','uncheckValue'=>null)); ?>
                    <label for="miring_kanan">Miring Kanan</label>
                </div>
                <div class="col-sm-3">                    
                    <?php echo $form->radioButton($model, 'posisi', array('value' => 'miring kanan', 'disabled' => $jenis == 'lihat', 'id' => 'miring_kanan','uncheckValue'=>null)); ?>
                    <label for="miring_kanan">Miring Kanan</label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'torniket', array('class' => 'control-label')) ?>
            <div class="row-fluid">
                <div class="col-sm-3">
                    <?php echo  $form->radioButton($model, 'torniket', array('value' => 'lengan kanan', 'disabled' => $jenis == 'lihat', 'id' => 'lengankanan', 'class' => 'radioToniket', 'uncheckValue' => null)); ?>
                    <label for="lengankanan">Lengan Kanan</label>
                </div>
                <div class="col-sm-3">
                    <?php echo  $form->radioButton($model, 'torniket', array('value' => 'lengan kiri', 'disabled' => $jenis == 'lihat', 'id' => 'lengankiri', 'class' => 'radioToniket', 'uncheckValue' => null)); ?>
                    <label for="lengankiri">Lengan Kiri</label>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">&nbsp;</label>
            <div class="row-fluid">
                <div class="col-sm-3">
                    <?php echo  $form->radioButton($model, 'torniket', array('value' => 'tungkai kanan', 'disabled' => $jenis == 'lihat', 'id' => 'tungkaikanan', 'class' => 'radioToniket', 'uncheckValue' => null)); ?>
                    <label for="tungkaikanan">Tungkai Kanan</label>
                </div>
                <div class="col-sm-3">
                    <?php echo  $form->radioButton($model, 'torniket', array('value' => 'tungkai kiri', 'disabled' => $jenis == 'lihat', 'id' => 'tungkaikiri', 'class' => 'radioToniket', 'uncheckValue' => null)); ?>
                    <label for="tungkaikiri">Tungkai Kiri</label>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">&nbsp;</label>
            <div class="row-fluid">
                <div class="col-sm-3">
                    Tekanan
                </div>
                <div class="col-sm-6">
                    <?php
                    echo $form->textField(
                        $model,
                        'torniket_tekanan',
                        array('class' => 'span3 integer2', 'rows' => 3, 'disabled' => true)
                    );
                    ?> mmHg
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">&nbsp;</label>
            <div class="row-fluid">
                <div class="col-sm-3">
                    Jam Pasang
                </div>
                <div class="col-sm-6">
                    <div class="jam_pasang_hide">
                        <div class="input-append">
                            <input readonly="readonly" class="span3" type="text">
                            <span class="add-on">
                                <i class="icon-time"></i>
                            </span>
                        </div>
                    </div>
                    <div class="jam_pasang_show" style="display: none;">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'jam_pasang',
                            'mode' => 'time',
                            'options' => array(
                                'dateFormat' => Params::TIME_FORMAT,
                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 'class' => 'span3',
                            ),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">&nbsp;</label>
            <div class="row-fluid">
                <div class="col-sm-3">
                    Jam Lepas
                </div>
                <div class="col-sm-6">
                    <div class="jam_pasang_hide">
                        <div class="input-append">
                            <input readonly="readonly" class="span3" type="text">
                            <span class="add-on">
                                <i class="icon-time"></i>
                            </span>
                        </div>
                    </div>
                    <div class="jam_pasang_show" style="display: none;">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'jam_lepas',
                            'mode' => 'time',
                            'options' => array(
                                'dateFormat' => Params::TIME_FORMAT,
                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 'class' => 'span3',
                            ),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label">Diartemi</label>
            <div class="row-fluid">
                <div class="col-sm-3">
                    <?php echo $form->checkBox($model, 'is_diatermi_monopolar', array('disabled' => $jenis == 'lihat')); ?>
                    Monopolar
                </div>
                <div class="col-sm-3">
                    <?php echo $form->checkBox($model, 'is_diatermi_bipolar', array('disabled' => $jenis == 'lihat')); ?>
                    Bipolar
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">&nbsp;</label>
                <div class="row-fluid">
                    <div class="col-sm-3">
                        <?php echo $form->checkBox($model, 'is_diatermi_tangankanan', array('disabled' => $jenis == 'lihat')); ?>
                        Tangan Kanan
                    </div>
                    <div class="col-sm-3">
                        <?php echo $form->checkBox($model, 'is_diatermi_tangankiri', array('disabled' => $jenis == 'lihat')); ?>
                        Tangan Kiri
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">&nbsp;</label>
                <div class="row-fluid">
                    <div class="col-sm-3">
                        <?php echo $form->checkBox($model, 'is_diatermi_tangankanan', array('disabled' => $jenis == 'lihat')); ?>
                        Kaki Kanan
                    </div>
                    <div class="col-sm-3">
                        <?php echo $form->checkBox($model, 'is_diatermi_tangankiri', array('disabled' => $jenis == 'lihat')); ?>
                        Kaki Kiri
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label">Sinar X selama operasi</label>
            <div class="row-fluid">
                <div class="col-sm-3">
                    <?php echo $form->checkBox($model, 'image_intensifier', array('class' => 'autoEnable', 'disabled' => $jenis == 'lihat')); ?>
                    Image Intensifier
                </div>
                <div class="col-sm-3">
                    <div class="col-sm-6">
                        Lamanya
                    </div>
                    <div class="col-sm-6">
                        <?php
                        echo $form->textField(
                            $model,
                            'lamanya',
                            array('class' => 'span3 PelayananpembedahanT_image_intensifier', 'rows' => 3, 'disabled' => true)
                        );
                        ?>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">&nbsp;</label>
                <div class="row-fluid">
                    <div class="col-sm-3">
                        <?php echo $form->checkBox($model, 'foto', array('class' => 'autoEnable', 'disabled' => $jenis == 'lihat')); ?>
                        Foto
                    </div>
                    <div class="col-sm-3">
                        <div class="col-sm-6">
                            Kontras
                        </div>
                        <div class="col-sm-6">
                            <?php
                            echo $form->textField(
                                $model,
                                'kontras',
                                array('class' => 'span1 PelayananpembedahanT_foto', 'rows' => 3, 'disabled' => true)
                            );
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="col-sm-6">
                            KV
                        </div>
                        <div class="col-sm-6">
                            <?php
                            echo $form->textField(
                                $model,
                                'kontras',
                                array('class' => 'span1 PelayananpembedahanT_foto', 'rows' => 3, 'disabled' => true)
                            );
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPemakaianBahan',
    'options' => array(
        'title' => 'Daftar Bahan Medis ' . Yii::app()->user->getState('ruangan_nama'),
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 600,
        'resizable' => false,
    ),
));
$modBhp = new BSObatalkesM('searchDialogBHP');
$modBhp->unsetAttributes();
if (isset($_GET['BSObatalkesM'])) {
    $modBhp->attributes = $_GET['BSObatalkesM'];
}
$modBhp->jenisobatalkes_id = Params::JENISOBATALKES_ID_BHP;

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatalkes-m-grid',
    'dataProvider' => $modBhp->searchDialogBHP(),
    'filter' => $modBhp,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0)",array("class"=>"btn-small", 
            "id" => "selectObat",
            "onClick" => "
                $(\'#obatalkes_id\').val($data->obatalkes_id);
                $(\'#obatalkes_nama\').val(\'$data->obatalkes_nama\');
                tambahPemakaianBahan(true);
                
                return false;"
                ))',
        ),
        array(
            'name' => 'jenisobatalkes_id',
            'type' => 'raw',
            'value' => '(!empty($data->jenisobatalkes_id) ? $data->jenisobatalkes->jenisobatalkes_nama : "")',
            'filter' => false,
        ),
        'obatalkes_nama',
        array(
            'header' => 'Jumlah Stok',
            'type' => 'raw',
            'value' => 'StokobatalkesT::getJumlahStok($data->obatalkes_id, Yii::app()->user->getState("ruangan_id"))',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>