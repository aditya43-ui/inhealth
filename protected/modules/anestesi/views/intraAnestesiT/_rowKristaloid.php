<tr style="padding-top: 1em;">    
    <td colspan="6"><?php
        echo CHtml::hiddenField('kristaloid['.$i.'][id]',isset($det)?$det->obatcairanintraanastesi_id:'', array('class' => 'span2 id'));
        echo CHtml::textField('kristaloid['.$i.'][nama]',isset($det)?$det->nama:'', array('class' => 'span2'));                
        echo CHtml::link("<i class=icon-plus-sign></i>", "javascript:;", array("onclick" => "tambahKristaloid();return false;", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik Untuk Tambah Kristaloid", "class"=>"btnadd" , "no-urut"=>$i));
        echo CHtml::link("<i class=icon-minus-sign></i>", "javascript:;", array("onclick" => "batalKristaloid(this);return false;", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik Untuk Hapus Kristaloid", "class"=>"btnhapus hide" , "no-urut"=>$i)); 
        ?>
    </td>
</tr>