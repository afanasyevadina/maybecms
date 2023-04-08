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
                [
                    'slug' => 'css',
                    'title' => 'Свой стиль',
                    'field_type' => 'text',
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
                [
                    'slug' => 'css',
                    'title' => 'Свой стиль',
                    'field_type' => 'text',
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
                [
                    'slug' => 'css',
                    'title' => 'Свой стиль',
                    'field_type' => 'text',
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
                    'slug' => 'rounds',
                    'title' => 'Скругление',
                    'field_type' => 'select',
                    'options' => [
                        'rounds-0' => 'Обычная',
                        'rounds-rounded' => 'Скругленные углы',
                        'rounds-circle' => 'Круглая',
                    ],
                ],
                [
                    'slug' => 'css',
                    'title' => 'Свой стиль',
                    'field_type' => 'text',
                ],
                [
                    'slug' => 'css',
                    'title' => 'Свой стиль',
                    'field_type' => 'text',
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
                [
                    'slug' => 'css',
                    'title' => 'Свой стиль',
                    'field_type' => 'text',
                ],
            ],
        ],
        'delimeter' => [
            'title' => 'Разделитель',
            'structure' => [
                [
                    'slug' => 'css',
                    'title' => 'Свой стиль',
                    'field_type' => 'text',
                ],
            ],
            'root' => true,
        ],
    ],
];
