<?php

// Home
Breadcrumbs::for('admin.dashboard', function ($trail) {
    // $trail->parent('admin');
    $trail->push('Dashboard', route('admin.dashboard'));
});

// Home > About
Breadcrumbs::for('admin.profile', function ($trail) {
    // $trail->parent('admin');
    $trail->push('Profile', route('admin.profile'));
});

Breadcrumbs::for('admin.users', function ($trail) {
    // $trail->parent('admin');
    $trail->push('Users', route('admin.users'));
});
// Home > Blog
Breadcrumbs::for('admin.role', function ($trail) {
    // $trail->parent('home');
    $trail->push('Role', route('admin.role'));
});

// Home > Blog > [Category]
Breadcrumbs::for('admin.permissions', function ($trail) {
    // $trail->parent('blog');
    $trail->push('Permissions', route('admin.permissions'));
});
Breadcrumbs::for('admin.category', function ($trail) {
    // $trail->parent('blog');
    $trail->push('Category', route('admin.category'));
});
Breadcrumbs::for('admin.tag', function ($trail) {
    // $trail->parent('blog');
    $trail->push('Tag', route('admin.tag'));
});
Breadcrumbs::for('admin.article', function ($trail) {
    // $trail->parent('blog');
    $trail->push('Post', route('admin.article'));
});
// Home > Blog > [Category] > [Post]
Breadcrumbs::for('admin.createArticle', function ($trail) {
    $trail->parent('admin.article');
    $trail->push('Create', route('admin.createArticle'));
});