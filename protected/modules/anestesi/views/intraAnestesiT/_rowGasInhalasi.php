<tr style="padding-top: 1em;" class="tr-gasflow">    
    <td colspan="6"><?php
        echo CHtml::hiddenField('gasinhalasi['.$i.'][id]',isset($det)?$det->obatcairanintraanastesi_id:'', array('class' => 'span2 id gasinhalasi'));
        echo CHtml::textField('gasinhalasi['.$i.'][nama]',isset($det)?$det->nama:'', array('class' => 'span2 nama gasinhalasi'));
        echo CHtml::link("<i class=icon-minus-sign></i>", "javascript:;", array("onclick" => "batalGasInhalasi(this);return false;", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik Untuk Hapus Gas Inhalasi", "class"=>"btnhapus hide")); 
        echo CHtml::link("<i class=icon-plus-sign></i>", "javascript:;", array("onclick" => "tambahGasInhalasi();return false;", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik Untuk Tambah Gas Inhalasi", 'class'=>'btnTambahGasInhalasi btnadd'))
        ?>
    </td>
</tr>