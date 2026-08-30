<table>
    <tr>
        <td class="box">
            <div id="formPeriksaBedah">
                <?php echo CHtml::hiddenField('patokanDalam') ?>
                <?php echo CHtml::hiddenField('patokanAsli') ?>
                <?php echo CHtml::hiddenField('is_operasi') ?>
                <?php echo CHtml::hiddenField('is_operasibersama') ?>
                <?php
                    foreach($modKegiatanOperasi as $i=>$kegiatanOperasi)
                    {
                        $ceklist = false;
                ?>
                        <div class="boxtindakan">
                            <h6><?php echo $kegiatanOperasi->kegiatanoperasi_nama; ?></h6>
                            <?php
                                foreach ($modOperasi as $j => $operasi)
                                {
                                     if($kegiatanOperasi->kegiatanoperasi_id == $operasi->kegiatanoperasi_id)
                                     {
                                         echo CHtml::checkBox("operasi[]", $ceklist,
                                            array(
                                                'value'=>$operasi->operasi_id,
                                                'tag'=>$operasi->daftartindakan_id,
                                                'onclick' => "getDataOperasi(this)",
                                                'class'=>'cekOperasi'
                                            )
                                         );
                                         echo "<span>".$operasi->operasi_nama."</span><br>";
                                     }
                                }
                            ?>
                        </div>
                <?php } ?>
            </div>
        </td>
    </tr>
</table>

<script>
    function getDataOperasi(obj)
    {
        var is_operasi = $("#is_operasi").val();
        var is_operasibersama = $("#is_operasibersama").val();
        var id_operasi = $(obj).val();
        
        if($(obj).is(':checked'))
        {
            if(items['key_' + $(obj).attr('tag')] == undefined)
            {
                var kelaspelayanan_id = $("#BSMasukPenunjangV_kelaspelayanan_id").val();
                $.post('<?php echo $this->createUrl('/'.Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/GetDataOperasi') ?>', {idOperasi:$(obj).val(), is_operasi:is_operasi, is_operasibersama:is_operasibersama, kelaspelayanan_id:kelaspelayanan_id},
                    function(data)
                    {
                        if(data.success)
                        {
                            items['key_' + data.item] = 'yes';
                            tambahTindakanPemakaianBahan(data.item,data.label);
                            $("#tblFormRencanaOperasi tbody").append(data.rec.replace());
                            renameRow();
                        }
                    },
                'json');
            }else{
                myAlert('Tindakan telah terfatar, silakan cek kembali!');
                $(obj).attr('checked', false);
            }
            setTimeout(function(){getRowsTypeAnastesiDropdown()},1500);
        }else{
            $('#tblFormRencanaOperasi > tbody').find('input[name$="[operasi_id]"]').each(
                function()
                {
                    if($(this).val() == id_operasi)
                    {
                        delete items['key_' + id_operasi];
                        $(this).parents('tr').detach();
                    }
                }
            );
        }
    }
    
    function renameRow()
    {
        var idx = 0;
        $("#tblFormRencanaOperasi tbody").find('tr').each(
            function()
            {
                $(this).find('input').each(
                    function()
                    {
                        var name_field = $(this).attr('name');
                        var id_field = $(this).attr('id');
                        $(this).attr('name', name_field.replace('99', idx));
                        $(this).attr('id', id_field.replace('99', idx));
                    }
                );
                $(this).find('select').each(
                    function()
                    {
                        var name_field = $(this).attr('name');
                        var id_field = $(this).attr('id');
                        $(this).attr('name', name_field.replace('99', idx));
                        $(this).attr('id', id_field.replace('99', idx));
                    }
                );
                jQuery('#BSTindakanPelayananT_'+ idx +'_mulaioperasi').datetimepicker(
                    jQuery.extend(
                        {showMonthAfterYear:false},
                        jQuery.datepicker.regional['id'],
                        {
                            'dateFormat':'dd M yy',
                            'timeText':'Waktu',
                            'hourText':'Jam',
                            'minuteText':'Menit',
                            'secondText':'Detik',
                            'showSecond':true,
                            'timeOnlyTitle':'Pilih Waktu',
                            'timeFormat':'hh:mm:ss',
                            'changeYear':true,
                            'changeMonth':true,
                            'showAnim':'fold',
                            'yearRange':'-80y:+20y'
                        }
                    )
                );                    
                jQuery('#BSTindakanPelayananT_'+ idx +'_selesaioperasi').datetimepicker(
                    jQuery.extend(
                        {showMonthAfterYear:false},
                        jQuery.datepicker.regional['id'],
                        {
                            'dateFormat':'dd M yy',
                            'timeText':'Waktu',
                            'hourText':'Jam',
                            'minuteText':'Menit',
                            'secondText':'Detik',
                            'showSecond':true,
                            'timeOnlyTitle':'Pilih Waktu',
                            'timeFormat':'hh:mm:ss',
                            'changeYear':true,
                            'changeMonth':true,
                            'showAnim':'fold',
                            'yearRange':'-80y:+20y'
                        }
                    )
                );                    
                idx++;
            }
        );
    }    

</script>