<?php

require_once __DIR__ . '/../common/header.php';

$show = $data['show'] ?? [];
$poster = $data['poster'] ?? null;
$schedules = $data['schedules'] ?? [];
$reviews = $data['reviews'] ?? [];
$ratingData = $data['ratingData'] ?? [];
$isAdmin = false;

require __DIR__ . '/../common/show_details_body.php';

require_once __DIR__ . '/../common/footer.php';
