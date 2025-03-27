<?php
use App\Events\MessageEvent;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('chat', function () {
        // $contacts = User::all();
        $contacts = ChatRoom::with('users')->get();

        $messages = ChatRoom::find(1)->messages()->with('user')->latest()->take(20)->get();
        return view('chat.chat', compact('contacts', 'messages'));
    })->name('chat');
    // Route::get('getchatmessages/{chatId}', function ($chatId) {
    //     $messages = ChatRoom::find($chatId)->messages()->with('user')->latest()->take(20)->get();
    //     // $messages = ChatRoom::find(1)->messages()->with('user')->latest()->take(20)->get();
    //     return response()->json(["Id" => $messages]);
    // })->name('getmessages');
    Route::post('chatas', function (Request $request) {
        // return response()->json(["message" => "Gaidys"]);
        // dd(request()->input('message'));
        // return view('chat.chat');
        //Aktyvuoja įvykį ir gražina atsakymą
        // dd('gaidys');
        // Gauti pranešimo turinį
        $message    = request()->input('message');
        $sender     = auth()->user()->id;
        $receiverId = request()->input('chatOponent');
        // Išsiųsti įvykį su pranešimo turiniu
        // event(new MessageEvent($message . $userId));

        //Privati žinutė
        // broadcast(new MessageEvent($message, $sender, $receiverId))->toOthers();
        // broadcast(new MessageEvent($message, $sender, $receiverId));
        event(new MessageEvent($message, $sender, $receiverId));
        // Grąžinti atsakymą į klientą
        return response()->json(['success' => true, 'message' => $message]);

    })->name('chat.btn');

    Route::get('/messages/{room}', [ChatController::class, 'getMessages'])->name('get.messages');
    Route::post('/messages', [ChatController::class, 'sendMessage'])->name('send.message');
});

require __DIR__ . '/auth.php';
