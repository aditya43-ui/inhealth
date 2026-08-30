<div style="margin-top: 10px;">
    <img src="data:image/png;base64, <?php echo $res_img['data']; ?>" style="height: 200px;"/>
</div>
<div style="margin-bottom: 10px;">
    <table style="width: 200px">
        <tr>
            <td width="100">Suhu Tubuh</td>
            <td width="10">:</td>
            <td><?php echo $res['tempratrue']; ?>&#8451</td>
        </tr>
        <tr>
            <td width="100">Pakai Masker</td>
            <td width="10">:</td>
            <td><?php 
            $val = $res['mask']; 
            
            if ($val == 1) {
                echo "Ya";
            } else if ($val == -1) {
                echo "Deteksi Masker tidak Aktif";
            } else {
                echo "Tidak";
            }
            
            ?>
            </td>
        </tr>
    </table>
    <?php echo CHtml::hiddenField('scan[waktuscan]', $res['currentTime']); ?>
    <?php echo CHtml::hiddenField('scan[suhu_tubuh]', $res['tempratrue']); ?>
    <?php echo CHtml::hiddenField('scan[pake_masker]', $res['mask']); ?>
    <?php echo CHtml::hiddenField('scan[data_gambar]', $res_img['data']); ?>
</div>

