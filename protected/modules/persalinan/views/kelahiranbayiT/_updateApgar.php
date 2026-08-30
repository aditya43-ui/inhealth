           
<form id="update_apgar">
    
<?php echo CHtml::hiddenField('kelahiranbayi_id', $modApgarScore[0]->kelahiranbayi_id); ?>
<?php echo CHtml::hiddenField('menitke', $modApgarScore[0]->menitke); ?>
    
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Kriteria</th>
            <th>Nilai</th>
        </tr>
    </thead>
    <tbody>
        
        
        
        <?php $i = 1; 
        
        
        $metode = MetodeapgarM::model()->findAll(array(
            'order'=>'metodeapgar_id asc',
        ));     
        
        $lister = CHtml::listData($modApgarScore, 'metodeapgar_id', 'nilai_apgar');
        ?>
        <?php foreach($metode as $row2){ 
            $list = array(
                "0 - ".$row2->nilai_0,
                "1 - ".$row2->nilai_1,
                "2 - ".$row2->nilai_2
            );
            
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $row2->kriteria; ?></td>
                <td><?php echo CHtml::dropDownList('nilai_apgar['.$row2->metodeapgar_id.']', $lister[$row2->metodeapgar_id], $list, array(
                    'class'=>'span5',
                )); ?></td>
                <?php $i++; ?>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php echo CHtml::htmlButton('<i class="entypo-check"></i> Simpan', array(
    'class' => 'btn btn-danger',
    'onclick'=>'submitUpdateApgar()',
    'id'=>'btn_update_apgar'
)); ?>
</form>