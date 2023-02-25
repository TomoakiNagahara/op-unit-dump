<?php
/** op-unit-dump:/testcase/d.php
 *
 * @creation  2019-03-08
 * @version   1.0
 * @package   op-unit-dump
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
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

//	...
D('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
