<?php
/** op-unit-dump:/unit/dump/action.php
 *
 * @creation  2019-03-08
 * @version   1.0
 * @package   op-unit-dump
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/* @var $app    \OP\UNIT\App  */
/* @var $args    array        */
//	...
D( true, false, null, TRUE, FALSE, NULL,
	0, 123, 1.23,
	'String', '123', 'true', 'false', 'null', 'NULL', '', ' ', '  ', " \t,\r,\n  ", '<h1> XSS ',
	[
		0, 1, '100', true, false, null,
		[
			'foo'    => 'bar',
			'null'    => null,
			'boolean' => [true, false],
			'number'  => [0, 1, 0.0, 1.0, -0, -1, 1.1],
			'string'  => [
				'empty'    => '',
				'space'    => ' ',
				'space x2' => '  ',
				'quote'    => '"',
				'single quote' => "'",
				'white space'=>"  \t,\r,\n  ",
				'XSS'=>'<h1> XSS ',
			]
		]
	]
);
