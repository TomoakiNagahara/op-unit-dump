op-unit-dump is part of op-core
===

 1. The "Dump" class can not be used by itself.
 2. Dump the variable passed to the "D" function.
 3. The "dump" class display the variable to easy readable.
 4. The display method changes depending on the MIME.

# Usage

```php
<?php
//	...
namespace OP;

//	Set admin IP-Address. (Localhost is always admin.)
Env::Set( Env::_ADMIN_IP_, '192.168.0.1' );

//	Visible only to admin. The criterion is the IP address.
D($_SESSION);
```

# How to read the variable

 * Strings are displayed in plain text. But in case of empty, add quote: `""`.
 * Integer are displayed in italic text. If string number case is add quote: `"123"`
 * Space characters are displayed with a grayed out underscore: `This_is_a_pen`
 * Control characters are displayed as metacharacters: `CR\rTAB\t`

# Technical information

 1. Pass the variable you want to display on the screen to the D function.
 2. The D function checks if you are the admin.
 3. If you are not admin, does not display anything.
 4. If you are an admin, takes over to OP\UNIT\Dump.
 5. Dump unit is convert to JSON and out that.
 6. The screen shows JSON, but it do table layouted by JavaScript.
