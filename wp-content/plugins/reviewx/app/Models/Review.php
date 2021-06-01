<?php

namespace ReviewX\Models;

use ReviewX\Models\Abstracts\AbstractModel;
use WpFluent\Exception;

class Review extends AbstractModel
{
	protected $primaryKey = 'comment_ID';

	private static $POST_TYPE = 'product';

	private static $COMMENT_TYPE = 'review';

	protected function setBaseScope($builder)
	{
		$builder = $builder->where('comment_type',self::$COMMENT_TYPE);
		parent::setBaseScope($builder);
	}

	public function setTable()
	{
		return 'comments';
	}

	public static function postType()
	{
		return self::$POST_TYPE;
	}

	public static function commentType()
	{
		return self::$COMMENT_TYPE;
	}
}