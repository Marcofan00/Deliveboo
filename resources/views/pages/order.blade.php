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
        .contenitore_mail{
            width: 80%;
            margin: 0 auto;
            background-color: #009FB7;
            color: white;
            padding: 20px ;
            position: relative;
        }
        
        #ul_mail{
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column
        }
        .logo_mail{
            padding: 20px 0;
            width: 40%;
            margin: 0 auto;
            text-align: center
        }
        .li_mail{
            list-style: none;
            margin: 8px 0;
        }
        #ringraziamento{
            text-align: end;
            padding-right: 16px;
            margin-top: 64px;
        }
        #tot{
            flex-grow: 1
        }
        @media all and ( max-width:576px){
            .logo_mail{
                width: 100%;
            }
            .contenitore_mail{
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="logo_mail">
        <img src="{{asset('/storage/img/Logo.png')}}" alt="logo">
    </div>
    <div class="contenitore_mail">
        
        <h2>Mail di conferma per l ordine effettutato</h2>
    
        <ul id="ul_mail">
            <li class="li_mail">
                Ordine Inviato da : {{$order -> buyer_fullname}}
            </li>
    
            <li class="li_mail">
                Indirizzo : {{$order -> buyer_address}}
            </li>
    
            <li class="li_mail">
                Transazione : avventuta con successo !
            </li>
    
            <li class="li_mail" id="tot">
                Totale ordine : {{$order -> bill}} &euro;
            </li>

            <div id="ringraziamento">
                Lo staff di DeeBoo ti ringrazia , Buon appetito {{$order -> buyer_fullname}}
            </div>   
        </ul>
        
        
    </div>
    
    {{-- {{$order}} --}}
</body>
</html>

