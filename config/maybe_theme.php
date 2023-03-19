<?php
return [
    'primitives' => [
        'navbar' => [
            'title' => 'Шапка',
            'structure' => [
                [
                    'slug' => 'logo',
                    'title' => 'Логотип',
                    'field_type' => 'image',
                ],
                [
                    'slug' => 'text',
                    'title' => 'Заголовок',
                    'field_type' => 'single-line-text',
                ],
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
            ],
            'children' => ['navbar-nav'],
            'root' => true,
        ],
        'navbar-nav' => [
            'title' => 'Меню в шапке',
            'structure' => [],
            'children' => ['text', 'link'],
        ],
        'section' => [
            'title' => 'Секция',
            'structure' => [
                [
                    'slug' => 'background',
                    'title' => 'Фон',
                    'field_type' => 'select',
                    'options' => [
                        'bg-white' => 'Белый',
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
                        'w-100' => '100%',
                        'w-75' => '75%',
                        'w-50' => '50%',
                        'w-33' => '33%',
                        'w-25' => '25%',
                        'w-auto' => 'Авто',
                    ]
                ],
                [
                    'slug' => 'display',
                    'title' => 'Отображение контента',
                    'field_type' => 'select',
                    'options' => [
                        'd-column' => 'Столбцом',
                        'd-row' => 'Строкой',
                    ]
                ],
                [
                    'slug' => 'align-v',
                    'title' => 'Вертикальное выравнивание',
                    'field_type' => 'select',
                    'options' => [
                        'align-v-center' => 'По центру',
                        'align-v-top' => 'Прибить к верху',
                        'align-v-bottom' => 'Прибить к низу',
                        'align-v-stretch' => 'Растянуть',
                    ]
                ],
                [
                    'slug' => 'align-h',
                    'title' => 'Горизонтальное выравнивание',
                    'field_type' => 'select',
                    'options' => [
                        'align-h-center' => 'По центру',
                        'align-h-left' => 'Прибить влево',
                        'align-h-right' => 'Прибить вправо',
                        'align-h-between' => 'Распределить к краям',
                        'align-h-around' => 'Распределить равномерно',
                    ]
                ],
                [
                    'slug' => 'css',
                    'title' => 'Свой стиль',
                    'field_type' => 'text',
                ],
            ],
            'children' => ['text', 'markdown', 'link', 'image', 'video', 'heading', 'delimeter', 'section', 'preset'],
            'root' => true,
            'source' => true,
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
                    'field_type' => 'single-line-text',
                ],
                [
                    'slug' => 'url',
                    'title' => 'URL ссылки',
                    'field_type' => 'link',
                ],
                [
                    'slug' => 'style',
                    'title' => 'Стиль ссылки',
                    'field_type' => 'select',
                    'options' => [
                        'link' => 'Ссылка',
                        'button' => 'Кнопка',
                    ],
                ],
            ],
        ],
        'image' => [
            'title' => 'Картинка',
            'structure' => [
                [
                    'slug' => 'alt',
                    'title' => 'Альтернативный текст',
                    'field_type' => 'single-line-text',
                ],
                [
                    'slug' => 'src',
                    'title' => 'Изображение',
                    'field_type' => 'image',
                ],
                [
                    'slug' => 'shape',
                    'title' => 'Форма',
                    'field_type' => 'select',
                    'options' => [
                        'shape-normal' => 'Обычная',
                        'shape-rounded' => 'Скругленные углы',
                        'shape-circle' => 'Круглая',
                        'shape-scale' => '1/2',
                    ],
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
            'root' => true,
        ],
    ],
];
