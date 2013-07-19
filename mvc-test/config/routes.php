<?php
// Admin
$cnf['admin']['namespace'] = 'Controllers\Admin1';

// Administration
$cnf['administration']['namespace'] = 'Controllers\Admin2';
$cnf['administration']['controllers']['index'] = 'test';
$cnf['administration']['controllers']['new'] = 'create';

// Defaults
$cnf['*']['namespace'] = 'Controllers';

return $cnf;