<tr style="padding-top: 1em;">    
    <td colspan="6"><?php
        echo CHtml::hiddenField('obat['.$i.'][id]',isset($det)?$det->obatcairanintraanastesi_id:'', array('class' => 'span2 id'));
        echo CHtml::textField('obat['.$i.'][nama]',isset($det)?$det->nama:'', array('class' => 'span2'));                
        echo CHtml::link("<i class=icon-plus-sign></i>", "javascript:;", array("onclick" => "tambahObat();return false;", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik Untuk Tambah Obat", "class"=>"btnadd" , "no-urut"=>$i));
        echo CHtml::link("<i class=icon-minus-sign></i>", "javascript:;", array("onclick" => "batalObat(this);return false;", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik Untuk Hapus Obat", "class"=>"btnhapus hide" , "no-urut"=>$i)); 
        ?>
    </td>
</tr>