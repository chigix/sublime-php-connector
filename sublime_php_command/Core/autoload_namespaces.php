<?php 
$coreDir = dirname(__FILE__);
$baseDir = dirname($coreDir);
return array(
    'Twig_Extensions_' => $coreDir . '/twig/extensions/lib',
    'Twig_' => $coreDir . '/twig/twig/lib',
    'Symfony\\Component\\Icu\\' => $coreDir . '/symfony/icu',
    'Symfony\\Bundle\\SwiftmailerBundle' => $coreDir . '/symfony/swiftmailer-bundle',
    'Symfony\\Bundle\\MonologBundle' => $coreDir . '/symfony/monolog-bundle',
    'Symfony\\Bundle\\AsseticBundle' => $coreDir . '/symfony/assetic-bundle',
    'Symfony\\' => $coreDir . '/symfony/symfony/src',
    'Sensio\\Bundle\\GeneratorBundle' => $coreDir . '/sensio/generator-bundle',
    'Sensio\\Bundle\\FrameworkExtraBundle' => $coreDir . '/sensio/framework-extra-bundle',
    'Sensio\\Bundle\\DistributionBundle' => $coreDir . '/sensio/distribution-bundle',
    '' => $baseDir . '/Commands',
);
?>