# Bricky



Das Addon liefert das Ultimative-Eierlegende-Wollmilch-Sau-Modul mit der Möglichkeit mehrspaltige Inhalte beliebig zu verwalten!


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

---



## Was Bricky werden / können soll

Brick ist ein Addon um einfach individuelle Module zu erstellen

**Erstellungsseite**

- Name des Moduls
- Auswahl von 1-n des "Bricks"
- Auswahl von 1-n möglichen Raster
- Auswahl von "Normal" / "Slices"
- Evtl. Auswahl von zusätzlichen Funktionen des Moduls (Vergabe von Grid-Klassen oder IDs, MediaManager Typen, Link über die komplette Modulausgabe... was auch immer)

**Modul**

- Auswahl und Nutzung der "Bricks" (wenn "Slice" gewählt. Ansonsten stehen die Bricks untereinander)
- Einstellungsseite für das Raster (und evtl., weitere Funktionen)
- Drag and Drop der einzelen Bricks und der Cols (Tabs)

**Was wird vom Addon geliefert?**

- 2-5 "Beispielbricks" (Fragmente überschreibbar)
- ein Beispielraster (BS4) für die Ausgabe (Fragment überschreibbar)
- eine ausfühlriche Anleitung wie eigene Bricks erstellt werden können bzw. das ausgegebene Raste angepasst werden kann.

**Wie ist ein Brick aktuell aufgebaut?**

- PHP Klasse für die Formulareingabe (Modulinput)
- Fragment: Backend Output (überschreibbar)
- Fragement: Frontend Output (überschreibbar)

---

 Die Beispiele sollen später separat aktiviert werden müssten … direkt dabei sollten die ganz einfachen sein … aber Grid Beispiele, bzw. alles was frontend spezieller wäre sollte separat aktiviert werden.



