<?php
/** op-unit-dump:/ci/Dump.php
 *
 * @created    2023-02-11
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

//	...
$ci = OP::Unit('CI');

//	_Escape
$result = null;
$args   = [[]];
$ci->Set('_Escape', $result, $args);

//	_Object
$result = null;
$args   = new \stdClass();
$ci->Set('_Object', $result, $args);

//	Mark
$result = "unit:/ci/CI_Client.class.php #ci - \n";
$args   = [];
$ci->Set('Mark', $result, $args);

//	MarkPlain
$result =  "null\ntrue\nfalse\n1\n\"1\"\n";
$args   =  [[null, true, false, 1,'1'],[]];
$ci->Set('MarkPlain', $result, $args);

//	MarkHtml
$args   =  [
	[null],
	[
		'file' => '/var/www/foo/bar.php',
		'line' => 100,
	]
];
$result = '<div class=\'OP_MARK\'>{"file":"\/var\/www\/foo\/bar.php","line":100,"args":[null]}</div>'."\n";
$ci->Set('MarkHtml', $result, $args);

//	_MarkPlain_
/*
$args   =  [
	[null],
	[
		'file' => '/var/www/foo/bar.php',
		'line' => 100,
	]
];
$result = "/var/www/foo/bar.php #100 - null\n";
*/
$args   = [null, null];
$result = 'Notice: This method was deprecated.';
$ci->Set('_MarkPlain_', $result, $args);

//	MarkJS
$args   =  [
	[null],
	[
		'file' => '/var/www/foo/bar.php',
		'line' => 100,
	]
];
$result = 'console.log(JSON.parse(\'{"file":"\/var\/www\/foo\/bar.php","line":100}\'), JSON.parse(\'[null]\'));';
$ci->Set('MarkJS', $result, $args);

//	MarkJson
$is_api = file_exists( OP()->MetaPath('asset:/unit/api/') );
$args   = [null,[]];
$result = $is_api ? NULL: 'Exception: Not installed Unit of API.';
$ci->Set('MarkJson', $result, $args);

//	Template
$path   = '../';
$args   = [$path];
$result = 'Exception: Deny upper directory specification.';
$ci->Set('Template', $result, $args);

//	...
return $ci->GenerateConfig();
