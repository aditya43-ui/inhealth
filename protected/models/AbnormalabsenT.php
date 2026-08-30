<?php

/**
 * This is the model class for table "abnormalabsen_t".
 *
 * The followings are the available columns in table 'abnormalabsen_t':
 * @property integer $abnormalabsen_id
 * @property integer $pegawai_id
 * @property string $tglpengajuan
 * @property string $tglabnormalabsen
 * @property string $jammasuk
 * @property string $jamkeluar
 * @property string $alasan
 * @property string $keterangan
 * @property integer $pegawaimengetahui_id
 * @property string $tglmengetahui
 * @property integer $pegawaimenyetujui_id
 * @property string $tglmenyetujui
 * @property string $statuspersetujuan
 */
class AbnormalabsenT extends CActiveRecord
{
	public $nama_pegawai, $nama_unitkerja, $pegawaimengetahui_nama, $pegawaimenyetujui_nama;
	public $tgl_awal, $tgl_akhir, $tglpersensi_awal, $tglpersensi_akhir, $ceklis, $nomorindukpegawai;


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'abnormalabsen_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, pegawaimengetahui_id, pegawaimenyetujui_id', 'numerical', 'integerOnly'=>true),
			array('alasan, statuspersetujuan', 'length', 'max'=>50),
			array('keterangan', 'length', 'max'=>200),
			array('tglpengajuan, tglabnormalabsen, jammasuk, jamkeluar, tglmengetahui, tglmenyetujui', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('abnormalabsen_id, pegawai_id, tglpengajuan, tglabnormalabsen, jammasuk, jamkeluar, alasan, keterangan, pegawaimengetahui_id, tglmengetahui, pegawaimenyetujui_id, tglmenyetujui, statuspersetujuan', 'safe', 'on'=>'search'),
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
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'pegawaimengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaimengetahui_id'),
			'pegawaimenyetujui' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaimenyetujui_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'abnormalabsen_id' => 'Abnormalabsen',
			'pegawai_id' => 'Pegawai',
			'tglpengajuan' => 'Tglpengajuan',
			'tglabnormalabsen' => 'Tglabnormalabsen',
			'jammasuk' => 'Jammasuk',
			'jamkeluar' => 'Jamkeluar',
			'alasan' => 'Alasan',
			'keterangan' => 'Keterangan',
			'pegawaimengetahui_id' => 'Mengetahui',
			'tglmengetahui' => 'Tglmengetahui',
			'pegawaimenyetujui_id' => 'Menyetujui',
			'tglmenyetujui' => 'Tglmenyetujui',
			'statuspersetujuan' => 'Statuspersetujuan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('abnormalabsen_id',$this->abnormalabsen_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('tglpengajuan',$this->tglpengajuan,true);
		$criteria->compare('tglabnormalabsen',$this->tglabnormalabsen,true);
		$criteria->compare('jammasuk',$this->jammasuk,true);
		$criteria->compare('jamkeluar',$this->jamkeluar,true);
		$criteria->compare('alasan',$this->alasan,true);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('pegawaimengetahui_id',$this->pegawaimengetahui_id);
		$criteria->compare('tglmengetahui',$this->tglmengetahui,true);
		$criteria->compare('pegawaimenyetujui_id',$this->pegawaimenyetujui_id);
		$criteria->compare('tglmenyetujui',$this->tglmenyetujui,true);
		$criteria->compare('statuspersetujuan',$this->statuspersetujuan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AbnormalabsenT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchInformasi()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select = "t.abnormalabsen_id, t.pegawai_id, t.tglpengajuan, pegawai_m.nomorindukpegawai, t.tglabnormalabsen, t.jammasuk, t.jamkeluar, t.alasan, t.keterangan, t.pegawaimengetahui_id, t.tglmengetahui, t.pegawaimenyetujui_id, t.tglmenyetujui, t.statuspersetujuan";
		$criteria->join = "join pegawai_m on pegawai_m.pegawai_id = t.pegawai_id 
							left join unitkerja_m on unitkerja_m.unitkerja_id = pegawai_m.unitkerja_id";
		
		$criteria->addBetweenCondition('DATE(t.tglpengajuan)', $this->tgl_awal, $this->tgl_akhir);

		if($this->ceklis){
			$criteria->addBetweenCondition('DATE(t.tglabnormalabsen)', $this->tglpersensi_awal, $this->tglpersensi_akhir);
		}
		
		$criteria->compare('LOWER(pegawai_m.nomorindukpegawai)', strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(pegawai_m.nama_pegawai)', strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(unitkerja_m.namaunitkerja)', strtolower($this->nama_unitkerja),true);
		$criteria->compare('LOWER(t.statuspersetujuan)', strtolower($this->statuspersetujuan));

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
