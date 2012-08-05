<?php

// try to reuse lib defined in a current symfony2 project
$autoload = __DIR__.'/../../../../../../app/autoload.php';
if (is_file($autoload)) {
    include $autoload;
} else {
    $vendorDir = __DIR__.'/../vendor';
    require_once $vendorDir.'/symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php';

    $loader = new Symfony\Component\ClassLoader\UniversalClassLoader();
    $loader->registerNamespaces(array(
        'Symfony' => array($vendorDir.'/symfony/src'),
    ));
    $loader->registerPrefixes(array(
        'Twig_' => $vendorDir.'/twig/lib',
    ));
    $loader->register();

    spl_autoload_register(function($class) {
        if (0 === strpos($class, 'Dojo\\DojoBundle\\')) {
            $path = __DIR__.'/../../'.implode('/', array_slice(explode('\\', $class), 2)).'.php';

            if (!stream_resolve_include_path($path)) {
                return false;
            }
            require_once $path;
            return true;
        }
    });
}
