<?php echo CHtml::css('#tableDetailBarang thead tr th{vertical-align:middle;}'); ?>
<div class="block-tabel">
    <div style="overflow: auto">
        <table class="table table-bordered table-striped table-condensed" id="tableDetailBarang">
            <thead>
                <tr>
                    <th>Tipe Barang</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Isi Kemasan</th>
                    <?php if (!empty($modBeli->pembelianbarang_id)) { ?>
                    <th>Jumlah Beli</th>
                    <?php } ?>
                    <th>Jumlah Terima</th>
                    <th>Harga Satuan (Rp)</th>
                    <th>Keringanan (%)</th>
                    <th>Keringanan (Rp)</th>
                    <th>PPN (%)</th>
                    <th>PPN (Rp)</th>
                    <th>PPh (%)</th>
                    <th>PPh (Rp)</th>
                    <th>Subtotal (Rp)</th>
                    <th>Kondisi Barang</th>
                    <th>Batal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($modDetails)){

                foreach ($modDetails as $i=>$detail){?>
                <?php $modBarang = BarangM::model()->findByPk($detail->barang_id);
                $detail->jmlbeli = number_format($detail->jmlbeli,2,",",".");
                $detail->jmlterima = number_format($detail->jmlterima,2,",",".");
                $detail->persendiscount = number_format($detail->persendiscount,2,",",".");
                $detail->persenpph = number_format($detail->persenpph,2,",",".");
                $detail->namabarangmaster = $modBarang->barang_nama;
                $detail->hargasatuanmaster = MyFormatter::formatNumberForPrint($modBarang->barang_harganetto,2);

                ?>
                    <tr>
                        <td><?php
                            echo CHtml::activeHiddenField($detail, '['.$i.']barang_id',array('class'=>'barang'));
                            echo CHtml::activeHiddenField($detail, '['.$i.']satuanbeli',array());
                            echo CHtml::activeHiddenField($detail, '['.$i.']hargasatuanmaster',array('class'=>'integer-decimal')); 
                            echo CHtml::activeHiddenField($detail, '['.$i.']namabarangmaster');
                            echo CHtml::activeHiddenField($detail, '['.$i.']hppcheck');
                           // echo !empty($modBarang->subsubkelompok)?$modBarang->subsubkelompok->subkelompok->kelompok->bidang->golongan->golongan_nama:null;
                            echo $modBarang->barang_type;
                            ?>
                        </td>
                      <!--  <td><?php //echo !empty($modBarang->subsubkelompok)? $modBarang->subsubkelompok->subkelompok->kelompok->bidang->bidang_nama:null; ?></td>
                        <td><?php //echo !empty($modBarang->subsubkelompok)? $modBarang->subsubkelompok->subkelompok->kelompok->kelompok_nama:null; ?></td>
                        <td><?php //echo !empty($modBarang->subsubkelompok)?$modBarang->subsubkelompok->subkelompok->subkelompok_nama:null; ?></td>
                        <td><?php //echo !empty($modBarang->subsubkelompok)?$modBarang->subsubkelompok->subsubkelompok_nama:null; ?></td>-->
                        <td><?php echo $modBarang->barang_kode; ?></td>
                        <td><?php echo $modBarang->barang_nama; ?></td>
                        <td><?php echo CHtml::activeTextField($detail, '['.$i.']jmldalamkemasan', array( 'class'=>'span1','readonly'=>true)); ?></td>
                        <?php if (!empty($modBeli->pembelianbarang_id)) { ?>
                        <td>
                        <?php
                            echo CHtml::activeTextField($detail, '['.$i.']jmlbeli', array('class'=>'span1 integer-decimal jmlbeli', 'readonly'=>true, 'style'=>'text-align: right;'));
                            echo '<br/>';
                            echo $form->error($detail, '['.$i.']jmlbeli');
                        ?>
                        </td>
                        <?php } ?>
                        <td>
                        <?php
                            echo CHtml::activeTextField($detail, '['.$i.']jmlterima', array('class'=>'span1 integer-decimal qty', 'onblur'=>'setTotalHarga(); '.((isset($modBeli)) ?'cekTerima(this)':''), 'style'=>'text-align: right;','readonly'=>true)).' '.$modBarang->barang_satuan;
                            echo '<br/>';
                            echo $form->error($detail, '['.$i.']jmlterima');
                        ?>
                        </td>
                        <td>
                        <?php
                            echo (Params::cekHiddenHargaGudangUmum()==true)?CHtml::activeTextField($detail, '['.$i.']hargasatuan', array('class'=>'span2 integer-decimal satuan', 'onblur'=>'setTotalHarga();', 'readonly'=>true, 'style'=>'text-align: right;')):CHtml::activePasswordField($detail, '['.$i.']hargasatuan', array('class'=>'span2 integer-decimal satuan', 'onblur'=>'setTotalHarga();', 'readonly'=>true, 'style'=>'text-align: right;'));
                            echo '<br/>';
                            echo $form->error($detail, '['.$i.']hargasatuan');
                        ?>
                        </td>
                         <td>
                        <?php
                            echo CHtml::activeTextField($detail, '['.$i.']persendiscount', array('class'=>'span1 integer-decimal persendiscount', 'onblur'=>'setTotalHarga();', 'readonly'=>true, 'style'=>'text-align: right;'));
                            echo '<br/>';
                            echo $form->error($detail, '['.$i.']persendiscount');
                        ?>
                        </td>
                         <td>
                        <?php
                            echo (Params::cekHiddenHargaGudangUmum()==true)?CHtml::activeTextField($detail, '['.$i.']jmldiscount', array('class'=>'span2 integer-decimal jmldiscount', 'onblur'=>'setTotalHarga();', 'readonly'=>true, 'style'=>'text-align: right;')):CHtml::activePasswordField($detail, '['.$i.']jmldiscount', array('class'=>'span2 integer-decimal jmldiscount', 'onblur'=>'setTotalHarga();', 'readonly'=>true, 'style'=>'text-align: right;'));
                            echo '<br/>';
                            echo $form->error($detail, '['.$i.']jmldiscount');
                        ?>
                        </td>
                         <td>
                        <?php
                            echo CHtml::activeTextField($detail, '['.$i.']persenppn', array('class'=>'span1 numbersOnly persenppn', 'onblur'=>'setTotalHarga();', 'readonly'=>true, 'style'=>'text-align: right;'));
                            echo '<br/>';
                            echo $form->error($detail, '['.$i.']persenppn');
                        ?>
                        </td>
                         <td>
                        <?php
                            echo (Params::cekHiddenHargaGudangUmum()==true)?CHtml::activeTextField($detail, '['.$i.']jmlppn', array('class'=>'span2 integer-decimal jmlppn', 'readonly'=>true, 'style'=>'text-align: right;')):CHtml::activePasswordField($detail, '['.$i.']jmlppn', array('class'=>'span2 integer-decimal jmlppn', 'readonly'=>true, 'style'=>'text-align: right;'));
                            echo '<br/>';
                            echo $form->error($detail, '['.$i.']jmlppn');
                        ?>
                        </td>
                         <td>
                        <?php
                            echo CHtml::activeTextField($detail, '['.$i.']persenpph', array('class'=>'span1 integer-decimal persenpph', 'onblur'=>'setTotalHarga();', 'readonly'=>true, 'style'=>'text-align: right;'));
                            echo '<br/>';
                            echo $form->error($detail, '['.$i.']persenpph');
                        ?>
                        </td>
                         <td>
                        <?php
                            echo (Params::cekHiddenHargaGudangUmum()==true)?CHtml::activeTextField($detail, '['.$i.']jmlpph', array('class'=>'span2 integer-decimal jmlpph', 'readonly'=>true, 'style'=>'text-align: right;')):CHtml::activePasswordField($detail, '['.$i.']jmlpph', array('class'=>'span2 integer-decimal jmlpph', 'readonly'=>true, 'style'=>'text-align: right;'));
                            echo '<br/>';
                            echo $form->error($detail, '['.$i.']jmlpph');
                        ?>
                        </td>
                        <td>
                        <?php
                            echo (Params::cekHiddenHargaGudangUmum()==true)?CHtml::activeTextField($detail, '['.$i.']hargabeli', array('class'=>'span2 integer-decimal hargabeli', 'onblur'=>'setTotalHarga();',  'readonly'=>true, 'style'=>'text-align: right;')):CHtml::activePasswordField($detail, '['.$i.']hargabeli', array('class'=>'span2 hargabeli integer-decimal', 'onblur'=>'setTotalHarga();',  'readonly'=>true, 'style'=>'text-align: right;'));
                            echo '<br/>';
                            echo $form->error($detail, '['.$i.']hargabeli');
                        ?>
                        </td>
                        <!--<td><?php //echo CHtml::activeDropDownList($detail, '['.$i.']satuanbeli', LookupM::getItems('satuanbarang'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?></td>                -->
                        <td>
                            <?php echo CHtml::activeTextField($detail, '['.$i.']kondisibarang',array('class'=>'span2','readonly'=>true));  ?>
                        <td><?php echo Chtml::link('<icon class="icon-remove"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
                    </tr>
                <?php }
                }
                ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="13" style="text-align: right;"><b>Total</b></td>
                <td>
                  <?php echo (Params::cekHiddenHargaGudangUmum()==true)?CHtml::textField('totalAll',0,array('class'=>'span2 integer-decimal','readonly'=>true, 'style'=>'text-align: right')):CHtml::passwordField('totalAll',0,array('class'=>'span2 integer-decimal','readonly'=>true, 'style'=>'text-align: right')); ?>
                </td>
                <td></td>
                <td></td>
              </tr>
            </tfoot>
        </table>
    </div>
</div>

<?php if (isset($modBeli)){
$js2 =<<< JS
    function cekTerima(obj){
        beli = $(obj).parents('tr').find('.beli').val();
        terima = $(obj).val();
        if (terima > beli){
            myAlert('Jumlah Terima tidak boleh lebih dari yang di Beli');
            $(obj).val(beli);
            return false;
        }
    }
JS;

Yii::app()->clientScript->registerScript('tes', $js2, CClientScript::POS_HEAD);
}
?>
