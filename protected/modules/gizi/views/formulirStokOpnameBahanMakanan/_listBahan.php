<?php
echo CHtml::css('#isiScroll{max-height: 500px; overflow-y: auto; margin-top: 10px;}');
?>
<!--search-form-->
<div id="form-carikata">
    <?php echo CHtml::textField('carikata', "", array('onkeyup' => 'return $(this).focusNextInputField(event);', 'onblur' => 'cariKata();', 'placeholder' => 'Ketik Kata Kunci Pencarian')) ?>
    <?php echo CHtml::htmlButton('<i class="entypo-search"></i>', array('class' => 'btn btn-primary', 'onclick' => 'cariKata();',)) ?>
    <?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default', 'onclick' => 'resetCariKata();')) ?>
</div>

<div id='isiScroll'>
    <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'makanan-m-grid',
        'dataProvider' => $modObat->searchInformasiUntukFormulirOpname(), //RND-6228
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih ' . CHtml::checkBox('is_pilihsemuaobat', true, array('onclick' => 'pilihSemua(this)', 'title' => 'Klik untuk pilih / tidak <br>semua obat', 'rel' => 'tooltip')),
                'type' => 'raw',
                'value' => '
                    CHtml::hiddenField(\'FormuliropnamegizidetR[\'.$data->bahanmakanan_id.\'][bahanmakanan_id]\',$data->bahanmakanan_id).
                    CHtml::checkBox(\'FormuliropnamegizidetR[\'.$data->bahanmakanan_id.\'][cekList]\', true, array(\'class\'=>\'cekList\', \'onclick\'=>\'getTotal();setNol(this);\'));
                    ',
            ),
            array(
                'header' => 'Jenis Bahan Makanan',
                'name' => 'jenisbahanmakanan',
            ),
            array(
                'header' => 'Nama Bahan Makanan',
                'type' => 'raw',
                'value' => '$data->namabahanmakanan',
            ),
            array(
                'header' => 'Golongan',
                'name' => 'golbahanmakanan_nama',
            ),
            array(
                'header' => 'Satuan',
                'type' => 'raw',
                'value' => '$data->satuanbahan',
            ),
            /*
            array(
                'header'=>'HPP',
                'type'=>'raw',
                'value'=>(Params::cekHiddenHargaGudangFarmasi()==true)?'CHtml::textField(\'harga\', number_format($data->harganetto,0,"","."), array(\'class\'=>\'span2 integer2\', \'readonly\'=>true))':'CHtml::passwordField(\'harga\', number_format($data->harganetto,0,"","."), array(\'class\'=>\'span2 integer2\', \'readonly\'=>true))'
            ),
                         * 
                         */
            array(
                'header' => 'Stok Sistem',
                'type' => 'raw',
                'value' => 'CHtml::textField(\'FormuliropnamegizidetR[\'.$data->bahanmakanan_id.\'][volume_stok]\', number_format($data->jumlah,0,"","."),array(\'class\'=>\'stok span1 integer2\', \'readonly\'=>true))',
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                    getTotal();
					setTanggalSistem();
                }',
    )); ?>
</div>