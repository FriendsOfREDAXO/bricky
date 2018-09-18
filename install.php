<?php

/**
 * This file is part of the Bricky package.
 *
 * @author (c) Friends Of REDAXO
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

\rex_sql_table::get(
    \rex::getTable('bricky_module'))
    ->ensurePrimaryIdColumn()
    ->ensureColumn(new \rex_sql_column('module_name', 'VARCHAR(255)'))
    ->ensureColumn(new \rex_sql_column('module_id', 'INT(11)'))
    ->ensureColumn(new \rex_sql_column('bricks', 'TEXT', true))
    ->ensureColumn(new \rex_sql_column('grids', 'TEXT', true))
    ->ensureColumn(new \rex_sql_column('view', 'ENUM("NORMAL","SLICES")'))
    ->ensureColumn(new \rex_sql_column('createdate', 'DATETIME'))
    ->ensureColumn(new \rex_sql_column('createuser', 'VARCHAR(255)'))
    ->ensureColumn(new \rex_sql_column('updatedate', 'DATETIME'))
    ->ensureColumn(new \rex_sql_column('updateuser', 'VARCHAR(255)'))

    ->ensureIndex(new \rex_sql_index('module', ['module_id'], \rex_sql_index::UNIQUE))
    ->ensure();
