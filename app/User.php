<?php

namespace App;
use App\Models\Employee;
use App\Models\Project;
use App\Models\UserRole;
use App\Models\Department;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id', 'id');
    }

    public function role()
    {
        return $this->hasOne('App\Models\UserRole', 'user_id', 'id');
    }
    
     

    public function isHR()
    {
        $userId = Auth::user()->id;
       $userRole = DB::table('users as u') 
                    ->join('user_roles as ur','ur.user_id','=','u.id')
                    ->join('roles as r','ur.role_id','=','r.id')
                        ->select('ur.role_id','r.role_type')
                        ->where('r.role_type',  2)->where('ur.user_id',$userId)->count();

        if($userRole > 0 )
        {
            return true;
        }
        return false;
    }

    public function notAnalyst()
    {
        $userId = Auth::user()->id;
        $userRole = UserRole::where('user_id', $userId)->first();
        if($userRole->role_id != 3)
        {
            return true;
        }
        return false;
    }

    public function isCoordinator()
    {
        $userId = Auth::user()->id;
         $userRole = DB::table('users as u') 
                    ->join('user_roles as ur','ur.user_id','=','u.id')
                    ->join('roles as r','ur.role_id','=','r.id')
                        ->select('ur.role_id','r.role_type')
                        ->where('r.role_type',  3)->where('ur.user_id',$userId)->count();
                
         if($userRole > 0)
        {
            return true;
        }
        
        
//        $roleIds = [2,5,7,8,9,10,14,16];
//        if(in_array($userRole->role_id, $roleIds) )
//        {
//            return true;
//        }
        return false;
    }

    public function isManager()
    {
        $userId = Auth::user()->id;
        $userRole = DB::table('users as u') 
                    ->join('user_roles as ur','ur.user_id','=','u.id')
                    ->join('roles as r','ur.role_id','=','r.id')
                        ->select('ur.role_id','r.role_type')
                        ->where('r.role_type',  1)->where('ur.user_id',$userId)->count();
        
        if($userRole > 0)
        {
            return true;
        }
        return false;
    }
    
    public function isFinanceManager()
    {
        $userId = Auth::user()->id;
        $userRole = DB::table('users as u') 
                    ->join('user_roles as ur','ur.user_id','=','u.id')
                    ->join('roles as r','ur.role_id','=','r.id')
                        ->select('ur.role_id','r.role_type')
                        ->where('r.role_type',  4)->where('ur.user_id',$userId)->count();
        
        if($userRole > 0)
        {
            return true;
        }
        return false;
    }
    
    
    

    public function project()
    {
        return $this->hasMany(Project::class);
    }
}
