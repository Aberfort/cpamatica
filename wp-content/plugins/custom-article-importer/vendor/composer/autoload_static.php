<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite752eee858c9951a7e264ce4cc6bb3bf
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'CustomArticleImporter\\' => 22,
            'Composer\\Installers\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'CustomArticleImporter\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
        'Composer\\Installers\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/installers/src/Composer/Installers',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite752eee858c9951a7e264ce4cc6bb3bf::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite752eee858c9951a7e264ce4cc6bb3bf::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInite752eee858c9951a7e264ce4cc6bb3bf::$classMap;

        }, null, ClassLoader::class);
    }
}
