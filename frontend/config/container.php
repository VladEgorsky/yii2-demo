<?php
return [
    'definitions' => [
        ymaker\social\share\widgets\SocialShare::class => [
            'configurator' => 'socialShare',
            'description' => false,
            'imageUrl' => false,
            'containerOptions' => ['tag' => 'div', 'class' => 'socials'],
            'linkContainerOptions' => ['tag' => false],
        ],
    ],
];
