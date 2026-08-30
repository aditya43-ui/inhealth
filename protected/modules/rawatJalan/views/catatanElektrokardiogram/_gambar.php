<?php
    
    $path2 = $model->gambar_path;
    // echo '<pre>'; var_dump($model->gambar_path); die;
    if (file_exists($path2)) {
        $content = file_get_contents($path2);
        $ext_data = pathinfo($path2);
        
        if (!empty($ext_data) && is_array($ext_data) && !empty($ext_data)) {
            $ext = $ext_data['extension'];
        }
        
        $res2 = "data:image/".$ext.";base64,". base64_encode($content);
    }
    
    ?>
<center>
    <div style="text-align: center; width: 80%; margin-top: 50px;">
        <img src="<?php echo !empty($res2) ? $res2 : 'File tidak ditemukan'; ?>" id="prev-gambar" />
    </div>
</center>