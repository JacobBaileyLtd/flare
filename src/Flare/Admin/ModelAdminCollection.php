<?php

namespace JacobBaileyLtd\Flare\Admin;

use Illuminate\Support\Collection;
use Symfony\Component\Finder\Finder;
use JacobBaileyLtd\Flare\Permissions\Permissions;

class ModelAdminCollection extends Collection
{
    /**
     * The items contained in the collection.
     *
     * @var array
     */
    protected $items = [];

    /**
     * __construct.
     */
    public function __construct()
    {
        parent::__construct();

        $this->items = $this->getModelAdminClasses();
    }

    /**
     * Gets ModelAdmin classes based on the current users permissions
     * which have been set. If a ModelAdmin class has not had the
     * Permissions provided, it will be displayed by default.
     * 
     * @return 
     */
    public function getModelAdminClasses()
    {
        $classCollection = [];

        foreach (config('flare.models') as $class) {
            if (!$this->usableClass($class)) {
                continue;
            }
            $classCollection[] = $class;
        }

        return $classCollection;
    }

    /**
     * Register ModelAdmin Routes.
     *
     * Loops through all of the ModelAdmin classes in the collection
     * and registers their ModelAdmin Routes
     * 
     * @return void
     */
    public function registerRoutes()
    {
        foreach ($this->items as $class) {
            (new $class())->registerRoutes();
        }
    }

    /**
     * Determines if a class is usable by the currently
     * defined user and their permission set.
     * 
     * @param string $class
     * 
     * @return boolean
     */
    private function usableClass($class)
    {
        // Should replace this with ReflectionClass::getShortName();
        if ($class == 'JacobBaileyLtd\Flare\Admin\ModelAdmin') {
            return false;
        }

        if (!$this->checkModelAdminPermissions($class)) {
            return false;
        }

        return true;
    }

    /**
     * Checks whether a ModelAdminPermissions are set if they are
     * it will check validity for the current user otherwise
     * it will return true, since all users have access
     * to this model admin.
     * 
     * @param string $class
     * 
     * @return boolean     
     */
    private function checkModelAdminPermissions($class)
    {
        if (!is_subclass_of($class, \JacobBaileyLtd\Flare\Contracts\PermissionsContract::class)) {
            return true;
        }

        return $this->checkUserHasModelAdminPermissions($class);
    }

    /**
     * Checks if the current user has access to a given 
     * ModelAdmin class and returns a boolean.
     * 
     * @param  $class
     * 
     * @return boolean     
     */
    private function checkUserHasModelAdminPermissions($class)
    {
        // Replace this with actual Permission Implementation Check
        return Permissions::check();
    }
}
