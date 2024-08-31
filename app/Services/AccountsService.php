<?php

namespace App\Services;

use App\Enums\AccountType;
use App\Enums\Users\UserStatus;
use App\Enums\UserTypes;
use App\Http\Requests\Account\ChangeTheStatusOfUsersRequest;
use App\Http\Requests\Account\GetUserAccountByStatusRequest;
use App\Http\Requests\Account\GetUserAccountByTypeRequest;
use App\Models\User;
use App\Models\UserIds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Service\FinancialConnections\AccountService;

use function App\Helper\paginatedResults;

class AccountsService
{
    
  


public static function getUserAccountByName(Request $request)
    {
        $name=$request->get('name');
        $users=User::query();

        if(!is_null($name))
        {
            $name = mb_strtolower($name, 'UTF-8');
            $users=User::query()
            ->Where('id',$name)
            ->orWhere(DB::raw('LOWER(first_name)'), 'LIKE', '%' . $name . '%')
            ->orWhere(DB::raw('LOWER(last_name)'), 'LIKE', '%' . $name . '%')
            ->orWhere(DB::raw("concat(first_name,' ',last_name)"), 'LIKE', '%' . $name . '%');
            
        }

        return $users->get();
    }

}