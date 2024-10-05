<?php
/**
 * Adapter for session in database filesystem
 *
 * @package: Scrawler
 * @author: Pranjal Pandey
 */
namespace Scrawler\Http\Adapters\Session;

use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

Class DatabaseAdapter extends NativeSessionStorage {

    public function __construct(){
        parent::__construct([],new DatabaseHandler);
    }

}