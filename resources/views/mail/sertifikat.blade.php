<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Event</title>
    <style>
        /* Tambahkan CSS Anda di sini atau gunakan file CSS terpisah */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: justify;
        }
        .text-center {
            text-align: center;
        }
        h1, h2, p {
            margin: 0 0 10px;
        }
        h1 {
            color: #333333;
        }
        .details, .agenda, .contact {
            margin: 20px 0;
        }
        .details p, .agenda p, .contact p {
            margin: 5px 0;
        }
        .footer {
            text-align: center;
            margin: 20px 0 0;
            color: #666666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="text-center">
            {{-- <h1>Sertifikat Event {{ ucwords($sendEmail['title']) }}</h1> --}}
        </div>
        <p>Halo {{ ucwords($sendEmail['name']) }},</p>
        <p>Terima kasih telah mendaftar untuk acara <strong>{{ ucwords($sendEmail['title']) }}</strong>! Kami dengan senang hati mengonfirmasi bahwa pendaftaran Anda telah berhasil diterima. Berikut adalah detail acara yang perlu Anda ketahui:</p>

        <div class="details">
            <h2>Data Peserta:</h2>
            <p><strong>Nama:</strong> {{ ucwords($sendEmail['name']) }}</p>
            <p><strong>Prodi:</strong> {{ ucwords($sendEmail['prodi']) }}</p>
            <p><strong>Email:</strong> {{ $sendEmail['email'] }}</p>
            <p><strong>Nomor Telepon:</strong> {{ $sendEmail['phone'] }}</p>
            <p><strong>Nomor Pendaftaran:</strong> {{ $sendEmail['code'] }}</p>
        </div>

        <p>Kami sangat mengharapkan kehadiran Anda di acara ini. Jangan lupa membawa salinan email ini atau menunjukkan nomor pendaftaran/kode QR Anda pada saat registrasi ulang di lokasi acara.</p>
        <p>Terima kasih dan sampai jumpa di acara!</p>
        <p>Salam hangat,</p>
        {{-- <p>Panitia {{ ucwords($sendEmail['title']) }}</p> --}}
        <div class="footer">
            <p>&copy; 2024 App Meom. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
