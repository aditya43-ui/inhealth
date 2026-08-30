<style>
    .base {
        max-width: 600px;
        /* max-: 400px; */
    }
</style>

<?php
    
echo CHtml::image($this->pathScanRM.$file->namafolder.'/'.$file->dokfilerm_filepath, $file->dokfilerm_filepath, array(
    'id'=>'detail_gambar',
    'width'=>'100%',
    'height'=>'100%',
));


?>

