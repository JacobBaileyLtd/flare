<?php

namespace Flare\Contracts;

interface PermissionsContract
{
    /**
     * Permission Provider.
     * 
     * @return 
     */
    public function providePermissions();

    /**
     * Can Create.
     * 
     * @return 
     */
    public function canCreate();

    /**
     * Can View.
     * 
     * @return
     */
    public function canView();

    /**
     * Can Edit.
     * 
     * @return 
     */
    public function canEdit();

    /**
     * Can Delete.
     * 
     * @return
     */
    public function canDelete();
}
