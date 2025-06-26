<?php
/**	op-unit-dump:/include/mark_css.php
 *
 * @deprecated 2023-02-25
 * @created    2022-10-23
 * @version    1.0
 * @package    op-unit-dump
 * @author     Tomoaki Nagahara
 * @copyright  Tomoaki Nagahara All right reserved.
 */

/**	Declare strict
 *
 */
declare(strict_types=1);

/**	namespace
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

		case 'array':
			$value = serialize($value);
			break;

		default:
			$value = __FILE__.' #'.__LINE__." This type is undefined. ($type)";
	}

	//	...
	echo $value;
}

//	finish
echo ')'.PHP_EOL;
