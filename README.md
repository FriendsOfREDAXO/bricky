# Bricky
Noch geheim … stimmt das noch @olien ?

Module die Bricky nutzen, werden über Bricky selbst verwaltet.
Das REDAXO-Modul wird automatisch erstellt und wird mit den sogenannten Bricks gefüttert.

Das Modul enthält dann solchen PHP-Code 

**Moduleingabe**
```php
<?php

use Bricky\Bricky;

echo Bricky::getModule('REX_MODULE_ID')
    ->setCtypesOrder('REX_VALUE[19]')
    ->setSelectedGrid('REX_VALUE[20]')
    ->getInput();

```

**Modulausgabe**
```php
<?php

use Bricky\Bricky;

echo Bricky::getModule('REX_MODULE_ID')->getOutput(\rex_var::toArray('REX_VALUE[1]'));

```
