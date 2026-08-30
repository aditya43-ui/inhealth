<tr data-row="<?php echo $i ?>" class="tabelnyasispesimen">
    <!--<td style="text-align: center"><span class="no_urut"><?php echo $i + 1; ?></span></td>-->    
    <td>
        <?php // echo !empty($modSpesimen->samplelab_nama) ? $modSpesimen->samplelab_nama : ''; ?>
        <div class="input-append">
            <?php echo CHtml::activeTextField($modSpesimen, '['.$i.']samplelab_nama', array('class'=>'span2 nama_samplelab required','readonly'=>true)); ?>
        </div>
        <?php echo CHtml::activeHiddenField($modSpesimen, '['.$i.']samplelab_id', array('class' => 'span2 id_samplelab required', 'readonly' => true)); ?>
        <?php echo CHtml::activeHiddenField($modSpesimen, '[' . $i . ']status', array('class' => 'status', 'readonly' => true)); ?>
        <?php echo CHtml::activeHiddenField($modSpesimen, '[' . $i . ']spesimen_id', array('class' => 'span3', 'readonly' => true)); ?>
        <?php echo CHtml::activeHiddenField($modSpesimen, '[' . $i . ']no_spesimen', array('class' => 'span3', 'readonly' => true)); ?>
    </td>
    <td width="275px !important">
        <div class="input-append">
            <?php echo CHtml::activeTextField($modSpesimen, '['.$i.']pemeriksaanlab_nama', array('placeholder' => 'Pilih Pemeriksaan','class'=>'required')); ?>
            <span class="add-on"><a onclick="setDialogPemeriksaan(this);" id="" href="javascript:void(0);"><i class="icon-list"></i><i class="icon-search"></i></a></span>
        </div>
        <?php echo CHtml::activeHiddenField($modSpesimen, '['.$i.']pemeriksaanlab_id', array('class' => 'span2 required', 'readonly' => true)); ?>
        <?php echo CHtml::activeHiddenField($modSpesimen, '['.$i.']tindakanpelayanan_id', array('class' => 'span2', 'readonly' => true)); ?>
        <?php echo CHtml::activeHiddenField($modSpesimen, '['.$i.']daftartindakan_id', array('class' => 'span2', 'readonly' => true)); ?>
        <?php echo CHtml::activeHiddenField($modSpesimen, '['.$i.']tarif_pelayananan', array('class' => 'span2', 'readonly' => true)); ?>
        <?php echo CHtml::activeHiddenField($modSpesimen, '['.$i.']permintaankepenunjang_id', array('class' => 'span2', 'readonly' => true)); ?>
        <?php echo CHtml::activeHiddenField($modSpesimen, '['.$i.']spesimen_id', array('class' => 'span2', 'readonly' => true)); ?>
        <?php echo CHtml::activeHiddenField($modSpesimen, '['.$i.']statusspesimen', array('class' => 'span2 statusspesimen', 'readonly' => true)); ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modSpesimen, '['.$i.']status', LookupM::getItems('jenispermintaan'), array('empty'=>'-- Pilih --', 'class'=>'span2 status_spesimen')); ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modSpesimen, '['.$i.']kualitas_spesimen', LookupM::getItems('kualitasspesimen'), array('empty'=>'-- Pilih --','class'=>'span2 required')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextArea($modSpesimen, '['.$i.']alasan', array('class' => 'span3', 'placeholder'=>'Alasan')); ?>
    </td>
    <td>
        <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', 'javascript:void(0)', array('class' => 'btn btn-primary btntambah', 'rel' => 'tooltip', 'title' => 'Klik untuk menambahkan data' ,'onclick' => 'tambahBaris()')); ?>
        <?php
        if (!empty($modSpesimen->permintaankepenunjang_id)) {
            echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', 'javascript:void(0)', array('class' => 'btn btn-danger btnhapus', 'onclick' => 'hapusData(this)', "rel" => "tooltip", "data-original-title" => "Klik untuk menghapus Data", 'data-placement' => 'left'));
        } else {
            echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', 'javascript:void(0)', array('class' => 'btn btn-danger btnhapus', 'onclick' => 'hapusBaris(this)', "rel" => "tooltip", "data-original-title" => "Klik untuk menghapus Data", 'data-placement' => 'left'));
        }
        ?>
    </td>
</tr>