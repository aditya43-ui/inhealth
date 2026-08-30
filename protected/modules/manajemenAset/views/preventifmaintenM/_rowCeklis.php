<tr>
    <td>
        <?php // echo CHtml::hiddenField("ceklis[]", isset($model->ipmchecklist_id) ? $model->ipmchecklist_id : '',array('class'=>'span1', 'readonly'=>true)); ?>
        <?php echo CHtml::textField("ceklis[]", $model->ipmchecklist_list , array('class'=>'span3','style' =>'margin-top: 5px;' ,'readonly'=>true)); ?>
    </td>
    <td>
        <a onclick="hapus(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus berkas" data-placement="center"><i style="margin-left: 10px;" class=" glyphicon glyphicon-remove"></i></a>
    </td>
</tr>
