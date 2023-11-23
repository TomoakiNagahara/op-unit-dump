<?php
/**
 * unit-dump:/Dump.class.php
 *
 * @created   2018-04-13
 * @version   1.0
 * @package   unit-dump
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @created   2018-04-20
 */
namespace OP\UNIT;

/** Use
 *
 */
use Exception;
use OP\OP;
use OP\OP_CI;
use OP\OP_CORE;
use OP\OP_UNIT;
use OP\IF_UNIT;
use OP\Env;
use function OP\Json;
use function OP\CompressPath;
use function OP\UNIT\Dump\toString;

/** Dump
 *
 * @created   2018-04-13
 * @version   1.0
 * @package   unit-dump
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Dump implements IF_UNIT
{
	/** trait
	 *
	 */
	use OP_CORE, OP_UNIT, OP_CI;

	/** Escape variable.
	 *
	 * @param array &$args
	 */
	static function _Escape(&$args)
	{
		//	...
		if(!is_array($args) ){
			return;
		}

		//	...
		foreach( $args as &$arg ){
			self::_EscapeByType($arg);
		}
	}

	/** Separate for _Object() from _Escape().
	 *
	 * @created   2020-09-06
	 * @param     mixed        &$arg
	 */
	static function _EscapeByType(&$arg)
	{
		switch( $type = gettype($arg) ){
			case 'array':
				self::_Escape($arg);
				break;

			case 'object':
				self::_Object($arg);
				break;

			case 'resource':
				$type = get_resource_type($arg);
				$arg  = "resource(type:$type)";
				break;

			case 'unknown type':
				$arg  = $type;
				break;

			default:
		}
	}

	/** Object to array.
	 *
	 * @created   2020-09-06
	 * @param     array        $arg
	 */
	static function _Object(&$arg)
	{
		//	Get object name.
		$name = get_class($arg);
		$arr["object($name)"] = [];

		//	Foreach property.
		foreach( $arg as $key => $val ){
			self::_EscapeByType($val);
			$arr["object($name)"][$key] = $val;
		}

		//	...
		$arg = $arr;
	}

	/** Mark
	 *
	 */
	static function Mark()
	{
		/**
		 * DEBUG_BACKTRACE_PROVIDE_OBJECT : Provide current object property.
		 * DEBUG_BACKTRACE_IGNORE_ARGS    : Ignore function or method arguments.
		 */
		$trace = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1];

		//	...
		$trace['file'] = OP::CompressPath($trace['file']);

		//	Arguments.
		$args = func_get_args()[0] ?? [];

		//	...
		self::_Escape($args);

		//	...
		switch( Env::Mime() ){
			case 'text/css':
				echo "\n/*\n";
				self::MarkPlain($args, $trace);
				echo "*/\n";
				break;

			case 'text/javascript':
				self::MarkJS($args, $trace);
				break;

			case 'text/json':
			case 'text/jsonp':
				self::MarkJson($args, $trace);
				break;

			case 'text/plain':
			case 'text/shell':
				self::MarkPlain($args, $trace);
				break;

			case 'text/html':
			default:
				//	...
				self::MarkHtml($args, $trace);
			break;
		}
	}

	/** MarkCss
	 *
	 * @param mixed $value
	 * @param array $trace
	 */
	static function MarkPlain($value, $trace)
	{
		//	...
		require_once(__DIR__.'/function/toString.php');

		//	...
		static $_file_len = 0;
		if( $file = $trace['file'] ?? null ){
			$line = $trace['line'] ?? null;

			//	...
			if( $_file_len < strlen($file) ){
				$_file_len = strlen($file);
			}

			//	Padding
		//	$file = str_pad($file, $_file_len, ' ', STR_PAD_RIGHT);
			$line = str_pad($line,          3, ' ', STR_PAD_LEFT);

			//	...
			echo "{$file} #{$line} - ";
		}

		//	...
		if(!is_array($value) ){
			$value = [$value];
		}

		//	...
		foreach( $value as $variable){
			echo toString($variable).PHP_EOL;
		}
	}

	/** MarkHtml
	 *
	 * @param mixed $value
	 * @param array $trace
	 */
	static function MarkHtml($args, $trace)
	{
		//	...
		$later = [];

		//	$mark
		$mark = [];
		$mark['file'] = $trace['file'];
		$mark['line'] = $trace['line'];
		$mark['args'] = [];

		//	$args
		foreach( $args as $value ){
			switch( $type = gettype($value) ){
				case 'array':
					//	Stack
					$later[] = $value;
					//	Look and feel to array.
					$count   = count($value);
					$value   = $type."($count)"; // --> array(1)
					break;

				case 'object':
					$later[] = $value;
					$value   = get_class($value);
					break;
			};

			$mark['args'][] = $value;
		};

		//	...
		Json($mark, 'OP_MARK');

		//	...
		foreach( $later as $value ){
			Json($value, 'OP_DUMP');
		}
	}

	/** _MarkPlain_
	 *
	 * @deprecated 2023-02-26
	 * @param mixed $value
	 * @param array $trace
	 */
	static function _MarkPlain_($value, $trace)
	{
		static $_file_len = 0;

		//	...
		if( $file = $trace['file'] ?? null ){
			$line = $trace['line'] ?? null;

			//	...
			if( $_file_len < strlen($file) ){
				$_file_len = strlen($file);
			}

			//	Padding
			$file = str_pad($file, $_file_len, ' ', STR_PAD_RIGHT);
			$line = str_pad($line,          3, ' ', STR_PAD_LEFT);

			//	...
			echo "{$file} #{$line} - ";
		}

		//	...
		if(!is_array($value) ){
			$value = [$value];
		}

		//	...
		$count = count($value);

		//	...
		if( $count === 0 ){
			//	...
			echo '(empty)';
		}else
		if( $count === 1 ){
			//	...
			$value = $value[0] ?? null;

			//	...
			switch( gettype($value) ){
				case 'NULL':
					$value = 'null';
					break;
				case 'boolean':
					$value = $value ? 'true': 'false';
					break;
				case 'string':
					$value = $value ? str_replace(["\r","\n","\t"], ['\r','\n','\t'], $value): '""';
					break;
			}

			//	...
			print_r($value);
		}else{
			print_r($value);
		};

		//	...
		echo PHP_EOL;
	}

	/** MarkJS
	 *
	 * @param mixed $value
	 * @param array $trace
	 */
	static function MarkJS($value, $trace)
	{
		$value = json_encode($value);
		$trace = json_encode($trace);
		echo "console.log(JSON.parse('{$trace}'), JSON.parse('{$value}'));";
	}

	/** MarkJson
	 *
	 * @param mixed $value
	 * @param array $trace
	 */
	static function MarkJson($value, $trace)
	{
		//	...
		if(!\OP\Unit::isInstall('Api') ){
			throw new Exception("Not installed Unit of API.");
		}

		//	For Eclipse validatiion warning.
		'\OP\UNIT\Api'::Dump(['trace'=>$trace,'value'=>$value]);
	}
}
