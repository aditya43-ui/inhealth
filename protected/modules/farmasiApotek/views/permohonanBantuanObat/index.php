<div class="white-container">
    <legend class="rim2">Permohonan <b>Bantuan Obat</b></legend>
    <?php
    if (isset($_GET['sukses'])) {
        Yii::app()->user->setFlash('success', "Data Permohonan Bantuan Obat berhasil disimpan!");
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'permohonanoa-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
        'focus' => '#' . CHtml::activeId($modPermohonanOa, 'permohonanoa_alasan'),
    ));

    ?>

    <fieldset class="box" id="form-permintaanpembelian">
        <legend class="rim">Data Permohonan Bantuan Obat</legend>
        <div>
            <?php $this->renderPartial($this->path_view . '_formPermohonanBantuan', array('form' => $form, 'format' => $format, 'modPermohonanOa' => $modPermohonanOa, 'modPermohonanOaDetail' => $modPermohonanOa)); ?>
        </div>
    </fieldset>

    <?php if (!isset($_GET['sukses'])) { ?>
        <fieldset class="box" id="form-tambahobatalkes">
            <legend class='rim'>Obat dan Alat Kesehatan</legend>
            <div class="row">
                <?php $this->renderPartial($this->path_view . '_formObatPermohonanBantuan', array('modPermohonanOa' => $modPermohonanOa)); ?>
            </div>
        </fieldset>
    <?php } ?>

    <div class="block-tabel">
        <h6>Tabel Permohonan <b>Bantuan Obat Alkes</b></h6>
        <table class="items table table-striped table-condensed" id="table-obatalkespasien">
            <thead>
                <th>No.Urut</th>
                <th>Kategori/<br>Nama Obat</th>
                <th>Asal Barang</th>
                <th>Stok Akhir</th>
                <th>Satuan Kecil/Besar</th>
                <th>Jumlah Permohonan<br>(Satuan Kecil)</th>
                <th>Minimal Stok</th>
                <th>Harga Satuan</th>
                <th>Sub Total</th>
                <th>Batal</th>
            </thead>
            <tbody>
                <?php
                if (count((array)$modDetails) > 0) {
                    foreach ($modDetails as $i => $modPermohonanOaDetail) {
                        echo $this->renderPartial($this->path_view . '_rowObatPermohonanBantuan', array('modPermohonanOaDetail' => $modPermohonanOaDetail, 'modPermohonanOa' => $modPermohonanOa));
                    }
                }
                ?>
            <tfoot>
                <tr>
                    <td colspan="8">Total</td>
                    <td><?php echo CHtml::textField('total', '', array('class' => 'span2 integer', 'style' => 'width:90px;')) ?></td>
                    <td></td>
                </tr>
            </tfoot>
            </tbody>
        </table>
    </div>

    <div class="form-actions">
        <?php
        if ($modPermohonanOa->isNewRecord) {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'cekObat();', 'onkeypress' => 'cekObat();')); //formSubmit(this,event)
            //              Jika tanpa CekObat();
            //                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);')); 
        } else {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
        }

        if (!isset($_GET['frame'])) {
            echo CHtml::link(
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index'),
                array(
                    'class' => 'btn btn-default',
                    'onclick' => 'return refreshForm(this);'
                )
            );
        }
        if ($modPermohonanOa->isNewRecord) {
            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => 'true'));
            //                echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),'javascript:void(0);',array('class'=>'btn btn-info', 'disabled'=>'true'));  /**RND-4045*
        } else {
            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')"));
            //                echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); /**RND-4045*
        }

        $content = $this->renderPartial($this->path_view . 'tips/tipsPermohonanBantuanObat', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>

    <?php $this->endWidget(); ?>
    <?php $this->renderPartial($this->path_view . '_jsFunctions', array('modPermohonanOa' => $modPermohonanOa, 'modPermohonanOaDetail' => $modPermohonanOaDetail)); ?>
</div>