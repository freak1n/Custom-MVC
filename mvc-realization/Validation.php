<?php

namespace php_mvc;

class Validation {
	private $rules = array();
	private $errors = array();

	public function set_rule($rule, $value, $params = null, $name = null)
	{
		$this->rules[] = array('val' => $value, 'rule' => $rule, 'params' => $params, 'name' => $name);
		return $this;
	}

	public function validate()
	{
		$this->errors = array();
		if (count($this->rules > 0)) 
		{
			foreach ($this->rules as $v) 
			{
				if ( ! $this->$v['rule']($v['val'], $v['params'])) 
				{
					if ($v['name']) 
					{
						$this->errors = $v['name'];
					}
					else
					{
						$this->errors[] = $v['rule'];
					}
				}	
			}
		}
		return (bool) ! count($this->errors);
	}

	public function get_errors()
	{
		return $this->errors;
	}

	public function required($val)
	{
		if (is_array($val)) 
			return ! empty($val);
		else
			return $val != '';
	}

	public function __call($a, $b)
	{
		throw new \Exception('Invalid validation rule', 500);
	}

	public static function matches($val1, $val2)
	{
		return $val1 == $val2;
	}

	public static function matches_strict($val1, $val2)
	{
		return $val1 === $val2;
	}

	public static function different($val1, $val2)
	{
		return $val1 != $val2;
	}

	public static function different_strict($val1, $val2)
	{
		return $val1 !== $val2;
	}

	public static function max_length($val, $max_length)
	{
		return (mb_strlen($val) <= $max_length);
	}

	public static function min_length($val, $min_length)
	{
		return (mb_strlen($val) >= $min_length);
	}

	public static function exact_length($val, $exact_length)
	{
		return (mb_strlen($val) == $min_length);
	}

	public static function gt($val1, $val2)
	{
		return ($val1 > $val2);
	}

	public static function lt($val1, $val2)
	{
		return ($val1 < $val2);
	}

	public static function alpha($val)
	{
		return (bool) preg_match('/^([a-z])+$/i', $val);
	}

	public static function alphanum($val)
	{
		return (bool) preg_match('/^([a-z0-9])+$/i', $val);
	}

	public static function alphanumdash($val)
	{
		return (bool) preg_match('/^([a-z0-9_-])+$/i', $val);
	}

	public static function numeric($val)
	{
		return is_numeric($val);	
	}

	public static function email($val)
	{
		return filter_var($val, FILTER_VALIDATE_EMAIL) !== false;
	}

	public static function emails($val)
	{
		if (is_array($val)) 
		{
			foreach ($val as $v) 
			{
				if ( ! self::email($val)) 
				{
					return false;
				}
			}
		}
		else
		{
			return false;
		}
		return true;
	}

	public static function url($val)
	{
		return filter_var($val, FILTER_VALIDATE_URL) !== false;
	}

	public static function ip($val)
	{
		return filter_var($val, FILTER_VALIDATE_IP) !== false;
	}

	public static function regexp($val1, $val2)
	{
		return (bool) preg_match($val2, $val1);
	}

	public static function custom($val1, $val2)
	{
		if ($val2 instanceof \Closure) 
		{
			return (bool) call_user_func($val2, $val1);
		}	
		throw new \Exception("Invalid validation function", 1);
	}
}