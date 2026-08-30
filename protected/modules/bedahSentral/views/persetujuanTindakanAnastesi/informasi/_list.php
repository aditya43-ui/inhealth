<div class="panel_ceklis_informasi" data-idx="<?php echo $cnt; ?>" id="ceklis_informasi_<?php echo $cnt; ?>">
    <?php
    echo "<h5><b>".$jenis->jenisinformasi_nama."</b></h5>";
    echo CHtml::hiddenField('informasi['.$jenis->jenisinformasi_id.'][pemberianinformasi_hasil]', '');    
    ?>
    <?php 
    
    
    
    if ($jenis->tipeinput_isiinformasi == Params::TIPEINPUT_ISIINFORMASI_PENJELASANTETAP) {
        $isi = IsiinformasiM::model()->findByAttributes(array(
            'jenisinformasi_id'=>$jenis->jenisinformasi_id
        ));
        if (!empty($isi)) {
            echo $isi->isiinformasi_nama;
            echo CHtml::hiddenField('informasi['.$jenis->jenisinformasi_id.'][pemberianinformasi_isian]', $isi->isiinformasi_nama);    
        }
    } else if ($jenis->tipeinput_isiinformasi == Params::TIPEINPUT_ISIINFORMASI_DIINPUTOLEHUSER) {
        $isi = IsiinformasiM::model()->findByAttributes(array(
            'jenisinformasi_id'=>$jenis->jenisinformasi_id
        ));
        if (!empty($isi)) {
            echo CHtml::textArea('informasi['.$jenis->jenisinformasi_id.'][pemberianinformasi_isian]', '', array('style'=>'width: 100%'));    
        }
        
    } else if ($jenis->tipeinput_isiinformasi == Params::TIPEINPUT_ISIINFORMASI_CHECKBOX) {
        $isi = IsiinformasiM::model()->findAllByAttributes(array(
            'jenisinformasi_id'=>$jenis->jenisinformasi_id
        ), array(
            'order'=>'isiinformasi_urutan'
        ));
        
        foreach ($isi as $idx=>$item) {
            if (!empty($item->infosebelumcheckbox)) {
                echo $item->infosebelumcheckbox."<br/>";
            }
            echo '<div class="checkbox">';
            echo CHtml::hiddenField('informasi['.$item->jenisinformasi_id.'][ceklis]['.$idx.'][sebelum]', $item->infosebelumcheckbox); 
            echo CHtml::hiddenField('informasi['.$item->jenisinformasi_id.'][ceklis]['.$idx.'][nama]', $item->isiinformasi_nama); 
            echo CHtml::hiddenField('informasi['.$item->jenisinformasi_id.'][ceklis]['.$idx.'][sesudah]', $item->infosetelahcheckbox); 
            echo CHtml::checkBox('informasi['.$item->jenisinformasi_id.'][ceklis]['.$idx.'][ceklis]', false); 
            echo $item->isiinformasi_nama;
            echo '</div>';
            if (!empty($item->infosetelahcheckbox)) {
                echo $item->infosetelahcheckbox."<br/>";
            }
        }
    } ?>
    <div>
        <div class="pull-right">
            <?php echo CHtml::radioButtonList('informasi['.$jenis->jenisinformasi_id.'][pemberianinformasi_hasil]', false, array(
                'Sudah Dijelaskan'=>'Sudah Dijelaskan',
                'Tidak Dijelaskan'=>'Tidak Dijelaskan',
            ), array('template'=>'<div class="radio-inline">{input}{label}</div>', 'separator'=>'', 'class'=>'pemberianinformasi_hasil', 'onclick'=>'inputCeklis(this, '.$cnt.');')); ?>
        </div>
    </div>
    <div class="clear"></div>
    
    <hr/>
    <div>
        <?php echo CHtml::htmlButton('<< Sebelumnya', array('class'=>'btn btn-green', 'disabled'=>($cnt == 0), 'onclick'=>'prev_informasi();')); ?>
        <div class="pull-right">
            <?php echo CHtml::htmlButton('Selanjutnya >>', array('class'=>'btn btn-green', 'disabled'=>($cnt == ($len - 1)), 'onclick'=>'next_informasi();')); ?>
        </div>
    </div>
    <div style="text-align: center"><?php echo '<b>'.($cnt + 1).'</b> dari <b>'.($len).'</b>'; ?></div>
    
    
<hr/>
</div>
