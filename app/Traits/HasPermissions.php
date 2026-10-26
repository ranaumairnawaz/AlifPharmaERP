<?php

namespace App\Traits;

use App\Models\Role;
use App\Models\Permission;

trait HasPermissions
{
    public function getAssignedRoleAttribute()
    {
        // New system Priority: role_id link
        if ($this->role_id) {
            return Role::find($this->role_id);
        }

        // Hybrid System Fallback: Search by slug string
        if ($this->role) {
            return Role::where('slug', $this->role)->first();
        }

        return null;
    }

    public function hasPermission($permission)
    {
        $role = $this->assignedRole;
        if (!$role) {
            return false;
        }

        return $role->permissions->contains('slug', $permission);
    }

    public function hasModuleAction($module, $action)
    {
        $role = $this->assignedRole;
        if (!$role) {
            return false;
        }

        return $role->permissions
            ->where('module', $module)
            ->where('action', $action)
            ->isNotEmpty();
    }

    public function isAdmin()
    {
        $role = $this->assignedRole;
        // Hybrid clearance: Check new RBAC system OR legacy role string for absolute admin resilience
        return ($role && in_array($role->slug, ['admin', 'administrator', 'superadmin'])) 
               || in_array(strtolower($this->role ?? ''), ['admin', 'administrator', 'superadmin']);
    }
}
