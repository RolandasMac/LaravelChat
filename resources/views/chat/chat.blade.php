<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
            <x-primary-button id="spausti" class="bg-green-500 spaustibtn">
                Spausti
            </x-primary-button>
        </h2> --}}
        {{-- <div id="chat-box" class="border p-4 h-64 overflow-y-auto bg-gray-100">
            <!-- Čia bus rodomos žinutės -->
            <h1>Chat's</h1>
        </div> --}}
    </x-slot>
    @push('styles')
        @vite(['resources/css/style.css']) <!-- Dinamiškai įtraukiamas style.css -->
    @endpush
    <div id="frame" class="mb-4 w-full">
        <div id="sidepanel">
            <div id="profile">
                <div class="wrap">
                    <div class="">
                        <div class="h-[30px] w-[30px] overflow-hidden rounded-full float-left ">
                            <img id="profile-img" src="{{asset('assets/6897018.png')}}"
                                class="online h-full w-full object-cover" alt="" />
                        </div>
                        <p>{{ auth()->user()->name }}</p>
                        <i class="fa fa-chevron-down expand-button" aria-hidden="true"></i>
                        <div id="status-options">
                            <ul>
                                <li id="status-online" class="active"><span class="status-circle">Gaidys</span>
                                    <p>Online</p>
                                </li>
                                <li id="status-away"><span class="status-circle"></span>
                                    <p>Away</p>
                                </li>
                                <li id="status-busy"><span class="status-circle"></span>
                                    <p>Busy</p>
                                </li>
                                <li id="status-offline"><span class="status-circle"></span>
                                    <p>Offline</p>
                                </li>
                            </ul>
                        </div>
                    </div>




                </div>
            </div>
            <div id="contacts">
                <ul>
                    @foreach ($contacts as $contact)
                        <li class="contact" id="{{ $contact->id }}">
                            <div class="wrap">
                                {{-- <span class="contact-status online"></span> --}}
                                <img src="{{asset('assets/6897018.png')}}" alt="" />
                                <div class="meta">
                                    <p class="name chatName">{{ $contact->name }}</p>
                                    {{-- <p class="preview">You just got LITT up, Mike.</p> --}}

                                    @foreach ($contact->users as $user)
                                        @if ($user->id !== auth()->id())
                                            <div class="username">
                                                <span class="user{{$user->id}}"></span>
                                                <p class="preview onlineUser" userId="{{$user->id}}">{{ $user->name }}.</p>
                                            </div>

                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </li>
                    @endforeach

                    {{-- <li class="contact active">
                        <div class="wrap">
                            <span class="contact-status busy"></span>
                            <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
                            <div class="meta">
                                <p class="name">Harvey Specter</p>
                                <p class="preview">Wrong. You take the gun, or you pull out a bigger one. Or, you call
                                    their bluff. Or, you do any one of a hundred and forty six other things.</p>
                            </div>
                        </div>
                    </li> --}}
                </ul>
            </div>
        </div>
        <div class="content w-200 pb-5">


            @livewire('chat-messages', ['messages' => $messages])
            {{-- <div class="messages mb-2 w-full">

                <ul id="chat-box">
                    @foreach ($messages as $message)
                    <li @class(['sent'=> $message->user_id === auth()->id(), 'replies' => $message->user_id !==
                        auth()->id()])>
                        <p>{{$message->user->name}}</p>

                        <p>{{$message->message . " " . $message->user_id . " " . auth()->id()}}</p>
                    </li>
                    @endforeach
                </ul> --}}


                {{-- <ul>
                    <li class="sent">
                        <img src="http://emilcarlsson.se/assets/mikeross.png" alt="" />
                        <p>How the hell am I supposed to get a jury to believe you when I am not even sure that I
                            do?!
                        </p>
                    </li>
                    <li class="replies">
                        <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
                        <p>When you're backed against the wall, break the god damn thing down.</p>
                    </li>
                    <li class="replies">
                        <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
                        <p>Excuses don't win championships.</p>
                    </li>
                    <li class="sent">
                        <img src="http://emilcarlsson.se/assets/mikeross.png" alt="" />
                        <p>Oh yeah, did Michael Jordan tell you that?</p>
                    </li>
                    <li class="replies">
                        <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
                        <p>No, I told him that.</p>
                    </li>
                    <li class="replies">
                        <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
                        <p>What are your choices when someone puts a gun to your head?</p>
                    </li>
                    <li class="sent">
                        <img src="http://emilcarlsson.se/assets/mikeross.png" alt="" />
                        <p>What are you talking about? You do what they say or they shoot you.</p>
                    </li>
                    <li class="replies">
                        <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
                        <p>Wrong. You take the gun, or you pull out a bigger one. Or, you call their bluff. Or, you
                            do
                            any one of a hundred and forty six other things.</p>
                    </li>
                </ul> --}}
                {{--
            </div> --}}
            <form id="chat-form" method="POST" class="message-input ">
                @csrf
                {{-- <div class=""> --}}
                    <div class="wrap flex justify-between align-baseline">
                        <input type="hidden" name="userId" value="{{ auth()->id() }}">
                        <input type="text" placeholder="Write your message..." name="message" class="grow rounded" />
                        <button type="submit" class=" rounded"><i class="fa fa-paper-plane"
                                aria-hidden="false"></i></button>
                    </div>
                    {{--
                </div> --}}
            </form>

        </div>
    </div>
    @livewireScripts <!-- Livewire JS turi būti įtrauktas čia! -->
    <script>
        // console.log("Livewire:", Livewire);
        window.userId = @json(auth()->user()->id);
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("chat-form");
            form.addEventListener("submit", function (event) {
                event.preventDefault();
                const chatRoomId = window.chatId;
                let formData = new FormData(form);
                if (chatRoomId !== null && chatRoomId !== undefined) {
                    formData.append('chat_room_id', chatRoomId);
                    fetch("{{ route('send.message') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                        },
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // console.log(data)
                                // Pridedame naują žinutę į sąrašą (pvz., po forma)


                                // let chatBox = document.getElementById("chat-box");
                                // if (!chatBox) return; // Jei nėra chat-box, sustabdyti funkciją

                                // let newMessageLi = document.createElement("li");

                                // // Pridedame klasę priklausomai nuo siuntėjo
                                // if (data.user_id === userId) {
                                //     newMessageLi.classList.add("replies");
                                // } else {
                                //     newMessageLi.classList.add("sent");
                                // }

                                // let newMessageName = document.createElement("p");
                                // newMessageName.textContent = data.user_id;
                                // newMessageLi.appendChild(newMessageName);

                                // let newMessageMessage = document.createElement("p");
                                // newMessageMessage.textContent = data.message;
                                // newMessageLi.appendChild(newMessageMessage);

                                // chatBox.appendChild(newMessageLi);

                                // Automatinis slinkimas į apačią
                                // chatBox.scrollTop = chatBox.scrollTop;
                                form.reset();
                            } else {
                                console.log(data)
                                // alert("Klaida: " + data.error);
                            }
                        })
                        .catch(error => console.error("Klaida:", error));
                } else {
                    alert("Pasirinkite pokalbių kanalą")
                }

            });
            const contacts = document.querySelectorAll(".contact");
            contacts.forEach(element => {
                element.addEventListener("click", function (event) {
                    event.preventDefault(); // Neleidžiame perkrauti puslapio
                    event.stopPropagation();
                    // Pasirenkame <meta> elementą
                    const metaTag = document.querySelector('meta[name="contact-id"]');
                    // Pakeičiame "content" reikšmę
                    metaTag.setAttribute("content", event.currentTarget.id);
                    // Patikriname, ar pakeista
                    const chatId = metaTag.getAttribute("content");
                    window.chatId = event.currentTarget.id;
                    window.updateChatListener(chatId);
                    Livewire.dispatch("setContact", { contact: event.currentTarget.querySelector('.chatName').textContent }); // Siunčiame duomenis į Livewire($contact)
                    // console.log(event.currentTarget.querySelector('.chatName').textContent);
                    // const url = `{{ route('get.messages', ['room' => '__room__']) }}`.replace('__room__', chatId);
                    // const url = "http://localhost:8000/messages/2"
                    const url = `http://localhost:8000/messages/${chatId}`
                    fetch(url, {
                        method: "GET",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                        },
                    })
                        .then(response => response.json())
                        .then(
                            (data) => {
                                if (typeof Livewire !== "undefined") {

                                    Livewire.dispatch("updateMessages", { newMessages: data }); // Siunčiame duomenis į Livewire
                                } else {
                                    console.error("Livewire nėra įkeltas!");
                                }
                            }
                        )
                        .catch(error => console.error("Klaida:", error));
                });
            });

        });

    </script>
</x-app-layout>