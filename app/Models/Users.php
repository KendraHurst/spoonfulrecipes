<?php

namespace Models;

use Base;
use DB\SQL\Mapper;

class Users extends Mapper {
	public function __construct() {
		parent::__construct( \Base::instance()->get('mysql'), 'users');
	}
}

