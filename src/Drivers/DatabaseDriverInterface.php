<?php
namespace Dframe\FileStorage\Drivers;

/**
 * A contract to identify an implementation to store permissions to
 *
 * Drivers can both be persistent or static depending on their implementation.
 * A default, static ArrayDriver implementation comes with this package.
 */

interface DatabaseDriverInterface
{

    public function get($adapter, $path);
    
    public function put($adapter, $path, $mine);

    public function cache($adapter, $orginalId, $path, $mine);

    public function drop($adapter, $path);

}
