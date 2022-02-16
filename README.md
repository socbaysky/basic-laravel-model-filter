```bash
$ composer require socbaysky/laravel-model-filter-basic
```

## Usage

Create new filter for your model example:

```bash
$ php artisan make:filter 'Models\User'
```

Or:

```bash
$ php artisan make:filter 'Models\AnyYourModel'
```

After run above commands console, Laravel will automatically generate:
- app/Filters/QueryFilter.php (only first time run above command)
- app/Traits/Filterable.php (only first time run above command)
- app/Filters/**User**Filter.php (ensure this file is not exists)
or
- app/Filters/**AnyYourModel**Filter.php (ensure this file is not exists)

Example UserFilter class, we will using it like that:

```php
public function index(Request $request)
{
    $user = User::query()
        ->name($request)
        ->email($request);

    return $user->get();
}
```

You can custom app/Filters/**User**Filter.php or app/Filters/**AnyYourModel**Filter.php for you purpose.

By default, generated filter has methods by your column in database table, example UserFilter:

```php
<?php

namespace App\Filters;

class UserFilter extends QueryFilter
{
    protected $filterable = [
        'id', 'name', 'email', 'email_verified_at', 'password', 'remember_token', 'created_at', 'updated_at'
    ];
    
    public function filterId($id)
    {
        return $this->builder->where('id', 'like', '%' . $id . '%');
    }
    public function filterName($name)
    {
        return $this->builder->where('name', 'like', '%' . $name . '%');
    }
    public function filterEmail($email)
    {
        return $this->builder->where('email', 'like', '%' . $email . '%');
    }
    public function filterEmailVerifiedAt($email_verified_at)
    {
        return $this->builder->where('email_verified_at', 'like', '%' . $email_verified_at . '%');
    }
    public function filterPassword($password)
    {
        return $this->builder->where('password', 'like', '%' . $password . '%');
    }
    public function filterRememberToken($remember_token)
    {
        return $this->builder->where('remember_token', 'like', '%' . $remember_token . '%');
    }
    public function filterCreatedAt($created_at)
    {
        return $this->builder->where('created_at', 'like', '%' . $created_at . '%');
    }
    public function filterUpdatedAt($updated_at)
    {
        return $this->builder->where('updated_at', 'like', '%' . $updated_at . '%');
    }

}
```

You can see ***protected $filterable***, this is array of column can be filter in your database table, you can edit this

And with methods with ***filter*** prefix, you can custom return statement to what you want follow Laravel eloquent, default we using "like" query.