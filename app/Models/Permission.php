<?php

namespace App\Models;

use Zizaco\Entrust\EntrustPermission;

/**
 * App\Models\Permission
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereUpdatedAt($value)
 */
class Permission extends EntrustPermission
{
    // cards
    const CREATE_CARDS = 'create-cards';
    const READ_CARDS = 'read-cards';
    const UPDATE_CARDS = 'update-cards';
    const DELETE_CARDS = 'delete-cards';

    // categories
    const CREATE_CATEGORIES = 'create-categories';
    const READ_CATEGORIES = 'read-categories';
    const UPDATE_CATEGORIES = 'update-categories';
    const DELETE_CATEGORIES = 'delete-categories';

    // decks
    const CREATE_DECKS = 'create-decks';
    const READ_DECKS = 'read-decks';
    const UPDATE_DECKS = 'update-decks';
    const DELETE_DECKS = 'delete-decks';

    // fields
    const CREATE_FIELDS = 'create-fields';
    const READ_FIELDS = 'read-fields';
    const UPDATE_FIELDS = 'update-fields';
    const DELETE_FIELDS = 'delete-fields';

    // groups
    const CREATE_GROUPS = 'create-groups';
    const READ_GROUPS = 'read-groups';
    const UPDATE_GROUPS = 'update-groups';
    const DELETE_GROUPS = 'delete-groups';

    // roles
    const CREATE_ROLES = 'create-roles';
    const READ_ROLES = 'read-roles';
    const UPDATE_ROLES = 'update-roles';
    const DELETE_ROLES = 'delete-roles';

    // stubs
    const CREATE_STUBS = 'create-stubs';
    const READ_STUBS = 'read-stubs';
    const UPDATE_STUBS = 'update-stubs';
    const DELETE_STUBS = 'delete-stubs';

    // tags
    const CREATE_TAGS = 'create-tags';
    const READ_TAGS = 'read-tags';
    const UPDATE_TAGS = 'update-tags';
    const DELETE_TAGS = 'delete-tags';

    // users
    const CREATE_USERS = 'create-users';
    const READ_USERS = 'read-users';
    const UPDATE_USERS = 'update-users';
    const DELETE_USERS = 'delete-users';

}
