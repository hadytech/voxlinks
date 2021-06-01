<?php

namespace ReviewX\Models;

use ReviewX\Models\Abstracts\AbstractModel;
use WpFluent\Exception;

class ReviewMeta extends AbstractModel
{

	public function setTable()
	{
		return 'commentsmeta';
	}
}