<tr  rowdata="0">
    <td><span class="program"><?php echo $model->programkerja_nama ?></span></td>
    <td><span class="kegiatan"><?php echo $model->subprogramkerja_nama ?></span></td>
    <td>
        <?php
            echo CHtml::activeHiddenField($model, '[0]subkegiatanprogram_id', array('class'=>'subkegiatanprogram_id'));
            echo CHtml::activeHiddenField($model, '[0]kegiatanprogram_id', array('class'=>'kegiatanprogram_id'));
            echo CHtml::activeHiddenField($model, '[0]subprogramkerja_id', array('class'=>'subprogramkerja_id'));
            echo CHtml::activeHiddenField($model, '[0]programkerja_id', array('class'=>'programkerja_id'));
            echo CHtml::activeHiddenField($model, '[0]pengadaanprogram_id', array('class'=>'pengadaanprogram_id'));
            if ($tipe == 'new'){
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => '[0]subkegiatanprogram_nama',
                    'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('AutocompleteKegiatan') . '",
                                dataType: "json",
                                data: {
                                    term: request.term,
                                    instalasi_id: $("#ADRencanaumumpengadaanT_instalasi_id").val(),
                                    periodeanggaran_id: $("#ADRencanaumumpengadaanT_periodeanggaran_id").val(),
                                },
                                success: function (data) {
                                    response(data);
                                }
                            })
                        }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                return false;
                            }',
                        'select' => 'js:function( event, ui ) {
                                setData(ui.item, this);
                                showRAB();
                                return false;
                            }',
                    ),
                    'htmlOptions' => array(
                        'class' => 'hurufs-only subkegiatanprogram_nama',
                        'placeholder' => 'Ketik Nama Kegiatan',
                        'onchange' => ""
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogSubKegiatan', 'jsFunction'=>'setRow(this);refreshSubKegiatan();$("#dialogSubKegiatan").dialog("open");'),
                ));
            }else{
                echo "<span class='subkegiatan'>".$model->subkegiatanprogram_nama."</span>";
            }
        ?>        
    </td>
    <td>
        <?php
            if ($tipe == 'new'){
        ?>
                <a class="hide btnhapus" onclick='hapusSub(this);  return false;' href='javascript:;'><span style="font-size:15px;color:red;"><i class='glyphicon glyphicon-minus'></i></span></a>
                <a class=" btntambah"  onclick='tambahSub(this);  return false;' href='javascript:;'><span style="font-size:15px;"><i class='glyphicon glyphicon-plus'></i></span></a>
                
                <?php
            }
                ?>
    </td>
</tr>