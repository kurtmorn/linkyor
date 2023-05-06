<?php
/**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
 */

return [
    'name' => env('APP_NAME', 'PlanetRune'),
    'logo' => '/images/logos/bh_small.png',
    'icon' => '/images/logos/bh_icon.png',
    'theme_color' => '#00A9fe',

    'route_domains' => [
        'main_site' => 'www.planetrune.com',
        'admin_site' => 'panel.planetrune.com'
    ],

    'storage_url' => 'http://cdn.planetrune.com',
    'discord_url' => 'https://discord.gg/planetrune',

    'system_user_id' => 1,
    'event_enabled' => false,
    'news_topic_id' => 1,
    'rules_thread_id' => null,
    'saint_item_id' => 10,

    'username_change_price' => 250,
    'clan_creation_price' => 25,

    'flood_time' => 5,
    'forum_age_requirement' => 0,
    'message_age_requirement' => 0,

    'renderer' => [
        'url' => 'http://renderer.planetrune.com',
        'key' => 'key',
        'default_filename' => 'user'
    ],

    'admin_panel_code' => '',
    'auth_code' => '298w2w2w2wygvsbnjisu26s2sty2s2hst2s',
    'maintenance_passwords' => [
        'newmaintenancekeygetfucked'
    ]
];
