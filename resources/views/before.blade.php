@extends('layouts.app')

@section('content')
    <div style="height: 10vh">
        <button onclick="startChat(1)">Start chat with 1</button>
        <button onclick="startChat(2)">Start chat with 2</button>
    </div>

    <div class="content" id="messages" style="height: 80vh">
    </div>

    <div class="message-bar" style="height: 10vh; width: 100%">
        <input id="message" type="text" style="width: 100%">
        <button onclick="send()">Send!</button>
    </div>

    <script>
        let id = (id) => document.getElementById(id)
        let actualToken

        document.addEventListener('DOMContentLoaded', async (event) => {
            let messages = id('messages')

            let req = await axios.get('/me')
            let userId = req.data
            console.log(userId)
            
            window.Echo.join('chat.' + userId)
                .here((users) => {
                    console.log('aquests usuaris estan al chat ' + userId, users)
                })
                .listen('StartChat', (res) => {
                    console.log('Invitat a un nou xat', res)

                    window.Echo.join('chat-between.' + res.token)
                        .here((users) => {
                            console.log(`Acabo d'entrar a la sala ${res.token}`)
                            console.log(users)
                            actualToken = res.token
                        })
                        .listen('NewMessage', (message) => {
                            console.log('Missatge rebut!', message)
                            showMessage(message)
                        })
                })
        })

        async function startChat(id) {
            let res = await window.axios.get('/start-chat/' + id)
            let token = res.data.token
            actualToken = token
            console.log(token)
            window.Echo.join('chat-between.' + token)
                .here((users) => {
                    console.log(users)
                })
                .listen('NewMessage', (message) => {
                    showMessage(message)
                })
        }

        const send = () => {
            window.axios.post('/send', {
                message: id('message').value,
                token: actualToken
            })
        }

        const showMessage = (e) => {
            let p = document.createElement('p')
            let message = document.createTextNode(e.username + ': ' + e.message)
            p.appendChild(message)
            messages.appendChild(p)
            console.log(e);
        }
    </script>
@endsection
