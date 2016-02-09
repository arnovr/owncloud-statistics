<?php
OCP\App::checkAppEnabled('statistics');
OCP\App::setActiveNavigationEntry('statistics');

OCP\App::addNavigationEntry(Array(
    'id'	=> 'statistics',
    'order'	=> 60,
    'href' => \OCP\Util::linkToRoute('statistics.Frontpage.run'),
    'icon'	=> OCP\Util::imagePath('statistics', 'iconchart.png'),
    'name'	=> \OC_L10N::get('statistics')->t('statistics')
));