<div>
    {{-- In work, do what you enjoy. --}}
    <h1>Livewire component</h1>
    <div class="contact-profile">
        <img src="{{asset('assets/6897018.png')}}" alt="" />
        <p>{{$chatName}}</p>
        {{-- <div class="social-media">
            <input type="text" name="chatOpnent" id="chatOpnent">
        </div> --}}
    </div>
    <div class="messages mb-2 w-full">
        <ul id="chat-box" class="border p-4 h-[500px] overflow-y-auto bg-gray-300">
            {{-- <div>{{ json_encode($messages) }}</div> --}}
            @foreach ($messages as $message)
                        <li @class([
                            'sent' => $message['user_id'] === auth()->id(),
                            'replies' => $message['user_id'] !==
                                auth()->id()
                        ])>

                            <div class="message">
                                <div class="">
                                    <p class="userName">{{$message['user']['name']}}</p>
                                    <p>...{{$message['message'] }}</p>

                                </div>
                                <small>{{ $message['created_at'] }}</small>
                            </div>


                        </li>
            @endforeach
        </ul>
    </div>
</div>