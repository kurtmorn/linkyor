<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@include('web.error.index', [
    'title' => 'Not Authorized',
    'description' => 'You do not have the necessary access to view this page',
    'code' => 403
])
