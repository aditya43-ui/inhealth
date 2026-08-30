<tr class="trparent">
    <td style="text-align: center; vertical-align: middle">
        <?php echo CHtml::textField('nourut',0, array('class'=>'span1 nourut','readonly'=>true)) ?>
    </td>
    <td style="text-align: center; vertical-align: middle" class="td_date">
        <?php $this->widget('MyDateTimePicker',array(
                'id'=>'tgl_pelayanan',
                'name'=>'tgl_pelayanan',
                'value'=>MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s')),
                'mode'=>'datetime',
                'options'=> array(
                    'showOn' => false,
                    'yearRange'=> "-150:+0",
                ),
                'htmlOptions'=>array(
					'placeholder'=>'00/00/0000 00:00:00',
					'class'=>'tgl_pelayanan',
					'onkeyup'=>"return $(this).focusNextInputField(event)",
					'style' => 'width:150px;'
                ),
        )); ?>
    </td>
    <td style="text-align: center; vertical-align: middle">
        <?php echo CHtml::hiddenField('tipepaket_id',$detail['tipepaket_id'],array('class'=>'tipepaket_id')); ?>
        <?php echo CHtml::textArea('tipepaket_nama',$detail['tipepaket_nama'],array('class'=>'tipepaket_nama span3','readonly'=>true)); ?>
    </td>
    <td style="margin: 0px !important; padding: 0px !important;">
        <table class="items table table-bordered table-striped table-condensed noshadowtabel">
            <tbody class='tblchild_jnsoa'>
                <?php 
                    if(!empty($detail['detail'])){
                        foreach($detail['detail'] as $jnsoa){
                            ?>
                                <tr class='trcld_jnsoa'>
                                    <td>
                                        <?php echo CHtml::textField('jenisobatalkes_nama',$jnsoa['jenisobatalkes_nama'],array('class'=>'jenisobatalkes_nama span2', 'readonly'=>true)); ?>
                                    </td>
                                </tr>
                            <?php 
                        }
                    }
                ?>
            </tbody>
        </table>
    </td>
    <td style="margin: 0px !important; padding: 0px !important;">
        <table class="items table table-bordered table-striped table-condensed noshadowtabel">
            <tbody class='tblchild_namaoa'>
                <?php 
                    if(!empty($detail['detail'])){
                        foreach($detail['detail'] as $oa){
                        ?>
                            <tr class='trcld_namaoa'>
                                <td>
                                    <?php echo CHtml::hiddenField('obatalkes_id',$oa['obatalkes_id'],array('class'=>'obatalkes_id')) ?>
                                    <?php echo CHtml::textField('obatalkes_nama',$oa['obatalkes_nama'],array('class'=>'obatalkes_nama span3', 'readonly'=>true)); ?>
                                </td>
                            </tr>
                        <?php 
                        }
                    }
                ?>
            </tbody>
        </table>
    </td>
    <td style="margin: 0px !important; padding: 0px !important;">
        <table class="items table table-bordered table-striped table-condensed noshadowtabel">
            <tbody class='tblchild_tglkadaluarsaoa'>
                <?php 
                    if(!empty($detail['detail'])){
                        foreach($detail['detail'] as $tglkdl){
                        ?>
                            <tr class='trcld_tglkadaluarsaoa'>
                                <td>
                                    <?php echo CHtml::textField('tglkadaluarsa',$tglkdl['tglkadaluarsa'],array('class'=>'tglkadaluarsa', 'readonly'=>true,'style'=>'width: 120px')); ?>
                                </td>
                            </tr>
                        <?php 
                        }
                    }
                ?>
            </tbody>
        </table>
    </td>
    <td style="margin: 0px !important; padding: 0px !important;">
        <table class="items table table-bordered table-striped table-condensed noshadowtabel">
            <tbody class='tblchild_hargajualoa'>
            <?php 
                if(!empty($detail['detail'])){
                    foreach($detail['detail'] as $hargsasatuan){
                    ?>
                         <tr class='trcld_hargajualoa'>
                            <td>
                                <?php echo CHtml::textField('hargajual',MyFormatter::formatNumberForPrint($hargsasatuan['hargajual'],2),array('class'=>'hargajual integer-decimal span2', 'readonly'=>true)); ?>
                            </td>
                        </tr>
                    <?php 
                    }
                }
            ?>
            </tbody>
        </table>
    </td>
    <td style="margin: 0px !important; padding: 0px !important;">
        <table class="items table table-bordered table-striped table-condensed noshadowtabel">
            <tbody class='tblchild_jmloa'>
            <?php 
                if(!empty($detail['detail'])){
                    foreach($detail['detail'] as $qtyoa){
                    ?>
                    <tr class='trcld_jmloa'>
                        <td>
                            <?php echo CHtml::textField('qty',MyFormatter::formatNumberForPrint($qtyoa['qty'],2),array('class'=>'qty integer-decimal span1', 'readonly'=>true)); ?>
                        </td>
                    </tr>
                    <?php 
                    }
                }
            ?>
            </tbody>
        </table>
    </td>
    <td style="margin: 0px !important; padding: 0px !important;">
        <table class="items table table-bordered table-striped table-condensed noshadowtabel">
            <tbody class='tblchild_satuankecil'>
            <?php 
                if(!empty($detail['detail'])){
                    foreach($detail['detail'] as $satuankeciloa){
                    ?>
                    <tr class='trcld_satuankecil'>
                        <td>
                            <?php echo CHtml::textField('satuankecil',$satuankeciloa['satuankecil'],array('class'=>'satuankecil span2', 'readonly'=>true,'style'=>'width: 60px')); ?>
                        </td>
                    </tr>
                    <?php 
                    }
                }
            ?>
            </tbody>
        </table>
    </td>
    <td style="margin: 0px !important; padding: 0px !important;">
        <table class="items table table-bordered table-striped table-condensed noshadowtabel">
            <tbody class='tblchild_subtotaloa'>
            <?php 
                if(!empty($detail['detail'])){
                    foreach($detail['detail'] as $sub){
                    ?>
                    <tr class='trcld_subtotaloa'>
                        <td>
                            <?php echo CHtml::textField('subtotal',0,array('class'=>'subtotal integer-decimal span2', 'readonly'=>true)); ?>
                        </td>
                    </tr>
                    <?php 
                    }
                }
            ?>
            </tbody>
            
        </table>
    </td>
    <td style="text-align: center; vertical-align: middle">
        <?php echo CHtml::htmlButton('<i class="icon-minus icon-white"></i>', array('onclick'=>'hapusBmhp(this);', 'class' => 'btn btn-danger')); ?>
    </td>
</tr>
