<?php echo CHtml::css('#tableDetailBarang thead tr th{vertical-align:middle;}'); ?>
<div style="overflow: auto">
    <div class="block-tabel">
        <table class="table table-striped table-condensed" id="tableDetailBarang">
            <thead>
                <tr>
                    <th>Tipe Barang</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Isi Dalam Kemasan</th>
                    <th>Jumlah Permintaan</th>    
                    <th>Harga Satuan (Rp)</th>
                    <th>Keringanan (%)</th>    
                    <th>Keringanan (Rp)</th>
                    <th>PPN (%)</th>    
                    <th>PPN (Rp)</th>
                    <th>PPh (%)</th>    
                    <th>PPh (Rp)</th>    
                    <th>Subtotal (Rp)</th>

                    <?php //if ($model->isNewRecord) { ?>
                    <th>Batal</th>
                    <?php //} ?>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (isset($modDetails)){
                    foreach ($modDetails as $i=>$detail){
                        
                        //var_dump($detail->attributes); die;
                        
                        //$detail->jmlbeli = number_format($detail->jmlbeli,2,",",".");
                        // $detail->jmlbeli = MyFormatter::formatNumberForPrint($detail->jmlbeli,2);
                        // $detail->hargasatuan = MyFormatter::formatNumberForPrint($detail->hargasatuan,2);
                ?>
                <?php 
                    $modBarang = BarangM::model()->findByPk($detail->barang_id); ?>
                    <tr data-id="<?php echo $detail->belibrgdetail_id; ?>">   
                        <td>
                            <?php 
                            if (!$detail->isNewRecord) {
                                echo CHtml::activeHiddenField($detail, '['.$i.']belibrgdetail_id',array('class'=>'barang')); 
                            }
                            ?>
                            <?php echo CHtml::activeHiddenField($detail, '['.$i.']barang_id',array('class'=>'barang')); ?>
                            <?php echo CHtml::activeHiddenField($detail, '['.$i.']hpp',array('class'=>'span2 integer-decimal hpp')); ?>
                            <?php echo CHtml::activeHiddenField($detail, '['.$i.']satuanbeli');  ?>
                            <?php echo $modBarang->barang_type; ?></td>
                        <td><?php echo $modBarang->barang_kode; ?></td>
                        <td><?php echo $modBarang->barang_nama; ?></td>
                        <td><?php echo CHtml::activeTextField($detail, '['.$i.']jmldlmkemasan', array('class'=>'span1 numbers-only', 'onchange'=>'hitungAllTotal();', 'style'=>'text-align: right;', 'readonly'=>true));
                            echo '<br/>';
                            echo $form->error($detail, '['.$i.']jmlbeli'); ?></td>                
                        <td>
                        <?php 
                            echo CHtml::activeTextField($detail, '['.$i.']jmlbeli', array('class'=>'span1 integer-decimal qty', 'onblur'=>'hitungAllTotal();', 'style'=>'text-align: right;')).' '.$modBarang->barang_satuan;
                            echo '<br/>';
                            echo $form->error($detail, '['.$i.']jmlbeli');
                        ?>
                        </td>
                        <td>
                        <?php 
                            echo (Params::cekHiddenHargaGudangUmum()==true)?CHtml::activeTextField($detail, '['.$i.']hargasatuan', array('class'=>'span2 integer-decimal satuan', 'onblur'=>'hitungAllTotal()', 'style'=>'text-align: right;')):CHtml::activePasswordField($detail, '['.$i.']hargasatuan', array('class'=>'span2 integer-decimal satuan', 'onblur'=>'hitungAllTotal()', 'style'=>'text-align: right;'));
                            echo '<br/>';
                            echo $form->error($detail, '['.$i.']hargasatuan');
                        ?>
                        </td>
                        <td>
                        <?php 
                            echo CHtml::activeTextField($detail, '['.$i.']persendiscount', array('class'=>'span1 integer-decimal persendiscount', 'onblur'=>'hitungAllTotal()', 'style'=>'text-align: right;'));
                            echo '<br/>';
                            echo $form->error($detail, '['.$i.']persendiscount');
                        ?>
                        </td>
                        <td>
                        <?php 
                            echo (Params::cekHiddenHargaGudangUmum()==true)?CHtml::activeTextField($detail, '['.$i.']jmldiscount', array('class'=>'span2 integer-decimal jmldiscount', 'style'=>'text-align: right;', 'readonly'=>true)):CHtml::activePasswordField($detail, '['.$i.']jmldiscount', array('class'=>'span2 integer-decimal jmldiscount', 'style'=>'text-align: right;', 'readonly'=>true));
                            echo '<br/>';
                            echo $form->error($detail, '['.$i.']jmldiscount');
                        ?>
                        </td>
                        <td>
                        <?php 
                            echo CHtml::activeTextField($detail, '['.$i.']persen_ppn', array('class'=>'span1 integer2 ppn', 'onblur'=>'hitungAllTotal()', 'style'=>'text-align: right;'));
                            echo '<br/>';
                            echo $form->error($detail, '['.$i.']persen_ppn');
                        ?>
                        </td>
                        <td>
                        <?php 
                            echo (Params::cekHiddenHargaGudangUmum()==true)?CHtml::activeTextField($detail, '['.$i.']ppn', array('class'=>'span2 integer-decimal ppn_nilai', 'style'=>'text-align: right;', 'readonly'=>true)):CHtml::activePasswordField($detail, '['.$i.']ppn', array('class'=>'span2 integer-decimal ppn_nilai', 'style'=>'text-align: right;', 'readonly'=>true));
                            echo '<br/>';
                            echo $form->error($detail, '['.$i.']ppn');
                        ?>
                        </td>
                        <td>
                        <?php 
                            echo CHtml::activeTextField($detail, '['.$i.']persenpph', array('class'=>'span1 integer-decimal persenpph', 'onblur'=>'hitungAllTotal()', 'style'=>'text-align: right;'));
                            echo '<br/>';
                            echo $form->error($detail, '['.$i.']persenpph');
                        ?>
                        </td>
                        <td>
                        <?php 
                            echo (Params::cekHiddenHargaGudangUmum()==true)?CHtml::activeTextField($detail, '['.$i.']jmlpph', array('class'=>'span2 integer-decimal jmlpph', 'style'=>'text-align: right;', 'readonly'=>true)):CHtml::activePasswordField($detail, '['.$i.']jmlpph', array('class'=>'span2 integer-decimal jmlpph', 'style'=>'text-align: right;', 'readonly'=>true));
                            echo '<br/>';
                            echo $form->error($detail, '['.$i.']jmlpph');
                        ?>
                        </td>
                        <td>
                        <?php 
                            echo (Params::cekHiddenHargaGudangUmum()==true)?CHtml::activeTextField($detail, '['.$i.']hargabeli', array('readonly'=>true,'class'=>'span2 integer-decimal beli', 'style'=>'text-align: right;')):CHtml::activePasswordField($detail, '['.$i.']hargabeli', array('readonly'=>true,'class'=>'span2 integer-decimal beli', 'style'=>'text-align: right;'));
                            echo '<br/>';
                            echo $form->error($detail, '['.$i.']hargabeli');
                        ?>
                        </td>
                        <td><?php echo Chtml::link('<icon class="icon-remove"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
                    </tr>   
                <?php }
                }
                ?>
            </tbody>
           <tfoot>
                <tr>
                    <td colspan="12" style = "text-align:right;">Total</td>
                    <td><?php echo (Params::cekHiddenHargaGudangUmum()==true)?CHtml::textField('total','',array('readonly'=>true,'class'=>'span2 integer-decimal', 'style'=>'text-align: right;')):CHtml::passwordField('total','',array('class'=>'span2 integer-decimal', 'style'=>'text-align: right;','readonly'=>true));?></td>					
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
