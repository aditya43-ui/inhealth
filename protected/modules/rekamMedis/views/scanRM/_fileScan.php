<div style="float:left;display: inline-block;position: relative;">        
    <a style="position: relative;" class="img_scan" href="<?php echo $this->createUrl('detailScanRM', array(
    'dokfilerm_id'=>$item->dokfilerm_id,
)); ?>" onclick="$('#dialog_detail').dialog('open'); $('#img_title').html('<?php echo $item->dokfilerm_filepath; ?>');" target="iframe_detail">
    <div class="img_content" style="text-align: center;">
        <?php         
            if (strpos($item->dokfilerm_filepath,'.pdf') !== false){
                echo "<button type='button' style='text-align:center;'><span style='font-size:60px;'><i class='".MyIcon::getIcons('pdf')."'></i></span></button>";
            }else{
                echo CHtml::image($this->pathScanRM.$item->namafolder.'/'.$item->dokfilerm_filepath, $item->dokfilerm_filepath, array(
                    'style'=>'max-width:200px; max-height: 300px;',
                )); 
            }
        ?>
    </div>
    <div class="img_info">
        <?php echo 'Nama Dokumen : <b>'.$item->dokfilerm_nama.'</b>'; ?><br>
        <?php echo '<b><u>'.$item->dokfilerm_filepath.'</u></b>'; ?><br/>
        <?php echo "Tgl. Scan : ". MyFormatter::formatDateTimeForUser($item->scan_tgl); ?><br/>
        <?php echo "Tgl. Upload : ". MyFormatter::formatDateTimeForUser($item->upload_tgl); ?><br/>        
        <?php echo "Batal"; 
        
        ?>
    </div>    
    </a>
    <?php 
        
        $onclick = 'window.parent.myAlert("Tidak bisa dihapus karena hak akses tidak sesuai")';

        $bisa_hapus = CustomFunction::hakAksesHapus(Yii::app()->user->getState('loginpemakai_id'), $item->create_ruangan, $item->create_loginpemakai_id);

        if($bisa_hapus) {
            $onclick = 'hapusGambar(this)';
        }

        echo CHtml::link("<span style='font-size:30px;color:red;z-index:9999;'><i class='".MyIcon::getIcons('batal')."'></i></span>","javascript:;",array('onclick' => $onclick,'dokfilerm_id'=>$item->dokfilerm_id, 'rel'=>'tooltip', 'data-original-title'=>'Klik untuk menghapus gambar ini', 'data-placement'=>'left', 'style'=>'position: absolute;top: 0;right: 0;z-index:999;', 'disabled' => true));
        
    ?>        
</div>
