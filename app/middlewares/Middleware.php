<?php
/**
 * Base Middleware Class
 */
abstract class Middleware {
    /**
     * Handle the middleware request
     * 
     * @return bool|void Return true to continue, or header redirect/exit
     */
    abstract public function handle();
}
