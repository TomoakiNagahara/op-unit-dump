<?php
/** op-unit-dump:/include/mark_css.php
 *
 * @created    2022-10-23
 * @version    1.0
 * @package    op-unit-dump
 * @author     Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright  Tomoaki Nagahara All right reserved.
 */

/** Declare strict
 *
 */
declare(strict_types=1);

/** namespace
 *
 */
namespace OP;

/* @var $value mixed */
/* @var $trace mixed */

//	start
echo PHP_EOL.'D(';

//	...
if( is_array($value) ){
	$values = $value;
}else{
	$values = [$value];
}

//	...
foreach( $values as $value ){
	switch( $type = strtolower(gettype($value)) ){
		case 'null':
			$value = 'null';
			break;

		case 'boolean':
			$value = $value ? 'true':'false';
			break;

		case 'string':
			$value = '"'.$value.'"';
			break;

		case 'object':
			$value = get_class($value);
			break;

		default:
			$value = __FILE__.' #'.__LINE__.' undefined type is '.$type;
	}

	//	...
	echo $value;
}

//	finish
echo ')'.PHP_EOL;
