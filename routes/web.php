<?php

use App\User;
use App\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Create roles for user with id 1
Route::get('/create', function (){
    $user = User::find(1);

    $role = new Role(['name'=>'Administrator']);
    $user->roles()->save($role);

    $role = new Role(['name'=>'Subscriber']);
    $user->roles()->save($role);

    $role = new Role(['name'=>'Author']);
    $user->roles()->save($role);
});

Route::get('/read',function (){
    $user=User::findorFail(1);
    // dd($user);    //This will show the actual return which in this case is a collection
    foreach($user->roles as $role){
        // dd($role);
         echo $role->name . "<br>";
        // dd($role);
    }
});


Route::get('/update', function(){

    $user = User::findOrFail(1);

    if($user->has('roles')){

        foreach($user->roles as $role){

            if($role->name=='Administrator'){
                $role->name = 'subscriber';
                $role->save();
            }

        }
    }

});


// Route::get('/delete', function () {
//     $user=User::findOrFail(1);
//     $user->roles()->delete();
// });


// Delete specific role of a user
Route::get('/delete', function () {

    $user=User::findOrFail(1);

    foreach ($user->roles as $role) {
        $role->whereId(7)->delete();
    }

});

Route::get('/attach', function (){

    //This way you can create additional entry in the pivot

    $user = User::findOrFail(1);
    $user->roles()->attach(2);  //You are saving

});


Route::get('/detach',function () {

    $user = User::findOrFail(1);

    $user->roles()->detach(2);

    //if you use $user->roles()->detach(); with no index then it detach all

});

//detach all
// Route::get('/detach',function () {

//     $user = User::findOrFail(1);

//     $user->roles()->detach();

// });


Route::get('/sync', function () {
    $user = User::findOrFail(1);
    $user->roles()->sync([1,2,3]);

    // So it will sync the  data from role to the user with an array that. For example
    // you have a user id that has multiple roles id of 1,2,4,5
    // It will enter all the the data to the role_user with different types, if there is any
    // data that  entered with the following user id but not in the value of the sync array, it will be deleted.
    //if
});





