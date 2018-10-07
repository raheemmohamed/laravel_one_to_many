<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//define a model globally
use App\Role;
use App\User;

Route::get('/', function () {
    return view('welcome');
});

//Inserting Many to many realtionship
Route::get('/insertmanytomany',function(){
    $user = User::findOrFail(1);

    $role = new Role(['name'=>'Administrator']);

    $user->roles()->save($role);

});

//read data many to many relationship
Route::get('/readmanytomany',function (){

   $user = User::find(1);

   foreach($user->roles as $role){
      echo  $role->name;
      echo "  =  ";
      echo $user->name;

   }

});

//update many to many relationship
Route::get('/updatemanytomany',function(){
    //find the user in user table
    $user = User::find(1);
    //check condition this user has any {roles}= this is define on usermodel as method ->true
    if($user->has('roles')){
        //loop it the roles table records
        foreach($user->roles as $role){
            //check the role table name coloumn is == Administrator
            if($role->name =='Administrator'){
                //then change role table name column value as = Subcriber
                $role->name = 'subcriber';
                //then role table with save method
                $role->save();
            }
        }
    }
});

//delete All Many to Many relationship records ::method 1
Route::get('/deletemanytomany', function (){
   $user = User::findOrFail(1);
   $user->roles()->delete();
});

//delete Many to Many relationship records:method 2
Route::get('/deletewithwhereclause',function (){
    $user = User::find(1);
    foreach($user->roles as $role){
        $role->where('id',5)->delete();
    }
});


//many to many relationship attached method
/* what attached did is find the particular user with
attached it to pivot table which is related Role_user table
*/
Route::get('/attached', function (){
    $user = User::find(1);
    $user->roles()->attach(7);
});

//detach with Many to many relationship
/* what detach does is find the particular user with
remove the particular given role id with particular row in role_user table
*/
Route::get('/detach',function(){
    $user = User::findOrFail(1);
    $user->roles()->detach([4,5]);
});

//Sync with Many to Many relationship
/* what sync using do is where any users with particular
role in id in pivot role_user table which is updating*/
Route::get('/sync',function(){
    $user = User::findOrFail(1);
    $user->roles()->sync([6]);
});