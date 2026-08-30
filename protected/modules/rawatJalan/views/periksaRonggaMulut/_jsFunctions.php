<script type="text/javascript">

    function printPemeriksaanFisik()
    {
        window.open('<?php echo $this->createUrl('printPemeriksaanFisik', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=950px,height=1122');
    }

    function defaultparamedis()
    {
        var paramedis = '<?php
$pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
if (!empty($pegawai))
    echo $pegawai->nama_pegawai;
?>';
        $("#<?php echo CHtml::activeId($model, 'paramedis_nama') ?>").val(paramedis);
    }

    function batalTambahBagianTubuh(obj) {
        //var conf = confirm("Apakah Anda yakin akan membatalkan pemilihan pemeriksaan ini ?");
        window.parent.myConfirm("Apakah Anda yakin akan membatalkan pemilihan pemeriksaan ini?", "Perhatian", function (r) {
            if (r) {
                var bagiantubuh_id = $(obj).parents('tr').find('input[name$="[bagiantubuh_id]"]').val();
                var gambartubuh_id = $(obj).parents('tr').find('input[name$="[gambartubuh_id]"]').val();
                var kordinat_tubuh_x = $(obj).parents('tr').find('.kordinat_tubuh_x').val();
                var kordinat_tubuh_y = $(obj).parents('tr').find('.kordinat_tubuh_y').val();
                var keterangan_periksa_gbr = $(obj).parents('tr').find('.keterangan_periksa_gbr').val();

                kordinat_tubuh_x = kordinat_tubuh_x.replace(/\./g, '_');
                kordinat_tubuh_y = kordinat_tubuh_y.replace(/\./g, '_');

                $(obj).parents('tbody').find('input[name$="[bagiantubuh_id]"][value="' + bagiantubuh_id + '"]').each(function () {
                    if ($(this).data('delete') == gambartubuh_id + '_' + kordinat_tubuh_x + '_' + kordinat_tubuh_y) {
                        $(this).parents('tr').detach();
                    }
                });
                
                $("#imgtag" + gambartubuh_id).find('#titikbiru_' + bagiantubuh_id + '_' + kordinat_tubuh_x + '_' + kordinat_tubuh_y).detach();
                $("#imgtag" + gambartubuh_id).find('#titikbirutext_' + bagiantubuh_id + '_' + kordinat_tubuh_x + '_' + kordinat_tubuh_y).detach();
                renameInput($('#table-bagtubuh'));
            }
        });

    }

    function hapusBagianTubuh(obj) {

        var bagiantubuh_id = $(obj).parents('tr').find('.bagiantubuh_id').val();
        var pemeriksaangambarronggamulut_id = $(obj).parents('tr').find('.pemeriksaangambarronggamulut_id').val();
        var gambartubuh_id = $(obj).parents('tr').find('.gambartubuh_id').val();
        var kordinat_tubuh_x = $(obj).parents('tr').find('.kordinat_tubuh_x').val();
        var kordinat_tubuh_y = $(obj).parents('tr').find('.kordinat_tubuh_y').val();
        var keterangan_periksa_gbr = $(obj).parents('tr').find('.keterangan_periksa_gbr').val();
        var pasienmasukpenunjang_id = <?php echo!empty($modKunjungan->pasienmasukpenunjang_id) ? $modKunjungan->pasienmasukpenunjang_id : "''"; ?>;

        var koor_tubuh_x = kordinat_tubuh_x.replace(/\./g, '_');
        var koor_tubuh_y = kordinat_tubuh_y.replace(/\./g, '_');

        window.parent.myConfirm("Apakah Anda yakin akan menghapus pemeriksaan ini?", "perhatian", function (r) {
            if (r) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->createUrl('HapusBagianTubuh') ?>",
                    data: "bagiantubuh_id=" + bagiantubuh_id + "&pemeriksaangambarronggamulut_id=" + pemeriksaangambarronggamulut_id + "&gambartubuh_id=" + gambartubuh_id + "&kordinat_tubuh_x=" + kordinat_tubuh_x + "&kordinat_tubuh_y=" + kordinat_tubuh_y + "&keterangan_periksa_gbr=" + keterangan_periksa_gbr + "&pasienmasukpenunjang_id=" + pasienmasukpenunjang_id,
                    dataType: "json",
                    success: function (data) {
                        if (data.ok == 0) {
                            window.parent.myAlert(data.pesan);
                        } else {

                            $(obj).parents('tbody').find('input[name$="[bagiantubuh_id]"][value="' + bagiantubuh_id + '"]').each(function () {
                                if ($(this).data('delete') == gambartubuh_id + '_' + koor_tubuh_x + '_' + koor_tubuh_y) {
                                    $(this).parents('tr').detach();
                                }
                            });
                            $("#imgtag" + gambartubuh_id).find('#titikbiru_' + bagiantubuh_id + '_' + koor_tubuh_x + '_' + koor_tubuh_y).detach();
                            $("#imgtag" + gambartubuh_id).find('#titikbirutext_' + bagiantubuh_id + '_' + koor_tubuh_x + '_' + koor_tubuh_y).detach();
                            renameInput($('#table-bagtubuh'));

                            window.parent.myAlert(data.pesan);
                        }

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        });
    }

    function renameInput(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function () {
            $(this).find("#no_urut").val(row + 1);
            $(this).find('span').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input,select,textarea').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            row++;
        });

    }

    function titikSebelumSimpan(ptitikX, ptitikY, lebar, rotasi, bagiantubuh_id, img) {
        var titikX = Math.round(ptitikX) - 10;
        var titikY = Math.round(ptitikY) - 10;
        var color = 'rgba(219, 50, 92, 0.9)';
        var size = '1px';

        var xtitik = ptitikX.replace(/\./g, '_');
        var ytitik = ptitikY.replace(/\./g, '_');

        $(img).append(
                $('<div id="titik_' + bagiantubuh_id + '_' + xtitik + '_' + ytitik + '"></div>')
                .css('position', 'absolute')
                .css('top', titikY + 'px')
                .css('left', titikX + 'px')
                .css('width', size)
                .css('height', size)
                .css('background-color', color)
                .css('cursor', 'pointer')
                .css('display', 'block')
                .css('padding', '5px')
                .css('-webkit-border-radius', '50%')
                .css('-moz-border-radius', '50%')
                .css('border-radius', '50%')
                .css('transform', 'rotate('+ rotasi + 'deg) scaleX(' + lebar/10 + ')')
                );
    }

    function titikSesudahSimpan(titikX, titikY, urutan, lebar, rotasi, bagiantubuh_id, img) {
        var x_titik = titikX.toFixed(7);
        var y_titik = titikY.toFixed(7);

        var titikX = titikX - 10;
        var titikY = titikY - 10;
        var nomor = urutan + 1;
        var color = 'rgba(219, 50, 92, 0.9)';
        var size = '5px';

        x_titik = x_titik.replace(/\./g, '_');
        y_titik = y_titik.replace(/\./g, '_');

        $(img).append(
                $('<div id="titikbiru_' + bagiantubuh_id + '_' + x_titik + '_' + y_titik + '"></div>')
                .css('position', 'absolute')
                .css('top', titikY + 'px')
                .css('left', titikX + 'px')
                .css('width', size)
                .css('height', size)
                .css('background-color', color)
                .css('cursor', 'pointer')
                .css('display', 'block')
                .css('padding', '5px')
                .css('-webkit-border-radius', '50%')
                .css('-moz-border-radius', '50%')
                .css('border-radius', '50%')
                .css('vertical-align', 'middle')
                .css('transform', 'rotate('+ rotasi + 'deg) scaleX(' + lebar/10 + ')')
                );
        $(img).append(
                $('<div id="titikbirutext_' + bagiantubuh_id + '_' + x_titik + '_' + y_titik + '"><strong style="position:absolute;top:0;left: 0;color:#000;">' + nomor + '</b></div>')
                .css('position', 'absolute')
                .css('top', titikY + 'px')
                .css('left', titikX + 'px')
        );
    }

    function loadTitikSesudahSimpan() {
<?php
if (!empty($modPemeriksaanGambar)) {
    $j = 1;
    foreach ($modPemeriksaanGambar as $i => $v) {
        ?>
                titikSesudahSimpan(<?= $v->kordinat_tubuh_x; ?>, <?= $v->kordinat_tubuh_y . ',' . $i . ',' . $v->lebar .','.$v->rotasi.','.$v->bagiantubuh_id ?>, '#imgtag<?php echo $v->gambartubuh_id; ?>');

        <?php $j++;
    }
}
?>
    }
    $(document).ready(function () {
        loadTitikSesudahSimpan();

        var counter = 0;
        var mouseX = 0;
        var mouseY = 0;

        $("[id^=imgtag] img").click(function (e) { // make sure the image is click
            var imgtag = $(this).parent(); // get the div to append the tagging list
            var no_img = $(this).attr('img-no');
            var gambartubuh_id = $(this).data('id');
            mouseX = (e.pageX - $(imgtag).offset().left); // x and y axis
            mouseY = (e.pageY - $(imgtag).offset().top);
            var displaySensor = 'none';
            console.log(no_img);
            
            console.log("bagian tubuh : ", gambartubuh_id);

            if (mouseX != 0 && mouseY != 0) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->createUrl('getBagianTubuhId') ?>",
                    data: {
                        kordinat_x : mouseX,
                        kordinat_y : mouseY,
                        gambartubuh_id : gambartubuh_id,
                    },
                    dataType: "json",
                    success: function (data) {

                        if (data.kakitangan == 'ok') {
                            displaySensor = 'true';
                        }

                        $('[id^=titikklik]').remove(); // menghapus titik lain selain titik current klik
                        $("#imgtag" + no_img).append(
                                $('<div id="titikklik' + no_img + '"></div>')
                                .css('position', 'absolute')
                                .css('top', Math.round(mouseY) - 10 + 'px')
                                .css('left', Math.round(mouseX) - 10 + 'px')
                                .css('width', '5px')
                                .css('height', '5px')
                                .css('background-color', 'rgba(219, 50, 92, 0.5)')
                                .css('cursor', 'pointer')
                                .css('display', 'block')
                                .css('padding', '5px')
                                .css('-webkit-border-radius', '50%')
                                .css('-moz-border-radius', '50%')
                                .css('border-radius', '50%')
                                );
                        var html = '<div id="tagit' + no_img + '">\n\
                <div class="name"  style="padding:10px;">\n\
                    <div class="text"><b>Data Pemeriksaan</b></div>\n\
                    <table>\n\
                        <tr>\n\
                            <td style="text-align: right; vertical-align: top;">Bagian Tubuh : </td>\n\
                            <td>\n\
                                <input type="hidden" id="gambartubuh_id' + no_img + '" value="' + no_img + '">\n\
                                <select id="bagiantubuh_id' + no_img + '" name="bagiantubuh_id" onkeypress="return $(this).focusNextInputField(event);" class="span3">\n\
                                ' + data.options + '\n\
                                \n\
                            </select>\n\
                            </td>\n\
                        </tr>\n\
                        <tr>\n\
                            <td style="text-align: right; vertical-align: top;">Lebar : </td>\n\
                            <td><input id ="lebar' + no_img + '" class="span3" type="range" min="1" max="100", value="10" oninput="transformTitik(' + no_img + ');" onkeypress="return $(this).focusNextInputField(event);"></input><?php //echo CHtml::textArea('keterangan','', array('class'=>'span2 ', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?><br>\n\</td>\n\
                        </tr>\n\
                        <tr>\n\
                            <td style="text-align: right; vertical-align: top;">Putaran : </td>\n\
                            <td><input id ="rotasi' + no_img + '" class="span3" type="range" min="0" max="180", value="0" oninput="transformTitik(' + no_img + ');" onkeypress="return $(this).focusNextInputField(event);"></input><?php //echo CHtml::textArea('keterangan','', array('class'=>'span2 ', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?><br>\n\</td>\n\
                        </tr>\n\
                        <tr>\n\
                            <td style="text-align: right; vertical-align: top;">Keterangan : </td>\n\
                            <td><textarea id ="keterangan' + no_img + '" class="span3" onkeypress="return $(this).focusNextInputField(event);"></textarea><?php //echo CHtml::textArea('keterangan','', array('class'=>'span2 ', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?><br>\n\</td>\n\
                        </tr>\n\
                        <tr>\n\
                            <td style="text-align: right; vertical-align: top;"></td>\n\
                            <td style="text-align: left;"><input type="radio" id="periksa_regular" name="periksa_tipe" value="Reguler" />Reguler &nbsp; <input type="radio" id="periksa_iregular" name="periksa_tipe" value="Ireguler" /> Ireguler<br>\n\</td>\n\
                        </tr><tr><td>&nbsp;</td></tr>\n\
                    </table>\n\
                        <input img-no="' + no_img + '" type="button" name="btnsave" value="Tambah" id="btnsave' + no_img + '" />\n\
                        <input img-no="' + no_img + '" type="button" name="btncancel" value="Cancel" id="btncancel' + no_img + '" /><br><br>\n\
                    </div>\n\
                </div>';

                        //$( '#tagit'+no_img ).remove( ); // remove any tagit div first
                        $('[id^=tagit]').remove(); // menghapus titik lain selain titik current klik
                        $(imgtag).append(html);
                        $('#tagit' + no_img).css({top: mouseY, left: mouseX});
                        $("#bagiantubuh_id").val(data.bagiantubuh_id);
                        $('#tagname' + no_img).focus();

                        mouseY = mouseY.toFixed(7);
                        mouseX = mouseX.toFixed(7);
                        $('#bagiantubuh_id' + no_img).val(data.bagiantubuh_id);

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }

        });

        $(document).on('click', '[id^=tagit] [id^=btnsave]', function () {
            var no_img = $(this).attr('img-no');
            var bagiantubuh_id = $('#bagiantubuh_id' + no_img).val();
            var lebar = $("#lebar" + no_img).val();
            var rotasi = $("#rotasi" + no_img).val();
            var keterangan = $('#keterangan' + no_img).val();
            var gambartubuh_id = $('#gambartubuh_id' + no_img).val();
            var img = $('#imgtag' + no_img).find('img');
            var id = $(img).attr('id');
            var reguler = $("input[name='periksa_tipe']:checked").val();
            //var koorX = $( img ).attr( 'mousex' );
            //var koorY = $( img ).attr( 'mousey' );
            $.ajax({
                type: "POST",
                url: "<?php echo $this->createUrl('tambahBagianTubuh') ?>",
                data: {
                    pic_id: id,
                    bagiantubuh_id: bagiantubuh_id,
                    gambartubuh_id: gambartubuh_id,
                    lebar: lebar,
                    rotasi: rotasi,
                    pic_x: mouseX,
                    pic_y: mouseY,
                    keterangan: keterangan,
                    type: "insert",
                    reguler: reguler,
                },
                dataType: "json",
                success: function (data) {
                    if (data.pesan != "") {
                        myAlert(data.pesan);
                    } else {
                        $('#table-bagtubuh > tbody').append(data.form);
                        renameInput($('#table-bagtubuh'));
                        titikSebelumSimpan(data.axis['x'], data.axis['y'], data.axis['lebar'], data.axis['rotasi'], data.bagiantubuh_id, '#imgtag' + no_img);
                    }
//          viewtag( id );
                    $('#tagit' + no_img).fadeOut();
                    $('#titikklik' + no_img).remove();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });

        });

        // Cancel the tag box.
        $(document).on('click', '[id^=tagit] [id^=btncancel]', function () {
            var no_img = $(this).attr('img-no');
            $('#tagit' + no_img).fadeOut();
            $('#titikklik' + no_img).remove();
        });

        // mouseover the taglist 
        $('#taglist').on('mouseover', 'li', function ( ) {
            id = $(this).attr("id");
            $('#view_' + id).css({opacity: 1.0});
        }).on('mouseout', 'li', function ( ) {
            $('#view_' + id).css({opacity: 0.0});
        });

        // mouseover the tagboxes that is already there but opacity is 0.
        $('#tagbox').on('mouseover', '.tagview', function ( ) {
            var pos = $(this).position();
            $(this).css({opacity: 1.0}); // div appears when opacity is set to 1.
        }).on('mouseout', '.tagview', function ( ) {
            $(this).css({opacity: 0.0}); // hide the div by setting opacity to 0.
        });

        // Remove tags.
        $('#taglist').on('click', '.remove', function () {
            id = $(this).parent().attr("id");
            // Remove the tag
            $.ajax({
                type: "POST",
                url: "savetag.php",
                data: "tag_id=" + id + "&type=remove",
                success: function (data) {
                    var img = $('#imgtag').find('img');
                    var id = $(img).attr('id');
                    //get tags if present
                    viewtag(id);
                }
            });
        });

        // load the tags for the image when page loads.
        var img = $('#imgtag').find('img');
        var id = $(img).attr('id');

    });
    
    function transformTitik(no_img) {
        var lebar = parseFloat($("#lebar" + no_img).val()) / 10;
        var rotasi = parseFloat($("#rotasi" + no_img).val());
        
        $("#titikklik" + no_img).css("transform", "rotate(" + rotasi + "deg) scaleX(" + lebar + ")");
    }

</script>
