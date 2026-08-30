<?php
/**
 * Row untuk ditampilkan ketika dalam transaksi
 * 
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 */


    $detail = new MutasiasetperalatanT;
    
?>

<tr data-row="0">
    <td>
        <?php 
        echo CHtml::activeHiddenField($detail, '[0]invperalatan_id', array(
            'class'=>'invperalatan_id',
        ));
        
        $this->widget('MyJuiAutoComplete',array(
                    'model'=>$detail,
                    'name'=>'invperalatan_nama',
                    'source'=>'js: function(request, response) {
                        $.ajax({
                            url: "'.$this->createUrl('ajaxGetPeralatan').'",
                            dataType: "json",
                            data: {
                                term: request.term,
                                ruangan_id: $("#MutasiasetT_ruanganasal_id").val(),
                                peralatankecuali_id: $("#peralatankecuali_id").val()
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
                    'tombolDialog'=>array("idDialog"=>'dialogDaftarTindakanPaket','jsFunction'=>"setDialog(this);refreshAset();"),
                    'htmlOptions'=>array('class'=>'invperalatan_nama', 'onkeypress'=>"return $(this).focusNextInputField(event)", ),
        )); ?>
    </td>
    <td class="no_aset lbl">
        
    </td>
    <td class="merk lbl">
        
    </td>
    <td class="thn_beli lbl">
        
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($detail, '[0]mutasi_keadaan', 
            LookupM::getItems('inventariskeadaan'),
            array(
                'class'=>'mutasi_keadaan span2'
            )); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextArea($detail, '[0]ket_mutasi', array(
            'class'=>'ket_mutasi'
        )); ?>
    </td>
    <td width="100" style="width: 100px; text-align: center !important;">
        <?php echo CHtml::link('<i class="icon-plus"></i>', 'javascript:;', array(
            'class'=>'btn-tambah',
            'onclick'=>'tambahRowBarang(this); return false;',
            'title'=>'Klik untuk menambahkan Barang',
            //'rel'=>'tooltip',
        )); ?>
        <?php echo CHtml::link('<i class="icon-minus"></i>', 'javascript:;', array(
            'onclick'=>'batalRowBarang(this); return false;',
            'title'=>'Klik untuk membatalkan Barang',
            'class'=>'btn-hapus',
        )); ?>
    </td>
</tr>