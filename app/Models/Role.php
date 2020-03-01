<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property int $super_user
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereSuperUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public static function addNewRole($newRequest)
    {
        $role = new Role();
        $role->name = $newRequest['nameRole'];
        $role->super_user = false;
        $role->access_admin_page=array_key_exists('access_admin_page',$newRequest)?true:false;
        $role->access_content=array_key_exists('access_content',$newRequest)?true:false;
        $role->access_security=array_key_exists('access_security_policy',$newRequest)?true:false;
        $role->access_setting=array_key_exists('access_setting',$newRequest)?true:false;
        $role->access_to_create=array_key_exists('access_to_create',$newRequest)?true:false;
        $role->access_to_edit=array_key_exists('access_to_edit',$newRequest)?true:false;
        $role->access_to_delete=array_key_exists('access_to_delete',$newRequest)?true:false;
        $role->save();
    }

    public static function updRole($newRequest, $id)
    {
        Role::where('id', $id)->update([
            'name' => $newRequest['nameRole'],
            'access_admin_page' => array_key_exists('access_admin_page',$newRequest)? true:false,
            'access_content' => array_key_exists('access_content',$newRequest)? true:false,
            'access_security' => array_key_exists('access_security_policy',$newRequest)? true:false,
            'access_setting' => array_key_exists('access_setting',$newRequest)? true:false,
            'access_to_create' => array_key_exists('access_to_create',$newRequest)? true:false,
            'access_to_edit' => array_key_exists('access_to_edit',$newRequest)? true:false,
            'access_to_delete' => array_key_exists('access_to_delete',$newRequest)? true:false,
        ]);
    }
}
