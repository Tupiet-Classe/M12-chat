@extends('layouts.app')

@section('content')
    <div class="content" id="messages" style="height: 90vh">
    </div>

    <div class="message-bar" style="height: 10vh; width: 100%">
        <input id="message" type="text" style="width: 100%">
        <button onclick="send()">Send!</button>
    </div>

    <script>
        let id = (id) => document.getElementById(id)

        document.addEventListener('DOMContentLoaded', async (event) => {
            let messages = id('messages')

            

            window.Echo.join('chat.' + 1 +'.'+2)
            .listen('NewMessage', (e) => {
                let p = document.createElement('p')
                let message = document.createTextNode(e.message)
                p.appendChild(message)
                messages.appendChild(p)
                console.log(e);
            })
            .here((users) => {
                console.log('hola', users)
            })
            .joining((user) => {
                console.log('joining', user.name)
            })
            .leaving((user) => {
                console.log('leaving', user.name)
            })
            .whisper('typing', {
                name: 'name'
            })
            .listenForWhisper('typing', (e) => {
                console.log(e.name);
            })
        })
        const send = () => {
            window.axios.post('/send', {
                message: id('message').value,
                token: 3
            })
        }
    </script>
@endsection
