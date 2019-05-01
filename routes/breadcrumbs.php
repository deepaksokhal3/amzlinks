<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home');
});

// Home > About
Breadcrumbs::for('campaigns', function ($trail) {
    $trail->parent('home');
    $trail->push('Compaigns', route('campaigns'));
});



