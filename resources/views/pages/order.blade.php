<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Mail</title>
    <style>
        *{
            box-sizing: border-box;
        }
        .contenitore{
            width: 40%;
            height: 100vh;
            margin: 0 auto;
            background-color: #009FB7;
            color: white;
            padding: 20px ;
            position: relative;
        }
        
        ul{
            margin: 0;
            padding: 0;
        }
        .logo{
            padding: 20px 0;
            width: 40%;
            margin: 0 auto;
            text-align: center
        }
        li{
            list-style: none;
            margin: 8px 0;
        }
        #ringraziamento{
            position: absolute;
            bottom: 20px;
            right: 20px;
            font-size: .7rem;
        }
        @media all and ( max-width:576px){
            .logo{
                width: 100%;
            }
            .contenitore{
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="logo">
        <img src="{{asset('/storage/img/Logo.png')}}" alt="logo">
    </div>
    <div class="contenitore">
        
        <h2>Mail di conferma per l ordine effettutato</h2>
    
        <ul>
            <li>
                Ordine Inviato da : {{$order -> buyer_fullname}}
            </li>
    
            <li>
                Indirizzo : {{$order -> buyer_address}}
            </li>
    
            <li>
                Transazione : avventuta con successo !
            </li>
    
            <li>
                Totale ordine : {{$order -> bill}} &euro;
            </li>
        </ul>
        
        <div id="ringraziamento">
            Lo staff di DeeBoo ti ringrazia , Buon appetito {{$order -> buyer_fullname}}
        </div>    
    </div>
    
    {{-- {{$order}} --}}
</body>
</html>

