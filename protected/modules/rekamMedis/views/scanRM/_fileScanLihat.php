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
</div>
