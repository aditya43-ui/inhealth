<?php
class TanggunganpenjaminM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TanggunganpenjaminM the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tanggunganpenjamin_m';
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('carabayar_id, penjamin_id, kelaspelayanan_id, subsidiasuransitind, subsidipemerintahtind, subsidirumahsakittind, iurbiayatind, subsidiasuransioa, subsidipemerintahoa, subsidirumahsakitoa, iurbiayaoa, persentanggcytopel, makstanggpel', 'required'),
			array('carabayar_id, penjamin_id, kelaspelayanan_id, tipenonpaket_id', 'numerical', 'integerOnly' => true),
			array('subsidiasuransitind, subsidipemerintahtind, subsidirumahsakittind, iurbiayatind, subsidiasuransioa, subsidipemerintahoa, subsidirumahsakitoa, iurbiayaoa, persentanggcytopel, makstanggpel', 'numerical'),
			array('tanggunganpenjamin_aktif', 'safe'),
			array('subsidiasuransitind', 'cekSemua'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tanggunganpenjamin_id, carabayar_id, penjamin_id, kelaspelayanan_id, tipenonpaket_id, subsidiasuransitind, subsidipemerintahtind, subsidirumahsakittind, iurbiayatind, subsidiasuransioa, subsidipemerintahoa, subsidirumahsakitoa, iurbiayaoa, persentanggcytopel, makstanggpel, tanggunganpenjamin_aktif', 'safe', 'on' => 'search'),
		);
	}
	public function cekSemua()
	{
		if (!$this->hasErrors()) {
			$jumlahTindakan = $this->subsidiasuransitind + $this->subsidipemerintahtind + $this->subsidirumahsakittind + $this->iurbiayatind;
			$jumlahOa = $this->subsidiasuransioa + $this->subsidipemerintahoa + $this->subsidirumahsakitoa + $this->iurbiayaoa;
			if ($jumlahTindakan > 100) {
				$this->addError('subsidiasuransitind', 'Jumlah keseluruhan tindakan tidak boleh lebih dari 100');
				$this->addError('subsidipemerintahtind', '');
				$this->addError('subsidirumahsakittind', '');
				$this->addError('iurbiayatind', '');
			}
			if ($jumlahOa > 100) {
				$this->addError('subsidiasuransioa', 'Jumlah keseluruhan tindakan tidak boleh lebih dari 100');
				$this->addError('subsidipemerintahoa', '');
				$this->addError('subsidirumahsakitoa', '');
				$this->addError('iurbiayaoa', '');
			}
			if ($this->persentanggcytopel > 100) {
				$this->addError('persentanggcytopel', 'Jumlah tidak boleh lebih dari 100');
			}
		}
	}
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'carabayar' => array(self::BELONGS_TO, 'CarabayarM', 'carabayar_id'),
			'kelaspelayanan' => array(self::BELONGS_TO, 'KelaspelayananM', 'kelaspelayanan_id'),
			'penjamin' => array(self::BELONGS_TO, 'PenjaminpasienM', 'penjamin_id'),
		);
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tanggunganpenjamin_id' => 'Tanggungan Penjamin',
			'carabayar_id' => 'Jenis Penjamin',
			'penjamin_id' => 'Penjamin',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'tipenonpaket_id' => 'Tipe Non Paket',
			'subsidiasuransitind' => 'Tanggungan Asuransi Tindakan',
			'subsidipemerintahtind' => 'Tanggungan Pemerintah Tindakan',
			'subsidirumahsakittind' => 'Tanggungan Rumah sakit Tindakan',
			'iurbiayatind' => 'Iurbiaya Tindakan',
			'subsidiasuransioa' => 'Tanggungan Asuransi OA',
			'subsidipemerintahoa' => 'Tanggungan Pemerintah OA',
			'subsidirumahsakitoa' => 'Tanggungan Rumah Sakit OA',
			'iurbiayaoa' => 'Iurbiayaoa',
			'persentanggcytopel' => 'Persen Cyto',
			'makstanggpel' => 'Maksimal Tanggungan',
			'tanggunganpenjamin_aktif' => 'Aktif',
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
		$criteria = new CDbCriteria;
		$criteria->compare('tanggunganpenjamin_id', $this->tanggunganpenjamin_id);
		$criteria->compare('carabayar_id', $this->carabayar_id);
		$criteria->compare('penjamin_id', $this->penjamin_id);
		$criteria->compare('kelaspelayanan_id', $this->kelaspelayanan_id);
		$criteria->compare('tipenonpaket_id', $this->tipenonpaket_id);
		$criteria->compare('subsidiasuransitind', $this->subsidiasuransitind);
		$criteria->compare('subsidipemerintahtind', $this->subsidipemerintahtind);
		$criteria->compare('subsidirumahsakittind', $this->subsidirumahsakittind);
		$criteria->compare('iurbiayatind', $this->iurbiayatind);
		$criteria->compare('subsidiasuransioa', $this->subsidiasuransioa);
		$criteria->compare('subsidipemerintahoa', $this->subsidipemerintahoa);
		$criteria->compare('subsidirumahsakitoa', $this->subsidirumahsakitoa);
		$criteria->compare('iurbiayaoa', $this->iurbiayaoa);
		$criteria->compare('persentanggcytopel', $this->persentanggcytopel);
		$criteria->compare('makstanggpel', $this->makstanggpel);
		$criteria->compare('tanggunganpenjamin_aktif', $this->tanggunganpenjamin_aktif);
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria = new CDbCriteria;
		$criteria->compare('tanggunganpenjamin_id', $this->tanggunganpenjamin_id);
		$criteria->compare('carabayar_id', $this->carabayar_id);
		$criteria->compare('penjamin_id', $this->penjamin_id);
		$criteria->compare('kelaspelayanan_id', $this->kelaspelayanan_id);
		$criteria->compare('tipenonpaket_id', $this->tipenonpaket_id);
		$criteria->compare('subsidiasuransitind', $this->subsidiasuransitind);
		$criteria->compare('subsidipemerintahtind', $this->subsidipemerintahtind);
		$criteria->compare('subsidirumahsakittind', $this->subsidirumahsakittind);
		$criteria->compare('iurbiayatind', $this->iurbiayatind);
		$criteria->compare('subsidiasuransioa', $this->subsidiasuransioa);
		$criteria->compare('subsidipemerintahoa', $this->subsidipemerintahoa);
		$criteria->compare('subsidirumahsakitoa', $this->subsidirumahsakitoa);
		$criteria->compare('iurbiayaoa', $this->iurbiayaoa);
		$criteria->compare('persentanggcytopel', $this->persentanggcytopel);
		$criteria->compare('makstanggpel', $this->makstanggpel);
		$criteria->compare('tanggunganpenjamin_aktif', $this->tanggunganpenjamin_aktif);
		// Klo limit lebih kecil dari nol itu berarti ga ada limit 
		$criteria->limit = -1;
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => false,
		));
	}
}
