<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Category
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Content[] $content
 * @property-read int|null $content_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property int $active
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereUserId($value)
 */
class Category extends Model
{
    public function content()
    {
        return $this->belongsToMany(Content::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent_category()
    {
        return $this->belongsTo(Category::class,'parent_id');
    }

    public function sub_category()
    {
        return $this->hasMany(Category::class,'parent_id');
    }

    public function set_additional_property_category()
    {
        return $this->hasMany(SetAdditionalProperty::class,'property_id');
    }

    protected $fillable=['name','active', 'super_category','parent_id','user_id'];

    public static function addCategory($newRequest,$id)
    {
        //Сохраняет новую категорию
        $category=new Category();
        $category->name=$newRequest['name_category'];
        $category->active=true;
        $category->super_category=$id?null:true;
        $category->parent_id=$id?$id:null;
        $category->user_id=\Auth::id();

        $category->save();
    }

}
