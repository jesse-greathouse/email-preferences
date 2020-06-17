# Email Preferences
A simple demonstration of how to manage email subscriptions with PHP and MySQL.

For the demonstration, I wanted to make sure that my code was a working proof of concept. I made the examples with the [Lumen PHP micro-framework](https://lumen.laravel.com/).

It's not necessary to run the app, but since it is a working POC then it is possible:

 - Clone the repository

	$ git clone https://github.com/jesse-greathouse/email-preferences.git

 - Change to the app directory

		$ cd email-preferences

 - Install dependencies

		$ composer install

 - Run migrations to set up the database

		$ php artisan migrate

 - Seed the database with fake data

		$ php artisan seed

 - Run the app

		$ php -S localhost:8000 -t public

I have included a [postman](https://www.postman.com/) configuration for  [environment](https://github.com/jesse-greathouse/email-preferences/blob/master/email-preferences-local.postman_environment.json) and [collection](https://github.com/jesse-greathouse/email-preferences/blob/master/email-preferences.postman_collection.json) that could be imported to browse the API.

## Task: Describe the major API endpoints
The four major Api endpoints are:

 - [/user](https://github.com/jesse-greathouse/email-preferences/blob/master/routes/web.php#L30)
 - [/newsletter](https://github.com/jesse-greathouse/email-preferences/blob/master/routes/web.php#L62)
 - [/post](https://github.com/jesse-greathouse/email-preferences/blob/master/routes/web.php#L94)
 - [/subscription](https://github.com/jesse-greathouse/email-preferences/blob/master/routes/web.php#L126)

Each responds to 4 methods of the http protocol:

 - GET
 - POST
 - PUT
 - DELETE

### Examples
[GET /user](https://github.com/jesse-greathouse/email-preferences/blob/master/routes/web.php#L31)
```php
$router->get('/user', function () {
	return new UsersResource(User::all());
});
```
In this example, the api simply uses the User model to fetch all the user records from the database and return them. You may notice that this API uses the "resource" pattern, which is a way of defining how an API resource is displayed on the page.

[\Http\Resources\Users](https://github.com/jesse-greathouse/email-preferences/blob/master/app/Http/Resources/Users.php)
```php
class Users extends ResourceCollection
{
	/**
	* Transform the resource collection into an array.
	*
	* @param \Illuminate\Http\Request $request
	* @return array
	*/
	public function toArray($request): array
	{
		return [
			'data' => UserResource::collection($this->collection),
		];
	}
}
```
This class describes how a collection of users are to be displayed. It establishes an array element called: data, and uses the UserResource to describe that element.

[\Http\Resources\User](https://github.com/jesse-greathouse/email-preferences/blob/master/app/Http/Resources/User.php)
```php
class  User  extends  JsonResource
{
	/**
	* Transform the resource into an array.
	*
	* @param \Illuminate\Http\Request $request
	* @return  array
	*/
	public  function  toArray($request): array
	{
		return [
			'id' => $this->id,
			'first_name' => $this->first_name,
			'last_name' => $this->last_name,
			'email' => $this->email,
			'subscriptions' => SubscriptionResource::collection($this->subscriptions),
		];
	}
}
```
Inside UserResource we can really see how users are intended to be represented in the API. You can also see that the "subscriptions" element is being created with the SubscriptionResource::collection method, which will display subscriptions as a collection of nested elements inside each user element.

[POST /user](https://github.com/jesse-greathouse/email-preferences/blob/master/routes/web.php#L35)
```php
$router->post('/user', function (Request $request) {
	$user = User::create($request->all());
	return (new UserResource($user))
	->additional(['meta' => [
		'message' => "User with id: $user->id was created.",
	]]);
});
```

In the /user post method, we can see that a new user is created. It takes all of the input from the request and applies those inputs to the User model's "create" method.

[User.php](https://github.com/jesse-greathouse/email-preferences/blob/master/app/User.php)
```php
<?php

namespace  App;

use Illuminate\Database\Eloquent\Model,
Illuminate\Database\Eloquent\Relations\HasMany;

class  User  extends  Model
{
	/**
	* @var  array
	*/
	protected  $fillable = ['first_name', 'last_name', 'email'];

	/**
	* @var  string
	*/
	protected  $first_name;

	/**
	* @var  string
	*/
	protected  $last_name;

	/**
	* @var  string
	*/
	protected  $email;

	/**
	* @return  HasMany
	*/
	public  function  subscriptions(): HasMany
	{
		return  $this->hasMany('App\Subscription');
	}
}
```

In the user model we can see a property called "fillable" which discribes an array that filters out which input is allowed to be used in the model. So a request to the POST /user endpoint would require the inputs: "first_name", "last_name" and "email".

in the resources/views folder, we can see an example of how the front-end would interact with these api endpoints on the back-end:

[index.php](https://github.com/jesse-greathouse/email-preferences/blob/master/resources/views/index.php)
```javascript
function getUsers() {
	$.get("/user").done(function(response) {
		refreshUsers(response.data);
	});
}

function deleteUser(id) {
	$.ajax({"url": "/user/" + id, "type": "DELETE"})
	.done(function(response) {
		getUsers();
	});
}

function addUser(user) {
	$.post("/user", user).done(function(response) {
		getUsers();
	});
}
```

## Task: Describe the data model

In the database/migrations folder of the project, you can see, in the migrations, how the database tables are set up.

[database/migrations/2020_06_16_170631_create_user_table.php](https://github.com/jesse-greathouse/email-preferences/blob/master/database/migrations/2020_06_16_170631_create_user_table.php)
```sql
CREATE TABLE IF NOT EXISTS `users` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`created_at` TIMESTAMP NULL DEFAULT NULL,
	`updated_at` TIMESTAMP NULL DEFAULT NULL,
	`email` VARCHAR(100) NULL,
	`first_name` VARCHAR(100) NULL,
	`last_name` VARCHAR(100) NULL,
PRIMARY KEY (`id`),
UNIQUE INDEX `email_UNIQUE` (`email` ASC));
```

[database/migrations/2020_06_16_171155_create_newsletter_table.php](https://github.com/jesse-greathouse/email-preferences/blob/master/database/migrations/2020_06_16_171155_create_newsletter_table.php)
```sql
CREATE TABLE IF NOT EXISTS `newsletters` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`created_at` TIMESTAMP NULL DEFAULT NULL,
	`updated_at` TIMESTAMP NULL DEFAULT NULL,
	`name` VARCHAR(255) NOT NULL,
	`slug` VARCHAR(255) NOT NULL,
	`description` TEXT DEFAULT NULL,
PRIMARY KEY (`id`),
UNIQUE INDEX `slug` (`slug` ASC));
```
[database/migrations/2020_06_16_171450_create_post_table.php](https://github.com/jesse-greathouse/email-preferences/blob/master/database/migrations/2020_06_16_171450_create_post_table.php)
```sql
CREATE TABLE IF NOT EXISTS `posts` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`created_at` TIMESTAMP NULL DEFAULT NULL,
	`updated_at` TIMESTAMP NULL DEFAULT NULL,
	`newsletter_id` INT NOT NULL,
	`publish_date` VARCHAR(45) NULL DEFAULT NULL,
	`content` TEXT DEFAULT NULL,
PRIMARY KEY (`id`),
INDEX `fkey_post_newsletter_id_idx` (`newsletter_id` ASC),
INDEX `publish_date_idx` (`publish_date` ASC),
CONSTRAINT `fkey_post_newsletter_id`
	FOREIGN KEY (`newsletter_id`)
	REFERENCES `newsletters` (`id`)
	ON DELETE CASCADE
	ON UPDATE NO ACTION);
```

[database/migrations/2020_06_16_171757_create_subscription_table.php](https://github.com/jesse-greathouse/email-preferences/blob/master/database/migrations/2020_06_16_171757_create_subscription_table.php)
```sql
CREATE TABLE IF NOT EXISTS `subscriptions` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`created_at` TIMESTAMP NULL DEFAULT NULL,
	`updated_at` TIMESTAMP NULL DEFAULT NULL,
	`user_id` INT NOT NULL,
	`newsletter_id` INT NOT NULL,
PRIMARY KEY (`id`),
UNIQUE INDEX `unique_user_newsletter_idx` (`user_id` ASC, `newsletter_id` ASC),
INDEX `fkey_newsletter_subscription_idx` (`newsletter_id` ASC),
INDEX `fkey_user_subscription_idx` (`user_id` ASC),
CONSTRAINT `fkey_user_subscription`
	FOREIGN KEY (`user_id`)
	REFERENCES `users` (`id`)
	ON DELETE CASCADE
	ON UPDATE NO ACTION,
CONSTRAINT `fkey_newsletter_subscription`
	FOREIGN KEY (`newsletter_id`)
	REFERENCES `newsletters` (`id`)
	ON DELETE CASCADE
	ON UPDATE NO ACTION);
```
The data model consists of 4 domain models, corresponding to the database tables:

 - [User](https://github.com/jesse-greathouse/email-preferences/blob/master/app/User.php)
	 - Keeps information about the user. A user's name and email will be required to create a subscription for that user.
 - [Newsletter](https://github.com/jesse-greathouse/email-preferences/blob/master/app/Newsletter.php)
	 - Creates a topical email newsletter. This only requires a human-readable name of the topic, a description which is a short blurb that explains what the newsletter is about, and a "slug" which will uniquely identify the newsletter in a url.
 - [Post](https://github.com/jesse-greathouse/email-preferences/blob/master/app/Post.php)
	 - Posts are articles for a specific newsletter. They require an association to a newsletter, a publish date so that a delivery mechanism can identify new posts relative to a given date, and of course the content data of that post.
 - [Subscription](https://github.com/jesse-greathouse/email-preferences/blob/master/app/Subscription.php)
	 - Subscription is an association table. It requires a relationship with a user id, and a newsletter id. Adding subscription makes it possible for a user to subscribe to a newsletter. 
	 - When an entry is deleted, then that subscription is cancelled without disturbing the user data, the newsletter data or any other users subscriptions. If a user is deleted, or a newsletter is deleted, removal of deletions will cascade from those events due to the cascade directives in those foreign key relationships.

## Task: Code a small sample of one or two of these model classes.

In particular, I think that the Subscription model is very interesting:

[app/Subscription.php](https://github.com/jesse-greathouse/email-preferences/blob/master/app/Subscription.php)

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model,
	Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
	/**
	* @var array
	*/
	protected $fillable = ['newsletter_id', 'user_id'];

	/**
	* @return BelongsTo
	*/
	public function user(): BelongsTo
	{
		return $this->belongsTo('App\User');
	}

	/**
	* @return BelongsTo
	*/
	public function newsletter(): BelongsTo
	{
		return $this->belongsTo('App\NewsLetter');
	}
}
```
This model serves to provide the association between users and newsletters. It only holds the association between those tables, and therefore only requires 2 fields, the User and the Newsletter.

In this model, Subscription is using the Illuminate model class to have accessor methods that describe the relationship as Belonging to an App\User and an App\Newsletter.

For testing, I feel that each of these endpoints needs an integration test for each of its methods (GET, POST, PUT, DELETE).  I have prepared samples of these tests
in the [tests/Feature](https://github.com/jesse-greathouse/email-preferences/tree/master/tests/Feature) directory.

[tests/Feature/UserTest.php](https://github.com/jesse-greathouse/email-preferences/blob/master/tests/Feature/UserTest.php)

```php
<?php

use App\User;

class UserTest extends TestCase
{

	/**
	* get /user
	*
	* @return void
	*/
	public function testGetUser()
	{
		$response = $this->getJson('/user');
		$response->assertStatus(200);
	}

	/**
	* post /user
	*
	* @return void
	*/

	public function testPostUser()
	{
		$user = factory(User::class)->make();
		$response = $this->json('POST', '/user', [
			'first_name' => $user->first_name,
			'last_name' => $user->last_name,
			'email' => $user->email
		]);

		$response
		->assertStatus(201)
		->assertJsonStructure([
			'data',
			'meta' => [
				'message',
			]
		]);
	}

	/**
	* get /user/{id}
	*
	* @return void
	*/
	public function testGetUserById()
	{
		$user = factory(User::class)->create();
		$response = $this->getJson('/user/'.$user->id);
		$response->assertStatus(200);
	}

	/**
	* put /user/{id}
	*
	* @return void
	*/
	public function testPutUserById()
	{
		$user = factory(User::class)->create();

		$response = $this->json('PUT', '/user/'.$user->id, [
			'first_name' => $user->first_name,
			'last_name' => $user->last_name,
			'email' => $user->email
		]);

		$response
		->assertStatus(200)
		->assertJsonStructure([
			'data',
			'meta' => [
				'message',
			]
		]);
	}

	/**
	* delete /user/{id}
	*
	* @return void
	*/

	public function testDeleteUserById()
	{
		$user = factory(User::class)->create();
		$response = $this->json('DELETE', '/user/'.$user->id);
		$response
			->assertStatus(200)
			->assertJsonStructure([
			'meta' => [
				'message',
			]
		]);
	}
}
```

In the example it's making an assertion about the http status code and the form of the json response. I feel like more assertions could be made about the form of the response but this is a good starting point to test for a proper response.

I feel like integration tests are important for the app, but not necessarily unit tests. This is because all the app does is serve up database rows in a controlled, secure way. There's no computations or factoring involved that would make unit tests relevant. For this reason I think only integration tests are appropriate for the app, in the state that its in.