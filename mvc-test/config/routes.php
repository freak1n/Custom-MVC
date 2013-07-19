<?php
// Admin
$cnf['admin']['namespace'] = 'Controllers\Admin1';

// Administration
$cnf['administration']['namespace'] = 'Controllers\Admin';
$cnf['administration']['controllers']['index']['to'] = 'Index';
$cnf['administration']['controllers']['index']['methods']['new'] = '_new';

$cnf['administration']['controllers']['new']['to'] = 'create';

// Defaults
$cnf['*']['namespace'] = 'Controllers';

return $cnf; 