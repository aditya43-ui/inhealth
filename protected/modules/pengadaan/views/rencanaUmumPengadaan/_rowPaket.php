<tr rowdata="0">
    <td><label class="no-urut">1</label>        
        <?php
            echo CHtml::hiddenField('paket[0][paketpekerjaan_id]','',array('readonly'=>true, 'class'=>'paketpekerjaan_id'));            
            echo CHtml::hiddenField('paket[0][mappingrekeninganggaran_id]','',array('readonly'=>true, 'class'=>'mappingrekeninganggaran_id'));            
            echo CHtml::hiddenField('paket[0][subkegiatanprogram_id]','',array('readonly'=>true, 'class'=>'subkegiatanprogram_id'));            
        ?>                         
    </td>
    <td>        
        <?php            
        $this->widget('MyJuiAutoComplete', array(                
            'name' => 'paket[0][kode_paketpekerjaan]',            
            'sourceUrl' => $this->createUrl('getPaketPekerjaan'),
            'options' => array(
                'showAnim' => 'fold',
                'minLength' => 3,
                'focus' => 'js:function( event, ui ) {
                        $(this).val( ui.item.label);
                        return false;
                    }',
                'select' => 'js:function( event, ui ) {
                            setPaketPekerjaan(ui.item, this);
                            return false;
                              }',
            ),
             'htmlOptions'=>array(
                 'readonly'=>false,
                 'placeholder'=>'Ketikkan nama paket',
                 'size'=>20,
                 'class'=>' kode_paketpekerjaan',
                 'onblur' => 'if(this.value === ""){ $(this).parents("tr").find(".paketpekerjaan_id").val("");$(this).parents("tr").find(".mappingrekeninganggaran_id").val(""); }',
                 'onkeypress'=>"return $(this).focusNextInputField(event);",
             ),
             'tombolDialog'=>array('idDialog'=>'dialogPaketPekerjaan','jsFunction'=>'setRow(this);refreshPaketPekerjaan();$("#dialogPaketPekerjaan").dialog("open")'),
        ));
                
        ?>
    </td>    
    <td>
        <a class="hide btnhapus" onclick='hapusPaket(this);  return false;' href='javascript:;'><i class='glyphicon glyphicon-minus'></i></a>
        <a class=" btntambah"  onclick='tambahPaket(this);  return false;' href='javascript:;'><i class='glyphicon glyphicon-plus'></i></a>
    </td>
</tr>