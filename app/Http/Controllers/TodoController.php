<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
Use Redirect;

use App\Models\TodoList;

/**
 * @group Todo management
 *
 * APIs for managing Todo
 */

class TodoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
     	$this->middleware('auth');
    }

    public function getUserTodo( $user_id = false ) {

    	if( !$user_id ) {
    		$user_id = Auth::user()->id;
    	}

    	return TodoList::select('id', 'user_id', 'todo_list', 'status')->where('user_id', $user_id)->groupBy('todo_list')->get();
    }

    public function editTodo(Request $request, $todo_id) {
        
        $todo = TodoList::findOrFail( $todo_id );

        return view('todo.edit', compact('todo') );
    }

        /**
    * Update Todo 
    * 
    * Update a tood
    *
    * @bodyParam  todo_id int required The id of the todo_ID. Example: 1
    *
    * @response {
    *  "todo_id": "1",
    * }
	*/

    public function updateTodo(Request $request, $todo_id) {

        try {

            $todo = TodoList::findOrFail( $todo_id );

            if( $todo === null ) {
                dd('Error: Invalid Todo id.');
            }

            $todo->status = $request->todo_status;
            $todo->save();

            return Redirect::route('dashboard')->with('success', 'Record has been updated successfully.');

            return back()->with('success','Record updated secessfully');

        }
        catch(\Exception $e) {
            return back()->with('error','Sorry! There was an error while updating the status.' . $e->getMessage()); // $e->getMessage()
        }

    }
}
