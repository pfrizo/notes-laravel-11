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
        //$notes = User::find($id)->notes()->whereNull('deleted_at')->orderBy('updated_at', 'desc')->get()->toArray();
        $notes = User::find($id)->notes()->orderBy('updated_at', 'desc')->get()->toArray();

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

        if($id === null){
            return redirect()->route('home');
        }
        
        $note = Note::find($id);

        return view('edit_note', ['note' => $note]);
    }

    public function editNoteSubmit(Request $request){
        $request->validate([
            'text_title' => 'required|min:3|max:200',
            'text_note' => 'required|min:3|max:300'
        ]);

        if($request->note_id == null){
            return redirect()->route('home');
        }

        $id = Operations::decryptId($request->note_id);

        if($id === null){
            return redirect()->route('home');
        }

        $note = Note::find($id);

        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        return redirect()->route('home');
    }

    public function deleteNote($id){
        $id = Operations::decryptId($id);

        if($id === null){
            return redirect()->route('home');
        }

        $note = Note::find($id);

        return view('delete_note', ['note' => $note]);
    }

    public function deleteNoteConfirm($id){
        
        $id = Operations::decryptId($id);

        if($id === null){
            return redirect()->route('home');
        }

        $note = Note::find($id);

        //Hard delete
        //$note->delete();

        //soft delete (add whereNull('deleted_at') in index query)
        //$note->deleted_at = date('Y:m:d H:i:s');
        //$note->save();

        //hard delete (property in model)
        //$note->forceDelete();

        //soft delete (property in model)
        $note->delete();

        return redirect()->route('home');
    }
}
