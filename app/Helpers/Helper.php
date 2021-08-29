<?php

namespace App\Helpers;
use Spatie\Permission\Models\Role;
use App\User;
use App\Models\Article;
class Helper
{
    public static function getPermissionsOfRole($roleName)
    {
        $arrPermissions = [];
        $roleOfPermission = Role::where('name', $roleName)->get();
        foreach($roleOfPermission as $role){
            foreach($role->permissions as $permission) {
                array_push($arrPermissions , $permission->name);
            }
        }
        return $arrPermissions;
    }
    public static function getRoleOfUser($userID)
    {
        $arrRole = [];
        $roleOfUser = User::find($userID);
        foreach($roleOfUser->roles as $role){
            array_push($arrRole , $role->name);
        }
        return $arrRole;
    }
    public static function getTagOfArticle($articelID)
    {
        $arrTags = [];
        $tagOfArticle = Article::find($articelID);
        foreach($tagOfArticle->tag as $tag){
            array_push($arrTags , $tag->id);
        }
        return $arrTags;
    }
}