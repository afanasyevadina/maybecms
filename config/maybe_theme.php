<?php
return [
    'primitives' => [
        'section' => [
            'title' => 'Секция',
            'structure' => [
                [
                    'slug' => 'background',
                    'title' => 'Фон',
                    'field_type' => 'select',
                    'options' => [
                        'bg-light' => 'Светлый',
                        'bg-dark' => 'Темный',
                        'bg-blue' => 'Голубой',
                    ]
                ],
                [
                    'slug' => 'width',
                    'title' => 'Ширина',
                    'field_type' => 'select',
                    'options' => [
                        'w-auto' => 'Авто',
                        'w-25' => '25%',
                        'w-50' => '50%',
                        'w-75' => '75%',
                        'w-100' => '100%',
                    ]
                ],
                [
                    'slug' => 'display',
                    'title' => 'Отображение контента',
                    'field_type' => 'select',
                    'options' => [
                        'd-block' => 'Столбцом',
                        'd-flex' => 'Строкой',
                    ]
                ],
            ],
            'children' => ['*'],
        ],
        'heading' => [
            'title' => 'Заголовок',
            'structure' => [
                [
                    'slug' => 'text',
                    'title' => 'Текст',
                    'field_type' => 'text',
                ],
                [
                    'slug' => 'level',
                    'title' => 'Текст',
                    'field_type' => 'select',
                    'options' => [
                        'h1' => 'h1',
                        'h2' => 'h2',
                        'h3' => 'h3',
                        'h4' => 'h4',
                        'h5' => 'h5',
                        'h6' => 'h6',
                    ],
                ],
            ],
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
        'delimeter' => [
            'title' => 'Разделитель',
            'structure' => [],
        ],
    ],
];
