<div class="control-group">
    <label class="control-label">Posisi</label>
    <div class="controls">
        <?php echo CHtml::dropDownList('halaman', '', [
            'kiri' => 'Kiri',
            'tengah' => 'Tengah',
            'kanan' => 'Kanan',            
        ],['empty'=>'-- Pilih --']) ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton('Cetak <i class=""entypo-print></i>',['onclick'=>'printLabel('. $id .');', 'class'=>'btn btn-success']); ?>
</div>
