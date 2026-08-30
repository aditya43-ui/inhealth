<tr>
    <td>
        <?php echo $modMppb->tanggal; ?>
        <?php echo CHtml::activeHiddenField($modMppb,'[ii]tanggal',array('readonly'=>true,'class'=>'span3')); ?>
    </td>
    <td>
        <?php echo $modMppb->kegiatanpmpp; ?>
        <?php echo CHtml::activeHiddenField($modMppb, '[ii]kegiatanpmpp', array('class'=>'span3', 'style'=>'text-align: right;')); ?>
    </td>
    <td>
        <?php echo $modMppb->petugas->namaLengkap; ?>
        <?php echo CHtml::activeHiddenField($modMppb, '[ii]petugas_id', array('readonly' => true,'class'=>'span3', 'style'=>'text-align: right;')); ?>
	</td>
    <td><?php echo Chtml::link('<icon class="icon-form-silang"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', "rel"=>'tooltip','name'=>'yt0','title'=>'Klik untuk menghapus data ini','class'=>'cancel')); ?></td>
</tr>
