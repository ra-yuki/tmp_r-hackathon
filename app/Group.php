<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    


    public function friends()
    {
        return $this->belongsToMany(Group::class, 'user_friend', 'userId', 'friendId')->withTimestamps();
    }

    // public function followers()
    // {
    //     return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    // }
    
    
    public function friend($userId)
    {
    // confirm if already following
        $exist = $this->is_friend($userId);
    // confirming that it is not you
        $its_me = $this->id == $userId;

        if ($exist || $its_me) {
        // do nothing if already following
        return false;
        } else {
        // follow if not following
        $this->friends()->attach($userId);
        return true;
        }
    }

    public function unfriend($userId)
    {
    // confirming if already following
        $exist = $this->is_friend($userId);
    // confirming that it is not you
        $its_me = $this->id == $userId;


        if ($exist && !$its_me) {
        // stop following if following
        $this->friends()->detach($userId);
        return true;
        } else {
        // do nothing if not following
        return false;
        }
    }


    public function is_friend($userId) {
        return $this->friends()->where('friendId', $userId)->exists();
    }
    
    public function makegroups()
    {
        return $this->hasMany(Group::class);
    }
    
    // public function feed_makegroups()
    // {
    //     $follow_user_ids = $this->followings()-> pluck('users.id')->toArray();
    //     $follow_user_ids[] = $this->id;
    //     return Micropost::whereIn('user_id', $follow_user_ids);
        
        
    // }
    
    public function groups()
    {
        return $this->belongsToMany(Micropost::class, 'user_group', 'userId', 'groupIid')->withTimestamps();
    }
    
    public function group($group_id)
    {
        $exist = $this->is_group($group_id);
        // confirming that it is not you

        if ($exist ) {
        // do nothing if already following
        return false;
        } else {
        // follow if not following
        $this->groups()->attach($group_id);
        return true;
        }
    }
    
     public function ungroup($group_id)
    {
        print_r("ungroup() pt1");
    // confirming if already following
        $exist = $this->is_group($group_id);
    // confirming that it is not you
    //    $its_me = $this->id == $userId;


        if ($exist) {
        // stop following if following
        $this->groups()->detach($group_id);
        print_r("ungroup() pt2");
        return true;
        } else {
        // do nothing if not following
        return false;
        }
    }
   public function is_group($group_id) {
    return $this->groups()->where('groupId', $group_id)->exists();
    }

}