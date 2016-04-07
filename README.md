# PHP SOA Library

You need to compose your application code through independent layers with well defined interfaces. This is a simple PHP library to help you with it and organize your code better; which in return helps your code to be more reusable, self documented and easily testable. 

## Basic thinking behind this architecture

- Seperation of concerns
	- Service layer should handle all the business logic
	- Repositories should handle persistance
	- Repositories should be a part of the service layer through composition
	- Controllers should handle requests 
		- Passing of the request data to the service
		- Handling authentication and authorization (preferably through a middleware)
- Adhere to [SOLID](#solid) principles (but you _may not necessarily_ need [ISP](#isp))
- Avoid boilerplate code, generated code & scaffolds
- Keep it Simple and Elegant 👌

## Example

You can follow the [10 minute "zero-to-hero" tutorial](http://devr.tips) to get an in-depth idea about how this can be used with your project. Or, given below is a basic example of the usage.

##### Controller

This is what we need to do

```
authenticate
call relevant service with request data
if error
	determine what errors should be shown to the user
	return error
if success
	return response with success message
```

It can be represented as ...

```php
# ProductController.php 

public function create() 
{
    $res = Dispatcher::call(ProductService::class, 'createProduct', $this->reqData);

    if ($res->fails()) {
        switch ($res->message()) {
            case ProductService::ERR_VALIDATION:
            case ProductService::ERR_CODE_EXISTS:
            case ProductService::ERR_INVALID_CATEGORY:
                return $res;
        }

        return Msg::error(self::ERR_CREATE_PRODUCT);
    }

    return $res;
}   
```

##### Service

And this is our basic service

```
filter request data
validate request data
check if product code already exists
check if category is a valid category
create product
return response
```

Which translates to ...

```php
# ProductService.php

cons ERR_CREATE_PRODUCT = 'error.product.failed_to_create';
cons ERR_CODE_EXISTS = 'error.product.code_exists';
cons ERR_INVALID_CATEGORY = 'error.product.invalid_category';
cons SUCC_PRODUCT_CREATED = 'success.product.created';

public function createProduct(
	Params $inputs,
	ProductRepository $productRepo,
	CategoryRepository $categoryRepo
)
{
    $inputs->filterAndValidate([
        'code' => 'required',
        'name' => 'required',
        'category' => 'required|numeric', 
        'weight' => 'numeric'
    ]);

    // Validate inputs
    if ($inputs->invalid()) {
        return Msg::error(self::ERR_VALIDATION, ['validations' => $inputs->errors()]);
    }

    // Check if code already exists
    if (is_null($productRepo->getProductFromCode($inputs->get('code')))) {
    	return Msg::error(self::ERR_CODE_EXISTS);
    }

    // Check if category is valid
    if (is_null($categoryRepo->getCategoryFromId($inputs->get('category')))) {
    	return Msg::error(self::ERR_INVALID_CATEGORY);
    }

    // Save product to the database
    $product = ProductRepository::createProduct($inputs->all());
    
    // Prepare reponse
    $response = ProductResponse($product);

    return new Msg::success($response, self::SUCC_PRODUCT_CREATED);
}
```

##### Repository

You may use your own implementation for this. Be it an ORM, query builder or raw SQL queries through PDO, but make sure [not to leak external objects] eg: ORM models, out of the repositories.

## What / How / Why

### Controller

- A controller takes a request from CLI / HTTP, passes it to the relevant service(s) and returns the response.

#### Middleware

- Authentication and authorization can be handled through a middleweare.

### Service

- A service or a service call / action, is concidered a single UoW (Unit of Work).
- A single service action can be either one of,
	- A single class which implements `Contracts\Callable` (recommended).
	- A public method on plain PHP class containing similar service actions.
- Accepts a single [`Data`](#data-objects) object containing the parameters (_ES6 Parameter destruction-esque goodness_)
- Will always return a [`Response`](#response-objects) object or any child object (`Success`, `Error` or `InternalError` which extends the former).
	- If the service was successful, it will return a `Success` object with a message.
	- If the service fails, it will return _why_ it failed rather than returning a generic error message announcing the service failure.
	- If a depending service fails, it would return an `Error` object with the message `BaseService::ERR_RELIANT_FAILURE`.
	- If a query (repository) fails, it would return an `InternalError` object with the message `BaseService::ERR_EXCEPTION`.
- At the beginning of each service, all the inputs should be filtered and validated. This will also be utilized to identify the inputs of the service.

#### Dispatcher

- This is used to dispatch a service call. 
- Dispatcher will always guarantee that no exception would be thrown from inside the service; and instead will return an `Error` response.

####  Message Constants

Error constants are usefull for the following purposes
- Determining what went wrong with a service calls.
	- When being called by another service or controller.

#### `Data` Objects


#### `Response` Objects

