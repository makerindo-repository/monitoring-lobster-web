<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    debug mode
    <script>
        const BASE_URL = "{{ url('/') }}";
        
        let temperature = [
            30, 31, 32, 33, 34
        ];
        let humidity = [
            60, 61, 62, 63, 64, 65, 66, 67, 68
        ];
        let ph = [
            6, 7, 8, 9, 10, 11, 12, 13
        ];
        let cod = [
            70, 80, 85, 90, 95
        ];
        let ammonia = [
            3,4,5,6,7,8
        ];
        let tss = [
            140, 141, 142, 143, 145, 146, 147
        ];
        let debit = [
            650, 600, 690, 700
        ];

        setInterval(() => {
            fetch(`${BASE_URL}/api/telemetry`, {
                headers: {
                 'Content-Type': 'application/json'
                },
                method: "POST", 
                body: JSON.stringify(
                {
                    "iot_node_id": "ED010122011NODE001",	
                    "temperature_node": temperature[Math.floor(Math.random() * temperature.length)],
                    "temperature_edge" : temperature[Math.floor(Math.random() * temperature.length)],
                    "humidity_node" : humidity[Math.floor(Math.random() * humidity.length)],
                    "humidity_edge": humidity[Math.floor(Math.random() * humidity.length)],
                    "ph": ph[Math.floor(Math.random() * ph.length)],
                    "cod": cod[Math.floor(Math.random() * cod.length)],
                    "ammonia": ammonia[Math.floor(Math.random() * ammonia.length)],
                    "tss": tss[Math.floor(Math.random() * tss.length)],
                    "debit": debit[Math.floor(Math.random() * debit.length)]
                }
            )}).then(r => r ? r.json() : r)
               .then(r => {
                   console.log(r)
               })
               .catch(err => {
                   console.warn(err)
               })

        }, 5000);

    </script>
</body>
</html>