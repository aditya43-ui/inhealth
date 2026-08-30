<?php

$result = array();
foreach ($modListKie as $l) {
    $result[$l['jeniskie']]['jeniskie'] = $l['jeniskie'];
    $result[$l['jeniskie']]['detail'][] = array(
        'jeniskie' => $l['jeniskie'],
        'listkie_id' => $l['listkie_id'],
        'listkie_nama' => $l['listkie_nama']

    );
}
?>

<?php foreach($result as $k => $v){?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo $k ?></div>
                </div>
                <div class="panel-body">
                    <div class="check" style="display:flex;">
                        <div style="margin-left:10px;"><input type="checkbox" onchange="checkAll(this)" name="chk[]" value="Pilih Semua"></div>
                        <div class="cekAll" ><label>Pilih Semua</label></div>
                    </div>
                    <!-- <br> -->
                    <?php 
                    $ceklist = false;
                    $i=0;
                    foreach($v['detail'] as $det) { ?>
                        <?php 
                        echo '<div>';
                            echo '<label class="checkbox inline">'.CHtml::activeCheckBox($modKieDet,'['.$det['listkie_id'].']listkie_id', array('value'=>$det['listkie_id'],
                            'onclick' => "inputperiksa(this);"));
                            echo "<span>".$det['listkie_nama']."</span></label><br/>";
                            echo CHtml::activeHiddenField($modKieDet,'['.$det['listkie_id'].']jeniskie',array('value'=>$det['jeniskie'],'readonly'=>true,'class'=>'span1'));

                            echo $form->hiddenField($modKieDet,'[]listkie_id');
                            echo $form->hiddenField($modKieDet,'[]jeniskie');
                        echo '</div>';
                        ?>
                    <?php  } $i++; ?>
                </div>
	        </div>
        </div>
    </div>
<?php } ?>

<script>
    function checkAll(ele) {
      var checkboxes = document.getElementsByTagName('input');
      if (ele.checked) {
          for (var i = 0; i < checkboxes.length; i++) {
              if (checkboxes[i].type == 'checkbox' ) {
                  checkboxes[i].checked = true;
              }
          }
      } else {
          for (var i = 0; i < checkboxes.length; i++) {
              if (checkboxes[i].type == 'checkbox') {
                  checkboxes[i].checked = false;
              }
          }
      }
  }
</script>