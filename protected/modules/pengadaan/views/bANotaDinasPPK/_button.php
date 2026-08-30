<div class="row-fluid">
    <div class="form-actions">    
    <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

        if ($model->termin_angka > $model->termin_jumlah) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
            } else if (!isset ($_GET['sukses'])) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit'));
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));   
            }
        echo '&nbsp;';
        
        if (empty($model->notadinasppk_id)) {
           // echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => 'true'));
            //echo "&nbsp;";
        } else {
            //echo CHtml::htmlButton(Yii::t('mds','{icon} Cetak',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'disabled'=>false,'type'=>'button','onclick'=>'print(\'PRINT\')'));
            //echo "&nbsp;";
        }
      
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index', array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id'])), array('class' => 'btn btn-danger', 'onclick' => 'return refreshForm(this);'));

        echo '&nbsp;';
        
        if (isset($_GET['notadinasppk_id'])) {
            echo CHtml::link(Yii::t('mds', '{icon} Kembali', array('{icon}' => '<i class="entypo-back"></i>')), $this->createUrl($this->id . '/index', array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id'])), array('class' => 'btn btn-success'));
        }
    ?>  
    </div>
</div>
<script>
    function print(){
        window.open('<?php echo $this->createUrl('print',array('id'=>$model->notadinasppk_id)); ?>','printwin','left=100,top=100,width=640,height=480');
    }
</script>