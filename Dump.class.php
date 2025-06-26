<?php
/**	op-unit-dump:/Dump.class.php
 *
 * @created   2018-04-13
 * @author    Tomoaki Nagahara
 * @copyright Tomoaki Nagahara All right reserved.
 */

/**	Declare strict
 *
 */
declare(strict_types=1);

/**	namespace
 *
 */
namespace OP\UNIT;

/**	Use
 *
 */
use Exception;
use OP\OP;
use OP\OP_CI;
use OP\OP_CORE;
use OP\Env;
use OP\IF_DUMP;
use function OP\Json;
use function OP\CompressPath;
use function OP\UNIT\Dump\toString;

/**	Dump
 *
 * @created   2018-04-13
 * @version   1.0
 * @package   op-unit-dump
 * @author    Tomoaki Nagahara
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Dump implements IF_DUMP
{
	/**	trait
	 *
	 */
	use OP_CORE, OP_CI;

	/**	Escape variable.
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

	/**	Separate for _Object() from _Escape().
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

	/**	Object to array.
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

	/**	Mark
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
		$mime = strtolower(Env::Mime());

		//	...
		if( strpos($mime, 'text/') === false ){
			//	Not text
			return;
		}

		//	...
		switch( $mime ){
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

	/**	MarkCss
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
			$line = $trace['line'] ?? '';
			if( $line ){
				$line = (string)$line;
			}

			//	...
			if( $_file_len < strlen($file) ){
				$_file_len = strlen($file);
			}

			//	For CI
			if( OP()->isCI() ){
				//	If called from CI_Client
				if( $file === 'unit:/ci/CI_Client.class.php' ){
					//	For CI of Dump.
					$line = 'ci';
				}
			}else{
			//	Padding
			$file = str_pad($file, $_file_len, ' ', STR_PAD_RIGHT);
			$line = str_pad($line,          3, ' ', STR_PAD_LEFT);
			}

			//	...
			echo "{$file} #{$line} - ";
		}

		//	...
		if( empty($value) ){
			echo PHP_EOL;
			return;
		}

		//	...
		if(!is_array($value) ){
			$value = [$value];
			/*
			echo toString($value).PHP_EOL;
			return;
			*/
		}

		//	...
		foreach( $value as $variable){
			echo toString($variable).PHP_EOL;
		}

		//	...
		if( empty($value) ){
			echo PHP_EOL;
		}
	}

	/**	MarkHtml
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

	/**	MarkJS
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

	/**	MarkJson
	 *
	 * @param mixed $value
	 * @param array $trace
	 */
	static function MarkJson($value, $trace)
	{
		//	...
		if(!\OP\Unit::isInstalled('Api') ){
			throw new Exception("Not installed Unit of API.");
		}

		//	For Eclipse validation warning.
		'\OP\UNIT\Api'::Dump(['trace'=>$trace,'value'=>$value]);
	}
}
