<?php
$mandatory = !empty($mandatory) ? $mandatory : true;
if ($mandatory == true) {
?>
    <span class="required"><i>Bagian dengan tanda * harus diisi.</i></span>
<?php
}
?>
<table style="width: 100%; border: none;">
    <?php
    $total = ceil(count((array)$tips) / 2);
    $petunjuk = Tips::getTips();
    //  var_dump($tips);die;
    $a = 1;
    for ($i = 0; $i < count((array)$tips); $i++) {

        if ($tips[$i] == 'bootaccordion') {
            echo "<tr><td style = 'padding:10px;width:10px;vertical-align:middle'>" . $a . "</td><td style = 'vertical-align:middle'>";
            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'tips-accordition',
                'content' => array(
                    'content-tips' => array(
                        'header' => '<b>Judul Header</b>',
                        'isi' => 'Data',
                        'active' => false,
                    ),
                ),
            ));
            echo "<br> berfungsi untuk menampilkan data, jika header di klik. </td></tr>";
        } else {
            echo '<tr><td style = "padding:10px;width:10px;vertical-align:middle">' . $a . '</td><td style = "vertical-align:middle;">' . $petunjuk[$tips[$i]] . '<td></tr>';
        }
        $a++;
    }
    ?>
</table>