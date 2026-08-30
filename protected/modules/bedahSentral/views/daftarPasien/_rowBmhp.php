<?php
    $paket = isset($paket)?$paket:false;    
?>
<tr class="trparent" pemeriksaanlab_id="<?= !empty($detail['pemeriksaanlab_id'])?$detail['pemeriksaanlab_id']:'' ?>"  cukup="" ispaket="<?= ($paket)?'ya':'tidak' ?>">
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
    <!-- <td style="text-align: center; vertical-align: middle" class="hide"> -->
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
                            $mendekatiminimalstok = !empty($jnsoa['mendekatiminimalstok'])?$jnsoa['mendekatiminimalstok']:'tidak';
                            ?>
                                <tr class='trcld trcld_jnsoa <?= ($mendekatiminimalstok=='ya')?'set-stok-habis':'' ?>'>
                                    <td>
                                        <?php echo CHtml::textField('jenisobatalkes_nama',$jnsoa['jenisobatalkes_nama'],array('class'=>'jenisobatalkes_nama span2 detail-oa', 'readonly'=>true)); ?>
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
                            $mendekatiminimalstok = !empty($oa['mendekatiminimalstok'])?$oa['mendekatiminimalstok']:'tidak';
                        ?>
                            <tr class='trcld trcld_namaoa <?= ($mendekatiminimalstok=='ya')?'set-stok-habis':'' ?>' >                                
                                <td>
                                    <?php                                         
                                        echo CHtml::hiddenField('obatalkes_id',$oa['obatalkes_id'],array('class'=>'obatalkes_id detail-oa'));
                                        echo CHtml::hiddenField('isbukanbebanpasien',$oa['isbukanbebanpasien'],array('class'=>'isbukanbebanpasien'));
                                        if ($mendekatiminimalstok == 'tidak'){
                                            echo CHtml::textField('obatalkes_nama',$oa['obatalkes_nama'],array('class'=>'obatalkes_nama span3', 'readonly'=>true)); 
                                        }else{
                                            $this->widget('MyJuiAutoComplete', array(
                                                'name'=>'obatalkes_nama',
                                                'value'=>$oa['obatalkes_nama'],
                                                'source'=>'js: function(request, response) {
                                                            $.ajax({
                                                                url: "'.$this->createUrl('PemakaianBmhp/AutocompleteObatAlkes').'",
                                                                dataType: "json",
                                                                data: {
                                                                    term: request.term,
                                                                },
                                                                success: function (data) {
                                                                        response(data);
                                                                }
                                                            })
                                                            }',
                                                'options'=>array(
                                                    'showAnim'=>'fold',
                                                    'minLength' => 2,
                                                    'focus'=> 'js:function( event, ui ) {
                                                            $(this).val("");
                                                            return false;
                                                        }',
                                                    'select'=>'js:function( event, ui ) {
                                                            $(this).val(ui.item.value);                                                            
                                                            setObatAlkes(ui.item,this,"panel-paket-bmhp");
                                                            return false;
                                                        }',
                                                ),
                                                'htmlOptions'=>array(
                                                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                                                    'onblur'=>'if(this.value==""){resetObatAlkes(this);}',
                                                    'class'=>'detail-oa obatalkes_nama',
                                                    'onfocus'=>'setNo(this);setJenis("paket-bmhp");'
                                                ),
                                                'tombolDialog'=>array('idDialog'=>'dialogPemakaianBahan','jsFunction'=>'$("#dialogPemakaianBahan").dialog("open");setNo(this);setJenis("paket-bmhp");'),
                                            )); 
                                        }
                                    ?>
                                </td>
                            </tr>
                        <?php 
                        }
                    }
                ?>
            </tbody>
        </table>
    </td>
    <td style="margin: 0px !important; padding: 0px !important;" class="hide">
        <table class="items table table-bordered table-striped table-condensed noshadowtabel">
            <tbody class='tblchild_tglkadaluarsaoa'>
                <?php 
                    if(!empty($detail['detail'])){                        
                        foreach($detail['detail'] as $tglkdl){
                            $mendekatiminimalstok = !empty($tglkdl['mendekatiminimalstok'])?$tglkdl['mendekatiminimalstok']:'tidak';
                        ?>
                            <tr class='trcld trcld_tglkadaluarsaoa <?= ($mendekatiminimalstok=='ya')?'set-stok-habis':'' ?>'>
                                <td>
                                    <?php echo CHtml::textField('tglkadaluarsa',$tglkdl['tglkadaluarsa'],array('class'=>'tglkadaluarsa detail-oa', 'readonly'=>true,'style'=>'width: 120px')); ?>
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
                        $mendekatiminimalstok = !empty($hargsasatuan['mendekatiminimalstok'])?$hargsasatuan['mendekatiminimalstok']:'tidak';
                    ?>
                         <tr class='trcld trcld_hargajualoa <?= ($mendekatiminimalstok=='ya')?'set-stok-habis':'' ?>'>                            
                            <td>
                                <?php echo CHtml::textField('hargajual',MyFormatter::formatNumberForPrint($hargsasatuan['hargajual'],2),array('class'=>'detail-oa hargajual integer-decimal-global span2', 'readonly'=>true)); ?>
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
                        $mendekatiminimalstok = !empty($qtyoa['mendekatiminimalstok'])?$qtyoa['mendekatiminimalstok']:'tidak';
                    ?>
                    <tr class='trcld trcld_jmloa <?= ($mendekatiminimalstok=='ya')?'set-stok-habis':'' ?>'>                       
                        <td>
                            <?php echo CHtml::textField('qty',$qtyoa['qty'],array('class'=>'qty integer-decimal-global span1 detail-oa', 'readonly'=>true)) .' '.$qtyoa['satuankecil']; ?>
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
            <tbody class='tblchild_persenppn'>
            <?php 
                if(!empty($detail['detail'])){
                    foreach($detail['detail'] as $sub){
                        $mendekatiminimalstok = !empty($qtyoa['mendekatiminimalstok'])?$qtyoa['mendekatiminimalstok']:'tidak';
                    ?>
                    <tr class='trcld_persenppn <?= ($mendekatiminimalstok=='ya')?'set-stok-habis':'' ?>'>
                        <td>
                            <?php echo CHtml::textField('ppnpersen',$sub['ppnpersen'],array('class'=>'ppnpersen integer-decimal-global span2', 'readonly'=>true)); ?>
                            <?php echo CHtml::hiddenField('jumlahppn',0,array('class'=>'jumlahppn integer-decimal-global span2', 'readonly'=>true)); ?>
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
            <tbody class='tblchild_persen_margin'>
            <?php 
                if(!empty($detail['detail'])){
                    foreach($detail['detail'] as $sub){
                        $mendekatiminimalstok = !empty($qtyoa['mendekatiminimalstok'])?$qtyoa['mendekatiminimalstok']:'tidak';
                    ?>
                    <tr class='trcld_persen_margin <?= ($mendekatiminimalstok=='ya')?'set-stok-habis':'' ?>'>
                        <td>
                            <?php echo CHtml::textField('persen_margin',$sub['persen_margin'],array('class'=>'persen_margin integer-decimal-global span2', 'readonly'=>true)); ?>
                            <?php echo CHtml::hiddenField('harga_margin',0,array('class'=>'harga_margin integer-decimal-global span2', 'readonly'=>true)); ?>
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
                        $mendekatiminimalstok = !empty($sub['mendekatiminimalstok'])?$sub['mendekatiminimalstok']:'tidak';
                    ?>
                    <tr class='trcld trcld_subtotaloa <?= ($mendekatiminimalstok=='ya')?'set-stok-habis':'' ?>'>                       
                        <td>
                            <?php echo CHtml::textField('subtotal',0,array('class'=>'subtotal detail-oa integer-decimal-global span2', 'readonly'=>true)); ?>
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
