
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INVOICE</title>
    <style>
        /* Create three equal columns that floats next to each other */
        
        * {
            box-sizing: border-box!important;
            font-family: sans-serif!important;
        }
        
        .column {
            float: left;
            width: 33.33%;
            padding: 10px;
            
        }
        /* Clear floats after the columns */
        
        .row:after {
            content: "";
            display: table;
            clear: both;
        }
        
        table {
            border-collapse: collapse;
            width: 100%;
        }
        
        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        
        .total {
            margin-left: 35.7%;
        }
        
        .shipping {
            margin-left: 31.7%;
            ;
        }
        
        .subtotal {
            margin-left: 23.7%;
        }
        
        .address {
            margin-top: 6%;
        }
    </style>

</head>

<body>
    <div class="row">
        <div class="column">
            <div class="col-lg-4 col-lg-push-4">
                <img src="https://new.monowamart.com/public/uploads/all/16Sp0LG8Z040SXGqCzpUEhWEG8gdku20ytu6LKJm.png" alt="" height="50" style="display:inline-block;">
            </div>
        </div>
        <div class="column">
            <h3>INVOICE</h3>
        </div>
        <div class="column">
            <p>
                facebook.com/monowamart<br> monowamart.com
                <br> New Market City Complex Dhaka,Dhaka,1205
                <br> 01977765336
            </p>
        </div>
    </div>
    <div class="row">
        <div class="column">
        @php
            $shipping_address = json_decode($order->shipping_address);
        @endphp
            <p>
                {{ $shipping_address->name }} {{ $shipping_address->address }} {{ $shipping_address->city }}
                Mob:{{ $shipping_address->phone }}
            </p>
        </div>
        <div class="column">

            <div class="address"><b>Shipping Address</b></div>
            <p>{{ $shipping_address->address }} {{ $shipping_address->city }}
            </p>
        </div>
        <div class="column">
            <p>
                Invoice No: <b> <span class="invoice">1701965</span> </b> <br> Order Date: <span class="date">October 2,2021</span> <br> Payment Method: <span class="cash">Cash on Delivary</span>
            </p>
        </div>
    </div>
    <table>
     <thead>
        <tr>
            <th>NO</th>
            <th>SKU</th>
            <th>PRODUCT</th>
            <th>QTY</th>
            <th>UNIT PRICE</th>
            <th>TOTAL</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($order->orderDetails as $key => $orderDetail)
		 @if ($orderDetail->product != null)
        <tr>
            <td style="text-align: center;">
                1   
            </td>
            <td style="text-align: center;">
                {{ $order->code }}
            </td>
            <td>{{ $orderDetail->product->name }} @if($orderDetail->variation != null) ({{ $orderDetail->variation }}) @endif</td>
            <td style="text-align: center;">{{ $orderDetail->quantity }}</td>
            <td style="text-align: center;"> {{ single_price($orderDetail->price/$orderDetail->quantity) }}</td>
            <td style="text-align: center;">{{ single_price($orderDetail->price) }}</td>
        </tr>
         @endif
        @endforeach
    </tbody>
    </table>
    <div class="row">
        <div class="column">
            <div style="color: rgb(129, 125, 125);"><b> Quantity Total : {{ $orderDetail->quantity }}</b> </div><br>
            <div style="border: 1px solid black;padding: 3px;"><b>{{ single_price($order->grand_total) }}}/b> </div>
        </div>
        <div class="column">

        </div>
        <div class="column">
            <div><b>Subtotal:</b> <span class="subtotal"> {{ single_price($order->orderDetails->sum('price')) }}</span> </div>
            <div><b> Shipping:</b> <span class="shipping"> {{ single_price($order->orderDetails->sum('shipping_cost')) }} </span></div>
            <div><b>Total:</b> <span class="total">{{ single_price($order->grand_total) }}</span> </div>
        </div>
    </div>
    <p style="text-align: center;">Thank you For Shopping With us! Enjoy Shopping @www.monowamart.com</p>
    <p>Prepared by:Name</p>
    
</body>

</html>