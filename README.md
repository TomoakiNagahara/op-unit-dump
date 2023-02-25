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

//	Do Dump.
D($_SESSION);
```
