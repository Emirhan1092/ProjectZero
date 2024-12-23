<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }

        h2 {
            color: #333;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        p {
            font-size: 16px;
            margin: 5px 0;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin: 5px 0;
            font-size: 16px;
        }

        img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 10px 0;
        }

        .image-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .image-container img {
            max-width: 200px;
            height: auto;
            object-fit: cover;
        }

        .part-info, .customer-info, .insurer-info {
            margin-bottom: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .part-info h3, .customer-info h3, .insurer-info h3 {
            margin-bottom: 10px;
            font-size: 18px;
            color: #555;
        }

        .part-info img {
            max-width: 200px;
            height: auto;
            object-fit: cover;
        }

        .info-list {
            margin: 10px 0;
        }
    </style>
</head>
<body>
@foreach ($data as $item)
    @php
        $itemsSavedByName = $item['saved_by_name'] ?? 'Unknown';
        $itemsSavedById = $item['saved_by_id'] ?? 'Unknown';
        $files = $item['files'] ?? [];
        $part_info = $item['part_info'] ?? [];
        $customer_informations = $item['customer_informations'] ?? [];
        $insurer_informations = $item['insurer_informations'] ?? [];
    @endphp

    <h2>Saved by: {{ $itemsSavedByName }}</h2>
    <p><strong>Saved By ID:</strong> {{ $itemsSavedById }}</p>

    <div class="image-container">
        @foreach ($files as $file)
            <div>
                <h4>{{ $file['file_name'] }}</h4>
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/customer/' . $file['file']))) }}" alt="{{ $file['file_name'] }}">
            </div>
        @endforeach
    </div>

    <div class="part-info">
        <h3>Part Information</h3>
        <ul>
            @foreach ($part_info as $part)
                <li>
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents('https:'.$part['car_img'])) }}" alt="Part Image">
                    <p><strong>Model:</strong> {{ $part['model_name'] }}</p>
                    <p><strong>Brand:</strong> {{ $part['brand_name'] }}</p>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="customer-info">
        <h3>Customer Information</h3>
        <ul>
            @foreach ($customer_informations as $customer_information)
                <li><strong>Name:</strong> {{ $customer_information['customer_name'] }}</li>
                <li><strong>Phone Number:</strong> {{ $customer_information['customer_phone_number'] }}</li>
            @endforeach
        </ul>
    </div>

    <div class="insurer-info">
        <h3>Insurer Information</h3>
        <ul>
            @foreach ($insurer_informations as $insurer_information)
                <li><strong>Insurer Name:</strong> {{ $insurer_information['insurer_name'] }}</li>
                <li><strong>Address:</strong> {{ $insurer_information['insurer_address'] }}</li>
                <li><strong>Email:</strong> {{ $insurer_information['insurer_email'] }}</li>
            @endforeach
        </ul>
    </div>
@endforeach
</body>
</html>
