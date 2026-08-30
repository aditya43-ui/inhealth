<?php

/**
 * This is the model class for table "infomohonpenangguhan_v".
 *
 * The followings are the available columns in table 'infomohonpenangguhan_v':
 * @property integer $permohonanpenangguhan_id
 * @property string $tglpermpenangguhan
 * @property string $jnspenangguhan
 * @property double $jumlahpinjaman
 * @property double $kesanggupanbayar
 * @property double $sisapinjaman
 * @property string $ketpenangguhan
 * @property integer $pen_diperiksaoleh
 * @property string $pen_tgldiperiksa
 * @property integer $pen_disetujuioleh
 * @property string $pen_tgldisetujui
 * @property string $nama_pegawai
 * @property string $jeniskelamin
 * @property string $alamat_pegawai
 * @property integer $keanggotaan_id
 * @property string $nokeanggotaan
 * @property integer $pinjaman_id
 * @property string $tglpinjaman
 * @property string $no_pinjaman
 * @property double $jml_pinjaman
 * @property integer $jmlangsuran_id
 * @property integer $angsuran_ke
 * @property string $tglangsuran
 * @property double $jmlpokok_angsuran
 * @property double $jmljasa_angsuran
 * @property double $jmldenda_angsuran
 * @property integer $pembayaranangsuran_id
 * @property string $tglpembayaranangsuran
 * @property integer $pengajuanpembayaran_id
 * @property string $tglpengajuanpemb
 */
class InfomohonpenangguhanV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfomohonpenangguhanV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'infomohonpenangguhan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('permohonanpenangguhan_id, pen_diperiksaoleh, pen_disetujuioleh, keanggotaan_id, pinjaman_id, jmlangsuran_id, angsuran_ke, pembayaranangsuran_id, pengajuanpembayaran_id', 'numerical', 'integerOnly'=>true),
			array('jumlahpinjaman, kesanggupanbayar, sisapinjaman, jml_pinjaman, jmlpokok_angsuran, jmljasa_angsuran, jmldenda_angsuran', 'numerical'),
			array('jnspenangguhan, nama_pegawai, nokeanggotaan, no_pinjaman', 'length', 'max'=>50),
			array('jeniskelamin', 'length', 'max'=>20),
			array('tglpermpenangguhan, ketpenangguhan, pen_tgldiperiksa, pen_tgldisetujui, alamat_pegawai, tglpinjaman, tglangsuran, tglpembayaranangsuran, tglpengajuanpemb', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('permohonanpenangguhan_id, tglpermpenangguhan, jnspenangguhan, jumlahpinjaman, kesanggupanbayar, sisapinjaman, ketpenangguhan, pen_diperiksaoleh, pen_tgldiperiksa, pen_disetujuioleh, pen_tgldisetujui, nama_pegawai, jeniskelamin, alamat_pegawai, keanggotaan_id, nokeanggotaan, pinjaman_id, tglpinjaman, no_pinjaman, jml_pinjaman, jmlangsuran_id, angsuran_ke, tglangsuran, jmlpokok_angsuran, jmljasa_angsuran, jmldenda_angsuran, pembayaranangsuran_id, tglpembayaranangsuran, pengajuanpembayaran_id, tglpengajuanpemb', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'permohonanpenangguhan_id' => 'Permohonanpenangguhan',
			'tglpermpenangguhan' => 'Tanggal Penangguhan',
			'jnspenangguhan' => 'Jenis Penangguhan',
			'jumlahpinjaman' => 'Jumlahpinjaman',
			'kesanggupanbayar' => 'Kesanggupan',
			'sisapinjaman' => 'Sisa Angsuran',
			'ketpenangguhan' => 'Ketpenangguhan',
			'pen_diperiksaoleh' => 'Pen Diperiksaoleh',
			'pen_tgldiperiksa' => 'Pen Tgldiperiksa',
			'pen_disetujuioleh' => 'Pen Disetujuioleh',
			'pen_tgldisetujui' => 'Pen Tgldisetujui',
			'nama_pegawai' => 'Nama Pegawai',
			'jeniskelamin' => 'Jenis Kelamin',
			'alamat_pegawai' => 'Alamat Pegawai',
			'keanggotaan_id' => 'Keanggotaan',
			'nokeanggotaan' => 'No. Anggota',
			'pinjaman_id' => 'Pinjaman',
			'tglpinjaman' => 'Tglpinjaman',
			'no_pinjaman' => 'No Pinjaman',
			'jml_pinjaman' => 'Jumlah Angsuran',
			'jmlangsuran_id' => 'Jmlangsuran',
			'angsuran_ke' => 'Angsuran Ke',
			'tglangsuran' => 'Tglangsuran',
			'jmlpokok_angsuran' => 'Jmlpokok Angsuran',
			'jmljasa_angsuran' => 'Jmljasa Angsuran',
			'jmldenda_angsuran' => 'Jmldenda Angsuran',
			'pembayaranangsuran_id' => 'Pembayaranangsuran',
			'tglpembayaranangsuran' => 'Tglpembayaranangsuran',
			'pengajuanpembayaran_id' => 'Pengajuanpembayaran',
			'tglpengajuanpemb' => 'Tglpengajuanpemb',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('permohonanpenangguhan_id',$this->permohonanpenangguhan_id);
		$criteria->compare('tglpermpenangguhan',$this->tglpermpenangguhan,true);
		$criteria->compare('jnspenangguhan',$this->jnspenangguhan,true);
		$criteria->compare('jumlahpinjaman',$this->jumlahpinjaman);
		$criteria->compare('kesanggupanbayar',$this->kesanggupanbayar);
		$criteria->compare('sisapinjaman',$this->sisapinjaman);
		$criteria->compare('ketpenangguhan',$this->ketpenangguhan,true);
		$criteria->compare('pen_diperiksaoleh',$this->pen_diperiksaoleh);
		$criteria->compare('pen_tgldiperiksa',$this->pen_tgldiperiksa,true);
		$criteria->compare('pen_disetujuioleh',$this->pen_disetujuioleh);
		$criteria->compare('pen_tgldisetujui',$this->pen_tgldisetujui,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('alamat_pegawai',$this->alamat_pegawai,true);
		$criteria->compare('keanggotaan_id',$this->keanggotaan_id);
		$criteria->compare('nokeanggotaan',$this->nokeanggotaan,true);
		$criteria->compare('pinjaman_id',$this->pinjaman_id);
		$criteria->compare('tglpinjaman',$this->tglpinjaman,true);
		$criteria->compare('no_pinjaman',$this->no_pinjaman,true);
		$criteria->compare('jml_pinjaman',$this->jml_pinjaman);
		$criteria->compare('jmlangsuran_id',$this->jmlangsuran_id);
		$criteria->compare('angsuran_ke',$this->angsuran_ke);
		$criteria->compare('tglangsuran',$this->tglangsuran,true);
		$criteria->compare('jmlpokok_angsuran',$this->jmlpokok_angsuran);
		$criteria->compare('jmljasa_angsuran',$this->jmljasa_angsuran);
		$criteria->compare('jmldenda_angsuran',$this->jmldenda_angsuran);
		$criteria->compare('pembayaranangsuran_id',$this->pembayaranangsuran_id);
		$criteria->compare('tglpembayaranangsuran',$this->tglpembayaranangsuran,true);
		$criteria->compare('pengajuanpembayaran_id',$this->pengajuanpembayaran_id);
		$criteria->compare('tglpengajuanpemb',$this->tglpengajuanpemb,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}