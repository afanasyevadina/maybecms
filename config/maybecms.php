<?php

return [
    'user_model' => 'App\\Models\\User',
    'field_types' => [
        'text',
        'markdown',
        'link',
        'image',
        'video',
    ],
    'primitives' => [
        'section' => [
            'title' => 'Секция',
            'structure' => [],
            'children' => ['*'],
        ],
        'text' => [
            'title' => 'Текст',
            'structure' => [
                [
                    'slug' => 'text',
                    'title' => 'Текст',
                    'field_type' => 'text',
                ],
            ],
        ],
        'markdown' => [
            'title' => 'Markdown',
            'structure' => [
                [
                    'slug' => 'text',
                    'title' => 'Контент',
                    'field_type' => 'markdown',
                ],
            ],
        ],
        'link' => [
            'title' => 'Ссылка',
            'structure' => [
                [
                    'slug' => 'text',
                    'title' => 'Текст ссылки',
                    'field_type' => 'text',
                ],
                [
                    'slug' => 'url',
                    'title' => 'URL ссылки',
                    'field_type' => 'link',
                ],
            ],
        ],
        'image' => [
            'title' => 'Картинка',
            'structure' => [
                [
                    'slug' => 'alt',
                    'title' => 'Альтернативный текст',
                    'field_type' => 'text',
                ],
                [
                    'slug' => 'src',
                    'title' => 'Изображение',
                    'field_type' => 'image',
                ],
            ],
        ],
        'video' => [
            'title' => 'Видео',
            'structure' => [
                [
                    'slug' => 'src',
                    'title' => 'Видео',
                    'field_type' => 'video',
                ],
            ],
        ],
    ],
];
