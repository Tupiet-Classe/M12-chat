@extends('layouts.app')

@section('content')
    <div style="height: 100vh">
        <button onclick="startChat(1)">Start chat with 1</button>
        <button onclick="startChat(2)">Start chat with 2</button>
    </div>

    <script>
        let id = (id) => document.getElementById(id)

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
                    console.log(res)

                    window.Echo.join('chat-between.' + token.token)
                        .here((users) => {
                            console.log(users)
                        })
                })
        })

        async function startChat(id) {
            let res = await window.axios.get('/start-chat/' + id)
            let token = res.data.token
            console.log(token)
            window.Echo.join('chat-between.' + token)
                .here((users) => {
                    console.log(users)
                })
        }
    </script>
@endsection
