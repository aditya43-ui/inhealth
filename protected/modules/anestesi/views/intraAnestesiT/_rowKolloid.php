<tr style="padding-top: 1em;">    
    <td colspan="6"><?php
        echo CHtml::hiddenField('kolloid['.$i.'][id]',isset($det)?$det->obatcairanintraanastesi_id:'', array('class' => 'span2 id'));
        echo CHtml::textField('kolloid['.$i.'][nama]',isset($det)?$det->nama:'', array('class' => 'span2'));                
        echo CHtml::link("<i class=icon-plus-sign></i>", "javascript:;", array("onclick" => "tambahKolloid();return false;", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik Untuk Tambah Kolloid", "class"=>"btnadd" , "no-urut"=>$i));
        echo CHtml::link("<i class=icon-minus-sign></i>", "javascript:;", array("onclick" => "batalKolloid(this);return false;", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik Untuk Hapus Kolloid", "class"=>"btnhapus hide" , "no-urut"=>$i)); 
        ?>
    </td>
</tr>