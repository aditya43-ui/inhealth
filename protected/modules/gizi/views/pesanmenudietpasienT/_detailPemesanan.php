<tr>   
    <td>
        <span id="jeniswaktu">
            <?php echo CHtml::checkBox('jeniswaktu[]', $modWaktu['jeniswaktu_id'], array('value'=>$modWaktu['jeniswaktu_id'],'id'=>'jeniswaktu_1','class'=>'jeniswaktu','checked'=>"checked"));?>
        </span>
    </td>
    <td><?php echo $modWaktu['jeniswaktu_nama']; ?>
        
        </td>
    <td><?php echo Chtml::link('<icon class="glyphicon glyphicon-remove"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer;', 'class'=>'cancel')); ?></td>
</tr>        