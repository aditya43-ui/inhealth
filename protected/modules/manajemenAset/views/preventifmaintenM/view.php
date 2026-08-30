<?php


$res = array();

foreach ($models as $item) {

    if (!$item->ipmchecklist_list) {
        continue;
    }

    $ipm = IpmchecklistM::model()->findByPk($item->ipmchecklist_id);

    if (empty($res[$ipm->ipm_jenis])) {
        $res[$ipm->ipm_jenis] = array();
    }

    $res[$ipm->ipm_jenis][] = $item;
}

$str = "";

foreach ($res as $jenis => $grup) {

    $str .= "<strong>".$jenis."</strong>";
    $str .= '<ul style="list-style-type:none">';
    foreach ($grup as $item) { 
        if (!$item->ipmchecklist_list) {
            continue;
        }
        $str .= '<li><ul style="list-style-type:'.($item->ipmchecklist_list ? 'disc' : 'circle').'"><li>';

        $ceklis = IpmchecklistM::model()->findByPk($item->ipmchecklist_id);
        $str .= $ceklis->ipm_listnama;

        $str .= '</li></ul></li>';

    }

    $str .= '</ul>';
}
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Detail Preventive Maintenance Barang - <?php echo $barang->barang_nama; ?>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"> <i class="far fa-file"></i> Perhitungan</div>
            </div>
            <div class="panel-body">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                    'data'=>$modHitung,
                    'attributes'=>array(
                        array(
                            'label'=>'Fungsi',
                            'name'=>'res_fungsi_nama',
                            'value'=>$modHitung->res_fungsi_nama." (".$modHitung->res_fungsi_nilai.")",
                        ),
                        array(
                            'label'=>'Klinis',
                            'name'=>'res_klinis_nama',
                            'value'=>$modHitung->res_klinis_nama." (".$modHitung->res_klinis_nilai.")",
                        ),
                        array(
                            'label'=>'Pemeliharaan',
                            'name'=>'res_pemeliharaan_nama',
                            'value'=>$modHitung->res_pemeliharaan_nama." (".$modHitung->res_pemeliharaan_nilai.")",
                        ),
                        array(
                            'label'=>'insiden',
                            'name'=>'res_insiden_nama',
                            'value'=>$modHitung->res_insiden_nama." (".$modHitung->res_insiden_nilai.")",
                        ),
                        array(
                            'label'=>'Ceklis',
                            'type'=>'raw',
                            'value'=>$str,
                        ),
                    ),
                )); ?>
            </div>
        </div>
        
        <div class="row-fluid">
            <div class="form-actions">
            <?php // echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->preventifmainten_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Preventive Maintenance Barang',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
            <?php $this->widget('UserTips',array('content'=>''));?>
            </div>
        </div>
    </div>
</div>