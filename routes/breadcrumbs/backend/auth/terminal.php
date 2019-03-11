<?php

Breadcrumbs::for('admin.auth.terminal.index', function ($trail) {
	$trail->parent('admin.dashboard');
	$trail->push(__('labels.backend.access.terminal.management'), route('admin.auth.user.index'));
});

Breadcrumbs::for('admin.auth.terminal.create', function ($trail) {
	$trail->parent('admin.dashboard');
	$trail->push(__('labels.backend.access.terminal.management'), route('admin.auth.terminal.index'));
});

Breadcrumbs::for('admin.auth.terminal.edit', function ($trail) {
	$trail->parent('admin.dashboard');
	$trail->push(__('labels.backend.access.terminal.management'), route('admin.auth.terminal.index'));
});
