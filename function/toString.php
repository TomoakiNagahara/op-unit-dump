<?php
/**	op-unit-dump:/function/toString.php
 *
 * @created    2023-02-25
 * @version    1.0
 * @package    op-unit-dump
 * @author     Tomoaki Nagahara
 * @copyright  Tomoaki Nagahara All right reserved.
 */

/**	namespace
 *
 */
namespace OP\UNIT\Dump;

/**	Variable to text string.
 *
 * @created    2023-02-25
 * @param      mixed
 * @return     string
 */
function toString($variable, $indent=0):string
{
	//	...
	switch( $type = strtolower(gettype($variable)) ){
		case 'null':
			$return = 'null';
			break;
		case 'boolean':
			$return = $variable ? 'true':'false';
			break;
		case 'integer':
			$return = $variable;
			break;
		case 'string':
			$return = '"'.str_replace(["\r","\n","\t"], ['\r','\n','\t'], $variable).'"';
			break;
		case 'object':
			$return = get_class($variable);
			break;
		case 'array':
			$return = fromArray($variable, $indent+1);
			break;
		default:
			$return = "Undefined type. ($type)";
	}

	//	...
	return $return;
}

/**	Array to text string.
 *
 * @created    2023-02-25
 * @param      array       $array
 * @return     string
 */
function fromArray(array $array, $indent):string
{
	//	...
	$pad = str_pad('', $indent*2, ' ');

	//	...
	$return = "[\n";

	//	...
	foreach( $array as $i => $v ){
		$i = OP()->Encode($i);
		$v = toString($v, $indent);
		$return .= "{$pad}{$i} => {$v}\n";
	}

	//	...
	$pad = str_pad('', ($indent-1)*2, ' ');
	$return .= "{$pad}]";

	//	...
	return $return;
}
