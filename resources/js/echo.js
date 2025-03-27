import Echo from "laravel-echo";

import Pusher from "pusher-js";
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: "reverb",
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT,
    wssPort: import.meta.env.VITE_REVERB_PORT,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? "https") === "https",
    enabledTransports: ["ws", "wss"],
});

// Klausomės "chat" kanalo
// window.Echo.channel("chat").listen(".send-message", (event) => {
//     // alert("Gaidys");
//     console.log("Gauta žinutė:", event.message);
//     let chatBox = document.getElementById("chat-box");
//     let newMessage = document.createElement("div");
//     newMessage.textContent = event.message;
//     chatBox.appendChild(newMessage);
// });

// Gauname prisijungusio vartotojo ID iš meta tag'o
// const userId = document.querySelector('meta[name="user-id"]').content;

// Gauname userId iš globalaus JS objekto
// const userId = window.userId;
// // const chatId = window.chatId;
// const chatId = document.querySelector('meta[name="contact-id"]').content;
// // const chatId = 2;
// console.log("userId:", userId, "echoCatId:", chatId);
// // Klausomės savo asmeninio kanalo (gavėjo)
// window.Echo.private(`chat.${chatId}`).listen(".send-message", (data) => {
//     console.log("Gauta privati žinutė:", "data.message");

//     // let chatBox = document.getElementById("chat-box");
//     // if (!chatBox) return; // Jei nėra chat-box, sustabdyti funkciją

//     // let newMessageLi = document.createElement("li");

//     // // Pridedame klasę priklausomai nuo siuntėjo
//     // if (data.user_id === userId) {
//     //     newMessageLi.classList.add("replies");
//     // } else {
//     //     newMessageLi.classList.add("sent");
//     // }

//     // let newMessageName = document.createElement("p");
//     // newMessageName.textContent = data.message.user_id;
//     // newMessageLi.appendChild(newMessageName);

//     // let newMessageMessage = document.createElement("p");
//     // newMessageMessage.textContent = data.message.message;
//     // newMessageLi.appendChild(newMessageMessage);

//     // chatBox.appendChild(newMessageLi);

//     // // Automatinis slinkimas į apačią
//     // chatBox.scrollTop = chatBox.scrollHeight;
// });

let currentChatId = window.chatId || null; // Saugome esamą chatId
let chatChannel = window.Echo.private(`chat.${currentChatId}`);
window.updateChatListener = (newChatId) => {
    if (currentChatId !== newChatId) {
        // Paliekame seną kanalą
        window.Echo.leave(`chat.${currentChatId}`);

        // Atnaujiname ID
        currentChatId = newChatId;

        // Prisijungiame prie naujo kanalo
        chatChannel = window.Echo.private(`chat.${currentChatId}`);

        chatChannel.listen(".send-message", (data) => {
            console.log("Gauta privati žinutė:", data.message);
            if (typeof Livewire !== "undefined") {
                console.log("Livewire įkeltas:", Livewire);
                Livewire.dispatch("addMessage", { message: data.message }); // Siunčiame duomenis į Livewire
            } else {
                console.error("Livewire nėra įkeltas!");
            }
        });
        console.log(`🔄 Pakeistas kanalas į: chat.${currentChatId}`);
    }
};

// setTimeout(() => {
//     window.updateChatListener(currentChatId); // Pvz., perjungiame į kitą pokalbį
// }, 5000);

window.Echo.join("online")
    .here((users) => {
        // console.log(users);
        const usersInRoms = document.querySelectorAll(".onlineUser");
        usersInRoms.forEach((user) => {
            // console.log(user);
            const userId = parseInt(user.getAttribute("userId"), 10);
            if (users.some((u) => u.id === userId)) {
                const previousElement = user.previousElementSibling; // Gauna prieš tai esantį elementą
                // console.log(previousElement);
                previousElement.classList.add("online");
            }
        });
        // console.log(usersInRoms);
        // document.getElementById(
    })
    .joining((user) => {
        // console.log(user.name + " joined to chat");
        const users = document.querySelectorAll(`.user${user.id}`);
        users.forEach((user) => {
            user.classList.add("online");
        });
        // document.getElementById(
        //     "messages"
        // ).innerHTML += `<p>${user.name} joint online</p>`;
    })
    .leaving((user) => {
        // console.log(user.name + " leaved chat");
        const users = document.querySelectorAll(`.user${user.id}`);
        users.forEach((user) => {
            user.classList.remove("online");
        });
    });
