
/** op-unit-dump:/args.js
 *
 * @created    ????
 * @version    1.0
 * @package    op-unit-dump
 * @author     Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright  Tomoaki Nagahara All right reserved.
 */

//	...
if( $OP === undefined ){
	$OP = {};
};

//...
if( $OP.Args === undefined ){
	//	...
	$OP.Args = function(args){
		//	...
		var spans = document.createElement('span');
			spans.classList.add('args');

		//	...
		if( args === undefined ){
			return spans;
		};

		//	...
		for(var arg of args){
			//	...
			var span = document.createElement('span');
				span.classList.add('arg');

			//	...
			span.appendChild( $OP.Arg(arg) );
			spans.appendChild( span );
		};

		//	...
		return spans;
	};
};
