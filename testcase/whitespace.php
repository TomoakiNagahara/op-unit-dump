<?php
/** op-unit-dump:/testcase/whitespace.php
 *
 * @creation  2024-01-06
 * @version   1.0
 * @package   op-unit-dump
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

//	...
$array = [
	'x1' => ' ',
	'x2' => '  ',
	'x3' => '   ',
];

//	...
echo json_encode($array);

?>
<p data-translate="true" data-lang="en">PHP's json_encode() function is combines consecutive the space.</p>
