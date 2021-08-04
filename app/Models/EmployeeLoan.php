<?php

namespace App\Models;

use App\Models\LoanType;
use Illuminate\Database\Eloquent\Model;

class EmployeeLoan extends Model
{
   
     public function LoanType()
    {
   
        return $this->hasMany('App\LoanType');
    
    }
     

}
