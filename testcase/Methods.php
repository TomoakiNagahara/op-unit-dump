<?php
/**	op-unit-dump:/testcase/Methods.php
 *
 * @creation  2023-02-25
 * @version   1.0
 * @package   op-unit-dump
 * @author    Tomoaki Nagahara
 * @copyright Tomoaki Nagahara All right reserved.
 */

/**
 *
 */
namespace OP;

/* @var $dump \OP\UNIT\Dump */
$dump  = OP()->Unit('Dump');
$array = ['str', null, true, ['aaa' => 'bbb',["\r\n\t"]]];

//	...
Html('MIME: text/plain');
echo '<textarea style="min-width: 50vw; height:20em;">';
Env::Mime('text/plain');
D('str', $array);
Env::Mime('text/html');
echo '</textarea>';

//	...
Html('MIME: text/css');
echo '<textarea style="min-width: 50vw; height:20em;">';
Env::Mime('text/css');
D('str', $array);
Env::Mime('text/html');
echo '</textarea>';
