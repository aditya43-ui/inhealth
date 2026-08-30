<?php

class RIAsesmenkebutuhanEdukasiT extends AsesmenkebutuhanEdukasiT
{
	public $kesediaanmenerimaedukasi_alasantidak_neonatus, $ispenerimaedukasi_keluargapasien_neonatus, $penerimaedukasi_namakeluargapasien_neonatus, $ispenerimaedukasi_lainnya_neonatus, $penerimaedukasi_lainnyanama_neonatus;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
