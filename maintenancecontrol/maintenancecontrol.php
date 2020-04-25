<?php
/* For licensing terms, see /license.txt */

/**
 * Class maintenancecontrol.
 */
class maintenancecontrol extends Plugin
{
    /**
     * maintenancecontrol constructor.
     */
    protected function __construct()
    {
        parent::__construct(
            '1.0',
            'Damien Renou',
            [
                'enable_plugin_dictionary' => 'boolean',
            ]
        );
    }

    /**
     * @return maintenancecontrol|null
     */
    public static function create()
    {
        static $result = null;

        return $result ? $result : $result = new self();
    }

    /**
     * Installation process.
     */
    public function install()
    {
       
    }

    /**
     * Uninstall process.
     */
    public function uninstall()
    {

    }
}
