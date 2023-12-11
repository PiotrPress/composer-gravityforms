<?php declare( strict_types = 1 );

namespace PiotrPress\Composer\GravityForms;

use Composer\Plugin\PluginInterface;
use Composer\Composer;
use Composer\IO\IOInterface;

class Plugin implements PluginInterface {
    public function activate( Composer $composer, IOInterface $io ) : void {
        if ( ! $key = $composer->getConfig()->get( 'http-basic' )[ $host = 'gravityapi.com' ][ 'password' ] ?? '' ) return;

        Stream::register( 'gravityforms' );

        $composer->getRepositoryManager()->addRepository( $composer->getRepositoryManager()->createRepository(
            'composer',
            [
                'url' => "gravityforms://:$key@$host",
                'options' => [
                    'gravityforms' => [
                        'api' => 'https://$host/wp-content/plugins/gravitymanager/api.php?op=get_plugin&slug=$slug&key=$key'
                    ]
                ]
            ],
            'gravityforms'
        ) );
    }

    public function deactivate( Composer $composer, IOInterface $io ) : void {}
    public function uninstall( Composer $composer, IOInterface $io ) : void {}
}