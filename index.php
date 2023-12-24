<?php
/** op-unit-dump:/index.php
 *
 * @creation  2018-04-13
 * @version   1.0
 * @package   op-unit-dump
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** Declare strict
 *
 */
declare(strict_types=1);

/** namespace
 *
 * @creation  2019-02-22
 */
namespace OP;

//	...
if(!Env::isAdmin() ){
	OP::Notice('Not Admin.');
	return;
}

//	...
if( class_exists('\OP\UNIT\Dump') ){
	return;
}

//	...
require_once(__DIR__.'/Dump.class.php');

//	...
//register_shutdown_function(function(){
	//	...
	try{
		/* @var $webpack UNIT\WebPack */
		/*
		//	Only http(s).
		if( Env::isHttp() ){
		$webpack = Unit::Instantiate('WebPack');
		$webpack->Set('js',  [__DIR__.'/mark', __DIR__.'/dump']);
		$webpack->Set('css', [__DIR__.'/mark', __DIR__.'/dump']);
		}
		*/
		OP()->WebPack()->Auto('./webpack/');
		/*
		OP()->WebPack()->Auto('asset:/webpack/css/args.css');
		*/
		/*
		OP()->WebPack()->Auto('asset:/webpack/css/color.css');
		*/

	}catch( \Exception $e ){
		//	...
		echo $e->getMessage();

		//	...
		echo '<script>';
		include(__DIR__.'/mark.js');
		include(__DIR__.'/dump.js');
		include(__DIR__.'/args.js');
		include(__DIR__.'/arg.js' );
		echo '</script>';

		//	...
		echo '<style>';
		include(__DIR__.'/mark.css');
		include(__DIR__.'/dump.css');
		echo '</style>';
	};
//});
