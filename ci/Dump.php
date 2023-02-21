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
$result = "unit:/ci/CI.class.php #304 - null\n";
$args   =  null;
$ci->Set('Mark', $result, $args);

//	MarkCss
$result =  "\n/*\nD(null)\n*/\n";
$args   =  [null, []];
$ci->Set('MarkCss', $result, $args);

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

//	MarkPlain
$args   =  [
	[null],
	[
		'file' => '/var/www/foo/bar.php',
		'line' => 100,
	]
];
$result = "/var/www/foo/bar.php  #100 - null\n";
$ci->Set('MarkPlain', $result, $args);

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
$args   = [null,[]];
$result = 'Exception: Not installed Unit of API.';
$ci->Set('MarkJson', $result, $args);

//	Template
$path   = '../';
$args   = [$path];
$result = 'Exception: Deny upper directory specification.';
$ci->Set('Template', $result, $args);

//	...
return $ci->GenerateConfig();
