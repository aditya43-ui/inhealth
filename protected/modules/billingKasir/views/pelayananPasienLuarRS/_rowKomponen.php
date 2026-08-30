<?php if(!empty($typeinput) && $typeinput == 'namakomponen'){ ?>
<tr class='trcld'>
    <td>
        <?php echo CHtml::dropDownList('komponen_id','',CHtml::listData(KomponentarifM::model()->findAll('komponentarif_aktif = true and komponentarif_id <> 6 order by komponentarif_nama ASC'),'komponentarif_id','komponentarif_nama'),array('class'=>'komponen_id span3', 'empty'=>'Pilih')); ?>    
        <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array('onclick'=>'tambahkomp(this);', 'class' => 'btn btn-primary')); ?>
        <?php echo CHtml::htmlButton('<i class="icon-minus icon-white"></i>', array('onclick'=>'hapusTindakan(this);', 'class' => 'btn btn-danger')); ?>
    </td>
</tr>
<?php }else if(!empty($typeinput) && $typeinput == 'tarifkomponen'){ ?>
    <tr class='trcld_tarif'>
        <td>
            <?php echo CHtml::textField('tarif_kompsatuan',0,array('class'=>'tarif_kompsatuan span2 integer-decimal', 'onblur'=>'hitungTotal();')); ?>
        </td>
    </tr>
<?php }else if(!empty($typeinput) && $typeinput == 'diskonkomponen'){ ?>
    <tr class='trcld_diskon'>
        <td>
        <?php echo CHtml::textField('discountkomptindakan',0,array('class'=>'discountkomptindakan span2 integer-decimal', 'onblur'=>'hitungTotal();')); ?>
        </td>
    </tr>
<?php }else if(!empty($typeinput) && $typeinput == 'totalkomponen'){ ?>
    <tr class='trcld_total'>
        <td>
        <?php echo CHtml::textField('tarif_tindakankomp',0,array('class'=>'tarif_tindakankomp span2 integer-decimal','readonly'=>true)); ?>
        </td>
    </tr>
<?php } ?>