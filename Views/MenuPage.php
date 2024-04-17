<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STAFF SITE</title>
    <link rel="stylesheet" href="../assets/css/staff.css">
    <script src="../utils/checkstaff.js"></script>
    <script src="../utils/logoutstaff.js"></script>
</head>

<body>
    <div class="outer-container">
        <div class="inner-container">
            <div class="container">
                <h2>Check-in</h2>
                <button id="checkinButton">Check-in</button>
            </div>

            <div class="container">
                <h2>Check-out</h2>
                <button id="checkoutButton">Check-out</button>
            </div>

            <div class="container">
                <h2>Logout</h2>
                <button onclick="Logout()">Logout</button>
            </div>

        </div>
        <div class="right-container">
            <h1>Staff Only</h1>
        </div>
        <div class="avatar-container">
            <div class="avatar"></div>
            <h3>Staff name</h3>
        </div>
    </div>

    <script>
        function handleCheckin(event) {
            event.preventDefault();
            var bearerToken = sessionStorage.getItem('token');
            var data = { token: bearerToken };
            fetch('../modules/func/checkin.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(result => {
                    if (result == true) {
                        alert('You have successfully checked in!');
                    } else if (result == false) {
                        alert('You checked in today!');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error: server');
                });
        }

        document.getElementById('checkinButton').addEventListener('click', function (event) {
            var isConfirmed = confirm('Are you sure you want to do CHECK-IN?');
            if (isConfirmed) {
                handleCheckin(event);
            }
        });

        function handleCheckOut(event) {
            event.preventDefault();
            var bearerToken = sessionStorage.getItem('token');
            var data = { token: bearerToken };
            fetch('../modules/func/checkout.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(result => {
                    if (result == true) {
                        alert('You have successfully checked out!');
                    } else if (result == false) {
                        alert('fail to checkout');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error: server');
                });
        }

        document.getElementById('checkoutButton').addEventListener('click', function (event) {
            var isConfirmed = confirm('Are you sure you want to do CHECK-OUT?');
            if (isConfirmed) {
                handleCheckOut(event);
            }
        });
    </script>

</body>

</html>