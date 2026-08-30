<tr style="padding-top: 1em;">    
    <th><?php
        echo CHtml::hiddenField('darah['.$i.'][id]',isset($det)?$det->obatcairanintraanastesi_id:'', array('class' => 'span2 id'));
        echo CHtml::dropDownList('darah['.$i.'][subjenis]',isset($det)?$det->sub_jenis:'',CHtml::listData(JeniskomponendarahM::model()->findAllByAttributes(array('jeniskantongdarah_aktif'=>true)),'jeniskantongdarah_singkatan','jeniskantongdarah_singkatan'), array('class' => 'span2','empty'=>'-- Pilih --', 'style'=>'width:80px;'));
        ?></th>
    <th><?php
        echo CHtml::textField('darah['.$i.'][nama]', isset($det)?$det->nama:'', array('class' => 'span2'));
        ?></th>
    <th><?php
        echo CHtml::textField('darah['.$i.'][ukuran]', isset($det)?$det->ukuran:'', array('class' => 'span1 numbers-only',));
        ?>CC</th>
    <td>
        <?php 
            echo CHtml::link("<i class=icon-minus-sign></i>", "javascript:;", array("onclick" => "batalDarah(this);return false;", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik Untuk Hapus Darah",'class'=>'btnhapus hide', "no-urut"=>$i)); 
            echo CHtml::link("<i class=icon-plus-sign></i>", "javascript:;", array("onclick" => "tambahDarah();return false;", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik Untuk Tambah Darah", "class"=>"btnadd" , "no-urut"=>$i));
        ?>
    </td>
</tr>