<?php declare( strict_types = 1 );

namespace PiotrPress\Composer\GravityForms;

use PiotrPress\Streamer;

class Stream extends Streamer {
    static public function register( string $protocol, int $flags = 0 ) : bool {
        if ( \in_array( $protocol, \stream_get_wrappers() ) ) self::unregister( $protocol );
        return parent::register( $protocol, $flags );
    }

    public function stream_open( string $path, string $mode, int $options, ?string &$opened_path ) : bool {
        if ( 'packages.json' === \substr( $path, -strlen( 'packages.json' ) ) ) self::$data[ $path ] = \json_encode( [
            'metadata-url' => '/%package%',
            'available-package-patterns' => [ \parse_url( $path, \PHP_URL_SCHEME ) . '/*' ]
        ] );
        else {
            $data = @\unserialize( @\file_get_contents( \str_replace( [ '$host', '$key', '$slug' ], [
                \parse_url( $path, \PHP_URL_HOST ),
                \parse_url( $path, \PHP_URL_PASS ),
                \basename( $path )
            ], \stream_context_get_options( $this->context )[ \parse_url( $path, \PHP_URL_SCHEME ) ][ 'api' ] ) ) ?: '' );
            self::$data[ $path ] = \json_encode( ( $data[ 'version_latest' ] ?? '' and $data[ 'download_url_latest' ] ?? '' ) ? [
                'packages' => [
                    \parse_url( $path, \PHP_URL_SCHEME ) . '/' . \basename( $path ) => [
                        $data[ 'version_latest' ] => [
                            'name' => \parse_url( $path, \PHP_URL_SCHEME ) . '/' . \basename( $path ),
                            'version' => $data[ 'version_latest' ],
                            'type' => 'wordpress-plugin',
                            'dist' => [
                                'type' => 'zip',
                                'url' => $data[ 'download_url_latest' ]
                            ]
                        ]
                    ]
                ]
            ] : [] );
        }

        return parent::stream_open( $path, $mode, $options, $opened_path );
    }
}