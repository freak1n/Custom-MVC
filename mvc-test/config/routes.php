<?php
// Admin
$cnf['admin']['namespace'] = 'Controllers\Admin1';

// Administration
$cnf['administration']['namespace'] = 'Controllers\Admin2';
$cnf['administration']['controllers']['index']['to'] = 'test';
$cnf['administration']['controllers']['index']['methods']['new'] = '_new';

$cnf['administration']['controllers']['new']['to'] = 'create';

// Defaults
$cnf['*']['namespace'] = 'Controllers';

return $cnf; 