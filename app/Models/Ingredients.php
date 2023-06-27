<?php

namespace Models;

use Base;
use DB\SQL\Mapper;

class Ingredients extends Mapper {
	public function __construct() {
		parent::__construct( \Base::instance()->get('mysql'), 'ingredients');
	}
}
