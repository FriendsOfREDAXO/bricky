# Bricky
Noch geheim

**Moduleingabe**
```php
<?php

use Bricky\Bricky;

echo Bricky::getInstance()->getInput(1);

```

**Modulausgabe**
```php
<?php

use Bricky\Bricky;

echo Bricky::getInstance()->getBackendOutput(\rex_var::toArray('REX_VALUE[1]'));

```
