<?php

namespace ReviewX\Models\Abstracts;

use WpFluent\Exception;

abstract class AbstractModel
{
	private $table;

	private $builder;

	protected $primaryKey = 'id';

	public abstract function setTable();

	public function __construct()
	{
		try {
			$this->table = $this->setTable();

			$this->builder = wpFluent()->table($this->table);

			$this->setBaseScope($this->builder);

		} catch (Exception $e) {
		}
	}

	protected function setBaseScope($builder)
	{
	}

	public function find($id)
	{
		return $this->builder->where($this->primaryKey,$id)->first();
	}

	public function where($condition,$operator,$value)
	{
		return $this->builder->where($condition,$operator,$value);
	}

	public function get()
	{
		return $this->builder->get();
	}

	public function first()
	{
		return $this->builder->first();
	}
}