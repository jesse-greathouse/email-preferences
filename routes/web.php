<?php

use Illuminate\Http\Request,
    Illuminate\Support\Facades\Route,
    Illuminate\Support\Facades\Validator;

use App\User,
    App\Post,
    App\Newsletter,
    App\Subscription,
    App\Rules\IsJobType,
    App\Rules\UserExists,
    App\Rules\UserEmailIsUnique,
    App\Http\Resources\User as UserResource,
    App\Http\Resources\Users as UsersResource,
    App\Http\Resources\Post as PostResource,
    App\Http\Resources\Posts as PostsResource,
    App\Http\Resources\Newsletter as NewsletterResource,
    App\Http\Resources\Newsletters as NewslettersResource,
    App\Http\Resources\Subscription as SubscriptionResource,
    App\Http\Resources\Subscriptions as SubscriptionsResource;

/** @var \Laravel\Lumen\Routing\Router $router */

// home
$router->get('/', function () use ($router) {
    return view('index', []);
});

// User
$router->get('/user', function () {
    return new UsersResource(User::all());
});

$router->post('/user', function (Request $request) {
    $user = User::create($request->all());
    return (new UserResource($user))
        ->additional(['meta' => [
            'message' => "User with id: $user->id was created.",
        ]]);
});

$router->get('/user/{id}', function ($id) {
    return new UserResource(User::findOrFail($id));
});

$router->put('/user/{id}', function (Request $request, $id) {
    $user = User::findOrFail($id);
    $user->update($request->all());
    return (new UserResource(User::find($id)))
        ->additional(['meta' => [
            'message' => "User with id: $id was updated.",
        ]]);
});

$router->delete('/user/{id}', function (Request $request, $id) {
    $user = User::findOrFail($id);
    $user->delete();
    return response()->json([ 'meta' => ['message' => "User with id: $id was deleted."]]);
});

// Newsletter
$router->get('/newsletter', function () {
    return new NewslettersResource(Newsletter::all());
});

$router->post('/newsletter', function (Request $request) {
    $newsletter = Newsletter::create($request->all());
    return (new NewsletterResource($newsletter))
        ->additional(['meta' => [
            'message' => "Newsletter with id: $newsletter->id was created.",
        ]]);
});

$router->get('/newsletter/{id}', function ($id) {
    return new NewsletterResource(Newsletter::findOrFail($id));
});

$router->put('/newsletter/{id}', function (Request $request, $id) {
    $newsletter = Newsletter::findOrFail($id);
    $newsletter->update($request->all());
    return (new NewsletterResource(Newsletter::find($id)))
        ->additional(['meta' => [
            'message' => "Newsletter with id: $id was updated.",
        ]]);
});

$router->delete('/newsletter/{id}', function (Request $request, $id) {
    $newsletter = Newsletter::findOrFail($id);
    $newsletter->delete();
    return response()->json([ 'meta' => ['message' => "Newsletter with id: $id was deleted."]]);
});

// Post
$router->get('/post', function () {
    return new PostsResource(Post::all());
});

$router->post('/post', function (Request $request) {
    $post = Post::create($request->all());
    return (new PostResource($post))
        ->additional(['meta' => [
            'message' => "Post with id: $post->id was created.",
        ]]);
});

$router->get('/post/{id}', function ($id) {
    return new PostResource(Post::findOrFail($id));
});

$router->put('/post/{id}', function (Request $request, $id) {
    $post = Post::findOrFail($id);
    $post->update($request->all());
    return (new PostResource(Post::find($id)))
        ->additional(['meta' => [
            'message' => "Post with id: $id was updated.",
        ]]);
});

$router->delete('/post/{id}', function (Request $request, $id) {
    $post = Post::findOrFail($id);
    $post->delete();
    return response()->json([ 'meta' => ['message' => "Post with id: $id was deleted."]]);
});

// Subscription
$router->get('/subscription', function () {
    return new SubscriptionsResource(Subscription::all());
});

$router->post('/subscription', function (Request $request) {
    $subscription = Subscription::create($request->all());
    return (new SubscriptionResource($subscription))
        ->additional(['meta' => [
            'message' => "Subscription with id: $subscription->id was created.",
        ]]);
});

$router->get('/subscription/{id}', function ($id) {
    return new SubscriptionResource(Subscription::findOrFail($id));
});

$router->put('/subscription/{id}', function (Request $request, $id) {
    $subscription = Subscription::findOrFail($id);
    $subscription->update($request->all());
    return (new SubscriptionResource(Subscription::find($id)))
        ->additional(['meta' => [
            'message' => "Subscription with id: $id was updated.",
        ]]);
});

$router->delete('/subscription/{id}', function (Request $request, $id) {
    $subscription = Subscription::findOrFail($id);
    $subscription->delete();
    return response()->json([ 'meta' => ['message' => "Subscription with id: $id was deleted."]]);
});