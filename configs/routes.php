<?php
    $routes['default_controller'] = 'home';

    $routes['san-pham'] = 'product/index';
    $routes['tin-tuc/(.*)'] = 'news/category/$1';