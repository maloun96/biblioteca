<?php

Breadcrumbs::for('admin.auth.loan.index', function ($trail) {
	$trail->parent('admin.dashboard');
	$trail->push('Loan', route('admin.auth.loan.index'));
});

Breadcrumbs::for('admin.auth.loan.create', function ($trail) {
	$trail->parent('admin.dashboard');
	$trail->push('Loan', route('admin.auth.loan.index'));
});

Breadcrumbs::for('admin.auth.loan.edit', function ($trail) {
	$trail->parent('admin.dashboard');
	$trail->push('Loan', route('admin.auth.loan.index'));
});
