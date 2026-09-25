<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Chatbot in PHP</title>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f2f2f2;
        }

        .wrapper {
            width: 700px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .wrapper .title {
            background: #007bff;
            color: white;
            font-size: 20px;
            text-align: center;
            padding: 15px;
            border-radius: 10px 10px 0 0;
        }

        .wrapper .form {
            max-height: 600px;
            overflow-y: auto;
            padding: 20px;
        }

        .wrapper .form .inbox {
            display: flex;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .wrapper .form .inbox .icon {
            width: 40px;
            height: 40px;
            background: #007bff;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            margin-right: 10px;
        }

        .wrapper .form .inbox .msg-header {
            max-width: 300px;
            background: #eaeaea;
            padding: 10px;
            border-radius: 10px;
            font-size: 14px;
            word-wrap: break-word;
        }

        .wrapper .form .user-inbox {
            display: flex;
            align-items: flex-start;
            justify-content: flex-end;
            /* Menempatkan chat di sisi kanan */
            margin-bottom: 10px;
        }

        .wrapper .form .user-inbox .icon {
            order: 2;
            /* Pindahkan icon ke sisi kanan */
            margin-left: 10px;
            /* Beri jarak antara pesan dan icon */
            margin-right: 0;
        }

        .wrapper .form .user-inbox .msg-header {
            background: #007bff;
            color: white;
            border-radius: 10px;
            max-width: 300px;
            padding: 10px;
            word-wrap: break-word;
            text-align: right;
            /* Menyelaraskan teks ke kanan */
        }

        .wrapper .typing-field {
            padding: 15px;
            background: #efefef;
            border-top: 1px solid #ddd;
            border-radius: 0 0 10px 10px;
        }

        .wrapper .typing-field .input-data {
            display: flex;
            justify-content: space-between;
        }

        .wrapper .typing-field .input-data input {
            width: 80%;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            outline: none;
        }

        .wrapper .typing-field .input-data button {
            width: 15%;
            background: #007bff;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .wrapper .typing-field .input-data button:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <a href="{{ route('dashboard') }}"> &lt; Kembali</a>
        <div class="title">Simple Online Chatbot</div>
        <div class="form">
            <div class="bot-inbox inbox">
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="msg-header">
                    <p>Halo saya adalah chatbot. Tanyakan tentang manajemen keuangan kepada saya!
                    </p>
                </div>
            </div>
        </div>
        <div class="typing-field">
            <div class="input-data">
                <input id="data" type="text" name="replies" placeholder="Type something here.." required>
                <button id="send-btn">Send</button>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#send-btn").on("click", function() {
                $value = $("#data").val();
                $msg = '<div class="user-inbox inbox"><div class="msg-header"><p>' + $value +
                    '</p></div></div>';
                $(".form").append($msg);
                $("#data").val('');

                // start ajax code
                $.ajax({
                    url: '{{ route('bot.post') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        'text': $value
                    },
                    success: function(result) {
                        $reply =
                            '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-user"></i></div><div class="msg-header"><p>' +
                            result.message + '</p></div></div>';
                        $(".form").append($reply);
                        // when chat goes down the scroll bar automatically comes to the bottom
                        $(".form").scrollTop($(".form")[0].scrollHeight);
                    }
                });
            });
        });
    </script>
</body>

</html>
