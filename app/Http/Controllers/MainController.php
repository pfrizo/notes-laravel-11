<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\Operations;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class MainController extends Controller
{
    public function index(){
        $id = session('user.id');
        $notes = User::find($id)->notes()->orderBy('id', 'desc')->get()->toArray();

        return view('home', ['notes' => $notes]);
    }

    public function newNote(){
        return view('new_note');
    }

    public function newNoteSubmit(Request $request){
        
        $request->validate([
            'text_title' => 'required|min:3|max:200',
            'text_note' => 'required|min:3|max:300'
        ]);

        $id = session('user.id');

        $note = new Note();
        $note->user_id = $id;
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        return redirect()->route('home');
    }

    public function editNote($id){
        $id = Operations::decryptId($id);
        
        echo "I'm editing note with id = $id";
    }

    public function deleteNote($id){
        $id = Operations::decryptId($id);

        echo "I'm deleting note with id = $id";
    }
}
