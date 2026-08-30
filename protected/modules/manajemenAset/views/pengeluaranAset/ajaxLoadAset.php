<?php
    $modDetail = new MAPengeluaranasetdetT;
    
?>

<tr data-row="0">
    <td>
        <?php 
        echo CHtml::activeHiddenField($modDetail, '[0]invperalatan_id', array(
            'class'=>'invperalatan_id',
        ));
        
        $this->widget('MyJuiAutoComplete',array(
                    'model'=>$modDetail,
                    'name'=>'invperalatan_nama',
                    'source'=>'js: function(request, response) {
                        $.ajax({
                            url: "'.$this->createUrl('ajaxGetPeralatan').'",
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
                        'minLength' => 3,
                        'focus'=> 'js:function( event, ui ) {
                            $(this).val(ui.item.label);
                        }',
                        'select'=>'js:function( event, ui ) {
                            $(this).parents("tr").find(".invperalatan_id").val(ui.item.invbarang_id);
                            $(this).val(ui.item.invperalatan_namabrg);
                            setBarang($(this), ui.item);
                            return false;
                        }',

                    ),
                    'tombolDialog'=>array("idDialog"=>'dialogDaftarTindakanPaket','jsFunction'=>"setDialog(this);"),
                    'htmlOptions'=>array('class'=>'invperalatan_nama', 'onkeypress'=>"return $(this).focusNextInputField(event)", ),
        )); ?>
    </td>
    <td class="no_aset">
        
    </td>
    <td class="merk">
        
    </td>
    <td class="thn_beli">
        
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modDetail, '[0]pengeluaranaset_keadaan', 
            LookupM::getItems('inventariskeadaan'),
            array(
                'class'=>'pengeluaranaset_keadaan span2'
            )); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextArea($modDetail, '[0]ket_pengeluaranaset', array(
            'class'=>'ket_pengeluaranaset'
        )); ?>
    </td>
    <td width="100" style="width: 100px; text-align: center !important;">
        <?php echo CHtml::link('<i class="icon-plus"></i>', '#', array(
            'onclick'=>'tambahRowBarang(this); return false;',
            'title'=>'Klik untuk menambahkan Barang',
        )); ?>
        <?php echo CHtml::link('<i class="icon-minus"></i>', '#', array(
            'onclick'=>'batalRowBarang(this); return false;',
            'title'=>'Klik untuk membatalkan Barang',
        )); ?>
    </td>
  
</tr>