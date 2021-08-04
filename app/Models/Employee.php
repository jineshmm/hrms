<?php

namespace App\Models;

use App\User;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function userrole()
    {
        return $this->hasOne('App\Models\UserRole', 'user_id', 'id');
    }

    public function employeeLeaves()
    {
        return $this->hasMany('App\EmployeeLeaves', 'user_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
     public function employeeLoans()
    {
        return $this->hasMany('App\EmployeeLoans', 'user_id', 'user_id');
    }
    
     public function department()
    {     

      return $this->hasOne(Department::class, 'id', 'department_id');
        
    }
    
  
        public function documents()
    {
        return $this->hasMany('App\Models\EmployeeDocuments','employee_id','id');
    }
    

}
