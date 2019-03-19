<?php

Breadcrumbs::for('admin.auth.book.index', function ($trail) {
	$trail->parent('admin.dashboard');
	$trail->push('Book', route('admin.auth.book.index'));
});

Breadcrumbs::for('admin.auth.book.create', function ($trail) {
	$trail->parent('admin.dashboard');
	$trail->push('Book', route('admin.auth.book.index'));
});

Breadcrumbs::for('admin.auth.book.edit', function ($trail) {
	$trail->parent('admin.dashboard');
	$trail->push('Book', route('admin.auth.book.index'));
});
