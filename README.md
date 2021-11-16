Purpose
===
This library is for convenient methods that use to register code base for Laravel project 

Target
===
We aimed to reduce complexity for real projects with MVC plus Repository and Service layers. 
The struct was tested by our real projects, and it reduces complexity significantly, also easy to debug, more readable.

The struct forcus on creating Repository and Service for Laravel project version 8.0 and up. 

Therefore:
- The Repository aimed to interact with Model, a Repository has only one Model instance. When creating new Repository, it automatically detects the Model. For exam: `UserRepository` will auto take `User` as the Model. 

- Service aimed to resolve logic. So your controller just need to pass params to Service, that's all.

- ApiLogicException helps throwing exception whenever your API faces one.

- ResponseTemplateTrait is a standard for json response, you won't need to repeat your code anymore, just call.

Installation
===
```
composer require pros/base
```

Commands
===

The lib supports 3 commands: 
- `php artisan make:remose <name>` to generate Repository, Model, Service base on `name`. 
  
  For exam: `php artisan make:remose User` will generate: 
    - `Models/User.php` 
    - `Repositories/UserRepository.php`
    - `Services/UserService.php`
- `php artisan make:repo <name>` to generate Repository
- `php artisan make:service <name>` to generate Service

Example
===
- `Controller.php`
```
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    // this line is to register json response convenient methods
    use ResponseTemplateTrait;

    pubic function __construct(
        protected Service $service
    ){}

    public function index(Request $request) 
    {
        $param1 = $request->get('param1');
        $data = $this->service->methodName($param1)

        // this method comes from ResponseTemplateTrait
        // it also contains jsonError and jsonSuccessNoContent methods
        return $this->jsonSuccess($data);
    }
}
```

- `Service.php`
```
class Service 
{
    pubic function __construct(
        protected Repository $repository
    ){}

    /**
    * for testing only, it can be whatever 
    */
    public function methodName($param1) : boolean
    {
        // This is for demo only,
        // you can throw new exception to avoid check error
        // here and there.
        // It helps code more readable.
        // But it doesn't limit you in returning error, both are fine
        if('a' === 'b') {
            throw new ApiLogicException('What the hell?');
        }

        // handle your code logic here and then interact with DB 
        // via repository
        return $this->repository->paramExists($param1);
    }
}
``` 

- `Repository.php`
```
class Repostory extends BaseRepository 
{
    public funtion paramExists($param) : boolean
    {
        // $this can represents for Model, Eloquent, QueryBuilder
        // so feel free to use this as you desired
        // you also can use $this->model for same purpose. 
        return $this->where('a' = $param)->exists();
    }
}
```
