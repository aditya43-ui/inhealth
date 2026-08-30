<table id="tabel-lpj" class="table table-bordered table-condensed">
    <tr>
        <thead>
            <th> No. </th>
            <th> Perincian Pembayaran <span class="required"> * </span> </th>
            <th> Keterangan </th>
            <th> Kategori</th>
            <th> Jumlah  <span class="required"> * </span> </th>
            <th> Harga Satuan  <span class="required"> * </span> </th>
            <th> Sub Total </th>
            <th> </th>
        </thead>
    </tr>
    <tbody>
        <?php 
        $modDetail = LpjT::model()->findAllByAttributes(['pengajuankasbon_id' => $model->pengajuankasbon_id]);
        if (empty($modDetail)) {
            $this->renderPartial($this->path_view . 'lpj/row/_row_lpj', ['model' => $model, 'modLPJ' => $modLPJ]); 
        } else {
            foreach ($modDetail as $key => $det){
                $this->renderPartial($this->path_view . 'lpj/row/_row_lpj', ['model' => $model, 'modLPJ' => $det]); 
            }
        }        
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" style="text-align: right;">
                Total
            </td>
            <td>
                <?= $form->textField($model, 'total_lpj', ['class' => 'span3', 'readonly' => true]) ?>
            </td>
            <td> </td>
            <td> </td>
        </tr>
    </tfoot>
</table>