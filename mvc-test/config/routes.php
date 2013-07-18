<?php
// Admin
$cnf['admin']['namespace'] = 'Controllers\Admin';

// Administration
$cnf['administration']['namespace'] = 'Controllers\Admin';
$cnf['administration']['controllers']['index'] = 'test';
$cnf['administration']['controllers']['new'] = 'create';

// Defaults
$cnf['*']['namespace'] = 'Controllers';

return $cnf;