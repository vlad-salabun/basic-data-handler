<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb18c87087c4afc8ee5cd8c5bbfa2c9e6
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Salabun\\Bdh\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Salabun\\Bdh\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb18c87087c4afc8ee5cd8c5bbfa2c9e6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb18c87087c4afc8ee5cd8c5bbfa2c9e6::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb18c87087c4afc8ee5cd8c5bbfa2c9e6::$classMap;

        }, null, ClassLoader::class);
    }
}
