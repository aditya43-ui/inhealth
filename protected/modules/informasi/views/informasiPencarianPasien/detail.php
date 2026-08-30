<style>
    .base {
        max-width: 400px;
        /* max-: 400px; */
    }
</style>

<?php
    
echo CHtml::image(Params::urlFileRMPasienDirectory().$file->namafolder.'/'.$file->dokfilerm_filepath, $file->dokfilerm_filepath, array(
    'id'=>'detail_gambar',
    'width'=>'50%',
    'height'=>'50%',
));


?>

